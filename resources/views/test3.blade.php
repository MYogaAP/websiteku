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
            font-family: 'Bodoni Moda', serif;
            color: #1450A3;
        }
    </style>
</head>

<body>
    {{-- Navigation Bar --}}
    <nav class="navbar bg-body-tertiary p-3 shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 judul">RADAR BANJARMASIN</span>
            <a href="#" class="text-decoration-none text-black">Kembali</a>
        </div>
    </nav>

    {{-- Content --}}
    <div class="container text-center">
        <div class="row align-items-center justify-content-center" style="height: 80vh">
            <div class="col-4 shadow p-5">
                <h1 class="mb-5">Daftar</h1>
                <div class="mb-3">
                    <input type="email" class="form-control rounded-pill" id="exampleFormControlInput1"
                        placeholder="email">
                </div>
                <div class="mb-3">
                    <input type="username" class="form-control rounded-pill" id="exampleFormControlInput1"
                        placeholder="username">
                </div>
                <div class="mb-3">
                    <input type="password" id="inputPassword5" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="password">
                </div>
                <div class="mb-3">
                    <input type="repassword" id="inputPassword6" class="form-control rounded-pill"
                        aria-describedby="passwordHelpBlock" placeholder="ketik ulang password">
                </div>
                <button type="button" class="btn btn-primary rounded-pill px-5">Register</button>
                <div class="mt-5">
                    <span>Sudah memiliki akun? <a href="" class="fw-bold">Masuk Sekarang!</a></span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
