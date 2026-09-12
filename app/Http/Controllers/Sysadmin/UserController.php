<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // 1. Danh sách Users
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('sysadmin.users.index', compact('users'));
    }

    // 2. Form tạo User mới
    public function create()
    {
        return view('sysadmin.users.create');
    }

    // 3. Lưu User mới
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => 'required|in:customer,staff,owner,sysadmin',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('sysadmin.users.index')->with('success', 'Đã tạo tài khoản người dùng thành công!');
    }

    // 4. Form chỉnh sửa thông tin & Role & Mật khẩu
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('sysadmin.users.edit', compact('user'));
    }

    // 5. Cập nhật User
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'     => 'required|in:customer,staff,owner,sysadmin',
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $userData = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // Nếu có nhập mật khẩu mới thì mới đổi
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('sysadmin.users.index')->with('success', 'Đã cập nhật tài khoản thành công!');
    }

    // 6. Khóa / Mở khóa tài khoản
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        // Không cho phép tự khóa chính mình
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'Mở khóa' : 'Khóa';

        // A09 - Ghi log việc khóa/mở khóa tài khoản
        LoginLog::create([
            'user_id'      => $user->id,
            'email'        => $user->email,
            'ip_address'   => request()->ip(),
            'user_agent'   => request()->userAgent(),
            'status'       => $user->is_active ? 'account_activated' : 'account_deactivated',
            'logged_in_at' => now(),
        ]);

        return back()->with('success', "Đã {$statusText} tài khoản thành công!");
    }

    // 7. Xem danh sách Login Logs
    public function logs()
    {
        $logs = LoginLog::latest('logged_in_at')->paginate(15);
        return view('sysadmin.logs.index', compact('logs'));
    }
}
