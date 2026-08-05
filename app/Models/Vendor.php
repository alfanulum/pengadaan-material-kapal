<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'kode_vendor',
        'nama_vendor',
        'email',
        'telepon',
        'pic',
        'alamat',
        'kategori',
        'status',
        'status_registrasi',
        'alasan_penolakan',
        'tanggal_daftar',
        'tanggal_verifikasi',
        'id_verifikator',
    ];

    protected $casts = [
        'tanggal_daftar'      => 'datetime',
        'tanggal_verifikasi'  => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'id_verifikator');
    }

    public function invitations()
    {
        return $this->hasMany(TenderInvitation::class);
    }

    public function quotations()
    {
        return $this->hasMany(VendorQuotation::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    /**
     * Cek apakah vendor sudah disetujui dan dapat menggunakan fitur penuh.
     */
    public function isApproved(): bool
    {
        return $this->status_registrasi === 'disetujui';
    }

    /**
     * Cek apakah vendor masih menunggu verifikasi.
     */
    public function isPending(): bool
    {
        return $this->status_registrasi === 'menunggu';
    }

    /**
     * Cek apakah vendor ditolak.
     */
    public function isRejected(): bool
    {
        return $this->status_registrasi === 'ditolak';
    }

    /**
     * Label status registrasi vendor.
     */
    public function getStatusRegistrasiLabelAttribute(): string
    {
        return match ($this->status_registrasi) {
            'menunggu'  => 'Menunggu Verifikasi',
            'disetujui' => 'Disetujui',
            'ditolak'   => 'Ditolak',
            default     => ucfirst($this->status_registrasi ?? 'Tidak Diketahui'),
        };
    }
}
