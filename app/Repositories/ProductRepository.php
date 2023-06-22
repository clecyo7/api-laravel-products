<?php 

namespace App\Repositories;

use App\Models\Product;

class ProductRepository 
{

    public function index() {
        $product = Product::orderBy('id', 'asc')->get();
        return response()->json(['data' => $product], 200);
    }

    public function show($id) {
        if(!$product = Product::find($id))
        return response()->json(['data' => 'Produto não Encontrado'], 404);

        return response()->json(['data' => $product], 200);
    }
}