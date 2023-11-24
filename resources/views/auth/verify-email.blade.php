<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Iklan Radar Banjarmasin</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />

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
    @if (!Cookie::has('auth'))
        <script>
            window.location = "{{ route('loginPage') }}";
        </script>
    @else
        <x-nav-bar-login />
        @php
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => gethostname() . '/websiteku/public/api/UserCheck',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => ['Accept: application/json', 'Authorization: Bearer ' . Cookie::get('auth')],
            ]);
            $user_data = curl_exec($curl);
            $user_data = json_decode($user_data);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($http_status == 401) {
                setcookie('auth', '', time() - 3600, '/');
                session()->flush();
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }
        @endphp
    @endif

    {{-- Content --}}
    {{-- <div class="container text-center">
        <div class="row align-items-center justify-content-center" style="height: 80vh">
            <div class="col-4 shadow p-5 mt-5">
                <h1 class="mb-5">Verifikasi Email Anda</h1>
                @if ($http_status == 200)
                    <a href="{{route('landingPagePro')}}" class="btn btn-primary rounded-pill px-5">
                        Lanjutkan</a>
                @else
                    <form method="POST" action="{{route('verification.send')}}">
                        @csrf
                            <button type="submit" class="btn btn-primary rounded-pill px-5">Kirim Email</button>
                    </form>
                @endif
                
            </div>
        </div>
    </div> --}}

    <section class="vh-100" style="background-color: #1450A3;">
        <div class="container py-5 vh-100">
            <div class="row d-flex justify-content-center align-items-center mt-5">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center justify-content-center mb-3 pb-1">
                                <span class="h3 fw-bold mb-0 text-center">Email Anda Telah Terverifikasi</span>
                            </div>
                            @if ($http_status == 200)
                                <a href="{{ route('landingPagePro') }}" class="d-flex btn btn-primary rounded-pill px-5 justify-content-center align-items-center">Masuk Beranda</a>
                            @else
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <div class="pt-1 mb-4">
                                        <button type="submit" class="btn btn-dark btn-lg btn-block w-100"
                                            style="background-color: #1450A3">Kirim Verifikasi</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center align-items-center mt-5">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="shadow-2-strong" style="border-radius: 1rem;">
                        <div class="p-0">
                            @if (session()->has('error'))
                                <div class="row align-items-center justify-content-center" style="margin: -2rem">
                                    <div class="alert alert-danger alert-dismissible fade show text-center"
                                        role="alert">
                                        {{ session()->get('error') }} <br>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            @if (session()->has('status'))
                                <div class="row align-items-center justify-content-center" style="margin: -2rem">
                                    <div class="alert alert-success alert-dismissible fade show text-center"
                                        role="alert">
                                        {{ session()->get('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        session()->forget('status');
        session()->forget('error');
    @endphp

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
