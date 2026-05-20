<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;
use App\Models\Tender;
use App\Models\TenderInvitation;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderController extends Controller
{
    public function index()
    {
        $tenders = Tender::with('materialRequest')
            ->latest()
            ->paginate(10);

        return view('supply-chain.tenders.index', compact('tenders'));
    }

    public function create($materialRequestId)
    {
        $materialRequest = MaterialRequest::with(['project', 'user', 'items'])
            ->findOrFail($materialRequestId);

        $vendors = Vendor::where('status', 'aktif')->get();

        return view('supply-chain.tenders.create', compact('materialRequest', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'material_request_id' => 'required|exists:material_requests,id',
            'nama_tender' => 'required|string|max:255',
            'deadline' => 'required|date',
            'catatan' => 'nullable|string',
            'vendor_ids' => 'required|array|min:1',
            'vendor_ids.*' => 'exists:vendors,id',
        ]);

        DB::transaction(function () use ($request) {
            $tender = Tender::create([
                'kode_tender' => 'TDR-' . date('YmdHis'),
                'material_request_id' => $request->material_request_id,
                'nama_tender' => $request->nama_tender,
                'deadline' => $request->deadline,
                'catatan' => $request->catatan,
                'status' => 'dikirim',
            ]);

            foreach ($request->vendor_ids as $vendorId) {
                TenderInvitation::create([
                    'tender_id' => $tender->id,
                    'vendor_id' => $vendorId,
                    'status' => 'dikirim',
                    'sent_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route('supply-chain.tenders.index')
            ->with('success', 'Tender berhasil dibuat dan dikirim ke vendor.');
    }

    public function show(Tender $tender)
    {
        $tender->load(['materialRequest.project', 'materialRequest.items', 'invitations.vendor']);

        return view('supply-chain.tenders.show', compact('tender'));
    }
}
