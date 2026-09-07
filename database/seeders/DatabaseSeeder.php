<?php

namespace Database\Seeders;

use App\Models\DanhMuc;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DanhMuc::create([
            'tenDanhMuc' => 'Truyện tranh',
            'moTa' => 'Các loại truyện tranh dành cho thiếu nhi và thanh thiếu niên.',
            'isActive' => true,
        ]);

        DanhMuc::create([
            'tenDanhMuc' => 'Sách thiếu nhi',
            'moTa' => 'Sách dành cho trẻ em.',
            'isActive' => true,
        ]);

        DanhMuc::create([
            'tenDanhMuc' => 'Sách giáo dục',
            'moTa' => 'Sách giáo khoa, sách tham khảo và tài liệu học tập.',
            'isActive' => true,
        ]);

        DanhMuc::create([
            'tenDanhMuc' => 'Sách văn học',
            'moTa' => 'Các tác phẩm văn học trong nước và quốc tế.',
            'isActive' => true,
        ]);

        DanhMuc::create([
            'tenDanhMuc' => 'Sách kỹ năng',
            'moTa' => 'Sách phát triển kỹ năng và tư duy.',
            'isActive' => true,
        ]);
    }
}
