<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // PO yang dikirim / sudah sampai tapi belum ada goods receipt
        $poMenunggu = PurchaseOrder::where('status', 'dikirim')
            ->whereDoesntHave('goodsReceipt')
            ->count();

        // PO yang sudah memiliki goods receipt
        $poSudahDiterima = GoodsReceipt::count();

        // Barang bermasalah
        $poMasalah = GoodsReceipt::whereIn('kondisi_barang', ['kerusakan', 'tidak_sesuai_spesifikasi'])->count();

        // Perlu tindak lanjut (masih menunggu)
        $perluTindakLanjut = GoodsReceipt::where('status_penerimaan', 'menunggu_tindak_lanjut')->count();

        // Daftar PO
        $purchaseOrders = PurchaseOrder::with(['vendor', 'tender', 'items', 'goodsReceipt'])
            ->whereIn('status', ['dikirim', 'diterima_gudang', 'selesai'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('dashboards.gudang', compact(
            'poMenunggu',
            'poSudahDiterima',
            'poMasalah',
            'perluTindakLanjut',
            'purchaseOrders'
        ));
    }
}
