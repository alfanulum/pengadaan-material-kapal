<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\TenderMessage;
use App\Models\TenderInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;

class VendorChatController extends Controller
{
    public function index(TenderInvitation $invitation)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        abort_if($invitation->vendor_id !== $vendor->id, 403);

        $messages = TenderMessage::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->orderBy('created_at')
            ->get();

        return view('vendor.chat.index', compact('invitation', 'messages'));
    }

    public function send(Request $request, TenderInvitation $invitation)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        abort_if($invitation->vendor_id !== $vendor->id, 403);

        TenderMessage::create([
            'tender_id' => $invitation->tender_id,
            'vendor_id' => $vendor->id,
            'sender_id' => Auth::id(),
            'role' => 'vendor',
            'type' => 'clarification',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back();
    }
}
