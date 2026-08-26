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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = PurchaseOrder::with([
            'tender.materialRequest.project',
            'vendor',
            'quotation',
            'pembuatPo',
        ])->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_po', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhereHas('vendor', fn($v) => $v->where('nama_vendor', 'like', "%{$search}%"))
                  ->orWhereHas('tender', fn($t) => $t->where('nama_tender', 'like', "%{$search}%")
                        ->orWhere('kode_tender', 'like', "%{$search}%"))
                  ->orWhereHas('pembuatPo', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $purchaseOrders = $query->paginate(10)->withQueryString();

        return view('supply-chain.purchase-orders.index', compact('purchaseOrders', 'search'));
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
            'vendor_quotation_id' => 'required|exists:penawaran_vendor,id',
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

            $items       = $tender->materialRequest->items;

            $hargaFinal      = $quotation->harga_negosiasi ?? $quotation->harga_penawaran;

            $po = PurchaseOrder::create([
                'kode_po'             => 'PO-' . date('YmdHis'),
                'tender_id'           => $tender->id,
                'vendor_id'           => $quotation->vendor_id,
                'vendor_quotation_id' => $quotation->id,
                'tanggal_po'          => $request->tanggal_po,
                'deadline_pengiriman' => $request->deadline_pengiriman,
                'total_harga'         => $hargaFinal,
                'catatan'             => $request->catatan,
                'status'              => 'dikirim_ke_vendor',
                'dibuat_oleh'         => Auth::id(),
            ]);

            $items = $tender->materialRequest->items;
            
            $hargaPenawaran = $quotation->harga_penawaran > 0 ? $quotation->harga_penawaran : 1;
            $discountFactor = $hargaFinal / $hargaPenawaran;

            foreach ($items as $item) {
                // Ambil harga satuan asli dari penawaran vendor item
                $vendorItem = \App\Models\VendorQuotationItem::where('vendor_quotation_id', $quotation->id)
                                ->where('material_request_item_id', $item->id)
                                ->first();
                                
                $hargaSatuanAsli = $vendorItem ? $vendorItem->harga_satuan : 0;
                
                // Aplikasikan diskon jika ada negosiasi
                $hargaSatuanAkhir = $hargaSatuanAsli * $discountFactor;
                $subtotalAkhir    = $hargaSatuanAkhir * $item->qty;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'nama_barang'       => $item->nama_barang,
                    'spesifikasi'       => $item->spesifikasi,
                    'qty'               => $item->qty,
                    'satuan'            => $item->satuan,
                    'harga_satuan'      => $hargaSatuanAkhir,
                    'subtotal'          => $subtotalAkhir,
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
            'tender.tenderInduk',
            'tender.tenderPengganti',
            'vendor',
            'quotation',
            'items',
            'pembuatPo',
            'shipment',
            'goodsReceipt',
        ]);

        return view('supply-chain.purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Redirect ke halaman buat Tender menggunakan material request yang sama.
     * Fitur "Buat Tender Ulang" setelah Vendor mengundurkan diri.
     */
    public function buatTenderUlang(PurchaseOrder $purchaseOrder)
    {
        // Validasi: PO harus berstatus vendor_mundur
        if (!$purchaseOrder->isVendorMundur()) {
            return redirect()
                ->route('supply-chain.purchase-orders.show', $purchaseOrder->id)
                ->with('error', 'Tender ulang hanya dapat dibuat apabila vendor telah mengundurkan diri.');
        }

        $purchaseOrder->load(['tender.materialRequest', 'tender.tenderPengganti']);

        // Cegah tender ulang ganda: jika tender pengganti sudah ada
        if ($purchaseOrder->tender && $purchaseOrder->tender->tenderPengganti) {
            $tenderBaru = $purchaseOrder->tender->tenderPengganti;
            return redirect()
                ->route('supply-chain.tenders.show', $tenderBaru->id)
                ->with('info', 'Tender ulang untuk PO ini sudah pernah dibuat. Anda diarahkan ke tender tersebut.');
        }

        $materialRequest = $purchaseOrder->tender->materialRequest ?? null;
        if (!$materialRequest) {
            return redirect()
                ->route('supply-chain.purchase-orders.show', $purchaseOrder->id)
                ->with('error', 'Data permintaan material tidak ditemukan.');
        }

        // Redirect ke halaman create Tender yang sudah ada, dengan tender_induk_id di session
        // agar store() dapat menyimpan relasi
        session(['tender_induk_id' => $purchaseOrder->tender->id]);

        return redirect()->route(
            'supply-chain.tenders.create',
            $materialRequest->id
        );
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
