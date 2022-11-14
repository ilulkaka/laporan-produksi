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


                <div class="col col-sm-6">
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
                            <th>No.Meja</th>
                            <th>Comp F</th>
                            <th>Comp Cr</th>
                            <th>OIL F</th>
                            <th>OIL Cr</th>
                            <th class="jumlah">Total</th>
                            <th class="total">Jml Lot</th>
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

            <!--<div class="card-body">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Pcs / Jam</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="chartpie2"
                            style="min-height: 250px; height: 250px; max-height: 950px; max-width: 100%; display: block; width: 422px;"
                            width="422" height="250" class="chartjs-render-monitor"></canvas>
                    </div>
                    
                </div>
            </div> -->

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

    $(function () {

        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {
        var key = localStorage.getItem('produksi_token');

        /*  var ctx1 = document.getElementById('chartpie2').getContext('2d');
          var chart1 = new Chart(ctx1, {
              type: 'bar',
              data1: {},
              options: {}
          }); */

        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();
        var selectshift = $('#selectshift').val();
        var line = $('#line').val();
        load_table(tgl_awal, tgl_akhir, key, selectshift, line);



        $("#btn_reload").click(function () {
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
            var selectshift = $('#selectshift').val();
            //var line = $('#line').val();
            load_table(tgl_awal, tgl_akhir, key, selectshift, line);
            //tampil_chart1(tgl_awal, tgl_akhir, selectline);
        });

        /*        $("#tb_laporan").on("click", ".jamoperator", function (e) {
                    e.preventDefault();
                    var nik = this.id;
                    $("#nik").val(nik);
                    var currentRow = $(this).closest("tr");
                    var operator = currentRow.find("td:eq(0)").text(); // get current row 3rd TD
                    $("#operator").val(operator);
                    var jam = currentRow.find("td:eq(7)").text(); // get current row 3rd TD
                    $("#i_jam_total").val(jam);
                    //console.log(currentRow);
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
            url: APP_URL + "/api/laporan/get_lap_sozai",
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
                var jmllot = 0;
                var jamtotal = 0;
                var pcsjam = 0;
                var totpcsjam = 0;
                var totjamopr = 0;

                $("#tb_laporan tbody").empty();
                $("#tb_laporan tfoot").empty();


                for (var i in data.hasil_sozai) {
                    nik = (data.hasil_sozai[i].nik);
                    operator = (data.hasil_sozai[i].operator);
                    no_mesin = (data.hasil_sozai[i].no_mesin);
                    cf = (data.hasil_sozai[i].CompF);
                    ccr = (data.hasil_sozai[i].CompCr);
                    oif = (data.hasil_sozai[i].OILF);
                    oicr = (data.hasil_sozai[i].OILCr);
                    lot = (data.hasil_sozai[i].lot_no);
                    jamopr = (data.hasil_sozai[i].jam_total);
                    status = (data.hasil_sozai[i].status);

                    totcf = totcf + Number(cf)
                    totccr = totccr + Number(ccr)
                    totoif = totoif + Number(oif)
                    totoicr = totoicr + Number(oicr)
                    jmllot = jmllot + Number(lot)
                    total = Number(cf) + Number(ccr) + Number(oif) + Number(oicr)
                    grandtotal = grandtotal + total

                    if (status == "Approve") {
                        pcsjam = total / Number(jamopr)
                    } else {
                        pcsjam = 0
                    }

                    totjamopr = totjamopr + Number(jamopr)
                    totpcsjam = totpcsjam + pcsjam

                    var newrow = '<tr><td><a href="#" id="' + nik + '" class="jamoperator">' + operator + '</a></td><td><name="cf[]" value="/>' + no_mesin + '</td><td><name="cf[]" value="/>' + cf + '</td><td><name="ccr[]" value="/>' + ccr + '</td><td><name="oif[]" value="/>' + oif + '</td><td><name="oicr[]" value="/>' + oicr + '</td><td class="jumlah"><name="total[]" value="/>' + total + '</td><td class="total"><name="total[]" value="/>' + lot + '</td><td class=""><name="total[]" value="/>' + jamopr + '</td><td class=""><name="total[]" value="/>' + parseFloat(pcsjam).toLocaleString("en-US") + '</td></tr>';
                    $('#tb_laporan tbody').append(newrow);
                }

                $("#tb_laporan tfoot").append('<tr><th colspan="2">Total :</th><th>' + totcf.toLocaleString("en-US") + '</th><th>' + totccr.toLocaleString("en-US") + '</th><th>' + totoif.toLocaleString("en-US") + '</th><th>' + totoicr.toLocaleString("en-US") + '</th><th class="jumlah">' + grandtotal.toLocaleString("en-US") + '</th><th class="total">' + jmllot.toLocaleString("en-US") + '</th><th class="">' + totjamopr.toLocaleString("en-US") + '</th><th class="">' + parseFloat(totpcsjam).toLocaleString("en-US") + '</th></tr>')
            }

        });
    }

    /*function tampil_chart1(tgl_awal, tgl_akhir, selectline) {
        //var tgl_awal = $('#tgl1').val();
        //var tgl_akhir = $('#tgl2').val();
        //;var selectline = $("#selectline").val();
        $.ajax({
            url: APP_URL + "/api/grafik_hasil_operator",
            method: "POST",
            data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectline": selectline },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var v_finish_qty = [];
                var v_jam_total = [];
                var v_pcsjam = [];
                var v_cyclejam = [];
                var coloR = [];
                var jam_total = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                for (var i in data.hasil_atari) {
                    label.push(data.hasil_atari[i].operator);
                    v_finish_qty.push(data.hasil_atari[i].finish_qty);
                    v_jam_total.push(data.hasil_atari[i].jam_total);

                    if (selectline == '70') {
                        v_cyclejam.push(data.hasil_atari[i].cyclejam);
                    } else {
                        v_pcsjam.push(data.hasil_atari[i].pcsjam);
                    }
                    coloR.push(dynamicColors());

                    qty_fg = data.hasil_atari[i].finish_qty;
                    jam_total = data.hasil_atari[i].jam_total;

                }

                if (selectline == '70') {
                    chart1.data = {
                        labels: label,
                        datasets: [
                            {
                                yAxisID: 'B',
                                label: 'Jam Kerja',
                                fill: true,
                                borderColor: 'rgb(255, 153, 51)',
                                pointBorderWidth: 10,
                                lineTension: 0.2,
                                data: v_jam_total,
                                type: 'line',
                                position: 'right',
                            },
                            {
                                yAxisID: 'A',
                                label: 'Cycle/Jam',
                                is3D: true,
                                //backgroundColor: coloR,
                                backgroundColor: 'rgb(51, 153, 255)',
                                borderColor: 'rgb(51, 153, 255)',
                                data: v_cyclejam,
                                position: 'left',

                            }


                        ]
                    };

                } else {
                    chart1.data = {
                        labels: label,
                        datasets: [
                            {
                                yAxisID: 'B',
                                label: 'Jam Kerja',
                                fill: true,
                                borderColor: 'rgb(255, 153, 51)',
                                pointBorderWidth: 10,
                                lineTension: 0.2,
                                data: v_jam_total,
                                type: 'line',
                                position: 'right',
                            },
                            {
                                yAxisID: 'A',
                                label: 'Pcs/Jam',
                                is3D: true,
                                //backgroundColor: coloR,
                                backgroundColor: 'rgb(51, 153, 255)',
                                borderColor: 'rgb(51, 153, 255)',
                                data: v_pcsjam,
                                position: 'left',

                            }


                        ]
                    };
                }

                chart1.options = {
                    tooltips: {
                        callbacks: {
                            title: function (tooltipItem, data) {
                                return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function (tooltipItem, data) {
                                return tooltipItem.yLabel.toLocaleString("en-US");
                            }

                        },
                        backgroundColor: '#FFF',
                        titleFontSize: 16,
                        titleFontColor: '#0066ff',
                        bodyFontColor: '#000',
                        bodyFontSize: 14,
                        displayColors: true
                    },

                    scales: {
                        yAxes: [
                            {
                                id: 'A',
                                type: 'linear',
                                position: 'left',
                                beginAtZero: true,
                            },
                            {
                                id: 'B',
                                type: 'linear',
                                position: 'right',
                                beginAtZero: true,
                                min: 0,
                            },
                        ]

                    },

                    onClick: function (c, i) {

                    }
                };
                chart1.update();
            }

        });
    }
    */


</script>
@endsection