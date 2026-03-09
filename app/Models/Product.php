<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// استيراد OrderItem
use App\Models\OrderItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'status',
        "category",
    ];

    // علاقة المنتج مع عناصر الطلب
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function cartItems()
{
    return $this->hasMany(CartItem::class);
}
}
