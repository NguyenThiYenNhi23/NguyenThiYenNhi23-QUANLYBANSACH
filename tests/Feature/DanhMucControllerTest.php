<?php

namespace Tests\Feature;

use App\Models\DanhMuc;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DanhMucControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_renders_the_create_category_page(): void
    {
        $response = $this->get(route('admin.danhmuc.create'));

        $response->assertSee('THÊM DANH MỤC');
    }

    public function test_creates_a_category_with_a_valid_payload(): void
    {
        $response = $this->post(route('admin.danhmuc.store'), [
            'tenDanhMuc' => 'Sách khoa học',
            'moTa' => 'Các đầu sách về khoa học.',
        ]);

        $response->assertRedirect(route('admin.danhmuc.index'));
        $response->assertSessionHas('success', 'Thêm danh mục thành công.');

        $this->assertDatabaseHas('danh_mucs', [
            'tenDanhMuc' => 'Sách khoa học',
            'moTa' => 'Các đầu sách về khoa học.',
            'isActive' => true,
        ]);
    }

    public function test_rejects_a_category_without_a_name(): void
    {
        $response = $this->from(route('admin.danhmuc.create'))
            ->post(route('admin.danhmuc.store'), [
                'moTa' => 'Danh mục chưa có tên.',
            ]);

        $response->assertRedirect(route('admin.danhmuc.create'));
        $response->assertSessionHasErrors([
            'tenDanhMuc' => 'Vui lòng nhập tên danh mục.',
        ]);
        $this->assertDatabaseCount('danh_mucs', 0);
    }

    public function test_rejects_a_category_without_a_description(): void
    {
        $response = $this->from(route('admin.danhmuc.create'))
            ->post(route('admin.danhmuc.store'), [
                'tenDanhMuc' => 'Sách khoa học',
            ]);

        $response->assertRedirect(route('admin.danhmuc.create'));
        $response->assertSessionHasErrors([
            'moTa' => 'Vui lòng nhập mô tả danh mục.',
        ]);
        $this->assertDatabaseCount('danh_mucs', 0);
    }

    public function test_renders_the_edit_category_page(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách lịch sử',
            'moTa' => 'Các đầu sách lịch sử.',
        ]);

        $response = $this->get(route('admin.danhmuc.edit', $danhMuc));

        $response->assertSee('SỬA DANH MỤC');
        $response->assertSee('Sách lịch sử');
    }

    public function test_updates_a_category_when_keeping_its_existing_name(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách lịch sử',
            'moTa' => 'Mô tả cũ.',
        ]);

        $response = $this->put(route('admin.danhmuc.update', $danhMuc), [
            'tenDanhMuc' => 'Sách lịch sử',
            'moTa' => 'Mô tả mới.',
        ]);

        $response->assertRedirect(route('admin.danhmuc.index'));
        $response->assertSessionHas('success', 'Cập nhật danh mục thành công.');

        $this->assertDatabaseHas('danh_mucs', [
            'maDanhMuc' => $danhMuc->maDanhMuc,
            'tenDanhMuc' => 'Sách lịch sử',
            'moTa' => 'Mô tả mới.',
        ]);
    }

    public function test_deletes_a_category(): void
    {
        $danhMuc = DanhMuc::create([
            'tenDanhMuc' => 'Sách nghệ thuật',
            'moTa' => 'Các đầu sách nghệ thuật.',
        ]);

        $response = $this->delete(route('admin.danhmuc.destroy', $danhMuc));

        $response->assertRedirect(route('admin.danhmuc.index'));
        $response->assertSessionHas('success', 'Xóa danh mục thành công.');
        $this->assertModelMissing($danhMuc);
    }
}
