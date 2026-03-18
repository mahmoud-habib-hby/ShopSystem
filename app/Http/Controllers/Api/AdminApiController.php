<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminApiController extends Controller
{

    // إضافة دليفري
 public function delivery(Request $request) 
{ 
    $request->validate([ 
        'name' => 'required|string|max:255', 
        'email' => 'required|email|unique:users,email', 
        'password' => 'required|confirmed|min:6',
        'phone' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]); 

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('users', 'public');
    }

    $delivery = User::create([ 
        'name' => $request->name, 
        'email' => $request->email, 
        'password' => Hash::make($request->password), 
        'phone' => $request->phone, 
        'role' => 'delivery',
        'image' => $imagePath,
    ]); 

    return response()->json([ 
        "message" => "Delivery created successfully", 
        "data" => [
            ...$delivery->toArray(),
            "image_url" => $imagePath ? asset('storage/' . $imagePath) : null
        ]
    ], 201); 
}

    // عرض كل الدليفري
    public function deliveries()
    {
        $deliveries = User::where('role', 'delivery')->get();

        return response()->json($deliveries);
    }


    // تفاصيل طلبات دليفري معين
    public function details($id)
    {
        $orders = Order::where("delivery_id", $id)->get();

        return response()->json($orders);
    }


    // عرض كل الطلبات
    public function orders()
    {
        $orders = Order::all();

        return response()->json($orders);
    }


    // تسوية الدفع
    public function money($id)
    {
        $order = Order::findOrFail($id);

        $order->payment_status = "settled";
        $order->save();

        return response()->json([
            "message" => "Payment settled successfully",
            "order" => $order
        ]);
    }


    // البحث عن طلب
    public function search(Request $request)
    {
        $orders = Order::where('id', $request->search)->get();

        return response()->json($orders);
    }


    // البحث عن دليفري
    public function search_delivery(Request $request)
    {
        $deliveries = User::where('id', $request->search)->get();

        return response()->json($deliveries);
    }


    // المنتجات المحذوفة
    public function delete()
    {
        $products = Product::where("status", "deleted")->get();

        return response()->json($products);
    }


    // استرجاع المنتج
    public function active($id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            "status" => "active"
        ]);

        return response()->json([
            "message" => "Product activated successfully",
            "product" => $product
        ]);
    }
}