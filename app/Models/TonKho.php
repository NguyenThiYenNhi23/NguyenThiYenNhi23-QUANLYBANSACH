<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TonKho extends Model
{
    protected $table = 'ton_khos';

    protected $primaryKey = 'maTonKho';

    public $timestamps = false;

    protected $fillable = [
        'maSach',
        'soLuongTon',
        'ngayCapNhat',
    ];
        public function sach()
    {
        return $this->belongsTo(Sach::class, 'maSach', 'maSach');
    }
}
