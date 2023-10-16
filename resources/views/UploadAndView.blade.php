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
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous"
        referrerpolicy="no-referrer" />
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

    {{-- Content --}}
    <div class="container text-center">
        <div class="row  mt-5">
            <div class="col fw-bold">
                <h3 class="fw-bold">Upload Format Iklan</h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                <img src="" alt="#">
                <p>Catatan : <br>Gambar dan Jenis warna iklan harus sesuai!</p>
            </div>
            <div class="col text-start">
                <p>Upload Gambar Iklan</p>
                <form action="{{route('RegisterCall')}}" method="POST">
                    @csrf
                    @method('POST')
                    <label for="image" class="btn btn-primary px-5 rounded-3">
                        <input name="image" id="image" type="file" class="visually-hidden">
                        Pilih Gambar
                    </label>
                </form>

                <p class="mt-3">Jenis Warna Iklan</p>
                <input type="radio" class="btn-check" name="options" id="option1" value="fc" readonly>
                <label class="btn btn-primary" for="option1">Full Warna</label>
                <input type="radio" class="btn-check" name="options" id="option2" value="bw" readonly>
                <label class="btn btn-secondary" for="option2">Hitam Putih</label>
                    
                <p class="mt-3">Status</p>
                <div class="border border-black text-center p-3">
                    <p><label id="ukuran">Ukuran tidak sesuai</label> 
                        <br> upload ulang atau hubungi nomor dibawah :
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
                        <a href="{{ route('detailukuran') }}" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white">Sebelumnya</a>
                    </div>
                    <div class="text-start">
                        <a href="{{ route('invoice') }}" class="btn btn-primary rounded px-5 mb-3" style="background-color: #0094E7; color:white">Selanjutnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.5/dist/js.cookie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        document.getElementById('image').addEventListener('change', function() {
            var myCookieValue = "";
            console.log(Cookies.get('auth'));
            var photo = this.files[0];
            var packet_id = 1;
    
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
    
            fetch("127.0.0.1/websiteku/public/api/CheckImage", requestOptions)
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                // if(data.success) {
                //     var successMessage = document.getElementById('ukuran');
                //     successMessage.innerText = data.success;
                // } else if (data.error) {
                //     var errorMessage = document.getElementById('ukuran');
                //     errorMessage.innerText = data.error;
                // }
            })
            .catch(error => console.log('error', error));
        });
    </script>
</body>

</html>
