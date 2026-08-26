<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;

class MaterialRequestController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $search = $request->input('search');

        $query = MaterialRequest::with(['project', 'user', 'items'])
            ->whereIn('status', ['approved_planner', 'disetujui'])
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_pengajuan', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('project', fn($p) => $p->where('nama_project', 'like', "%{$search}%"))
                  ->orWhereHas('items', fn($i) => $i->where('nama_barang', 'like', "%{$search}%"));
            });
        }

        $materialRequests = $query->paginate(10)->withQueryString();

        $newRequests = MaterialRequest::with(['project', 'user', 'items'])
            ->whereIn('status', ['approved_planner', 'disetujui'])
            ->doesntHave('tender')
            ->latest()
            ->take(3)
            ->get();

        return view('supply-chain.material-requests.index', compact('materialRequests', 'newRequests', 'search'));
    }

    public function show($id)
    {
        $materialRequest = MaterialRequest::findOrFail($id);

        return view('supply-chain.material-requests.show', compact('materialRequest'));
    }
}
