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
        // 1. Tài khoản Quản trị hệ thống (Sysadmin)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'      => 'System Admin',
                'password'  => Hash::make('12345678'),
                'role'      => 'sysadmin',
                'is_active' => true,
            ]
        );

        // 2. Tài khoản Chủ shop (Owner)
        User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name'      => 'Chủ Cửa Hàng',
                'password'  => Hash::make('12345678'),
                'role'      => 'owner',
                'is_active' => true,
            ]
        );

        // 3. Tài khoản Nhân viên bán hàng (Staff)
        User::updateOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'name'      => 'Nhân Viên Bán Hàng',
                'password'  => Hash::make('12345678'),
                'role'      => 'staff',
                'is_active' => true,
            ]
        );
    }
}
