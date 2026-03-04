<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',  
        'delivery_id',
        'status',  
        "address",
        "phone",
        'total_price',
        'website_url',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // كل Order لها دليفرى واحد
    public function delivery()
    {
        return $this->belongsTo(User::class, 'delivery_id');
    }

    // كل Order تحتوي على عدة عناصر OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
