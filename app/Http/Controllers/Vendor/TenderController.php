<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\TenderInvitation;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorQuotation;
use Illuminate\Http\Request;
use App\Models\TenderClarification;

class TenderController extends Controller
{
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

        return view(
            'vendor.tenders.show',
            compact(
                'vendor',
                'invitation',
                'clarifications'
            )
        );
    }

    public function storeQuotation(Request $request, $id)
    {
        $request->validate([
            'harga_penawaran' => 'required|numeric|min:0',
            'estimasi_pengiriman' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string',
            'file_penawaran' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $invitation = TenderInvitation::with('tender')
            ->where('vendor_id', $vendor->id)
            ->where('id', $id)
            ->firstOrFail();

        $filePath = null;

        if ($request->hasFile('file_penawaran')) {
            $filePath = $request->file('file_penawaran')->store('vendor-quotations', 'public');
        }

        VendorQuotation::updateOrCreate(
            [
                'tender_id' => $invitation->tender_id,
                'vendor_id' => $vendor->id,
            ],
            [
                'harga_penawaran' => $request->harga_penawaran,
                'estimasi_pengiriman' => $request->estimasi_pengiriman,
                'catatan' => $request->catatan,
                'file_penawaran' => $filePath,
                'status' => 'dikirim',
            ]
        );

        $invitation->update([
            'status' => 'ditawar',
        ]);

        return redirect()
            ->route('vendor.tenders.show', $invitation->id)
            ->with('success', 'Penawaran berhasil dikirim.');
    }
}
