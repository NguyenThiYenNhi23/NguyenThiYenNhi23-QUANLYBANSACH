<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class NhanVien extends Model
{
    protected $table = 'nhan_viens';

    protected $primaryKey = 'maNV';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'hoTen',
        'sdt',
        'email',
        'diaChi',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function phieuNhaps()
    {
        return $this->hasMany(PhieuNhap::class, 'maNV', 'maNV');
    }
}