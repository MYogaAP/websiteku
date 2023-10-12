<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class FormController extends Controller
{
    function LoginCall(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/UserLogin',
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
        curl_close($curl);
        $response = json_decode($response);

        if(!empty($response->message)) {
            return view('login', ['message' => $response->message]);
        }

        Cookie::queue('auth', $response->auth, 1440, null, null, false, true);

        return view('landingPageLogin');
    }

    function RegisterCall(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/UserRegister',
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
        curl_close($curl);
        $response = json_decode($response);
        
        if(!empty($response->message)) {
            return view('register', ['message' => $response->message]);
        }

        return view('login');
    }

    function UpdateProfileCall(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/UpdateUserProfile',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS =>'{
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
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = json_decode($response);
        curl_close($curl);

        if($http_status == 401){
            return View('profile');
        }

        return View('profile')->with(['MessageSuccess' => $response->message]);
    }

    function UpdatePasswordCall(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/UpdateUserPassword',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_POSTFIELDS =>'{
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
            return View('profile');
        }

        return View('profile')->with([
            "MessageWarning" => $response->errors->password
        ]);
    }

    function LogoutCall(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/UserLogout',
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
        curl_close($curl);

        setcookie("auth", "", time() - 3600, "/");

        return View('profile');
    }
}
