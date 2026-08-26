<?php

namespace App\Http\Controllers\Gudang;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
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

        // Daftar PO
        $query = PurchaseOrder::with(['vendor', 'tender', 'items', 'goodsReceipt'])
            ->whereIn('status', ['dikirim', 'diterima_gudang', 'selesai', 'retur', 'penggantian_vendor', 'menunggu_tindak_lanjut']);

        $search = $request->input('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_po', 'like', "%{$search}%")
                  ->orWhereHas('vendor', function($q) use ($search) {
                      $q->where('nama_vendor', 'like', "%{$search}%");
                  })
                  ->orWhereHas('tender', function($q) use ($search) {
                      $q->where('nama_tender', 'like', "%{$search}%");
                  });
            });
        }

        $filterStatus = $request->input('filter_status');
        if ($filterStatus) {
            if ($filterStatus === 'menunggu_penerimaan') {
                $query->where('status', 'dikirim')->whereDoesntHave('goodsReceipt');
            } elseif ($filterStatus === 'telah_diperiksa') {
                $query->whereHas('goodsReceipt');
            } elseif ($filterStatus === 'kondisi_bermasalah') {
                $query->whereHas('goodsReceipt', function ($q) {
                    $q->whereIn('kondisi_barang', ['kerusakan', 'tidak_sesuai_spesifikasi']);
                });
            } elseif ($filterStatus === 'menunggu_resolusi') {
                $query->whereHas('goodsReceipt', function ($q) {
                    $q->where('status_penerimaan', 'menunggu_tindak_lanjut');
                });
            }
        }

        $purchaseOrders = $query->orderBy('updated_at', 'desc')->paginate(10)->withQueryString();

        return view('dashboards.gudang', compact(
            'poMenunggu',
            'poSudahDiterima',
            'poMasalah',
            'purchaseOrders'
        ));
    }
}


