<?php

use App\Http\Middleware\EnforceAccountStanding;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckPasswordExpiry;
use App\Models\LoginLog;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');
	$middleware->web(append: [
            EnforceAccountStanding::class,
        ]);

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'admin' => AdminMiddleware::class,
            'password.expiry' => CheckPasswordExpiry::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Ghi log khi POST /login bị chặn bởi throttle:5,1 ở route (HTTP 429).
        // Trả về null để Laravel vẫn hiển thị trang 429 như bình thường.
        $exceptions->render(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->isMethod('post') && $request->is('login')) {
                try {
                    LoginLog::create([
                        'user_id'      => null,
                        'email'        => Str::limit((string) $request->input('email', ''), 255, ''),
                        'ip_address'   => $request->ip(),
                        'user_agent'   => Str::limit((string) $request->userAgent(), 255, ''),
                        'status'       => 'login_locked',
                        'logged_in_at' => now(),
                    ]);
                } catch (\Throwable $ex) {
                    report($ex); // lỗi ghi log không được làm hỏng trang lỗi
                }
            }

            return null;
        });
    })->create();
