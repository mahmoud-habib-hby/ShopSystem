<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
        public function DeliveryForm(){
        return view("admin.add.Delivery");
    }
        public function Delivery(Request $request){
            $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
            // 'role' => 'required|in:admin,delivery,customer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            "phone"=>$request->phone,
            'role' => 'delivery',
        ]);
        return redirect('product'); 
    }
    public function deliveries()
{
    $deliveries = User::where('role', 'delivery')->get();

    return view('admin.index.Delivery', compact('deliveries'));
}
public function details($id){
$order=Order::where("delivery_id",$id)->get();
return view("admin.show.Delivery",compact("order"));
}
}
