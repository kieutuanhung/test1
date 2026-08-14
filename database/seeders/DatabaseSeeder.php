<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo tài khoản Admin mặc định nếu chưa tồn tại
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Quản Trị Viên',
                'password' => Hash::make('12345678'), // Mật khẩu đăng nhập
                'role'     => 'admin',
            ]
        );
    }
}
