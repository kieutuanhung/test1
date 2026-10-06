<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LogFailedLogin
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Chạy khi Auth::attempt() thất bại (sai email hoặc sai mật khẩu).
     * Chỉ ghi email đã nhập - KHÔNG bao giờ ghi mật khẩu.
     */
    public function handle(Failed $event): void
    {
        LoginLog::create([
            'user_id'      => $event->user?->getAuthIdentifier(), // null nếu email không tồn tại
            'email'        => Str::limit((string) ($event->credentials['email'] ?? ''), 255, ''),
            'ip_address'   => $this->request->ip(),
            'user_agent'   => Str::limit((string) $this->request->userAgent(), 255, ''),
            'status'       => 'login_failed',
            'logged_in_at' => now(),
        ]);
    }
}
