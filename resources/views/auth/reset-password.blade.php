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
    </style>
</head>

<body>

    {{-- Content --}}
    {{-- <div class="container text-center">
        <div class="row align-items-center justify-content-center" style="height: 80vh">
            <div class="col-4 shadow p-5 mt-5">
                <h1 class="mb-5">Lupa Password</h1>
                <form method="POST" action="{{route('password.update')}}">
                    @csrf
                        <input type="hidden" name="token" value="{{request()->token}}">
                        <input type="hidden" name="email" value="{{request()->email}}">
                        <div class="mb-3">
                            <input type="password" id="password" name="password" class="form-control rounded-pill" aria-describedby="passwordHelpBlock" placeholder="Ketik password disini" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control rounded-pill" aria-describedby="passwordHelpBlock" placeholder="Ketik ulang password disini" required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-5">Update Password</button>
                </form>
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
                                <span class="h3 fw-bold mb-0">Lupa Password</span>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ request()->token }}">
                                    <input type="hidden" name="email" value="{{ request()->email }}">
                                    <div class="form-outline mb-2">
                                        Password
                                        <input type="password" name="password" class="form-control form-control-lg"
                                            id="password" required>
                                        Konfirmasi Password
                                        <input type="password" name="password_confirmation"
                                            class="form-control form-control-lg" id="password_confirmation" required>
                                    </div>
                                    <div class="pt-1 mb-4">
                                        <button type="submit" class="btn btn-dark btn-lg btn-block w-100"
                                            style="background-color: #1450A3">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                            <div>
                                @if ($errors->any())
                                    <div class="row align-items-center justify-content-center p-4"
                                        style="margin: -2rem">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            @foreach ($errors->all() as $data)
                                                {{ $data }} <br>
                                            @endforeach
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif
                                @if (session()->has('status'))
                                    <div class="row align-items-center justify-content-center p-4"
                                        style="margin: -2rem">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
