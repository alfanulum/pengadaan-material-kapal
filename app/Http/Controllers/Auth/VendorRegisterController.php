<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class VendorRegisterController extends Controller
{
    /**
     * Tampilkan form registrasi Vendor.
     */
    public function create(): View
    {
        return view('auth.vendor-register');
    }

    /**
     * Proses registrasi Vendor mandiri.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_vendor'   => ['required', 'string', 'max:255'],
            'pic'           => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'telepon'       => ['required', 'string', 'max:30'],
            'alamat'        => ['required', 'string'],
            'kategori'      => ['nullable', 'string', 'max:255'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama_vendor.required'  => 'Nama perusahaan wajib diisi.',
            'nama_vendor.max'       => 'Nama perusahaan maksimal 255 karakter.',
            'pic.required'          => 'Nama PIC / penanggung jawab wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan. Gunakan email lain atau login jika sudah memiliki akun.',
            'telepon.required'      => 'Nomor telepon wajib diisi.',
            'alamat.required'       => 'Alamat perusahaan wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Password dan konfirmasi password tidak sesuai.',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat akun User dengan role vendor
            $user = User::create([
                'name'      => $request->nama_vendor,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'role'      => 'vendor',
            ]);

            event(new Registered($user));

            // 2. Buat data Vendor yang terhubung dengan User
            Vendor::create([
                'user_id'           => $user->id,
                'kode_vendor'       => 'TMP-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'nama_vendor'       => $request->nama_vendor,
                'email'             => $request->email,
                'telepon'           => $request->telepon,
                'pic'               => $request->pic,
                'alamat'            => $request->alamat,
                'kategori'          => $request->kategori,
                'status'            => 'nonaktif', // nonaktif sampai disetujui
                'status_registrasi' => 'menunggu', // menunggu verifikasi Supply Chain
                'tanggal_daftar'    => now(),
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi Vendor berhasil dikirim. Akun Anda sedang menunggu verifikasi dari Supply Chain. Silakan login untuk memantau status registrasi Anda.');
    }
}
