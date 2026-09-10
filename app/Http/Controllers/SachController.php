<?php

namespace App\Http\Controllers;

use App\Models\Sach;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SachController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.sach.index', [
            'sachs' => Sach::query()->latest('maSach')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.sach.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Sach::create($request->validate([
            'maDanhMuc' => ['required', 'integer'],
            'tenSach' => ['required', 'string', 'max:255'],
            'giaBan' => ['required', 'numeric', 'min:0'],
            'moTa' => ['nullable', 'string'],
            'hinhAnh' => ['nullable', 'string', 'max:255'],
        ]));

        return redirect()->route('sach.index')->with('success', 'Thêm sách thành công.');
    }

    public function show(int $maSach): View
    {
        return view('admin.sach.show', ['sach' => Sach::findOrFail($maSach)]);
    }

    public function edit(int $maSach): View
    {
        return view('admin.sach.edit', ['sach' => Sach::findOrFail($maSach)]);
    }

    public function update(Request $request, int $maSach): RedirectResponse
    {
        Sach::findOrFail($maSach)->update($request->validate([
            'maDanhMuc' => ['required', 'integer'],
            'tenSach' => ['required', 'string', 'max:255'],
            'giaBan' => ['required', 'numeric', 'min:0'],
            'moTa' => ['nullable', 'string'],
            'hinhAnh' => ['nullable', 'string', 'max:255'],
        ]));

        return redirect()->route('sach.index')->with('success', 'Cập nhật sách thành công.');
    }

    public function updateStatus(int $maSach): RedirectResponse
    {
        return back()->with('success', 'Đã cập nhật trạng thái sách.');
    }

    public function destroy(int $maSach): RedirectResponse
    {
        Sach::findOrFail($maSach)->delete();

        return redirect()->route('sach.index')->with('success', 'Đã xóa sách.');
    }
}
