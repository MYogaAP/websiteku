<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class DataLinkerController extends Controller
{
    function SendToDetailUkuran(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/PacketList',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $desc = isset($request->deskripsi_iklan)? $request->deskripsi_iklan : "";
        
        $data = [
            "nama_instansi" => $request->nama_instansi,
            "mulai_iklan" => $request->mulai_iklan,
            "akhir_iklan" => $request->akhir_iklan,
            "deskripsi_iklan" => $desc,
            "email_instansi" => $request->email_instansi,
        ];

        $request->session()->put('form_data', $data);
        $request->session()->put('response', $response);
        $request->session()->put('ukuran_hal', 1);

        return redirect()->route('detailukuran');
    }

    function SendToUploadAndView(Request $request) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/GetPacketColor/'. $request->data_paket,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $data = [
            "packet_id" => $request->data_paket,
            "format_warna" => $response->data[0]->format_warna,
            "contoh_foto" => $response->data[0]->contoh_foto,
        ];

        $request->session()->put('packet_data', $data);

        return redirect()->route('uploadandview');
    }

    function LoadNextPacketData(Request $request) {
        $page = session('ukuran_hal') + 1;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/PacketList?page='.$page,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $request->session()->put('response', $response);
        $request->session()->put('ukuran_hal', $page);

        return redirect()->route('detailukuran');
    }

    function LoadPrevPacketData(Request $request) {
        $page = session('ukuran_hal') - 1;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => gethostname().'/websiteku/public/api/PacketList?page='.$page,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
        ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        $request->session()->put('response', $response);
        $request->session()->put('ukuran_hal', $page);

        return redirect()->route('detailukuran');
    }
}
