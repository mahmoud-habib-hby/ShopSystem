<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Order;
use App\Models\Product;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // العنصر ينتمي إلى طلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // العنصر ينتمي إلى منتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
