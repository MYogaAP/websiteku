<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Jasa Iklan Radar Banjarmasin</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link type="text/css" href="{{ asset('customerStyle/css/styles.css') }}" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:opsz,wght@6..96,800&family=Montserrat&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        header {
            background-image: url({{ asset('customerStyle/background-home.png') }});
        }

        body {
            font-family: 'Montserrat', sans-serif;
            padding-top: 70px;
        }

        .judul {
            font-family: 'Bodoni MT', serif;
            color: #1450A3;
            transition: color 0.3s;
        }

        .judul:hover {
            color: #1450A3;
        }

        .scroll-down-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: fadeInDown 2s ease infinite;
        }

        .scroll-down-indicator p {
            margin-bottom: 5px;
            color: white;
            text-align: center;
        }

        .arrow {
            width: 30px;
            height: 30px;
            border-width: 2px 2px 0 0;
            transform: rotate(-45deg);
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            animation: bounce 2s infinite;
        }

        .arrow::before {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-right: 2px solid white;
            border-bottom: 2px solid white;
            transform: rotate(45deg);
            bottom: 5px;
            right: 5px;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }


    </style>
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        @if (!Cookie::has('auth'))
            <x-nav-bar />
            {{-- <script>
                window.location = "{{ route('loginPage') }}";
            </script> --}}
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

                if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
                    setcookie('auth', '', time() - 3600, '/');
                    session()->flush();
                    header('Location: ' . route('loginPage'), true, 302);
                    exit();
                }
                if ($http_status == 403) {
                    header('Location: ' . route('verification.notice'), true, 302);
                    exit();
                }
                session()->flush();
            @endphp
            @if ($user_data->role == 'admin' || $user_data->role == 'agent')
                <script>
                    window.location = "{{ route('orderData') }}";
                </script>
            @endif
        @endif

        <!-- Header-->
        <header class="py-4 position-relative">
            <div class="container px-4">
                <div class="row gx-5 align-items-center justify-content-center">
                    <div class="col-lg-8 col-xl-7 col-xxl-6">
                        <div class="my-5 text-center text-xl-start">
                            <h2 class="display-5 fw-bolder text-white mb-2">Jasa Iklan</h2>
                            <h1 class="display-5 fw-bolder text-white mb-2">Radar Banjarmasin</h1>
                            <p style="color: white; font-size: 16px; text-align:justify;">Radar Banjarmasin menawarkan
                                platform iklan
                                terpercaya untuk mempromosikan bisnis Anda di Kalimantan Selatan. Dengan jangkauan luas
                                dan target audiens lokal, layanan ini memaksimalkan visibilitas usaha Anda secara
                                efektif.</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                <a class="btn btn-primary btn-lg px-4 me-sm-3" href="{{ route('pemesanan') }}">Pesan Jasa</a>
                                <a class="btn btn-outline-light btn-lg px-4" href="{{ route('panduanPro') }}">Panduan</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5"
                            src="{{ asset('images/koran-1.png') }}" alt="..." /></div>
                </div>
            </div>
            <div class="scroll-down-indicator">
                <div class="arrow"></div>
            </div>
        </header>
        <!-- Features section-->
        <section class="py-5" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5">
                    <div class="col-lg-4 mb-5 mb-lg-0 d-flex align-items-center justify-content-center">
                        <h3 class="fw-bolder mb-5">Keuntungan dan kemudahan jasa iklan koran secara digital</h3>
                    </div>
                    <div class="col-lg">
                        <div class="row gx-5 row-cols-1 row-cols-md-3">
                            <div class="col mb-5 h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                    <i class="fa-solid fa-handshake-simple"></i>
                                </div>
                                <h2 class="h5 fw-bold">Kemudahan Akses</h2>
                                <p class="mb-0" style="text-align:justify">Proses pemesanan yang dapat dilakukan kapan saja dan di mana saja 
                                    menghemat waktu dan tenaga Anda. Tidak perlu lagi datang langsung ke kantor 
                                    untuk melakukan transaksi, memberikan fleksibilitas yang signifikan.</p>
                            </div>
                            <div class="col mb-5 h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                    <i class="fa-brands fa-get-pocket"></i>
                                </div>
                                <h2 class="h5 fw-bold">Fleksibilitas Pemilihan Paket</h2>
                                <p class="mb-0" style="text-align:justify">Tanpa proses rumit, sekarang Anda dapat menyesuaikan pilihan iklan sesuai 
                                    dengan target audiens dan anggaran bisnis Anda. Hal ini memberikan tingkat 
                                    fleksibilitas yang optimal untuk strategi pemasaran Anda.</p>
                            </div>
                            <div class="col h-100">
                                <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                                    <i class="fa-solid fa-hand-holding-dollar"></i>
                                </div>
                                <h2 class="h5 fw-bold">Transaksi Secara Digital</h2>
                                <p class="mb-0" style="text-align:justify">Pembayaran dapat dilakukan secara digital, menghilangkan kebutuhan 
                                    untuk transaksi tunai atau pergi ke lokasi fisik, memberikan tingkat keamanan 
                                    dan kenyamanan yang tinggi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial section-->
        <div class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col">
                        <div class="text-center">
                            <div class="fs-4 mb-5 fst-italic">"Ciptakan jejak sukses bisnismu melalui iklan koran yang tepat sasaran."</div>
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="rounded-circle me-3" src="{{ asset('images/40.png') }}" alt="..." />
                                <div class="fw-bold">
                                    Radar Banjarmasin
                                    <span class="fw-bold text-primary mx-1">-</span>
                                    Paling Paham Soal Banua
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer-->
    <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; Kerja Praktik - Universitas Lambung Mangkurat 2023</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('customerStyle/css/script.js') }}"></script>
</body>

</html>
