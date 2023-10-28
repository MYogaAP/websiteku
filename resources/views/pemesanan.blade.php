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
    </style>
</head>

<body>
    {{-- Navigation Bar --}}
    <x-nav-bar-back />

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
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $data_user = curl_exec($curl);
            $data_user = json_decode($data_user);
            
            if($http_status == 401){
                setcookie("auth", "", time() - 3600, "/");
                header("Location: " . route('loginPage'), true, 302);
                exit();
            }
        @endphp
    @endif

    @if (session("form_data"))
        @php
            $form_data = session("form_data");
            $nama = $form_data['nama_instansi'];
            $mulai = $form_data['mulai_iklan'];
            $akhir = $form_data['akhir_iklan'];
            $desk = $form_data['deskripsi_iklan'];
            $email = $form_data['email_instansi'];
            $telp = $form_data['telpon_instansi'];
        @endphp
    @endif

    {{-- Content --}}
    <div class="container text-center mt-5">
        <div class="row fw-bold">
            <div class="col">
                <h3 class="fw-bold">Pemesanan Iklan</h3> 
            </div>
        </div>
        
        <form action="{{ route('SimpanPesanan') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row justify-content-center mt-5">
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" id="nama_instansi" name="nama_instansi" class="form-control rounded-pill" placeholder="Nama Instansi" 
                        value=@if(isset($nama))
                            {{ $nama }}
                        @endif>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <label class="ps-2 text-secondary">Tanggal Mulai</label>
                        <div class="text-start mx-3">
                            <input type="date" class="form-control" id="mulai_iklan" name="mulai_iklan" required
                            value=@if(isset($mulai))
                            {{ $mulai }}
                            @endif>
                        </div>
                        <label class="text-secondary">Tanggal Berakhir</label>
                        <div class="text-end mx-3">
                            <input type="date" class="form-control" id="akhir_iklan" name="akhir_iklan" required 
                            value=@if(isset($akhir))
                            {{ $akhir }}
                            @endif>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" id="deskripsi_iklan" name="deskripsi_iklan" class="form-control rounded-pill" placeholder="Deskripsi Keperluan Iklan (jika perlu)"
                        value=@if(isset($desk))
                        {{ $desk }}
                        @endif>
                    </div>
                    <div class="mb-3">
                        <input type="email" id="email_instansi" name="email_instansi" class="form-control rounded-pill" placeholder="Email Yang Dapat Dihubungi" required
                        value=@if(isset($email))
                        {{ $email }}
                        @elseif (isset($data_user->email))
                        {{ $data_user->email }}
                        @endif>
                    </div>
                    <div class="mb-3">
                        <input type="tel" id="telpon_instansi" name="telpon_instansi" class="form-control rounded-pill" placeholder="Nomor Telpon Yang Dapat Dihubungi" required
                        value=@if(isset($telp))
                        {{ $telp }}
                        @elseif (isset($data_user->no_hp))
                        {{ $data_user->no_hp }}
                        @endif>
                    </div>
                    <div>
                        <div class="text-end">
                            <input type="submit" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white" value="Selanjutnya">
                        </div>
                    </div>
                </div>
            </div>
        </form>       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // No Sunday
            const mulai = document.getElementById('mulai_iklan');
            const akhir = document.getElementById('akhir_iklan');
            mulai.addEventListener('input', function(e){
                var day = new Date(this.value).getUTCDay();
                if([0].includes(day)){
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
            akhir.addEventListener('input', function(e){
                var day = new Date(this.value).getUTCDay();
                if([0].includes(day)){
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
