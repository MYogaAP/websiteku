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

        /* Mengubah warna latar belakang date picker */
        .form-control[type="date"]::-webkit-calendar-picker-indicator {
            background-color: none;
            color: #fff;
            border: none;
            border-radius: 50%;
            padding: 4px;
        }

        /* Mengubah warna teks pada date picker */
        .form-control[type="date"]::-webkit-datetime-edit {
            color: #7f7986;
        }

        /* Mengatur border date picker */
        .form-control[type="date"]::-webkit-inner-spin-button {
            display: none;
        }

        .form-control[type="date"]::-webkit-clear-button {
            display: none;
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
    </style>
</head>

<body>
    {{-- Navigation Bar --}}
    <x-nav-bar-back />

    @if (!Cookie::has('auth'))
        <script>
            window.location = "{{ route('loginPage') }}";
        </script>
    @else
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
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $data_user = curl_exec($curl);
            $data_user = json_decode($data_user);

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
        @endphp
    @endif

    @if (session('form_data'))
        @php
            $form_data = session('form_data');
            $nama = $form_data['nama_instansi'];
            $mulai = $form_data['mulai_iklan'];
            $akhir = $form_data['akhir_iklan'];
            $desk = $form_data['deskripsi_iklan'];
            $email = $form_data['email_instansi'];
            $telp = $form_data['telpon_instansi'];
            $almt = $form_data['alamat_instansi'];
        @endphp
    @endif

    {{-- Content --}}
    {{-- <div class="container text-center mt-5">
        <div class="row fw-bold">
            <div class="col mt-5">
                <h3 class="fw-bold">Pemesanan Iklan</h3>
            </div>
        </div>

        <form action="{{ route('SimpanPesanan') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row justify-content-center mt-5">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" id="nama_instansi" name="nama_instansi" class="form-control"
                            placeholder="Nama Instansi"
                            value=@if (isset($nama)) {{ $nama }} @endif>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <label class="ps-2 text-secondary">Tanggal Mulai</label>
                        <div class="text-start mx-3">
                            <input type="date" class="form-control" id="mulai_iklan" name="mulai_iklan" required
                                value=@if (isset($mulai)) {{ $mulai }} @endif>
                        </div>
                        <label class="text-secondary">Tanggal Berakhir</label>
                        <div class="text-end mx-3">
                            <input type="date" class="form-control" id="akhir_iklan" name="akhir_iklan" required
                                value=@if (isset($akhir)) {{ $akhir }} @endif>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" id="email_instansi" name="email_instansi" class="form-control"
                            placeholder="Email Yang Dapat Dihubungi" required
                            value=@if (isset($email)) {{ $email }}
                        @elseif (isset($data_user->email))
                        {{ $data_user->email }} @endif>
                    </div>
                    <div class="mb-3">
                        <input type="tel" id="telpon_instansi" name="telpon_instansi" class="form-control"
                            placeholder="Nomor Telpon Yang Dapat Dihubungi" required
                            value=@if (isset($telp)) {{ $telp }}
                        @elseif (isset($data_user->no_hp))
                        {{ $data_user->no_hp }} @endif>
                    </div>
                    <div class="mb-3">
                        <textarea type="text" id="alamat_instansi" name="alamat_instansi" class="form-control" placeholder="Alamat Instansi"
                            required value=@if (isset($almt)) {{ $almt }} @endif></textarea>
                    </div>
                    <div class="mb-3">
                        <textarea id="deskripsi_iklan" name="deskripsi_iklan" class="form-control"
                            placeholder="Deskripsi Keperluan Iklan (jika perlu)"
                            value=@if (isset($desk)) {{ $desk }} @endif></textarea>
                    </div>
                    <div>
                        <div class="text-end">
                            <input type="submit" class="btn btn-primary rounded px-5 mb-3"
                                style="background-color: #0094E7; color:white" value="Selanjutnya">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}
    <main class="flex-shrink-0 mt-5">
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Contact form-->
                <div class="bg-secondary-subtle rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h1 class="fw-bolder">Pemesanan Iklan</h1>
                        <p class="lead fw-normal text-muted mb-0">
                            Isi formulir dengan detail keperluan iklan anda
                        </p>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <form id="contactForm" action="{{ route('SimpanPesanan') }}" method="POST"
                                autocomplete="off">
                                @csrf
                                <!-- Name input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="nama_instansi" name="nama_instansi" type="text"
                                        placeholder="Nama Instansi"
                                        value="@if(isset($nama)){{$nama}}@endif">
                                    <label for="nama_instansi"><span class="text-danger inline">*</span>Nama Instansi</label>
                                </div>
                                {{-- Date --}}
                                <div class="form-floating mb-3 d-flex">
                                    <input type="date" class="form-control" id="mulai_iklan" name="mulai_iklan"
                                        required value=@if (isset($mulai)) {{ $mulai }} @endif>
                                    <label for="mulai_iklan"><span class="text-danger inline">*</span>Tanggal 
                                        Mulai Tayang</label>
                                </div>
                                <div class="form-floating mb-3 d-flex">
                                    <input type="date" class="form-control" id="akhir_iklan" name="akhir_iklan"
                                        required value=@if (isset($akhir)) {{ $akhir }} @endif>
                                    <label for="akhir_iklan"><span class="text-danger inline">*</span>Tanggal
                                        Berakhir Tayang</label>
                                </div>
                                <!-- Email address input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" name="email_instansi" id="email_instansi" type="email"
                                        placeholder="Email Yang Dapat Dihubungi" required
                                        value=@if (isset($email)) {{ $email }}
                                    @elseif (isset($data_user->email))
                                    {{ $data_user->email }} @endif>
                                    <label for="email_instansi"><span class="text-danger inline">*</span>Email address</label>
                                </div>
                                <!-- Phone number input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="telpon_instansi" name="telpon_instansi"
                                        type="tel" placeholder="Nomor Telpon Yang Dapat Dihubungi"
                                        data-sb-validations="required" required onkeypress='validate(event)' 
                                        value=@if(isset($telp)){{$telp}}
                                    @elseif(isset($data_user->no_hp))
                                    {{$data_user->no_hp}} @endif>
                                    <label for="telpon_instansi"><span class="text-danger inline">*</span>Phone number</label>
                                </div>
                                <!-- Alamat input-->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="alamat_instansi" id="alamat_instansi" type="text" placeholder="Alamat Instansi"
                                        style="height: 10rem" required>@if (isset($almt)) {{$almt}} @endif</textarea>
                                    <label for="alamat_instansi"><span class="text-danger inline">*</span>Alamat
                                        Instansi</label>
                                </div>
                                <!-- Deskripsi input-->
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" name="deskripsi_iklan" id="deskripsi_iklan" type="text"
                                        placeholder="Deskripsi Keperluan Iklan (jika perlu)" style="height: 10rem" data-sb-validations="required">@if (isset($desk)) {{$desk}} @endif</textarea>
                                    <label for="deskripsi_iklan">
                                        Deskripsi Keperluan Iklan
                                    </label>
                                </div>
                                <!-- Submit success message-->
                                <div class="d-none" id="submitSuccessMessage">
                                    <div class="text-center mb-3">
                                        <div class="fw-bolder">Form submission successful!</div>
                                        To activate this form, sign up at
                                        <br />
                                        <a
                                            href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                    </div>
                                </div>
                                <!-- Submit error message-->
                                <div class="d-none" id="submitErrorMessage">
                                    <div class="text-center text-danger mb-3">
                                        Error sending message!
                                    </div>
                                </div>
                                <!-- Submit Button-->
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function validate(evt) {
                var theEvent = evt || window.event;

                // Handle paste
                if (theEvent.type === 'paste') {
                    key = event.clipboardData.getData('text/plain');
                } else {
                // Handle key press
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                }
                var regex = /[0-9]/;
                if( !regex.test(key) ) {
                    theEvent.returnValue = false;
                    if(theEvent.preventDefault) theEvent.preventDefault();
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                // No Sunday
                const mulai = document.getElementById('mulai_iklan');
                const akhir = document.getElementById('akhir_iklan');
                mulai.addEventListener('input', function(e) {
                    var day = new Date(this.value).getUTCDay();
                    if ([0].includes(day)) {
                        e.preventDefault();
                        this.value = '';

                        // SWEET ALERT
                        let timerInterval
                        Swal.fire({
                            title: 'Awas!',
                            html: 'Anda tidak dapat memilih hari minggu.',
                            timer: 5000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            },
                            showCloseButton: true
                        })
                    }
                });
                akhir.addEventListener('input', function(e) {
                    var day = new Date(this.value).getUTCDay();
                    if ([0].includes(day)) {
                        e.preventDefault();
                        this.value = '';

                        // SWEET ALERT
                        let timerInterval
                        Swal.fire({
                            title: 'Awas!',
                            html: 'Anda tidak dapat memilih hari minggu.',
                            timer: 5000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            },
                            showCloseButton: true
                        })
                    }
                });

                // Minimal Date
                const now = new Date();
                const hours = now.getHours();
                if (hours >= 17) {
                    now.setDate(now.getDate() + 1);
                    now.setDate(now.getDate() + 1);
                    const theDayAfter = now.toISOString().substr(0, 10);

                    mulai.setAttribute("min", theDayAfter);
                    akhir.setAttribute("min", theDayAfter);
                } else {
                    now.setDate(now.getDate() + 1);
                    const tomorrow = now.toISOString().substr(0, 10);

                    mulai.setAttribute("min", tomorrow);
                    akhir.setAttribute("min", tomorrow);
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
</body>

</html>
