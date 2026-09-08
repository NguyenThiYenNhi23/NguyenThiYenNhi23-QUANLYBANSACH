<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'maNV', 'maNV');
    }

    public function chiTietPhieuNhaps()
    {
        return $this->hasMany(CTPhieuNhap::class, 'maPN', 'maPN');
    }
}
