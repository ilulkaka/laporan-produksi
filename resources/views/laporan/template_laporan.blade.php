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
                <div class="col-sm-6">
                    <h5>Date : {{date('d M Y')}}</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="row float-left">
                            <a href="#" id="btn_back" name="btn_back"><i class="fas fa-arrow-circle-left">
                                    Back</i></a>
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

    <div class="modal fade" id="modal-entryjamoperator" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Entry Jam Operator </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <h3><input type="text" style="border: none; color: blue;" id="operator" name="operator"
                                    disabled>
                            </h3>
                            <input type="hidden" id="shift" name="shift">
                            <input type="hidden" id="kode_line" name="kode_line">
                            <input type="hidden" id="nik" name="nik">
                            <input type="hidden" id="i_no_mesin" name="i_no_mesin">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Total Jam</label>
                            <input type="number" class="form-control" name="i_jam_total" id="i_jam_total" required>
                        </div>
                        <!-- <div class="form-group col-md-3">
                            <input type="hidden" id="i_jam_lain" name="i_jam_lain" class="form-control" required>
                        </div> -->
                        <div class="form-group col-md-8">
                            <label style="text-align: center; ">Tgl Proses</label>
                            <input type="date" id="tgl_proses" name="tgl_proses"
                                style="font-size: x-large; text-align: center; border: none; color: crimson;"
                                class="form-control" disabled>
                        </div>
                    </div>
                    <textarea class="form-control" name="i_keterangan" id="i_keterangan" cols="30" rows="4"
                        placeholder="Keterangan"></textarea>
                    @foreach ($line as $l)
                    @if($l == '51')
                    <hr>
                    <label>Pergantian Spare part .</label>
                    <div class="row">
                        <div class="form-group col-md-7">
                            <select name="i_item" id="i_item" class="form-control select2" style="width: 100%;"
                                required>
                                <option value="">Item ... </option>
                                @foreach ($item1 as $i)
                                <option value="{{$i->item}}">{{$i->item}} {{$i->spesifikasi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" class="form-control form-flat" name="i_qty" id="i_qty"
                                placeholder="Qty">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-outline-success btn-rounded"
                                data-mdb-ripple-color="dark">Add</button>
                        </div>
                    </div>

                    <table class="table table-bordered" id="tb_ng">
                        <thead>
                            <tr>
                                <th style="width: 250px">Item</th>
                                <th style="width: 75px">Qty</th>
                                <th style="width: 75px">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total :</th>
                                <th colspan="2" id="qty">Qty</th>
                            </tr>
                        </tfoot>
                    </table>

                    @endif
                    @endforeach

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" id="i_simpan" name="i_simpan" value="Simpan">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('/assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('/dist/js/adminlte.js')}}"></script>
    <script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>


    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/'))!!}
        $(document).ready(function () {
            /* $("#btn_back").click(function () {
                 window.history.back();
             }); */

            var segments = window.location.href.split('/');
            var difsegment = segments.reverse()
            var shift = difsegment[0];
            var kode_line = difsegment[1];
            var tgl_proses = difsegment[2];

            $("#btn_back").attr("href", APP_URL + "/produksi/frm_report_produksi/" + tgl_proses + '/' + kode_line + '/' + shift);


            var key = localStorage.getItem('produksi_token');


            $("#i_simpan").click(function () {
                var tgl_proses = $("#tgl_proses").val();
                var kode_line = $("#kode_line").val();
                var shift = $("#shift").val();
                var operator = $("#operator").val();
                var i_jam_total = $("#i_jam_total").val();
                var i_jam_lain = $("#i_jam_lain").val();
                var i_keterangan = $("#i_keterangan").val();
                var nik = $("#nik").val();
                var i_no_mesin = $("#i_no_mesin").val();

                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/laporan/entry_jam_operator",
                    headers: {
                        "token_req": key,
                    },
                    data: {
                        "nik": nik,
                        "operator": operator,
                        "i_jam_total": i_jam_total,
                        "i_jam_lain": i_jam_lain,
                        "i_keterangan": i_keterangan,
                        "kode_line": kode_line,
                        "shift": shift,
                        "tgl_proses": tgl_proses,
                        "i_no_mesin": i_no_mesin,
                    },
                    //data: datas,
                    async: false,
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert("Insert data success .")
                            window.location = window.location;
                            //workresult.ajax.reload();
                        } else {
                            alert(resp.message);
                            //location.reload();
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    });
            });

            $('#modal-entryjamoperator').on('shown.bs.modal', function () {
                $('#i_jam_total').focus();
            })

            $("#tb_laporan").on("click", ".jamoperator", function (e) {
                //alert('test');
                e.preventDefault();
                var nik = this.id;
                $("#nik").val(nik);
                var currentRow = $(this).closest("tr");
                var operator = currentRow.find("td:eq(0)").text(); // get current row 3rd TD
                $("#operator").val(operator);
                var no_mesin = currentRow.find("td:eq(1)").text(); // get current row 3rd TD
                $("#i_no_mesin").val(no_mesin);
                //console.log(currentRow);

                $("#shift").val(shift);

                $("#kode_line").val(kode_line);

                $("#tgl_proses").val(tgl_proses);


                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/produksi/get_jamkerja",
                    headers: { "token_req": key },
                    data: { 'nik': nik, 'kode_line': kode_line, 'tgl_proses': tgl_proses, 'shift': shift, 'no_mesin': no_mesin },
                    dataType: "json",
                })
                    .done(function (resp) {

                        $("#i_jam_total").val(resp.jam_total);
                        $("#i_keterangan").val(resp.ket);
                        $("#modal-entryjamoperator").modal("show");

                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });

            });

        });

    </script>



</body>

</html>
@yield('script')