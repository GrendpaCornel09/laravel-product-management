<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Http\Request;
use illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
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
        // $validated_data=$request->validate([
        //     'name'=>'required',
        //     'price'=>'required|numeric',
        //     'stock'=>'required|integer',
        // ]);

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required|numeric',
            'stock'=>'required|integer'
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->all();
            $errorMessage=implode(', ',$errors);
            return response()->json($errorMessage);
        }

        $products=Product::create($request->all());
        return response()->json(['products'=>$products]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $product=Product::findOrFail($id);
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
        // $validated_data=$request->validate([
        //     'name'=>'required',
        //     'price'=>'required|numeric',
        //     'stock'=>'required|integer',
        // ]);

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required|numeric',
            'stock'=>'required|integer',
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->all();
            $errorMessage=implode(', ',$errors);
            return response()->json($errorMessage);
        }

        $product=Product::find($id);
        if(!$product){
            return response()->json(['message'=>'Produk tidak ditemukan'],404);
        }

        $product->update($request->all());
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
