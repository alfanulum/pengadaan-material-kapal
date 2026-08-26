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
    | Menampilkan semua vendor yang diundang pada tender ini
    |--------------------------------------------------------------------------
    */
    public function index($tenderId)
    {
        $tender = Tender::findOrFail($tenderId);

        // Ambil semua vendor yang diundang pada tender ini
        $selectedInvitations = TenderInvitation::with('vendor')
            ->where('tender_id', $tenderId)
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
        })->sortByDesc(function ($item) {
            $hasUnread = $item->unread > 0 ? 1 : 0;
            $timestamp = $item->last_message ? $item->last_message->created_at->timestamp : 0;
            return sprintf('%d_%010d', $hasUnread, $timestamp);
        });

        return view('supply-chain.chatnegosiasi.index', compact('tender', 'vendors', 'tenderId'));
    }

    /*
    |--------------------------------------------------------------------------
    | CHAT DETAIL PER VENDOR
    | Bisa diakses jika vendor tidak berstatus tidak_terpilih / ditolak
    |--------------------------------------------------------------------------
    */
    public function show($tenderId, $vendorId)
    {
        $tender = Tender::findOrFail($tenderId);
        $vendor = Vendor::findOrFail($vendorId);

        // Guard: pastikan vendor ini memang diundang pada tender ini
        $invitation = TenderInvitation::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->first();

        if (!$invitation) {
            abort(403, 'Vendor ini tidak diundang pada tender ini.');
        }

        if ($invitation->status === 'tidak_terpilih' || $invitation->status === 'ditolak') {
            abort(403, 'Vendor ini sudah dinyatakan tidak terpilih.');
        }

        $messages = TenderMessage::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->where('type', 'negotiation')
            ->orderBy('created_at', 'asc')
            ->get();

        // Ambil semua vendor yang diundang pada tender ini untuk sidebar
        $selectedInvitations = TenderInvitation::with('vendor')
            ->where('tender_id', $tenderId)
            ->get();

        // Buat koleksi vendor dengan info last message dan unread count
        $vendors = $selectedInvitations->map(function ($inv) use ($tenderId) {
            $v = $inv->vendor;

            $lastMessage = TenderMessage::where('tender_id', $tenderId)
                ->where('vendor_id', $v->id)
                ->where('type', 'negotiation')
                ->orderBy('created_at', 'desc')
                ->first();

            $unread = TenderMessage::where('tender_id', $tenderId)
                ->where('vendor_id', $v->id)
                ->where('type', 'negotiation')
                ->where('role', 'vendor')
                ->where('is_read', false)
                ->count();

            return (object) [
                'vendor'       => $v,
                'last_message' => $lastMessage,
                'unread'       => $unread,
            ];
        })->sortByDesc(function ($item) {
            $hasUnread = $item->unread > 0 ? 1 : 0;
            $timestamp = $item->last_message ? $item->last_message->created_at->timestamp : 0;
            return sprintf('%d_%010d', $hasUnread, $timestamp);
        });

        return view('supply-chain.chatnegosiasi.show', compact(
            'tender',
            'vendor',
            'messages',
            'vendors',
            'tenderId',
            'vendorId'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    | Supply Chain adalah pihak pertama — tidak ada batasan, SC bebas mengirim
    | Guard: tidak boleh kirim ke vendor yang sudah tidak terpilih
    |--------------------------------------------------------------------------
    */
    public function send(
        Request $request,
        $tenderId,
        $vendorId,
        FirebaseService $firebase
    ) {
        // Guard: pastikan vendor ini diundang pada tender ini
        $invitation = TenderInvitation::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->first();

        if (!$invitation) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Vendor tidak diundang pada tender ini.'], 403);
            }
            abort(403, 'Vendor tidak diundang pada tender ini.');
        }

        if ($invitation->status === 'tidak_terpilih' || $invitation->status === 'ditolak') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Vendor sudah dinyatakan tidak terpilih.'], 403);
            }
            abort(403, 'Vendor ini sudah dinyatakan tidak terpilih.');
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

        $messageModel = TenderMessage::create([
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
                try {
                    $firebase->sendNotification(
                        $user->fcm_token,
                        'Negosiasi dari ' . Auth::user()->name,
                        $request->hasFile('attachment') ? '📷 Mengirim gambar' : \Illuminate\Support\Str::limit($request->message, 80),
                        $attachmentPath ? asset('storage/' . $attachmentPath) : null
                    );
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Firebase Negotiation SC Error: ' . $e->getMessage());
                }
            }
        }

        // Return JSON for AJAX requests (no page reload)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => 'ok', 
                'message' => 'Pesan terkirim',
                'data' => [
                    'id'             => $messageModel->id,
                    'sender_id'      => $messageModel->sender_id,
                    'message'        => $messageModel->message,
                    'attachment_url' => $messageModel->attachment ? asset('storage/' . $messageModel->attachment) : null,
                    'role'           => 'me',
                    'sender_name'    => 'Supply Chain (Anda)',
                    'time'           => $messageModel->created_at->format('H:i'),
                    'is_read'        => $messageModel->is_read,
                ]
            ]);
        }

        return back();
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX: GET MESSAGES (for real-time polling)
    | Guard: vendor aktif
    |--------------------------------------------------------------------------
    */
    public function messagesAjax($tenderId, $vendorId)
    {
        // Guard: pastikan vendor ini diundang pada tender ini
        $invitation = TenderInvitation::where('tender_id', $tenderId)
            ->where('vendor_id', $vendorId)
            ->first();

        if (!$invitation) {
            abort(403, 'Vendor tidak diundang pada tender ini.');
        }

        if ($invitation->status === 'tidak_terpilih' || $invitation->status === 'ditolak') {
            abort(403, 'Vendor ini sudah dinyatakan tidak terpilih.');
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

        return response()->json(['data' => $messages]);
    }
}
