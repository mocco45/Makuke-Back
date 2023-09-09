<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        ]);

        // Store the uploaded file
        $uploadedFile = $request->file('file');
        $fileName = time() . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->storeAs('public/images', $fileName);

        // Optionally, you can save the file path to your database for reference

        return response()->json(['message' => 'Image uploaded successfully']);
    }

    public function test(Request $request){
        $amount = $request->loanAmount;
        $category = Category::where('start_range', '<=', $amount)
                    ->where('final_range', '>=', $amount)->first();

        if($category){

            dd($category->id.' '.$category->name);

        }

        else{
            return "No Such Category";
        }
    }
}
