<?php 

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryServices 
{
    public function __construct(protected CategoryRepository $categoryRepository){}

    public function index(Request $request) {
        return $this->categoryRepository->index($request);
    }

    public function show(int $id) {
        return $this->categoryRepository->show($id);
    }


}