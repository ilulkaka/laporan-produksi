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
    <div class="col col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">HH/KY Dept Chart</h3>

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
                    style="min-height: 400px; height: 400px; max-height: 850px; max-width: 100%; display: block; width: 422px;"
                    width="750" height="250" class="chartjs-render-monitor"></canvas>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">HH/KY Type Chart</h3>

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


    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">HH/KY Level Chart</h3>

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
                <canvas id="chartpie2"
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

        var ctx2 = document.getElementById('chartpie2').getContext('2d');
        var chart2 = new Chart(ctx2, {
            type: 'bar',
            data2: {},
            options: {}
        });

        tampil_chart($("#tgl2").val(), chart, key);
        tampil_chart1($("#tgl2").val(), chart1, key);
        tampil_chart2($("#tgl2").val(), chart2, key);
        $("#btn_refresh").click(function () {
            tampil_chart($("#tgl2").val(), chart, key);
            tampil_chart1($("#tgl2").val(), chart1, key);
            tampil_chart2($("#tgl2").val(), chart2, key);
        });
    });

    function tampil_chart(per, chart, key) {
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();
        $.ajax({
            url: APP_URL + "/api/hse/grafikpie",
            method: "POST",
            data: { "tgl1": tgl1, "tgl2": tgl2 },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value1 = [];
                var value2 = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                for (var i in data) {
                    label.push(data[i].bagian);

                    value.push(data[i].HH);
                    value1.push(data[i].KY);
                    value2.push(data[i].SM);
                    coloR.push(dynamicColors());
                }

                chart.data = {
                    labels: label,
                    datasets: [
                        /*{
                            label: 'HK',
                            is3D: true,
                            backgroundColor: coloR,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBorderColor: 'rgba(200, 200 ,200, 1)',
                            data: value,
                        },
                        {
                            label: 'KY',
                            is3D: true,
                            backgroundColor: coloR,
                            borderColor: 'rgba(200, 200, 200, 0.75)',
                            hoverBorderColor: 'rgba(200, 200 ,200, 1)',
                            data: jl,
                        }*/
                        {
                            label: 'HH',
                            fill: true,
                            borderColor: 'rgb(46, 139, 87)',
                            backgroundColor: 'rgb(46, 139, 87)',
                            data: value,
                            type: 'bar'



                        },
                        {
                            label: 'KY',
                            fill: true,
                            borderColor: 'rgb(191, 0 ,0)',
                            backgroundColor: 'rgb(191, 0 ,0)',
                            data: value1,
                            type: 'bar'
                        },
                        {
                            label: 'Small Meeting',
                            fill: true,
                            borderColor: 'rgb(0,0,255)',
                            backgroundColor: 'rgb(0,0,255)',
                            data: value2,
                            type: 'bar'
                        }


                    ]
                };
                chart.options = {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                zeroLineWidth: 1
                            },
                            ticks: {
                                beginAtZero: true,
                                display: true
                            }
                        }]
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
            url: APP_URL + "/api/hse/grafikbar",
            method: "POST",
            data: { "tgl1": tgl1, "tgl2": tgl2 },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value1 = [];
                var valueAll = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                for (var i in data) {
                    label.push(data[i].jenis_laporan);

                    value.push(data[i].Open1);
                    value1.push(data[i].Close1);
                    valueAll.push(data[i].Alltotal);
                    coloR.push(dynamicColors());


                }



                chart1.data = {
                    labels: label,
                    datasets: [
                        {
                            label: 'Open',
                            fill: true,
                            borderColor: 'rgb(191, 0 ,0)',
                            backgroundColor: 'rgb(191, 0 ,0)',
                            data: value,
                            type: 'bar'



                        },
                        {
                            label: 'Close',
                            fill: true,
                            borderColor: 'rgb(46, 139, 87)',
                            backgroundColor: 'rgb(46, 139, 87)',
                            data: value1,
                            type: 'bar'
                        },
                        {
                            label: 'All',
                            fill: true,
                            borderColor: 'rgb(192, 192, 192)',
                            backgroundColor: 'rgb(192, 192, 192)',
                            data: valueAll,
                            type: 'bar'
                        },
                    ]
                };
                chart1.options = {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                zeroLineWidth: 1
                            },
                            ticks: {
                                beginAtZero: true,
                                display: true
                            }
                        }]
                    }

                };
                chart1.update();
            }

        });
    }

    function tampil_chart2(per, chart2, key) {
        var tgl1 = $('#tgl1').val();
        var tgl2 = $('#tgl2').val();
        $.ajax({
            url: APP_URL + "/api/hse/grafikbar2",
            method: "POST",
            data: { "tgl1": tgl1, "tgl2": tgl2 },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value1 = [];
                var value2 = [];
                var valueAll = [];
                var coloR = [];
                var dynamicColors = function () {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };

                for (var i in data) {
                    label.push(data[i].level_resiko);

                    value.push(data[i].Open1);
                    value1.push(data[i].Close1);
                    valueAll.push(data[i].Alltotal);
                    coloR.push(dynamicColors());
                }

                chart2.data = {
                    labels: label,
                    datasets: [
                        {
                            label: 'Open',
                            fill: true,
                            borderColor: 'rgb(191, 0 ,0)',
                            backgroundColor: 'rgb(191, 0 ,0)',
                            data: value,
                            type: 'bar'



                        },
                        {
                            label: 'Close',
                            fill: true,
                            borderColor: 'rgb(46, 139, 87)',
                            backgroundColor: 'rgb(46, 139, 87)',
                            data: value1,
                            type: 'bar'
                        },
                        {
                            label: 'All',
                            fill: true,
                            borderColor: 'rgb(192, 192, 192)',
                            backgroundColor: 'rgb(192, 192, 192)',
                            data: valueAll,
                            type: 'bar'
                        },
                    ]
                };
                chart2.options = {
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                zeroLineWidth: 1
                            },
                            ticks: {
                                beginAtZero: true,
                                display: true
                            }
                        }]
                    }

                };
                chart2.update();
            }

        });
    }

</script>
@endsection