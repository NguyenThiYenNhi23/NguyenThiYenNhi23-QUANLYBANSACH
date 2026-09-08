<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongThucThanhToan extends Model
{
    protected $table = 'phuong_thuc_thanh_toans';

    protected $primaryKey = 'maPTTT';

    public $timestamps = false;

    protected $fillable = [
        'tenPhuongThuc',
        'moTa',
        'trangThai',
    ];
       public function donHangs()
    {
        return $this->hasMany(DonHang::class, 'maPTTT', 'maPTTT');
    }
}
