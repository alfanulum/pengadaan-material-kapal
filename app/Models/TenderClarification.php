<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderClarification extends Model
{
    protected $fillable = [
        'tender_id',
        'vendor_id',
        'engineer_id',
        'sender_id',
        'message',
        'attachment',
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

    public function engineer()
    {
        return $this->belongsTo(User::class, 'engineer_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
