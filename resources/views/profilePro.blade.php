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
        <x-nav-bar-login />
        <!-- Page content-->
        <section class="py-5">
            <div class="container px-5">
                <!-- Contact form-->
                <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                    <div class="text-center mb-5">
                        <h1 class="fw-bolder">Profil Akun</h1>
                    </div>
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-8 col-xl-6">
                            <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                                <!-- Name input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="name" type="text"
                                        placeholder="Enter your name..." data-sb-validations="required" disabled />
                                    <label for="name">Full name</label>
                                    <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.
                                    </div>
                                </div>
                                <!-- Email address input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="email" type="email"
                                        placeholder="name@example.com" data-sb-validations="required,email" disabled />
                                    <label for="email">Email address</label>
                                    <div class="invalid-feedback" data-sb-feedback="email:required">An email is
                                        required.</div>
                                    <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.
                                    </div>
                                </div>
                                <!-- Password input-->
                                <div class="form-floating mb-3">
                                    <div class="">
                                        <div>
                                            <input class="form-control" id="password" type="password" placeholder=""
                                                data-sb-validations="required" />
                                            <label for="password">Password</label>
                                        </div>
                                        <div>
                                            <div class=""><button class="btn btn-primary btn-lg disabled"
                                                    id="submitButton" type="submit">Submit</button></div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback" data-sb-feedback="password:required">password
                                        dibutuhkan.
                                    </div>
                                </div>
                                <!-- Username input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="phone" type="password"
                                        placeholder="(123) 456-7890" data-sb-validations="required" />
                                    <label for="phone">User</label>
                                    <div class="invalid-feedback" data-sb-feedback="phone:required">Username dibutuhkan.
                                    </div>
                                </div>
                                <!-- Phone number input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="phone" type="tel"
                                        placeholder="(123) 456-7890" />
                                    <label for="phone">Nomor Handphone</label>
                                </div>
                                <!-- Phone number input-->
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="phone" type="tel"
                                        placeholder="(123) 456-7890" data-sb-validations="required" />
                                    <label for="phone">Pekerjaan</label>
                                    <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is
                                        required.</div>
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
                                <div class="d-grid"><button class="btn btn-primary btn-lg disabled" id="submitButton"
                                        type="submit">Submit</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Contact cards-->
                {{-- <div class="row gx-5 row-cols-2 row-cols-lg-4 py-5">
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-chat-dots"></i></div>
                        <div class="h5 mb-2">Chat with us</div>
                        <p class="text-muted mb-0">Chat live with one of our support specialists.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-people"></i></div>
                        <div class="h5">Ask the community</div>
                        <p class="text-muted mb-0">Explore our community forums and communicate with other users.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-question-circle"></i></div>
                        <div class="h5">Support center</div>
                        <p class="text-muted mb-0">Browse FAQ's and support articles to find solutions.</p>
                    </div>
                    <div class="col">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i
                                class="bi bi-telephone"></i></div>
                        <div class="h5">Call us</div>
                        <p class="text-muted mb-0">Call us during normal business hours at (555) 892-9403.</p>
                    </div>
                </div> --}}
            </div>
        </section>
    </main>
    <!-- Footer-->
    {{-- <footer class="bg-dark py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0 text-white">Copyright &copy; Your Website 2023</div>
                </div>
                <div class="col-auto">
                    <a class="link-light small" href="#!">Privacy</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Terms</a>
                    <span class="text-white mx-1">&middot;</span>
                    <a class="link-light small" href="#!">Contact</a>
                </div>
            </div>
        </div>
    </footer> --}}
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>