<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use App\Services\FirebaseService;
use App\Models\User;
use Illuminate\Http\Request;

class GoodsReceiptReportController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Daftar seluruh laporan penerimaan barang.
     */
    public function index(Request $request)
    {
        $query = GoodsReceipt::with(['purchaseOrder.vendor', 'purchaseOrder.tender', 'purchaseOrder.items', 'creator'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status_penerimaan', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('purchaseOrder', function ($q) use ($search) {
                $q->where('kode_po', 'like', "%{$search}%")
                  ->orWhereHas('vendor', fn ($q2) => $q2->where('nama_vendor', 'like', "%{$search}%"));
            });
        }

        $receipts = $query->paginate(15)->withQueryString();

        $stats = [
            'total'                   => GoodsReceipt::count(),
            'diterima_sesuai'         => GoodsReceipt::where('status_penerimaan', 'diterima_sesuai')->count(),
            'bermasalah'              => GoodsReceipt::whereIn('status_penerimaan', ['menunggu_tindak_lanjut', 'retur_barang', 'penggantian_vendor'])->count(),
            'menunggu_tindak_lanjut'  => GoodsReceipt::where('status_penerimaan', 'menunggu_tindak_lanjut')->count(),
        ];

        return view('supply-chain.goods-receipt-reports.index', compact('receipts', 'stats'));
    }

    /**
     * Detail laporan penerimaan barang.
     */
    public function show(GoodsReceipt $goodsReceiptReport)
    {
        $goodsReceiptReport->load([
            'purchaseOrder.vendor',
            'purchaseOrder.tender.materialRequest.project',
            'purchaseOrder.items',
            'photos',
            'creator',
        ]);

        return view('supply-chain.goods-receipt-reports.show', compact('goodsReceiptReport'));
    }

    /**
     * Konfirmasi penyelesaian — update status ke selesai.
     */
    public function confirm(GoodsReceipt $goodsReceiptReport)
    {
        $goodsReceiptReport->update(['status_penerimaan' => 'diterima_sesuai']);
        $goodsReceiptReport->purchaseOrder->update(['status' => 'selesai']);

        return redirect()
            ->route('supply-chain.goods-receipt-reports.show', $goodsReceiptReport->id)
            ->with('success', 'Laporan penerimaan dikonfirmasi sebagai selesai.');
    }

    /**
     * Proses retur barang.
     */
    public function processReturn(GoodsReceipt $goodsReceiptReport)
    {
        $goodsReceiptReport->update(['status_penerimaan' => 'retur_barang']);
        $goodsReceiptReport->purchaseOrder->update(['status' => 'retur']);

        // Notify gudang user
        $gudangUsers = User::where('role', 'gudang')->whereNotNull('fcm_token')->get();
        $po = $goodsReceiptReport->purchaseOrder;
        foreach ($gudangUsers as $user) {
            try {
                $this->firebase->sendNotification(
                    $user->fcm_token,
                    '🔄 Proses Retur — ' . $po->kode_po,
                    "Supply Chain memproses retur untuk PO {$po->kode_po}. Siapkan barang untuk dikembalikan ke vendor."
                );
            } catch (\Throwable $e) {
                logger()->error("Firebase notify failed for user {$user->id}: " . $e->getMessage());
            }
        }

        return redirect()
            ->route('supply-chain.goods-receipt-reports.show', $goodsReceiptReport->id)
            ->with('success', 'Proses retur barang telah dimulai.');
    }
}
