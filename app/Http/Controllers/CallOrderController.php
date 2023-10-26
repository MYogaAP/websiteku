<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Cookie;

class CallOrderController extends Controller
{
  function NewOrderAndInvoiceCall(Request $request) {
    $form_data = $request->session()->get('form_data', 'default');
    $packet_data = $request->session()->get('packet_data', 'default');
    $nama = $form_data['nama_instansi'];
    $email = $form_data['email_instansi'];
    $packet_id = $packet_data['packet_id'];

    // Get User Data
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
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    if($http_status == 401){
        setcookie("auth", "", time() - 3600, "/");
        header("Location: " . URL::to('/login'), true, 302);
        exit();
    }

    // Get Packet Data
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
    $data_packet = $data_packet->data[0];
    curl_close($curl);

    // Make Invoice Xendit
    $curl = curl_init();
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'POST',
    //   CURLOPT_POSTFIELDS =>'{
    //     "amount": 1000,
    //     "invoice_duration": 60,
    //     "payer_email": "customer@domain.com",
    //     "description": "Invoice Demo #123",
    //     "payment_methods": []
    //   }',
    //   CURLOPT_HTTPHEADER => array(
    //     'Content-Type: application/json',
    //     'Authorization: Basic eG5kX3Byb2R1Y3Rpb25fbzlNN1NGcDZJNWdTb3RpUXVqc2MxWkpGVkFrWnZ5eWtJMnl2YUNIdm9XcjZGVlk1U1hsZ0ZOUG1VTU9YWjZtOg=='
    //   ),
    // ));
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode(array(
        "external_id" => $data_user->username."_".$data_user->role."_".$data_user->email,
        "amount" => $data_packet->harga_paket,
        "description" => "Pemesanan pemasangan iklan pada koran Radar Banjarmasin",
        "invoice_duration" => 86400,
        "customer" => [
            "given_names" => $nama,
            "email" => $email,
            "mobile_number" => $data_user->no_hp,
        ],
        "success_redirect_url" => route("riwayat"),
        "failure_redirect_url" => route("riwayat"),
        "currency" => "IDR",
        "items" => [
            [
                "name" => $data_packet->nama_paket,
                "quantity" => 1,
                "price" => $data_packet->harga_paket,
                "category" => "Promotion",
            ]
        ]
      )),
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Basic '.config('xendit.key')
      ),
    ));
    $createInvoice = curl_exec($curl);
    curl_close($curl);
    dd($createInvoice);

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
        'order_invoice' => $createInvoice,
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
