<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CustomerApiController extends Controller
{

    // عرض كل المنتجات
    public function products()
    {
        $products = Product::all();

        return response()->json($products);
    }


    // إضافة للسلة
    public function addToCart(Request $request, $productId)
    {

        $user = Auth::user();

        $quantity = $request->quantity ?? 1;

        $product = Product::find($productId);

        if ($product->stock < $quantity) {
            return response()->json([
                "message" => "الكمية غير متوفرة",
                "stock" => $product->stock
            ],400);
        }

        $cart = Cart::firstOrCreate(
            ['user_id'=>$user->id,'status'=>'active']
        );


        $cartItem = CartItem::where('cart_id',$cart->id)
            ->where('product_id',$product->id)
            ->first();

        if($cartItem){

            $cartItem->quantity += $quantity;
            $cartItem->save();

        }else{

            CartItem::create([
                "cart_id"=>$cart->id,
                "product_id"=>$product->id,
                "quantity"=>$quantity,
                "price"=>$product->price
            ]);

        }

        $product->stock -= $quantity;
        $product->save();

        return response()->json([
            "message"=>"product added to cart"
        ]);
    }


    // عرض السلة
    public function cart()
    {

        $user = Auth::user();

        $cart = Cart::where('user_id',$user->id)
            ->where('status','active')
            ->with('items.product')
            ->first();

        return response()->json($cart);
    }


    // حذف منتج من السلة
    public function removeFromCart($id)
    {

        $cartItem = CartItem::findOrFail($id);

        $product = $cartItem->product;

        $product->stock += $cartItem->quantity;

        $product->save();

        $cartItem->delete();

        return response()->json([
            "message"=>"item removed"
        ]);
    }


    // إنشاء طلب
    public function buy($cartId, Request $request)
    {

        $request->validate([
            'address'=>'required|string|min:5|max:255',
            'phone'=>'required|string|min:11|max:15',
            'website_url'=>'required|url',
            'total_price'=>'required|numeric'
        ]);

        $cart = Cart::findOrFail($cartId);

        $user = Auth::user();

        $cart->status = "completed";
        $cart->save();


        $order = Order::create([
            "customer_id"=>$user->id,
            "status"=>"pending",
            "payment_status"=>"unpaid",
            "total_price"=>$request->total_price,
            "phone"=>$request->phone,
            "address"=>$request->address,
            "website_url"=>$request->website_url
        ]);


        foreach($cart->items as $item){

            OrderItem::create([
                "order_id"=>$order->id,
                "product_id"=>$item->product_id,
                "quantity"=>$item->quantity,
                "price"=>$item->price
            ]);

        }

        return response()->json([
            "message"=>"order created",
            "order"=>$order
        ]);
    }


    // عرض الطلبات
    public function orders()
    {

        $userId = Auth::user()->id;

        $orders = Order::where('customer_id',$userId)
            ->with('items.product')
            ->orderBy('created_at','desc')
            ->get();

        return response()->json($orders);
    }


    // تأكيد الاستلام
    public function received($id)
    {

        $order = Order::findOrFail($id);

        $order->update([
            "status"=>"received"
        ]);

        return response()->json([
            "message"=>"order received"
        ]);
    }


    // البحث عن المنتجات
    public function search(Request $request)
    {

        $products = Product::where("name","LIKE","%$request->search%")->get();

        return response()->json($products);
    }


    // إلغاء الطلب
    public function cancel($id)
    {

        $order = Order::findOrFail($id);

        $order->update([
            "status"=>"canceled"
        ]);

        return response()->json([
            "message"=>"order canceled"
        ]);
    }

}