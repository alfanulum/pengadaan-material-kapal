<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);

        return view('supply-chain.vendors.index', compact('vendors'));
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
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:30',
            'pic' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Vendor::create($request->all());

        return redirect()
            ->route('supply-chain.vendors.index')
            ->with('success', 'Data vendor berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
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
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:30',
            'pic' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $vendor->update($request->all());

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
}
