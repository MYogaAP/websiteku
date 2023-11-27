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
    <div class="container text-center">
        <div class="row  mt-5">
            <div class="col fw-bold">
                <h3 class="fw-bold">Panduan Pesan Iklan</h3>
            </div>

            <div class="row">
                <div class="col">
                    <img class="shadow-lg" style="max-height: 70vh" src="{{ asset('public/images/koran.png') }}" alt="">
                        <br><br>
                        <div class="fw-bold text-start">Iklan Kolom</div>
                            <p class="text-start">
                                Iklan display yang besarannya ditentukan jumlah
                                kolom (lebar) dan satuan milimeter (tinggi). 
                                Maksimal sebesar 6 kolom x 530 milimeter (6 kolom = 3000 pixel, 530 milimeter = 5300 pixel).
                            </p>    
                        <div class="fw-bold text-start">Iklan Deret/Baris</div> 
                            <p class="text-start">
                                Iklan teks berukuran 1 kolom (50 milimeter / 500 pixel).
                                Iklan ini bisa dilampirkan dengan gambar ataupun tanpa gambar.
                                Iklan deret/baris ini dikelompokkan menjadi satu halaman iklan baris.
                            </p>
                        <div class="fw-bold text-start">Advetorial</div>    
                            <p class="text-start">
                                Advetorial bersifat berita dan materinya lebih detail menjabarkan promosi
                                yang sedang dilakukan. Bisa diterbitkan dengan gambar maupun tanpa gambar.
                            </p>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">JENIS IKLAN</th>
                                        <th scope="col">HARGA</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <th scope="row">Iklan Deret</th>
                                        <td>Rp. 20.000,-/baris</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Iklan Umum Display Hitam Putih</th>
                                        <td>Rp. 30.000,-/mmk</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Iklan Umum Display Berwarna</th>
                                        <td>Rp. 40.000,-/mmk</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Iklan Halaman 1 Utama dan Berwarna</th>
                                        <td>Rp. 120.000,-/mmk</td>
                                    </tr>
                                </tbody>
                            </table>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
