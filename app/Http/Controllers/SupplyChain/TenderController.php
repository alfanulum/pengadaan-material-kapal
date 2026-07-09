<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;
use App\Models\Tender;
use App\Models\TenderInvitation;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorQuotation;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

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
            'nama_tender'         => 'required|string|max:255',
            'deadline'            => 'required|date',
            'catatan'             => 'nullable|string',
            'vendor_ids'          => 'required|array|min:1',
            'vendor_ids.*'        => 'exists:vendors,id',
        ]);

        DB::transaction(function () use ($request) {
            $tender = Tender::create([
                'kode_tender'        => 'TDR-' . date('YmdHis'),
                'material_request_id'=> $request->material_request_id,
                'nama_tender'        => $request->nama_tender,
                'deadline'           => $request->deadline,
                'catatan'            => $request->catatan,
                'status'             => 'dikirim',
            ]);

            foreach ($request->vendor_ids as $vendorId) {
                TenderInvitation::create([
                    'tender_id' => $tender->id,
                    'vendor_id' => $vendorId,
                    'status'    => 'dikirim',
                    'sent_at'   => now(),
                ]);
            }
        });

        return redirect()
            ->route('supply-chain.tenders.index')
            ->with('success', 'Tender berhasil dibuat dan dikirim ke vendor.');
    }

    public function show(Tender $tender)
    {
        $tender->load([
            'materialRequest.project',
            'materialRequest.items',
            'materialRequest.user',
            'invitations.vendor',
            'quotations.vendor',
            'purchaseOrder',
            'clarifications.vendor',
            'clarifications.sender',
        ]);

        return view('supply-chain.tenders.show', compact('tender'));
    }

    public function chooseVendor($tenderId, $quotationId)
    {
        $chosenQuotation = null;

        DB::transaction(function () use ($tenderId, $quotationId, &$chosenQuotation) {
            $tender = Tender::with('invitations')->findOrFail($tenderId);

            $quotation = VendorQuotation::where('tender_id', $tender->id)
                ->where('id', $quotationId)
                ->firstOrFail();

            VendorQuotation::where('tender_id', $tender->id)
                ->update([
                    'status' => 'ditolak',
                ]);

            $quotation->update([
                'status' => 'diterima',
            ]);

            $tender->invitations()->update([
                'status' => 'tidak_terpilih',
            ]);

            $tender->invitations()
                ->where('vendor_id', $quotation->vendor_id)
                ->update([
                    'status' => 'terpilih',
                ]);

            $tender->update([
                'status' => 'vendor_terpilih',
            ]);

            $chosenQuotation = $quotation->load(['vendor.user', 'tender']);
        });

        // Kirim notifikasi Firebase ke vendor yang terpilih
        if ($chosenQuotation) {
            $this->notifyChosenVendor($chosenQuotation);
        }

        return redirect()
            ->route('supply-chain.tenders.show', $tenderId)
            ->with('success', 'Vendor pemenang berhasil dipilih.');
    }

    /**
     * Kirim notifikasi Firebase ke vendor yang dipilih.
     */
    private function notifyChosenVendor(VendorQuotation $quotation): void
    {
        // Dapatkan user dari vendor yang terpilih
        $vendor = Vendor::with('user')->find($quotation->vendor_id);

        if (!$vendor || !$vendor->user || !$vendor->user->fcm_token) {
            return;
        }

        $namaTender = $quotation->tender->nama_tender ?? '-';

        try {
            $this->firebase->sendNotification(
                $vendor->user->fcm_token,
                '🏆 Anda Terpilih sebagai Vendor',
                "Penawaran Anda untuk tender {$namaTender} telah dipilih oleh Supply Chain."
            );
        } catch (\Throwable $e) {
            logger()->error("Firebase notify vendor failed for vendor {$vendor->id}: " . $e->getMessage());
        }
    }
}
