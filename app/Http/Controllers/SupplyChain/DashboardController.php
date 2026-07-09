<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_po' => \App\Models\PurchaseOrder::count(),
            'diproses' => \App\Models\PurchaseOrder::where('status', 'diproses')->count(),
            'dikirim'  => \App\Models\PurchaseOrder::where('status', 'dikirim')->count(),
            'selesai'  => \App\Models\PurchaseOrder::where('status', 'selesai')->count(),
        ];

        return view('dashboards.supply', compact('stats'));
    }
}