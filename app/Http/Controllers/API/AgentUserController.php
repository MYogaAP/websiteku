<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AgentListResource;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;

class AgentUserController extends Controller
{
    function CheckCurrent() {
        $user = Auth::user();
        if($user->hasVerifiedEmail()){
            return response()->json(Auth::user(), 200);
        }
        $data = Auth::user();
        $data->message = "Tolong verifikasi email anda!";
        return response()->json($data, 403);
    }

    function AgentList() {
        $agents = User::where('role', 'agent')->get();
        return AgentListResource::collection($agents);
    }
    
    function UpdatePassword(Request $request) {
        $newPassword = $request->validate([
            'old_password' => [
                'required'
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
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

        $currentAccount = Auth::user()->user_id;
        $currentPassword = Auth::user()->password;
        $oldPassword = $newPassword['old_password'];
        $newPassword = $newPassword['password'];

        if (!Hash::check($oldPassword, $currentPassword)) { 
            return response()->json([
                'message' => 'Pasword lama yang anda masukkan salah.',
            ], 404);
        } elseif (Hash::check($newPassword, $currentPassword)){
            return response()->json([
                'message' => 'The password baru yang anda masukkan sama dengan password lama anda.',
            ], 404);
        } else {
            $updateData = User::findOrFail($currentAccount);
            $updateData->password = $newPassword;
            $updateData->save();
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Password telah diperbaharui.',
            ]);
        }

        return response()->json([
            'message' => 'Sebuah kesalahan terjadi.',
            404
        ]);
    }

    function UpdateProfile(Request $request) {
        $newProfile = $request->validate([
            'name' => [
                'max:255'
            ],
            'no_hp' => [
                'numeric'
            ],
            'pekerjaan' => [
                'max:255'
            ]
        ], [
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'pekerjaan.max' => 'Pekerjaan tidak boleh lebih dari :max karakter.',
        ]);

        $currentAccount = Auth::user()->user_id;

        $updateData = User::findOrFail($currentAccount);
        $updateData->name = $newProfile["name"];
        $updateData->no_hp = $newProfile["no_hp"];
        $updateData->pekerjaan = $newProfile["pekerjaan"];
        $updateData->save();

        return response()->json([
            'message' => 'Profile telah diperbaharui.',
        ]);
    }

    function AdminUpdateAgentProfile(Request $request, $user_id) {
        $newProfile = $request->validate([
            'name' => [
                'max:255'
            ],
            'no_hp' => [
                'numeric'
            ],
            'pekerjaan' => [
                'max:255'
            ]
        ], [
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'pekerjaan.max' => 'Pekerjaan tidak boleh lebih dari :max karakter.',
        ]);

        $updateData = User::findOrFail($user_id);

        if($updateData->role != 'agent'){
            return response()->json([
                'message' => 'Akun yang dipilih bukan seorang anggota biro iklan.',
            ]);
        }

        $updateData->name = $newProfile["name"];
        $updateData->no_hp = $newProfile["no_hp"];
        $updateData->pekerjaan = $newProfile["pekerjaan"];
        $updateData->save();

        return response()->json([
            'message' => 'Profile telah diperbaharui.',
        ]);
    }

    function DeleteAgent($user_id) {
        $deleteData = User::findOrFail($user_id);

        if($deleteData->role != 'agent'){
            return response()->json([
                'message' => 'Akun yang dipilih bukan seorang anggota biro iklan.',
            ]);
        }

        $deleteData->name = $deleteData->name.Str::random(30);
        $deleteData->username = $deleteData->username.Str::random(30);
        $deleteData->email = $deleteData->email.Str::random(30);
        $deleteData->role = "costumer";
        $deleteData->no_hp = "";
        $deleteData->pekerjaan = "";
        $deleteData->save();
        $deleteData->delete();

        return response()->json([
            'message' => 'Anggota biro telah dihapus.',
        ]);
    }
}
