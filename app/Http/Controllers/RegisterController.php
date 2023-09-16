<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    function RegisterCostumer(Request $request) {
        $request->validate([
            'username' => [
                'required',
                'unique:users,username',
                'max:255',
                'min:5',
                'regex:/\w*$/',
                'regex:/\S/',
                'alpha_dash',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $request->merge(['role' => 'customer']);

        $newData = User::create($request->all());

        return response()->json([
            'message' => 'Account has been succesfully made.',
        ]);
    }
}
