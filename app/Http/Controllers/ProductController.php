<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use illuminate\Http\JsonResponse;
use ReturnTypeWillChange;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products=Product::all();
        return response()->json(['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated_data=$request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
        ]);

        $products=Product::create($request->all());
        return response()->json(['products'=>$products]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $product=Product::find($id);
        if($product){
            return response()->json(['product'=>$product]);
        }else{
            return response()->json(['message'=>'Produk tidak ditemukan'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated_data=$request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
        ]);
        $product=Product::find($id);
        if(!$product){
            return response()->json(['message'=>'Produk tidak ditemukan'],404);
        }

        $product->update($validated_data);
        return response()->json(['message'=>'Produk berhasil diupdate','product'=>$product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $product=Product::find($id);
        if(!$product){
            return response()->json(['message'=>'Produk tidak ditemukan'],404);
        }

        $product->delete();
        return response()->json(['message'=>'Produk berhasil dihapus']);
    }
}
