<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
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
                    'password' => ['Invalid credentials']
                        ]
                    ], status:500);
        }
        else{
        $user = User::whereRaw('BINARY username = ?', $credentials['username'])->first();
        
        $token = $user->createToken('auth-token',expiresAt:now()->addMinute(720)->timezone('Africa/Dar_es_Salaam'));

        // Get the plain text token
        $plainTextToken = $token->plainTextToken;

        // Extract the expiry time
        $expires = $token->accessToken->expires_at;
        
        $user->update([
                'status' => true
            ]);
        }
        return response()->json([
            'access_token' => $plainTextToken,
            'expires_at' => $expires->toDateTimeString(),
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
