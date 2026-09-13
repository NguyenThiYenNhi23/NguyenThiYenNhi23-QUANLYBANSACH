<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\Sach;
use App\Models\TonKho;
use Illuminate\Http\Request;

class ThongKeController extends Controller
{
    public function index()
    {
        $tongSach = Sach::count();
        $tongDanhMuc = DanhMuc::count();
        $tongDonHang = DonHang::count();
        $tongDoanhThu = (float) DonHang::sum('tongTien');
        $sanPhamSapHet = TonKho::where('soLuongTon', '<=', 10)->count();

        $donHangGanDay = DonHang::with('khachHang')
            ->orderByDesc('ngayDat')
            ->limit(5)
            ->get();

        return view('quantri.thongke', compact(
            'tongSach',
            'tongDanhMuc',
            'tongDonHang',
            'tongDoanhThu',
            'sanPhamSapHet',
            'donHangGanDay'
        ));
    }
}
