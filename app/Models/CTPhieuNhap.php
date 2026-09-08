<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTPhieuNhap extends Model
{
    protected $table = 'ct_phieu_nhaps';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'maPN',
        'maSach',
        'soLuong',
        'donGia',
        'thanhTien',
    ];

    public function phieuNhap()
    {
        return $this->belongsTo(PhieuNhap::class, 'maPN', 'maPN');
    }

    public function sach()
    {
        return $this->belongsTo(Sach::class, 'maSach', 'maSach');
    }
}
