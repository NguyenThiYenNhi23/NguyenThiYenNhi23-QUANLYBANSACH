<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiKhoan extends Model
{
     protected $table = 'tai_khoans';

    protected $primaryKey = 'maTK';

    public $timestamps = false;

    protected $fillable = [
        'tenDangNhap',
        'matKhau',
        'vaiTro',
        'trangThai',
    ];
        public function khachHang()
    {
        return $this->hasOne(KhachHang::class, 'maTK', 'maTK');
    }

    public function nhanVien()
    {
        return $this->hasOne(NhanVien::class, 'maTK', 'maTK');
    }
}
