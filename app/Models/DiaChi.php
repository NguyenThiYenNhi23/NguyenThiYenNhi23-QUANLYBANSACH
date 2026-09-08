<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    protected $table = 'dia_chis';

    protected $primaryKey = 'maDiaChi';

    public $timestamps = false;

    protected $fillable = [
        'maKH',
        'hoTenNguoiNhan',
        'sdt',
        'diaChiChiTiet',
        'isDefault',
    ];
       public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'maKH', 'maKH');
    }

    public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'maDiaChi', 'maDiaChi');
    }
}
