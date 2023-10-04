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
    <x-nav-bar />

    {{-- Conetent --}}
    <div class="container text-center">
        <div class="row">
            <div class="col">Detail Pemesanan Iklan</div>
        </div>
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Nama Instansi">
                </div>
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-select rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Keperluan Iklan">
                </div>
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Deskripsi Keperluan Iklan (jika perlu)">
                </div>
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Email Instansi / Kontak yang dapat dihubungi">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
