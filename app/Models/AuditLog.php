<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use LogicException;

class AuditLog extends Model
{
    // Bảng chỉ có created_at, tự gán trong record()
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'user_email',
        'user_role',
        'action',
        'target_type',
        'target_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    // Các trường tuyệt đối không được ghi vào log
    private const SENSITIVE_KEYS = [
        'password',
        'password_confirmation',
        'current_password',
        'remember_token',
        'payment_code',
        'token',
    ];

    /**
     * Audit log là bằng chứng nên không cho sửa/xóa qua Eloquent.
     */
    protected static function booted(): void
    {
        static::updating(function () {
            throw new LogicException('Audit log không được phép chỉnh sửa.');
        });

        static::deleting(function () {
            throw new LogicException('Audit log không được phép xóa.');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ghi một dòng audit log.
     *
     * @param string      $action  VD: 'order.status_changed'
     * @param Model|null  $target  Đối tượng bị tác động (Order, User, Product...)
     * @param array|null  $old     Giá trị trước khi đổi
     * @param array|null  $new     Giá trị sau khi đổi
     */
    public static function record(
        string $action,
        ?Model $target = null,
        ?array $old = null,
        ?array $new = null
    ): void {
        try {
            $actor = Auth::user();
            $request = request();

            static::create([
                'user_id'     => $actor?->id,
                'user_email'  => $actor?->email,
                'user_role'   => $actor?->role,
                'action'      => $action,
                'target_type' => $target ? class_basename($target) : null,
                'target_id'   => $target?->getKey(),
                'old_values'  => $old ? Arr::except($old, self::SENSITIVE_KEYS) : null,
                'new_values'  => $new ? Arr::except($new, self::SENSITIVE_KEYS) : null,
                'ip_address'  => $request?->ip(),
                'user_agent'  => $request ? mb_substr((string) $request->userAgent(), 0, 255) : null,
                'created_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            // Lỗi ghi log không được làm hỏng nghiệp vụ chính
            report($e);
        }
    }

    /**
     * So sánh 2 mảng giá trị, chỉ trả về các trường THỰC SỰ thay đổi.
     *
     * @return array{0: array, 1: array}  [giá trị cũ đã đổi, giá trị mới đã đổi]
     */
    public static function diff(array $before, array $after): array
    {
        $normalize = function ($v) {
            if (is_bool($v)) {
                return (string) (int) $v;
            }
            if (is_numeric($v)) {
                return (string) (float) $v; // '100000.00' == '100000'
            }
            return (string) $v;
        };

        $old = [];
        $new = [];

        foreach ($after as $key => $value) {
            $prev = $before[$key] ?? null;
            if ($normalize($prev) !== $normalize($value)) {
                $old[$key] = $prev;
                $new[$key] = $value;
            }
        }

        return [$old, $new];
    }
}
