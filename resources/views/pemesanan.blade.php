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

        /* Mengubah warna latar belakang date picker */
        .form-control[type="date"]::-webkit-calendar-picker-indicator {
            background-color: none;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 4px;
        }

        /* Mengubah warna teks pada date picker */
        .form-control[type="date"]::-webkit-datetime-edit {
            color: #7f7986;
        }

        /* Mengatur border date picker */
        .form-control[type="date"]::-webkit-inner-spin-button {
            display: none;
        }

        .form-control[type="date"]::-webkit-clear-button {
            display: none;
        }
    </style>
</head>

<body>
    {{-- Navigation Bar --}}
    <x-nav-bar-back />

    {{-- Conetent --}}
    <div class="container text-center mt-5">
        <div class="row fw-bold">
            <div class="col">
                <h3 class="fw-bold">Pemesanan Iklan</h3> 
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-6">
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Nama Instansi">
                </div>

                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-select rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Keperluan Iklan">
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <label for="" class="ps-2 text-secondary">Tanggal Mulai</label>
                    <div class="text-start mx-3">
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                    <label for="" class="text-secondary">Tanggal Berakhir</label>
                    <div class="text-end mx-3">
                        <input type="date" class="form-control" id="tanggal">
                    </div>
                </div>
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Deskripsi Keperluan Iklan (jika perlu)">
                </div>
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="Email Instansi / Kontak yang dapat dihubungi">
                </div>
                <div class="">
                    {{-- <div class="text-end">
                        <button type="button" class="btn btn-danger rounded-pill px-5 mb-3">Keluar</button>
                    </div> --}}
                    <div class="text-end">
                        <a href="{{ route('detailukuran') }}" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white">Selanjutnya</a>
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
