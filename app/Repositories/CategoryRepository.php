<?php

namespace App\Repositories;

use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;
use App\Models\Subcategory;
use App\Custom\NumberRows;

class CategoryRepository {
    public function getCategoriesAll() {
        return Category::all();
    }

    public function getCategories(int $page) {
        $categories = DB::table('categories')
                        ->select('categories.id', 'categories.name', 'categories.state', 'categories.created_at', 'categories.updated_at')
                        ->skip($page * NumberRows::numberRows())
                        ->limit(NumberRows::numberRows())
                        ->get();
        return $categories;
    }

    public function getCategoriesActive() {
        return Category::where('state', 1)->get();
    }

    public function getSubcategoriesByIdCategory(int $id) {
        return Subcategory::where('category_id', $id)->get();
    }

    public function getCategoryById(int $id) {
        return Category::find($id);
    }

    public function saveCategory(Category $category) {
        $category->save();
    }

    public function updateCategory(Category $category) {
        $category->update();
    }
}