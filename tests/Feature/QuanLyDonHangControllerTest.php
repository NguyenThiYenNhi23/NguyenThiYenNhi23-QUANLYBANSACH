<?php

namespace Tests\Feature;

use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\PhuongThucThanhToan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuanLyDonHangControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_requires_an_authenticated_user(): void
    {
        $response = $this->get(route('quantri.donhang.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_rejects_a_customer_from_order_management(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($user)->get(route('quantri.donhang.index'));

        $response->assertForbidden();
    }

    public function test_employee_can_update_an_order_status(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $donHang = $this->createOrder();

        $response = $this->actingAs($employee)->patch(
            route('quantri.donhang.status', $donHang),
            ['trangThai' => 'DangXuLy']
        );

        $response->assertRedirect(route('quantri.donhang.show', $donHang));
        $response->assertSessionHas('success', 'Cập nhật trạng thái đơn hàng thành công.');
        $this->assertDatabaseHas('don_hangs', [
            'maDH' => $donHang->maDH,
            'trangThai' => 'DangXuLy',
        ]);
    }

    public function test_rejects_an_invalid_order_status_transition(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $donHang = $this->createOrder(['trangThai' => 'HoanThanh']);

        $response = $this->actingAs($employee)->patch(
            route('quantri.donhang.status', $donHang),
            ['trangThai' => 'DangGiao']
        );

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Đơn hàng không thể cập nhật sang trạng thái đã chọn.');
        $this->assertDatabaseHas('don_hangs', [
            'maDH' => $donHang->maDH,
            'trangThai' => 'HoanThanh',
        ]);
    }

    public function test_status_label_translates_all_known_statuses_to_vietnamese(): void
    {
        $this->assertSame('Chờ xác nhận', DonHang::statusLabel('ChoXacNhan'));
        $this->assertSame('Đang xử lý', DonHang::statusLabel('DangXuLy'));
        $this->assertSame('Đang giao', DonHang::statusLabel('DangGiao'));
        $this->assertSame('Đã giao', DonHang::statusLabel('DaGiao'));
        $this->assertSame('Hoàn thành', DonHang::statusLabel('HoanThanh'));
        $this->assertSame('Đã hủy', DonHang::statusLabel('DaHuy'));
    }

    public function test_order_list_keeps_filters_when_listing_results(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $this->createOrder(['trangThai' => 'ChoXacNhan']);

        $response = $this->actingAs($employee)->get(route('quantri.donhang.index', [
            'keyword' => 'Nguyễn Văn A',
            'trangThai' => 'ChoXacNhan',
        ]));

        $response->assertOk();
        $response->assertSee('Nguyễn Văn A');
        $response->assertSee('Chờ xác nhận');
    }

    public function test_order_search_accepts_hash_prefix_in_order_id(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $donHang = $this->createOrder(['trangThai' => 'ChoXacNhan']);

        $response = $this->actingAs($employee)->get(route('quantri.donhang.index', [
            'keyword' => '#'.$donHang->maDH,
        ]));

        $response->assertOk();
        $response->assertSee('#'.$donHang->maDH);
    }

    public function test_admin_order_detail_includes_shipping_fee_line(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);
        $donHang = $this->createOrder(['tongTien' => 180000, 'trangThai' => 'ChoXacNhan']);

        $response = $this->actingAs($employee)->get(route('quantri.donhang.show', $donHang));

        $response->assertOk();
        $response->assertSee('Phí vận chuyển');
        $response->assertSee('30.000');
    }

    public function test_customer_cancel_order_sets_cancel_date(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $khachHang = KhachHang::create([
            'user_id' => $customer->id,
            'hoTen' => 'Nguyễn Văn A',
            'sdt' => '0900000000',
            'email' => $customer->email,
        ]);
        $diaChi = DiaChi::create([
            'maKH' => $khachHang->maKH,
            'hoTenNguoiNhan' => 'Nguyễn Văn A',
            'sdt' => '0900000000',
            'diaChiChiTiet' => '123 Đường Sách',
        ]);
        $payment = PhuongThucThanhToan::create([
            'tenPhuongThuc' => 'COD',
            'trangThai' => true,
        ]);
        $donHang = DonHang::create([
            'maKH' => $khachHang->maKH,
            'maDiaChi' => $diaChi->maDiaChi,
            'maPTTT' => $payment->maPTTT,
            'ngayDat' => now(),
            'tongTien' => 150000,
            'trangThai' => 'ChoXacNhan',
        ]);

        $response = $this->actingAs($customer)->patch(route('customer.donmua.cancel', $donHang));

        $response->assertRedirect();
        $this->assertDatabaseHas('don_hangs', [
            'maDH' => $donHang->maDH,
            'trangThai' => 'DaHuy',
        ]);
        $this->assertNotNull(DonHang::find($donHang->maDH)->ngayHuy);
    }

    private function createOrder(array $attributes = []): DonHang
    {
        $user = User::factory()->create(['role' => 'customer']);
        $khachHang = KhachHang::create([
            'user_id' => $user->id,
            'hoTen' => 'Nguyễn Văn A',
            'sdt' => '0900000000',
            'email' => $user->email,
        ]);
        $diaChi = DiaChi::create([
            'maKH' => $khachHang->maKH,
            'hoTenNguoiNhan' => 'Nguyễn Văn A',
            'sdt' => '0900000000',
            'diaChiChiTiet' => '123 Đường Sách',
        ]);
        $phuongThuc = PhuongThucThanhToan::create([
            'tenPhuongThuc' => 'COD',
            'trangThai' => true,
        ]);

        return DonHang::create(array_merge([
            'maKH' => $khachHang->maKH,
            'maDiaChi' => $diaChi->maDiaChi,
            'maPTTT' => $phuongThuc->maPTTT,
            'ngayDat' => now(),
            'tongTien' => 150000,
            'trangThai' => 'ChoXacNhan',
        ], $attributes));
    }
}
