<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    function Login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $user = User::where('username', $request->username)->first();
 
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'user' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->username)->plainTextToken;
    }

    function Logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }

    function Check() {
        return response()->json(Auth::user());
    }
}
