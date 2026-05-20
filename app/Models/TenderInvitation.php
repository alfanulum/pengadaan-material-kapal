<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderInvitation extends Model
{
    protected $fillable = [
        'tender_id',
        'vendor_id',
        'status',
        'sent_at',
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
