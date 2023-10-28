<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Iklan Radar Banjarmasin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,800&family=Montserrat&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .judul {
            font-family: 'Bodoni MT';
            color: #1450A3;
        }
    </style>
</head>

<body>
    {{-- Navigation Bar --}}
    <x-nav-bar-back />

    @if(!Cookie::has('auth'))
        <script>window.location="{{route('loginPage')}}";</script>
    @endif

    @php
        if(session("order_data")){
            $order_list = session("order_data");
        }else {
            header("Location: " . route('landingPageLogin'), true, 302);
            exit();
        }
    @endphp

    {{-- Content --}}
    <div class="container text-center mt-5 border rounded-4">
        <div class="row align-items-start">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No Order</th>
                            <th scope="col" colspan="2">Detail Iklan</th>
                            <th scope="col">Status Iklan</th>
                            <th scope="col">Foto Iklan</th>
                            <th scope="col">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!isset($order_list->data[0]))
                            <tr>
                                <td colspan="6" class="text-secondary">Anda belum melakukan order iklan</td>
                            </tr>
                        @endif
                        @foreach ($order_list->data as $order)
                            <tr>
                                <th scope="row">0</th>
                                <td class="text-start">
                                    Nama Instansi<br>
                                    Ukuran Iklan<br>
                                    Tanggal Penerbitan<br>
                                    Deskripsi Iklan<br>
                                    <a href="#" class="text-decoration-none">Detail Lebih Lanjut</a>
                                </td>
                                <td class="text-start">
                                    : {{$order->nama_instansi}}<br>
                                    : {{$order->tinggi}} x {{$order->kolom}} mmk<br>
                                    : {{$order->mulai_iklan}} hingga {{$order->akhir_iklan}}<br>
                                    : {{$order->deskripsi_iklan}}<br>
                                </td>
                                <td>
                                    @if($order->status_iklan == "Telah Diupload")
                                        <p class="text-success">{{$order->status_iklan}}</p>
                                    @elseif($order->status_iklan == "Sedang Diproses")
                                        <p class="text-primary">{{$order->status_iklan}}</p>
                                    @elseif($order->status_iklan == "Dalam Antrian")
                                        <p class="text-primary">{{$order->status_iklan}}</p>
                                    @elseif($order->status_iklan == "Dibatalkan")
                                        <p class="text-danger">{{$order->status_iklan}}</p>
                                    @else
                                        <p class="text-secondary">{{$order->status_iklan}}</p>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="container" style="max-height: 21rem; width: 17rem; overflow: hidden"> 
                                        <a href="{{ asset('storage/image/'.$order->foto_iklan) }}" target="_blank">
                                            <img src="{{ asset('storage/image/'.$order->foto_iklan) }}" class="card-img-top" alt="..." style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    @if($order->status_pembayaran == "Belum Lunas")
                                    @php
                                        $curl = curl_init();
                                        curl_setopt_array($curl, array(
                                        CURLOPT_URL => 'https://api.xendit.co/v2/invoices/'.$order->invoice_id,
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_HTTPHEADER => array(
                                            'Authorization: Basic '.config('xendit.key')
                                        ),
                                        ));
                                        $invoice_data = curl_exec($curl);
                                        $invoice_data = json_decode($invoice_data);
                                        curl_close($curl);
                                        
                                        if(isset($invoice_data->status)){
                                            if($invoice_data->status == "PAID" || $invoice_data->status == "SETTLED"){
                                                $curl = curl_init();
                                                curl_setopt_array($curl, array(
                                                CURLOPT_URL => gethostname().'/websiteku/public/api/UpdateOrder/'.$order->order_id.'/2/Lunas',
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
                                                $update = curl_exec($curl);
                                                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                                curl_close($curl);

                                                if($http_status == 401){
                                                    setcookie("auth", "", time() - 3600, "/");
                                                    header("Location: " . URL::to('/login'), true, 302);
                                                    exit();
                                                }
                                                $order->status_pembayaran = "Lunas";
                                            } elseif($invoice_data->status == "EXPIRED"){
                                                $curl = curl_init();
                                                curl_setopt_array($curl, array(
                                                CURLOPT_URL => gethostname().'/websiteku/public/api/UpdateOrder/'.$order->order_id.'/2/Dibatalkan',
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
                                                $update = curl_exec($curl);
                                                curl_close($curl);

                                                $curl = curl_init();
                                                curl_setopt_array($curl, array(
                                                CURLOPT_URL => gethostname().'/websiteku/public/api/UpdateOrder/'.$order->order_id.'/1/Dibatalkan',
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
                                                $update = curl_exec($curl);
                                                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                                curl_close($curl);

                                                if($http_status == 401){
                                                    setcookie("auth", "", time() - 3600, "/");
                                                    header("Location: " . URL::to('/login'), true, 302);
                                                    exit();
                                                }
                                                $order->status_pembayaran = "Dibatalkan";
                                                $order->status_iklan = "Dibatalkan";
                                            }
                                        }
                                    @endphp
                                        @if($order->status_pembayaran == "Belum Lunas")
                                            <p class="text-secondary">{{$order->status_pembayaran}}</p>
                                            <a href="{{isset($order->invoice_id)? $xendit_link.$order->invoice_id : "#"}}" class="text-decoration-none" target="_blank">Bayar Disini</a>
                                        @endif
                                    @endif

                                    @if($order->status_pembayaran == "Lunas")
                                        <p class="text-success">{{$order->status_pembayaran}}</p>
                                        <a href="{{isset($order->invoice_id)? $xendit_link.$order->invoice_id : "#"}}" class="text-decoration-none" target="_blank">Invoice Disini</a>
                                    @elseif($order->status_pembayaran == "Dibatalkan")
                                        <p class="text-danger">{{$order->status_pembayaran}}</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                @if(isset($order_list->links->next, $order_list->links->prev))
                    <ul class="pagination justify-content-end">
                        @if (isset($order_list->links->next))
                            <li class="page-item">
                                <a class="page-link" href="{{ route('UserOrderHalamanSebelumnya')}}">Previous</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Previous</a>
                            </li>
                        @endif
                        {{-- Numbers --}}
                        @for ($i = $order_list->meta->current_page - 1; $i >= $order_list->meta->current_page - 2 && $i >= $order_list->meta->from; $i--)
                            <li class="page-item">
                                <a class="page-link" href="{{route('UserOrderHalamanNomor', ['page' => $i])}}">{{$i}}</a>
                            </li>
                        @endfor
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{$order_list->meta->current_page}}</span>
                        </li>
                        @for ($i = $order_list->meta->current_page + 1; $i <= $order_list->meta->current_page + 2 && $i <= $order_list->meta->from; $i++)
                            <li class="page-item">
                                <a class="page-link" href="{{route('UserOrderHalamanNomor', ['page' => $i])}}">{{$i}}</a>
                            </li>
                        @endfor
                        @if (isset($order_list->links->next))
                            <li class="page-item">
                                <a class="page-link" title="" href="{{ route('UserOrderHalamanSelanjutnya')}}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        @endif
                    </ul>
                    @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
