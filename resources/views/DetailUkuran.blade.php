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
    {{-- Navigation Bar --}}
    <x-nav-bar-back />

    @if(!Cookie::has('auth'))
        <script>window.location="{{route('loginPage')}}";</script>
    @else
        @php
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
            $response = curl_exec($curl);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            if($http_status == 401){
                setcookie("auth", "", time() - 3600, "/");
                header("Location: " . URL::to('/login'), true, 302);
                exit();
            }
            
            $ukuran = session('ukuran_data');
            if(empty($ukuran)){
                header("Location: " . route("landingPageLogin"), true, 302);
                exit();
            }
        @endphp
    @endif

    {{-- Content --}}
    <div class="container text-center">
        <div class="row mt-4">
            <div class="col">
                <h3 class="fw-bold">Pilih Paket Ukuran Iklan</h3>
            </div>
        </div>
        <form action="{{ route('SimpanUkuran') }}" method="POST">
            @csrf
            <div class="row mt-3 align-items-center">
                @if(isset($ukuran->links->prev))
                    <div class="col-1">
                        <a href="{{ route('UkuranHalamanSebelumnya') }}" class="link-primary" style="width:60px; height:60px; font-size:35px;"><i class="fa-solid fa-chevron-left"></i></a>
                    </div>
                @else
                    <div class="col-1">
                        <a href="#" class="link-secondary" style="width:60px; height:60px; font-size:35px; pointer-events: none;"><i class="fa-solid fa-chevron-left"></i></a>
                    </div>
                @endif
                @foreach ($ukuran->data as $packet)
                    <div class="col">
                        <div class="card mx-auto shadow-sm" style="width: 17rem;">
                            <div class="container" style="width: 17rem; height: 21rem; overflow: hidden">   
                                <img src="{{ asset('storage/image_example/'.$packet->contoh_foto) }}" class="card-img-top" alt="..." style="border: 1px solid black; object-fit: cover; width: 100%; height: 100%">
                            </div>    
                            <div class="card-body">
                                <h5 class="card-title">Contoh Ukuran {{$packet->tinggi}} mm x {{$packet->kolom}} kolom</h5>
                                <p class="card-text">Harga Rp. @money($packet->harga_paket)</p>
                                {{-- <a href="#" class="btn btn-primary" style="background-color: #0094E7; color:white">Pilih Paket</a> --}}
                                <input type="radio" class="btn-check" name="data_paket" id="{{$packet->nama_paket}}" value="{{$packet->packet_id}}" required>
                                <label class="btn btn-outline-primary" for="{{$packet->nama_paket}}">Pilih Paket</label>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if(isset($ukuran->links->next))
                    <div class="col-1">
                        <a href="{{ route('UkuranHalamanSelanjutnya') }}" class="link-primary" style="width:60px; height:60px; font-size:35px;"><i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                @else
                    <div class="col-1">
                        <a href="#" class="link-secondary" style="width:60px; height:60px; font-size:35px; pointer-events: none;"><i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                @endif
            </div>
            <div class="row justify-content-center">
                <div class="col-5" style="margin-top: -15px">
                    <div class="d-flex justify-content-between mt-5">
                        <div class="text-end">
                            <a href="{{ route('pemesanan') }}" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white">Sebelumnya</a>
                        </div>
                        <div class="text-start">
                            <input type="submit" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white" value="Selanjutnya">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
