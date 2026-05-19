<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialRequest extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'kode_pengajuan',
        'tanggal_dibutuhkan',
        'total_rab',
        'file_rab',
        'file_perizinan',
        'catatan',
        'catatan_planner',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(MaterialRequestItem::class);
    }
}
