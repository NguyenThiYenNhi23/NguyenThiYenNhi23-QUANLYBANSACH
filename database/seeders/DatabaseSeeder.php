<?php

namespace Database\Seeders;

use App\Models\CTDonHang;
use App\Models\CTGioHang;
use App\Models\CTPhieuNhap;
use App\Models\DanhMuc;
use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\KhachHang;
use App\Models\NhanVien;
use App\Models\PhieuNhap;
use App\Models\PhuongThucThanhToan;
use App\Models\Sach;
use App\Models\TaiKhoan;
use App\Models\TonKho;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedDanhMucs();
        $this->seedUsers();
        $this->seedTaiKhoans();
        $this->seedKhachHangs();
        $this->seedNhanViens();
        $this->seedDiaChis();
        $this->seedSachs();
        $this->seedGioHangs();
        $this->seedPhuongThucThanhToans();
        $this->seedDonHangs();
        $this->seedPhieuNhaps();
        $this->seedTonKho();
        $this->seedDonMuas();
    }

    private function seedDanhMucs(): void
    {
        $danhMucs = [
            ['tenDanhMuc' => 'Truyện tranh', 'moTa' => 'Các loại truyện tranh cho thiếu nhi và thanh thiếu niên.', 'isActive' => true],
            ['tenDanhMuc' => 'Sách thiếu nhi', 'moTa' => 'Sách dành cho trẻ em và học sinh tiểu học.', 'isActive' => true],
            ['tenDanhMuc' => 'Sách giáo dục', 'moTa' => 'Sách giáo khoa, sách tham khảo và tài liệu học tập.', 'isActive' => true],
            ['tenDanhMuc' => 'Sách văn học', 'moTa' => 'Tác phẩm văn học trong nước và quốc tế.', 'isActive' => true],
            ['tenDanhMuc' => 'Sách kỹ năng', 'moTa' => 'Sách phát triển kỹ năng sống và tư duy.', 'isActive' => true],
        ];

        foreach ($danhMucs as $danhMuc) {
            DanhMuc::query()->firstOrCreate(
                ['tenDanhMuc' => $danhMuc['tenDanhMuc']],
                $danhMuc
            );
        }
    }

    private function seedUsers(): void
    {
        $users = [
            ['name' => 'Nguyễn Văn An', 'email' => 'an@gmail.com', 'phone' => '0901111111', 'password' => '123456', 'role' => 'customer'],
            ['name' => 'Trần Thị Bích', 'email' => 'bich@gmail.com', 'phone' => '0902222222', 'password' => '123456', 'role' => 'customer'],
            ['name' => 'Lê Văn Cường', 'email' => 'cuong@gmail.com', 'phone' => '0903333333', 'password' => '123456', 'role' => 'employee'],
            ['name' => 'Phạm Thị Duyên', 'email' => 'duyen@gmail.com', 'phone' => '0904444444', 'password' => '123456', 'role' => 'employee'],
        ];

        foreach ($users as $user) {
            User::query()->firstOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'phone' => $user['phone'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                ]
            );
        }
    }

    private function seedTaiKhoans(): void
    {
        $taiKhoans = [
            ['tenDangNhap' => 'khach1', 'matKhau' => '123456', 'vaiTro' => 'khachhang', 'trangThai' => true],
            ['tenDangNhap' => 'khach2', 'matKhau' => '123456', 'vaiTro' => 'khachhang', 'trangThai' => true],
            ['tenDangNhap' => 'nhanvien1', 'matKhau' => '123456', 'vaiTro' => 'nhanvien', 'trangThai' => true],
            ['tenDangNhap' => 'nhanvien2', 'matKhau' => '123456', 'vaiTro' => 'nhanvien', 'trangThai' => true],
        ];

        foreach ($taiKhoans as $taiKhoan) {
            TaiKhoan::query()->firstOrCreate(
                ['tenDangNhap' => $taiKhoan['tenDangNhap']],
                $taiKhoan
            );
        }
    }

    private function seedKhachHangs(): void
    {
        $khachHangs = [
            ['user_id' => User::where('email', 'an@gmail.com')->value('id'), 'hoTen' => 'Nguyễn Văn An', 'sdt' => '0901111111', 'email' => 'an@gmail.com'],
            ['user_id' => User::where('email', 'bich@gmail.com')->value('id'), 'hoTen' => 'Trần Thị Bích', 'sdt' => '0902222222', 'email' => 'bich@gmail.com'],
        ];

        foreach ($khachHangs as $khachHang) {
            KhachHang::query()->firstOrCreate(
                ['user_id' => $khachHang['user_id']],
                $khachHang
            );
        }
    }

    private function seedNhanViens(): void
    {
        $nhanViens = [
            ['user_id' => User::where('email', 'cuong@gmail.com')->value('id'), 'hoTen' => 'Lê Văn Cường', 'sdt' => '0903333333', 'email' => 'cuong@gmail.com', 'diaChi' => 'Hà Nội'],
            ['user_id' => User::where('email', 'duyen@gmail.com')->value('id'), 'hoTen' => 'Phạm Thị Duyên', 'sdt' => '0904444444', 'email' => 'duyen@gmail.com', 'diaChi' => 'Đà Nẵng'],
        ];

        foreach ($nhanViens as $nhanVien) {
            NhanVien::query()->firstOrCreate(
                ['user_id' => $nhanVien['user_id']],
                $nhanVien
            );
        }
    }

    private function seedDiaChis(): void
    {
        $maKHAn = KhachHang::where('email', 'an@gmail.com')->value('maKH');
        $maKHBich = KhachHang::where('email', 'bich@gmail.com')->value('maKH');

        $diaChis = [
            ['maKH' => $maKHAn, 'hoTenNguoiNhan' => 'Nguyễn Văn An', 'sdt' => '0901111111', 'diaChiChiTiet' => 'Số 12, Đường Lê Lợi, Quận 1, TP.HCM', 'isDefault' => true],
            ['maKH' => $maKHAn, 'hoTenNguoiNhan' => 'Nguyễn Văn An', 'sdt' => '0901111111', 'diaChiChiTiet' => 'Số 28, Đường Võ Văn Tần, Quận 3, TP.HCM', 'isDefault' => false],
            ['maKH' => $maKHBich, 'hoTenNguoiNhan' => 'Trần Thị Bích', 'sdt' => '0902222222', 'diaChiChiTiet' => 'Số 8, Đường Nguyễn Huệ, Quận 1, TP.HCM', 'isDefault' => true],
        ];

        foreach ($diaChis as $diaChi) {
            DiaChi::query()->firstOrCreate(
                [
                    'maKH' => $diaChi['maKH'],
                    'diaChiChiTiet' => $diaChi['diaChiChiTiet'],
                ],
                $diaChi
            );
        }
    }

    private function seedSachs(): void
    {
        $danhMucIds = DanhMuc::query()->pluck('maDanhMuc', 'tenDanhMuc');

        $sachs = [
            ['maDanhMuc' => $danhMucIds['Truyện tranh'], 'tenSach' => 'Doraemon Tập 1', 'giaBan' => 25000, 'moTa' => 'Truyện tranh ngắn gọn, dễ thương dành cho trẻ em.', 'hinhAnh' => 'images/doraemon-1.jpg', 'trangThai' => 'Đang kinh doanh'],
            ['maDanhMuc' => $danhMucIds['Truyện tranh'], 'tenSach' => 'Conan Tập 10', 'giaBan' => 30000, 'moTa' => 'Truyện tranh trinh thám hấp dẫn.', 'hinhAnh' => 'images/conan-10.jpg', 'trangThai' => 'Đang kinh doanh'],
            ['maDanhMuc' => $danhMucIds['Sách thiếu nhi'], 'tenSach' => 'Bé Học Toán', 'giaBan' => 99000, 'moTa' => 'Sách giúp trẻ học toán cơ bản qua hình ảnh.', 'hinhAnh' => 'images/be-hoc-toan.jpg', 'trangThai' => 'Đang kinh doanh'],
            ['maDanhMuc' => $danhMucIds['Sách giáo dục'], 'tenSach' => 'Giải Bài Tập Toán 6', 'giaBan' => 45000, 'moTa' => 'Tài liệu hỗ trợ học sinh lớp 6.', 'hinhAnh' => 'images/giai-bai-tap-toan-6.jpg', 'trangThai' => 'Đang kinh doanh'],
            ['maDanhMuc' => $danhMucIds['Sách văn học'], 'tenSach' => 'Truyện Kiều', 'giaBan' => 120000, 'moTa' => 'Tác phẩm văn học kinh điển Việt Nam.', 'hinhAnh' => 'images/truyen-kieu.jpg', 'trangThai' => 'Đang kinh doanh'],
            ['maDanhMuc' => $danhMucIds['Sách kỹ năng'], 'tenSach' => 'Thói Quen Tốt', 'giaBan' => 85000, 'moTa' => 'Sách hướng dẫn xây dựng thói quen hiệu quả.', 'hinhAnh' => 'images/thoi-quen-tot.jpg', 'trangThai' => 'Đang kinh doanh'],
        ];

        foreach ($sachs as $sach) {
            Sach::query()->firstOrCreate(
                ['tenSach' => $sach['tenSach']],
                $sach
            );
        }
    }

    private function seedGioHangs(): void
    {
        $gioHangs = [
            ['maKH' => KhachHang::where('email', 'an@gmail.com')->value('maKH'), 'ngayTao' => now(), 'ngayCapNhat' => now()],
            ['maKH' => KhachHang::where('email', 'bich@gmail.com')->value('maKH'), 'ngayTao' => now(), 'ngayCapNhat' => now()],
        ];

        $gioHangList = [];
        foreach ($gioHangs as $gioHang) {
            $gioHangList[] = GioHang::query()->firstOrCreate(
                ['maKH' => $gioHang['maKH']],
                $gioHang
            );
        }

        $ctGioHangs = [
            ['maGioHang' => $gioHangList[0]->maGioHang, 'maSach' => Sach::where('tenSach', 'Doraemon Tập 1')->value('maSach'), 'soLuong' => 2, 'donGia' => 25000],
            ['maGioHang' => $gioHangList[0]->maGioHang, 'maSach' => Sach::where('tenSach', 'Bé Học Toán')->value('maSach'), 'soLuong' => 1, 'donGia' => 99000],
            ['maGioHang' => $gioHangList[1]->maGioHang, 'maSach' => Sach::where('tenSach', 'Giải Bài Tập Toán 6')->value('maSach'), 'soLuong' => 1, 'donGia' => 45000],
        ];

        foreach ($ctGioHangs as $ctGioHang) {
            CTGioHang::query()->firstOrCreate(
                ['maGioHang' => $ctGioHang['maGioHang'], 'maSach' => $ctGioHang['maSach']],
                $ctGioHang
            );
        }
    }

    private function seedPhuongThucThanhToans(): void
    {
        $phuongThucThanhToans = [
            ['tenPhuongThuc' => 'Thanh toán khi nhận hàng (COD)', 'moTa' => 'Khách hàng thanh toán trực tiếp khi nhận hàng.', 'trangThai' => true],
            ['tenPhuongThuc' => 'Ví điện tử VNpay', 'moTa' => 'Khách hàng chuyển khoản qua ví điện tử VNpay.', 'trangThai' => true],
        ];

        foreach ($phuongThucThanhToans as $phuongThucThanhToan) {
            PhuongThucThanhToan::query()->firstOrCreate(
                ['tenPhuongThuc' => $phuongThucThanhToan['tenPhuongThuc']],
                $phuongThucThanhToan
            );
        }
    }

    private function seedDonHangs(): void
    {
        $donHangs = [
            ['maKH' => KhachHang::where('email', 'an@gmail.com')->value('maKH'), 'maDiaChi' => DiaChi::where('maKH', KhachHang::where('email', 'an@gmail.com')->value('maKH'))->first()->maDiaChi, 'maPTTT' => PhuongThucThanhToan::where('tenPhuongThuc', 'Thanh toán khi nhận hàng')->value('maPTTT'), 'ngayDat' => now(), 'tongTien' => 250000, 'trangThai' => 'ChoXacNhan'],
            ['maKH' => KhachHang::where('email', 'bich@gmail.com')->value('maKH'), 'maDiaChi' => DiaChi::where('maKH', KhachHang::where('email', 'bich@gmail.com')->value('maKH'))->first()->maDiaChi, 'maPTTT' => PhuongThucThanhToan::where('tenPhuongThuc', 'Chuyển khoản ngân hàng')->value('maPTTT'), 'ngayDat' => now(), 'tongTien' => 155000, 'trangThai' => 'DangGiao'],
        ];

        $donHangList = [];
        foreach ($donHangs as $donHang) {
            $donHangList[] = DonHang::query()->firstOrCreate(
                [
                    'maKH' => $donHang['maKH'],
                    'maDiaChi' => $donHang['maDiaChi'],
                    'maPTTT' => $donHang['maPTTT'],
                    'ngayDat' => $donHang['ngayDat'],
                ],
                $donHang
            );
        }

        $ctDonHangs = [
            ['maDH' => $donHangList[0]->maDH, 'maSach' => Sach::where('tenSach', 'Doraemon Tập 1')->value('maSach'), 'soLuong' => 2, 'donGia' => 25000, 'thanhTien' => 50000],
            ['maDH' => $donHangList[0]->maDH, 'maSach' => Sach::where('tenSach', 'Bé Học Toán')->value('maSach'), 'soLuong' => 2, 'donGia' => 99000, 'thanhTien' => 198000],
            ['maDH' => $donHangList[1]->maDH, 'maSach' => Sach::where('tenSach', 'Giải Bài Tập Toán 6')->value('maSach'), 'soLuong' => 1, 'donGia' => 45000, 'thanhTien' => 45000],
            ['maDH' => $donHangList[1]->maDH, 'maSach' => Sach::where('tenSach', 'Thói Quen Tốt')->value('maSach'), 'soLuong' => 1, 'donGia' => 85000, 'thanhTien' => 85000],
        ];

        foreach ($ctDonHangs as $ctDonHang) {
            CTDonHang::query()->firstOrCreate(
                ['maDH' => $ctDonHang['maDH'], 'maSach' => $ctDonHang['maSach']],
                $ctDonHang
            );
        }
    }

    private function seedPhieuNhaps(): void
    {
        $phieuNhaps = [
            ['maNV' => NhanVien::where('email', 'cuong@gmail.com')->value('maNV'), 'ngayNhap' => now(), 'tongTien' => 350000, 'trangThai' => 'HoanThanh'],
            ['maNV' => NhanVien::where('email', 'duyen@gmail.com')->value('maNV'), 'ngayNhap' => now(), 'tongTien' => 220000, 'trangThai' => 'HoanThanh'],
        ];

        $phieuNhapList = [];
        foreach ($phieuNhaps as $phieuNhap) {
            $phieuNhapList[] = PhieuNhap::query()->firstOrCreate(
                [
                    'maNV' => $phieuNhap['maNV'],
                    'ngayNhap' => $phieuNhap['ngayNhap'],
                ],
                $phieuNhap
            );
        }

        $ctPhieuNhaps = [
            ['maPN' => $phieuNhapList[0]->maPN, 'maSach' => Sach::where('tenSach', 'Doraemon Tập 1')->value('maSach'), 'soLuong' => 20, 'donGia' => 20000, 'thanhTien' => 400000],
            ['maPN' => $phieuNhapList[1]->maPN, 'maSach' => Sach::where('tenSach', 'Conan Tập 10')->value('maSach'), 'soLuong' => 10, 'donGia' => 22000, 'thanhTien' => 220000],
        ];

        foreach ($ctPhieuNhaps as $ctPhieuNhap) {
            CTPhieuNhap::query()->firstOrCreate(
                ['maPN' => $ctPhieuNhap['maPN'], 'maSach' => $ctPhieuNhap['maSach']],
                $ctPhieuNhap
            );
        }
    }

    private function seedTonKho(): void
    {
        foreach (Sach::query()->get() as $sach) {
            TonKho::query()->firstOrCreate(
                ['maSach' => $sach->maSach],
                [
                    'maSach' => $sach->maSach,
                    'soLuongTon' => 50,
                    'ngayCapNhat' => now(),
                ]
            );
        }
    }

    private function seedDonMuas(): void
    {
        DB::table('don_muas')->updateOrInsert(
            ['id' => 1],
            ['created_at' => now(), 'updated_at' => now()]
        );

        DB::table('ct_don_muas')->updateOrInsert(
            ['id' => 1],
            ['created_at' => now(), 'updated_at' => now()]
        );
    }
}

