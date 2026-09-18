<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toans';
    protected $primaryKey = 'maThanhToan';

    protected $fillable = [
        'maDH',
        'maPTTT',
        'soTien',
        'maGiaoDich',
        'phuongThuc',
        'trangThai',
        'thoiGianThanhToan',
    ];

    protected $casts = [
        'soTien' => 'decimal:2',
        'thoiGianThanhToan' => 'datetime',
    ];

    public function donHang()
    {
        return $this->belongsTo(
            DonHang::class,
            'maDH',
            'maDH'
        );
    }

    public function phuongThucThanhToan()
    {
        return $this->belongsTo(
            PhuongThucThanhToan::class,
            'maPTTT',
            'maPTTT'
        );
    }
}