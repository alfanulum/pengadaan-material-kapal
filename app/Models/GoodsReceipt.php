<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'tanggal_diterima',
        'jumlah_diterima',
        'kondisi_barang',
        'catatan_gudang',
        'detail_permasalahan',
        'jumlah_rusak',
        'tindakan_selanjutnya',
        'status_penerimaan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_diterima' => 'date',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function photos()
    {
        return $this->hasMany(GoodsReceiptPhoto::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getKondisiLabelAttribute(): string
    {
        return match ($this->kondisi_barang) {
            'sesuai'                    => 'Diterima Sesuai Pesanan',
            'diterima_dengan_catatan'   => 'Diterima Dengan Catatan',
            'kerusakan'                 => 'Barang Mengalami Kerusakan/Cacat',
            'tidak_sesuai_spesifikasi'  => 'Tidak Sesuai Spesifikasi',
            default                     => ucfirst(str_replace('_', ' ', $this->kondisi_barang)),
        };
    }

    public function getTindakanLabelAttribute(): string
    {
        if (!$this->tindakan_selanjutnya) return '-';
        return match ($this->tindakan_selanjutnya) {
            'terima_dengan_catatan' => 'Terima Barang dengan Catatan',
            'minta_penggantian'     => 'Minta Penggantian Barang kepada Vendor',
            'retur_sebagian'        => 'Retur Sebagian Barang',
            'tolak_barang'          => 'Tolak Barang',
            default                 => ucfirst(str_replace('_', ' ', $this->tindakan_selanjutnya)),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_penerimaan) {
            'diterima_sesuai'         => 'Diterima Sesuai',
            'diterima_dengan_catatan' => 'Diterima Dengan Catatan',
            'menunggu_tindak_lanjut'  => 'Menunggu Tindak Lanjut',
            'retur_barang'            => 'Retur Barang',
            'penggantian_vendor'      => 'Penggantian Vendor',
            default                   => ucfirst(str_replace('_', ' ', $this->status_penerimaan)),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status_penerimaan) {
            'diterima_sesuai'         => 'bg-emerald-100 text-emerald-700',
            'diterima_dengan_catatan' => 'bg-yellow-100 text-yellow-700',
            'menunggu_tindak_lanjut'  => 'bg-orange-100 text-orange-700',
            'retur_barang'            => 'bg-red-100 text-red-700',
            'penggantian_vendor'      => 'bg-purple-100 text-purple-700',
            default                   => 'bg-slate-100 text-slate-700',
        };
    }
}
