<?php

namespace App\Http\Controllers;

use App\Models\TonKho;

class TonKhoController extends Controller
{
    /**
     * Hiển thị danh sách tồn kho
     */
    public function index()
    {
        // Lấy tồn kho và thông tin sách tương ứng
        $tonKhos = TonKho::with('sach')
            ->orderBy('maSach', 'asc')
            ->get();

        return view('tonkho.index', compact('tonKhos'));
    }
}