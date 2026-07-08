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
            'message' => 'required|string|max:2000',
        ]);


        $materialRequest = $tender->materialRequest;


        if ($materialRequest->user_id !== Auth::id()) {
            abort(403);
        }



        // SIMPAN BALASAN ENGINEER

        TenderClarification::create([

            'tender_id' => $tender->id,

            'vendor_id' => $vendor->id,

            'engineer_id' => Auth::id(),

            'sender_id' => Auth::id(),

            'message' => $request->message,

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

                'Balasan Klarifikasi',

                Auth::user()->name .
                    ' membalas pertanyaan teknis Anda'

            );
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
}
