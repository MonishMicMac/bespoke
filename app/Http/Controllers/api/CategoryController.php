<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function view()
    {
        // dd('uiyghiyuh');
        // Fetch categories where action is 0 and select only the required fields
        $categoriesview = Category::select('id', 'name', 'img_path', 'action')
            ->where('action', '0')
            ->get();

        // Fetch subcategories where action is 0 and select only the required fields
        $subcategoriesview = Subcategory::select('id', 'name', 'category_id', 'img_path', 'action')
            ->where('action', '0')
            ->get();

        // Check if both categories and subcategories exist
        if ($categoriesview->isEmpty() && $subcategoriesview->isEmpty()) {
            return response()->json([
                'status' => 'Error',
                'message' => 'No records found',
            ]);
        }

        // Map subcategories to their respective categories
        $categoriesview->map(function ($category) use ($subcategoriesview) {
            $category->subcategories = $subcategoriesview->where('category_id', $category->id)->values();
            return $category;
        });

        // Return success response with categories (including nested subcategories)
        return response()->json([
            'status' => 'Success',
            'message' => 'Data retrieved successfully',
            'categories' => $categoriesview,
        ]);
    }
}
