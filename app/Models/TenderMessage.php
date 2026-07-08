<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderMessage extends Model
{
    protected $table = 'tender_messages';

    protected $fillable = [
        'tender_id',
        'vendor_id',
        'sender_id',
        'role',
        'type',
        'message',
        'attachment',
        'is_read',
    ];

    // RELASI
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
