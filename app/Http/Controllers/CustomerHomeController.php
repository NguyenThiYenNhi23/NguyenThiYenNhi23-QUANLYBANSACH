<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use App\Models\DanhMuc;
use Illuminate\View\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CustomerHomeController extends Controller
{
    public function index()
    {
        $baseQuery = Sach::with('tonKho')
            ->whereExists(function ($query) {
                $query->from('ton_khos')
                    ->whereColumn('sachs.maSach', 'ton_khos.maSach')
                    ->where('soLuongTon', '>', 0);
            });

        $groupColumns = [
            'sachs.maSach',
            'sachs.maDanhMuc',
            'sachs.tenSach',
            'sachs.giaBan',
            'sachs.moTa',
            'sachs.hinhAnh',
            'sachs.trangThai',
        ];

        $sachNoiBat = (clone $baseQuery)
            ->select([
                'sachs.*',
                DB::raw('COALESCE(SUM(ct_don_hangs.soLuong), 0) as tongDaBan'),
            ])
            ->leftJoin('ct_don_hangs', 'sachs.maSach', '=', 'ct_don_hangs.maSach')
            ->groupBy($groupColumns)
            ->orderByDesc('tongDaBan')
            ->limit(8)
            ->get();

        $sachBanChay = (clone $baseQuery)
            ->select([
                'sachs.*',
                DB::raw('COALESCE(SUM(ct_don_hangs.soLuong), 0) as tongDaBan'),
            ])
            ->leftJoin('ct_don_hangs', 'sachs.maSach', '=', 'ct_don_hangs.maSach')
            ->groupBy($groupColumns)
            ->orderByDesc('tongDaBan')
            ->limit(8)
            ->get();

        $sachMoi = (clone $baseQuery)
            ->orderByDesc('maSach')
            ->limit(8)
            ->get();

        $sachs = $sachNoiBat;

        return view('customer.home', compact('sachs', 'sachNoiBat', 'sachBanChay', 'sachMoi'));
    }
}