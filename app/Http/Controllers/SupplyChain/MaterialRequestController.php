<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $materialRequests = MaterialRequest::with(['project', 'user', 'items'])
            ->whereIn('status', ['approved_planner', 'disetujui'])
            ->latest()
            ->paginate(10);

        return view('supply-chain.material-requests.index', compact('materialRequests'));
    }

    public function show($id)
    {
        $materialRequest = MaterialRequest::findOrFail($id);

        return view('supply-chain.material-requests.show', compact('materialRequest'));
    }
}
