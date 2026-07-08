<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\TenderClarification;
use App\Models\Vendor;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenderClarificationController extends Controller
{
    public function index()
    {
        $clarifications = TenderClarification::with([
            'tender.materialRequest.project',
            'vendor',
            'sender',
        ])
            ->where('engineer_id', Auth::id())
            ->latest()
            ->get()
            ->groupBy(function ($item) {
                return $item->tender_id . '-' . $item->vendor_id;
            });

        return view('engineer.clarifications.index', compact('clarifications'));
    }


    public function show(Tender $tender, Vendor $vendor)
    {
        $materialRequest = $tender->materialRequest;

        if ($materialRequest->user_id !== Auth::id()) {
            abort(403);
        }


        $messages = TenderClarification::with('sender')
            ->where('tender_id', $tender->id)
            ->where('vendor_id', $vendor->id)
            ->where('engineer_id', Auth::id())
            ->orderBy('created_at')
            ->get();


        // tandai pesan vendor sudah dibaca
        TenderClarification::where('tender_id', $tender->id)
            ->where('vendor_id', $vendor->id)
            ->where('engineer_id', Auth::id())
            ->where('sender_id', '!=', Auth::id())
            ->update([
                'status' => 'dibaca',
            ]);


        return view(
            'engineer.clarifications.show',
            compact(
                'tender',
                'vendor',
                'messages'
            )
        );
    }



    public function reply(
        Request $request,
        Tender $tender,
        Vendor $vendor,
        FirebaseService $firebase
    ) {

        $request->validate([
            'message' => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
        if (!$request->message && !$request->hasFile('attachment')) {
            return back()->with('error', 'Pesan atau gambar harus diisi');
        }


        $materialRequest = $tender->materialRequest;


        if ($materialRequest->user_id !== Auth::id()) {
            abort(403);
        }



        // SIMPAN BALASAN ENGINEER

        $attachmentPath = $request->hasFile('attachment') ? $request->file('attachment')->store('chat_attachments', 'public') : null;

        TenderClarification::create([

            'tender_id' => $tender->id,

            'vendor_id' => $vendor->id,

            'engineer_id' => Auth::id(),

            'sender_id' => Auth::id(),

            'message' => $request->message,
            'attachment' => $attachmentPath,
            'status' => 'terkirim',
        ]);




        /*
        |--------------------------------------------------------------------------
        | FIREBASE NOTIFICATION KE VENDOR
        |--------------------------------------------------------------------------
        */


        $vendorUser = $vendor->user;


        if (
            $vendorUser &&
            $vendorUser->fcm_token
        ) {

            $firebase->sendNotification(
                $vendorUser->fcm_token,
                'Klarifikasi dari ' . Auth::user()->name,
                $request->hasFile('attachment') ? '📷 Mengirim gambar' : \Illuminate\Support\Str::limit($request->message, 80),
                $attachmentPath ? asset('storage/' . $attachmentPath) : null
            );
        }



        // Return JSON for AJAX requests (no page reload)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['status' => 'ok', 'message' => 'Jawaban terkirim']);
        }

        return redirect()

            ->route(
                'engineer.clarifications.show',
                [
                    $tender->id,
                    $vendor->id
                ]
            )

            ->with(
                'success',
                'Jawaban klarifikasi berhasil dikirim.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | AJAX: GET MESSAGES (for real-time polling)
    |--------------------------------------------------------------------------
    */
    public function messagesAjax(Tender $tender, Vendor $vendor)
    {
        $messages = TenderClarification::with('sender')
            ->where('tender_id', $tender->id)
            ->where('vendor_id', $vendor->id)
            ->where('engineer_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id'          => $msg->id,
                    'sender_id'   => $msg->sender_id,
                    'message'     => $msg->message,
                    'attachment_url' => $msg->attachment ? asset('storage/' . $msg->attachment) : null,
                    'role'        => $msg->sender_id == auth()->id() ? 'me' : 'other',
                    'sender_name' => $msg->sender_id == auth()->id() ? 'Engineer (Anda)' : ($msg->sender->name ?? 'Vendor'),
                    'time'        => $msg->created_at->format('d-m-Y H:i'),
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
