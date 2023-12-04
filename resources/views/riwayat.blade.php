<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Iklan Radar Banjarmasin</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('public/favicon.ico')}}" />
    
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
            padding-top: 60px;
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
            $xendit_link = "https://checkout.xendit.co/v2/";
            $canceling = session('cancel');
        }else {
            header("Location: " . route('landingPagePro'), true, 302);
            exit();
        }
    @endphp

    {{-- Content --}}
    <div class="container text-center mt-5 border rounded-4">
        @isset($canceling->message)
            <div class="d-flex justify-content-center">
                <div class="mb-1 mt-3 alert alert-success w-50">
                    {{ $canceling->message }}
                </div>
            </div>
        @endisset
        @if(session()->has('message'))
            <div class="d-flex justify-content-center">
                <div class="mb-1 mt-3 alert alert-success w-50">
                    {{ session()->get('message') }}
                </div>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="d-flex justify-content-center">
                <div class="mb-1 mt-3 alert alert-danger w-50">
                    {{ session()->get('error') }}
                </div>
            </div>
        @endif
        <div class="row align-items-start">
            <div class="col">
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th scope="col">No Order</th>
                            <th scope="col">Detail Iklan</th>
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
                                            CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/UpdatePayedOrder/'.$order->order_id,
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
                                                session()->flush();
                                                header("Location: " . route('loginPage'), true, 302);
                                                exit();
                                            }
                                            $order->status_pembayaran = "Lunas";
                                            $order->status_iklan = "Sedang Diproses";
                                        } elseif($invoice_data->status == "EXPIRED" && ($order->status_pembayaran != "Pembayaran Kedaluwarsa" || $order->status_pembayaran != "Dibatalkan")){
                                            $desk_up = "Waktu pembayaran habis.";
                                            $curl = curl_init();
                                            curl_setopt_array($curl, array(
                                            CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/CancelOrder/'.$order->order_id.'/exp',
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
                                                session()->flush();
                                                header("Location: " . route('loginPage'), true, 302);
                                                exit();
                                            }
                                            $order->status_pembayaran = "Pembayaran Kedaluwarsa";
                                            $order->status_iklan = "Dibatalkan";
                                            $order->foto_iklan = "none";
                                        }
                                    }
                                @endphp
                            @endif
                            @php
                                if(isset($order_list)){
                                    $start = now()->parse($order->mulai_iklan)->format('d-M-Y');
                                    $end = now()->parse($order->akhir_iklan)->format('d-M-Y');
                                }
                                if($order->tanggal_pembayaran != "-"){
                                    $paid = now()->parse($order->tanggal_pembayaran)->format('d-M-Y H:i:s');
                                }
                            @endphp
                            <tr>
                                <th scope="row">
                                    <p>
                                        @if (isset($order->nomor_order))
                                            {{$order->nomor_order}}
                                        @else
                                            {{'--------------------'}}
                                        @endif    
                                    </p>
                                </th>
                                <td class="text-start">
                                    <div class="container p-2">
                                        <div class="row">
                                            <div class="col">
                                                <p>Nama Instansi</p>
                                            </div>
                                            <div class="col-8">
                                                <p>: {{$order->nama_instansi}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>Ukuran Iklan</p>
                                            </div>
                                            <div class="col-8">
                                                <p>: {{$order->tinggi}} x {{$order->kolom}} mmk</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>Tanggal Penerbitan</p>
                                            </div>
                                            <div class="col-8">
                                                <p>: {{$start}} hingga {{$start}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>Deskripsi Iklan</p>
                                            </div>
                                            <div class="col-8">
                                                <p>: {{$order->deskripsi_iklan}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>Waktu Pembayaran</p>
                                            </div>
                                            <div class="col-8">
                                                <p>: {{isset($paid)?$paid:"-"}} </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p>Progress Iklan</p>
                                            </div>
                                            <div class="col-8">
                                                <p>: {{isset($order->detail_kemajuan)? $order->detail_kemajuan:"-" }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <p><a href="{{ route('riwayatDetail', ['order_id' => $order->order_id]) }}" class="text-decoration-none">Detail Lebih Lanjut</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="
                                        @if($order->status_iklan == "Telah Tayang")
                                            {{'text-success'}}
                                        @elseif($order->status_iklan == "Menunggu Pembayaran")
                                            {{'text-primary'}}
                                        @elseif($order->status_iklan == "Dibatalkan")
                                            {{'text-danger'}}
                                        @else
                                            {{'text-secondary'}}
                                        @endif
                                    ">
                                        {{$order->status_iklan}}</p>
                                </td>
                                <td class="align-middle">
                                    <div class="container" style="max-height: 21rem; width: 17rem; overflow: hidden"> 
                                        @if($order->foto_iklan == "none")
                                            <a href="{{ asset('public/images/logo.jpeg') }}" target="_blank">
                                                <img src="{{ asset('public/images/logo.jpeg') }}" class="card-img-top" alt="" style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                            </a>
                                        @else
                                            <a href="{{ asset('public/storage/image/'.$order->foto_iklan) }}" target="_blank">
                                                <img src="{{ asset('public/storage/image/'.$order->foto_iklan) }}" class="card-img-top" alt="" style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($order->status_pembayaran == "Belum Lunas")
                                        <p class="text-secondary">{{$order->status_pembayaran}}</p>
                                        <p><a href="{{isset($order->invoice_id)? $xendit_link.$order->invoice_id : "#"}}" class="text-decoration-none btn btn-sm w-100 btn-outline-primary rounded" target="_blank">
                                            Bayar Disini
                                        </a></p>
                                        <p><form action="{{route('DeleteOrderCall', ['order' => $order->order_id])}}" method="POST" class="FormBatalkanXendit">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="xendit_id" value="{{$order->invoice_id}}">
                                            <input type="submit" class="btn btn-outline-danger rounded btn-sm w-100" value="Batalkan">
                                        </form></p>
                                    @endif

                                    @if($order->status_pembayaran == "Lunas")
                                        <p class="text-success">{{$order->status_pembayaran}}</p>
                                        <a href="{{isset($order->invoice_id)? $xendit_link.$order->invoice_id : "#"}}" class="text-decoration-none" target="_blank">Invoice Disini</a>
                                    @elseif($order->status_pembayaran == "Dibatalkan" || $order->status_pembayaran == "Pembayaran Kedaluwarsa")
                                        <p class="text-danger">{{$order->status_pembayaran}}</p>
                                    @elseif($order->status_pembayaran == "Menunggu Konfirmasi")
                                        <p class="text-secondary">{{$order->status_pembayaran}}</p>
                                        <p><form action="{{route('CancelingOrderCall', ['order' => $order->order_id])}}" method="POST" class="FormBatalkanOrder">
                                            @method('DELETE')
                                            @csrf
                                            <input type="submit" class="btn btn-outline-danger rounded btn-sm w-100" value="Batalkan">
                                        </form></p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- PAGINATION --}}
                @if(isset($order_list->links->next) || isset($order_list->links->prev))
                    <ul class="pagination justify-content-end">
                        {{-- Previous Page --}}
                        <li class="page-item {{ isset($order_list->links->prev) ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ isset($order_list->links->prev) ? route('UserOrderHalamanSebelumnya') : '#' }}">Previous</a>
                        </li>

                        {{-- Page Numbers --}}
                        @for ($i = max(1, $order_list->meta->current_page - 3); $i <= min($order_list->meta->last_page, $order_list->meta->current_page + 3); $i++)
                            @if ($i != $order_list->meta->current_page)
                                <li class="page-item">
                                    <a class="page-link" href="{{ route('UserOrderHalamanNomor', ['page' => $i]) }}">{{ $i }}</a>
                                </li>
                            @else
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $i }}</span>
                                </li>
                            @endif
                        @endfor

                        {{-- Next Page --}}
                        <li class="page-item {{ isset($order_list->links->next) ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ isset($order_list->links->next) ? route('UserOrderHalamanSelanjutnya') : '#' }}" title="Next">Next</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </div>

    @php
        session()->forget('cancel');
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Get all elements with the class "FormBatalkanOrder"
        const forms = document.querySelectorAll(".FormBatalkanOrder");

        // Iterate over each form
        forms.forEach((form) => {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                const swal = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-outline-danger",
                        cancelButton: "btn btn-outline-primary",
                        actions: "d-flex justify-content-center gap-3"
                    },
                    buttonsStyling: false
                });

                // Membuat Model
                swal.fire({
                    title: "Apakah anda yakin ingin membatalkan?",
                    html: "Anda akan MEMBATALKAN sebuah order!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Lanjutkan",
                    cancelButtonText: "Kembali",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the specific form that triggered the event
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script>
        // Get all elements with the class "FormBatalkanXendit"
        const forms = document.querySelectorAll(".FormBatalkanXendit");

        // Iterate over each form
        forms.forEach((form) => {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                const swal = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-outline-danger",
                        cancelButton: "btn btn-outline-primary",
                        actions: "d-flex justify-content-center gap-3"
                    },
                    buttonsStyling: false
                });

                // Membuat Model
                swal.fire({
                    title: "Apakah anda yakin ingin membatalkan pembayaran?",
                    html: "Anda akan MEMBATALKAN pembayaran sebuah order!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Lanjutkan",
                    cancelButtonText: "Kembali",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the specific form that triggered the event
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
