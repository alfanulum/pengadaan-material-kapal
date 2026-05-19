<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequestItem extends Model
{
    protected $fillable = [
        'material_request_id',
        'nama_barang',
        'spesifikasi',
        'qty',
        'satuan',
    ];

    public function materialRequest()
    {
        return $this->belongsTo(MaterialRequest::class);
    }
}
