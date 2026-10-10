<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // Người thực hiện (null nếu là hệ thống / khách quét QR chưa đăng nhập)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Bản chụp thông tin người thực hiện, phòng khi user bị xóa hoặc đổi role sau này
            $table->string('user_email')->nullable();
            $table->string('user_role', 50)->nullable();

            // Hành động, ví dụ: order.status_changed, order.refunded, user.role_changed
            $table->string('action', 100)->index();

            // Đối tượng bị tác động (Order, User, Product, Category...)
            $table->string('target_type', 100)->nullable();
            $table->unsignedBigInteger('target_id')->nullable();

            // Giá trị trước và sau khi thay đổi (JSON). KHÔNG lưu mật khẩu/token.
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            // Chỉ có created_at: audit log không bao giờ được sửa
            $table->timestamp('created_at')->useCurrent()->index();

            $table->index(['target_type', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
