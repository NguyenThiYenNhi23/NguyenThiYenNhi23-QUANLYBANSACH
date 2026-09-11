<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveSachRequest;
use App\Models\DanhMuc;
use App\Models\Sach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SachController extends Controller
{
    /**
     * Hiển thị danh sách sách
     *
     * Chức năng:
     * - Tìm kiếm theo mã sách, tên sách
     * - Lọc theo danh mục
     * - Lọc theo trạng thái kinh doanh
     * - Sắp xếp
     *
     * Lưu ý:
     * - Trang quản lý sách không hiển thị số lượng tồn.
     * - Số lượng tồn được quản lý ở phân hệ kho.
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));
        $maDanhMuc = $request->input('maDanhMuc');
        $status = $request->input('trangThai');
        $sort = $request->input('sort', 'maSach_desc');

        /*
        |--------------------------------------------------------------------------
        | Chỉ cho phép 2 trạng thái kinh doanh
        |--------------------------------------------------------------------------
        |
        | Nhân viên chỉ được chọn:
        | - Đang kinh doanh
        | - Ngừng kinh doanh
        |
        | Hết hàng không phải là trạng thái kinh doanh.
        | Hết hàng được xác định dựa vào số lượng tồn trong kho.
        |
        */

        if (!in_array($status, [
            'Đang kinh doanh',
            'Ngừng kinh doanh'
        ])) {
            $status = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Truy vấn danh sách sách
        |--------------------------------------------------------------------------
        */

        $query = Sach::with('danhMuc')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where(
                        'tenSach',
                        'like',
                        '%' . $keyword . '%'
                    )
                    ->orWhere(
                        'maSach',
                        'like',
                        '%' . $keyword . '%'
                    );
                });
            })
            ->when($maDanhMuc, function ($query, $maDanhMuc) {
                $query->where(
                    'maDanhMuc',
                    $maDanhMuc
                );
            })
            ->when($status, function ($query, $status) {
                $query->where(
                    'trangThai',
                    $status
                );
            });

        /*
        |--------------------------------------------------------------------------
        | Sắp xếp
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'tenSach_asc':
                $query->orderBy(
                    'tenSach',
                    'asc'
                );
                break;

            case 'giaBan_asc':
                $query->orderBy(
                    'giaBan',
                    'asc'
                );
                break;

            case 'giaBan_desc':
                $query->orderBy(
                    'giaBan',
                    'desc'
                );
                break;

            default:
                $query->orderBy(
                    'maSach',
                    'desc'
                );
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Phân trang
        |--------------------------------------------------------------------------
        */

        $sachs = $query
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Danh mục
        |--------------------------------------------------------------------------
        */

        $danhMucs = DanhMuc::orderBy(
            'tenDanhMuc'
        )->get();

        /*
        |--------------------------------------------------------------------------
        | Thống kê
        |--------------------------------------------------------------------------
        |
        | Tổng số sách:
        | - Tất cả sách trong hệ thống
        |
        | Đang kinh doanh:
        | - Dựa vào trangThai
        |
        | Hết hàng:
        | - Dựa vào ton_khos.soLuongTon <= 0
        |
        | Ngừng kinh doanh:
        | - Dựa vào trangThai
        |
        */

        $stats = [

            // Tổng số sách
            'total' => Sach::count(),

            // Sách đang kinh doanh
            'active' => Sach::where(
                'trangThai',
                'Đang kinh doanh'
            )->count(),

            // Sách hết hàng
            'out_of_stock' => Sach::whereHas(
                'tonKho',
                function ($query) {
                    $query->where(
                        'soLuongTon',
                        '<=',
                        0
                    );
                }
            )->count(),

            // Sách ngừng kinh doanh
            'inactive' => Sach::where(
                'trangThai',
                'Ngừng kinh doanh'
            )->count(),
        ];

        return view(
            'sach.index',
            compact(
                'sachs',
                'keyword',
                'maDanhMuc',
                'status',
                'sort',
                'danhMucs',
                'stats'
            )
        );
    }


    /**
     * Hiển thị form thêm sách
     */
    public function create()
    {
        $danhMucs = DanhMuc::all();

        return view(
            'sach.create',
            compact('danhMucs')
        );
    }


    /**
     * Lưu sách mới
     */
    public function store(SaveSachRequest $request)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Xử lý hình ảnh riêng
        |--------------------------------------------------------------------------
        */

        unset($data['hinhAnh']);

        if ($request->hasFile('hinhAnh')) {

            $data['hinhAnh'] = $request
                ->file('hinhAnh')
                ->store(
                    'books',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Trạng thái mặc định
        |--------------------------------------------------------------------------
        |
        | Sách mới mặc định là:
        | Đang kinh doanh
        |
        */

        if (!isset($data['trangThai'])) {

            $data['trangThai'] =
                'Đang kinh doanh';
        }

        /*
        |--------------------------------------------------------------------------
        | Chỉ cho phép 2 trạng thái
        |--------------------------------------------------------------------------
        */

        if (!in_array(
            $data['trangThai'],
            [
                'Đang kinh doanh',
                'Ngừng kinh doanh'
            ]
        )) {

            $data['trangThai'] =
                'Đang kinh doanh';
        }

        /*
        |--------------------------------------------------------------------------
        | Tạo sách
        |--------------------------------------------------------------------------
        */

        Sach::create($data);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Thêm sách thành công.'
            );
    }


    /**
     * Hiển thị chi tiết sách
     */
    public function show($maSach)
    {
        /*
        |--------------------------------------------------------------------------
        | Lấy thông tin sách
        |--------------------------------------------------------------------------
        |
        | Trang chi tiết không cần hiển thị số lượng tồn.
        | Vì vậy chỉ cần lấy danh mục.
        |
        */

        $sach = Sach::with('danhMuc')
            ->findOrFail($maSach);

        return view(
            'sach.show',
            compact('sach')
        );
    }


    /**
     * Hiển thị form sửa sách
     */
    public function edit($maSach)
    {
        $sach = Sach::findOrFail($maSach);

        $danhMucs = DanhMuc::all();

        return view(
            'sach.edit',
            compact(
                'sach',
                'danhMucs'
            )
        );
    }


    /**
     * Cập nhật thông tin sách
     */
    public function update(
        SaveSachRequest $request,
        $maSach
    ) {
        $sach = Sach::findOrFail($maSach);

        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Xử lý hình ảnh riêng
        |--------------------------------------------------------------------------
        */

        unset($data['hinhAnh']);

        /*
        |--------------------------------------------------------------------------
        | Chỉ cho phép 2 trạng thái
        |--------------------------------------------------------------------------
        |
        | Không cho lưu:
        | Hết hàng
        |
        | Hết hàng được xác định tự động
        | dựa trên số lượng tồn kho.
        |
        */

        if (isset($data['trangThai'])) {

            if (!in_array(
                $data['trangThai'],
                [
                    'Đang kinh doanh',
                    'Ngừng kinh doanh'
                ]
            )) {

                unset($data['trangThai']);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Upload hình ảnh mới
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('hinhAnh')) {

            /*
            | Xóa hình cũ nếu tồn tại
            */

            if (
                $sach->hinhAnh &&
                Storage::disk('public')->exists(
                    $sach->hinhAnh
                )
            ) {

                Storage::disk('public')->delete(
                    $sach->hinhAnh
                );
            }

            /*
            | Lưu hình mới
            */

            $data['hinhAnh'] = $request
                ->file('hinhAnh')
                ->store(
                    'books',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Cập nhật sách
        |--------------------------------------------------------------------------
        */

        $sach->update($data);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Cập nhật sách thành công.'
            );
    }


    /**
     * Cập nhật trạng thái kinh doanh của sách
     *
     * Nhân viên chỉ được chọn:
     * - Đang kinh doanh
     * - Ngừng kinh doanh
     *
     * Không có lựa chọn Hết hàng.
     *
     * Hết hàng được xác định tự động từ tồn kho.
     */
    public function updateStatus(
        Request $request,
        $maSach
    ) {
        $sach = Sach::findOrFail($maSach);

        /*
        |--------------------------------------------------------------------------
        | Kiểm tra trạng thái
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'trangThai' => [
                'required',
                'in:Đang kinh doanh,Ngừng kinh doanh'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cập nhật trạng thái
        |--------------------------------------------------------------------------
        */

        $sach->update([
            'trangThai' => $request->trangThai
        ]);

        return redirect()
            ->route('sach.index')
            ->with(
                'success',
                'Cập nhật trạng thái sách thành công.'
            );
    }


    /**
     * Xóa sách
     */
    public function destroy($maSach)
    {
        $sach = Sach::with([
            'chiTietDonHangs',
            'chiTietGioHangs',
            'chiTietPhieuNhaps',
            'tonKho',
        ])->findOrFail($maSach);

        /*
        |--------------------------------------------------------------------------
        | Kiểm tra dữ liệu liên quan
        |--------------------------------------------------------------------------
        */

        $hasRelatedData =
            $sach->chiTietDonHangs()->exists()
            || $sach->chiTietGioHangs()->exists()
            || $sach->chiTietPhieuNhaps()->exists()
            || $sach->tonKho()->exists();

        if ($hasRelatedData) {

            return redirect()
                ->route('sach.index')
                ->with(
                    'error',
                    'Không thể xóa sách vì sách đã phát sinh dữ liệu liên quan.'
                );
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Xóa hình ảnh
            |--------------------------------------------------------------------------
            */

            if (
                $sach->hinhAnh &&
                Storage::disk('public')->exists(
                    $sach->hinhAnh
                )
            ) {

                Storage::disk('public')->delete(
                    $sach->hinhAnh
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Xóa sách
            |--------------------------------------------------------------------------
            */

            $sach->delete();

            return redirect()
                ->route('sach.index')
                ->with(
                    'success',
                    'Xóa sách thành công.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->route('sach.index')
                ->with(
                    'error',
                    'Không thể xóa sách vì sách đã phát sinh dữ liệu liên quan.'
                );
        }
    }
}