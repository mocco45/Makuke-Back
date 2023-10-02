<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardResource;
use App\Models\Board_Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class Board_MemberController extends Controller
{
    public function index(){
        $board = Board_Member::all();

        return BoardResource::collection($board);
        
    }

    public function show(Board_Member $board_member){
        $boardM = Board_Member::find($board_member->id);
        
        return new BoardResource($boardM);
    }

    public function uploadMemberImage(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
            ]);

            // Store the uploaded file
            $uploadedFile = $request->file('photo');
            $memberImageName = time() . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/images/memberss', $memberImageName);

            // Pass the $memberImageName to the store function
            


            return $memberImageName;
          

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function store(Request $request){
        try {
            
        $validated = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'gender' => 'required|string|',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|unique:'. Board_Member::class,
            'region' => 'required|string',
            'district' => 'required|string',
            'street' => 'required|string',
            'position' => 'required|string',
            'file' => 'image|mimes:jpeg,png,jpg',
        ]);

        if($request->hasFile('file')){
            $img = $request->file('file');
            $memberPhoto = time() . '.' .$img->getClientOriginalExtension();
            $img->storeAs('public/images/board-members', $memberPhoto);

        }

        if($validated){
           $board = Board_Member::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'region' => $request->region,
                'district' => $request->district,
                'street' => $request->street,
                'position' => $request->position,
                'photo' => $memberPhoto,
            ]);
        }
        return response()->json(['Member added successfully', 'data' => $board]);


    } catch (\Throwable $th) {

        return response()->json(['Error occured', 'error' => $th->getMessage()],500);
    }   
    }

    public function update(Board_Member $board_member, Request $request)
{
        // Check if the board member exists
        if (!$board_member) {
            return response()->json(['error' => 'Board member not found'], 404);
        }

        $validated = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'gender' => 'required|string',
            'phone' => 'required',
            'email' => 'email|unique:board_members,email,' . $board_member->id,
            'address' => 'required|string',
            'position' => 'required|string',
            'file' => 'image|mimes:jpeg,png,jpg',
        ]);

        $memberPhotoUpdate = $board_member->photo; // Default to the current photo

        if($request->hasFile('file')){
            $img = $request->file('file');
            $memberPhotoUpdate = time() . '.' .$img->getClientOriginalExtension();
            $img->storeAs('public/images/board-members', $memberPhotoUpdate);

            // Delete the old photo file if it exists
            $oldPhotoPath = public_path('storage/images/board-members/' . $board_member->photo);
            if (File::exists($oldPhotoPath)) {
                File::delete($oldPhotoPath);
            }
        }

        if($validated){
            $board_member->update([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'region' => $request->region,
                'district' => $request->district,
                'street' => $request->street,
                'position' => $request->position,
                'photo' => $memberPhotoUpdate,
            ]);
        }

        return response()->json(['message' => 'Member updated successfully']);

}



    public function destroy(Board_Member $board_member){
        if(Auth::user()->id == $board_member->id){
            return response()->json(['Access Denied'], abort(401));
        }
        $boardM = $board_member->delete();
        
        
        if($boardM){
            unlink(public_path('Images/Board/' . $board_member->image ));
        }

        return response()->json(['Member Deleted Successfully']);
    }
}
