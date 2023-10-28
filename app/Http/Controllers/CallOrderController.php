<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class CallOrderController extends Controller
{
  function NewOrderAndInvoiceCall(Request $request) {
    $form_data = $request->session()->get('form_data', 'default');
    $packet_data = $request->session()->get('packet_data', 'default');
    $nama = $form_data['nama_instansi'];
    $mulai = $form_data['mulai_iklan'];
    $akhir = $form_data['akhir_iklan'];
    $desk = $form_data['deskripsi_iklan'];
    $email = $form_data['email_instansi'];
    $telp = $form_data['telpon_instansi'];
    $packet_id = $packet_data['packet_id'];
    
    // Count Days
    $start = Carbon::parse($mulai); 
    $end = Carbon::parse($akhir);
    $days = 1 + ($start->diffInDaysFiltered(function(Carbon $date) {
      return !$date->isSunday();
    }, $end));

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
        "external_id" => $data_user->username."-".$data_user->role."-".$data_user->email,
        "amount" => $days*$data_packet->harga_paket,
        "description" => "Pemesanan pemasangan iklan pada koran Radar Banjarmasin",
        "invoice_duration" => 86400,
        "customer" => [
            "given_names" => $nama,
            "email" => $email,
            "mobile_number" => $telp,
        ],
        "failure_redirect_url" => route("riwayat"),
        "currency" => "IDR",
        "locale" => "id",
        "items" => [
            [
                "name" => "Iklan Paket ".$data_packet->nama_paket,
                "quantity" => $days,
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
    $createInvoice = json_decode($createInvoice);
    curl_close($curl);

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
        'nomor_instansi' => $telp,
        'deskripsi_iklan' => $desk,
        'mulai_iklan' => $mulai,
        'akhir_iklan' => $akhir,
        'packet_id' => $packet_id,
        'lama_hari' => $days,
        'invoice_id' => $createInvoice->id,
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
