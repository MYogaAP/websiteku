<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index() {
        $data = UserData::all();
        return response()->json($data);
    }
}
