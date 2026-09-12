<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sach extends Model
{
    protected $table = 'sachs';

    protected $primaryKey = 'maSach';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'maDanhMuc',
        'tenSach',
        'giaBan',
        'moTa',
        'hinhAnh',
        'trangThai',
    ];

    /**
     * Một sách thuộc một danh mục
     */
        public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'maDanhMuc', 'maDanhMuc');
    }

    public function tonKho()
    {
        return $this->hasOne(TonKho::class, 'maSach', 'maSach');
    }

    public function chiTietGioHangs()
    {
        return $this->hasMany(CTGioHang::class, 'maSach', 'maSach');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(CTDonHang::class, 'maSach', 'maSach');
    }

    public function chiTietPhieuNhaps()
    {
        return $this->hasMany(CTPhieuNhap::class, 'maSach', 'maSach');
    }
}

