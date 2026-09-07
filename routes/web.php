<?php

use App\Http\Controllers\DanhMucController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.danhmuc.index');
});

Route::get('/admin/danhmuc', [DanhMucController::class, 'index'])
    ->name('admin.danhmuc.index');

Route::get('/admin/danhmuc/create', [DanhMucController::class, 'create'])
    ->name('admin.danhmuc.create');

Route::post('/admin/danhmuc', [DanhMucController::class, 'store'])
    ->name('admin.danhmuc.store');

Route::get('/admin/danhmuc/{danhMuc}/edit', [DanhMucController::class, 'edit'])
    ->name('admin.danhmuc.edit');

Route::put('/admin/danhmuc/{danhMuc}', [DanhMucController::class, 'update'])
    ->name('admin.danhmuc.update');

Route::delete('/admin/danhmuc/{danhMuc}', [DanhMucController::class, 'destroy'])
    ->name('admin.danhmuc.destroy');
