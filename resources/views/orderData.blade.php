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

            if (content.height() > sidebar.height())
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
            $filter = request('filter');
            if (isset($filter)) {
                if ($filter == 'Semua Pesanan') {
                    $GetData = 'AgentAllDetailedOrders';
                } elseif ($filter == 'Sudah Konfirmasi') {
                    $GetData = 'AgentResponsibility';
                } else {
                    $GetData = 'NeedConfirmation';
                }
            } else {
                $GetData = 'NeedConfirmation';
                $filter = 'Perlu Konfirmasi';
            }

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => gethostname() . '/websiteku/public/api/' . $GetData,
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
            $xendit_link = 'https://checkout.xendit.co/v2/';

            if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
                setcookie('auth', '', time() - 3600, '/');
                session()->flush();
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }
        @endphp
    @endif

    <!-- Page Wrapper -->
    <div id="wrapper">
        <x-admin.sidebar class="sidebar" />
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
                                <div class="col-3">
                                    <h4 class="m-0 font-weight-bold text-primary mb-2">Order Data</h4>
                                </div>
                                <div class="col-5 text-center">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    @if (session()->has('danger'))
                                        <div class="alert alert-danger alert-dismissable">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            {{ session()->get('danger') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-2 text-right">
                                    <div class="mb-1">Download Excel</div>
                                    <div class="dropdown mb-4">
                                        <a href="#" class="btn btn-primary btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-download"></i>
                                            </span>
                                            <span class="text" data-toggle="modal"
                                                data-target="#DownloadExcel">Unduh</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-2 text-right">
                                    <div class="mb-1">Data Yang Ditampilkan:</div>
                                    <div class="dropdown mb-4">
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            @if (isset($filter))
                                                {{ $filter }}
                                            @else
                                                {{ 'Perlu Konfirmasi' }}
                                            @endif
                                        </button>
                                        <div class="dropdown-menu animated--fade-in"
                                            aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="{{ route('orderDataFilter', ['filter' => 'Perlu Konfirmasi']) }}">Perlu
                                                Konfirmasi</a>
                                            <a class="dropdown-item"
                                                href="{{ route('orderDataFilter', ['filter' => 'Sudah Konfirmasi']) }}">Sudah
                                                Konfirmasi</a>
                                            <a class="dropdown-item"
                                                href="{{ route('orderDataFilter', ['filter' => 'Semua Pesanan']) }}">Semua
                                                Pesanan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            @if ($order->status_pembayaran == 'Belum Lunas')
                                                @php
                                                    $curl = curl_init();
                                                    curl_setopt_array($curl, [
                                                        CURLOPT_URL => 'https://api.xendit.co/v2/invoices/' . $order->invoice_id,
                                                        CURLOPT_RETURNTRANSFER => true,
                                                        CURLOPT_ENCODING => '',
                                                        CURLOPT_MAXREDIRS => 10,
                                                        CURLOPT_TIMEOUT => 0,
                                                        CURLOPT_FOLLOWLOCATION => true,
                                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                                        CURLOPT_HTTPHEADER => ['Authorization: Basic ' . config('xendit.key')],
                                                    ]);
                                                    $invoice_data = curl_exec($curl);
                                                    $invoice_data = json_decode($invoice_data);
                                                    curl_close($curl);

                                                    if (isset($invoice_data->status)) {
                                                        if ($invoice_data->status == 'PAID' || $invoice_data->status == 'SETTLED') {
                                                            $curl = curl_init();
                                                            curl_setopt_array($curl, [
                                                                CURLOPT_URL => gethostname() . '/websiteku/public/api/UpdatePayedOrder/' . $order->order_id,
                                                                CURLOPT_RETURNTRANSFER => true,
                                                                CURLOPT_ENCODING => '',
                                                                CURLOPT_MAXREDIRS => 10,
                                                                CURLOPT_TIMEOUT => 0,
                                                                CURLOPT_FOLLOWLOCATION => true,
                                                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                                CURLOPT_CUSTOMREQUEST => 'PATCH',
                                                                CURLOPT_HTTPHEADER => ['Accept: application/json', 'Authorization: Bearer ' . Cookie::get('auth')],
                                                            ]);
                                                            $update = curl_exec($curl);
                                                            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                                            curl_close($curl);

                                                            if ($http_status == 401) {
                                                                setcookie('auth', '', time() - 3600, '/');
                                                                $request->session()->flush();
                                                                header('Location: ' . route('loginPage'), true, 302);
                                                                exit();
                                                            }
                                                            $order->status_pembayaran = 'Lunas';
                                                            $order->status_iklan = 'Sedang Diproses';
                                                        } elseif ($invoice_data->status == 'EXPIRED') {
                                                            $desk_up = 'Waktu pembayaran habis.';
                                                            $curl = curl_init();
                                                            curl_setopt_array($curl, [
                                                                CURLOPT_URL => gethostname() . '/websiteku/public/api/CancelOrder/' . $order->order_id,
                                                                CURLOPT_RETURNTRANSFER => true,
                                                                CURLOPT_ENCODING => '',
                                                                CURLOPT_MAXREDIRS => 10,
                                                                CURLOPT_TIMEOUT => 0,
                                                                CURLOPT_FOLLOWLOCATION => true,
                                                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                                                CURLOPT_CUSTOMREQUEST => 'POST',
                                                                CURLOPT_POSTFIELDS =>
                                                                    '{
                                                            "detail_kemajuan": "' .
                                                                    $desk_up .
                                                                    '"
                                                        }',
                                                                CURLOPT_HTTPHEADER => ['Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . Cookie::get('auth')],
                                                            ]);
                                                            $cancel = curl_exec($curl);
                                                            $cancel = json_decode($cancel);
                                                            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                                            curl_close($curl);

                                                            if ($http_status == 401) {
                                                                setcookie('auth', '', time() - 3600, '/');
                                                                $request->session()->flush();
                                                                header('Location: ' . route('loginPage'), true, 302);
                                                                exit();
                                                            }
                                                            $order->status_pembayaran = 'Dibatalkan';
                                                            $order->status_iklan = 'Dibatalkan';
                                                            $order->foto_iklan = 'none';
                                                        }
                                                    }
                                                @endphp
                                            @endif
                                            <tr>
                                                <td>
                                                    <div class="container p-2">
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>No. Order</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>:
                                                                    @if (isset($order->nomor_order))
                                                                        {{ $order->nomor_order }}
                                                                    @else
                                                                        {{ '--------------------' }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>No. Seri</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>:
                                                                    @if (isset($order->nomor_seri))
                                                                        {{ $order->nomor_seri }}
                                                                    @else
                                                                        {{ '--------------------' }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>No. Invoice</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>:
                                                                    @if (isset($order->nomor_invoice))
                                                                        {{ $order->nomor_invoice }}
                                                                    @else
                                                                        {{ '--------------------' }}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Invoice</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>:
                                                                    @if (isset($order->invoice_id))
                                                                        <a href="{{ $xendit_link . $order->invoice_id }}"
                                                                            target="_blank">{{ $order->invoice_id }}</a>
                                                                    @else
                                                                        {{ '--------------------' }}
                                                                    @endif
                                                                </p>
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
                                                                <p>: {{ $order->nama_instansi }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Ukuran Iklan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{ $order->tinggi }} x {{ $order->kolom }} mmk
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Tanggal Penerbitan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{ $order->mulai_iklan }} hingga
                                                                    {{ $order->akhir_iklan }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Lama Terbit</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{ $order->lama_hari }} Hari</p>
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
                                                                <p
                                                                    class="@if ($order->status_iklan == 'Dibatalkan') {{ 'text-danger' }}
                                                                @elseif($order->status_iklan == 'Telah Tayang')
                                                                    {{ 'text-success' }}
                                                                @elseif ($order->status_iklan == 'Menunggu Pembayaran')
                                                                    {{ 'text-secondary' }}
                                                                @else
                                                                    {{ 'text-primary' }} @endif">
                                                                    : {{ $order->status_iklan }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Status Pembayaran</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p
                                                                    class="@if ($order->status_pembayaran == 'Dibatalkan') {{ 'text-danger' }}
                                                                @elseif($order->status_pembayaran == 'Telah Tayang')
                                                                    {{ 'text-success' }}
                                                                @elseif ($order->status_pembayaran == 'Belum Lunas')
                                                                    {{ 'text-secondary' }}
                                                                @else
                                                                    {{ 'text-primary' }} @endif">
                                                                    : {{ $order->status_pembayaran }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>Deskripsi Iklan</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p>: {{ $order->deskripsi_iklan }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="container"
                                                        style="max-height: 18.5rem; width: 15rem; overflow: hidden">
                                                        @if ($order->foto_iklan == 'none')
                                                            <a href="{{ asset('images/logo.jpeg') }}"
                                                                target="_blank">
                                                                <img src="{{ asset('images/logo.jpeg') }}"
                                                                    class="card-img-top" alt=""
                                                                    style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/image/' . $order->foto_iklan) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/image/' . $order->foto_iklan) }}"
                                                                    class="card-img-top" alt=""
                                                                    style="border: 1px solid black; object-fit:contain; width: 100%; height: 100%">
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($order->status_pembayaran != 'Dibatalkan')
                                                        @if ($order->status_iklan != 'Telah Tayang')
                                                            <div class="dropdown mb-4 text-center">
                                                                <button class="btn btn-primary " type="button"
                                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fas fa-pen-nib"></i>
                                                                </button>
                                                                <div class="dropdown-menu animated--fade-in"
                                                                    aria-labelledby="dropdownMenuButton">
                                                                    @if ($order->status_pembayaran == 'Menunggu Konfirmasi')
                                                                        <button id="TerimaOrderBtn"
                                                                            class="dropdown-item text-primary"
                                                                            data-toggle="modal"
                                                                            data-target="#TerimaOrder"
                                                                            data-id="{{ $order->order_id }}">
                                                                            Terima Order</button>
                                                                        <button id="TolakOrderBtn"
                                                                            class="dropdown-item text-danger"
                                                                            data-toggle="modal"
                                                                            data-target="#TolakOrder"
                                                                            data-id="{{ $order->order_id }}">
                                                                            Tolak Order</button>
                                                                    @elseif ($order->status_pembayaran == 'Belum Lunas')
                                                                        <button id="BatalkanOrderBtn"
                                                                            class="dropdown-item text-danger"
                                                                            data-toggle="modal"
                                                                            data-target="#BatalkanOrder"
                                                                            data-id="{{ $order->order_id }}"
                                                                            data-xenid="{{ $order->invoice_id }}">
                                                                            Batalkan Order</button>
                                                                    @elseif ($order->status_pembayaran != 'Dibatalkan')
                                                                        <button id="PublishedOrderBtn"
                                                                            class="dropdown-item text-primary"
                                                                            data-toggle="modal"
                                                                            data-target="#PublishedOrder"
                                                                            data-id="{{ $order->order_id }}">
                                                                            Telah Tayang</button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
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

    <!-- Download Excel -->
    <div class="modal fade" id="DownloadExcel" tabindex="-1" role="dialog" aria-labelledby="DownloadExcel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unduh Rekap Data Excel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('DownloadExportOrderData') }}" class="user" method="POST" autocomplete="off">
                    @method('POST')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <div class="container mt-4">
                                    <h5 class="fallbackLabel">Pilih rekap tanggal berapa yang ingin diunduh</h5>
                                    <div class="fallbackDatePicker">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="month">Bulan:</label>
                                                    <select class="form-control" id="month" name="month">
                                                        <option value="1" selected>Januari</option>
                                                        <option value="2">Februari</option>
                                                        <option value="3">Maret</option>
                                                        <option value="4">April</option>
                                                        <option value="5">Mei</option>
                                                        <option value="6">Juni</option>
                                                        <option value="7">Juli</option>
                                                        <option value="8">Agustus</option>
                                                        <option value="9">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="year">Tahun:</label>
                                                    <select class="form-control" id="year"
                                                        name="year"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Unduh Rekap
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Terima Order -->
    <div class="modal fade" id="TerimaOrder" tabindex="-1" role="dialog" aria-labelledby="TerimaOrder"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terima Order</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('TerimaOrderPengguna') }}" class="user" method="POST" autocomplete="off"
                    id="FormTerima">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="order_id" id="order_id" value="">
                            <div class="mb-3">
                                <label for="nomor_order" class="form-label">Nomor Order<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomor_order" name="nomor_order"
                                    placeholder="cth. BJM230000452" required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_seri" class="form-label">Nomor Seri<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomor_seri" name="nomor_seri"
                                    placeholder="cth. 9107743232723925" required>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_invoice" class="form-label">Nomor Invoice<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomor_invoice" name="nomor_invoice"
                                    placeholder="cth. 2300051YA-BJM" required>
                            </div>
                            <div class="mb-3">
                                <label for="detail_kemajuan" class="form-label">Detail Penerimaan Iklan</label>
                                <textarea class="form-control" rows="3" id="detail_kemajuan" name="detail_kemajuan"
                                    placeholder="cth. pesanan kami terima ...."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-user btn-block">
                            Terima Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tolak Order -->
    <div class="modal fade" id="TolakOrder" tabindex="-1" role="dialog" aria-labelledby="TolakOrder"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tolak Order</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('TolakOrderPengguna') }}" class="user" method="POST" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="order_id" id="order_id" value="">
                            <div class="mb-3">
                                <label for="detail_kemajuan" class="form-label">Detail Penolakan Iklan<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="detail_kemajuan" name="detail_kemajuan"
                                    placeholder="cth. pesanan kami tolak karena ...."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Tolak Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Published Order -->
    <div class="modal fade" id="PublishedOrder" tabindex="-1" role="dialog" aria-labelledby="PublishedOrder"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Tayang Order</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('OrderTelahTayang') }}" class="user" method="POST" autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="order_id" id="order_id" value="">
                            <div class="mb-3">
                                <label for="detail_kemajuan" class="form-label">Detail Progress Iklan<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="detail_kemajuan" name="detail_kemajuan"
                                    placeholder="cth. pesanan telah kami tayangkan ...." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Konfirmasi Tayang Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Batalkan Order -->
    <div class="modal fade" id="BatalkanOrder" tabindex="-1" role="dialog" aria-labelledby="BatalkanOrder"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Batal Order</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('BatalkanOrderPengguna') }}" class="user" method="POST"
                    autocomplete="off">
                    @method('PATCH')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="order_id" id="order_id" value="">
                            <input type="hidden" name="xendit_id" id="xendit_id" value="">
                            <div class="mb-3">
                                <label for="detail_kemajuan" class="form-label">Detail Pembatalan Iklan<span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" rows="3" id="detail_kemajuan" name="detail_kemajuan"
                                    placeholder="cth. pesanan telah kami batalkan karena ...." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Konfirmasi Batal Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @php
        session()->forget('success');
        session()->forget('danger');
    @endphp

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Download Excel Kalender --}}
    <script>
        var yearDropdown = document.getElementById('year');

        var currentYear = new Date().getFullYear();
        var startYear = currentYear;
        var endYear = currentYear - 10;

        for (var year = startYear; year >= endYear; year--) {
            var option = document.createElement('option');
            option.value = year;
            option.text = year;
            yearDropdown.add(option);
        }
    </script>

    <script>
        document.getElementById("FormTerima").addEventListener("submit", function(event) {
            event.preventDefault();
            const swal = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-outline-success",
                    cancelButton: "btn btn-outline-danger",
                    actions: "d-flex justify-content-center gap-3",
                    container: "pe-4"
                },
                buttonsStyling: false
            });

            // Ambil data
            var no_order = "Nomor Order: " + document.querySelector('input[name="nomor_order"]').value + "<br>";
            var no_seri = "Nomor Seri: " + document.querySelector('input[name="nomor_seri"]').value + "<br>";
            var no_inv = "Nomor Invoice: " + document.querySelector('input[name="nomor_invoice"]').value + "<br>";

            // Membuat Model
            swal.fire({
                title: "Apakah anda yakin?",
                html: "Pastikan semua data yang dimasukkan benar!<br>" + no_order + no_seri + no_inv,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Teruskan",
                cancelButtonText: "Batalkan",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('FormTerima').submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swal.fire({
                        title: "Aksi telah dibatalkan!",
                        text: "Data order tidak berubah",
                        icon: "error"
                    });
                }
            });
        });
    </script>



    <script>
        $(document).on("click", "#TerimaOrderBtn", function() {
            var OrderId = $(this).data('id');
            $(".modal-body #order_id").val(OrderId);
        });
        $(document).on("click", "#TolakOrderBtn", function() {
            var OrderId = $(this).data('id');
            $(".modal-body #order_id").val(OrderId);
        });
        $(document).on("click", "#PublishedOrderBtn", function() {
            var OrderId = $(this).data('id');
            $(".modal-body #order_id").val(OrderId);
        });
        $(document).on("click", "#BatalkanOrderBtn", function() {
            var OrderId = $(this).data('id');
            var XenditId = $(this).data('xenid');
            $(".modal-body #order_id").val(OrderId);
            $(".modal-body #xendit_id").val(XenditId);
        });
    </script>
</body>

</html>
