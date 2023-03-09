<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubcategoryService;

class SubcategoryController extends Controller
{
    protected $subcategoryService;

    public function __construct(SubcategoryService $subcategoryService) {
        $this->subcategoryService = $subcategoryService;
    }   

    public function getSubcategories() {
        $response = $this->subcategoryService->getSubcategories();

        return response()->json($response);
    }

    public function getSubcategoryById(int $id) {
        $response = $this->subcategoryService->getSubcategoryById($id);
        return response()->json($response);
    }

    public function saveSubcategory(Request $request) {
        $response = $this->subcategoryService->saveSubcategory($request);

        return response()->json($response);
    }
    
    public function updateSubcategory(Request $request, int $id) {
        $response = $this->subcategoryService->updateSubcategory($request, $id);

        return response()->json($response);
    }

    public function changeStateSubcategory(int $id) {
        $response = $this->subcategoryService->changeStateSubcategory($id);

        return response()->json($response);
    }
}
