<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-])[A-Za-z\d@$!%*?&_\-]+$/',
            ],
        ], [
            'username.required' => 'Kolom username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.max' => 'Username tidak boleh lebih dari :max karakter.',
            'username.min' => 'Username harus minimal :min karakter.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dan garis bawah.',
        
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        
            'password.required' => 'Kolom password wajib diisi.',
            'password.min' => 'Password harus minimal :min karakter.',
            'password.regex' => 'Password harus mengandung huruf kapital, huruf kecil, satu angka dan satu simbol.',
        ]);

        $request->merge(['name' => 'user_'.Str::random(10)."_".$request->username]);
        $request->merge(['role' => 'customer']); // Making the user as customer

        $newData = User::create($request->all());
        event(new Registered($newData));

        return response()->json([
            'message' => 'Akun berhasil dibuat.'
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
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_\-])[A-Za-z\d@$!%*?&_\-]+$/',
            ],
        ], [
            'username.required' => 'Kolom username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.max' => 'Username tidak boleh lebih dari :max karakter.',
            'username.min' => 'Username harus minimal :min karakter.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dan garis bawah.',
        
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
        
            'password.required' => 'Kolom password wajib diisi.',
            'password.min' => 'Password harus minimal :min karakter.',
            'password.regex' => 'Password harus mengandung huruf kapital, huruf kecil, satu angka dan satu simbol.',
        ]);

        $request->merge(['role' => 'agent']); // Making the user as agent
        $request->merge(['email_verified_at' => now()]); // Making the agent email verified

        $newData = User::create($request->all());

        return response()->json([
            'message' => 'Akun berhasil dibuat.',
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
            ],[
                'username.required' => 'Kolom username wajib diisi.',
                'username.unique' => 'Username sudah digunakan.',
                'username.max' => 'Username tidak boleh lebih dari :max karakter.',
                'username.min' => 'Username harus minimal :min karakter.',
                'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dan garis bawah.',
            ]
        ]);

        return response()->json([
            'message' => 'The username is available.',
        ]);
    }
}
