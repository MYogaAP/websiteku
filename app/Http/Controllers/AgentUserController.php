<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AgentListResource;
use Illuminate\Validation\Rules\Password;

class AgentUserController extends Controller
{
    function CheckCurrent() {
        return response()->json(Auth::user());
    }

    function AgentList() {
        $agents = User::where('role', 'agent')->get();
        return AgentListResource::collection($agents);
    }
    
    function UpdatePassword(Request $request) {
        $newPassword = $request->validate([
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(3),
            ]
        ]);

        $currentAccount = Auth::user()->user_id;
        $currentPassword = Auth::user()->password;
        $newPassword = $newPassword['password'];

        if (Hash::check($newPassword, $currentPassword)){
            return response()->json([
                'message' => 'The password inputed is the same as the current password.',
            ], 404);
        }

        $updateData = User::findOrFail($currentAccount);
        $updateData->password = $newPassword;
        $updateData->save();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Password has been updated.',
        ]);
    }

    function UpdateProfile(Request $request) {
        $newProfile = $request->validate([
            'no_hp' => [
                'numeric'
            ],
            'pekerjaan' => [
                'max:255'
            ]
        ]);

        $currentAccount = Auth::user()->user_id;

        $updateData = User::findOrFail($currentAccount);
        $updateData->no_hp = $newProfile["no_hp"];
        $updateData->pekerjaan = $newProfile["pekerjaan"];
        $updateData->save();

        return response()->json([
            'message' => 'Profile has been updated.',
        ]);
    }

    function DeleteAgent($user_id) {
        $deleteData = User::findOrFail($user_id);

        if($deleteData->role != 'agent'){
            return response()->json([
                'message' => 'Selected account is not an agent.',
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
            'message' => 'Agent has been deleted.',
        ]);
    }
}
