<?php

namespace App\Repositories;

use DB;
use App\Models\Subcategory;
use App\Custom\NumberRows;

class SubcategoryRepository {
    public function getSubcategoriesAll() {
        $categories = DB::table('subcategories')
                        ->join('categories', 'subcategories.category_id', 'categories.id')
                        ->select('subcategories.id AS id', 'categories.name AS category', 'subcategories.name AS subcategory', 'subcategories.state AS state', 'subcategories.created_at AS created_at')
                        ->get();
                        
        return $categories;
    }

    public function getSubcategories(int $page) {
        $categories = DB::table('subcategories')
                        ->join('categories', 'subcategories.category_id', 'categories.id')
                        ->select('subcategories.id AS id', 'categories.name AS category', 'subcategories.name AS subcategory', 'subcategories.state AS state', 'subcategories.created_at AS created_at')
                        ->skip($page * NumberRows::numberRows())
                        ->limit(NumberRows::numberRows())
                        ->get();

        return $categories;
    }

    public function getSubcategoryById(int $id) {
        return Subcategory::findorfail($id);
    }

    public function saveSubcategory(Subcategory $subcategory) {
        $subcategory->save();
    }

    public function updateSubcategory(Subcategory $subcategory) {
        $subcategory->update();
    }
}