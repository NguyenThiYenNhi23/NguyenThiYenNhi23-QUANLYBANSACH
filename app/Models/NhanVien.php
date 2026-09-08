<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhan_viens';

    protected $primaryKey = 'maNV';

    public $timestamps = false;

    protected $fillable = [
        'maTK',
        'hoTen',
        'sdt',
        'email',
        'diaChi',
    ];
        public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'maTK', 'maTK');
    }

    public function phieuNhaps()
    {
        return $this->hasMany(PhieuNhap::class, 'maNV', 'maNV');
    }
}