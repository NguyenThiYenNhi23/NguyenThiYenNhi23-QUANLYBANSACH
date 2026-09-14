<?php

namespace Tests\Feature;

use App\Models\DanhMuc;
use App\Models\Sach;
use App\Models\TonKho;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerBookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_adding_to_cart(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách kỹ thuật',
            'moTa' => 'Sách kỹ thuật',
        ]);

        $sach = Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Laravel nâng cao',
            'giaBan' => 150000,
            'moTa' => 'Giới thiệu Laravel nâng cao.',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $response = $this->post(route('customer.cart.add'), [
            'maSach' => $sach->maSach,
            'soLuong' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_guest_is_redirected_to_login_when_buying_now(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách kinh doanh',
            'moTa' => 'Sách kinh doanh',
        ]);

        $sach = Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Quản trị doanh nghiệp',
            'giaBan' => 200000,
            'moTa' => 'Mô tả',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $response = $this->post(route('customer.cart.buyNow'), [
            'maSach' => $sach->maSach,
            'soLuong' => 1,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_buy_now_replaces_existing_cart_with_only_selected_book(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách kỹ thuật',
            'moTa' => 'Sách kỹ thuật',
        ]);

        $sach = Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'JavaScript nâng cao',
            'giaBan' => 180000,
            'moTa' => 'Mô tả',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $this->actingAs($this->createUser())
            ->withSession([
                'cart' => [
                    999 => [
                        'maSach' => 999,
                        'tenSach' => 'Sách cũ',
                        'giaBan' => 50000,
                        'hinhAnh' => null,
                        'soLuong' => 1,
                    ],
                ],
            ])
            ->post(route('customer.cart.buyNow'), [
                'maSach' => $sach->maSach,
                'soLuong' => 2,
            ])
            ->assertRedirect(route('customer.cart'))
            ->assertSessionMissing('success');

        $this->assertSame([
            $sach->maSach => [
                'maSach' => $sach->maSach,
                'tenSach' => $sach->tenSach,
                'giaBan' => $sach->giaBan,
                'hinhAnh' => $sach->hinhAnh,
                'soLuong' => 2,
            ],
        ], session('cart'));
    }

    public function test_cart_continue_shopping_link_returns_to_last_viewed_book_detail(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách văn học',
            'moTa' => 'Sách văn học',
        ]);

        $sach = Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Dế Mèn phiêu lưu ký',
            'giaBan' => 90000,
            'moTa' => 'Mô tả',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $this->get(route('customer.book.show', $sach->maSach));

        $this->get(route('customer.cart'))
            ->assertSee(route('customer.book.show', $sach->maSach));
    }

    private function createUser()
    {
        return \App\Models\User::factory()->create();
    }
}
