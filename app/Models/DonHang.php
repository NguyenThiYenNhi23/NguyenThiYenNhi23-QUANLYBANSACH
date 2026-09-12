<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hangs';

    protected $primaryKey = 'maDH';

    public $timestamps = false;

    protected $fillable = [
        'maKH',
        'maDiaChi',
        'maPTTT',
        'ngayDat',
        'tongTien',
        'trangThai',
    ];

    protected $casts = [
        'ngayDat' => 'datetime',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'maKH', 'maKH');
    }

    public function diaChi()
    {
        return $this->belongsTo(DiaChi::class, 'maDiaChi', 'maDiaChi');
    }

    public function phuongThucThanhToan()
    {
        return $this->belongsTo(
            PhuongThucThanhToan::class,
            'maPTTT',
            'maPTTT'
        );
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(CTDonHang::class, 'maDH', 'maDH');
    }
}
