<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NhanVien;
use App\Models\CTPhieuNhap;

class PhieuNhap extends Model
{
    protected $table = 'phieu_nhaps';

    protected $primaryKey = 'maPN';

    public $timestamps = false;

    protected $fillable = [
        'maNV',
        'ngayNhap',
        'tongTien',
        'trangThai',
    ];

    protected $casts = [
        'ngayNhap' => 'datetime',
        'tongTien' => 'decimal:2',
    ];

    public function nhanVien()
    {
        return $this->belongsTo(
            NhanVien::class,
            'maNV',
            'maNV'
        );
    }

    public function chiTiet()
    {
        return $this->hasMany(
            CTPhieuNhap::class,
            'maPN',
            'maPN'
        );
    }
}