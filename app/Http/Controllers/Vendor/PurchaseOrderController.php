<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Shipment;
use App\Models\User;
use App\Models\Vendor;
use App\Services\FirebaseService;
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
