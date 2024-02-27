<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Create a new category
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create([
            'name' => trim(ucfirst($request->name)),
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Category created successfully', 'category' => $category]);
    }

    // Show a single category
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }

    // Update a category
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->name = trim(ucfirst($request->name));
        $category->description = $request->description;
        $category->save();

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    // Delete a category
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
