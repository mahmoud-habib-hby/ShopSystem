<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index(){
        $orders=Order::where("status","pending")->get();
        return view("Delivery.now",compact("orders"));
    }
    public function show($id){
        $orderItems=OrderItem::where("order_id",$id)->with("product")->get();
        return view("Delivery.details",compact("orderItems"));
    }
public function add($id){
    $userId = Auth::user()->id;
    
    // تحديث طلب معين
    Order::where('id', $id)->update([
        "status" => "assigned",
        "delivery_id" => $userId,
    ]);
    
    return redirect()->back()->with('success', 'تم تعيين الطلب بنجاح');
}
public function work(){
    $userId = Auth::user()->id;
    $orders= Order::where('delivery_id', $userId)->whereIn('status', ['assigned', 'delivered'])->get();
    return view("Delivery.work",compact("orders"));
}
public function delivered($id) {
        Order::where('id', $id)->update([
        "status" => "delivered",
    ]);
    return redirect()->back()->with('success', 'تم تعيين الطلب بنجاح');
}
public function past(){
    $userId=Auth::user()->id;
    $orders= Order::where("delivery_id",$userId)->get();
    return view("Delivery.Past",compact("orders"));
}
}
