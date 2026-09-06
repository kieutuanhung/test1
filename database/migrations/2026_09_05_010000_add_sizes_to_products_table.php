<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Thêm cột "sizes" (danh sách size có sẵn, lưu dạng chuỗi phân cách bởi dấu phẩy, VD: "S,M,L,XL")
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sizes')->nullable()->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('sizes');
        });
    }
};
