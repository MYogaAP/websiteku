<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Periklanan Radar Banjarmasin</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
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
    <style>
        header {
            background-image: url({{ asset('customerStyle/background-home.png') }});
        }

        body {
            font-family: 'Montserrat', sans-serif;
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
                $data = curl_exec($curl);
                $data = json_decode($data);
                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                curl_close($curl);
                
                if($http_status == 401){
                    setcookie("auth", "", time() - 3600, "/");
                    session()->flush();
                    header("Location: " . route('loginPage'), true, 302);
                    exit();
                }
            @endphp
            
            <!-- Page content-->
            <section class="py-5 mt-5">
                <div class="container px-5">
                    <!-- Contact form-->
                        <div class="text-center mb-5 mt-5">
                        </div>

                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                @if(isset($MessageSuccess))
                                    <div class="row align-items-center justify-content-center">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ $MessageSuccess }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div> 
                                @endif

                                @if(isset($MessageWarning))
                                    @foreach ($MessageWarning as $message)
                                        <div class="row align-items-center justify-content-center">
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{$message}}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        </div> 
                                    @endforeach
                                @endif

                                <!-- Name input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="username" type="text" name="username"
                                        placeholder="Enter your username..." data-sb-validations="required" 
                                        value="{{$data->username}}" disabled />
                                    <label for="username">Username</label>
                                    <div class="invalid-feedback" data-sb-feedback="name:required">Username is required.
                                    </div>
                                </div>
                                <!-- Email address input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="email" type="email" name="email"
                                        placeholder="name@example.com" data-sb-validations="required,email" 
                                        value="{{$data->email}}" disabled />
                                    <label for="email">Email address</label>
                                    <div class="invalid-feedback" data-sb-feedback="email:required">An email is
                                        required.</div>
                                    <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.
                                    </div>
                                </div>
                                <form action="{{route('UpdatePasswordCall')}}" method="post" id="UpdatePassword" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <!-- Old Password input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="old_password" name="old_password" type="password" placeholder=""
                                            data-sb-validations="required" />
                                        <label for="old_password">Password Lama</label>
                                        <div class="invalid-feedback" data-sb-feedback="old_password:required">password lama
                                            dibutuhkan.
                                        </div>
                                    </div>
                                    <!-- Password input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="password" name="password" type="password" placeholder=""
                                            data-sb-validations="required" />
                                        <label for="password">Password Baru</label>
                                        <div class="invalid-feedback" data-sb-feedback="password:required">password baru
                                            dibutuhkan.
                                        </div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <div class="d-grid"><button class="btn btn-primary btn" id="submitButton"
                                                type="submit">Ganti Password</button></div>
                                    </div>
                                </form>
                                <form action="{{route('UpdateProfileCall')}}" method="POST" autocomplete="off">
                                    @method('PATCH')
                                    @csrf
                                    <!-- Name input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="nama" type="text" name="nama"
                                            placeholder="cth. Abdul Hafiz" data-sb-validations="required" 
                                            value="{{$data->name}}"/>
                                        <label for="nama">Nama Lengkap</label>
                                        <div class="invalid-feedback" data-sb-feedback="phone:required">Nama anda dibutuhkan.
                                        </div>
                                    </div>
                                    <!-- Phone number input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="no_hp" type="tel" name="no_hp"
                                            placeholder="cth. 081515759080" value="{{$data->no_hp}}" onkeypress='validate(event)'/>
                                        <label for="no_hp">Nomor Handphone</label>
                                    </div>
                                    <!-- Phone number input-->
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="pekerjaan" name="pekerjaan"
                                        placeholder="Pekerjaan" value="{{$data->pekerjaan}}"/>
                                        <label for="pekerjaan">Pekerjaan</label>
                                    </div>
                                    <div class="d-none" id="submitSuccessMessage">
                                        <div class="text-center mb-3">
                                            <div class="fw-bolder">Form submission successful!</div>
                                            To activate this form, sign up at
                                            <br />
                                            <a
                                                href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                        </div>
                                    </div>
                                    <div class="d-none" id="submitErrorMessage">
                                        <div class="text-center text-danger mb-3">Error sending message!</div>
                                    </div>
                                    <!-- Submit Button-->
                                    <div class="form-floating mb-3">
                                        <div class="d-grid"><button class="btn btn-primary btn " id="submitButton"
                                                type="submit">Perbaharui Data</button></div>
                                    </div>
                                </form>
                                <form action="{{route('LogoutCall')}}" method='POST'>
                                    @method('DELETE')
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <div class="d-grid"><button class="btn btn-danger btn" id="submitButton"
                                                type="submit">Logout</button></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </main>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

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
    </script>

    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
