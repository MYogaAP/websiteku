<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CallAgentController extends Controller
{
    function AddTheAgent(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname() . '/websiteku/public/api/AgentRegister',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "name" : "'.$request->nama_anggota.'",
            "username" : "'.$request->username_anggota.'",
            "email" : "'.$request->email_anggota.'",
            "password" : "'.$request->password_anggota.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '. Cookie::get('auth'),
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }

        $request->session()->put('add_agent', $response->message);

        return redirect()->route('agentData');
    }
    
    function UpdateTheAgent(Request $request, $agent) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname() . '/websiteku/public/api/DeleteAgent/'. $agent,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '. Cookie::get('auth')
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }

        $request->session()->put('update_data', $response->message);

        return redirect()->route('agentData');
    }

    function DeleteTheAgent(Request $request, $agent) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname() . '/websiteku/public/api/DeleteAgent/'. $agent,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '. Cookie::get('auth')
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }

        $request->session()->put('delete_agent', $response->message);

        return redirect()->route('agentData');
    }
}
