<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Hiển thị trang đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:tai_khoans,tenDangNhap',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::transaction(function () use ($request): void {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
                'role' => 'customer',
            ]);

            $accountId = DB::table('tai_khoans')->insertGetId([
                'tenDangNhap' => $request->email,
                'matKhau' => Hash::make($request->password),
                'vaiTro' => 'customer',
                'trangThai' => true,
            ], 'maTK');

            DB::table('khach_hangs')->insert([
                'maTK' => $accountId,
                'hoTen' => $request->name,
                'sdt' => $request->phone,
                'email' => $request->email,
            ]);
        });

        return redirect()
            ->route('login')
            ->with('success', 'Đăng ký tài khoản thành công!');
    }

    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

        if ($user->role === 'customer') {
            return redirect()->route('customer.home');
        }

        if ($user->role === 'employee') {
            return redirect()->route('quantri.trangchu');
        }

        if ($user->role === 'admin') {
            return redirect()->route('quantri.trangchu');
        }

        Auth::logout();

        return back()->withErrors([
            'email' => 'Tài khoản không có quyền truy cập.',
        ]);
        }

        return back()
            ->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác.',
            ])
            ->onlyInput('email');
    }

    // Hiển thị form quên mật khẩu
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // Gửi link đặt lại mật khẩu
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('password.request')
                ->with('status', 'Liên kết đặt lại mật khẩu đã được gửi tới email của bạn.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // Hiển thị form đặt lại mật khẩu
    public function showResetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Cập nhật mật khẩu mới
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // Đăng xuất
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
}
}
