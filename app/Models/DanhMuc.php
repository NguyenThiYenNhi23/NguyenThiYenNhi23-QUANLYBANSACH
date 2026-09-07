<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    protected $table = 'danh_mucs';

    protected $primaryKey = 'maDanhMuc';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'tenDanhMuc',
        'moTa',
        'isActive',
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];
}
