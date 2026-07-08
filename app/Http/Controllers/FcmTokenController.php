<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FcmTokenController extends Controller
{
    /**
     * Simpan FCM token ke user yang sedang login.
     */
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        Auth::user()->update([
            'fcm_token' => $request->token,
        ]);

        return response()->json(['status' => 'ok']);
    }
}
