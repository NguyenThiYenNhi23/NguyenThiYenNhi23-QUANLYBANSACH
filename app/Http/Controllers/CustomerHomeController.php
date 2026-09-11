<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use App\Models\DanhMuc;
use Illuminate\View\View;

class CustomerHomeController extends Controller
{
    public function index(): View
    {
        // ==============================
        // SÁCH BÁN CHẠY
        // ==============================
        // Chỉ hiển thị sách:
        // - Đang kinh doanh
        // - Còn hàng (soLuongTon > 0)
        $sachBanChay = Sach::query()
            ->select(
                'sachs.maSach',
                'sachs.maDanhMuc',
                'sachs.tenSach',
                'sachs.giaBan',
                'sachs.moTa',
                'sachs.hinhAnh'
            )
            ->selectRaw(
                'COALESCE(SUM(ct_don_hangs.soLuong), 0) as tongDaBan'
            )
            ->leftJoin(
                'ct_don_hangs',
                'sachs.maSach',
                '=',
                'ct_don_hangs.maSach'
            )
            ->with('tonKho')
            ->where('sachs.trangThai', 'Đang kinh doanh')
            ->whereHas('tonKho', function ($query) {
                $query->where('soLuongTon', '>', 0);
            })
            ->groupBy(
                'sachs.maSach',
                'sachs.maDanhMuc',
                'sachs.tenSach',
                'sachs.giaBan',
                'sachs.moTa',
                'sachs.hinhAnh'
            )
            ->orderByDesc('tongDaBan')
            ->take(8)
            ->get();


        // ==============================
        // SÁCH NỔI BẬT
        // ==============================
        // Hiện database chưa có cột "noiBat",
        // nên tạm sử dụng nhóm sách bán chạy.
        $sachNoiBat = $sachBanChay->take(4);


        // ==============================
        // SÁCH MỚI
        // ==============================
        // Chỉ lấy sách:
        // - Đang kinh doanh
        // - Còn hàng
        //
        // Bảng sachs chưa có created_at,
        // nên tạm lấy maSach lớn nhất.
        $sachMoi = Sach::query()
            ->with('tonKho')
            ->where('trangThai', 'Đang kinh doanh')
            ->whereHas('tonKho', function ($query) {
                $query->where('soLuongTon', '>', 0);
            })
            ->orderByDesc('maSach')
            ->take(8)
            ->get();


        // ==============================
        // DANH MỤC
        // ==============================
        $danhMucs = DanhMuc::query()
            ->where('isActive', true)
            ->orderBy('tenDanhMuc')
            ->get();


        // ==============================
        // TRẢ DỮ LIỆU SANG VIEW
        // ==============================
        return view('customer.home', compact(
            'sachNoiBat',
            'sachBanChay',
            'sachMoi',
            'danhMucs'
        ));
    }
}