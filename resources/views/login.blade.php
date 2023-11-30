<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Iklan Radar Banjarmasin</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('public/favicon.ico')}}" />
    
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

        .text-center {
            text-align: center;
        }

        .mb-0 {
            margin-bottom: 0;
        }
    </style>
</head>

<body>

    @if (Cookie::has('auth'))
        @php
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/UserCheck',
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

            if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
                setcookie('auth', '', time() - 3600, '/');
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }
            if ($http_status == 403) {
                header('Location: ' . route('verification.notice'), true, 302);
                exit();
            }
        @endphp
        @if ($user_data->role == 'admin' || $user_data->role == 'agent')
            <script>
                window.location = "{{ route('orderData') }}";
            </script>
        @else
            <script>
                window.location = "{{ route('landingPagePro') }}";
            </script>
        @endif
    @endif

    {{-- Content --}}
    {{-- <div class="container text-center">
        <div class="row align-items-center justify-content-center" style="height: 80vh">
            <div class="col-4 shadow p-5 mt-5">
                <h1 class="mb-5">Masuk</h1>
                <div class="mb-3">
                <form method="POST" action="{{ route('LoginCall')}}">
                @csrf
                    <input type="username" name="username" class="form-control rounded-pill" id="exampleFormControlInput1" placeholder="username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" id="inputPassword5" class="form-control rounded-pill" aria-describedby="passwordHelpBlock" placeholder="password" required>
                </div>
                    <button type="submit" class="btn btn-primary rounded-pill px-5">Login</button>
                </form>

                <div class="mt-5">
                    <span>Belum memiliki akun? <a href="{{ route('registerPage') }}" class="fw-bold">Daftar Sekarang</a></span>
                    <span><a href="{{ route('password.request') }}" class="fw-bold" target="_blank">Lupa Password?</a></span>
                </div>
            </div>
        </div> --}}

    <section class="vh-100" style="background-color: #1450A3;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="{{ asset('public/images/loginPage.png') }}" alt="login form" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <div class="d-flex align-items-center mb-3 pb-1">
                                        <span class="h1 fw-bold mb-0">Selamat Datang!</span>
                                    </div>
                                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Jasa Iklan Radar
                                        Banjarmasin</h5>
                                    <div class="form-outline mb-4">
                                        <form method="POST" action="{{ route('LoginCall') }}">
                                            @csrf
                                            Username atau Email
                                            <input type="username" name="username" class="form-control form-control-lg"
                                                id="exampleFormControlInput1" required>
                                    </div>
                                    <div class="form-outline mb-4">
                                        Password
                                        <input type="password" name="password" id="inputPassword5"
                                            class="form-control form-control-lg" required>
                                    </div>
                                    <div>
                                        @if (isset($errors_msg))
                                            @foreach ($errors_msg as $error)
                                                <div class="alert alert-danger alert-dismissible fade show"
                                                    role="alert">
                                                    @foreach ($error as $msg)
                                                        {{ $msg }} <br>
                                                    @endforeach
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endforeach
                                        @endif
                                        @if (isset($error_msg))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ $error_msg }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (isset($message))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ $message }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                        @if (session()->has('status'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ session()->get('status') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-dark btn-lg btn-block w-100" type="submit"
                                            style="background-color: #1450A3">Masuk</button>
                                    </div>
                                    </form>
                                    <hr class="my-4">
                                    <div class="text-center mb-4">
                                        <a class="small text-muted d-block mb-2" href="{{ route('password.request') }}"
                                            style="text-decoration: none; font-size: 18px">Lupa password?</a>
                                        <p class="mb-0" style="color: #393f81; ">Belum memiliki akun?
                                            <a href="{{ route('registerPage') }}" class="fw-bold"
                                                style="color: #393f81; text-decoration: none;">Daftar sekarang</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
