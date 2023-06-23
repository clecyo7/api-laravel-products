<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductServices
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function index(Request $request)
    {
        return $this->productRepository->index($request);
    }

    public function show($id)
    {
        return $this->productRepository->show($id);
    }

    public function create($request)
    {
        //busca na base se já existi
        $productSearch = Product::Where('name', '=', "$request->name")->first();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $name = Str::kebab($request->name);
            $extension = $request->image->extension();
            $nameFile = "{$name}.{$extension}";
        }

        // se não existir será feito o cadastro
        if (!isset($productSearch->name)) {
            return $this->productRepository->create($request, $nameFile);
            //caso já exista na base devolve o erro.
        } else {
            return response()->json(['status' => 'error', 'message' => 'Produto já existente na base', 500]);
        }
    }

    public function update($request, $id)
    {
        if (!$product = Product::find($id))
            return response()->json(['error' => 'Produto não encontrado'], 404);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            //DELETE NA IMAGE ANTERIOR
            if ($product->image) {
                if (Storage::exists("products/{$product->image}")) //VERIFICA SE EXISTE
                    Storage::delete("products/{$product->image}"); //SE EXISTER SERÁ DELETEDO
            }
            $name = Str::kebab($request->name); //MUDA O NOME
            $extension = $request->image->extension(); //PEGA EXTENSION DA IMAGE
            $nameFile = "{$name}.{$extension}"; // SALV O NOVO NOME
        }
        return $this->productRepository->update($request, $id, $nameFile);
    }
}
