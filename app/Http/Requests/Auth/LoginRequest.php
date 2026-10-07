<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // Tăng bộ đếm cho cả 2 tầng: 900 giây = 15 phút
            RateLimiter::hit($this->throttleKey(), 900);
            RateLimiter::hit($this->emailThrottleKey(), 900);

            // Tầng 4: Ghi log khi đăng nhập thất bại
            $this->logLoginAttempt('failed');

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Đăng nhập thành công: Ghi log và xóa bộ đếm rate limit
        $this->logLoginAttempt('success');
        RateLimiter::clear($this->throttleKey());
        RateLimiter::clear($this->emailThrottleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        $isIpLimited = RateLimiter::tooManyAttempts($this->throttleKey(), 5);
        $isEmailLimited = RateLimiter::tooManyAttempts($this->emailThrottleKey(), 10);

        if (! $isIpLimited && ! $isEmailLimited) {
            return;
        }

        // Tầng 4: Ghi log trạng thái bị chặn (lockout)
        $this->logLoginAttempt('locked');

        event(new Lockout($this));

        // Lấy số giây còn lại cần chờ của tầng bị khóa
        $seconds = max(
            RateLimiter::availableIn($this->throttleKey()),
            RateLimiter::availableIn($this->emailThrottleKey())
        );

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Tầng 1 Throttle Key: Giới hạn theo Email + IP (5 lần / 15 phút).
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }

    /**
     * Tầng 2 Throttle Key: Giới hạn theo riêng Email (10 lần / 15 phút - chống xoay IP).
     */
    public function emailThrottleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|global_email');
    }

    /**
     * Tầng 4: Ghi log vào bảng login_logs.
     */
    protected function logLoginAttempt(string $status): void
    {
        try {
            DB::table('login_logs')->insert([
                'email' => $this->input('email'),
                'ip_address' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Không làm gián đoạn request nếu bảng logs chưa kịp tạo hoặc lỗi DB
        }
    }
}
