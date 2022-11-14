@extends('layout.main')
@section('content')

<div class="row">
    <div class="col col-md-12">
        <div class="card card-secondary">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="row">
                    <input type="date" class="form-control col-md-2" id="tgl1" value="{{date('Y-m').'-01'}}">
                    <label for="" class="col-md-2 text-center">Sampai</label>
                    <input type="date" class="form-control col-md-2" id="tgl2" value="{{date('Y-m-d')}}">
                    <div class="col col-md-1 text-right"><label> Line</label></div>

                    <div class="col col-md-3">
                        <select name="selectline" id="selectline"
                            class="form-control select2 @error('selectline') is-invalid @enderror" style="width: 100%;"
                            required>
                            <option value="">Select Line</option>
                            @foreach($line as $l)
                            <option value="{{$l->kode_line}}">{{$l->nama_line}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary flat" id="btn_refresh"><i class="fa fa-sync"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Finish Qty</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
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
                <canvas id="chartpie"
                    style="min-height: 250px; height: 250px; max-height: 950px; max-width: 100%; display: block; width: 422px;"
                    width="422" height="250" class="chartjs-render-monitor"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pcs / Jam</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
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
                <canvas id="chartpie1"
                    style="min-height: 250px; height: 250px; max-height: 950px; max-width: 100%; display: block; width: 422px;"
                    width="422" height="250" class="chartjs-render-monitor"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 id="judul_grafik" class="card-title">Data</h3>

                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tb_hasil_produksi">
                    <thead>
                        <tr>
                            <th>Operator</th>
                            <th>Qty Finish</th>
                            <th>Jam Kerja</th>
                            <th>Pcs /Jam</th>
                            <th>Cycle Total</th>
                            <th>Cycle /Jam</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="1" style="text-align:center; font-size: large;">T O T A L</th>
                            <th style="text-align:center; font-size: large;"></th>
                            <th style="text-align:center; font-size: large;"></th>
                            <th style="text-align:center; font-size: large;"></th>
                            <th style="text-align:center; font-size: large;"></th>
                            <th style="text-align:center; font-size: large;"></th>

                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 id="judul_grafik_1" class="card-title">Data</h3>

                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tb_hasil_fcr">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>F-Mono</th>
                            <th>Cr</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="1" style="text-align:center; ">TOTAL</th>
                            <th style="text-align:center; font-size: large;"></th>
                            <th style="text-align:center; font-size: large;"></th>
                            <th style="text-align:center; font-size: large;"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });


    $(document).ready(function () {

        var key = localStorage.getItem('npr_token');
        var ctx = document.getElementById('chartpie').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {},
            options: {}
        });


        var ctx1 = document.getElementById('chartpie1').getContext('2d');
        var chart1 = new Chart(ctx1, {
            type: 'bar',
            data1: {},
            options: {}
        });

        var tgl_awal = $('#tgl1').val();
        var tgl_akhir = $('#tgl2').val();
        var selectline = $('#selectline').val();
        tampil_chart(tgl_awal, tgl_akhir, selectline, chart, key);
        tampil_chart1(tgl_awal, tgl_akhir, selectline, chart1, key);
        get_details(tgl_awal, tgl_akhir, selectline, key);
        get_fcr(tgl_awal, tgl_akhir, selectline, key);

        $("#btn_refresh").click(function () {
            var tgl_awal = $('#tgl1').val();
            var tgl_akhir = $('#tgl2').val();
            var selectline = $('#selectline').val();
            tampil_chart(tgl_awal, tgl_akhir, selectline, chart, key);
            tampil_chart1(tgl_awal, tgl_akhir, selectline, chart1, key);
            get_details(tgl_awal, tgl_akhir, selectline, key);
            get_fcr(tgl_awal, tgl_akhir, selectline, key);
        });

    });

    function tampil_chart(tgl_awal, tgl_akhir, selectline, chart, key) {
        $.ajax({
            url: APP_URL + "/api/grafik_hasil_operator",
            method: "POST",
            data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectline": selectline },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var operator = [];
                var value = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };


                for (var i in data.hasil_atari) {
                    operator.push(data.hasil_atari[i].operator);
                    value.push(data.hasil_atari[i].finish_qty);
                    coloR.push(dynamicColors());
                }

                chart.data = {
                    labels: operator,
                    datasets: [
                        {
                            label: 'Finish Qty',
                            backgroundColor: '#00D16A',
                            borderColor: 'rgb(51, 153, 255)',
                            data: value,
                            fill: true,
                        }
                    ]
                },


                    chart.options = {
                        onClick: function (c, i) {
                        },

                        tooltips: {
                            callbacks: {
                                title: function (tooltipItem, data) {
                                    return data['labels'][tooltipItem[0]['index']];
                                },
                                label: function (tooltipItem, data) {
                                    return 'Finish Qty : ' + tooltipItem.yLabel.toLocaleString("en-US") + ' Pcs';
                                }

                            },
                            label: 'Finish Qty',
                            backgroundColor: '#FFCCFF',
                            titleFontSize: 16,
                            titleFontColor: '#0066ff',
                            bodyFontColor: '#000',
                            bodyFontSize: 14,
                            displayColors: true
                        }

                    };
                chart.update();

            }

        });
    }

    function tampil_chart1(tgl_awal, tgl_akhir, selectline, chart1, key) {
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

    function get_details(tgl_awal, tgl_akhir, selectline, key) {
        var tb_hasil_produksi = $("#tb_hasil_produksi").DataTable({

            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/detail_hasil_jam_produksi',
                type: "POST",
                headers: { "token_req": key },
                data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectline": selectline },

            },
            /*columnDefs: [{

                targets: [0],
                visible: true,
                searchable: false
            },

            {
                targets: [4],
                data: null,

                render: function (data, type, row, meta) {
                    if (selectline == '70') {
                        var tothasil = (parseFloat(data.cycle));
                        return tothasil.toLocaleString("en-US");
                    } else {
                        
                        return 'test';
                    }
                }
            },
            ],*/

            columns: [
                { data: 'operator', name: 'operator' },
                { data: 'finish_qty', name: 'finish_qty', render: $.fn.dataTable.render.number(',', '.', 0, '') },
                { data: 'jam_total', name: 'jam_total', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                { data: 'pcsjam', name: 'pcsjam', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                { data: 'total_cycle', name: 'total_cycle', render: $.fn.dataTable.render.number(',', '.', 0, '') },
                { data: 'cyclejam', name: 'cyclejam', render: $.fn.dataTable.render.number(',', '.', 2, '') },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(1)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                Totalfinishqty = api
                    .column(1, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(1).footer()).html(
                    Totalfinishqty.toLocaleString("en-US")
                );

                TotalJam = api
                    .column(2, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                $(api.column(2).footer()).html(
                    TotalJam.toLocaleString("en-US")
                );

                Totalpcsjam = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                $(api.column(3).footer()).html(
                    Totalpcsjam.toLocaleString("en-US")
                );

                Totalcycle = api
                    .column(4, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                $(api.column(4).footer()).html(
                    Totalcycle.toLocaleString("en-US")
                );

                Totalcyclejam = api
                    .column(5, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                $(api.column(5).footer()).html(
                    Totalcyclejam.toLocaleString("en-US")
                );

            }

        });
    }

    function get_fcr(tgl_awal, tgl_akhir, selectline, key) {
        var tb_hasil_fcr = $("#tb_hasil_fcr").DataTable({

            destroy: true,
            processing: true,
            serverSide: true,
            searching: false,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/detail_hasil_fcr',
                type: "POST",
                headers: { "token_req": key },
                data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectline": selectline },

            },
            columnDefs: [{

                targets: [0],
                visible: true,
                searchable: false
            },

            {
                targets: [3],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var tothasil = (parseFloat(data.F) + parseFloat(data.CR));
                    return tothasil.toLocaleString("en-US");
                }
            },
            ],
            columns: [
                { data: 'type', name: 'type' },
                { data: 'F', name: 'F', render: $.fn.dataTable.render.number(',', '.', 0, '') },
                { data: 'CR', name: 'CR', render: $.fn.dataTable.render.number(',', '.', 2, '') },
                //{ data: 'pcsj', name: 'pcsj', render: $.fn.dataTable.render.number(',', '.', 2, '') },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column(1)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                Totalf = api
                    .column(1, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(1).footer()).html(
                    Totalf.toLocaleString("en-US")
                );

                Totalcr = api
                    .column(2, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                $(api.column(2).footer()).html(
                    Totalcr.toLocaleString("en-US")
                );

                Totalfcr = api
                    .column(3, { page: 'current' })
                    .data()
                    .reduce(function (a, b) {
                        return Totalf + Totalcr;
                    }, 0);
                $(api.column(3).footer()).html(
                    Totalfcr.toLocaleString("en-US")
                );

            }

        });
    }

</script>
@endsection