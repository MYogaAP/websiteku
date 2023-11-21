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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }

        .judul {
            font-family: 'Bodoni MT', serif;
            color: #1450A3;
        }
    </style>
</head>

<body>
    @if (!Cookie::has('auth'))
        <script>
            window.location = "{{ route('loginPage') }}";
        </script>
    @else
        @php
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => gethostname().'/websiteku/public/api/OrderDetail/'. $order_id,
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

            if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
                setcookie('auth', '', time() - 3600, '/');
                session()->flush();
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }
            if ($http_status == 403) {
                header('Location: ' . route('verification.notice'), true, 302);
                exit();
            }
        @endphp
    @endif
    @php
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.xendit.co/v2/invoices/'.$data->invoice_id,
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
        
        if(isset($invoice_data->paid)){
            $paid_date = now()->parse($invoice_data->paid_at)->format('d-M-Y');
        }
        if(isset($invoice_data->expiry_date)){
            $expiry_date = now()->parse($invoice_data->expiry_date)->format('d-M-Y');
        }
        if(isset($data)){
            $start = now()->parse($data->mulai_iklan)->format('d-M-Y');
            $end = now()->parse($data->mulai_iklan)->format('d-M-Y');
        }
        
        if(isset($invoice_data->status)){
            if($invoice_data->status == "PAID" || $invoice_data->status == "SETTLED"){
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => gethostname().'/websiteku/public/api/UpdatePayedOrder/'.$data->order_id,
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
                    $request->session()->flush();
                    header("Location: " . route('loginPage'), true, 302);
                    exit();
                }
                $data->status_pembayaran = "Lunas";
                $data->status_iklan = "Sedang Diproses";
            } elseif($invoice_data->status == "EXPIRED" && $data->status_pembayaran != "Dibatalkan"){
                $desk_up = "Waktu pembayaran habis.";
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => gethostname().'/websiteku/public/api/CancelOrder/'.$data->order_id,
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

                if($http_status == 401){
                    setcookie("auth", "", time() - 3600, "/");
                    $request->session()->flush();
                    header("Location: " . route('loginPage'), true, 302);
                    exit();
                }
                $data->status_pembayaran = "Dibatalkan";
                $data->status_iklan = "Dibatalkan";
                $data->foto_iklan = "none";
            }
        }
    @endphp

    {{-- Navigation Bar --}}
    <x-nav-bar-riwayat />
    {{-- Content --}}
    <br><br>
    <div class="container text-center mt-5">
        <div class="row mt-4 justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">No. Order</p>
            <p class="fw-bold col-sm-auto">: {{isset($data->nomor_order)?$data->nomor_order:"-"}}</p>
        </div>
        <div class="row justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">No. Seri</p>
            <p class="fw-bold col-sm-auto">: {{isset($data->nomor_seri)?$data->nomor_seri:"-"}}</p>
        </div>
        <div class="row justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">No. Invoice</p>
            <p class="fw-bold col-sm-auto">: {{isset($data->nomor_invoice)?$data->nomor_invoice:"-"}}</p>
        </div>
        <div class="row justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">ALAMAT</p>
            <p class="fw-bold col-sm-auto">: {{isset($data->alamat_instansi)?$data->alamat_instansi:"-"}}</p>
        </div>
        <div class="row mt-2">
            <div class="col">
                <h3 class="fw-bold">Detail Order Iklan</h3>
            </div>
        </div>
        <br>
        <br>
        <div class="text-start">
            <p class="fw-bold">Nama Pemasang <span style="padding-left: 73px;">: {{$data->nama_instansi}}</span></p>
            <p class="fw-bold">Ukuran Iklan <span style="padding-left: 111px;">: {{$data->tinggi}} x {{$data->kolom}} mmk</span></p>
            <p class="fw-bold">Tanggal Penerbitan <span style="padding-left: 55px;">: {{$start}} hingga {{$end}}</span></p>
            <p class="fw-bold">Nilai Iklan <span style="padding-left: 135px;">: {{$data->harga_paket}}</span></p>
            <p class="fw-bold">
                Waktu Pembayaran <span style="padding-left: 55px;">: {{isset($paid_date)?$paid_date:"-"}} </span>
                <span class="
                    @if($data->status_pembayaran == "Telah Tayang")
                        {{'text-success'}}
                    @elseif($data->status_pembayaran == "Menunggu Konfirmasi")
                        {{'text-secondary'}}
                    @elseif($data->status_pembayaran == "Dibatalkan")
                        {{'text-danger'}}
                    @else
                        {{'text-secondary'}}
                    @endif
                ">{{$data->status_pembayaran}}</span>
            </p>
            <p class="fw-bold">Jenis Pembayaran <span style="padding-left: 68px;">: TRANSFER</span></p>
            <p class="fw-bold">Kontak Person <span style="padding-left: 97px;">: {{$data->nomor_instansi}}</span></p>
            <p class="fw-bold">Keterangan <span style="padding-left: 121px;">: {{$data->deskripsi_iklan}}</span></p>
        </div>
    </div>
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="text-center">JUDUL IKLAN</th>
                    <th scope="col" class="text-center">UKURAN</th>
                    <th scope="col" class="text-center">HARGA</th>
                    <th scope="col" class="text-center">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">Pengumuman Terbit: {{$start}} hingga {{$end}}</td>
                    <td class="text-center">{{$data->tinggi}} x {{$data->kolom}} mmk</td>
                    <td class="text-center"> @money($data->harga_paket)</td>
                    <td class="text-center"> @money($data->harga_paket * $data->lama_hari)</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="container text-center mt-3">
        <div class="row mt-4 justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">Bruto</p>
            <p class="fw-bold col-sm-auto">: @money($data->harga_paket * $data->lama_hari)</p>
        </div>
        <div class="row mt-1 justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">Netto</p>
            <p class="fw-bold col-sm-auto">: @money($data->harga_paket * $data->lama_hari)</p>
        </div>
        {{-- <div class="row mt-1 justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">PPN 11%</p>
            <p class="fw-bold col-sm-auto">: </p>
        </div> --}}
        <div class="row mt-1 justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">TOTAL</p>
            <p class="fw-bold col-sm-auto">: @money($data->harga_paket * $data->lama_hari)</p>
        </div>
        <div class="row mt-1 justify-content-md-start text-start" style="font-size: 15px">
            <p class="fw-bold col-sm-7"></p>
            <p class="fw-bold col-sm-2">JATUH TEMPO</p>
            <p class="fw-bold col-sm-auto">: {{$expiry_date}}</p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>
</html>