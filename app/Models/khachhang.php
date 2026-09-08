<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khach_hangs';

    protected $primaryKey = 'maKH';

    public $timestamps = false;

    protected $fillable = [
        'maTK',
        'hoTen',
        'sdt',
        'email',
    ];
     public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'maTK', 'maTK');
    }

    public function diaChis()
    {
        return $this->hasMany(DiaChi::class, 'maKH', 'maKH');
    }

    public function gioHang()
    {
        return $this->hasOne(GioHang::class, 'maKH', 'maKH');
    }

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'maKH', 'maKH');
    }
}