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

    {{-- Content --}}
    <div class="container text-center" style="width: 55rem">
        <div class="row mt-4">
            <div class="col">
                <h3 class="fw-bold">Invoice Pembayaran</h3>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="card mx-auto shadow-sm rounded-3" style="width: 17rem;">
                    <div class="card-body bg-outline-primary rounded-3" style="background-color: #4E95F8">
                        <h5 style="color: white" class="fw-bold mb-3">SCAN QR-CODE</h5>
                        <img src="{{ asset('images/QR.png') }}" class="card-img-top rounded-3" alt="..." style="background-color:white">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mx-auto shadow-sm rounded-3" style="width: 20rem; height: 19rem">
                    <div class="card-body bg-outline-primary rounded-3" style="background-color: #4E95F8; color:white">
                        <h5 style="color: white" class="fw-bold mb-3">Detail Pembayaran</h5>
                        <hr>
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-sm-5 col-md-6">Nama Iklan</div>
                                <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">Paket AxB</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5 col-md-6">Jenis Iklan</div>
                                <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">Paket AxB</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-5 col-lg-6">Tanggal Mulai</div>
                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">xx/xx/xxxx</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-5 col-lg-6">Tanggal Akhir</div>
                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">xx/xx/xxxx</div>
                            </div>
                        </div>
                        <hr>
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-sm-5 col-md-6">Total Bayar</div>
                                <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">Rp. xxx.xxx.xxx</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <button class="btn rounded-4 ps-4 pe-4 fw-bold btn-success">Refresh</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
