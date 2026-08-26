<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\TenderInvitation;
use App\Models\User;
use App\Models\Vendor;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorQuotation;
use Illuminate\Http\Request;
use App\Models\TenderClarification;

class TenderController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $invitations = TenderInvitation::with([
            'tender.materialRequest.project',
            'tender.materialRequest.items',
            'vendor'
        ])
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->get();

        return view('vendor.tenders.index', compact('vendor', 'invitations'));
    }

    public function show($id)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $invitation = TenderInvitation::with([
            'tender.materialRequest.project',
            'tender.materialRequest.items',
            'vendor'
        ])
            ->where('vendor_id', $vendor->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($invitation->status === 'dikirim') {
            $invitation->update([
                'status' => 'dibaca',
            ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Tandai pesan engineer sebagai dibaca
    |--------------------------------------------------------------------------
    */
        TenderClarification::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->where('sender_id', '!=', Auth::id())
            ->where('status', 'terkirim')
            ->update([
                'status' => 'dibaca'
            ]);

        $clarifications = TenderClarification::with('sender')
            ->where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->orderBy('created_at')
            ->get();

        $quotation = VendorQuotation::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->first();

        return view(
            'vendor.tenders.show',
            compact(
                'vendor',
                'invitation',
                'clarifications',
                'quotation'
            )
        );
    }

    public function storeQuotation(Request $request, $id)
    {
        $request->validate([
            'items'               => 'required|array',
            'items.*.harga_satuan'=> 'required|numeric|min:0',
            'estimasi_pengiriman' => 'nullable|integer|min:1',
            'catatan'             => 'nullable|string',
            'file_penawaran'      => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ], [
            'items.required'           => 'Harga per item wajib diisi.',
            'items.*.harga_satuan.required' => 'Harga satuan wajib diisi.',
            'items.*.harga_satuan.numeric'  => 'Harga satuan harus berupa angka.',
            'estimasi_pengiriman.integer' => 'Estimasi pengiriman harus berupa angka bulat (hari).',
            'file_penawaran.file'      => 'File penawaran yang diunggah tidak valid.',
            'file_penawaran.mimes'     => 'Format file penawaran harus berupa PDF, DOC, DOCX, XLS, atau XLSX.',
            'file_penawaran.max'       => 'Ukuran file penawaran tidak boleh melebihi 10 MB.',
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $invitation = TenderInvitation::with('tender')
            ->where('vendor_id', $vendor->id)
            ->where('id', $id)
            ->firstOrFail();

        // Cari data penawaran yang sudah ada (jika ada) untuk mempertahankan file lama jika vendor tidak mengunggah file baru
        $existingQuotation = VendorQuotation::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->first();

        $filePath = $existingQuotation ? $existingQuotation->file_penawaran : null;

        if ($request->hasFile('file_penawaran')) {
            $filePath = $request->file('file_penawaran')->store('vendor-quotations', 'public');
        }

        // Kalkulasi Total Harga Penawaran dari Item
        $totalHargaPenawaran = 0;
        $itemsData = [];

        foreach ($request->items as $itemId => $data) {
            $mri = \App\Models\MaterialRequestItem::findOrFail($itemId);
            $hargaSatuan = $data['harga_satuan'];
            $subtotal = $hargaSatuan * $mri->qty;
            
            $totalHargaPenawaran += $subtotal;
            
            $itemsData[] = [
                'material_request_item_id' => $itemId,
                'harga_satuan'             => $hargaSatuan,
                'subtotal'                 => $subtotal,
            ];
        }

        $quotation = VendorQuotation::updateOrCreate(
            [
                'tender_id' => $invitation->tender_id,
                'vendor_id' => $vendor->id,
            ],
            [
                'harga_penawaran'     => $totalHargaPenawaran,
                'estimasi_pengiriman' => $request->estimasi_pengiriman,
                'catatan'             => $request->catatan,
                'file_penawaran'      => $filePath,
                'status'              => 'dikirim',
            ]
        );

        // Hapus item lama jika update
        \App\Models\VendorQuotationItem::where('vendor_quotation_id', $quotation->id)->delete();

        // Simpan item baru
        foreach ($itemsData as $itemData) {
            \App\Models\VendorQuotationItem::create([
                'vendor_quotation_id'      => $quotation->id,
                'material_request_item_id' => $itemData['material_request_item_id'],
                'harga_satuan'             => $itemData['harga_satuan'],
                'subtotal'                 => $itemData['subtotal'],
            ]);
        }

        $invitation->update([
            'status' => 'ditawar',
        ]);

        // Kirim notifikasi Firebase ke Supply Chain bahwa penawaran vendor masuk
        $namaVendor = $vendor->nama_vendor ?? 'Vendor';
        $namaTender = $invitation->tender->nama_tender ?? '-';

        $this->notifySupplyChain(
            '📝 Penawaran Vendor Masuk',
            "Vendor {$namaVendor} telah mengirim penawaran untuk tender {$namaTender}."
        );

        return redirect()
            ->route('vendor.tenders.show', $invitation->id)
            ->with('success', 'Penawaran berhasil dikirim.');
    }

    public function updateNegotiationNominal(Request $request, $id)
    {
        $request->validate([
            'harga_negosiasi' => 'required|numeric|min:1',
        ], [
            'harga_negosiasi.required' => 'Nominal negosiasi wajib diisi.',
            'harga_negosiasi.numeric'  => 'Nominal negosiasi harus berupa angka.',
            'harga_negosiasi.min'      => 'Nominal negosiasi harus lebih besar dari 0.',
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $invitation = TenderInvitation::with('tender.purchaseOrder')
            ->where('vendor_id', $vendor->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($invitation->status === 'tidak_terpilih' || $invitation->status === 'ditolak') {
            return redirect()
                ->route('vendor.tenders.show', $invitation->id)
                ->with('error', 'Anda sudah dinyatakan tidak terpilih pada tender ini. Nominal tidak dapat diubah.');
        }

        if ($invitation->tender->purchaseOrder) {
            return redirect()
                ->route('vendor.tenders.show', $invitation->id)
                ->with('error', 'Purchase Order sudah dibuat. Nominal tidak dapat diubah lagi.');
        }

        $quotation = VendorQuotation::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->firstOrFail();

        $quotation->update([
            'harga_negosiasi' => $request->harga_negosiasi,
        ]);

        $namaVendor = $vendor->nama_vendor ?? 'Vendor';
        $namaTender = $invitation->tender->nama_tender ?? '-';

        $this->notifySupplyChain(
            '💰 Perubahan Nominal Penawaran',
            "Vendor {$namaVendor} telah mengubah nominal penawaran untuk tender {$namaTender}."
        );

        return redirect()
            ->route('vendor.tenders.show', $invitation->id)
            ->with('success', 'Nominal penawaran berhasil diperbarui.');
    }

    /**
     * Kirim notifikasi Firebase ke semua user Supply Chain.
     */
    private function notifySupplyChain(string $title, string $body): void
    {
        $users = User::where('role', 'supply_chain')
            ->whereNotNull('fcm_token')
            ->get();

        foreach ($users as $user) {
            try {
                $this->firebase->sendNotification($user->fcm_token, $title, $body);
            } catch (\Throwable $e) {
                logger()->error("Firebase notify SC failed for user {$user->id}: " . $e->getMessage());
            }
        }
    }
}
