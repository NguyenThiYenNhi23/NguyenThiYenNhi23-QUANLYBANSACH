<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CTGioHang extends Model
{
    protected $table = 'ct_gio_hangs';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'maGioHang',
        'maSach',
        'soLuong',
        'donGia',
    ];
      public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'maGioHang', 'maGioHang');
    }

    public function sach()
    {
        return $this->belongsTo(Sach::class, 'maSach', 'maSach');
    }
}
