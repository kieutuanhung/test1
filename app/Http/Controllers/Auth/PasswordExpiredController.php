<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordExpiredController extends Controller
{
    public function show()
    {
        return view('auth.password-expired');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Đổi mật khẩu thành công!');
    }
}
