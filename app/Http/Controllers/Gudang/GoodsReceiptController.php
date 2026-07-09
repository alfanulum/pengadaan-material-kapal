<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptPhoto;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GoodsReceiptController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Daftar seluruh PO yang perlu/sudah diperiksa gudang.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['vendor', 'tender', 'items', 'goodsReceipt'])
            ->whereIn('status', ['dikirim', 'diterima_gudang', 'selesai'])
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('gudang.goods-receipts.index', compact('purchaseOrders'));
    }

    /**
     * Form pemeriksaan penerimaan barang untuk PO tertentu.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['vendor', 'tender.materialRequest.project', 'items', 'goodsReceipt.photos']);

        return view('gudang.goods-receipts.show', compact('purchaseOrder'));
    }

    /**
     * Simpan laporan penerimaan barang (goods receipt).
     */
    public function store(Request $request, PurchaseOrder $purchaseOrder)
    {
        $request->validate([
            'tanggal_diterima'    => 'required|date',
            'jumlah_diterima'     => 'required|integer|min:0',
            'kondisi_barang'      => 'required|in:sesuai,diterima_dengan_catatan,kerusakan,tidak_sesuai_spesifikasi',
            'catatan_gudang'      => 'nullable|string|max:2000',
            'detail_permasalahan' => 'nullable|string|max:2000',
            'jumlah_rusak'        => 'nullable|integer|min:0',
            'tindakan_selanjutnya'=> 'nullable|in:terima_dengan_catatan,minta_penggantian,retur_sebagian,tolak_barang',
            'foto'                => 'nullable|array|max:10',
            'foto.*'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'keterangan_foto.*'   => 'nullable|string|max:255',
        ], [
            'foto.max' => 'Maksimal upload 10 gambar.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.mimes' => 'Format gambar tidak didukung. Gunakan JPG, PNG, atau WEBP.',
            'foto.*.max' => 'Ukuran gambar maksimal 5 MB per file.',
        ]);

        // Tentukan status penerimaan
        $kondisi = $request->kondisi_barang;
        $tindakan = $request->tindakan_selanjutnya;

        $statusPenerimaan = match (true) {
            $kondisi === 'sesuai'                                     => 'diterima_sesuai',
            $kondisi === 'diterima_dengan_catatan' && !$tindakan      => 'diterima_dengan_catatan',
            $tindakan === 'retur_sebagian' || $tindakan === 'tolak_barang' => 'retur_barang',
            $tindakan === 'minta_penggantian'                         => 'penggantian_vendor',
            $tindakan === 'terima_dengan_catatan'                     => 'diterima_dengan_catatan',
            default                                                   => 'menunggu_tindak_lanjut',
        };

        $receipt = DB::transaction(function () use ($request, $purchaseOrder, $statusPenerimaan) {
            // Hapus laporan lama jika ada (update)
            $purchaseOrder->goodsReceipt?->photos()->each(function ($photo) {
                Storage::disk('public')->delete($photo->file_path);
            });
            $purchaseOrder->goodsReceipt?->delete();

            $receipt = GoodsReceipt::create([
                'purchase_order_id'    => $purchaseOrder->id,
                'tanggal_diterima'     => $request->tanggal_diterima,
                'jumlah_diterima'      => $request->jumlah_diterima,
                'kondisi_barang'       => $request->kondisi_barang,
                'catatan_gudang'       => $request->catatan_gudang,
                'detail_permasalahan'  => $request->detail_permasalahan,
                'jumlah_rusak'         => $request->jumlah_rusak,
                'tindakan_selanjutnya' => $request->tindakan_selanjutnya,
                'status_penerimaan'    => $statusPenerimaan,
                'created_by'           => Auth::id(),
            ]);

            // Upload foto
            if ($request->hasFile('foto')) {
                $keteranganList = $request->keterangan_foto ?? [];
                foreach ($request->file('foto') as $index => $file) {
                    $path = $file->store('goods-receipts/' . $receipt->id, 'public');
                    GoodsReceiptPhoto::create([
                        'goods_receipt_id' => $receipt->id,
                        'file_path'        => $path,
                        'keterangan'       => $keteranganList[$index] ?? null,
                    ]);
                }
            }

            // Update status PO
            $newPoStatus = match ($statusPenerimaan) {
                'diterima_sesuai'         => 'selesai',
                'diterima_dengan_catatan' => 'selesai',
                'retur_barang'            => 'retur',
                'penggantian_vendor'      => 'penggantian_vendor',
                default                   => 'menunggu_tindak_lanjut',
            };
            $purchaseOrder->update(['status' => $newPoStatus]);

            return $receipt;
        });

        // Kirim notifikasi ke semua supply chain
        $this->notifySupplyChain($receipt, $purchaseOrder);

        return redirect()
            ->route('gudang.goods-receipts.report', $receipt->id)
            ->with('success', 'Laporan penerimaan barang berhasil disimpan.');
    }

    /**
     * Detail laporan penerimaan yang sudah disimpan.
     */
    public function showReport(GoodsReceipt $receipt)
    {
        $receipt->load(['purchaseOrder.vendor', 'purchaseOrder.tender', 'purchaseOrder.items', 'photos', 'creator']);

        return view('gudang.goods-receipts.report', compact('receipt'));
    }

    private function notifySupplyChain(GoodsReceipt $receipt, PurchaseOrder $po): void
    {
        $supplyChainUsers = User::where('role', 'supply_chain')
            ->whereNotNull('fcm_token')
            ->get();

        $status = $receipt->status_label;
        $isProblematic = in_array($receipt->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']);

        $title = $isProblematic
            ? 'Laporan Penerimaan Perlu Ditinjau'
            : 'Laporan Penerimaan Baru';

        $body = $isProblematic
            ? "Gudang telah menyimpan laporan penerimaan untuk Purchase Order {$po->kode_po} dengan status {$status}. Silakan cek pada menu Laporan Penerimaan."
            : "Gudang telah menyimpan laporan penerimaan untuk Purchase Order {$po->kode_po}. Silakan cek pada menu Laporan Penerimaan.";

        $url = route('supply-chain.goods-receipt-reports.show', $receipt->id);
        $data = ['click_action' => $url];

        foreach ($supplyChainUsers as $user) {
            try {
                $this->firebase->sendNotification($user->fcm_token, $title, $body, null, $data);
            } catch (\Throwable $e) {
                // Log error but don't block
                logger()->error("Firebase notify failed for user {$user->id}: " . $e->getMessage());
            }
        }
    }
}
