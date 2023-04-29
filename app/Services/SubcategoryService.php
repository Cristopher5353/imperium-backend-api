<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SubcategoryRepository;
use App\Models\Subcategory;
use App\Custom\ValidateExistById;
use App\Custom\TotalPages;

class SubcategoryService {
    protected $subcategoryRepository;

    public function __construct(SubcategoryRepository $subcategoryRepository) {
        $this->subcategoryRepository = $subcategoryRepository;
    }

    public function getSubcategories(int $page) {
        $subcategoriesAll = $this->subcategoryRepository->getSubcategoriesAll();
        $subcategories = $this->subcategoryRepository->getSubcategories($page);
        $totalPages = TotalPages::totalPages($subcategoriesAll->count());

        return [
            "status" => 200,
            "message" => "Listado de subcategorías",
            "data" => $subcategories,
            "totalPages" => $totalPages
        ];
    }

    public function getSubcategoryById(int $id) {
        $response = ValidateExistById::validateExistById($id, "subcategories", "Subcategoría");

        if($response[0]["confirm"]) return $response[1];

        $subcategory = $this->subcategoryRepository->getSubcategoryById($id);

        return [
            "status" => 200,
            "message" => "Subcategoría enviada correctamente",
            "data" => $subcategory
        ];
    }

    public function saveSubcategory(Request $request) {
        $validator = Validator::make($request->all(), [
            'category_id' => 'exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return [
                "status" => 400,
                "message" => "Errores al registrar la Subcategoría",
                "data" => [$validator->errors()]
            ];
        }

        $subcategory = new Subcategory();
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->state = 1;

        $this->subcategoryRepository->saveSubcategory($subcategory);

        return [
            "status" => 201,
            "message" => "Subcategoría registrada correctamente",
            "data" => []
        ];
    }

    public function updateSubcategory(Request $request, int $id) {
        $response = ValidateExistById::validateExistById($id, "subcategories", "Subcategoría");

        if($response[0]["confirm"]) return $response[1];

        $validator = Validator::make($request->all(), [
            'category_id' => 'exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return [
                "status" => 400,
                "message" => "Errores al actualizar la Subcategoría",
                "data" => [$validator->errors()]
            ];
        }

        $subcategory = $this->subcategoryRepository->getSubcategoryById($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;

        $this->subcategoryRepository->updateSubcategory($subcategory);

        return [
            "status" => 200,
            "message" => "Subcategoría actualizada correctamente",
            "data" => []
        ];
    }

    public function changeStateSubcategory(int $id) {
        $response = ValidateExistById::validateExistById($id, "subcategories", "Subcategoría");

        if($response[0]["confirm"]) return $response[1];

        $subcategory = $this->subcategoryRepository->getSubcategoryById($id);
        $subcategory->state = ($subcategory->state == 1) ?0 :1;

        $this->subcategoryRepository->updateSubcategory($subcategory);

        return [
            "status" => 200,
            "message" => "Subcategoría actualizada correctamente",
            "data" => []
        ];
    }
}