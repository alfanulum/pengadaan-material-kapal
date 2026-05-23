<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorQuotation extends Model
{
    protected $fillable = [
        'tender_id',
        'vendor_id',
        'harga_penawaran',
        'estimasi_pengiriman',
        'catatan',
        'file_penawaran',
        'status',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class);
    }
}
