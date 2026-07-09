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

    public function tender()
    {
        return $this->hasOne(Tender::class);
    }

    public function getGlobalProcurementStatusAttribute()
    {
        $tender = $this->tender;
        $po = $tender ? $tender->purchaseOrder : null;
        $receipt = $po ? $po->goodsReceipt : null;

        if ($receipt) {
            return 'Barang Diterima Gudang';
        }

        if ($po && in_array($po->status, ['dikirim', 'selesai', 'diterima_gudang'])) {
            return 'Barang Dikirim';
        }

        if ($po) {
            return 'Vendor Terpilih';
        }

        if ($tender) {
            return 'Tender Diproses';
        }

        return 'Pengajuan Dibuat';
    }

    public function getProcurementTimelineAttribute()
    {
        $tender = $this->tender;
        $po = $tender ? $tender->purchaseOrder : null;
        $receipt = $po ? $po->goodsReceipt : null;

        return [
            'pengajuan_dibuat' => [
                'active' => true,
                'date' => $this->created_at,
            ],
            'tender_diproses' => [
                'active' => $tender !== null,
                'date' => $tender ? $tender->created_at : null,
            ],
            'vendor_terpilih' => [
                'active' => $po !== null,
                'date' => ($po && $po->tanggal_po) ? \Carbon\Carbon::parse($po->tanggal_po) : ($po ? $po->created_at : null),
            ],
            'barang_dikirim' => [
                'active' => $po && in_array($po->status, ['dikirim', 'selesai', 'diterima_gudang']),
                'date' => ($po && $po->tanggal_pengiriman) ? \Carbon\Carbon::parse($po->tanggal_pengiriman) : ($po ? $po->updated_at : null),
            ],
            'barang_diterima' => [
                'active' => $receipt !== null,
                'date' => ($receipt && $receipt->tanggal_diterima) ? \Carbon\Carbon::parse($receipt->tanggal_diterima) : ($receipt ? $receipt->created_at : null),
            ],
        ];
    }
}
