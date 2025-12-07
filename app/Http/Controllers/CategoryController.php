<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        if($categories->isEmpty()){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Category not found'
                ],
                404

            );
        }
        
        return response()->json(
            [
                'success' => true,
                'data' => $categories,
                'message' => 'Category retrieved successfully'
            ]
        );
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $category = Category::create([
            'category_name' => $request->category_name,
        ]);

        $category->refresh();

        return response()->json([
            'message' => 'Category created successfully',
            'jobpost' => $category,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Category not found'
                ],
                404

            );
        }

        return response()->json([
        'success' => true,
        'data' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Category not found'
                ],
                404

            );
        }

        $category->category_name = $request->category_name;
        $category->save();

         return response()->json([
            'success' => true,
            'message' => 'Category updated successfully'
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Category not found'
                ],
                404

            );
        }

        
        $category->delete();

         return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
            ], 200);
    }
}
