<?php

namespace App\Http\Controllers;

use App\Http\Resources\BoardResource;
use App\Models\Board_Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request){
        try {
            
        $validated = $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'gender' => 'required|string|',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|unique:'. Board_Member::class,
            'address' => 'required|string',
            'position' => 'required|string',
            'photo' => 'required|string|mimes:jpeg,png,jpg',
        ]);

        if($validated){
           $board = Board_Member::create([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'position' => $request->position,
                'photo' => $request->photo,
            ]);
        }
        return response()->json(['Member added successfully', 'data' => $board]);


    } catch (\Throwable $th) {

        return response()->json(['Error occured', 'error' => $th->getMessage()],500);
    }

        
    }

    public function update(Board_Member $board_member, Request $request){
        try {
            $boardM = Board_Member::find($board_member->id);
            $boardM->update([
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'position' => $request->position,
                'photo' => $request->photo,
            ]);

            return response()->json(['Member updated Successfully']);
        } catch (\Throwable $th) {
            return response()->json(['Error Occured', 'error' => $th->getMessage()],500);
        }
    }

    public function destroy(Board_Member $board_member){
        if(Auth::user()->id == $board_member->id){
            return response()->json(['Access Denied'], abort(401));
        }
dd($board_member);
        $boardM = $board_member->delete();
        
        
        if($boardM){
            unlink(public_path('Images/Board/' . $board_member->image ));
        }

        return response()->json(['Member Deleted Successfully']);
    }
}
