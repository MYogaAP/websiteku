<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class CallOrderController extends Controller
{
  function DeleteOrderCall(Request $request, $order) {
    $desk_up = "Dibatalkan oleh Pengguna.";
    // Xendit
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.xendit.co/invoices/'.$request->xendit_id.'/expire!',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.config('xendit.key')
      ),
    ));
    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
    curl_close($curl);

    // DB
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => gethostname().'/websiteku/public/api/CancelOrder/'.$order,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
        "detail_kemajuan": "'.$desk_up.'"
      }',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: Bearer '.Cookie::get('auth')
      ),
    ));
    $cancel = curl_exec($curl);
    $cancel = json_decode($cancel);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }

    $request->session()->put('cancel', $cancel);

    return redirect()->route('UserOrderHalamanNomor', ['page' => $request->session()->get('order_page', 'default')]); 
  }

  function NewOrderCall(Request $request) {
    $form_data = $request->session()->get('form_data', 'default');
    $packet_data = $request->session()->get('packet_data', 'default');
    $nama = $form_data['nama_instansi'];
    $mulai = $form_data['mulai_iklan'];
    $akhir = $form_data['akhir_iklan'];
    $desk = $form_data['deskripsi_iklan'];
    $email = $form_data['email_instansi'];
    $telp = $form_data['telpon_instansi'];
    $almt = $form_data['alamat_instansi'];
    $packet_id = $packet_data['packet_id'];
    
    // Count Days
    $start = Carbon::parse($mulai); 
    $end = Carbon::parse($akhir);
    $days = 1 + ($start->diffInDaysFiltered(function(Carbon $date) {
      return !$date->isSunday();
    }, $end));

    // Store The Order
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
      'alamat_instansi' => $almt,
    ),
    CURLOPT_HTTPHEADER => array(
      'Accept: application/json',
      'Authorization: Bearer '.Cookie::get('auth'),
    ),
    ));
    $response = curl_exec($curl);
    $response = json_decode($response);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }

    return redirect()->route('SendToRiwayatUser');
  }

  function AcceptUserOrder(Request $request) {
    $request->validate([
      'nomor_invoice' => 'required',
      'nomor_order' => 'required',
      'nomor_seri' => 'required',
    ]);
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "";

    // Order Data
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => gethostname().'/websiteku/public/api/OrderDetail/'.$request->order_id,
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
    $data_order = curl_exec($curl);
    $data_order = json_decode($data_order);
    $data_order = $data_order->data[0];
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }

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
      "external_id" => $request->nomor_invoice,
      "amount" => $data_order->lama_hari*$data_order->harga_paket,
      "description" => "Pemesanan pemasangan iklan pada koran Radar Banjarmasin",
      "invoice_duration" => 1209600,
      "customer" => [
          "given_names" => $data_order->nama_instansi,
          "email" => $data_order->email_instansi,
          "mobile_number" => $data_order->nomor_instansi,
      ],
      'customer_notification_preference' => [
        'invoice_created' => [
            'whatsapp',
            'email'
        ],
        'invoice_reminder' => [
            'whatsapp',
            'email'
        ],
        'invoice_paid' => [
            'whatsapp',
            'email'
        ],
        'invoice_expired' => [
            'whatsapp',
            'email'
        ]
      ],
      "failure_redirect_url" => route("riwayat"),
      "currency" => "IDR",
      "locale" => "id",
      "items" => [
          [
              "name" => "Iklan Paket ".$data_order->nama_paket,
              "quantity" => $data_order->lama_hari,
              "price" => $data_order->harga_paket,
              "category" => "Promotion",
          ]
      ]
    )),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Authorization: Basic '.config('xendit.key')
    )));
    $createInvoice = curl_exec($curl);
    $createInvoice = json_decode($createInvoice);
    curl_close($curl);

    // Update Database
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => gethostname().'/websiteku/public/api/ConfirmOrder/'.$request->order_id.'/1',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "invoice_id": "'.$createInvoice->id.'",
        "nomor_order": "'.$request->nomor_order.'",
        "nomor_invoice": "'.$request->nomor_invoice.'",
        "nomor_seri": "'.$request->nomor_seri.'",
        "detail_kemajuan": "'.$desk_up.'"
    }',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer '.Cookie::get('auth'),
      ),
    ));
    $accept = curl_exec($curl);
    $accept = json_decode($accept);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }
    $request->session()->put('accept', $accept);
    return redirect()->route('orderData'); 
  }

  function DeclineUserOrder(Request $request) {
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "";
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => gethostname().'/websiteku/public/api/ConfirmOrder/'.$request->order_id.'/2',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
      "detail_kemajuan": "'.$desk_up.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Content-Type: application/json',
        'Authorization: Bearer '.Cookie::get('auth'),
    ),
    ));
    $declined = curl_exec($curl);
    $declined = json_decode($declined);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }

    $request->session()->put('declined', $declined);
    return redirect()->route('orderData'); 
  }

  function PublishedUserOrder(Request $request) {
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "";
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => gethostname().'/websiteku/public/api/UpdateOrder/3/1/Telah Tayang',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PATCH',
    CURLOPT_POSTFIELDS => '{
      "detail_kemajuan": "'.$desk_up.'"
    }',
    CURLOPT_HTTPHEADER => array(
      'Accept: application/json',
      'Authorization: Bearer '.Cookie::get('auth'),
    ),
    ));
    $accept = curl_exec($curl);
    $accept = json_decode($accept);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }

    $request->session()->put('accept', $accept);
    return redirect()->route('orderData'); 
  }

  function CancelUserOrder(Request $request) {
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "Dibatalkan oleh tim biro iklan.";
    // Xendit
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.xendit.co/invoices/'.$request->xendit_id.'/expire!',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.config('xendit.key')
      ),
    ));
    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
    curl_close($curl);

    // DB
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => gethostname().'/websiteku/public/api/CancelOrder/'.$request->order_id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
        "detail_kemajuan": "'.$desk_up.'"
      }',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: Bearer '.Cookie::get('auth')
      ),
    ));
    $cancel = curl_exec($curl);
    $cancel = json_decode($cancel);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if($http_status == 401){
      setcookie("auth", "", time() - 3600, "/");
      header("Location: " . route('loginPage'), true, 302);
      exit();
    }

    $request->session()->put('accept', $cancel);

    return redirect()->route('orderData'); 
  }
}