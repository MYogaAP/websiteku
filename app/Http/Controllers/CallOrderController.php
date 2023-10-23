<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class CallOrderController extends Controller
{
    function NewOrderCall(Request $request) {
        $form_data = $request->session()->get('form_data', 'default');
        $packet_data = $request->session()->get('packet_data', 'default');
        $nama = $form_data['nama_instansi'];
        $mulai = $form_data['mulai_iklan'];
        $akhir = $form_data['akhir_iklan'];
        $desk = $form_data['deskripsi_iklan'];
        $email = $form_data['email_instansi'];
        $packet_id = $packet_data['packet_id'];

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => gethostname().'/websiteku/public/api/StoreOrder',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'image'=> new \CURLFILE($request->image),
            'nama_instansi' => $nama,
            'email_instansi' => $email,
            'deskripsi_iklan' => $desk,
            'mulai_iklan' => $mulai,
            'akhir_iklan' => $akhir,
            'packet_id' => $packet_id,
        ),
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.Cookie::get('auth'),
          ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return redirect()->route('riwayat');
    }
}
