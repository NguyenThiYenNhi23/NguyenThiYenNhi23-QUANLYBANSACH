<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DanhMucController;
use Illuminate\Support\Facades\Route;

// Đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.store');

// Đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

// Quên mật khẩu
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

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
