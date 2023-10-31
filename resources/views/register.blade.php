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
</head>

<body>
    {{-- Navigation Bar --}}
    <x-nav-bar />

    @if(Cookie::has('auth'))
        <script>window.location="{{route('landingPageLogin')}}";</script>
    @endif

    {{-- Content --}}
    <div class="container text-center">
        <div class="row align-items-center justify-content-center" style="height: 80vh">
            <div class="col-4 shadow p-5">
                <h1 class="mb-5">Daftar</h1>

                @if(isset($message))
                    <p>{{ $message }}</p>
                @else
                    <p></p>
                @endif

                <form method="POST" action="{{ route('RegisterCall')}}">
                    @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control rounded-pill" id="email" placeholder="Ketik email disini" required>
                        </div>
                        <div class="mb-3">
                            <input type="username" name="username" class="form-control rounded-pill" id="username" placeholder="Ketik username disini" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" id="password" name="password" class="form-control rounded-pill" aria-describedby="passwordHelpBlock" placeholder="Ketik password disini" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control rounded-pill" aria-describedby="passwordHelpBlock" placeholder="Ketik ulang password disini" required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-5">Register</button>
                </form>

                <div class="mt-5">
                    <span>Sudah memiliki akun? <a href="{{ route('loginPage') }}" class="fw-bold">Masuk Sekarang!</a></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        var password = document.getElementById("password");
        var confirm_password = document.getElementById("confirm_password");

        function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match");
            } else {
                confirm_password.setCustomValidity('');
            }
        }
        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
