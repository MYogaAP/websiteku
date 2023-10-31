<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard - Radar Banjarmasin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('adminStyle/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('adminStyle/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('adminStyle/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">
    @if (!Cookie::has('auth'))
        <script>
            window.location = "{{ route('loginPage') }}";
        </script>
    @else
        @php
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => gethostname().'/websiteku/public/api/AgentList',
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
            $response = json_decode($response);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($http_status == 401) {
                setcookie('auth', '', time() - 3600, '/');
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }
        @endphp
    @endif

    <script>
        window.onload = function() {
            var sidebar = $('.sidebar');
            var content = $('.content');

            if (content.height() > sidebar.height() )
                sidebar.css('height', content.height());
            else
                sidebar.css('height', sidebar.height());
        }
    </script>

    <!-- Page Wrapper -->
    <div id="wrapper" class="content">
        <x-admin.sidebar class="sidebar"/>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid mt-4">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row no-gutters align-items-center">
                                <div class="col-10">
                                    <h4 class="m-0 font-weight-bold text-primary mb-2">Data Anggota Divisi Iklan</h4>
                                </div>
                                <div class="col-2 text-right">
                                    <a href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text" data-toggle="modal" data-target="#TambahModal">Tambah Agent</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary">Detail Anggota</th>
                                            <th class="text-secondary">Email</th>
                                            <th class="text-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response->data as $agent)
                                            <tr>
                                                <td>
                                                    <div class="d-flex flex-row">
                                                        <div class="p-2">
                                                            <p>Name</p>
                                                            <p>Username </p>
                                                            <p>No. HP</p>
                                                            <p>Pekerjaan</p> 
                                                        </div>
                                                        <div class="p-2">
                                                            <p>: {{ $agent->name }}</p>
                                                            <p>: {{ $agent->username }}</p>
                                                            <p>: {{ isset($agent->no_hp) ? $agent->ho_hp : "-" }}</p>
                                                            <p>: {{ isset($agent->pekerjaan) ? $agent->pekerjaan : "-" }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $agent->email }}</td>
                                                <td>
                                                    <form action="#" method="POST">
                                                        @method("DELETE")
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary " type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-minus"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal-->
    <div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Anggota Divisi Iklan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="user" autocomplete="off">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Name</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="cth. Abdul Hafiz">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Username</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="cth. user26">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Email</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1"
                                    placeholder="cth. user@radar.com">
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Password</label>
                                <input type="password" class="form-control" id="exampleFormControlInput1"
                                    placeholder="RadarPaham_123Banua">
                            </div>
                        </div>
                        <a href="login.html" class="btn btn-primary btn-user btn-block">
                            Tambah
                        </a>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Tidak
                    </button>
                    <a class="btn btn-primary" href="login.html">Ya</a>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('adminStyle/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminStyle/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('adminStyle/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('adminStyle/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('adminStyle/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminStyle/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('adminStyle/js/demo/datatables-demo.js') }}"></script>
</body>

</html>
