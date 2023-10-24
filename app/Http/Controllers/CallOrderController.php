<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Xendit\Xendit;
require 'vendor/autoload.php';

class CallOrderController extends Controller
{
  function NewOrderAndInvoiceCall(Request $request) {
    $form_data = $request->session()->get('form_data', 'default');
    $packet_data = $request->session()->get('packet_data', 'default');
    $nama = $form_data['nama_instansi'];
    $email = $form_data['email_instansi'];
    $packet_id = $packet_data['packet_id'];

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => gethostname().'/websiteku/public/api/GetPacket/'.$packet_id,
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
    $data_packet = curl_exec($curl);
    $data_packet = json_decode($data_packet);
    curl_close($curl);

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => gethostname().'/websiteku/public/api/UserCheck',
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
    $data_user = curl_exec($curl);
    $data_user = json_decode($data_user);
    $data_user = $data_user->data[0];
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if($http_status == 401){
        setcookie("auth", "", time() - 3600, "/");
        header("Location: " . URL::to('/login'), true, 302);
        exit();
    }

    Xendit::setApiKey('xnd_production_o9M7SFp6I5gSotiQujsc1ZJFVAkZvyykI2yvaCHvoWr6FVY5SXlgFNPmUMOXZ6m');
    $params = [ 
      'external_id' => $data_user->username."".$data_user->role."".$data_user->email,
      'amount' => $data_user->harga_paket,
      'description' => 'Pemesanan pemasangan iklan pada koran Radar Banjarmasin',
      'invoice_duration' => 86400,
      'customer' => [
          'given_names' => $nama,
          'email' => $email,
          'mobile_number' => $data_user->no_hp,
      ],
      'success_redirect_url' => route('NewInvoiceCall'),
      'failure_redirect_url' => route('NewInvoiceCall'),
      'currency' => 'IDR',
      'items' => [
          [
              'name' => $data_packet->nama_paket,
              'quantity' => 1,
              'price' => $data_user->harga_paket,
              'category' => 'Promotion',
          ]
      ]
    ];
    $createInvoice = \Xendit\Invoice::create($params);
    var_dump($createInvoice);

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
