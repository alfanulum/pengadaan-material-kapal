<?php

namespace App\Http\Controllers\SupplyChain;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Menampilkan daftar PO yang sedang dipantau.
     */
    public function index()
    {
        // Tampilkan PO yang tidak di-archive
        $purchaseOrders = PurchaseOrder::with([
            'vendor',
            'tender.materialRequest.project',
            'items',
            'goodsReceipt'
        ])
        ->where('is_archived', false)
        ->latest()
        ->paginate(15);

        return view('supply-chain.monitoring.index', compact('purchaseOrders'));
    }

    /**
     * Menampilkan detail tracking (timeline).
     */
    public function show($id)
    {
        $po = PurchaseOrder::with([
            'vendor',
            'tender.materialRequest.project',
            'items',
            'goodsReceipt'
        ])->findOrFail($id);

        return view('supply-chain.monitoring.show', compact('po'));
    }

    /**
     * Menampilkan form edit tanggal/status jika diperlukan.
     */
    public function edit($id)
    {
        $po = PurchaseOrder::with(['goodsReceipt'])->findOrFail($id);
        
        return view('supply-chain.monitoring.edit', compact('po'));
    }

    /**
     * Menyimpan perubahan tanggal/status.
     */
    public function update(Request $request, $id)
    {
        $po = PurchaseOrder::findOrFail($id);
        
        $request->validate([
            'tanggal_pengiriman' => 'nullable|date',
            'tanggal_diterima'   => 'nullable|date',
        ]);

        // Update PO
        if ($request->has('tanggal_pengiriman')) {
            $po->tanggal_pengiriman = $request->tanggal_pengiriman;
            $po->save();
        }

        // Update Goods Receipt
        if ($po->goodsReceipt && $request->has('tanggal_diterima') && $request->tanggal_diterima) {
            $po->goodsReceipt->tanggal_diterima = $request->tanggal_diterima;
            $po->goodsReceipt->save();
        }

        return redirect()->route('supply-chain.monitoring.show', $po->id)
            ->with('success', 'Data monitoring berhasil diperbarui.');
    }

    /**
     * Mengarsipkan monitoring (Hapus Monitoring).
     */
    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        
        // Cek apakah barang sudah diterima
        if ($po->status !== 'selesai' && $po->status !== 'diterima_gudang' && !$po->goodsReceipt) {
            return redirect()->back()->with('error', 'Hanya PO yang sudah diterima gudang yang bisa dihapus dari riwayat.');
        }

        $po->is_archived = true;
        $po->save();

        return redirect()->route('supply-chain.monitoring.index')
            ->with('success', 'Riwayat monitoring pengadaan berhasil dihapus/diarsipkan.');
    }
}
