<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
        public function DeliveryForm(){
            $user=Auth::user()->role;
            
        return view("admin.add.Delivery");
    }
public function Delivery(Request $request){ 
    $request->validate([ 
        'name' => 'required|string|max:255', 
        'email' => 'required|email|unique:users,email', 
        'password' => 'required|confirmed|min:6',
        'phone' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]); 

    $imagePath = null;

    // رفع الصورة
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('users', 'public');
    }

    User::create([ 
        'name' => $request->name, 
        'email' => $request->email, 
        'password' => Hash::make($request->password), 
        'phone' => $request->phone, 
        'role' => 'delivery',
        'image' => $imagePath, // حفظ مسار الصورة
    ]); 

    return redirect('product');  
}
    public function deliveries()
{
    $deliveries = User::where('role', 'delivery')->get();

    return view('admin.index.Delivery', compact('deliveries'));
}
public function details($id){
$orders=Order::where("delivery_id",$id)->get();
return view("admin.show.Delivery",compact("orders"));
}
public function orders(){
    $orders=Order::all();
    return view("admin.index.orders",compact("orders"));
}
public function money($id)
{
    $order = Order::findOrFail($id);

    $order->payment_status = "settled";

    $order->save();

    return redirect()->back();
}
public function search(Request $request){
    $search_order = Order::where('id',$request->search)->get();
    return view("admin.index.orders",compact("search_order"));
}
public function search_delivery(Request $request){
    $search_delivery=User::where('id',$request->search)->get();
    return view("admin.index.Delivery",compact("search_delivery"));
}
public function delete(){
    $product=Product::where("status","deleted")->get();
    return view("admin.index.delete",compact("product"));
}
public function active($id){
        Product::findOrFail($id)->update([
            "status"=>"active"
        ]);
        return redirect()->back();
}
}
