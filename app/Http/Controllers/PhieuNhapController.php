<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\CTPhieuNhap;
use App\Models\NhanVien;
use App\Models\Sach;
use App\Models\TonKho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhieuNhapController extends Controller
{
    /**
     * Danh sách phiếu nhập + tìm kiếm nhanh
     */
    public function index(Request $request)
{
    $keyword = trim($request->keyword ?? '');

    $phieuNhaps = PhieuNhap::with(['nhanVien', 'chiTiet'])
        ->when($keyword, function ($query) use ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('maPN', 'like', '%' . $keyword . '%')
                    ->orWhereHas('nhanVien', function ($nv) use ($keyword) {
                        $nv->where('hoTen', 'like', '%' . $keyword . '%');
                    });
            });
        })
        ->orderBy('maPN', 'asc')
        ->get();

    return view('phieunhap.index', compact(
        'phieuNhaps',
        'keyword'
    ));
}

    /**
     * Form lập phiếu
     */
    public function create()
    {
        $nhanViens = NhanVien::orderBy('hoTen')->get();
        $sachs = Sach::orderBy('maSach')->get();

        return view('phieunhap.create', compact(
            'nhanViens',
            'sachs'
        ));
    }

    /**
     * Lưu phiếu nhập
     */
    public function store(Request $request)
    {
        $request->validate([
            'maNV' => 'required|exists:nhan_viens,maNV',
            'ngayNhap' => 'required|date',
            'maSach' => 'required|array|min:1',
            'maSach.*' => 'required|exists:sachs,maSach',
            'soLuong' => 'required|array|min:1',
            'soLuong.*' => 'required|integer|min:1',
            'donGia' => 'required|array|min:1',
            'donGia.*' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $phieuNhap = PhieuNhap::create([
                'maNV' => $request->maNV,
                'ngayNhap' => $request->ngayNhap,
                'tongTien' => 0,
                'trangThai' => 'HoanThanh',
            ]);

            $tongTien = 0;

            foreach ($request->maSach as $index => $maSach) {

                $soLuong = (int) $request->soLuong[$index];
                $donGia = (float) $request->donGia[$index];

                $thanhTien = $soLuong * $donGia;

                CTPhieuNhap::create([
                    'maPN' => $phieuNhap->maPN,
                    'maSach' => $maSach,
                    'soLuong' => $soLuong,
                    'donGia' => $donGia,
                    'thanhTien' => $thanhTien,
                ]);

                $tongTien += $thanhTien;

                // Cập nhật tồn kho
                $tonKho = TonKho::firstOrCreate(
                    ['maSach' => $maSach],
                    [
                        'soLuongTon' => 0,
                        'ngayCapNhat' => now(),
                    ]
                );

                $tonKho->soLuongTon += $soLuong;
                $tonKho->ngayCapNhat = now();
                $tonKho->save();
            }

            $phieuNhap->tongTien = $tongTien;
            $phieuNhap->save();
        });

        return redirect()
            ->route('phieunhap.index')
            ->with('success', 'Lập phiếu nhập thành công.');
    }

    /**
     * Xem chi tiết
     */
    public function show($maPN)
    {
        $phieuNhap = PhieuNhap::with([
            'nhanVien',
            'chiTiet.sach'
        ])->findOrFail($maPN);

        return view('phieunhap.show', compact('phieuNhap'));
    }

    /**
     * Form sửa phiếu
     */
    public function edit($maPN)
    {
        $phieuNhap = PhieuNhap::with('chiTiet.sach')
            ->findOrFail($maPN);

        // Phiếu đã hủy không được sửa
        if ($phieuNhap->trangThai === 'DaHuy') {
            return redirect()
                ->route('phieunhap.index')
                ->with('error', 'Phiếu đã hủy không thể sửa.');
        }

        $nhanViens = NhanVien::orderBy('hoTen')->get();
        $sachs = Sach::orderBy('maSach')->get();

        return view('phieunhap.edit', compact(
            'phieuNhap',
            'nhanViens',
            'sachs'
        ));
    }

    /**
     * Cập nhật phiếu nhập
     */
    public function update(Request $request, $maPN)
    {
        $phieuNhap = PhieuNhap::with('chiTiet')
            ->findOrFail($maPN);

        if ($phieuNhap->trangThai === 'DaHuy') {
            return back()->with('error', 'Phiếu đã hủy không thể sửa.');
        }

        $request->validate([
            'maNV' => 'required|exists:nhan_viens,maNV',
            'ngayNhap' => 'required|date',
            'maSach' => 'required|array|min:1',
            'maSach.*' => 'required|exists:sachs,maSach',
            'soLuong' => 'required|array|min:1',
            'soLuong.*' => 'required|integer|min:1',
            'donGia' => 'required|array|min:1',
            'donGia.*' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $phieuNhap) {

            /*
             * 1. Hoàn tác số lượng cũ khỏi tồn kho
             */
            foreach ($phieuNhap->chiTiet as $chiTiet) {

                $tonKho = TonKho::where(
                    'maSach',
                    $chiTiet->maSach
                )->first();

                if ($tonKho) {
                    $tonKho->soLuongTon -= $chiTiet->soLuong;

                    if ($tonKho->soLuongTon < 0) {
                        $tonKho->soLuongTon = 0;
                    }

                    $tonKho->ngayCapNhat = now();
                    $tonKho->save();
                }
            }

            /*
             * 2. Xóa chi tiết cũ
             */
            $phieuNhap->chiTiet()->delete();

            /*
             * 3. Tạo chi tiết mới
             */
            $tongTien = 0;

            foreach ($request->maSach as $index => $maSach) {

                $soLuong = (int) $request->soLuong[$index];
                $donGia = (float) $request->donGia[$index];

                $thanhTien = $soLuong * $donGia;

                CTPhieuNhap::create([
                    'maPN' => $phieuNhap->maPN,
                    'maSach' => $maSach,
                    'soLuong' => $soLuong,
                    'donGia' => $donGia,
                    'thanhTien' => $thanhTien,
                ]);

                $tongTien += $thanhTien;

                /*
                 * 4. Cộng lại tồn kho theo dữ liệu mới
                 */
                $tonKho = TonKho::firstOrCreate(
                    ['maSach' => $maSach],
                    [
                        'soLuongTon' => 0,
                        'ngayCapNhat' => now(),
                    ]
                );

                $tonKho->soLuongTon += $soLuong;
                $tonKho->ngayCapNhat = now();
                $tonKho->save();
            }

            /*
             * 5. Cập nhật thông tin phiếu
             */
            $phieuNhap->maNV = $request->maNV;
            $phieuNhap->ngayNhap = $request->ngayNhap;
            $phieuNhap->tongTien = $tongTien;
            $phieuNhap->save();
        });

        return redirect()
            ->route('phieunhap.index')
            ->with('success', 'Cập nhật phiếu nhập thành công.');
    }

    /**
     * Xóa phiếu chưa có chi tiết
     */
    public function destroy($maPN)
    {
        $phieuNhap = PhieuNhap::with('chiTiet')
            ->findOrFail($maPN);

        // Đã hủy thì không xóa
        if ($phieuNhap->trangThai === 'DaHuy') {
            return back()->with(
                'error',
                'Phiếu đã hủy không thể xóa.'
            );
        }

        // Có chi tiết thì không được xóa
        if ($phieuNhap->chiTiet->count() > 0) {
            return back()->with(
                'error',
                'Phiếu đã có dữ liệu, không được xóa. Vui lòng hủy phiếu.'
            );
        }

        $phieuNhap->delete();

        return redirect()
            ->route('phieunhap.index')
            ->with('success', 'Đã xóa phiếu nhập.');
    }

    /**
     * Hủy phiếu đã nhập
     */
    public function cancel($maPN)
    {
        $phieuNhap = PhieuNhap::with('chiTiet')
            ->findOrFail($maPN);

        if ($phieuNhap->trangThai === 'DaHuy') {
            return back()->with(
                'error',
                'Phiếu này đã được hủy.'
            );
        }

        // Phiếu không có chi tiết thì xóa, không cần hủy
        if ($phieuNhap->chiTiet->count() === 0) {
            return back()->with(
                'error',
                'Phiếu chưa có dữ liệu nên chỉ được xóa.'
            );
        }

        DB::transaction(function () use ($phieuNhap) {

            /*
             * Hoàn tác số lượng nhập vào tồn kho
             */
            foreach ($phieuNhap->chiTiet as $chiTiet) {

                $tonKho = TonKho::where(
                    'maSach',
                    $chiTiet->maSach
                )->first();

                if ($tonKho) {

                    $tonKho->soLuongTon -= $chiTiet->soLuong;

                    if ($tonKho->soLuongTon < 0) {
                        $tonKho->soLuongTon = 0;
                    }

                    $tonKho->ngayCapNhat = now();
                    $tonKho->save();
                }
            }

            $phieuNhap->trangThai = 'DaHuy';
            $phieuNhap->save();
        });

        return redirect()
            ->route('phieunhap.index')
            ->with('success', 'Đã hủy phiếu nhập và cập nhật lại tồn kho.');
    }
}