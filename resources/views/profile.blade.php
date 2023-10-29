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
            font-family: 'Bodoni MT', serif;
            color: #1450A3;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    {{-- Navigation Bar --}}
    <x-nav-bar-back />

    {{-- Conetent --}}

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
            $data = curl_exec($curl);
            $data = json_decode($data);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            if($http_status == 401){
                setcookie("auth", "", time() - 3600, "/");
                header("Location: " . URL::to('/login'), true, 302);
                exit();
            }
        @endphp

        <div>
            <div class="container">
                <div class="mt-5 ">
                    <h3 class="text-center fw-bold">Identitas Profil Akun</h3>
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    <div class="col-6">
                        <div class="mb-3">
                            <input type="username" class="form-control rounded-pill" id="username" name='username'
                                placeholder="username" value="{{$data->username}}" disabled>
                        </div>

                        <form action="{{route('UpdatePasswordCall')}}" method="post" id="UpdatePassword">
                            @method('PATCH')
                            @csrf
                            <div class="mb-3">
                                <input type="password" class="form-control rounded-pill" id="password" name="password"
                                    placeholder="password" value="YourPassword">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-secondary round-5 px-3 mb-3">Ganti Password</button>
                            </div>
                        </form>

                        <form action="{{route('UpdateProfileCall')}}" method="POST">
                        @method('PATCH')
                        @csrf

                        <div class="mb-3">
                            <input type="text" class="form-control rounded-pill" id="no_hp" name="no_hp"
                                placeholder="No HP" value="{{$data->no_hp}}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-pill" id="pekerjaan" name="pekerjaan"
                                placeholder="Pekerjaan" value="{{$data->pekerjaan}}">
                        </div>
                        <div class="d-flex flex-row-reverse justify-content-between">
                            <div class="text-start m">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 mb-3">Simpan</button>
                            </div>
                            
                        </form>
                            <div class="text-end">
                                <form action="{{route('LogoutCall')}}" method='POST'>
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger rounded-pill px-5 mb-3">Keluar</button>
                                </form>
                            </div>
                        </div>

                        @if(!empty($MessageSuccess))
                            <div class="mb-3 alert alert-success">
                                {{ $MessageSuccess }}
                            </div>
                        @endif

                        @if(!empty($MessageWarning))
                            @foreach ($MessageWarning as $message)
                                <div class="mb-3 alert alert-danger">
                                    {{$message}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
