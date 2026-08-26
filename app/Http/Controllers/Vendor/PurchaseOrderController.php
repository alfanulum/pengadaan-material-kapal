<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Vendor;
use App\Services\FirebaseService;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function index()
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $purchaseOrders = PurchaseOrder::with([
            'tender.materialRequest.project',
            'vendor',
            'items',
            'shipment',
            'goodsReceipt',
        ])
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(10);

        return view('vendor.purchase-orders.index', compact('vendor', 'purchaseOrders'));
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        if ($purchaseOrder->vendor_id !== $vendor->id) {
            abort(403);
        }

        $purchaseOrder->load([
            'tender.materialRequest.project',
            'tender.materialRequest.user',
            'vendor',
            'quotation',
            'items',
            'shipment',
            'goodsReceipt',
            'pembuatPo',
        ]);

        return view('vendor.purchase-orders.show', compact('vendor', 'purchaseOrder'));
    }

    public function ship(PurchaseOrder $purchaseOrder)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        // Validasi: PO milik vendor yang sedang login
        if ($purchaseOrder->vendor_id !== $vendor->id) {
            abort(403, 'Anda tidak berhak mengirim barang untuk PO ini.');
        }

        // Validasi: Vendor tidak boleh kirim barang jika sudah mundur
        if ($purchaseOrder->isVendorMundur()) {
            return back()->with('error', 'Anda telah mengundurkan diri dari Purchase Order ini. Pengiriman tidak dapat dilakukan.');
        }

        // Validasi: Status PO harus dikirim_ke_vendor
        if ($purchaseOrder->status !== 'dikirim_ke_vendor') {
            return back()->with('error', 'Status Purchase Order tidak valid untuk pengiriman barang.');
        }

        // Validasi: Barang belum pernah dikirim (tidak boleh duplikat)
        if ($purchaseOrder->shipment) {
            return back()->with('error', 'Barang untuk Purchase Order ini sudah pernah dikirim sebelumnya.');
        }

        DB::transaction(function () use ($purchaseOrder, $vendor) {
            // Buat data pengiriman barang
            Shipment::create([
                'purchase_order_id' => $purchaseOrder->id,
                'tender_id'         => $purchaseOrder->tender_id,
                'vendor_id'         => $vendor->id,
                'tanggal_kirim'     => now(),
                'status'            => 'dikirim',
            ]);

            // Update status PO menjadi dikirim
            $purchaseOrder->update([
                'status'             => 'dikirim',
                'tanggal_pengiriman' => now(),
            ]);
        });

        // Reload relasi
        $purchaseOrder->load(['tender.materialRequest', 'vendor']);
        $namaVendor  = $vendor->nama_vendor ?? 'Vendor';
        $kodePo      = $purchaseOrder->kode_po;
        $namaTender  = $purchaseOrder->tender->nama_tender ?? '-';

        // Notifikasi ke Gudang
        $this->notifyRole(
            'gudang',
            '📦 Barang Baru Dikirim Vendor',
            "Vendor {$namaVendor} telah mengirim barang untuk Purchase Order {$kodePo}. Silakan cek daftar barang yang akan diterima."
        );

        // Notifikasi ke Supply Chain
        $this->notifyRole(
            'supply_chain',
            '🚚 Barang Dikirim Vendor',
            "Vendor {$namaVendor} telah mengirim barang untuk tender {$namaTender}."
        );

        return redirect()
            ->route('vendor.purchase-orders.show', $purchaseOrder->id)
            ->with('success', 'Barang berhasil dikirim ke gudang.');
    }

    /**
     * Proses pengunduran diri Vendor dari Purchase Order.
     */
    public function mundur(Request $request, PurchaseOrder $purchaseOrder)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        // 1. PO harus milik vendor yang sedang login
        if ($purchaseOrder->vendor_id !== $vendor->id) {
            abort(403, 'Anda tidak berhak melakukan pengunduran diri dari Purchase Order ini.');
        }

        // 2. Validasi alasan wajib diisi
        $request->validate([
            'alasan_pengunduran_diri' => 'required|string|min:10|max:2000',
        ], [
            'alasan_pengunduran_diri.required' => 'Alasan pengunduran diri wajib diisi.',
            'alasan_pengunduran_diri.min'      => 'Alasan pengunduran diri minimal 10 karakter.',
        ]);

        // 3. Reload state terbaru dari DB (hindari race condition)
        $purchaseOrder->refresh();

        // 4. Cek apakah pengunduran diri masih diperbolehkan
        if (!$purchaseOrder->canVendorWithdraw()) {
            return redirect()
                ->route('vendor.purchase-orders.show', $purchaseOrder->id)
                ->with('error', 'Pengunduran diri tidak dapat dilakukan. Status Purchase Order tidak mengizinkan tindakan ini.');
        }

        DB::transaction(function () use ($purchaseOrder, $vendor, $request) {
            $purchaseOrder->update([
                'status'                   => 'vendor_mundur',
                'tanggal_pengunduran_diri' => now(),
                'alasan_pengunduran_diri'  => $request->alasan_pengunduran_diri,
            ]);
        });

        // Kirim notifikasi ke Supply Chain
        $namaVendor = $vendor->nama_vendor ?? 'Vendor';
        $kodePo     = $purchaseOrder->kode_po;

        $this->notifyRole(
            'supply_chain',
            '⚠️ Vendor Mengundurkan Diri',
            "Vendor {$namaVendor} telah mengundurkan diri dari Purchase Order {$kodePo}. Silakan tinjau dan tentukan tindak lanjut."
        );

        return redirect()
            ->route('vendor.purchase-orders.show', $purchaseOrder->id)
            ->with('success', 'Pengunduran diri Anda telah berhasil direkam. Supply Chain telah mendapatkan notifikasi.');
    }

    /**
     * Unduh Dokumen Purchase Order dalam format PDF (untuk Vendor).
     * Vendor hanya dapat mengunduh PO miliknya sendiri.
     */
    public function unduhDokumenPo(PurchaseOrder $purchaseOrder)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        // Validasi kepemilikan PO
        if ($purchaseOrder->vendor_id !== $vendor->id) {
            abort(403, 'Anda tidak berhak mengunduh dokumen Purchase Order ini.');
        }

        // Load semua relasi yang diperlukan
        $purchaseOrder->load([
            'tender.materialRequest.project',
            'tender.materialRequest.items',
            'vendor',
            'quotation',
            'items',
            'pembuatPo',
        ]);

        $pdf = Pdf::loadView('supply-chain.purchase-orders.pdf', [
            'po' => $purchaseOrder,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $kodePo   = $purchaseOrder->kode_po ?? 'PO';
        $filename = 'purchase-order-' . $kodePo . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Kirim notifikasi Firebase ke semua user dengan role tertentu.
     */
    private function notifyRole(string $role, string $title, string $body): void
    {
        $users = User::where('role', $role)
            ->whereNotNull('fcm_token')
            ->get();

        foreach ($users as $user) {
            try {
                $this->firebase->sendNotification($user->fcm_token, $title, $body);
            } catch (\Throwable $e) {
                logger()->error("Firebase notify failed for user {$user->id}: " . $e->getMessage());
            }
        }
    }
}
