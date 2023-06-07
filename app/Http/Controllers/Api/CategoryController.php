<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            Category::create([
                'name' => $request->get('name'),
            ]);

            return response()->json(['message' => 'succes']);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {

        try {
            $category->update([
                'name' => $request->get('title')
            ]);

            return response()->json(['message' => 'succes']);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
