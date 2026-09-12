<?php

namespace Tests\Feature;

use App\Models\DanhMuc;
use App\Models\Sach;
use App\Models\TonKho;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SachControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_uses_delete_action_instead_of_cancel(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách kỹ thuật',
            'moTa' => 'Sách kỹ thuật',
        ]);

        Sach::create([
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenSach' => 'Laravel cơ bản',
            'giaBan' => 150000,
            'moTa' => 'Giới thiệu về Laravel.',
            'trangThai' => 'Đang kinh doanh',
        ]);

        $response = $this->get(route('sach.index'));

        $response->assertOk();
        $response->assertSee('Xóa');
        $response->assertDontSee('Hủy');
    }

    public function test_delete_rejects_book_with_related_constraints(): void
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

        TonKho::create([
            'maSach' => $sach->maSach,
            'soLuongTon' => 5,
            'ngayCapNhat' => now(),
        ]);

        $response = $this->delete(route('sach.destroy', $sach));

        $response->assertRedirect(route('sach.index'));
        $response->assertSessionHas('error', 'Không thể xóa sách vì sách đã phát sinh dữ liệu liên quan.');
        $this->assertDatabaseHas('sachs', ['maSach' => $sach->maSach]);
    }
}
