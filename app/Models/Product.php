<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'sizes',
        'image',
        'is_new_arrival',
        'is_best_seller',
    ];

    protected $casts = [
        'is_new_arrival' => 'boolean',
        'is_best_seller' => 'boolean',
    ];

    // Trả về danh sách size dưới dạng mảng, VD: "S, M, L" -> ['S', 'M', 'L']
    public function getSizeListAttribute()
    {
        if (!$this->sizes) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->sizes))));
    }

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
