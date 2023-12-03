<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cookie;

class CallUserController extends Controller
{
    function LoginCall(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => request()->getSchemeAndHttpHost().'/websiteku/public/api/UserLogin',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "username" : "'.$request->username.'",
            "password" : "'.$request->password.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        if(isset($response->errors)) {
            return view('login', ['errors_msg' => $response->errors]);
        } elseif (isset($response->message)){
            return view('login', ['message' => $response->message]);
        }

        Cookie::queue('auth', $response->auth, 720, null, null, false, true);

        return redirect()->route('loginPage');
    }

    function RegisterCall(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => request()->getSchemeAndHttpHost().'/websiteku/public/api/UserRegister',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "email" : "'.$request->email.'",
            "username" : "'.$request->username.'",
            "password" : "'.$request->password.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 422){
            return view('register')->with([
                'errors_msg' => $response->errors,
            ]);
        } else if($http_status != 200){
            return view('register')->with([
                'message' => "Terjadi suatu kesalahan!",
            ]);
        }

        // Login After Registering
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => request()->getSchemeAndHttpHost().'/websiteku/public/api/UserLogin',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "username" : "'.$request->username.'",
            "password" : "'.$request->password.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if(isset($response->errors)) {
            return view('login', ['errors_msg' => $response->errors]);
        } elseif (isset($response->message)){
            return view('login', ['message' => $response->message]);
        }

        if($http_status == 200){
            Cookie::queue('auth', $response->auth, 720, null, null, false, true);
            return redirect()->route('loginPage');
        } else {
            return view('login')->with([
                'error_msg' => "Terjadi suatu kesalahan!",
            ]);
        }
    }

    function UpdateProfileCall(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => request()->getSchemeAndHttpHost().'/websiteku/public/api/UpdateUserProfile',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS =>'{
            "name" : "'.$request->nama.'",
            "no_hp" : "'.$request->no_hp.'",
            "pekerjaan" : "'.$request->pekerjaan.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            return View('profilePro');
        } else if ($http_status == 200){
            return View('profilePro')->with(['MessageSuccess' => $response->message]);
        } else if ($http_status == 422){
            return View('profilePro')->with(['MessageWarning' => [$response->message]]);
        }

        return View('profilePro')->with(['MessageWarning' => ['Terjadi sebuah kesalahan']]);
    }

    function UpdatePasswordCall(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => request()->getSchemeAndHttpHost().'/websiteku/public/api/UpdateUserPassword',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS =>'{
            "old_password" : "'.$request->old_password.'",
            "password" : "'.$request->password.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $response = json_decode($response);

        if($http_status == 401){
            return View('profilePro');
        }

        if($http_status == 404){
            return View('profilePro')->with([
                "MessageWarning" => [$response->message]
            ]);
        }
        
        if($http_status == 422){
            return View('profilePro')->with([
                "MessageWarning" => $response->errors->password
            ]);
        }

        if($http_status == 200){
            return View('profilePro')->with([
                "MessageSuccess" => $response->message
            ]);
        }
    }

    function LogoutCall(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => request()->getSchemeAndHttpHost().'/websiteku/public/api/UserLogout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth')
        ),
        ));
        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        setcookie("auth", "", time() - 3600, "/");

        if($http_status == 200){
            return View('login')->with([
                "message" => "Berhasil keluar dari akun."
            ]);
        } else {
            return View('login')->with([
                "error_msg" => "Terjadi suatu kesalahan."
            ]);
        }
    }
}
