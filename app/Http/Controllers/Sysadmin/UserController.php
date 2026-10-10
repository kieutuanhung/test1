<?php

namespace App\Http\Controllers\Sysadmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
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

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        // Audit: tạo tài khoản (KHÔNG ghi mật khẩu)
        AuditLog::record('user.created', $user, null, [
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role,
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

        // Snapshot trước khi sửa để so sánh (phục vụ audit)
        $before = $user->only(['name', 'email', 'role']);

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

        // Audit: tách riêng việc đổi role vì đây là thay đổi phân quyền, rất nhạy cảm
        [$old, $new] = AuditLog::diff($before, $user->only(['name', 'email', 'role']));

        if (array_key_exists('role', $new)) {
            AuditLog::record('user.role_changed', $user, ['role' => $old['role']], ['role' => $new['role']]);
            unset($old['role'], $new['role']);
        }

        if (!empty($new)) {
            AuditLog::record('user.updated', $user, $old, $new);
        }

        // Chỉ ghi sự kiện đổi mật khẩu, tuyệt đối không ghi giá trị
        if ($request->filled('password')) {
            AuditLog::record('user.password_changed_by_admin', $user);
        }

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

        // Audit: ghi rõ AI là người khóa/mở khóa (login_logs chỉ ghi tài khoản bị tác động)
        AuditLog::record(
            $user->is_active ? 'user.activated' : 'user.deactivated',
            $user,
            ['is_active' => !$user->is_active],
            ['is_active' => $user->is_active]
        );

        return back()->with('success', "Đã {$statusText} tài khoản thành công!");
    }

    // 7. Xem danh sách Login Logs
    public function logs(Request $request)
    {
        $query = LoginLog::query();

        // Lọc theo email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Lọc theo địa chỉ IP
        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        // Lọc theo thiết bị / trình duyệt
        if ($request->filled('device')) {
            $query->where('user_agent', 'like', '%' . $request->device . '%');
        }

        // Lọc theo trạng thái (success, login_failed, login_locked, password_changed, ...)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo khoảng thời gian - Từ ngày
        if ($request->filled('from_date')) {
            $query->whereDate('logged_in_at', '>=', $request->from_date);
        }

        // Lọc theo khoảng thời gian - Đến ngày
        if ($request->filled('to_date')) {
            $query->whereDate('logged_in_at', '<=', $request->to_date);
        }

        $logs = $query->latest('logged_in_at')->paginate(15)->withQueryString();

        // Thống kê theo trạng thái (toàn bộ bảng, không phụ thuộc bộ lọc)
        $stats = LoginLog::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('sysadmin.logs.index', compact('logs', 'stats'));
    }

    // 8. Xem Audit Log (nhật ký hành động nghiệp vụ: đơn hàng, thanh toán, user, sản phẩm...)
    public function audit(Request $request)
    {
        $query = AuditLog::query();

        // Lọc theo người thực hiện (email)
        if ($request->filled('actor')) {
            $query->where('user_email', 'like', '%' . $request->actor . '%');
        }

        // Lọc theo hành động
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Lọc theo loại đối tượng (Order, User, Product, Category)
        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        // Lọc theo ID đối tượng (VD: xem toàn bộ lịch sử của đơn #12)
        if ($request->filled('target_id')) {
            $query->where('target_id', (int) $request->target_id);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $logs = $query->latest('created_at')->latest('id')->paginate(15)->withQueryString();

        // Dữ liệu cho dropdown bộ lọc
        $actions = AuditLog::query()->select('action')->distinct()->orderBy('action')->pluck('action');
        $targetTypes = AuditLog::query()->whereNotNull('target_type')->select('target_type')->distinct()->orderBy('target_type')->pluck('target_type');

        // Thống kê nhanh (toàn bộ bảng, không phụ thuộc bộ lọc)
        $stats = [
            'total'   => AuditLog::count(),
            'today'   => AuditLog::whereDate('created_at', today())->count(),
            'order'   => AuditLog::where('action', 'like', 'order.%')->orWhere('action', 'like', 'payment.%')->count(),
            'account' => AuditLog::where('action', 'like', 'user.%')->count(),
        ];

        return view('sysadmin.logs.audit', compact('logs', 'actions', 'targetTypes', 'stats'));
    }
}
