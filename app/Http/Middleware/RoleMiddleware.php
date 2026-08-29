<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Kiểm tra xem tài khoản có bị Sysadmin khóa hay không
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa bởi Quản trị viên!');
        }

        // 3. Kiểm tra Role hiện tại có nằm trong danh sách được phép không
        if (!in_array($user->role, $roles)) {
            abort(403, 'Bạn không có quyền truy cập vào khu vực này!');
        }

        return $next($request);
    }
}
