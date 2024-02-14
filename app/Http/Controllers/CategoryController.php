<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::all();
        if($categories){
            return response()->json($categories, 200);

        } else{

            return response()->json([
                "message" => "Error occured while processing your request"
              ], 404);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => ['required','unique:categories,name'],
            'status' => ['required']
        ]);
        
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
     
       $category = new Category();
       $category->name = $request->name;
       $category->status = $request->status;
       $category->save();
       return response($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message'=> 'Deleted Successfully!!',
            ]);
           
        } catch (\Throwable $th) {
            return response()->json(['error' => 'No Category Asscociated with that ID!!.'], 404);
        }
       
    }
}
