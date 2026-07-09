<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $materialRequests = MaterialRequest::where('user_id', Auth::id())->get();

        $stats = [
            'total' => $materialRequests->count(),
            'menunggu' => $materialRequests->where('status', 'menunggu_persetujuan')->count(),
            'disetujui' => $materialRequests->whereIn('status', ['disetujui_planner', 'tender_dibuat', 'po_diterbitkan', 'selesai'])->count(),
        ];

        return view('dashboards.engineer', compact('stats'));
    }
}
