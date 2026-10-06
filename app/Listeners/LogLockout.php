<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Str;

class LogLockout
{
    /**
     * Chạy khi LoginRequest chặn vì sai quá 5 lần (theo cặp email|IP).
     */
    public function handle(Lockout $event): void
    {
        $request = $event->request;

        LoginLog::create([
            'user_id'      => null,
            'email'        => Str::limit((string) $request->input('email', ''), 255, ''),
            'ip_address'   => $request->ip(),
            'user_agent'   => Str::limit((string) $request->userAgent(), 255, ''),
            'status'       => 'login_locked',
            'logged_in_at' => now(),
        ]);
    }
}
