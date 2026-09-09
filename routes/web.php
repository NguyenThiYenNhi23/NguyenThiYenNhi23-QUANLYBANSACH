<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DanhMucController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\CustomerSearchController;
use App\Http\Controllers\CustomerDanhMucController;
use App\Http\Controllers\CustomerGioiThieuController;
use App\Http\Controllers\CustomerBookController;
use App\Http\Controllers\SachController;
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
    return redirect()->route('customer.home');
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


Route::get('/customer', [CustomerHomeController::class, 'index'])
    ->name('customer.home');
Route::get('/customer/search', [CustomerSearchController::class, 'index'])
    ->name('customer.search');
Route::get('/customer/danhmuc', [CustomerDanhMucController::class, 'index'])
    ->name('customer.danhmuc');
Route::get('/customer/gioi-thieu', [CustomerGioiThieuController::class, 'index'])
    ->name('customer.gioithieu');

Route::get('/customer/book/{sach}', [CustomerBookController::class, 'show'])
    ->name('customer.book.show');

Route::post('/customer/cart/add', [CustomerBookController::class, 'addToCart'])
    ->name('customer.cart.add');

Route::post('/customer/cart/buy-now', [CustomerBookController::class, 'buyNow'])
    ->name('customer.cart.buyNow');

Route::get('/customer/cart', [CustomerBookController::class, 'cart'])
    ->name('customer.cart');

    //Quản lý sách

Route::prefix('sach')->group(function () {

    // Danh sách + tìm kiếm
    Route::get('/', [SachController::class, 'index'])
        ->name('sach.index');

    // Thêm sách
    Route::get('/create', [SachController::class, 'create'])
        ->name('sach.create');

    Route::post('/', [SachController::class, 'store'])
        ->name('sach.store');

    // Sửa
    Route::get('/{maSach}/edit', [SachController::class, 'edit'])
        ->name('sach.edit');

    Route::put('/{maSach}', [SachController::class, 'update'])
        ->name('sach.update');

    // Chi tiết
    Route::get('/{maSach}', [SachController::class, 'show'])
        ->name('sach.show');

    // Cập nhật trạng thái
    Route::patch(
        '/{maSach}/status',
        [SachController::class, 'updateStatus']
    )->name('sach.updateStatus');

    // Xóa
    Route::delete(
        '/{maSach}',
        [SachController::class, 'destroy']
    )->name('sach.destroy');
});

