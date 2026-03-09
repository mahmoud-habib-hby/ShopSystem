<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    // عرض كل المنتجات
    public function index()
    {
                $role=Auth::user()->role;
            if(!$role || $role!=="admin"){
                return redirect()->back()->with("error","admin only");
            }
        $products = Product::all();
        return view('admin.index.products', compact('products'));
    }

    // عرض صفحة إضافة منتج
    public function create()
    {
        return view('admin.add.product');
    }

    // حفظ المنتج الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            "category"=>"required",
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'category'=>$request->category,
        ]);

        return redirect()->route('product.index')->with('success', 'Product Added Successfully');
    }

    // عرض صفحة تعديل المنتج
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.update.product', compact('product'));
    }

    // تحديث المنتج
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image',
            'category'=>'required',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category'=>$request->category
        ]);

        return redirect()->route('product.index')->with('success', 'Product Updated Successfully');
    }

    // حذف المنتج
public function destroy($id)
{
    $product = Product::findOrFail($id);
    
    // تحديث order_items
    $product->update([
        "status"=>"deleted"
    ]);
    $product->save();
    
    return redirect()->route('product.index')->with('success', 'Product Deleted Successfully');
}
    public function AddStock(Request $request ,$id){
        $product=Product::findOrFail($id);
        $product->stock=$product->stock+$request->stock;
        $product->save();
        return redirect()->back();
    }
        public function RemoveStock(Request $request ,$id){
        $product=Product::findOrFail($id);
        $product->stock=$product->stock-$request->stock;
        $product->save();
        return redirect()->back();
    }
}