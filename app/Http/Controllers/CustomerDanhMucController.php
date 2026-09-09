<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\Sach;
use Illuminate\Http\Request;

class CustomerDanhMucController extends Controller
{
    public function index(Request $request)
    {
        // Lấy các danh mục đang hoạt động
        $danhMucs = DanhMuc::where('isActive', true)
            ->orderBy('tenDanhMuc')
            ->get();

        // Lấy bộ lọc từ URL
        $maDanhMuc = $request->input('maDanhMuc');
        $gia = $request->input('gia');

        // Mặc định sắp xếp theo tên A → Z
        $sort = $request->input('sort', 'name-asc');

        // Lấy sách
        $query = Sach::with(['danhMuc', 'tonKho']);

        // Lọc theo danh mục nếu có chọn
        if ($maDanhMuc) {
            $query->where('maDanhMuc', $maDanhMuc);
        }

        // Lọc theo giá nếu có chọn
        if ($gia === 'duoi-50000') {
            $query->where('giaBan', '<', 50000);
        }

        if ($gia === '50000-100000') {
            $query->whereBetween('giaBan', [50000, 100000]);
        }

        if ($gia === '100000-200000') {
            $query->whereBetween('giaBan', [100000, 200000]);
        }

        if ($gia === 'tren-200000') {
            $query->where('giaBan', '>', 200000);
        }

        // Sắp xếp sách
        switch ($sort) {

            case 'name-asc':
                // Tên A → Z
                $query->orderBy('tenSach', 'asc');
                break;

            case 'newest':
                // Mã sách lớn hơn được xem là sách mới hơn
                $query->orderByDesc('maSach');
                break;

            case 'best-selling':
                // Sắp xếp theo số lượng đã bán
                $query->leftJoin(
                    'ct_don_hangs',
                    'sachs.maSach',
                    '=',
                    'ct_don_hangs.maSach'
                )
                ->select('sachs.*')
                ->selectRaw(
                    'COALESCE(SUM(ct_don_hangs.soLuong), 0) as tongDaBan'
                )
                ->groupBy(
                    'sachs.maSach',
                    'sachs.maDanhMuc',
                    'sachs.tenSach',
                    'sachs.giaBan',
                    'sachs.moTa',
                    'sachs.hinhAnh'
                )
                ->orderByDesc('tongDaBan');
                break;

            case 'price-asc':
                // Giá thấp → cao
                $query->orderBy('giaBan', 'asc');
                break;

            case 'price-desc':
                // Giá cao → thấp
                $query->orderBy('giaBan', 'desc');
                break;

            default:
                // Nếu sort không hợp lệ → mặc định A → Z
                $query->orderBy('tenSach', 'asc');
                break;
        }

        // Lấy danh sách sách
        $sachs = $query->get();

        return view('customer.danhmuc', compact(
            'danhMucs',
            'sachs',
            'maDanhMuc',
            'gia',
            'sort'
        ));
    }
}