<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Các dòng đã bán ra của sản phẩm này (dùng để tính Best Seller)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
