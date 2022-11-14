<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/img/NPMI_Logo.png') }}">
    <title>PT. NPR Mfg Ind</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">



    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


    <link href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/datatables-select/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap-slider/css/bootstrap-slider.min.css') }}">
    @yield('css')

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>


            </ul>



            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->

                <li class="nav-item dropdown show">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                        <i class="far fa-bell"></i>

                        @if (Session::has('id') && App\UserModel::find(Session::get('id'))->unreadNotifications->count() > 0)
                            <span
                                class="badge badge-danger navbar-badge">{{ App\UserModel::find(Session::get('id'))->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    @if (Session::has('id') && App\UserModel::find(Session::get('id'))->unreadNotifications->count() > 0)
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach (App\UserModel::find(Session::get('id'))->unreadNotifications as $notif)
                                <a href="{{ route('readnotif', ['type' => $notif->data['type'], 'id' => Session::get('id')]) }}"
                                    class="dropdown-item">
                                    @if ($notif->data['type'] == 'perbaikan')
                                        <i class="fas fa-cog"></i>
                                    @else
                                        <i class="fas fa-exclamation-circle"></i>
                                    @endif
                                    {{ $notif->data['message'] }}
                                    <small
                                        class="float-right text-muted text-sm">{{ $notif->data['nama_mesin'] }}</small>

                                </a>

                                <div class="dropdown-divider"></div>
                            @endforeach
                        </div>
                    @endif
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('/dist/img/NPMI_Logo.png') }}" alt="NPMI Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PT. NPR Mfg Ind</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('/assets/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ url('/userprofil') }}" class="d-block">{{ Session::get('name') }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    DASHBOARD

                                </p>
                            </a>
                        </li>
                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('produksi/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('produksi/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        PRODUKSI
                                        <i class="fas fa-angle-left right"></i>
                                        <!-- <span class="badge badge-info right">6</span> -->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/produksi/inquery_report') }}"
                                            class="nav-link {{ Request::is('produksi/inquery_report') ? 'active' : '' }}">
                                            <i class="far fa-file-alt nav-icon"></i>
                                            <p>Report Produksi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/report') }}"
                                            class="nav-link {{ Request::is('produksi/report') ? 'active' : '' }}">
                                            <i class="far fa-file-alt nav-icon"></i>
                                            <p>Report Inquery</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/NGreport') }}"
                                            class="nav-link {{ Request::is('produksi/NGreport') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>NG Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/lembur') }}"
                                            class="nav-link {{ Request::is('produksi/lembur') ? 'active' : '' }}">
                                            <i class="fas fa-clock nav-icon"></i>
                                            <p>Report Lembur</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item has-treeview {{ Request::is('produksi/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('produksi/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        PRODUKSI
                                        <i class="fas fa-angle-left right"></i>
                                        <!-- <span class="badge badge-info right">6</span> -->
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/formmasalah') }}"
                                            class="nav-link {{ Request::is('produksi/formmasalah') ? 'active' : '' }}">
                                            <i class="far fa-keyboard nav-icon"></i>
                                            <p>Informasi Masalah</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/produksi/menu_hasil_produksi') }}"
                                            class="nav-link {{ Request::is('produksi/menu_hasil_produksi') ? 'active' : '' }}">
                                            <i class="far fa-file-alt nav-icon"></i>
                                            <p>Report Produksi</p>
                                        </a>
                                    </li>
                                    <!--<li class="nav-item">
                  <a href="{{ url('produksi/report') }}"
                    class="nav-link {{ Request::is('produksi/report') ? 'active' : '' }}">
                    <i class="far fa-file-alt nav-icon"></i>
                    <p>Report Inquery</p>
                  </a>
                </li>-->
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/NGreport') }}"
                                            class="nav-link {{ Request::is('produksi/NGreport') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>NG Report</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/lembur') }}"
                                            class="nav-link {{ Request::is('produksi/lembur') ? 'active' : '' }}">
                                            <i class="fas fa-clock nav-icon"></i>
                                            <p>Report Lembur</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/menurequestjigu') }}"
                                            class="nav-link {{ Request::is('produksi/menurequestjigu') ? 'active' : '' }}">
                                            <i class="fas fa-drafting-compass nav-icon"></i>
                                            <p>Request Jigu / Part</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('produksi/perbaikan') }}"
                                            class="nav-link {{ Request::is('produksi/perbaikan') ? 'active' : '' }}">
                                            <i class="fas fa-hammer nav-icon"></i>
                                            <p>Request Perbaikan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('maintenance/*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ Request::is('maintenance/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-toolbox"></i>
                                    <p>
                                        MAINTENANCE
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/perbaikan') }}"
                                            class="nav-link {{ Request::is('maintenance/perbaikan') ? 'active' : '' }}">
                                            <i class="fas fa-hammer nav-icon"></i>
                                            <p>Perbaikan</p>
                                        </a>

                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/laporan') }}"
                                            class="nav-link {{ Request::is('maintenance/laporan') ? 'active' : '' }}">
                                            <i class="fas fa-chart-line nav-icon"></i>
                                            <p>Laporan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Session::get('dept') == 'MAINTENANCE' ||
                            Session::get('level') == 'Admin' ||
                            Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('maintenance/*') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ Request::is('maintenance/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-toolbox"></i>
                                    <p>
                                        MAINTENANCE
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/perbaikan') }}"
                                            class="nav-link {{ Request::is('maintenance/perbaikan') ? 'active' : '' }}">
                                            <i class="fas fa-hammer nav-icon"></i>
                                            <p>Perbaikan</p>
                                        </a>

                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/schedule') }}"
                                            class="nav-link {{ Request::is('maintenance/schedule') ? 'active' : '' }}">
                                            <i class="far fa-calendar-alt nav-icon"></i>
                                            <p>Schedule</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/laporan') }}"
                                            class="nav-link {{ Request::is('maintenance/laporan') ? 'active' : '' }}">
                                            <i class="fas fa-chart-line nav-icon"></i>
                                            <p>Laporan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/maintenance/mesin') }}"
                                            class="nav-link {{ Request::is('maintenance/mesin') ? 'active' : '' }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>Mesin</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('technical/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('technical/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-drafting-compass"></i>
                                    <p>
                                        TECHNICAL
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/undermaintenance') }}"
                                            class="nav-link {{ Request::is('') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>Jigu Control</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(strpos(Session::get('dept'), 'TOOLING') !== false ||
                            Session::get('level') == 'Admin' ||
                            Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('technical/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('technical/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-drafting-compass"></i>
                                    <p>
                                        TECHNICAL
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/undermaintenance') }}"
                                            class="nav-link {{ Request::is('') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>Jigu Control</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/technical/inquery-permintaan') }}"
                                            class="nav-link {{ Request::is('technical/inquery-permintaan') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>Request</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/technical/update') }}"
                                            class="nav-link {{ Request::is('technical/update') ? 'active' : '' }}">
                                            <i class="fas fa-clipboard-check nav-icon"></i>
                                            <p>Update Denpyou</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/technical/list_master') }}"
                                            class="nav-link {{ Request::is('technical/list_master') ? 'active' : '' }}">
                                            <i class="fa fa-asterisk nav-icon"></i>
                                            <p>Master Tanegata</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('qa/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('qa/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-ruler-combined"></i>
                                    <p>
                                        QA
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/undermaintenance') }}"
                                            class="nav-link {{ Request::is('qa/qamenu') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>QA Menu</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(strpos(Session::get('dept'), 'MEASUREMENT') !== false ||
                            Session::get('level') == 'Admin' ||
                            Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('qa/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('qa/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-ruler-combined"></i>
                                    <p>
                                        QA
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/qa/qamenu') }}"
                                            class="nav-link {{ Request::is('qa/qamenu') ? 'active' : '' }}">
                                            <i class="fas fa-plus-square nav-icon"></i>
                                            <p>QA Menu</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                        @elseif(strpos(Session::get('dept'), 'INSPECTION') !== false ||
                            Session::get('level') == 'Admin' ||
                            Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('kensa/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('kensa/*') ? 'active' : '' }}">
                                    <i class="nav-icon fab fa-korvue"></i>
                                    <p>
                                        KENSA
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/kensa/gaikan') }}"
                                            class="nav-link {{ Request::is('kensa/gaikan') ? 'active' : '' }}">
                                            <i class="fas fa-certificate nav-icon"></i>
                                            <p>GAIKAN</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                        @elseif(Session::get('dept') == 'PPIC' || Session::get('level') == 'Admin' || Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('ppic/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('ppic/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-truck"></i>
                                    <p>
                                        DELIVERY
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/ppic/workresult') }}"
                                            class="nav-link {{ Request::is('ppic/workresult') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Work Result Entry</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/ppic/inqueryworkresult') }}"
                                            class="nav-link {{ Request::is('ppic/inqueryworkresult') ? 'active' : '' }}">
                                            <i class="fas fa-list-ol nav-icon"></i>
                                            <p>List Work Result</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/ppic/f_calculation') }}" class="nav-link">
                                            <i class="fab fa-fedex nav-icon"></i>
                                            <p>Estimasi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/ppic/target') }}" class="nav-link">
                                            <i class="fas fa-text-height nav-icon"></i>
                                            <p>TARGET</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/ppic/f_master') }}"
                                            class="nav-link {{ Request::is('ppic/f_master') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Master PPIC</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/ppic/jam_kerusakan') }}"
                                            class="nav-link {{ Request::is('ppic/jam_kerusakan') ? 'active' : '' }}">
                                            <i class="fas fa-cogs nav-icon"></i>
                                            <p>Jam Kerusakan Mesin</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('hse/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('hse/*') ? 'active' : '' }}">
                                    <i class="nav-icon fab fa-envira"></i>
                                    <p>
                                        HSE
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/hse/hklist') }}"
                                            class="nav-link {{ Request::is('hse/hklist') ? 'active' : '' }}">
                                            <i class="fas fa-list nav-icon"></i>
                                            <p>HH / KY Inquery</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('hse/hhkygrafik') }}"
                                            class="nav-link {{ Request::is('hse/hhkygrafik') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>HH / KY Grafik</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Session::get('dept') == 'HSE' || Session::get('level') == 'Admin' || Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('hse/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('hse/*') ? 'active' : '' }}">
                                    <i class="nav-icon fab fa-envira"></i>
                                    <p>
                                        HSE
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/hse/f_hhky') }}"
                                            class="nav-link {{ Request::is('hse/f_hhky') ? 'active' : '' }}">
                                            <i class="fas fa-h-square nav-icon"></i>
                                            <p>HH / KY Entry</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/hse/hklist') }}"
                                            class="nav-link {{ Request::is('hse/hklist') ? 'active' : '' }}">
                                            <i class="fas fa-list nav-icon"></i>
                                            <p>HH / KY Inquery</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('hse/hhkygrafik') }}"
                                            class="nav-link {{ Request::is('hse/hhkygrafik') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>HH / KY Grafik</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('iso/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('iso/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-globe"></i>
                                    <p>
                                        ISO
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('iso/ssgrafik') }}"
                                            class="nav-link {{ Request::is('iso/ssgrafik') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>SS Grafik</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Session::get('dept') == 'SEKRETARIAT ISO' ||
                            Session::get('level') == 'Admin' ||
                            Session::get('level') == 'Manager')
                            <li class="nav-item has-treeview {{ Request::is('iso/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('iso/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-globe"></i>
                                    <p>
                                        ISO
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/iso/ssentry') }}"
                                            class="nav-link {{ Request::is('iso/ssentry') ? 'active' : '' }}">
                                            <i class="fab fa-staylinked nav-icon"></i>
                                            <p>SS Entry</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('iso/ssgrafik') }}"
                                            class="nav-link {{ Request::is('iso/ssgrafik') ? 'active' : '' }}">
                                            <i class="fas fa-chart-pie nav-icon"></i>
                                            <p>SS Grafik</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/iso/sspoint') }}"
                                            class="nav-link {{ Request::is('iso/') ? 'active' : '' }}">
                                            <i class="fas fa-list-ol nav-icon"></i>
                                            <p>SS Point</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                        @elseif(Session::get('level') == 'Admin' || Session::get('level') == 'Manager' || Session::get('nik') == '0014')
                            <li class="nav-item has-treeview {{ Request::is('manager/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('manager/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        Manager
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/manager/targetlembur') }}"
                                            class="nav-link {{ Request::is('manager/targetlembur') ? 'active' : '' }}">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Target Lembur</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if (Session('nik') == '000000')
                            <li class="nav-item has-treeview {{ Request::is('pga/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('pga/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        PGA
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/employee') }}"
                                            class="nav-link {{ Request::is('pga/employee') ? 'active' : '' }}">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Employee</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(strtoupper(Session::get('name')) == 'ASMAN' || Session::get('level') == 'Admin')
                            <li class="nav-item has-treeview {{ Request::is('pga/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('pga/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        PGA
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-danger right" id="notifskill"
                                            name="notifskill"></span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/employee') }}"
                                            class="nav-link {{ Request::is('pga/employee') ? 'active' : '' }}">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Employee</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/appraisal') }}"
                                            class="nav-link {{ Request::is('pga/appraisal') ? 'active' : '' }}">
                                            <i class="fas fa-check-circle nav-icon"></i>
                                            <p>Appraisal</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/PGABonus') }}"
                                            class="nav-link {{ Request::is('pga/PGABonus') ? 'active' : '' }}">
                                            <i class="fas fa-money-bill-wave nav-icon"></i>
                                            <p>Bonus</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/menupenilaian') }}"
                                            class="nav-link {{ Request::is('pga/menupenilaian') ? 'active' : '' }}">
                                            <i class="fas fa-pen-alt nav-icon"></i>
                                            <p>Penilaian Entry</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/skillmatrik') }}"
                                            class="nav-link {{ Request::is('pga/skillmatrik') ? 'active' : '' }}">
                                            <i class="fa fa-sitemap nav-icon"></i>
                                            <p>Skill Matrik</p>
                                            <span class="badge badge-danger right" id="notifskill_1"
                                                name="notifskill_1"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Session::get('level') == 'Leader' ||
                            Session::get('level') == 'Foreman' ||
                            Session::get('level') == 'Assisten Supervisor' ||
                            Session::get('level') == 'Supervisor' ||
                            Session::get('level') == 'Assisten Manager' ||
                            Session::get('name') == 'Doni H' ||
                            Session::get('name') == 'Fajar N' ||
                            Session::get('name') == 'Haryono')
                            <li class="nav-item has-treeview {{ Request::is('pga/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('pga/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        PGA
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-danger right" id="notifskill"
                                            name="notifskill"></span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/employee') }}"
                                            class="nav-link {{ Request::is('pga/employee') ? 'active' : '' }}">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Employee</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/menupenilaian') }}"
                                            class="nav-link {{ Request::is('pga/menupenilaian') ? 'active' : '' }}">
                                            <i class="fas fa-pen-alt nav-icon"></i>
                                            <p>Penilaian Entry</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/skillmatrik') }}"
                                            class="nav-link {{ Request::is('pga/skillmatrik') ? 'active' : '' }}">
                                            <i class="fa fa-sitemap nav-icon"></i>
                                            <p>Skill Matrik</p>
                                            <span class="badge badge-danger right" id="notifskill_1"
                                                name="notifskill_1"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Session::get('dept') == 'PGA')
                            <li class="nav-item has-treeview {{ Request::is('pga/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('pga/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        PGA
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/employee') }}"
                                            class="nav-link {{ Request::is('pga/employee') ? 'active' : '' }}">
                                            <i class="fas fa-address-card nav-icon"></i>
                                            <p>Employee</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/skillmatrik') }}"
                                            class="nav-link {{ Request::is('pga/skillmatrik') ? 'active' : '' }}">
                                            <i class="fa fa-sitemap nav-icon"></i>
                                            <p>Skill Matrik</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @elseif(Session::get('level_user') == 'Administrasi' || Session::get('level_user') == 'Staff')
                            <li class="nav-item has-treeview {{ Request::is('pga/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('pga/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-edit"></i>
                                    <p>
                                        PGA
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/pga/skillmatrik') }}"
                                            class="nav-link {{ Request::is('pga/skillmatrik') ? 'active' : '' }}">
                                            <i class="fa fa-sitemap nav-icon"></i>
                                            <p>Skill Matrik</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item has-treeview {{ Request::is('document/*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('document/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    DOCUMENT
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-danger right" id="notifdocument"
                                        name="notifdocument"></span>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/document/inquery_document') }}"
                                        class="nav-link {{ Request::is('document/inquery_document') ? 'active' : '' }}">
                                        <i class="fa fa-file-contract nav-icon"></i>
                                        <p>My Document</p>
                                        <!--<span class="badge badge-danger right" id="notifdocument_1"
                                        name="notifdocument_1"></span>-->
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @if (Session('nik') == '000000')
                        @elseif(Session::get('level') == 'Admin')
                            <li class="nav-item has-treeview {{ Request::is('admin/*') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ Request::is('admin/*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Admin
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/admin/register') }}"
                                            class="nav-link {{ Request::is('admin/register') ? 'active' : '' }}">
                                            <i class="fas fa-user-plus nav-icon"></i>
                                            <p>Register</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/admin/list-user') }}"
                                            class="nav-link {{ Request::is('admin/list-user') ? 'active' : '' }}">
                                            <i class="fas fa-portrait nav-icon"></i>
                                            <p>List User</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/admin/tools') }}"
                                            class="nav-link {{ Request::is('admin/tools') ? 'active' : '' }}">
                                            <i class="fas fa-tools nav-icon"></i>
                                            <p>Tools</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/admin/log') }}"
                                            class="nav-link {{ Request::is('admin/log') ? 'active' : '' }}">
                                            <i class="fas fa-clipboard-list nav-icon"></i>
                                            <p>Log</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif


                        <li class="nav-item">
                            <a href="{{ url('/calendar') }}"
                                class="nav-link {{ Request::is('calendar') ? 'active' : '' }}">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Calendar
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/petunjuk') }}"
                                class="nav-link {{ Request::is('petunjuk') ? 'active' : '' }}">
                                <i class="nav-icon far fa-question-circle"></i>
                                <p>
                                    HELP
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link" id="logout">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    LOGOUT
                                    <meta name="csrf-token" content="{{ csrf_token() }}">

                                </p>
                            </a>
                        </li>
                        <!-- /.sidebar-menu -->
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <h5>Date : {{ date('d M Y') }}</h5>
                        </div>

                    </div>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Main row -->

                    @yield('content')
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>

            <!-- /.content -->
            <footer class="p-3 mb-2 bg-light text-dark">
                <strong>Copyright &copy; 2020 <a href="#">PT. NPR Manufacturing Indonesia</a>.</strong>
                <!-- All rights reserved.-->
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.0.2
                </div>
            </footer>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <div id="sidebar-overlay"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>





    <!-- AdminLTE App -->
    <script src="{{ asset('/dist/js/adminlte.js') }}"></script>

    <script src="{{ asset('/assets/script/aplikasi.js') }}"></script>
    <script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function loadingon() {
            document.getElementById("loadingscreen").style.display = "block";
        }

        function loadingoff() {
            document.getElementById("loadingscreen").style.display = "none";
        }
    </script>
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}



        $("#logout").click(function(event) {
            event.preventDefault();
            var user = localStorage.getItem('npr_id_user');
            $.ajax({
                    url: APP_URL + '/logout',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: user
                    },
                })
                .done(function(resp) {
                    if (resp.success) {
                        localStorage.removeItem('npr_name');
                        localStorage.removeItem('npr_token');
                        localStorage.removeItem('npr_id_user');
                        window.location.href = "{{ route('login') }}";

                    } else
                        $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                })
                .fail(function() {
                    $("#error").html(
                        "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                    );
                    //toastr['warning']('Tidak dapat terhubung ke server !!!');
                });

        });
    </script>

    @if (Session::get('dept') == 'PPIC')
        <script type="text/javascript">
            $(document).ready(function() {

                Echo.channel('mesin')
                    .listen('EventPPIC', (e) => notifikasi(e.message.judul, e.message.sub, e.message.isi));
            });

            function notifikasi(judul, sub, isi) {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 10000

                });
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: judul,
                    subtitle: sub,
                    body: isi
                })


            }
        </script>
    @endif

    @if (Session::get('level') == 'Supervisor' ||
        Session::get('level') == 'Assisten Manager' ||
        Session::get('level') == 'Manager' ||
        Session::get('level') == 'Admin')
        <script>
            $(document).ready(function() {
                var key = localStorage.getItem('npr_token');
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/notifskill",
                        headers: {
                            "token_req": key
                        },
                        dataType: "json",
                    })
                    .done(function(resp) {
                        if (resp.skillmatrik >= 1) {
                            //alert(resp.skillmatrik[0].total);
                            $("#notifskill").html(resp.skillmatrik);
                            $("#notifskill_1").html(resp.skillmatrik);
                        } else {
                            $("#notifskill").html('');
                            $("#notifskill_1").html('');
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                        );
                    });

            });
        </script>
    @endif

    <script>
                        var key = localStorage.getItem('npr_token');
        $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/notifdocument",
                        headers: {
                            "token_req": key
                        },
                        dataType: "json",
                    })
                    .done(function(resp) {
                        if (resp.document >= 1) {
                            //alert(resp.skillmatrik[0].total);
                            $("#notifdocument").html(resp.document);
                            $("#notifdocument_1").html(resp.document);
                        } else {
                            $("#notifdocument").html('');
                            $("#notifdocument_1").html('');
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                        );
                    });
    </script>


</body>

</html>
@yield('script')
