<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTDonHang extends Model
{
    protected $table = 'ct_don_hangs';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'maDH',
        'maSach',
        'soLuong',
        'donGia',
        'thanhTien',
    ];
        public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'maDH', 'maDH');
    }

    public function sach()
    {
        return $this->belongsTo(Sach::class, 'maSach', 'maSach');
    }
}
