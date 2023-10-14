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

    {{-- Content --}}
    <div class="container text-center mt-5 border rounded-4">
        <div class="row align-items-start">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nama Instansi</th>
                            <th scope="col">Mulai</th>
                            <th scope="col">Akhir</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Status Iklan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>PT. Trikora</td>
                            <td>Senin/04/09/2023</td>
                            <td>Sabtu/09/09/2023</td>
                            <td class="text-success">Berhasil</td>
                            <td class="text-success">Diterima</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>PT. Ro Ulin</td>
                            <td>Senin/11/09/2023</td>
                            <td>Sabtu/16/09/2023</td>
                            <td class="text-danger">Gagal</td>
                            <td class="text-danger">Dibatalkan</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>PT. Sutoyo S</td>
                            <td>Senin/25/09/2023</td>
                            <td>Sabtu/30/09/2023</td>
                            <td>Menunggu Pembayaran</td>
                            <td>Menunggu Konfirmasi</td>
                        </tr>
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
