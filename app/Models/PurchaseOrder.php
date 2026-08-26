<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'kode_po',
        'tender_id',
        'vendor_id',
        'vendor_quotation_id',
        'tanggal_po',
        'tanggal_pengiriman',
        'deadline_pengiriman',
        'total_harga',
        'catatan',
        'status',
        'is_archived',
        'dibuat_oleh',
        'tanggal_pengunduran_diri',
        'alasan_pengunduran_diri',
    ];

    protected $casts = [
        'tanggal_pengunduran_diri' => 'datetime',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function quotation()
    {
        return $this->belongsTo(VendorQuotation::class, 'vendor_quotation_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function goodsReceipt()
    {
        return $this->hasOne(GoodsReceipt::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    /**
     * Staf Supply Chain yang membuat Purchase Order ini.
     */
    public function pembuatPo()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /**
     * Cek apakah Vendor masih diizinkan mengundurkan diri dari PO ini.
     *
     * Vendor hanya boleh mundur apabila:
     * 1. Status PO masih 'dikirim_ke_vendor' (belum ada pengiriman)
     * 2. Vendor belum pernah mengundurkan diri (tanggal_pengunduran_diri masih null)
     */
    public function canVendorWithdraw(): bool
    {
        // Sudah mundur sebelumnya
        if (!is_null($this->tanggal_pengunduran_diri)) {
            return false;
        }

        // Status yang tidak mengizinkan pengunduran diri
        $statusTidakBoleh = [
            'dikirim',
            'selesai',
            'dibatalkan',
            'retur',
            'penggantian_vendor',
            'menunggu_tindak_lanjut',
            'vendor_mundur',
            'diterima_gudang',
        ];

        if (in_array($this->status, $statusTidakBoleh)) {
            return false;
        }

        // Hanya boleh saat status dikirim_ke_vendor (belum ada pengiriman)
        return $this->status === 'dikirim_ke_vendor';
    }

    /**
     * Cek apakah PO ini vendor-nya sudah mengundurkan diri.
     */
    public function isVendorMundur(): bool
    {
        return $this->status === 'vendor_mundur' || !is_null($this->tanggal_pengunduran_diri);
    }
}
