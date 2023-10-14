<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        return response()->json(['Category list', 'categories' => $categories], 200); 
    }

    public function show(Category $category){
        $categoryFind = Category::find($category->id);
        
        return response()->json(['Specific Category', 'category' => $categoryFind], 200);
    }

    public function store(Request $request){
        $valid = $request->validate([
            'name' => 'required|string',
            'start_range' => 'required|numeric',
            'final_range' => 'required|numeric',
            'duration' => 'required|numeric',
            'interest' => 'required|numeric',
        ]);

        if($valid){
            Category::create([
                'name' => $request->name,
                'start_range' => $request->start_range,
                'final_range' => $request->final_range,
                'duration' => $request->duration,
                'interest' => $request->interest,
            ]);

            return response()->json(['Category Successfully Created']);
        }
        else{
            return response()->json(['Error occured'], abort(404));
        }
    }

    public function edit(Category $category){
        $categoryFind = Category::find($category->id);

        return response()->json(['Edit category', 'edit' => $categoryFind],200);
    }

    public function update(Request $request, Category $category){
        $valid = $request->validate([
            'name' => 'required|string',
            'start_range' => 'required|numeric',
            'final_range' => 'required|numeric',
            'duration' => 'required|numeric',
            'interest' => 'required|numeric',
        ]);

        if($valid){
            $categorUpdate = Category::find($category->id);
            $categorUpdate->update($valid);

            return response()->json(['Category Successfully Updated']);
        }
        else{
            return response()->json(['Error occured'], abort(404));
        }
    }

    public function destroy(Category $category){

        $del = $category->delete();

        if($del){
            return response()->json(['Category Deletion Successfully']);
        }
        else{
            return response()->json(['Category Deletion Failed']);
        }
    }
}
