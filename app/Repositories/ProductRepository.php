<?php 

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;


class ProductRepository 
{

    public function index() {
        $product = Product::orderBy('id', 'asc')->get();
        return response()->json(['data' => $product], 200);
    }

    public function show($id) {
        if(!$product = Product::with('assessments')
        ->where('id', $id)
        ->first())
        return response()->json(['data' => 'Produto não Encontrado'], 404);

        return response()->json(['data' => $product], 200);
    }


    public function create1($request) {
        try {
            $product = Product::create($request->all());
            if ($product) 
                return response()->json(['success' => 'Produto criado com sucesso!', 'data' => $this->show($product->id)]);
           
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro ao criar o produto.'], 500);
        }
    }


    public function create($request) {
        try {
            $product = Product::create($request->all());
            if ($product) 
                return response()->json(['success' => 'Produto criado com sucesso!', 'data' => $this->show($product->id)]);
            
        } catch (\Exception $e) {
            // Mensagem de erro detalhada para depuração
            dd($e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro ao criar o produto.'], 500);
        }
    }
    
}

