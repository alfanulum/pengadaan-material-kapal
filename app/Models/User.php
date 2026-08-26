<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'fcm_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    /**
     * Tender-tender yang dibuat oleh user ini (Supply Chain).
     */
    public function tendersDibuat()
    {
        return $this->hasMany(Tender::class, 'dibuat_oleh');
    }

    /**
     * Purchase Order-purchase Order yang dibuat oleh user ini (Supply Chain).
     */
    public function purchaseOrdersDibuat()
    {
        return $this->hasMany(PurchaseOrder::class, 'dibuat_oleh');
    }
}
