<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    protected $fillable = [
        'kode_tender',
        'material_request_id',
        'nama_tender',
        'deadline',
        'catatan',
        'status',
    ];

    public function materialRequest()
    {
        return $this->belongsTo(MaterialRequest::class);
    }

    public function invitations()
    {
        return $this->hasMany(TenderInvitation::class);
    }

    public function quotations()
    {
        return $this->hasMany(VendorQuotation::class);
    }

    public function purchaseOrder()
    {
        return $this->hasOne(PurchaseOrder::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'tender_invitations')
            ->withPivot('status', 'sent_at')
            ->withTimestamps();
    }
}
