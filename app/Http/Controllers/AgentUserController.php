<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AgentUserController extends Controller
{
    function CheckCurrent() {
        return response()->json(Auth::user());
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

    function DeleteAgent($user_id) {
        $deleteData = User::findOrFail($user_id);

        if($deleteData->role != 'agent'){
            return response()->json([
                'message' => 'Selected account is not an agent.',
            ]);
        }

        $deleteData->delete();

        return response()->json([
            'message' => 'Agent has been deleted.',
        ]);
    }
}
