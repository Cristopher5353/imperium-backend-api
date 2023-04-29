<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoryRepository;
use App\Models\Category;
use App\Custom\ValidateExistById;
use App\Custom\TotalPages;

class CategoryService {
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoriesAll() {
        $categoriesAll = $this->categoryRepository->getCategoriesAll();

        return [
            "status" => 200,
            "message" => "Listado de prioridades",
            "data" => $categoriesAll,
        ];
    }

    public function getCategories(int $page) {
        $categoriesAll = $this->categoryRepository->getCategoriesAll();
        $categories = $this->categoryRepository->getCategories($page);
        $totalPages = TotalPages::totalPages($categoriesAll->count());

        return [
            "status" => 200,
            "message" => "Listado de prioridades",
            "data" => $categories,
            "totalPages" => $totalPages
        ];
    }

    public function getCategoriesActive() {
        $categories = $this->categoryRepository->getCategoriesActive();

        return [
            "status" => 200,
            "message" => "Listado de categorías activas",
            "data" => $categories
        ];
    }

    public function getSubcategoriesByIdCategory(int $id) {
        $subcategories = $this->categoryRepository->getSubcategoriesByIdCategory($id);

        return [
            "status" => 200,
            "message" => "Listado de subcategorías por categoría",
            "data" => $subcategories
        ];
    }

    public function getCategoryById(int $id) {
        $response = ValidateExistById::validateExistById($id, "categories", "Categoría");

        if($response[0]["confirm"]) return $response[1];

        $category = $this->categoryRepository->getCategoryById($id);

        return [
            "status" => 200,
            "message" => "Categoría enviada correctamente",
            "data" => $category
        ];
    }

    public function saveCategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return [
                "status" => 400,
                "message" => "Errores al registrar la categoría",
                "data" => [$validator->errors()]
            ];
        }

        $category = new Category();
        $category->name = $request->name;
        $category->state = 1;

        $this->categoryRepository->saveCategory($category);

        return [
            "status" => 201,
            "message" => "Categoría registrada correctamente",
            "data" => []
        ];
    }

    public function updateCategory(Request $request, int $id) {
        $response = ValidateExistById::validateExistById($id, "categories", "Categoría");

        if($response[0]["confirm"]) return $response[1];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return [
                "status" => 400,
                "message" => "Errores al actualizar la categoría",
                "data" => [$validator->errors()]
            ];
        }

        $category = $this->categoryRepository->getCategoryById($id);
        $category->name = $request->name;

        $this->categoryRepository->updateCategory($category);

        return [
            "status" => 200,
            "message" => "Categoría actualizada correctamente",
            "data" => []
        ];
    }

    public function changeStateCategory(int $id) {
        $response = ValidateExistById::validateExistById($id, "categories", "Categoría");

        if($response[0]["confirm"]) return $response[1];

        $category = $this->categoryRepository->getCategoryById($id);
        $category->state = ($category->state == 1) ?0 :1;

        $this->categoryRepository->updateCategory($category);

        return [
            "status" => 200,
            "message" => "Categoría actualizada correctamente",
            "data" => []
        ];
    }
}