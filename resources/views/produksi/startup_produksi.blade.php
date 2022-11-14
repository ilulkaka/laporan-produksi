@extends('produksi.templatemenu')

<style>
    img.center {
        display: block;
        margin: 0 auto;
    }

    h1 {
        border-style: solid;
        border-color: coral;
    }

    div.card-body {
        border-style: solid;
        border-color: coral;
    }
</style>

<body class="login-page" style="min-height: 512.391px;">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Kanri</b>NPMI</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body">
                <p class="login-box-msg" style="color: crimson;">Select to start your session</p>
                <hr style="margin-top: -10px;">
                <p></p>
                <form action="" method="post" id="formqr">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-mb-3"><label>Process Date</label></div>
                        <div class="col col-mb-8">
                            <input type="date" class="form-control" value="" name="tgl_proses" id="tgl_proses"
                                placeholder="Tanggal Kejadian" required>
                        </div>
                    </div>
                    <div class="form-group col-mb-3">
                        <select name="shift" id="shift" class="form-control" required>
                            <option value="">Select Shift</option>
                            <option value="SHIFT1">SHIFT 1</option>
                            <option value="SHIFT2">SHIFT 2</option>
                            <option value="SHIFT3">SHIFT 3</option>
                            <option value="NONSHIFT">NON SHIFT</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <!--<select name="line_proses" id="line_proses"
                            class="form-control select2 @error('line_proses') is-invalid @enderror" style="width: 100%;"
                            required>
                            <option value="">Select Line Proses</option>
                            @foreach($proses as $p)
                            <option value="{{$p->kode_line}}">{{$p->nama_line}}</option>
                            @endforeach
                        </select>-->
                        <div class="col col-mb-10">
                            <input type="search" class="form-control" value="" name="line_proses" id="line_proses"
                                placeholder="Please Scan your QR Code ." autocomplete="off" required>
                        </div>
                    </div>
                    <p style="color: blue; text-align: left; margin-top: -15px; font-size: smaller;">
                        <i> Pastikan
                            <b> Caps
                                Lock</b> dalam posisi <b style="color: crimson;">OFF</b></i>
                    </p>
                    <img src="{{asset('/assets/img/qr_code_1.png')}}"
                        style="heigh:300px;width:300px; margin-top: -10px;" alt="centered image" class="center">

                    <!--<div class="social-auth-links text-center mb-3">
                        <button type="button" class="btn btn-block btn-danger" id="btn_lokasi"><i
                                class="fas fa-thumbtack"></i> LOCATION</button>
                    </div>-->
                </form>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href=""></a>
                </p>
                <p class="mb-0">
                    <a href="" class="text-center"></a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>



</body>


@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {

        $('#line_proses').tooltip('disable');
        //loadingon();
        //var key = localStorage.getItem('npr_token');

        /*$("#line_proses").change(function () {
            var lok = $(this).children("option:selected").html();
            $("#btn_lokasi").html(lok);
        });*/

        $("#shift").change(function () {
            $("#line_proses").focus();
        });

        $("#formqr").submit(function (e) {
            e.preventDefault();

            var line = $("#line_proses").val();
            var shift = $("#shift").val();
            var tgl = $("#tgl_proses").val();

            if (shift == "" || tgl == "") {
                alert('Column can`t be empty !');
            } else {
                $.ajax({
                    url: APP_URL + '/api/gettoken',
                    type: 'POST',
                    data: { idname: 'IDproduksi', 'line': line },
                    dataType: 'json',
                })
                    .done(function (resp) {
                        if (resp.success) {
                            //console.log(resp.token);
                            localStorage.setItem('produksi_token', resp.token);
                            //console.log(resp.qline);
                            window.location.href = APP_URL + "/produksi/frm_report_produksi/" + tgl + "/" + resp.qline + "/" + shift;
                        } else {
                            alert(resp.message);
                            $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                        //toastr['warning']('Tidak dapat terhubung ke server !!!');
                    })

            }

        });

        /*$("#btn_lokasi").click(function () {
            var line = $("#line_proses").val();
            var shift = $("#shift").val();
            var tgl = $("#tgl_proses").val();

            if (line == "" || shift == "" || tgl == "") {
                alert('Column can`t be empty !');
            } else {
                $.ajax({
                    url: APP_URL + '/api/gettoken',
                    type: 'POST',
                    data: { idname: 'IDproduksi', 'line': line },
                    dataType: 'json',
                })
                    .done(function (resp) {
                        if (resp.success) {
                            //console.log(resp.token);
                            localStorage.setItem('produksi_token', resp.token);
                            //console.log(resp.qline);
                            window.location.href = APP_URL + "/produksi/frm_report_produksi/" + tgl + "/" + resp.qline + "/" + shift;
                        } else {
                            alert(resp.message);
                            $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                        //toastr['warning']('Tidak dapat terhubung ke server !!!');
                    })

            }
        }); */

    });

</script>
@endsection