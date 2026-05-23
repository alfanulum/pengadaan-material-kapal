<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $purchaseOrders = PurchaseOrder::with([
            'tender.materialRequest.project',
            'vendor',
            'items',
        ])
            ->where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(10);

        return view('vendor.purchase-orders.index', compact('vendor', 'purchaseOrders'));
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        if ($purchaseOrder->vendor_id !== $vendor->id) {
            abort(403);
        }

        $purchaseOrder->load([
            'tender.materialRequest.project',
            'tender.materialRequest.user',
            'vendor',
            'quotation',
            'items',
        ]);

        return view('vendor.purchase-orders.show', compact('vendor', 'purchaseOrder'));
    }
}
