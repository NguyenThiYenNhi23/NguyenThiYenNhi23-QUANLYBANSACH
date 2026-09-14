<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class QuanLyKhachHangController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        $khachHangs = KhachHang::query()
            ->whereHas('user', function ($query) {
                $query->where('role', 'customer');
            })
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('hoTen', 'like', '%' . $keyword . '%')
                      ->orWhere('email', 'like', '%' . $keyword . '%')
                      ->orWhere('sdt', 'like', '%' . $keyword . '%');
                });
            })
            ->orderBy('maKH', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('quantri.ql_khachhang.kh_index', compact(
            'khachHangs',
            'keyword'
        ));
    }
}