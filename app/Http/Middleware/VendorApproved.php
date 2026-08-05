<?php

namespace App\Http\Middleware;

use App\Models\Vendor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VendorApproved
{
    /**
     * Lindungi route vendor — hanya vendor yang sudah disetujui yang boleh akses.
     * Vendor yang belum disetujui (menunggu/ditolak) diarahkan ke dashboard dengan pesan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'vendor') {
            return redirect()->route('dashboard');
        }

        $vendor = Vendor::where('user_id', $user->id)->first();

        if (!$vendor) {
            return redirect()->route('login')->with('error', 'Data Vendor tidak ditemukan.');
        }

        if ($vendor->status_registrasi === 'disetujui') {
            return $next($request);
        }

        // Vendor belum disetujui — arahkan ke dashboard dengan pesan
        return redirect()
            ->route('vendor.dashboard')
            ->with('error', 'Akun Anda belum disetujui oleh Supply Chain.');
    }
}
