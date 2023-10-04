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

    {{-- Content --}}
    <div>
        <div class="container text-center">
            <div class="row align-items-center justify-content-evenly" style="height: 80vh">
                <div class="col text-start">
                    <h1 class="fw-bold">Jasa Iklan Radar Banjarmasin</h1>
                    <p>Radar Banjarmasin menawarkan platform iklan terpercaya untuk mempromosikan bisnis
                        Anda di Kalimantan Selatan. Dengan jangkauan luas dan target audiens lokal, layanan ini
                        memaksimalkan
                        visibilitas usaha Anda secara efektif.</p>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary rounded-pill">Pesan Jasa</button>
                        <button type="button" class="btn btn-secondary rounded-pill">Baca Panduan</button>
                    </div>
                </div>
                <div class="col">
                    <img class="shadow-lg" style="max-height: 50vh" src="{{ asset('storage/images/koran.jpg') }}"
                        alt="">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
