<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // صفحة عرض كل المنتجات للمستخدم
    public function index()
    {
        $products = Product::all(); 
        return view('customer.Products', compact('products')); 
    }
    
    public function addToCart(Request $request, $productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // جلب الكمية من الرابط (لو مش موجودة يبقى 1)
        $quantity = $request->quantity ?? 1;
        $product = Product::findOrFail($productId);
        
        // التحقق من وجود كمية كافية في المخزون
        if ($product->stock < $quantity) {
            return back()->with('error', "الكمية المطلوبة ($quantity) غير متوفرة. المتاح: {$product->stock}");
        }
        
        // جلب السلة النشطة
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'active'],
            ['user_id' => $user->id, 'status' => 'active']
        );

        // التحقق من وجود المنتج في السلة
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $product->id)
                            ->first();

        if ($cartItem) {
            // لو موجود، زود الكمية بالرقم اللي اختاره العميل
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // لو مش موجود، أضيفه بالكمية الجديدة
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }
        
        $product->stock = $product->stock - $quantity;
        $product->save();
        
        return back()->with('success', "تم إضافة $quantity كجم من {$product->name} للسلة");
    }
    
    public function cart()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->with('items.product') 
                    ->first();

        return view('customer.buy', compact("cart"));
    }
    
    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $product = $cartItem->product;
        $product->stock = $product->stock + $cartItem->quantity;
        $product->save();
        
        CartItem::destroy($id);
        
        return redirect()->route('customer.cart')->with('success', 'Product Deleted Successfully');
    }
    
    public function buy($id, Request $request)
    {
        $request->validate([
            'address' => 'required|string|min:5|max:255',
            'phone' => 'required|string|min:11|max:15',
            'website_url' => 'required|url', // يجب أن يكون رابط صحيح
            'total_price' => 'required|numeric'
        ]);

        $cart = Cart::findOrFail($id);
        $user = Auth::user();
        
        // التحقق من أن السلة تخص المستخدم الحالي
        if ($cart->user_id != $user->id) {
            return redirect()->route('customer.cart')->with('error', 'هذه السلة لا تخصك');
        }
        
        $cart->status = "completed";
        $cart->save();
        
        $order = Order::create([
            "customer_id" => $user->id,
            "status" => "pending",
            "payment_status" => "unpaid",
            "total_price" => $request->total_price,
            "phone" => $request->phone,
            "address" => $request->address,
            'website_url' => $request->website_url
        ]);
        
        foreach($cart->items as $item){
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $item->product_id,
                "quantity" => $item->quantity,
                "price" => $item->price
            ]);
        }
        
        return redirect()->route('customer.cart')->with('success', 'تم إنشاء الطلب بنجاح');
    }
    
    public function order() 
    {
        $userId = Auth::user()->id;
        $orders = Order::where('customer_id', $userId)
                       ->with('items.product')
                        ->orderBy('created_at', 'desc')
                       ->get();
        
        return view('customer.Order', compact('orders'));
    }
    public function received($id){
        Order::findOrFail($id)->update([
            "status"=>"received",
        ]);
        return redirect()->back();
    }
}