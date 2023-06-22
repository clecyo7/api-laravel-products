<?php


namespace App\Repositories;

use App\Models\Category;

class CategoryRepository 
{

    public function index() {
        $category = Category::orderBy('id','asc')->get();
        return response()->json(['data' => $category], 200);
    }

    public function show($id) {
        if(!$category = Category::find($id))
        return response()->json(['error' => 'Produto não encontrado'], 404);

        return response()->json(['data' => $category]);
    }
}
