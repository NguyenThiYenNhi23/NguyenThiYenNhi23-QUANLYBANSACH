<?php

namespace Tests\Feature;

use App\Models\DanhMuc;
use App\Models\Sach;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerBookDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_book_detail_page(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Khoa học',
            'moTa' => 'Danh mục khoa học',
            'isActive' => true,
        ]);

        $sach = Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Ôn luyện thi tốt nghiệp năm 2022',
            'giaBan' => 65250,
            'moTa' => 'Sách luyện thi',
            'hinhAnh' => null,
            'trangThai' => 'Đang kinh doanh',
        ]);

        $response = $this->get(route('customer.book.show', $sach->maSach));

        $response->assertOk();
        $response->assertSee($sach->tenSach);
    }

    public function test_customer_can_add_book_to_cart(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách giáo khoa',
            'moTa' => 'Danh mục sách giáo khoa',
            'isActive' => true,
        ]);

        $sach = Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Sách giáo khoa',
            'giaBan' => 100000,
            'moTa' => 'Sách giáo khoa',
            'hinhAnh' => null,
            'trangThai' => 'Đang kinh doanh',
        ]);

        $response = $this->post(route('customer.cart.add'), [
            'maSach' => $sach->maSach,
            'soLuong' => 1,
        ]);

        $response->assertRedirect(route('customer.book.show', $sach->maSach));
        $this->assertNotEmpty(session('cart'));
        $this->assertArrayHasKey($sach->maSach, session('cart'));
        $this->assertEquals(1, session('cart.' . $sach->maSach . '.soLuong'));
    }
}
