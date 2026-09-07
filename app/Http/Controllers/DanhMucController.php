<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDanhMucRequest;
use App\Models\DanhMuc;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DanhMucController extends Controller
{
    public function index(Request $request): View
    {
        $query = DanhMuc::query();

        if ($request->filled('search')) {
            $query->where(
                'tenDanhMuc',
                'like',
                '%'.$request->search.'%'
            );
        }

        $danhMucs = $query->get();

        return view('admin.danhmuc.index', compact('danhMucs'));
    }

    public function create(): View
    {
        return view('admin.danhmuc.create');
    }

    public function store(SaveDanhMucRequest $request): RedirectResponse
    {
        DanhMuc::create($request->validated());

        return redirect()
            ->route('admin.danhmuc.index')
            ->with('success', 'Thêm danh mục thành công.');
    }

    public function edit(DanhMuc $danhMuc): View
    {
        return view('admin.danhmuc.edit', compact('danhMuc'));
    }

    public function update(SaveDanhMucRequest $request, DanhMuc $danhMuc): RedirectResponse
    {
        $danhMuc->update($request->validated());

        return redirect()
            ->route('admin.danhmuc.index')
            ->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy(DanhMuc $danhMuc): RedirectResponse
    {
        $danhMuc->delete();

        return redirect()
            ->route('admin.danhmuc.index')
            ->with('success', 'Xóa danh mục thành công.');
    }
}
