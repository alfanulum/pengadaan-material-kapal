<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nama_project',
        'kode_project',
        'deskripsi',
    ];

    public function materialRequests()
    {
        return $this->hasMany(MaterialRequest::class);
    }
}
