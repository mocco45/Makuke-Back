<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token')->plainTextToken; 
            
            return response()->json([
                'token' => $token,
                'user' => $user,
                
            ], 200);
        }
        else{
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        
        
        // $request->session()->regenerate();

        // return response(['Login successfully']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy()
    {
        Auth::logout(); 
        return response()->json(['message' => 'Successfully logged out']);
    }
}
