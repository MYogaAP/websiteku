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
    
    @if (!Cookie::has('auth'))
        <script>
            window.location = "{{ route('loginPage') }}";
        </script>
    @else
        @php
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => gethostname().'/websiteku/public/api/AgentAllDetailedOrders',
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
            $xendit_link = "https://checkout.xendit.co/v2/";

            if ($http_status == 401) {
                setcookie('auth', '', time() - 3600, '/');
                header('Location: ' . URL::to('/login'), true, 302);
                exit();
            }
        @endphp
    @endif

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
                            <h4 class="m-0 font-weight-bold text-primary mb-2">
                                Order Data
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary">Detail Nomor</th>
                                            <th class="text-secondary">Detail Iklan</th>
                                            <th class="text-secondary">Foto Iklan</th>
                                            <th class="text-secondary">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($response->data as $order)
                                            <tr>
                                                <td>
                                                    <div class="container p-2">
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>No. Order</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: ---</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>No. Invoice</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: ---</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Invoice</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: <a href="{{ $xendit_link.$order->invoice_id }}" target="_blank">{{ $order->invoice_id }}</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="container p-2">
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Nama Instansi</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->nama_instansi}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Ukuran Iklan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->tinggi}} x {{$order->kolom}} mmk</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Tanggal Penerbitan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->mulai_iklan}} hingga {{$order->akhir_iklan}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Lama Terbit</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->lama_hari}} Hari</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Status Pembayaran</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->status_pembayaran}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Status Iklan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->status_iklan}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Harga Paket</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: Rp. @money($order->harga_paket) / Hari</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Harga Total</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: Rp. @money($order->harga_paket * $order->lama_hari)</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Status Iklan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p class="@if ($order->status_iklan == 'Dibatalkan')
                                                                    {{'text-danger'}}
                                                                @elseif($order->status_iklan == 'Lunas')
                                                                    {{'text-success'}}
                                                                @elseif ($order->status_iklan == 'Belum Lunas')
                                                                    {{'text-secondary'}}
                                                                @else
                                                                    {{'text-primary'}}
                                                                @endif">
                                                                    : {{$order->status_iklan}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Status Pembayaran</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p class="@if ($order->status_pembayaran == 'Dibatalkan')
                                                                    {{'text-danger'}}
                                                                @elseif($order->status_pembayaran == 'Telah Diupload')
                                                                    {{'text-success'}}
                                                                @elseif ($order->status_pembayaran == 'Menunggu Pembayaran')
                                                                    {{'text-secondary'}}
                                                                @else
                                                                    {{'text-primary'}}
                                                                @endif">
                                                                    : {{$order->status_pembayaran}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Deskripsi Iklan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{$order->deskripsi_iklan}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="container" style="max-height: 18.5rem; width: 15rem; overflow: hidden"> 
                                                        @if($order->foto_iklan == "none")
                                                            <a href="{{ asset('images/logo.jpeg') }}" target="_blank">
                                                                <img src="{{ asset('images/logo.jpeg') }}" class="card-img-top" alt="" style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/image/'.$order->foto_iklan) }}" target="_blank">
                                                                <img src="{{ asset('storage/image/'.$order->foto_iklan) }}" class="card-img-top" alt="" style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                                            </a>
                                                        @endif
                                                    </div>
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
                                                            <form action="#" method="POST">
                                                                @method("PATCH")
                                                                @csrf
                                                                <button type="submit" class="dropdown-item" formaction="">
                                                                    Menunggu Konfirmasi</button>
                                                                <button type="submit" class="dropdown-item" formaction="">
                                                                    Dalam Antrian</button>
                                                                <button type="submit" class="dropdown-item" formaction="">
                                                                    Sedang Diproses</button>
                                                                <button type="submit" class="dropdown-item" formaction="">
                                                                    Telah Diupload</button>
                                                                <button type="submit" class="dropdown-item" formaction="">
                                                                    Dibatalkan</button>
                                                            </form>
                                                        </div>
                                                    </div>
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

        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
