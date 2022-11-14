<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets/img/NPMI_Logo.png')}}">
    <title>PT. NPR Mfg Ind</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">



    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/daterangepicker/daterangepicker.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">


    <link href="{{asset('/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/datatables-select/css/select.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/bootstrap-slider/css/bootstrap-slider.min.css')}}">

    @yield('head')
</head>

<body>



    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-5">
                    <h5>Date : {{date('d M Y')}}</h5>
                </div>

                <div class="pull-right">
                    <h4 id="jam"> 00:00:00 </h4>

                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/produksi/menu_produksi')}}"><i class="fas fa-home">
                                    Home / </i></a></li>

                        <div class="row float-left">
                            <button class="btn btn-sm float-center" id="btn_reload"><i class="fa fa-sync">
                                    Refresh / </i></button>

                            <button class="btn btn-sm float-center"
                                style="font-family: 'Times New Roman'; color: red;"><a data-toggle="collapse"
                                    data-parent="#accordion" href="#collapseOne3" class="btn-flat"
                                    aria-expanded="false">
                                    <b>Power</b>
                                </a>
                            </button>
                            <div id="collapseOne3" class="panel-collapse in collapse">
                                <button type="button" class="btn btn-sm btn-danger" id="btn_shutdown"><i
                                        class="fa fa-power-off"></i> Shutdwon</button>
                            </div>
                        </div>
                </div>
                </ol>

            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->



            @yield('content')
        </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
    <footer class="p-3 mb-2 bg-light text-dark">
        <strong>Copyright &copy; {{Date('Y')}} <a style="color:blue;"> PT. NPR Manufacturing
                Indonesia</a>.</strong>
        <!-- All rights reserved.-->
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.2
        </div>
    </footer>


    <!-- jQuery -->
    <script src="{{asset('/assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('/dist/js/adminlte.js')}}"></script>


    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/'))!!}
        $(document).ready(function () {
            clockUpdate();
            setInterval(clockUpdate, 1000);

            $("#btn_reload").click(function () {
                //location.reload();
                //setTimeout(() => {
                //    window.location.reload(true);
                //});
                window.location = window.location;
            })
        })

        $("#btn_shutdown").click(function () {
            var e = confirm("Apakah anda akan mematikan perangkat ini ?");
            if (e) {
                window.location.href = 'http://127.0.0.1:5000/shutdown';
            }
        });

        function clockUpdate() {
            var tgl = new Date();
            function addZero(x) {
                if (x < 10) {
                    return x = '0' + x;
                } else {
                    return x;
                }
            }

            var h = addZero(tgl.getHours());
            var m = addZero(tgl.getMinutes());
            var s = addZero(tgl.getSeconds());

            $("#jam").text(h + ':' + m + ':' + s)
        }

    </script>

</body>

</html>
@yield('script')