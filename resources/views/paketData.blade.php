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

    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>

</head>

<body id="page-top" class="content">
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
    <div id="wrapper">
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
                            <h5 class="m-0 font-weight-bold text-primary mb-2">
                                Paket Data
                            </h5>
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text" data-toggle="modal" data-target="#TambahModal">Tambah
                                            Paket</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary" colspan="2">Detail Paket</th>
                                            <th class="text-secondary">Contoh Foto</th>
                                            <th class="text-secondary">Status Visibilitas</th>
                                            <th class="text-secondary">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(session('packet_data'))
                                            @foreach (session('packet_data') as $list)
                                                <tr>
                                                    <td style="border-right-style: none;" class="text-start">
                                                        Nama Paket<br>
                                                        Ukuran Paket<br>
                                                        Format Warna Paket<br>
                                                        Harga Paket
                                                    </td>
                                                    <td style="border-left-style: none;" class="text-start">
                                                        : {{$list->nama_paket}}<br>
                                                        : {{$list->tinggi." x ".$list->kolom}} mmk<br>
                                                        : {{$list->format_warna == "fc"? "Full Color" : "Black White"}}<br>
                                                        : Rp. @money($list->harga_paket)
                                                    </td>
                                                    <td class="text-center" style="max-height: 21rem; width: 17rem; overflow: hidden">
                                                        <a href="{{ asset('storage/image_example/'.$list->contoh_foto) }}" target="_blank">
                                                        <img src="{{ asset('storage/image_example/'.$list->contoh_foto) }}" class="card-img-top" alt="" style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                                        </a>
                                                    </td>
                                                    <td class="{{$list->hidden == 'yes' ? 'text-secondary h5 text-center' : 'text-primary h5 text-center'}}">
                                                        {{$list->hidden == "yes" ? "HIDDEN" : "VISIBLE"}}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown mb-4 text-center">
                                                            <button class="btn btn-primary " type="button"
                                                                id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-pen-nib"></i>
                                                            </button>
                                                            <div class="dropdown-menu animated--fade-in"
                                                                aria-labelledby="dropdownMenuButton">
                                                                <form action="#" method="post">
                                                                    @method("PATCH")
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item" formaction="{{route('SembunyikanPaket', ['packet' => $list->packet_id])}}">
                                                                        Hide Packet</button>
                                                                    <button type="submit" class="dropdown-item" formaction="{{route('TampilkanPaket', ['packet' => $list->packet_id])}}">
                                                                        Unhide Packet</button>
                                                                </form>
                                                                <form action="{{route('HapusPaket', ['packet' => $list->packet_id])}}" method="post">
                                                                    @method("DELETE")
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item">
                                                                        Delete Packet</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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

    <!-- Tambah Paket -->
    <div class="modal fade" id="TambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Paket</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('TambahPaket')}}" class="user" method="POST" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="contoh_foto_paket" class="form-label">Pastikan data yang ditambahakan sesuai</label>
                                <input class="form-control" type="file" id="contoh_foto_paket" name="contoh_foto_paket">
                            </div>
                            <div class="mb-3">
                                <label for="nama_paket" class="form-label">Nama Paket</label>
                                <input type="text" class="form-control" id="nama_paket" name="nama_paket"
                                    placeholder="cth. Paket1">
                            </div>
                            <div class="mb-3">
                                <label for="tinggi_paket" class="form-label">Tinggi</label>
                                <input type="number" class="form-control" id="tinggi_paket" name="tinggi_paket"
                                    placeholder="50" min="1" max="530">
                            </div>
                            <div class="mb-3">
                                <label for="kolom_paket" class="form-label">Kolom</label>
                                <input type="number" class="form-control" id="kolom_paket" name="kolom_paket"
                                    placeholder="1" min="1" max="6">
                            </div>
                            <div class="mb-3">
                                <label for="format_warna_paket" class="form-label">Format Warna</label>
                                <select class="form-control" id="format_warna_paket" name="format_warna_paket">
                                    <option value="fc">Full Color</option>
                                    <option value="bw">Black White</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="harga_paket" class="form-label">Harga Paket</label>
                                <input type="number" class="form-control" id="harga_paket" name="harga_paket"
                                    placeholder="100000">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Tambah
                        </button>
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
