<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'kode_vendor',
        'nama_vendor',
        'email',
        'telepon',
        'pic',
        'alamat',
        'kategori',
        'status',
    ];
}
