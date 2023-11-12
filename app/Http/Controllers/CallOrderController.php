<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;

class CallOrderController extends Controller
{
  function DeleteOrderCall(Request $request, $order) {
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
      CURLOPT_CUSTOMREQUEST => 'DELETE',
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
    
  }

  function DeclineUserOrder(Request $request) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => gethostname().'/websiteku/public/api/ConfirmOrder/'.$request->order_id.'/2',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'PATCH',
      CURLOPT_POSTFIELDS =>'{
        "detail_kemajuan": '.$request->detail_kemajuan.'
      }',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
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
}

// Make Invoice Xendit
// $curl = curl_init();
// curl_setopt_array($curl, array(
// CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
// CURLOPT_RETURNTRANSFER => true,
// CURLOPT_ENCODING => '',
// CURLOPT_MAXREDIRS => 10,
// CURLOPT_TIMEOUT => 0,
// CURLOPT_FOLLOWLOCATION => true,
// CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// CURLOPT_CUSTOMREQUEST => 'POST',
// CURLOPT_POSTFIELDS => json_encode(array(
//   "external_id" => $data_user->username."-".$data_user->role."-".$data_user->email,
//   "amount" => $days*$data_packet->harga_paket,
//   "description" => "Pemesanan pemasangan iklan pada koran Radar Banjarmasin",
//   "invoice_duration" => 86400,
//   "customer" => [
//       "given_names" => $nama,
//       "email" => $email,
//       "mobile_number" => $telp,
//   ],
//   "failure_redirect_url" => route("riwayat"),
//   "currency" => "IDR",
//   "locale" => "id",
//   "items" => [
//       [
//           "name" => "Iklan Paket ".$data_packet->nama_paket,
//           "quantity" => $days,
//           "price" => $data_packet->harga_paket,
//           "category" => "Promotion",
//       ]
//   ]
// )),
// CURLOPT_HTTPHEADER => array(
//   'Content-Type: application/json',
//   'Authorization: Basic '.config('xendit.key')
// ),
// ));
// $createInvoice = curl_exec($curl);
// $createInvoice = json_decode($createInvoice);
// curl_close($curl);
