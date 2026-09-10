<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class KhachHang extends Model
{
    protected $table = 'khach_hangs';

    protected $primaryKey = 'maKH';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'hoTen',
        'sdt',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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