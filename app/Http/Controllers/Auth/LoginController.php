<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = request(['email', 'password']);

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

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth-token')->plainTextToken;
        

        return response()->json(['access_token' => $token]);


    }

    public function destroy(Request $request)
    {
        
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        return response()->json(['message' => 'Successfully logged out']);
    }
}
