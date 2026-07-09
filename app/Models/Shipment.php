<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'tender_id',
        'vendor_id',
        'tanggal_kirim',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
