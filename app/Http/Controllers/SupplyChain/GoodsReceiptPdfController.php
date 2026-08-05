<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class GoodsReceiptPdfController extends Controller
{
    /**
     * Unduh laporan penerimaan material dalam format PDF.
     */
    public function download(GoodsReceipt $goodsReceipt): Response|\Symfony\Component\HttpFoundation\Response
    {
        // Load semua relasi yang diperlukan untuk PDF
        $goodsReceipt->load([
            'purchaseOrder.vendor',
            'purchaseOrder.tender.materialRequest.project',
            'purchaseOrder.items',
            'photos',
            'creator',
        ]);

        // Siapkan foto untuk PDF — filter hanya yang file-nya ada
        $photos = $goodsReceipt->photos->filter(function ($photo) {
            try {
                $path = Storage::disk('public')->path($photo->file_path);
                return file_exists($path) && is_readable($path);
            } catch (\Throwable $e) {
                return false;
            }
        })->values();

        $photoData = $photos->map(function ($photo) {
            try {
                $path    = Storage::disk('public')->path($photo->file_path);
                $content = file_get_contents($path);
                $mime    = mime_content_type($path);
                return [
                    'base64'     => 'data:' . $mime . ';base64,' . base64_encode($content),
                    'keterangan' => $photo->keterangan ?? '',
                ];
            } catch (\Throwable $e) {
                return null;
            }
        })->filter()->values();

        $pdf = Pdf::loadView('supply-chain.goods-receipt-reports.pdf', [
            'receipt'   => $goodsReceipt,
            'photoData' => $photoData,
        ]);

        $pdf->setPaper('a4', 'portrait');

        // Nama file: laporan-penerimaan-[kode-po]-[tanggal].pdf
        $kodePo   = $goodsReceipt->purchaseOrder->kode_po ?? 'PO';
        $tanggal  = $goodsReceipt->tanggal_diterima
            ? $goodsReceipt->tanggal_diterima->format('d-m-Y')
            : now()->format('d-m-Y');

        $filename = 'laporan-penerimaan-' . $kodePo . '-' . $tanggal . '.pdf';

        return $pdf->download($filename);
    }
}
