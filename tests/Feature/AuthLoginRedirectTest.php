<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_login_redirects_to_customer_home(): void
    {
        User::create([
            'name' => 'Khách hàng A',
            'email' => 'customer@example.com',
            'phone' => '0912345671',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'customer@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('customer.home'));
    }

    public function test_customer_home_page_renders_without_undefined_variable_errors(): void
    {
        $response = $this->get(route('customer.home'));

        $response->assertOk();
    }

    public function test_admin_book_page_requires_authentication(): void
    {
        $response = $this->get(route('sach.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_customer_home_page_loads_for_logged_in_customer(): void
    {
        $user = User::create([
            'name' => 'Khách hàng B',
            'email' => 'customer-b@example.com',
            'phone' => '0912345672',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $danhMuc = \App\Models\DanhMuc::create([
            'tenDanhMuc' => 'Tiểu thuyết',
            'moTa' => 'Tiểu thuyết',
        ]);

        \App\Models\Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Doraemon',
            'giaBan' => 10000,
            'moTa' => 'Truyện ngắn',
            'trangThai' => 'Đang kinh doanh',
        ]);

        \App\Models\TonKho::create([
            'maSach' => 1,
            'soLuongTon' => 10,
            'ngayCapNhat' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('customer.home'));

        $response->assertOk();
    }

    public function test_customer_cart_page_loads_with_cart_count(): void
    {
        $user = User::create([
            'name' => 'Khách hàng C',
            'email' => 'customer-c@example.com',
            'phone' => '0912345673',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        session(['cart' => [
            1 => [
                'maSach' => 1,
                'tenSach' => 'Doraemon',
                'giaBan' => 10000,
                'hinhAnh' => null,
                'soLuong' => 2,
            ],
        ]]);

        $response = $this->actingAs($user)->get(route('customer.cart'));

        $response->assertOk();
        $response->assertSee('2');
    }

    public function test_customer_can_remove_item_from_cart(): void
    {
        $danhMuc = \App\Models\DanhMuc::create([
            'tenDanhMuc' => 'Thiếu nhi',
            'moTa' => 'Thiếu nhi',
        ]);

        $sach = \App\Models\Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Doraemon',
            'giaBan' => 10000,
            'moTa' => 'Truyện thiếu nhi',
            'trangThai' => 'Đang kinh doanh',
        ]);

        session(['cart' => [
            $sach->maSach => [
                'maSach' => $sach->maSach,
                'tenSach' => $sach->tenSach,
                'giaBan' => $sach->giaBan,
                'hinhAnh' => null,
                'soLuong' => 2,
            ],
        ]]);

        $response = $this->postJson(route('customer.cart.update'), [
            'maSach' => $sach->maSach,
            'action' => 'remove',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $this->assertArrayNotHasKey($sach->maSach, session('cart', []));
    }

    public function test_customer_checkout_uses_only_selected_cart_items(): void
    {
        $user = User::create([
            'name' => 'Khách hàng D',
            'email' => 'customer-d@example.com',
            'phone' => '0912345674',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $danhMuc = \App\Models\DanhMuc::create([
            'tenDanhMuc' => 'Khoa học',
            'moTa' => 'Khoa học',
        ]);

        $sachA = \App\Models\Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Sách A',
            'giaBan' => 10000,
            'moTa' => 'Sách A',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $sachB = \App\Models\Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Sách B',
            'giaBan' => 20000,
            'moTa' => 'Sách B',
            'trangThai' => 'Đang kinh doanh',
        ]);

        session(['cart' => [
            $sachA->maSach => [
                'maSach' => $sachA->maSach,
                'tenSach' => $sachA->tenSach,
                'giaBan' => $sachA->giaBan,
                'hinhAnh' => null,
                'soLuong' => 1,
            ],
            $sachB->maSach => [
                'maSach' => $sachB->maSach,
                'tenSach' => $sachB->tenSach,
                'giaBan' => $sachB->giaBan,
                'hinhAnh' => null,
                'soLuong' => 1,
            ],
        ]]);

        $response = $this->actingAs($user)->get(route('customer.checkout', ['selected' => [$sachA->maSach]]));

        $response->assertOk();
        $response->assertSee('Sách A');
        $response->assertDontSee('Sách B');
    }

    public function test_admin_cannot_delete_category_with_books(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'phone' => '0912345679',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $danhMuc = \App\Models\DanhMuc::create([
            'tenDanhMuc' => 'Sách giáo khoa',
            'moTa' => 'Sách giáo khoa',
            'isActive' => true,
        ]);

        \App\Models\Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Toán 10',
            'giaBan' => 50000,
            'moTa' => 'Sách học',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $response = $this->actingAs($admin)
            ->delete(route('admin.danhmuc.destroy', $danhMuc));

        $response->assertRedirect(route('admin.danhmuc.index'));
        $response->assertSessionHas('error', 'Không thể xóa danh mục vì danh mục này đang có sách đang kinh doanh.');
        $this->assertDatabaseHas('danh_mucs', ['maDanhMuc' => $danhMuc->maDanhMuc]);
    }
}
