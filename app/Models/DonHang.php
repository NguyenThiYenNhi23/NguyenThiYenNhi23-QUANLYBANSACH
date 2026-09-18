<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hangs';

    protected $primaryKey = 'maDH';

    public $timestamps = false;

    public const STATUS_LABELS = [
        'ChoXacNhan' => 'Chờ xác nhận',
        'DangXuLy' => 'Đang xử lý',
        'DangGiao' => 'Đang giao',
        'DaGiao' => 'Đã giao',
        'HoanThanh' => 'Hoàn thành',
        'DaHuy' => 'Đã hủy',
    ];

    protected $fillable = [
        'maKH',
        'maDiaChi',
        'maPTTT',
        'ngayDat',
        'tongTien',
        'trangThai',
        'ngayHuy',
        'ngayHoanThanh',
    ];

    protected $casts = [
        'ngayDat' => 'datetime',
        'ngayHuy' => 'datetime',
        'ngayHoanThanh' => 'datetime',
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
    public function thanhToan()
{
    return $this->hasOne(
        ThanhToan::class,
        'maDH',
        'maDH'
    );
}

    public static function statusLabel(?string $status): string
    {
        return self::STATUS_LABELS[$status] ?? (string) $status;
    }
}
