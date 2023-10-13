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
        <div class="row mt-5">
            <div class="col">
                <h3 class="fw-bold">Pilih Paket Ukuran Iklan</h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <div class="card mx-auto" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Contoh Ukuran A x B</h5>
                        <p class="card-text">Harga Rp. .... /</p>
                        <a href="#" class="btn btn-primary">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mx-auto" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Contoh Ukuran A x B</h5>
                        <p class="card-text">Harga Rp. .... /</p>
                        <a href="#" class="btn btn-primary">Pilih Paket</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mx-auto" style="width: 18rem;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Contoh Ukuran A x B</h5>
                        <p class="card-text">Harga Rp. .... /</p>
                        <a href="#" class="btn btn-primary">Pilih Paket</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="d-flex justify-content-between mt-5">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary rounded px-5 mb-3">Sebelumnya</button>
                    </div>
                    <div class="text-start">
                        <button type="button" class="btn btn-primary rounded px-5 mb-3">Selanjutnya</button>
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
