<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\GoodsReceipt;
use App\Models\PurchaseOrder;

class GoodsReceiptController extends Controller
{
    /**
     * Daftar seluruh laporan penerimaan barang yang dilaporkan gudang.
     */
    public function index()
    {
        $goodsReceipts = GoodsReceipt::with([
            'purchaseOrder.vendor',
            'purchaseOrder.tender.materialRequest.project',
            'purchaseOrder.items',
            'photos',
            'creator',
        ])
        ->latest()
        ->paginate(15);

        $stats = [
            'total'               => GoodsReceipt::count(),
            'diterima_sesuai'     => GoodsReceipt::where('status_penerimaan', 'diterima_sesuai')->count(),
            'bermasalah'          => GoodsReceipt::whereIn('kondisi_barang', ['kerusakan', 'tidak_sesuai_spesifikasi'])->count(),
            'tindak_lanjut'       => GoodsReceipt::where('status_penerimaan', 'menunggu_tindak_lanjut')->count(),
        ];

        return view('supply-chain.goods-receipts.index', compact('goodsReceipts', 'stats'));
    }

    /**
     * Detail satu laporan penerimaan barang.
     */
    public function show(GoodsReceipt $goodsReceipt)
    {
        $goodsReceipt->load([
            'purchaseOrder.vendor',
            'purchaseOrder.tender.materialRequest.project',
            'purchaseOrder.items',
            'photos',
            'creator',
        ]);

        return view('supply-chain.goods-receipts.show', compact('goodsReceipt'));
    }
}
