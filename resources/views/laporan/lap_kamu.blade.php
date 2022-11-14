@extends('laporan.template_laporan')
@section('head')

<link rel="stylesheet" href="{{asset('/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')

<style>
    .status {
        color: red;
    }

    .jumlah {
        color: blue;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="card card-success">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="card-title" style="font-size:x-large">Laporan Hasil Proses
                                    {{$line->nama_line}}</h3>
                                <input type="hidden" id="line" name="line" value="{{$line->kode_line}}">
                                <span class="float-right">
                                    <button class="btn btn-sm" id="btn-entryjamoperator">
                                        <font color="white"><i class="far fa-clock mr-1"></i>
                                            <i style="font-size: small;"> Klik Nama Operator untuk input jam kerja .
                                            </i>
                                        </font>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-tools">

                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-2">
                        <input type="date" class="form-control" id="tgl_awal" value="{{date('Y-m-d')}}">
                    </div>
                    <label for="" class="col-md-1 text-center">Sampai</label>
                    <div class="col col-md-2">
                        <input type="date" class="form-control " id="tgl_akhir" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col col-md-1 text-right"><label> Shift</label></div>

                    <div class="col col-md-2">
                        <select name="selectshift" id="selectshift"
                            class="form-control select2 @error('shift') is-invalid @enderror" style="width: 100%;"
                            value="{{$shift}}" required>
                            <option value="All" @if($shift=="All" ) {{"selected"}}@endif>All</option>
                            <option value="SHIFT1" @if($shift=="SHIFT1" ) {{"selected"}}@endif>SHIFT 1</option>
                            <option value="SHIFT2" @if($shift=="SHIFT2" ) {{"selected"}}@endif>SHIFT 2</option>
                            <option value="SHIFT3" @if($shift=="SHIFT3" ) {{"selected"}}@endif>SHIFT 3</option>
                            <option value="NONSHIFT" @if($shift=="NONSHIFT" ) {{"selected"}}@endif>NON SHIFT </option>
                        </select>
                    </div>
                    <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
                </div>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="tb_laporan">
                    <thead>
                        <tr>
                            <th>OPERATOR</th>
                            <th>No Mesin</th>
                            <th style="background-color:rgb(51, 204, 255)">BIRU</th>
                            <th>PUTIH</th>
                            <th style="background-color: rgb(255, 255, 102)">KUNING</th>
                            <th style="background-color: rgb(255, 153, 204)">PINK</th>
                            <th style="background-color: rgb(204, 153, 255)">PINK-U</th>
                            <th style="background-color: rgb(153, 255, 102)">Hijau Naishu</th>
                            <th style="background-color: rgb(26, 255, 178)">Hijau Reguler</th>
                            <th style="background-color: rgb(204, 255, 51)">Hijau Uchicatto</th>
                            <th>Lain</th>
                            <th>Total</th>
                            <th class="status">Lot</th>
                            <th class="status">Cycle</th>
                            <th>Jam Kerja</th>
                            <th>Pcs/Jam</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                    <tfoot>

                    </tfoot>
                </table>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="tb_laporan_dandoriman">
                    <thead>
                        <tr>
                            <th>Dandoriman</th>
                            <th>None</th>
                            <th>SEMI</th>
                            <th>FULL</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                    <tfoot>

                    </tfoot>
                </table>
            </div>


        </div>
    </div>

    @endsection

    @section('script')
    <!-- Select2 -->
    <script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var key = localStorage.getItem('produksi_token');
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
            var selectshift = $('#selectshift').val();
            var line = $('#line').val();
            load_table(tgl_awal, tgl_akhir, key, selectshift, line);


            $("#btn_reload").click(function () {
                var tgl_awal = $('#tgl_awal').val();
                var tgl_akhir = $('#tgl_akhir').val();
                var selectshift = $('#selectshift').val();
                var line = $('#line').val();
                load_table(tgl_awal, tgl_akhir, key, selectshift, line);
            });

            /*            $("#tb_laporan_kamu").on("click", ".jamoperator", function (e) {
                            e.preventDefault();
                            var nik = this.id;
                            $("#nik").val(nik);
                            var currentRow = $(this).closest("tr");
                            var col1 = currentRow.find("td:eq(0)").text(); // get current row 3rd TD
                            $("#operator").val(col1);
                            var jam = currentRow.find("td:eq(14)").text(); // get current row 3rd TD
                            $("#i_jam_total").val(jam);
                            var segments = window.location.href.split('/');
                            var difsegment = segments.reverse()
                            var shift = difsegment[0];
                            $("#shift").val(shift);
                            var kode_line = difsegment[1];
                            $("#kode_line").val(kode_line);
                            var tgl_proses = difsegment[2];
                            $("#tgl_proses").val(tgl_proses);
            
                            $("#modal-entryjamoperator").modal("show");
                        });
            */

        });


        function load_table(tgl_awal, tgl_akhir, key, selectshift, line) {
            $.ajax({
                url: APP_URL + "/api/laporan/get_lap_kamu",
                method: "POST",
                data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectshift": selectshift, "line": line },
                dataType: "json",
                headers: { "token_req": key },
                success: function (data) {
                    var totp = 0;
                    var totb = 0;
                    var totk = 0;
                    var totpi = 0;
                    var totpiu = 0;
                    var tothn = 0;
                    var tothr = 0;
                    var tothu = 0;
                    var totlain = 0;
                    var totlot = 0;
                    var totcycle = 0;
                    var jml = 0;
                    var grandtotal = 0;

                    var fb = 0;
                    var fp = 0;
                    var fk = 0;
                    var fpi = 0;
                    var fpiu = 0;
                    var fhn = 0;
                    var fhr = 0;
                    var fhu = 0;
                    var flain = 0;

                    var jamtotal = 0;
                    var pcsjam = 0;
                    var totpcsjam = 0;
                    var totjamopr = 0;

                    $("#tb_laporan tbody").empty();
                    $("#tb_laporan tfoot").empty();


                    var totn = 0;
                    var tots = 0;
                    var totf = 0;
                    var jml = 0;
                    var grandtotal = 0;
                    $("#tb_laporan_dandoriman tbody").empty();
                    $("#tb_laporan_dandoriman tfoot").empty();




                    for (var i in data.hasil_kamu) {
                        nik = (data.hasil_kamu[i].nik);
                        operator = (data.hasil_kamu[i].operator);
                        no_mesin = (data.hasil_kamu[i].no_mesin);
                        b = (data.hasil_kamu[i].BIRU);
                        p = (data.hasil_kamu[i].PUTIH);
                        k = (data.hasil_kamu[i].KUNING);
                        pi = (data.hasil_kamu[i].PINK);
                        piu = (data.hasil_kamu[i].PinkU);
                        hn = (data.hasil_kamu[i].HijauNaishu);
                        hr = (data.hasil_kamu[i].HijauReguler);
                        hu = (data.hasil_kamu[i].HijauUchicatto);
                        lain = (data.hasil_kamu[i].Lain);
                        lot = (data.hasil_kamu[i].lot_no);
                        cycle = (data.hasil_kamu[i].total_cycle);
                        jamopr = (data.hasil_kamu[i].jam_total);
                        status = (data.hasil_kamu[i].status);

                        totb = Number(b)
                        totp = Number(p)
                        totk = Number(k)
                        totpi = Number(pi)
                        totpiu = Number(piu)
                        tothn = Number(hn)
                        tothr = Number(hr)
                        tothu = Number(hu)
                        totlain = Number(lain)
                        totlot = totlot + Number(lot)
                        totcycle = totcycle + Number(cycle)
                        jml = Number(b) + Number(p) + Number(k) + Number(totpi) + Number(piu) + Number(hn) + Number(hr) + Number(hu) + Number(lain)
                        grandtotal = grandtotal + jml

                        if (status == "Approve") {
                            pcsjam = jml / Number(jamopr)
                        } else {
                            pcsjam = 0
                        }

                        totjamopr = totjamopr + Number(jamopr)
                        totpcsjam = totpcsjam + pcsjam

                        var newrow = '<tr><td><a href="#" id="' + nik + '" class="jamoperator">' + operator + '</td><td><name="no_mesin[]" value="/>' + no_mesin + '</td><td><name="b[]" value="/>' + b + '</td><td><name="p[]" value="/>' + p + '</td><td><name="k[]" value="/>' + k + '</td><td><name="pi[]" value="/>' + pi + '</td><td><name="piu[]" value="/>' + piu + '</td><td><name="hn[]" value="/>' + hn + '</td><td><name="hr[]" value="/>' + hr + '</td><td><name="hu[]" value="/>' + hu + '</td><td><name="lain[]" value="/>' + lain + '</td><td class="jumlah"><name="jml[]" value="/>' + jml + '</td><td class="status"><name="lot_no[]" value="/>' + lot + '</td><td class="status"><name="cycle[]" value="/>' + cycle + '</td><td class=""><name="total[]" value="/>' + jamopr + '</td><td class=""><name="total[]" value="/>' + parseFloat(pcsjam).toLocaleString("en-US") + '</td></tr>';
                        $('#tb_laporan tbody').append(newrow);

                        fb = fb + totb;
                        fp = fp + totp;
                        fk = fk + totk;
                        fpi = fpi + totpi;
                        fpiu = fpiu + totpiu;
                        fhn = fhn + tothn;
                        fhr = fhr + tothr;
                        fhu = fhu + tothu;
                        flain = flain + totlain;
                    }

                    $("#tb_laporan tfoot").append('<tr><th colspan="2">Total :</th><th>' + fb.toLocaleString("en-US") + '</th><th>' + fp.toLocaleString("en-US") + '</th><th>' + fk.toLocaleString("en-US") + '</th><th>' + fpi.toLocaleString("en-US") + '</th><th>' + fpiu.toLocaleString("en-US") + '</th><th>' + fhn.toLocaleString("en-US") + '</th><th>' + fhr.toLocaleString("en-US") + '</th><th>' + fhu.toLocaleString("en-US") + '</th><th>' + flain.toLocaleString("en-US") + '</th><th class="jumlah">' + grandtotal.toLocaleString("en-US") + '</th><th class="status">' + totlot.toLocaleString("en-US") + '</th><th class="status">' + totcycle.toLocaleString("en-US") + '</th><th class="">' + totjamopr.toLocaleString("en-US") + '</th><th class="">' + parseFloat(totpcsjam).toLocaleString("en-US") + '</th></tr>')

                    for (var i in data.hasil_dandoriman) {
                        dandoriman = (data.hasil_dandoriman[i].dandoriman);
                        n = (data.hasil_dandoriman[i].kosong);
                        s = (data.hasil_dandoriman[i].separuh);
                        f = (data.hasil_dandoriman[i].penuh);

                        totn = totn + Number(n)
                        tots = tots + Number(s)
                        totf = totf + Number(f)

                        var newrow = '<tr><td><name="dandoriman[]" value="/>' + dandoriman + '</td><td><name="no_mesin[]" value="/>' + n + '</td><td><name="b[]" value="/>' + s + '</td><td><name="p[]" value="/>' + f + '</td></tr>';
                        $('#tb_laporan_dandoriman tbody').append(newrow);

                    }

                    $("#tb_laporan_dandoriman tfoot").append('<tr><th colspan="1">Total :</th><th>' + totn.toLocaleString("en-US") + '</th><th>' + tots.toLocaleString("en-US") + '</th><th>' + totf.toLocaleString("en-US") + '</th></tr>')


                }


            });
        }

    </script>
    @endsection