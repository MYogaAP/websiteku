<?php

namespace App\Http\Controllers;

use App\Models\PacketData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    function AddNewPacket(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/AddPacket',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'image'=> new \CURLFILE($request->contoh_foto_paket),
            'nama_paket' => $request->nama_paket,
            'tinggi' => $request->tinggi_paket,
            'kolom' => $request->kolom_paket,
            'format_warna' => $request->format_warna_paket,
            'harga_paket' => $request->harga_paket,
        ),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer ' .Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            $request->session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }

        $request->session()->forget('update_add');
        $request->session()->forget('update_delete');
        $request->session()->forget('update_unhide');
        $request->session()->forget('update_hide');
        $request->session()->put('update_add', $response->message);

        return redirect()->route('LihatPaket');
    }

    function ShowPacket(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/AgentPacketList',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer ' .Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            $request->session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }

        $request->session()->forget('update_add');
        $request->session()->forget('update_delete');
        $request->session()->forget('update_unhide');
        $request->session()->forget('update_hide');
        $request->session()->put('packet_data', $response->data);
        
        return redirect()->route('paketData');
    }

    function HideThePacket(Request $request, $packet) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/HidePacket/'.$packet,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth')
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            $request->session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }
        
        $request->session()->forget('update_add');
        $request->session()->forget('update_delete');
        $request->session()->forget('update_unhide');
        $request->session()->forget('update_hide');
        $request->session()->put('update_hide', $response == 1);

        return redirect()->route('LihatPaket');
    }

    function UnhideThePacket(Request $request, $packet) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/UnHidePacket/'.$packet,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PATCH',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth')
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            $request->session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }
        
        $request->session()->forget('update_add');
        $request->session()->forget('update_delete');
        $request->session()->forget('update_unhide');
        $request->session()->forget('update_hide');
        $request->session()->put('update_unhide', $response == 1);

        return redirect()->route('LihatPaket');
    }

    function DeleteThePacket(Request $request, $packet) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/DeletePacket/'.$packet,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth')
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($http_status == 401){
            setcookie("auth", "", time() - 3600, "/");
            $request->session()->flush();
            header("Location: " . route('loginPage'), true, 302);
            exit();
        }
        
        $request->session()->forget('update_add');
        $request->session()->forget('update_delete');
        $request->session()->forget('update_unhide');
        $request->session()->forget('update_hide');
        $request->session()->put('update_delete', $response->message);

        return redirect()->route('LihatPaket');
    }
}
