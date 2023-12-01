<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\DataTableExport;
use Maatwebsite\Excel\Facades\Excel;
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
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/CancelOrder/'.$order,
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
        'Authorization: Bearer '.Cookie::get('auth')
      ),
    ));
    $cancel = curl_exec($curl);
    $cancel = json_decode($cancel);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }

    $request->session()->put('cancel', $cancel);
    return redirect()->route('UserOrderHalamanNomor', ['page' => $request->session()->get('order_page', 'default')]); 
  }

  function CancelingOrderCall(Request $request, $order) {
    $desk_up = "Dibatalkan oleh Pengguna.";

    // Get Data
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/OrderDetail/'. $order,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => ['Accept: application/json', 'Authorization: Bearer ' . Cookie::get('auth')],
    ]);
    $data = curl_exec($curl);
    $data = json_decode($data);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    $data = $data->data[0];

    if($data->status_iklan != "Menunggu Konfirmasi"){
      $request->session()->put('cancel', "Sebuah kesalahan terjadi");
      return redirect()->route('UserOrderHalamanNomor', ['page' => $request->session()->get('order_page', 'default')]); 
    }

    if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }

    // DB
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/CancelOrder/'.$order,
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
        'Authorization: Bearer '.Cookie::get('auth')
      ),
    ));
    $cancel = curl_exec($curl);
    $cancel = json_decode($cancel);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
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
      return !$date->isSunday(); // Without Sunday
    }, $end));

    // Store The Order
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/StoreOrder',
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

    if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }

    session()->forget('form_data', 'default');
    session()->forget('packet_data', 'default');
    return redirect()->route('SendToRiwayatUser');
  }

  function AcceptUserOrder(Request $request) {
    $request->validate([
      'nomor_invoice' => 'required',
      'nomor_order' => 'required',
      'nomor_seri' => 'required',
    ]);
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "Telah diterima oleh anggota tim Biro Iklan Radar Banjarmasin";
    $expire_time = 1209600; //2 Weeks in minutes

    // Get Order Data
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/OrderDetail/'.$request->order_id,
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

    if ($http_status == 401 || $http_status == 500) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
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
      "invoice_duration" => $expire_time,
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
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/ConfirmOrder/'.$request->order_id.'/1',
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

    if ($http_status == 401 || $http_status == 500) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }
    
    if($http_status == 200){
      $request->session()->put('success', $accept->message);
    } elseif ($http_status == 404) {
      $request->session()->put('danger', $accept->message);
    } else {
      $request->session()->put('danger', "Sebuah kesalahan terjadi.");
    }
    return redirect()->route('orderData' , ['filter' => 'Sudah Konfirmasi']); 
  }

  function DeclineUserOrder(Request $request) {
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "Dibatalkan oleh agent.";
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/ConfirmOrder/'.$request->order_id.'/2',
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

    if ($http_status == 401 || $http_status == 500 ) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }

    if($http_status == 200){
      $request->session()->put('success', $declined->message);
    } elseif ($http_status == 404) {
      $request->session()->put('danger', $declined->message);
    } else {
      $request->session()->put('danger', "Sebuah kesalahan terjadi.");
    }
    return redirect()->route('orderData'); 
  }

  function PublishedUserOrder(Request $request) {
    $desk_up = isset($request->detail_kemajuan) ? $request->detail_kemajuan : "Iklan telah ditayangkan pada koran.";
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/UpdateOrder/'.$request->order_id.'/1',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "detail_kemajuan": "'.$desk_up.'",
        "status": "Telah Tayang"
      }',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: Bearer '.Cookie::get('auth'),
        'Content-Type: application/json'
      ),
    ));
    $accept = curl_exec($curl);
    $accept = json_decode($accept);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }

    if($http_status == 200){
      $request->session()->put('success', $accept->message);
    } else {
      $request->session()->put('danger', "Sebuah kesalahan terjadi.");
    }
    return redirect()->route('orderData', ['filter' => 'Sudah Konfirmasi']); 
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

    if ($http_status == 404) {
      $request->session()->put('danger', "Sebuah kesalahan terjadi.");
      return redirect()->route('orderData' , ['filter' => 'Sudah Konfirmasi']); 
    }

    // DB
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/CancelOrder/'.$request->order_id,
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
        'Authorization: Bearer '.Cookie::get('auth'),
        'Content-Type: application/json'
      ),
    ));
    $cancel = curl_exec($curl);
    $cancel = json_decode($cancel);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_status == 401 || $http_status == 500) {
      setcookie('auth', '', time() - 3600, '/');
      session()->flush();
      header('Location: ' . route('loginPage'), true, 302);
      exit();
    }

    if($http_status == 200){
      $request->session()->put('success', $cancel->message);
    } elseif ($http_status == 404) {
      $request->session()->put('danger', $cancel->message);
    } else {
      $request->session()->put('danger', "Sebuah kesalahan terjadi.");
    }

    return redirect()->route('orderData' , ['filter' => 'Sudah Konfirmasi']); 
  }

  function ExportOrderData(Request $request){
    $fileName = 'OrderData_' . $request->year . '_' . $request->month . '.xlsx';
    
    return Excel::download(new DataTableExport($request->year, $request->month), $fileName);
  }
}