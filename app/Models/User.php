<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // ← لازم تضيف السطر ده
use App\Models\Order;
use App\Models\Cart;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory; // ← مهم جدًا تضيف HasApiTokens

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        "phone",
        'role', // admin, delivery, customer
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // علاقة الزبائن مع Orders
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // علاقة الدليفرى مع Orders
    public function deliveries()
    {
        return $this->hasMany(Order::class, 'delivery_id');
    }

    // المستخدم لديه عدة سلات
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}