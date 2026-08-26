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
        'dibuat_oleh',
        'tender_induk_id',
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

    public function clarifications()
    {
        return $this->hasMany(TenderClarification::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'undangan_tender')
            ->withPivot('status', 'sent_at')
            ->withTimestamps();
    }

    /**
     * Staf Supply Chain yang membuat Tender ini.
     */
    public function pembuatTender()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /**
     * Tender induk (tender yang digantikan oleh tender ini).
     * Artinya: tender ini adalah tender ulang dari tender induk tersebut.
     */
    public function tenderInduk()
    {
        return $this->belongsTo(Tender::class, 'tender_induk_id');
    }

    /**
     * Tender pengganti (tender baru yang dibuat sebagai tender ulang dari tender ini).
     */
    public function tenderPengganti()
    {
        return $this->hasOne(Tender::class, 'tender_induk_id');
    }
}
