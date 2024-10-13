<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        // Kiểm tra xem người dùng đã đăng nhập và có vai trò tương ứng không
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Nếu không có quyền, chuyển hướng về trang chủ
        return redirect('/');
    }
}

