<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\Sach;
use App\Models\TonKho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThongKeController extends Controller
{
    public function index(Request $request)
    {
        // ==============================
        // SẢN PHẨM SẮP HẾT
        // ==============================

        $sanPhamSapHet = TonKho::where('soLuongTon', '<=', 10)
            ->count();


        // ==============================
        // SÁCH BÁN CHẠY
        // ==============================

        $sachBanChay = Sach::query()
            ->select([
                'sachs.maSach',
                'sachs.tenSach',
                'sachs.giaBan',
                'sachs.hinhAnh',

                DB::raw(
                    'COALESCE(SUM(ct_don_hangs.soLuong), 0) as tongDaBan'
                ),
            ])
            ->leftJoin(
                'ct_don_hangs',
                'sachs.maSach',
                '=',
                'ct_don_hangs.maSach'
            )
            ->where(
                'sachs.trangThai',
                'Đang kinh doanh'
            )
            ->whereExists(function ($query) {

                $query->select(DB::raw(1))
                    ->from('ton_khos')
                    ->whereColumn(
                        'ton_khos.maSach',
                        'sachs.maSach'
                    )
                    ->where(
                        'ton_khos.soLuongTon',
                        '>',
                        0
                    );

            })
            ->groupBy(
                'sachs.maSach',
                'sachs.maDanhMuc',
                'sachs.tenSach',
                'sachs.giaBan',
                'sachs.moTa',
                'sachs.hinhAnh',
                'sachs.trangThai'
            )
            ->orderByDesc('tongDaBan')
            ->limit(5)
            ->get();


        // ==============================
        // ĐƠN HÀNG HÔM NAY
        // ==============================

        $donHangHomNay = DonHang::whereDate(
            'ngayDat',
            today()
        )->count();


        // ==============================
        // DOANH THU THÁNG NÀY
        // ==============================

        $doanhThuThangNay = (float) DonHang::whereYear(
            'ngayDat',
            now()->year
        )
            ->whereMonth(
                'ngayDat',
                now()->month
            )
            ->sum('tongTien');


        // =====================================================
        // LỌC DOANH THU THEO KHOẢNG THỜI GIAN
        // =====================================================

        $tuNgay = $request->input(
            'tuNgay',
            now()->startOfMonth()->format('Y-m-d')
        );

        $denNgay = $request->input(
            'denNgay',
            now()->format('Y-m-d')
        );


        // Nếu chọn ngược ngày thì tự đổi lại
        if ($tuNgay > $denNgay) {

            [$tuNgay, $denNgay] = [
                $denNgay,
                $tuNgay
            ];

        }


        // =====================================================
        // NGÀY BẮT ĐẦU / KẾT THÚC
        // =====================================================

        $ngayBatDau = Carbon::parse(
            $tuNgay
        )->startOfDay();

        $ngayKetThuc = Carbon::parse(
            $denNgay
        )->endOfDay();


        // =====================================================
        // LẤY DOANH THU THEO NGÀY
        // =====================================================

        $doanhThuTheoNgay = DonHang::query()

            ->selectRaw(
                'DATE(ngayDat) as ngay'
            )

            ->selectRaw(
                'SUM(tongTien) as doanhThu'
            )

            ->whereBetween(
                'ngayDat',
                [
                    $ngayBatDau,
                    $ngayKetThuc
                ]
            )

            ->groupByRaw(
                'DATE(ngayDat)'
            )

            ->orderBy(
                'ngay'
            )

            ->pluck(
                'doanhThu',
                'ngay'
            )

            ->toArray();


        // =====================================================
        // TẠO ĐỦ CÁC NGÀY TRONG KHOẢNG
        // =====================================================

        $bieuDoDoanhThu = [];

        $currentDate = $ngayBatDau->copy();


        while (
            $currentDate->lte($ngayKetThuc)
        ) {

            $ngay = $currentDate->format(
                'Y-m-d'
            );


            $bieuDoDoanhThu[] = [

                'ngay' => $ngay,

                'hienThi' => $currentDate->format(
                    'd/m'
                ),

                'doanhThu' => (float) (
                    $doanhThuTheoNgay[$ngay] ?? 0
                ),

            ];


            $currentDate->addDay();

        }


        // =====================================================
        // DOANH THU CAO NHẤT
        // =====================================================

        $doanhThuCaoNhat = collect(
            $bieuDoDoanhThu
        )->max(
            'doanhThu'
        );


        if (
            !$doanhThuCaoNhat ||
            $doanhThuCaoNhat <= 0
        ) {

            $doanhThuCaoNhat = 1;

        }


        // =====================================================
        // TỔNG DOANH THU TRONG KHOẢNG ĐÃ CHỌN
        // =====================================================

        $tongDoanhThuLoc = array_sum(
            array_column(
                $bieuDoDoanhThu,
                'doanhThu'
            )
        );


        // =====================================================
        // TRẢ VỀ VIEW
        // =====================================================

        return view(
            'quantri.thongke',
            compact(
                'sanPhamSapHet',
                'sachBanChay',
                'donHangHomNay',
                'doanhThuThangNay',
                'bieuDoDoanhThu',
                'doanhThuCaoNhat',
                'tuNgay',
                'denNgay',
                'tongDoanhThuLoc'
            )
        );
    }
}