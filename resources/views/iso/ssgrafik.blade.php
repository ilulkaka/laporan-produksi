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
                <div class="row align-center">
                    <input type="date" class="form-control col-md-2" id="tgl1" value="{{date('Y-m').'-01'}}">
                    <label for="" class="col-md-2 text-center">Sampai</label>
                    <input type="date" class="form-control col-md-2" id="tgl2" value="{{date('Y-m-d')}}">
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
                <h3 class="card-title">SS Dept Chart</h3>

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
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 422px;"
                    width="422" height="250" class="chartjs-render-monitor"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">SS Status Chart</h3>

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
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 422px;"
                    width="422" height="250" class="chartjs-render-monitor"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script type="text/javascript">
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

        tampil_chart($("#tgl2").val(), chart, key);
        tampil_chart1($("#tgl2").val(), chart1, key);
        $("#btn_refresh").click(function () {
            tampil_chart($("#tgl2").val(), chart, key);
            tampil_chart1($("#tgl2").val(), chart1, key);
        });
    });

    function tampil_chart(per, chart, key) {
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();
        $.ajax({
            url: APP_URL + "/api/iso/grafikpie",
            method: "POST",
            data: { "tgl1": tgl1, "tgl2": tgl2 },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value1 = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                for (var i in data) {
                    label.push(data[i].departemen);
                    value.push(data[i].count);
                    value1.push(data[i].count_nik);
                    coloR.push(dynamicColors());
                }

                chart.data = {
                    labels: label,
                    datasets: [
                            {
                                yAxisID: 'B',
                                label: 'Orang',
                                fill: true,
                                borderColor: 'rgb(255, 153, 51)',
                                pointBorderWidth: 10,
                                lineTension: 0.2,
                                data: value1,
                                type: 'line',
                                position: 'right',
                            },
                            {
                                yAxisID: 'A',
                                label: 'Total SS',
                                is3D: true,
                                //backgroundColor: coloR,
                                backgroundColor: 'rgb(51, 153, 255)',
                                borderColor: 'rgb(51, 153, 255)',
                                data: value,
                                position: 'left',

                            }
                        ]
                };
                chart.options = {
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
                chart.update();
            }

        });
    }

    function tampil_chart1(per, chart1, key) {
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();
        $.ajax({
            url: APP_URL + "/api/iso/grafikbar",
            method: "POST",
            data: { "tgl1": tgl1, "tgl2": tgl2 },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                for (var i in data) {
                    label.push(data[i].status_ss);
                    value.push(data[i].count);
                    coloR.push(dynamicColors());
                }

                chart1.data = {
                    labels: label,
                    datasets: [
                        {
                            label: '',
                            is3D: true,
                            backgroundColor: coloR,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBorderColor: 'rgba(200, 200 ,200, 1)',
                            data: value,
                        }

                    ]
                };
                chart1.options = {

                    onClick: function (c, i) {

                    }
                };
                chart1.update();
            }

        });
    }

</script>
@endsection