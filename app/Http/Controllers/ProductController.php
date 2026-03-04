<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // عرض كل المنتجات
    public function index()
    {
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
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully');
    }
}