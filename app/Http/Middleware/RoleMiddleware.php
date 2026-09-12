<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Lấy vai trò của tài khoản đang đăng nhập
        $role = auth()->user()->role;

        // Kiểm tra vai trò có được phép truy cập không
        if (!in_array($role, $roles)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}