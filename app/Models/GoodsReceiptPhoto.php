<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiptPhoto extends Model
{
    protected $fillable = [
        'goods_receipt_id',
        'file_path',
        'keterangan',
    ];

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }
}
