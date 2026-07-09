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
}

