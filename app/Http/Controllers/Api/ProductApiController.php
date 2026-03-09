<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductApiController extends Controller
{

    // عرض كل المنتجات
    public function page(){
        $products=Product::where("status","active")->get();
        return response()->json($products);
    }
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }


    // إضافة منتج
    public function store(Request $request)
    {

        if(Auth::user()->role !== "admin"){
            return response()->json([
                "message"=>"admin only"
            ],403);
        }

        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            // 'image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category'=>'required'
        ]);


        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('products','public');

        }


        $product = Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'image'=>$imagePath,
            'category'=>$request->category
        ]);


        return response()->json([
            "message"=>"product created",
            "product"=>$product
        ],201);
    }


    // عرض منتج واحد
    public function show($id)
    {

        $product = Product::findOrFail($id);

        return response()->json($product);
    }


    // تحديث منتج
    public function update(Request $request,$id)
    {

        if(Auth::user()->role !== "admin"){
            return response()->json([
                "message"=>"admin only"
            ],403);
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
            'image'=>'nullable|image',
            'category'=>'required'
        ]);


        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('products','public');

            $product->image = $imagePath;

        }


        $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'category'=>$request->category
        ]);


        return response()->json([
            "message"=>"product updated",
            "product"=>$product
        ]);
    }


    // حذف المنتج (soft delete logic)
    public function delete($id)
    {

        if(Auth::user()->role !== "admin"){
            return response()->json([
                "message"=>"admin only"
            ],403);
        }

        $product = Product::findOrFail($id);

        $product->update([
            "status"=>"deleted"
        ]);

        return response()->json([
            "message"=>"product deleted"
        ]);
    }


    // إضافة مخزون
    public function addStock(Request $request,$id)
    {

        $product = Product::findOrFail($id);

        $product->stock += $request->stock;

        $product->save();

        return response()->json([
            "message"=>"stock added",
            "stock"=>$product->stock
        ]);
    }


    // تقليل المخزون
    public function removeStock(Request $request,$id)
    {

        $product = Product::findOrFail($id);

        $product->stock -= $request->stock;

        $product->save();

        return response()->json([
            "message"=>"stock removed",
            "stock"=>$product->stock
        ]);
    }

}