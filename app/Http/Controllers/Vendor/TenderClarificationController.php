<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\TenderClarification;
use App\Models\TenderMessage;
use App\Models\TenderInvitation;
use App\Models\Vendor;
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

                'Klarifikasi Baru',

                Auth::user()->name .
                    ' mengirim pertanyaan spesifikasi'

            );
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
        TenderInvitation $invitation
    ) {

        $request->validate([

            'message' => 'required|string|max:2000'

        ]);



        $vendor = Vendor::where(
            'user_id',
            Auth::id()
        )->firstOrFail();



        if (
            $invitation->vendor_id !== $vendor->id
        ) {

            abort(403);
        }




        TenderMessage::create([

            'tender_id' => $invitation->tender_id,

            'vendor_id' => $vendor->id,

            'sender_id' => Auth::id(),

            'role' => 'vendor',

            'type' => 'negotiation',

            'message' => $request->message,

            'is_read' => false,

        ]);



        return back();
    }
}
