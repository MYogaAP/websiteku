<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    function RegisterCostumer(Request $request) {
        $request->validate([
            'username' => [
                'required',
                'unique:users,username',
                'max:255',
                'min:5',
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
                    ->symbols()
                    ->uncompromised(3),
            ],
        ]);

        $request->merge(['name' => 'user_'.Str::random(10)."_".$request->username]);
        $request->merge(['role' => 'costumer']); // Making the user as costumer

        $newData = User::create($request->all());
        event(new Registered($newData));

        return response()->json([
            'message' => 'Account has been succesfully made.'
        ]);
    }

    function VerifEmailUser(EmailVerificationRequest $request) {
        $request->fulfill();

        return response()->json([
            'message' => 'Email akun berhasil diverifikasi'
        ], 200);
    }

    function SendAnVerifEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Email verifikasi telah dikirimkan ulang!'
        ], 200);
    }

    function RegisterAgent(Request $request) {
        $request->validate([
            'name' => [
                'required',
                'max:255'
            ],
            'username' => [
                'required',
                'unique:users,username',
                'max:255',
                'min:5',
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

        $request->merge(['role' => 'agent']); // Making the user as agent
        $request->merge(['email_verified_at' => now()]); // Making the agent email verified

        $newData = User::create($request->all());

        return response()->json([
            'message' => 'Agent has been succesfully made.',
        ]);
    }

    function EmailCheck(Request $request) {
        $request->validate([
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
        ]);

        return response()->json([
            'message' => 'The email is available.',
        ]);
    }

    function UsernameCheck(Request $request) {
        $request->validate([
            'username' => [
                'required',
                'unique:users,username',
                'max:255',
                'min:5',
                'alpha_dash',
            ],
        ]);

        return response()->json([
            'message' => 'The username is available.',
        ]);
    }
}
