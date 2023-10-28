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
    @else
        @php
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => gethostname().'/websiteku/public/api/UserOrdersList',
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
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $response = curl_exec($curl);
            $response = json_decode($response);
            
            if($http_status == 401){
                setcookie("auth", "", time() - 3600, "/");
                header("Location: " . URL::to('/login'), true, 302);
                exit();
            }
        @endphp
    @endif

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
                        @foreach ($response->data as $order)
                            <tr>
                                <th scope="row">0</th>
                                <td class="text-start">
                                    Nama Instansi<br>
                                    Ukuran Iklan<br>
                                    Tanggal Penerbitan<br>
                                    Deskripsi Iklan<br>
                                </td>
                                <td class="text-start">
                                    : {{$order->nama_instansi}}<br>
                                    : {{$order->tinggi}} x {{$order->kolom}} mmk<br>
                                    : {{$order->mulai_iklan}} hingga {{$order->akhir_iklan}}<br>
                                    : {{$order->deskripsi_iklan}}<br>
                                </td>
                                <td class="text-primary">{{$order->status_iklan}}</td>
                                <td></td>
                                <td><a href="{{isset($order->order_invoice)? $order->order_invoice : "#"}}">Disini</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
