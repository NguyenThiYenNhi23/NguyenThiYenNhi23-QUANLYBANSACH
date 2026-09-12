<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrangChuController extends Controller
{
    public function index()
    {
        // Các số liệu này đang để mẫu.
        // Sau khi làm xong cơ sở dữ liệu,
        // chúng ta sẽ lấy số liệu thật từ database.

        $tongSach = 1250;
        $tongKhachHang = 5320;
        $tongDonHang = 86;
        $tongTonKho = 8450;
        $sapHet = 24;
        $hetHang = 5;

        return view('admin.trangchu', compact(
            'tongSach',
            'tongKhachHang',
            'tongDonHang',
            'tongTonKho',
            'sapHet',
            'hetHang'
        ));
    }
}