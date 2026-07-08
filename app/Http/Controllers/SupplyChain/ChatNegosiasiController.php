<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use App\Models\TenderMessage;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;
use App\Models\User;

class ChatNegosiasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST VENDOR CHAT PER TENDER (INBOX STYLE)
    |--------------------------------------------------------------------------
    */
    public function index($tenderId)
    {
        $tender = Tender::findOrFail($tenderId);

        $vendors = TenderMessage::with('vendor')
            ->where('tender_id', $tenderId)
            ->where('type', 'negotiation')
            ->select('vendor_id')
            ->groupBy('vendor_id')
            ->get();

        return view('supply-chain.chatnegosiasi.index', compact('tender', 'vendors', 'tenderId'));
    }

    /*
    |--------------------------------------------------------------------------
    | CHAT DETAIL PER VENDOR
    |--------------------------------------------------------------------------
    */
    public function show($tenderId, $vendorId)
    {
        $tender = Tender::findOrFail($tenderId);
        $vendor = Vendor::findOrFail($vendorId);

        $messages = TenderMessage::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->where('type', 'negotiation')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('supply-chain.chatnegosiasi.show', compact(
            'tender',
            'vendor',
            'messages',
            'tenderId',
            'vendorId'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */
    public function send(
        Request $request,
        $tenderId,
        $vendorId,
        FirebaseService $firebase
    ) {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);


        // SIMPAN PESAN
        TenderMessage::create([
            'tender_id' => $tenderId,
            'vendor_id' => $vendorId,
            'sender_id' => Auth::id(),
            'role' => 'supply_chain',
            'type' => 'negotiation',
            'message' => $request->message,
            'is_read' => false
        ]);


        /*
    |--------------------------------------------------------------------------
    | FIREBASE NOTIFICATION KE VENDOR
    |--------------------------------------------------------------------------
    */


        $vendor = Vendor::find($vendorId);


        if ($vendor && $vendor->user_id) {

            $user = User::find($vendor->user_id);


            if ($user && $user->fcm_token) {

                $firebase->sendNotification(
                    $user->fcm_token,
                    'Pesan Negosiasi Baru',
                    Auth::user()->name .
                        ' mengirim pesan negosiasi'
                );
            }
        }


        return back();
    }
}
