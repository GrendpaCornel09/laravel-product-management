<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Http\Request;
use illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use ReturnTypeWillChange;

$token=['test123'];

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $products=Product::all();
        if(count($products)<1){
            return response()->json(['Products unavailable'],400);
        }
        return response()->json(['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:50',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0'
        ],[
            'name.required'=>'Nama produk tidak boleh kosong.',
            'name.string'=>'Nama produk harus berupa string.',
            'name.max'=>'Nama produk tidak boleh melebihi 50 karakter.',
            'price.required'=>'Harga produk tidak boleh kosong.',
            'price.numeric'=>'Harga produk harus berupa angka.',
            'price.min'=>'Harga produk tidak boleh negatif',
            'stock.required'=>'Stok produk tidak boleh kosong.',
            'stock.integer'=>'Stok produk harus berupa integer.',
            'stock.min'=>'Stok produk tidak boleh negatif.'
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->all();
            $errorMessage=implode(', ',$errors);
            return response()->json([$errorMessage],400);
        }

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
            return response()->json(['message'=>'Produk tidak ditemukan'],400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:50',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0'
        ],[
            'name.required'=>'Nama produk tidak boleh kosong.',
            'name.string'=>'Nama produk harus berupa string.',
            'name.max'=>'Nama produk tidak boleh melebihi 50 karakter.',
            'price.required'=>'Harga produk tidak boleh kosong.',
            'price.numeric'=>'Harga produk harus berupa angka.',
            'price.min'=>'Harga produk tidak boleh negatif',
            'stock.required'=>'Stok produk tidak boleh kosong.',
            'stock.integer'=>'Stok produk harus berupa integer.',
            'stock.min'=>'Stok produk tidak boleh negatif.'
        ]);

        if($validator->fails()){
            $errors=$validator->errors()->all();
            $errorMessage=implode(', ',$errors);
            return response()->json([$errorMessage],400);
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
