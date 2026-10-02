<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('login_logs', function (Blueprint $table) {
            // Lưu loại sự kiện: account_activated, account_deactivated, ...
            // nullable để các dòng log cũ không bị ảnh hưởng
            $table->string('status', 50)->nullable()->after('user_agent');
        });
    }

    public function down(): void
    {
        Schema::table('login_logs', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
