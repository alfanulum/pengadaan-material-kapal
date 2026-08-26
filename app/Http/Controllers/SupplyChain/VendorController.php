<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::with('user')->latest();

        // Filter berdasarkan tab status registrasi
        $filterStatus = $request->input('filter', 'semua');
        if ($filterStatus === 'menunggu') {
            $query->where('status_registrasi', 'menunggu');
        } elseif ($filterStatus === 'disetujui') {
            $query->where('status_registrasi', 'disetujui');
        } elseif ($filterStatus === 'ditolak') {
            $query->where('status_registrasi', 'ditolak');
        }

        // Filter berdasarkan search keyword
        $search = $request->input('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_vendor', 'like', "%{$search}%")
                  ->orWhere('nama_vendor', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('pic', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $vendors = $query->paginate(15)->withQueryString();

        // Hitung jumlah per status
        $counts = [
            'semua'    => Vendor::count(),
            'menunggu' => Vendor::where('status_registrasi', 'menunggu')->count(),
            'disetujui'=> Vendor::where('status_registrasi', 'disetujui')->count(),
            'ditolak'  => Vendor::where('status_registrasi', 'ditolak')->count(),
        ];

        return view('supply-chain.vendors.index', compact('vendors', 'filterStatus', 'counts', 'search'));
    }

    public function create()
    {
        return view('supply-chain.vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_vendor' => 'required|string|max:50|unique:vendors,kode_vendor',
            'nama_vendor' => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'telepon'     => 'nullable|string|max:30',
            'pic'         => 'nullable|string|max:255',
            'alamat'      => 'nullable|string',
            'kategori'    => 'nullable|string|max:255',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        // Vendor yang dibuat Supply Chain langsung disetujui
        Vendor::create(array_merge($request->all(), [
            'status_registrasi'  => 'disetujui',
            'tanggal_daftar'     => now(),
            'tanggal_verifikasi' => now(),
            'id_verifikator'     => Auth::id(),
        ]));

        return redirect()
            ->route('supply-chain.vendors.index')
            ->with('success', 'Data vendor berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['user', 'verifikator']);
        return view('supply-chain.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('supply-chain.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $request->validate([
            'kode_vendor' => 'required|string|max:50|unique:vendors,kode_vendor,' . $vendor->id,
            'nama_vendor' => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'telepon'     => 'nullable|string|max:30',
            'pic'         => 'nullable|string|max:255',
            'alamat'      => 'nullable|string',
            'kategori'    => 'nullable|string|max:255',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $vendor->update($request->only([
            'kode_vendor', 'nama_vendor', 'email', 'telepon',
            'pic', 'alamat', 'kategori', 'status',
        ]));

        return redirect()
            ->route('supply-chain.vendors.index')
            ->with('success', 'Data vendor berhasil diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()
            ->route('supply-chain.vendors.index')
            ->with('success', 'Data vendor berhasil dihapus.');
    }

    /**
     * Setujui registrasi Vendor.
     */
    public function approve(Vendor $vendor)
    {
        if ($vendor->status_registrasi !== 'menunggu') {
            return redirect()
                ->route('supply-chain.vendors.show', $vendor)
                ->with('error', 'Vendor tidak dalam status menunggu verifikasi.');
        }

        // Generate kode vendor permanen jika masih kode sementara (TMP-xxxx)
        $kodeVendor = $vendor->kode_vendor;
        if (str_starts_with($kodeVendor, 'TMP-')) {
            $lastVendor = Vendor::where('kode_vendor', 'like', 'VDR-%')
                ->orderByDesc('kode_vendor')
                ->first();

            $nextNumber = 1;
            if ($lastVendor) {
                $lastNumber = (int) str_replace('VDR-', '', $lastVendor->kode_vendor);
                $nextNumber = $lastNumber + 1;
            }
            $kodeVendor = 'VDR-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        }

        $vendor->update([
            'kode_vendor'        => $kodeVendor,
            'status'             => 'aktif',
            'status_registrasi'  => 'disetujui',
            'alasan_penolakan'   => null,
            'tanggal_verifikasi' => now(),
            'id_verifikator'     => Auth::id(),
        ]);

        return redirect()
            ->route('supply-chain.vendors.show', $vendor)
            ->with('success', 'Registrasi Vendor berhasil disetujui.');
    }

    /**
     * Tolak registrasi Vendor.
     */
    public function reject(Request $request, Vendor $vendor)
    {
        $request->validate([
            'alasan_penolakan' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.min'      => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $vendor->update([
            'status'             => 'nonaktif',
            'status_registrasi'  => 'ditolak',
            'alasan_penolakan'   => $request->alasan_penolakan,
            'tanggal_verifikasi' => now(),
            'id_verifikator'     => Auth::id(),
        ]);

        return redirect()
            ->route('supply-chain.vendors.show', $vendor)
            ->with('success', 'Registrasi Vendor berhasil ditolak.');
    }

    /**
     * Vendor memperbaiki data registrasi yang ditolak.
     * Diakses oleh Vendor yang ditolak melalui route vendor.resubmit.store
     */
    public function resubmit(Request $request)
    {
        $vendor = Vendor::where('user_id', Auth::id())->first();

        if (!$vendor || $vendor->status_registrasi !== 'ditolak') {
            return redirect()->route('vendor.dashboard')->with('error', 'Hanya vendor yang ditolak yang dapat memperbaiki data.');
        }

        $request->validate([
            'nama_vendor' => ['required', 'string', 'max:255'],
            'pic'         => ['required', 'string', 'max:255'],
            'telepon'     => ['required', 'string', 'max:30'],
            'alamat'      => ['required', 'string'],
            'kategori'    => ['nullable', 'string', 'max:255'],
        ], [
            'nama_vendor.required' => 'Nama perusahaan wajib diisi.',
            'pic.required'         => 'Nama PIC wajib diisi.',
            'telepon.required'     => 'Nomor telepon wajib diisi.',
            'alamat.required'      => 'Alamat wajib diisi.',
        ]);

        $vendor->update([
            'nama_vendor'        => $request->nama_vendor,
            'pic'                => $request->pic,
            'telepon'            => $request->telepon,
            'alamat'             => $request->alamat,
            'kategori'           => $request->kategori,
            'status_registrasi'  => 'menunggu',
            'alasan_penolakan'   => null,
            'tanggal_verifikasi' => null,
            'id_verifikator'     => null,
        ]);

        return redirect()
            ->route('vendor.dashboard')
            ->with('success', 'Data registrasi Anda telah diperbaiki dan dikirim ulang. Silakan tunggu verifikasi dari Supply Chain.');
    }
}
