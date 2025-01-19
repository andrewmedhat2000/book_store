<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = $this->categoryService->createCategory($validated);

        return response()->json([
            'message' => 'Category created successfully!',
            'Category' => $category
        ], 201);
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories);
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function trashed()
    {
        $trashedCategories = $this->categoryService->getTrashedCategories();
        return response()->json($trashedCategories);
    }
}
