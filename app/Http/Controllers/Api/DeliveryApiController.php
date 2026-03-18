<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class DeliveryApiController extends Controller
{

    // عرض الطلبات الجديدة
    public function orders()
    {

        $orders = Order::where("status","pending")->get();

        return response()->json($orders);
    }


    // تفاصيل الطلب
    public function details($id)
    {

        $orderItems = OrderItem::where("order_id",$id)
            ->with("product")
            ->get();

        return response()->json($orderItems);
    }


    // استلام الطلب
    public function takeOrder($id)
    {

        $userId = Auth::user()->id;

        Order::where('id',$id)->update([
            "status"=>"assigned",
            "delivery_id"=>$userId
        ]);

        return response()->json([
            "message"=>"order assigned successfully"
        ]);
    }


    // الطلبات التي يعمل عليها الدليفري
    public function myOrders()
    {

        $userId = Auth::user()->id;

$orders = Order::where('delivery_id', $userId)
    ->whereIn('status', ['assigned', 'delivered'])
    ->orderBy('created_at', 'desc')
    ->get();

        return response()->json($orders);
    }


    // تم التوصيل
    public function delivered($id)
    {

        Order::where('id',$id)->update([
            "status"=>"delivered"
        ]);

        return response()->json([
            "message"=>"order delivered"
        ]);
    }


    // الطلبات السابقة
    public function pastOrders()
    {

        $userId = Auth::user()->id;

        $orders = Order::where("delivery_id",$userId)->get();

        return response()->json($orders);
    }


    // تحصيل المال
    public function collectMoney($id)
    {

        $order = Order::findOrFail($id);

        $order->payment_status = "collected";

        $order->save();

        return response()->json([
            "message"=>"payment collected"
        ]);
    }

}