<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordExpiredController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        // Nếu mật khẩu CHƯA hết hạn (hoặc chưa từng đổi) -> không cho vào trang này
        if (!$user->password_changed_at || $user->password_changed_at->diffInMonths(now()) < 6) {
            return redirect()->route('home');
        }

        return view('auth.password-expired');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);

        // Kiểm tra mật khẩu mới không được trùng mật khẩu cũ
        if (Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.',
            ]);
        }

        $request->user()->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        // A09 - Ghi log việc đổi mật khẩu vào bảng login_logs
        DB::table('login_logs')->insert([
            'user_id' => auth()->id(),
            'email' => auth()->user()->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'password_changed',
            'logged_in_at' => now(),
        ]);

        return redirect()->route('home')->with('status', 'Đổi mật khẩu thành công!');
    }
}
