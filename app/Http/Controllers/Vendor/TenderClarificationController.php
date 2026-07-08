<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\TenderClarification;
use App\Models\TenderMessage;
use App\Models\TenderInvitation;
use App\Models\Vendor;
use App\Models\Tender;
use App\Services\FirebaseService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenderClarificationController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | CLARIFICATION CHAT
    |--------------------------------------------------------------------------
    */

    public function chat(TenderInvitation $invitation)
    {

        $vendor = Vendor::where(
            'user_id',
            Auth::id()
        )->firstOrFail();


        if ($invitation->vendor_id !== $vendor->id) {

            abort(403);
        }



        $messages = TenderClarification::where(
            'tender_id',
            $invitation->tender_id
        )

            ->where(
                'vendor_id',
                $vendor->id
            )

            ->orderBy(
                'created_at',
                'asc'
            )

            ->get();



        return view(
            'vendor.tenders.chat-clarification',
            compact(
                'invitation',
                'messages'
            )
        );
    }




    public function store(
        Request $request,
        TenderInvitation $invitation,
        FirebaseService $firebase
    ) {

        $request->validate([

            'message' => 'required|string|max:2000'

        ]);



        $vendor = Vendor::where(

            'user_id',

            Auth::id()

        )->firstOrFail();



        if ($invitation->vendor_id !== $vendor->id) {

            abort(403);
        }



        $invitation->load(
            'tender.materialRequest.user'
        );




        // SIMPAN PESAN

        TenderClarification::create([

            'tender_id' => $invitation->tender_id,

            'vendor_id' => $vendor->id,

            'engineer_id' => $invitation
                ->tender
                ->materialRequest
                ->user_id,

            'sender_id' => Auth::id(),

            'message' => $request->message,

            'status' => 'terkirim',

        ]);




        /*
        |--------------------------------------------------------------------------
        | FIREBASE KE ENGINEER
        |--------------------------------------------------------------------------
        */

        $engineer = $invitation
            ->tender
            ->materialRequest
            ->user;

        if (
            $engineer &&
            $engineer->fcm_token
        ) {
            $firebase->sendNotification(
                $engineer->fcm_token,
                'Klarifikasi dari ' . Auth::user()->name,
                \Illuminate\Support\Str::limit($request->message, 80)
            );
        }

        // Return JSON for AJAX requests (no page reload)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['status' => 'ok', 'message' => 'Pesan terkirim']);
        }

        return back();
    }







    /*
    |--------------------------------------------------------------------------
    | NEGOTIATION CHAT
    |--------------------------------------------------------------------------
    */

    public function negotiation(TenderInvitation $invitation)
    {

        $vendor = Vendor::where(
            'user_id',
            Auth::id()
        )->firstOrFail();


        if ($invitation->vendor_id !== $vendor->id) {

            abort(403);
        }



        $messages = TenderMessage::where(
            'tender_id',
            $invitation->tender_id
        )

            ->where(
                'vendor_id',
                $vendor->id
            )

            ->where(
                'type',
                'negotiation'
            )

            ->orderBy(
                'created_at',
                'asc'
            )

            ->get();



        return view(
            'vendor.tenders.chat-negotiation',
            compact(
                'invitation',
                'messages'
            )
        );
    }




    public function sendNegotiation(
        Request $request,
        TenderInvitation $invitation,
        FirebaseService $firebase
    ) {

        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        if ($invitation->vendor_id !== $vendor->id) {
            abort(403);
        }

        TenderMessage::create([
            'tender_id' => $invitation->tender_id,
            'vendor_id' => $vendor->id,
            'sender_id' => Auth::id(),
            'role'      => 'vendor',
            'type'      => 'negotiation',
            'message'   => $request->message,
            'is_read'   => false,
        ]);


        /*
        |--------------------------------------------------------------------------
        | FIREBASE NOTIFICATION KE SUPPLY CHAIN
        |--------------------------------------------------------------------------
        */

        $scUsers = User::where('role', 'supply_chain')->get();

        foreach ($scUsers as $scUser) {
            if ($scUser->fcm_token) {
                $firebase->sendNotification(
                    $scUser->fcm_token,
                    'Negosiasi dari ' . Auth::user()->name,
                    \Illuminate\Support\Str::limit($request->message, 80)
                );
            }
        }

        // Return JSON for AJAX requests (no page reload)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['status' => 'ok', 'message' => 'Pesan terkirim']);
        }

        return back();
    }




    /*
    |--------------------------------------------------------------------------
    | AJAX: GET MESSAGES (for real-time polling)
    |--------------------------------------------------------------------------
    */

    public function clarificationMessagesAjax(
        TenderInvitation $invitation
    ) {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        if ($invitation->vendor_id !== $vendor->id) {
            abort(403);
        }

        $messages = TenderClarification::with('sender')
            ->where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id'        => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'message'   => $msg->message,
                    'role'      => $msg->sender_id == auth()->id() ? 'me' : 'other',
                    'sender_name' => $msg->sender->name ?? 'Engineer',
                    'time'      => $msg->created_at->format('d-m-Y H:i'),
                ];
            });

        return response()->json(['messages' => $messages]);
    }


    public function negotiationMessagesAjax(
        TenderInvitation $invitation
    ) {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        if ($invitation->vendor_id !== $vendor->id) {
            abort(403);
        }

        $messages = TenderMessage::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->where('type', 'negotiation')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) {
                return [
                    'id'        => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'message'   => $msg->message,
                    'role'      => $msg->sender_id == auth()->id() ? 'me' : 'other',
                    'sender_name' => $msg->role === 'vendor' ? 'Anda / Vendor' : 'Supply Chain',
                    'time'      => $msg->created_at->format('d-m-Y H:i'),
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
