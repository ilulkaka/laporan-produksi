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




    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/daterangepicker/daterangepicker.css')}}">



    <link href="{{asset('/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/datatables-select/css/select.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{asset('/assets/plugins/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="{{asset('/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/plugins/bootstrap-slider/css/bootstrap-slider.min.css')}}">
</head>

<body>

    <div class="content-header">

        <div class="container-fluid">
            <div class="row mb-12">

                <div class="col-sm-6">
                    <h5>Date : {{date('d M Y')}}</h5>
                </div>
                <div class="pull-right">
                    <h4 id="jam">00:00:00</h4>

                </div>

            </div>
        </div><!-- /.container-fluid -->
    </div>
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
        <strong>Copyright &copy; {{Date('Y')}} <a href="#">PT. NPR Manufacturing Indonesia</a>.</strong>
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

    <script src="{{asset('/assets/plugins/toastr/toastr.min.js')}}"></script>

    <script src="{{asset('/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <script src="{{ asset('js/app.js') }}"></script>

    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/'))!!}
        $(document).ready(function () {
            clockUpdate();
            setInterval(clockUpdate, 1000);
            alarm_act('off');
            $("#btn_reload").click(function () {
                location.reload();
            });
            $('body').on('click', '#toastsContainerTopRight', function () {
                alarm_act('off');
            });


            Echo.channel('notif')
                .listen('EventMessage', (e) => notifikasi(e.message.judul, e.message.sub, e.message.isi,e.message.ppic));
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
        function alarm_act(mode) {
            var link = 'http://127.0.0.1:5000/lampon';
            if (mode == 'off') {
                link = 'http://127.0.0.1:5000/lampoff';
            }else if(mode == 'urgent'){
                link = 'http://127.0.0.1:5000/urgent';
            }

            $.ajax({
                url: link,
                type: 'GET',
                dataType: 'jsonp',
            }).done(function (resp) {

                console.log(resp);
            });
        }

        function notifikasi(judul, sub, isi, ppic) {
            var kelas = 'bg-warning';
            if (ppic == 'Y') {
                alarm_act('urgent');
                kelas = 'bg-danger'
            }else{

                alarm_act('on');
            }
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000

            });
            $(document).Toasts('create', {
                class: kelas,
                title: judul,
                subtitle: sub,
                body: isi
            })


        }
    </script>

    @yield('script')
</body>

</html>