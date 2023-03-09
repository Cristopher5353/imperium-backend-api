<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryRepository {
    public function getCategories() {
        return Category::all();
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