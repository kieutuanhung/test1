<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'size',
        'price',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        // withTrashed(): vẫn lấy được thông tin sản phẩm (ảnh, tên gốc...) dù sản phẩm
        // đã bị Owner/Staff xóa mềm khỏi shop, để không vỡ trang lịch sử đơn hàng cũ
        return $this->belongsTo(Product::class)->withTrashed();
    }

    // Chỉ khớp nếu sản phẩm gốc VẪN CÒN đang bán (chưa bị xóa mềm) - dùng để loại
    // sản phẩm đã ngừng bán ra khỏi các danh sách "cần làm" như Gom hàng/Nhập kho
    public function activeProduct()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
