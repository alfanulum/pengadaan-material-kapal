<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\TenderMessage;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EngineerChatController extends Controller
{
    public function index(Tender $tender)
    {
        $messages = TenderMessage::where('tender_id', $tender->id)
            ->orderBy('created_at')
            ->get();

        return view('engineer.chat.index', compact('tender', 'messages'));
    }

    public function send(Request $request, Tender $tender)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        TenderMessage::create([
            'tender_id' => $tender->id,
            'vendor_id' => null,
            'sender_id' => Auth::id(),
            'role' => 'engineer',
            'type' => 'clarification',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back();
    }
}
