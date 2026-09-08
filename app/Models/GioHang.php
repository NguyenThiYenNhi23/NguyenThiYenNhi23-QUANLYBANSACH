<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
     protected $table = 'gio_hangs';

    protected $primaryKey = 'maGioHang';

    public $timestamps = false;

    protected $fillable = [
        'maKH',
        'ngayTao',
        'ngayCapNhat',
    ];
        public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'maKH', 'maKH');
    }

    public function chiTietGioHangs()
    {
        return $this->hasMany(CTGioHang::class, 'maGioHang', 'maGioHang');
    }
}
