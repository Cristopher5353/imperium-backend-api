<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }   

    public function getCategoriesAll() {
        $response = $this->categoryService->getCategoriesAll();

        return response()->json($response);
    }

    public function getCategories(int $page) {
        $response = $this->categoryService->getCategories($page);

        return response()->json($response);
    }

    public function getCategoriesActive() {
        $response = $this->categoryService->getCategoriesActive();

        return response()->json($response);
    }

    public function getSubcategoriesByIdCategory(int $id) {
        $response = $this->categoryService->getSubcategoriesByIdCategory($id);

        return response()->json($response);
    }

    public function getCategoryById(int $id) {
        $response = $this->categoryService->getCategoryById($id);
        
        return response()->json($response);
    }

    public function saveCategory(Request $request) {
        $response = $this->categoryService->saveCategory($request);

        return response()->json($response);
    }

    public function updateCategory(Request $request, int $id) {
        $response = $this->categoryService->updateCategory($request, $id);

        return response()->json($response);
    }

    public function changeStateCategory(int $id) {
        $response = $this->categoryService->changeStateCategory($id);

        return response()->json($response);
    }
}
