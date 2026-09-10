<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\CustomerBookController;
use App\Http\Controllers\CustomerDanhMucController;
use App\Http\Controllers\CustomerGioiThieuController;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\CustomerSearchController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\SachController;
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
// SÁCH KHÁCH HÀNG
Route::get('/customer/book/{sach}', [CustomerBookController::class, 'show'])
    ->name('customer.book.show');
// GIỎ HÀNG
Route::post('/customer/cart/add', [CustomerBookController::class, 'addToCart'])
    ->name('customer.cart.add');

Route::post('/customer/cart/buy-now', [CustomerBookController::class, 'buyNow'])
    ->name('customer.cart.buyNow');

Route::get('/customer/cart', [CustomerBookController::class, 'cart'])
    ->name('customer.cart');
// CHECKOUT
Route::get('/customer/checkout', [CustomerBookController::class, 'checkout'])
    ->name('customer.checkout');
// Thêm địa chỉ
Route::post('/customer/checkout/address', [CustomerBookController::class, 'storeAddress'])
    ->name('customer.checkout.address.store');
// Xác nhận đặt hàng
Route::post('/customer/checkout/order', [CustomerBookController::class, 'placeOrder'])
    ->name('customer.checkout.order');
// Hiển thị trang thanh toán VNPay
Route::get('/customer/checkout/vnpay', [CustomerBookController::class, 'vnpayPayment'])
    ->name('customer.checkout.vnpay');

// Xử lý kết quả thanh toán VNPay
Route::post('/customer/checkout/vnpay/result', [CustomerBookController::class, 'vnpayPaymentResult'])
    ->name('customer.checkout.vnpay.result');
//Đơn hàng thành công
Route::get('/customer/order/{donHang}', [CustomerBookController::class, 'orderSuccess'])
    ->name('customer.order.success');

// Quản lý sách

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
// taikhoan
Route::middleware('auth')->prefix('customer/account')->group(function () {
    Route::get('/', [CustomerAccountController::class, 'index'])
        ->name('customer.account');

    Route::put('/password', [CustomerAccountController::class, 'updatePassword'])
        ->name('customer.account.password.update');

    Route::post('/addresses', [CustomerAccountController::class, 'storeAddress'])
        ->name('customer.account.addresses.store');

    Route::get('/addresses/{diaChi}/edit', [CustomerAccountController::class, 'editAddress'])
        ->name('customer.account.addresses.edit');

    Route::put('/addresses/{diaChi}', [CustomerAccountController::class, 'updateAddress'])
        ->name('customer.account.addresses.update');

    Route::delete('/addresses/{diaChi}', [CustomerAccountController::class, 'destroyAddress'])
        ->name('customer.account.addresses.destroy');

    Route::patch('/addresses/{diaChi}/default', [CustomerAccountController::class, 'setDefaultAddress'])
        ->name('customer.account.addresses.default');

    Route::post('/logout', [CustomerAccountController::class, 'logout'])
        ->name('customer.account.logout');
});
