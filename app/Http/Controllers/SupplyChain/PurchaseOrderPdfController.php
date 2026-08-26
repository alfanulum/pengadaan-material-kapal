<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderPdfController extends Controller
{
    /**
     * Unduh Dokumen Purchase Order dalam format PDF (untuk Supply Chain).
     */
    public function download(PurchaseOrder $purchaseOrder)
    {
        // Load semua relasi yang diperlukan untuk dokumen PDF
        $purchaseOrder->load([
            'tender.materialRequest.project',
            'tender.materialRequest.items',
            'vendor',
            'quotation',
            'items',
            'pembuatPo',
        ]);

        $pdf = Pdf::loadView('supply-chain.purchase-orders.pdf', [
            'po' => $purchaseOrder,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $kodePo   = $purchaseOrder->kode_po ?? 'PO';
        $filename = 'purchase-order-' . $kodePo . '.pdf';

        return $pdf->download($filename);
    }
}
