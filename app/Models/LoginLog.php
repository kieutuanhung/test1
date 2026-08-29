<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    public $timestamps = false; // Bảng này chỉ dùng trường logged_in_at

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'logged_in_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
