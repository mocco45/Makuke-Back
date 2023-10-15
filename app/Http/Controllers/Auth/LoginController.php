<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function username(){
            return 'username';
        }


    public function login(Request $request){
        
        $request->validate([
            'username' => ['required', 'string', 'exists:users,username'],
            'password' => ['required', 'string'],
        ]);

        $credentials = request(['username', 'password']);

        if(!auth()->attempt($credentials)){
            return response()->json([
                'message' => 'The given data.',
                'errors' =>[
                    'password' => [
                        'Invalid credentials'
                    ]
                ]
                    ], status:500);
        }
        else{
        $user = User::where('username', $request->username)->first();
        $token = $user->createToken('auth-token')->plainTextToken;
        $user->update([
                'status' => true
            ]);
        }
        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ]);


    }

    public function destroy(Request $request)
    {
        
        if(auth()->user()){
            $user = User::where('id', auth()->user()->id);
            $user->update([
                'status' => false
            ]);

        }
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });
        

        return response()->json(['message' => 'Successfully logged out']);
    }
}
