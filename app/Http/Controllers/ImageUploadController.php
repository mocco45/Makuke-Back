<?php

namespace App\Http\Controllers;

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
}
