<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Tender;
use App\Models\Vendor;
use App\Models\VendorQuotation;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        $purchaseOrders = PurchaseOrder::with([
            'tender.materialRequest.project',
            'vendor',
            'quotation'
        ])
            ->latest()
            ->paginate(10);

        return view('supply-chain.purchase-orders.index', compact('purchaseOrders'));
    }

    public function create($tenderId)
    {
        $tender = Tender::with([
            'materialRequest.project',
            'materialRequest.user',
            'materialRequest.items',
            'invitations.vendor',
            'quotations.vendor',
            'purchaseOrder'
        ])->findOrFail($tenderId);

        if ($tender->status !== 'vendor_terpilih') {
            return redirect()
                ->route('supply-chain.tenders.show', $tender->id)
                ->with('success', 'Purchase Order hanya dapat dibuat setelah vendor pemenang dipilih.');
        }

        if ($tender->purchaseOrder) {
            return redirect()
                ->route('supply-chain.purchase-orders.show', $tender->purchaseOrder->id)
                ->with('success', 'Purchase Order untuk tender ini sudah dibuat.');
        }

        $quotation = VendorQuotation::with('vendor')
            ->where('tender_id', $tender->id)
            ->where('status', 'diterima')
            ->firstOrFail();

        return view('supply-chain.purchase-orders.create', compact('tender', 'quotation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tender_id'           => 'required|exists:tenders,id',
            'vendor_quotation_id' => 'required|exists:vendor_quotations,id',
            'tanggal_po'          => 'required|date',
            'deadline_pengiriman' => 'nullable|date|after_or_equal:tanggal_po',
            'catatan'             => 'nullable|string',
        ]);

        $purchaseOrder = DB::transaction(function () use ($request) {
            $tender = Tender::with([
                'materialRequest.items',
                'purchaseOrder'
            ])->findOrFail($request->tender_id);

            if ($tender->purchaseOrder) {
                return $tender->purchaseOrder;
            }

            $quotation = VendorQuotation::with('vendor')
                ->where('id', $request->vendor_quotation_id)
                ->where('tender_id', $tender->id)
                ->where('status', 'diterima')
                ->firstOrFail();

            $items = $tender->materialRequest->items;
            $jumlahItem = max($items->count(), 1);

            $hargaSatuanRata = $quotation->harga_penawaran / $jumlahItem;

            $po = PurchaseOrder::create([
                'kode_po'             => 'PO-' . date('YmdHis'),
                'tender_id'           => $tender->id,
                'vendor_id'           => $quotation->vendor_id,
                'vendor_quotation_id' => $quotation->id,
                'tanggal_po'          => $request->tanggal_po,
                'deadline_pengiriman' => $request->deadline_pengiriman,
                'total_harga'         => $quotation->harga_penawaran,
                'catatan'             => $request->catatan,
                'status'              => 'dikirim_ke_vendor',
            ]);

            foreach ($items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'nama_barang'       => $item->nama_barang,
                    'spesifikasi'       => $item->spesifikasi,
                    'qty'               => $item->qty,
                    'satuan'            => $item->satuan,
                    'harga_satuan'      => $hargaSatuanRata,
                    'subtotal'          => $hargaSatuanRata,
                ]);
            }

            return $po->load(['vendor.user', 'tender']);
        });

        // Kirim notifikasi Firebase ke vendor terpilih bahwa PO sudah diterbitkan
        $this->notifyVendor($purchaseOrder);

        return redirect()
            ->route('supply-chain.purchase-orders.show', $purchaseOrder->id)
            ->with('success', 'Purchase Order berhasil dibuat dan dikirim ke vendor.');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load([
            'tender.materialRequest.project',
            'tender.materialRequest.user',
            'vendor',
            'quotation',
            'items',
        ]);

        return view('supply-chain.purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Kirim notifikasi Firebase ke vendor terpilih bahwa PO sudah diterbitkan.
     */
    private function notifyVendor(PurchaseOrder $po): void
    {
        // Load relasi jika belum ter-load
        $po->loadMissing(['vendor.user', 'tender']);

        $vendor = $po->vendor;
        if (!$vendor || !$vendor->user || !$vendor->user->fcm_token) {
            return;
        }

        $kodePo     = $po->kode_po;
        $namaTender = $po->tender->nama_tender ?? '-';

        try {
            $this->firebase->sendNotification(
                $vendor->user->fcm_token,
                '📋 Purchase Order Diterbitkan',
                "Supply Chain telah menerbitkan Purchase Order {$kodePo} untuk tender {$namaTender}. Silakan cek dan lakukan pengiriman barang."
            );
        } catch (\Throwable $e) {
            logger()->error("Firebase notify vendor PO failed for vendor {$vendor->id}: " . $e->getMessage());
        }
    }
}
