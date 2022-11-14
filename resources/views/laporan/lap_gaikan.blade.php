@extends('laporan.template_laporan')
@section('head')

<link rel="stylesheet" href="{{asset('/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endsection
@section('content')

<style>
    .total {
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
                <h3 class="p-2 mb-2 bg-success text-white">Laporan Hasil Proses {{$line->nama_line}}</h3>
                <input type="hidden" id="line" name="line" value="{{$line->kode_line}}">
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
                            <th>Comp F</th>
                            <th>Comp Cr</th>
                            <th>OIL F</th>
                            <th>OIL Cr</th>
                            <th class="jumlah">Total</th>
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

            /*           $("#tb_laporan_gaikan").on("click", ".jamoperator", function (e) {
                           e.preventDefault();
                           var nik = this.id;
                           $("#nik").val(nik);
                           var currentRow = $(this).closest("tr");
                           var col1 = currentRow.find("td:eq(0)").text(); // get current row 3rd TD
                           $("#operator").val(col1);
                           var jam = currentRow.find("td:eq(6)").text(); // get current row 3rd TD
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
                url: APP_URL + "/api/laporan/get_lap_gaikan",
                method: "POST",
                data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectshift": selectshift, "line": line },
                dataType: "json",
                headers: { "token_req": key },
                success: function (data) {
                    var label = [];
                    var value = [];
                    var value2 = [];
                    var totcf = 0;
                    var totccr = 0;
                    var totoif = 0;
                    var totoicr = 0;
                    var total = 0;
                    var grandtotal = 0;

                    var jamtotal = 0;
                    var pcsjam = 0;
                    var totpcsjam = 0;
                    var totjamopr = 0;

                    $("#tb_laporan tbody").empty();
                    $("#tb_laporan tfoot").empty();


                    for (var i in data.hasil_gaikan) {
                        nik = (data.hasil_gaikan[i].nik);
                        operator = (data.hasil_gaikan[i].operator);
                        cf = (data.hasil_gaikan[i].CompF);
                        ccr = (data.hasil_gaikan[i].CompCr);
                        oif = (data.hasil_gaikan[i].OILF);
                        oicr = (data.hasil_gaikan[i].OILCr);
                        jamopr = (data.hasil_gaikan[i].jam_total);
                        status = (data.hasil_gaikan[i].status);

                        totcf = totcf + Number(cf)
                        totccr = totccr + Number(ccr)
                        totoif = totoif + Number(oif)
                        totoicr = totoicr + Number(oicr)
                        total = Number(cf) + Number(ccr) + Number(oif) + Number(oicr)
                        grandtotal = grandtotal + total

                        if (status == "Approve") {
                            pcsjam = total / Number(jamopr)
                        } else {
                            pcsjam = 0
                        }

                        totjamopr = totjamopr + Number(jamopr)
                        totpcsjam = totpcsjam + pcsjam

                        var newrow = '<tr><td><a href="#" id="' + nik + '" class="jamoperator">' + operator + '</td><td><name="cf[]" value="/>' + cf + '</td><td><name="ccr[]" value="/>' + ccr + '</td><td><name="oif[]" value="/>' + oif + '</td><td><name="oicr[]" value="/>' + oicr + '</td><td class="jumlah"><name="total[]" >' + total + '</td><td class=""><name="total[]" value="/>' + jamopr + '</td><td class=""><name="total[]" value="/>' + parseFloat(pcsjam).toLocaleString("en-US") + '</td></tr>';
                        $('#tb_laporan tbody').append(newrow);
                    }

                    $("#tb_laporan tfoot").append('<tr><th colspan="1">Total :</th><th>' + totcf.toLocaleString("en-US") + '</th><th>' + totccr.toLocaleString("en-US") + '</th><th>' + totoif.toLocaleString("en-US") + '</th><th>' + totoicr.toLocaleString("en-US") + '</th><th class="jumlah">' + grandtotal.toLocaleString("en-US") + '</th><th class="">' + totjamopr.toLocaleString("en-US") + '</th><th class="">' + parseFloat(totpcsjam).toLocaleString("en-US") + '</th></tr>')
                }

            });
        }


    </script>
    @endsection