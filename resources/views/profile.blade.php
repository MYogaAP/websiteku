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
    <x-nav-bar-back />

    {{-- Conetent --}}

    @php
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => '127.0.0.1/websiteku/public/api/UserCheck',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer jk8hRBZH7NonOuQTYvM7ZWeviRt9FzloHeUljhkr79c2defd'
        ),
        ));
        $data = curl_exec($curl);
        $data = json_decode($data);
    @endphp

    <div>
        <div class="container">
            <div class="row mt-5">
                <h1 class="text-center">Identitas Profil Akun</h1>
            </div>
            <div class="row mt-5">
                <div class="col-4">
                    <div class="text-center">
                        <img src="{{ asset('storage/images/koran.jpg') }}" alt="" width="200px" class="border">
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary rounded-pill px-3 mb-3">Ganti Foto</button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="username" class="form-control rounded-pill" id="exampleFormControlInput1"
                            placeholder="username" value="{{$data->username}}">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control rounded-pill" id="exampleFormControlInput1"
                            placeholder="password" value="YourPassword">
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary round-5 px-3 mb-3">Ganti Password</button>
                    </div>
                    <div class="mb-3">
                        <input type="username" class="form-control rounded-pill" id="exampleFormControlInput1"
                            placeholder="No HP" value="{{$data->no_hp}}">
                    </div>
                    <div class="mb-3">
                        <input type="username" class="form-control rounded-pill" id="exampleFormControlInput1"
                            placeholder="Pekerjaan" value="{{$data->perkerjaan}}">
                    </div>
                    <div class="d-flex  justify-content-between">
                        <div class="text-end">
                            <a href="">
                            <button type="button" class="btn btn-danger rounded-pill px-5 mb-3">Keluar</button>
                            </a>
                        </div>
                        <div class="text-start">
                            <button type="button" class="btn btn-primary rounded-pill px-5 mb-3">Simpan</button>
                        </div>
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
