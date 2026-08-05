<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use App\Models\TenderMessage;
use App\Models\TenderInvitation;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;
use App\Models\User;

class ChatNegosiasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST VENDOR CHAT PER TENDER (INBOX STYLE)
    | Hanya menampilkan vendor yang penawarannya sudah dipilih (invitation status = 'terpilih')
    |--------------------------------------------------------------------------
    */
    public function index($tenderId)
    {
        $tender = Tender::findOrFail($tenderId);

        // Ambil vendor terpilih berdasarkan status invitation 'terpilih', bukan dari pesan
        $selectedInvitations = TenderInvitation::with('vendor')
            ->where('tender_id', $tenderId)
            ->where('status', 'terpilih')
            ->get();

        // Buat koleksi vendor dengan info last message dan unread count
        $vendors = $selectedInvitations->map(function ($invitation) use ($tenderId) {
            $vendor = $invitation->vendor;

            $lastMessage = TenderMessage::where('tender_id', $tenderId)
                ->where('vendor_id', $vendor->id)
                ->where('type', 'negotiation')
                ->orderBy('created_at', 'desc')
                ->first();

            $unread = TenderMessage::where('tender_id', $tenderId)
                ->where('vendor_id', $vendor->id)
                ->where('type', 'negotiation')
                ->where('role', 'vendor')
                ->where('is_read', false)
                ->count();

            return (object) [
                'vendor'       => $vendor,
                'last_message' => $lastMessage,
                'unread'       => $unread,
            ];
        });

        return view('supply-chain.chatnegosiasi.index', compact('tender', 'vendors', 'tenderId'));
    }

    /*
    |--------------------------------------------------------------------------
    | CHAT DETAIL PER VENDOR
    | Hanya vendor terpilih yang boleh dibuka
    |--------------------------------------------------------------------------
    */
    public function show($tenderId, $vendorId)
    {
        $tender = Tender::findOrFail($tenderId);
        $vendor = Vendor::findOrFail($vendorId);

        // Guard: pastikan vendor ini memang terpilih pada tender ini
        $invitation = TenderInvitation::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->where('status', 'terpilih')
            ->first();

        if (!$invitation) {
            abort(403, 'Vendor ini tidak terpilih pada tender ini.');
        }

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
    | Supply Chain adalah pihak pertama — tidak ada batasan, SC bebas mengirim
    | Guard: hanya boleh kirim ke vendor terpilih
    |--------------------------------------------------------------------------
    */
    public function send(
        Request $request,
        $tenderId,
        $vendorId,
        FirebaseService $firebase
    ) {
        // Guard: pastikan vendor ini terpilih pada tender ini
        $invitation = TenderInvitation::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->where('status', 'terpilih')
            ->first();

        if (!$invitation) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Vendor tidak terpilih pada tender ini.'], 403);
            }
            abort(403, 'Vendor tidak terpilih pada tender ini.');
        }

        $request->validate([
            'message'    => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ]);
        if (!$request->message && !$request->hasFile('attachment')) {
            return back()->with('error', 'Pesan atau gambar harus diisi');
        }

        $attachmentPath = $request->hasFile('attachment')
            ? $request->file('attachment')->store('chat_attachments', 'public')
            : null;

        TenderMessage::create([
            'tender_id'  => $tenderId,
            'vendor_id'  => $vendorId,
            'sender_id'  => Auth::id(),
            'role'       => 'supply_chain',
            'type'       => 'negotiation',
            'message'    => $request->message,
            'attachment' => $attachmentPath,
            'is_read'    => false,
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
                    'Negosiasi dari ' . Auth::user()->name,
                    $request->hasFile('attachment') ? '📷 Mengirim gambar' : \Illuminate\Support\Str::limit($request->message, 80),
                    $attachmentPath ? asset('storage/' . $attachmentPath) : null
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
    | Guard: hanya vendor terpilih
    |--------------------------------------------------------------------------
    */
    public function messagesAjax($tenderId, $vendorId)
    {
        // Guard: pastikan vendor ini terpilih pada tender ini
        $invitation = TenderInvitation::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->where('status', 'terpilih')
            ->first();

        if (!$invitation) {
            abort(403, 'Vendor tidak terpilih pada tender ini.');
        }

        $messages = TenderMessage::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->where('type', 'negotiation')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($msg) use ($vendorId) {
                return [
                    'id'             => $msg->id,
                    'sender_id'      => $msg->sender_id,
                    'message'        => $msg->message,
                    'attachment_url' => $msg->attachment ? asset('storage/' . $msg->attachment) : null,
                    'role'           => $msg->sender_id == auth()->id() ? 'me' : 'other',
                    'sender_name'    => $msg->role === 'supply_chain' ? 'Supply Chain (Anda)' : 'Vendor',
                    'time'           => $msg->created_at->format('d M H:i'),
                ];
            });

        return response()->json(['messages' => $messages]);
    }
}
