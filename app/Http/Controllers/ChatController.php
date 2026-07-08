<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TenderMessage;
use App\Models\Vendor;
use App\Models\TenderInvitation;

class ChatController extends Controller
{
    /**
     * OPEN CHAT (GROUP BY TENDER + TYPE)
     */
    public function index($invitationId, $type)
    {
        $vendor = Vendor::where('user_id', Auth::id())->first();

        $invitation = TenderInvitation::where('id', $invitationId)
            ->where('vendor_id', $vendor->id)
            ->firstOrFail();

        // GROUP CHAT PER TENDER + TYPE
        $messages = TenderMessage::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->where('type', $type)
            ->orderBy('created_at')
            ->get();

        // AUTO MARK AS READ
        TenderMessage::where('tender_id', $invitation->tender_id)
            ->where('vendor_id', $vendor->id)
            ->where('type', $type)
            ->where('sender_id', '!=', Auth::id())
            ->update(['is_read' => true]);

        return view('chat.index', compact('messages', 'invitation', 'type'));
    }

    /**
     * SEND MESSAGE
     */
    public function send(Request $request, $invitationId, $type)
    {
        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->first();

        $invitation = TenderInvitation::where('id', $invitationId)
            ->where('vendor_id', $vendor->id)
            ->firstOrFail();

        TenderMessage::create([
            'tender_id' => $invitation->tender_id,
            'vendor_id' => $vendor->id,
            'sender_id' => Auth::id(),
            'role' => 'vendor',
            'type' => $type, // clarification / negotiation
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back();
    }
}
