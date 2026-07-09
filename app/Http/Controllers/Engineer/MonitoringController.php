<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    /**
     * Menampilkan daftar kebutuhan material yang sudah masuk tahap procurement (PO).
     */
    public function index()
    {
        $purchaseOrders = \App\Models\PurchaseOrder::whereHas('tender.materialRequest', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->with([
            'vendor',
            'tender.materialRequest.project',
            'items',
            'goodsReceipt'
        ])
        ->where('is_archived', false)
        ->latest()
        ->paginate(15);

        return view('engineer.monitoring.index', compact('purchaseOrders'));
    }

    /**
     * Menampilkan detail tracking timeline procurement.
     */
    public function show($id)
    {
        $po = \App\Models\PurchaseOrder::whereHas('tender.materialRequest', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->with([
            'vendor',
            'tender.materialRequest.project',
            'items',
            'goodsReceipt'
        ])
        ->findOrFail($id);

        return view('engineer.monitoring.show', compact('po'));
    }
}
