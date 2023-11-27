<div>
    @if (!Cookie::has('auth'))
        <script>
            window.location = "{{ route('loginPage') }}";
        </script>
    @else
        @php
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => request()->getSchemeAndHttpHost().'/api/UserCheck',
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
            $user_data = curl_exec($curl);
            $user_data = json_decode($user_data);
            $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            if ($http_status == 401 || $http_status == 500 || $http_status == 404) {
                setcookie('auth', '', time() - 3600, '/');
                session()->flush();
                header('Location: ' . route('loginPage'), true, 302);
                exit();
            }
        @endphp
    @endif
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Radar Banjarmasin</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0" />

        <!-- Divider -->
        <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Dashboard</div>

        <!-- Nav Item - Order Data -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('orderData') }}">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Order Data</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('paketData') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Paket Data</span></a>
            </li>
            
        <!-- Nav Item - Pemesanan Iklan -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('pemesanan') }}">
                    <i class="fas fa-fw fa-pen-alt"></i>
                    <span>Pesan Iklan</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider" />

        <!-- Heading -->
        <div class="sidebar-heading">Utility</div>

        @isset($user_data->role)
        @if ($user_data->role == "admin")
            <li class="nav-item">
                <a class="nav-link" href="{{ route('agentData') }}">
                    <i class="fas fa-fw fa-user-lock"></i>
                    <span>Data Anggota Biro Iklan</span></a>
            </li>
        @endif
        @endisset

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-user"></i>
                <span>User</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Options</h6>
                    <a class="dropdown-item" href="{{route('profilePro')}}">
                        <i class="fas fa-address-card fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="{{ route('SendToRiwayatUser') }}">
                        <i class="fas fa-address-book fa-sm fa-fw mr-2 text-gray-400"></i>
                        Riwayat
                    </a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block" />

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <!-- End of Sidebar -->

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
                    <form action="{{route('LogoutCall')}}" method='POST'>
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-primary" type="button">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
