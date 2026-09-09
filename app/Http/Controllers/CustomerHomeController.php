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
        // Bảng sachs chưa có created_at,
        // nên tạm lấy maSach lớn nhất.
        $sachMoi = Sach::query()
            ->with('tonKho')
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