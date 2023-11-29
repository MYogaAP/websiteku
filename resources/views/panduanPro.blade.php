<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Periklanan Radar Banjarmasin</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('public/favicon.ico')}}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link type="text/css" href="{{ asset('public/customerStyle/css/styles.css') }}" rel="stylesheet" />

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
    </style>
</head>

<body class="d-flex flex-column">
    <main class="flex-shrink-0">
        <x-nav-bar-back />
        <!-- Header-->
        <header class="py-5">
            <div class="container px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xxl-6">
                        <div class="text-center my-5">
                            <h1 class="fw-bolder mb-3">Panduan Pemesanan Iklan
                            </h1>
                            <p class="lead fw-normal text-muted mb-4">Nikmati kenyamanan 
                                dalam proses pemesanan di Radar Banjarmasin yang disederhanakan 
                                melalui empat langkah mudah. Kami berkomitmen untuk memberikan layanan 
                                terbaik bagi Anda!</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- About section one-->
        <section class="py-5 bg-light" id="scroll-target">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0"
                            src="{{ asset('public/images/DaftarAkun.gif') }}" alt="..." /></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">1. Membuat Akun</h2>
                        <p class="lead fw-normal text-muted mb-0">Buatlah akun pribadi terlebih dahulu di platform kami.
                            Dengan langkah-langkah sederhana, dapatkan akses penuh ke layanan kami dan mulailah
                            mendefinisikan keberadaan online Anda.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- About section two-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-first order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0"
                            src="{{ asset('public/images/Pesan1.gif') }}" alt="..." /></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">2. Pesan Jasa</h2>
                        <p class="lead fw-normal text-muted mb-0">Pesan jasa iklan sekarang. Isi formulir dengan
                            detail keperluan iklan anda, dan biarkan kami membantu mewujudkan visi pemasaranmu.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- About section Three-->
        <section class="py-5 bg-light" id="scroll-target">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0"
                            src="{{ asset('public/images/Pesan2.gif') }}" alt="..." /></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">3. Pilih Paket</h2>
                        <p class="lead fw-normal text-muted mb-0">Pilihlah paket iklan yang cocok dengan kebutuhan
                            spesifik iklan Anda. Dengan berbagai opsi paket yang tersedia, kami memastikan Anda
                            mendapatkan solusi yang sesuai untuk menyampaikan iklan Anda secara optimal.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- About section Four-->
        <section class="py-5">
            <div class="container px-5 my-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6 order-first order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0"
                            src="{{ asset('public/images/BayarPesanan.gif') }}" alt="..." /></div>
                    <div class="col-lg-6">
                        <h2 class="fw-bolder">4. Bayar Pesanan</h2>
                        <p class="lead fw-normal text-muted mb-0">Lakukan pembayaran untuk pesanan Anda dengan mudah dan
                            aman. Pilih metode pembayaran yang nyaman bagi Anda, sehingga dapat diproses dan
                            iklan Anda bisa segera tampil di koran Radar Banjarmasin</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team members section-->
        <section class="py-5 bg-light">
            <div class="container px-5 my-5">
                <div class="text-center">
                    <h3 class="fw-bolder">Customer Service</h3>
                    <p class="lead fw-normal text-muted mb-5">Tidak menemukan paket yang sesuai? kontak customer service kami!</p>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <a href="">
                                <img class="img-fluid rounded-circle mb-4 px-4"
                                    src="{{ asset('public/images/cs.png') }}" alt="..." />
                            </a>
                            <br>
                            <a class="btn btn-lg px-1" style="font-size: 15px; background-color:limegreen; color:white" href="{{config('contactperson.contact')}}" target="_blank">Hubungi Via Whatsapp</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
    <script src="js/scripts.js"></script>
</body>

</html>
