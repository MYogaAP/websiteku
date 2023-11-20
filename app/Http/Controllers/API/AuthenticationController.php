<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    function Login(Request $request) {
        $request->validate([
            'username' => 'required',
        ]);

        $login = $request->username;
        $user = User::where('email', $login)->orWhere('username', $login)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'user' => ['The provided credentials are incorrect.'],
            ]);
        }

        $request->validate([
            'password' => [
                'required',
                'min:8'
            ]
        ]);
        
 
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'user' => ['The provided credentials are incorrect.'],
            ]);
        }
        
        $token = $user->createToken($request->username)->plainTextToken;

        return response()->json([
            'auth' => $token,
        ]);
    }

    function Logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }
}
