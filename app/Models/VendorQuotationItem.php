<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorQuotationItem extends Model
{
    protected $table = 'penawaran_vendor_items';

    protected $fillable = [
        'vendor_quotation_id',
        'material_request_item_id',
        'harga_satuan',
        'subtotal',
    ];

    public function quotation()
    {
        return $this->belongsTo(VendorQuotation::class, 'vendor_quotation_id');
    }

    public function materialRequestItem()
    {
        return $this->belongsTo(MaterialRequestItem::class, 'material_request_item_id');
    }
}
