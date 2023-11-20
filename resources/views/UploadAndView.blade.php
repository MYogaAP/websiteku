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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            $response = curl_exec($curl);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
                setcookie('auth', '', time() - 3600, '/');
                session()->flush();
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }

            $packet = session('packet_data');
            $auth = Cookie::get('auth');
            if (!isset($packet)) {
                header('Location: ' . route('landingPageLogin'), true, 302);
                exit();
            }
        @endphp
    @endif

    {{-- Content --}}
    <div class="container text-center" style="margin-top: 100px;">
        <form action="{{ route('NewOrderCall') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row  mt-5">
                <div class="col fw-bold">
                    <h3 class="fw-bold">Upload Format Iklan</h3>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <a href="{{ asset('storage/image_example/' . $packet['contoh_foto']) }}" target="_blank"
                        style="width: 100%; height: 100%;">
                        <div class="container" style="width: 17rem; height: 21rem; overflow: hidden">
                            <img src="{{ asset('storage/image_example/' . $packet['contoh_foto']) }}"
                                class="card-img-top" alt="..."
                                style="border: 1px solid black; object-fit: contain; width: 100%; height: 100%">
                        </div>
                    </a>

                    <p>Catatan : <br>Ukuran gambar iklan harus sesuai!</p>
                </div>
                <div class="col text-start">
                    <p>Upload Gambar Iklan</p>

                    <label for="image" class="btn btn-primary px-5 rounded-3">
                        <input name="image" id="image" type="file" class="visually-hidden" required>
                        Pilih Gambar
                    </label>

                    <p class="mt-3">Jenis Warna Iklan</p>
                    @if ($packet['format_warna'] == 'fc')
                        <input type="radio" class="btn-check" name="options" id="option1" value="fc" checked>
                        <label class="btn btn-outline-primary" for="option1">Full Warna</label>
                        <input type="radio" class="btn-check" name="options" id="option2" value="bw" disabled>
                        <label class="btn btn-outline-primary" for="option2">Hitam Putih</label>
                    @else
                        <input type="radio" class="btn-check" name="options" id="option1" value="fc" disabled>
                        <label class="btn btn-outline-primary" for="option1">Full Warna</label>
                        <input type="radio" class="btn-check" name="options" id="option2" value="bw" checked>
                        <label class="btn btn-outline-primary" for="option2">Hitam Putih</label>
                    @endif

                    <p id="status" class="mt-3" style="visibility: hidden">Status</p>
                    <div id="status-border" class="border border-black text-center p-3 alert alert-warning"
                        style="visibility: hidden">
                        <p><label id="ukuran">Ukuran yang diupload tidak sesuai. Ukuran yang disarankan adalah ####px
                                dan ####px.</label>
                            <br><label id="contact-text">Mohon upload ulang atau hubungi nomor dibawah :</label>
                        </p>
                        <button type="button" class="btn btn-success btn-sm rounded-3">Contact Support <i
                                class="fa-solid fa-phone mx-2"></i></button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-5" style="margin-top: -15px">
                    <div class="d-flex justify-content-between mt-5">
                        <div class="text-end">
                            <a href="{{ route('detailukuran') }}" class="btn btn-primary rounded px-5 mb-3"
                                style="background-color: #0094E7; color:white">Sebelumnya</a>
                        </div>
                        <div class="text-start">
                            <input type="submit" id="submit-btn" value="Kirim Pesanan"
                                class="btn btn-primary rounded px-5 mb-3"
                                style="background-color: #0094E7; color:white" disabled>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="form-floating mb-3">
                        <div class="d-grid">
                            <a href="{{ route('detailukuran') }}" class="btn btn-primary btn">
                                Sebelumnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-6">
                    <div class="form-floating mb-3">
                        <div class="d-grid">
                            <input type="submit" id="submit-btn" class="btn btn-primary btn" value="Kirim Pesanan">
                        </div>
                    </div>
                </div>
            </div> --}}
        </form>
    </div>

    <p id="2BW0TmvQmi3yMQqjfWTpZcDkmQ2HdymY" class="invisible visually-hidden">{{ $auth }}</p>
    <p id="clAXLgmxnapTRttSvxaJspEXKgGUESrS" class="invisible visually-hidden">{{ $packet['packet_id'] }}</p>

    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('image').addEventListener('change', function() {
            var myCookieValue = document.getElementById("2BW0TmvQmi3yMQqjfWTpZcDkmQ2HdymY").textContent;
            var photo = this.files[0];
            var packet_id = document.getElementById("clAXLgmxnapTRttSvxaJspEXKgGUESrS").textContent;
            const APIURL = window.location.protocol + "//" + window.location.hostname +
                "/websiteku/public/api/CheckImage";
            const RESULT = document.getElementById('ukuran');
            const CONTACT = document.getElementById('contact-text');

            var subBtn = document.getElementById('submit-btn');
            var statusText = document.getElementById('status');
            var statusBorder = document.getElementById('status-border');
            subBtn.disabled = true;
            statusText.style.visibility = "hidden";
            statusBorder.style.visibility = "hidden";

            var myHeaders = new Headers();
            myHeaders.append("Accept", "application/json");
            myHeaders.append("Authorization", "Bearer " + myCookieValue);

            var formdata = new FormData();
            formdata.append("image", photo);
            formdata.append("packet_id", packet_id);

            var requestOptions = {
                method: 'POST',
                headers: myHeaders,
                body: formdata,
                redirect: 'follow'
            }

            fetch(APIURL, requestOptions)
                .then(response => response.json())
                .then(data => {
                    if (data.berhasil) {
                        RESULT.textContent = data.message;
                        CONTACT.textContent = "Jika ada masalah lain, hubungi nomor dibawah :"
                        subBtn.disabled = false;
                        statusText.style.visibility = "visible";
                        statusBorder.style.visibility = "visible";
                        statusBorder.classList.add("alert-success");
                        statusBorder.classList.remove("alert-warning");
                    } else {
                        RESULT.textContent = data.message;
                        CONTACT.textContent = "Mohon upload ulang atau hubungi nomor dibawah :"
                        subBtn.disabled = true;
                        statusText.style.visibility = "visible";
                        statusBorder.style.visibility = "visible";
                        statusBorder.classList.add("alert-warning");
                        statusBorder.classList.remove("alert-success");
                    }
                })
                .catch(error => console.error(error));
        });
    </script>
</body>

</html>
