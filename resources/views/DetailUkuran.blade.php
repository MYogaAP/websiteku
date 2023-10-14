<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
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
    <x-nav-bar-login />

    {{-- Content --}}
    <div class="container text-center">
        <div class="row mt-4">
            <div class="col">
                <h3 class="fw-bold">Pilih Paket Ukuran Iklan</h3>
            </div>
        </div>
        <div class="row mt-3 align-items-center">
            <div class="col-1">
                <button class="btn-outline-primary rounded-pill text-center" style="width:60px; height:60px; font-size:35px; background-color:white;"><i class="fa-solid fa-chevron-left"></i></button>
            </div>
            <div class="col">
                <div class="card mx-auto shadow-sm" style="width: 17rem;">
                    <img src="{{ asset('images/Paket1.png') }}" class="card-img-top" alt="..." style="border: 1px solid black">
                    <div class="card-body">
                        <h5 class="card-title">Contoh Ukuran A x B</h5>
                        <p class="card-text">Harga Rp. .... /</p>
                        <a href="#" class="btn btn-primary" style="background-color: #0094E7; color:white">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mx-auto shadow-sm" style="width: 17rem;">
                    <img src="{{ asset('images/Paket2.png') }}" class="card-img-top" alt="..." style="border: 1px solid black">
                    <div class="card-body">
                        <h5 class="card-title">Contoh Ukuran A x B</h5>
                        <p class="card-text">Harga Rp. .... /</p>
                        <a href="#" class="btn btn-primary" style="background-color: #0094E7; color:white">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mx-auto shadow-sm" style="width: 17rem;">
                    <img src="{{ asset('images/Paket3.png') }}" class="card-img-top" alt="..." style="border: 1px solid black">
                    <div class="card-body">
                        <h5 class="card-title">Contoh Ukuran A x B</h5>
                        <p class="card-text">Harga Rp. .... /</p>
                        <a href="#" class="btn btn-primary" style="background-color: #0094E7; color:white">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col-1">
                <button class="btn-outline-primary rounded-pill text-center" style="width:60px; height:60px; font-size:35px; background-color:white;"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5" style="margin-top: -15px">
                <div class="d-flex justify-content-between mt-5">
                    <div class="text-end">
                        <a href="{{ route('pemesanan') }}" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white">Sebelumnya</a>
                    </div>
                    <div class="text-start">
                        <a href="{{ route('uploadandview') }}" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white">Selanjutnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
