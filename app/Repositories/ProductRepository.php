<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class ProductRepository
{

    public function index()
    {
        $product = Product::orderBy('id', 'asc')->get();
        return response()->json(['data' => $product], 200);
    }

    public function show($id)
    {
        if (!$product = Product::with('assessments')
            ->where('id', $id)
            ->first())
            return response()->json(['data' => 'Produto não Encontrado'], 404);

        return response()->json(['data' => $product], 200);
    }

    public function create(Request $request, $nameFile)
    {
        DB::beginTransaction();
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->assessments_id = $request->assessments_id;
            $product->image = $request->image;
            if ($product->save()) {
                $upload = $request->image->storeAs('products', $nameFile);
                if (!$upload)
                    return response()->json(['error' => 'Fail_Upload'], 500);

                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Produto foi cadastrado.', 'data' => $this->show($product->id), 201]);
                //return response()->json(['success' => 'Produto criado com sucesso!', 'data' => $this->show($product->id)]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function update($request, $id, $nameFile)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->image = $request->image;
            if ($product->save()) {
                $upload = $request->image->storeAs('products', $nameFile);
                if (!$upload)
                    return response()->json(['error' => 'Fail_Upload'], 500);
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Produto foi atualizado.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
