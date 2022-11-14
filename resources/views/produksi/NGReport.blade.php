@extends('layout.main')
@section('content')

<head>

    <style>
        .tengah {
            text-align: center;
        }

        .kiri {
            text-align: left;
        }

        .kanan {
            text-align: right;
        }

        .eloading {
            position: fixed;
            /* Sit on top of the page content */
            display: none;
            /* Hidden by default */
            width: 100%;
            /* Full width (cover the whole page) */
            height: 100%;
            /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Black background with opacity */
            z-index: 2;
            /* Specify a stack order in case you're using a different order for other elements */
            cursor: pointer;
            /* Add a pointer on hover */
        }

        .spiner {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }
    </style>
</head>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Success Rate by Type</h3>

                </div>

            </div>
            <div class="card-body">


                <div class="position-relative mb-4">

                    <canvas id="type_mn" height="400" style="display: block; width: 723px; height: 400px;" width="723"
                        class="chartjs-render-monitor"></canvas>
                </div>


            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Success Rate by Material</h3>

                </div>

            </div>
            <div class="card-body">


                <div class="position-relative mb-4">

                    <canvas id="material_mn" height="400" style="display: block; width: 723px; height: 400px;"
                        width="723" class="chartjs-render-monitor"></canvas>
                </div>


            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">

                <div class="card card-secondary">
                    <div class="card-header">
                        <div class="col-6">
                            <h3 class="card-title">Success Rate</h3>
                        </div>
                    </div>
                    <div class="card-tools">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="tanggalawal">Tanggal Awal</label>
                        <input type="date" class="form-control" value="{{date('Y-m').'-01'}}" name="tanggalawal"
                            id="tanggalawal" placeholder="Tanggal ditemukan" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tanggalakhir">Tanggal Akhir</label>
                        <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="tanggalakhir"
                            id="tanggalakhir" placeholder="Tanggal ditemukan" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="prosesawal">Proses Awal</label>
                        <select name="v_name" id="prosesawal" class="form-control" style="width: 100%;" required>
                            <option value="10">Furnace</option>
                            @foreach($location as $value=>$i)
                            <option value="{{$i->line_proses}}" @if($i->line_proses == '10')
                                {{'selected'}}@endif>{{$i->nama_line}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prosesakhir">Proses Akhir</label>
                        <select name="v_name" id="prosesakhir" class="form-control" style="width: 100%;" required>

                            @foreach($location as $i)
                            <option value="{{$i->line_proses}}" @if($i->line_proses == '320')
                                {{'selected'}}@endif>{{$i->nama_line}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="btn btn-success" id="btn-letsgo">Run</button>

            </div>
        </div>



    </div>


    <div class="col-md-8">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="far fa-heart"></i></span>

            <div class="info-box-content">

                <dl class="row align-items-center">
                    <dt class="col-md-4">
                        <h4>Success Rate All</h4>
                        <h3 id="successrate">0 %</h3>
                    </dt>
                    <div class="col-md-8">


                        <div class="info-box bg-warning">

                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                            <div class="info-box-content col-md-12">
                                <dl class="row">
                                    <dt class="col-sm-4">


                                        <a href="" class="srate" id="comp-f">
                                            <h4>Comp F</h4>
                                        </a>
                                    </dt>
                                    <dd class="col-sm-4">

                                        <h3 id="compf">0 %</h3>
                                    </dd>

                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">

                                        <a href="" class="srate" id="comp-cr">
                                            <h4>Comp Cr</h4>
                                        </a>
                                    </dt>
                                    <dd class="col-sm-4">

                                        <h3 id="compcr">0 %</h3>
                                    </dd>
                                </dl>

                            </div>



                        </div>

                        <div class="info-box" style="background-color: beige">
                            <span class="info-box-icon" style="color: black"><i class="fas fa-tag"></i></span>

                            <div class="info-box-content">
                                <dl class="row">
                                    <dt class="col-sm-4">

                                        <a href="" class="srate" id="oil-f">
                                            <h4>OIL F</h4>
                                        </a>
                                    </dt>
                                    <dd class="col-sm-4">

                                        <h3 id="oilf" style="color: black">0 %</h3>
                                    </dd>

                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">

                                        <a href="" class="srate" id="oil-cr">
                                            <h4>OIL Cr</h4>
                                        </a>
                                    </dt>
                                    <dd class="col-sm-4">

                                        <h3 id="oilcr" style="color: black">0 %</h3>
                                    </dd>
                                </dl>
                            </div>
                        </div>


                    </div>
                </dl>


            </div>
        </div>
    </div>



</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Monitoring NG</h3>
                    <button class="btn btn-outline-info" id="btn_conf"><i class="fa fa-cog"></i></button>
                </div>

            </div>
            <div class="card-body">


                <div class="position-relative mb-4">

                    <canvas id="monitoring_ng" height="400" style="display: block; width: 723px; height: 400px;"
                        width="723" class="chartjs-render-monitor"></canvas>
                </div>


            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">TOP 10 NG</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="tb_ng">
                    <thead>
                        <tr>
                            <th style="width: 40px">No. </th>
                            <th>Jenis NG</th>

                            <th style="width: 40px">Qty</th>
                            <th style="width: 60px">Persentase</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyNG">

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">TOP 10 Successrate ter rendah</h3>
            </div>
            <div class="card-body">
                <table class="table table-hover text-nowrap" id="tb_peritem">
                    <thead>
                        <tr>

                            <th>No.</th>
                            <th>Part No</th>
                            <th>Lot No</th>
                            <th>Start Qty</th>
                            <th>Finish Qty</th>
                            <th>Success Rate</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyItem">

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>


    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 id="judul_grafik" class="card-title">Grafik NG</h3>

                </div>

            </div>
            <div class="card-body">


                <div class="position-relative mb-4">

                    <canvas id="ng-chart" height="400" style="display: block; width: 723px; height: 800px;" width="723"
                        class="chartjs-render-monitor"></canvas>
                </div>


            </div>
        </div>
    </div>
</div>
<div class="row">

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Success Rate Gaikan Kensa</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">

                    <table class="table table-bordered" id="tb_kensa">
                        <thead>
                            <tr>

                                <th>Process</th>

                                <th style="text-align:center;">Qty</th>
                                <th>Lot</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Production</td>
                                <td id="j_pro" style="text-align:center;">0</td>
                                <td rowspan="4" style="vertical-align : middle;text-align:center;" id="j_lot">0</td>
                            </tr>
                            <tr>
                                <td>CAMU Qty</td>
                                <td id="j_camu" style="text-align:center;">0</td>

                            </tr>
                            <tr>
                                <td>Incoming Kensa</td>
                                <td id="j_inc" style="text-align:center;">0</td>

                            </tr>
                            <tr>
                                <td>Finish Kensa</td>
                                <td id="j_finish" style="text-align:center;">0</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">

                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th>Process</th>

                                <th>Success Rate</th>
                                <th>NG</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Zoukei - CAMU</td>
                                <td id="z-c">0</td>
                                <td id="n_z-c">0</td>
                            </tr>
                            <tr>
                                <td>CAMU - Kensa</td>
                                <td id="c-k">0</td>
                                <td id="n_c-k">0</td>
                            </tr>
                            <tr>
                                <td>Kensa - FG</td>
                                <td id="k-f">0</td>
                                <td id="n_k-f">0</td>
                            </tr>
                            <tr>
                                <td>CAMU - FG</td>
                                <td id="c-f">0</td>
                                <td id="n_c-f">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl" id="mdgroup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="GroupTitle">Type NG list</h5>
            </div>
            <div class="modal-body">

                <div class="position-relative mb-4">

                    <canvas id="chart_group" height="400" style="display: block; width: 723px; height: 800px;"
                        width="723" class="chartjs-render-monitor"></canvas>
                </div>
                <div class="row">
                    <div id="accordion">

                        <div class="card">

                            <div id="collapseOne" class="panel-collapse in collapse" style="">
                                <div class="card-body">
                                    <table id="tb_item"
                                        class="table table-bordered table-striped text-nowrap dataTable">
                                        <thead>
                                            <th>id</th>
                                            <th>Part Number</th>
                                            <th>Lot No</th>
                                            <th>Proses</th>
                                            <th>Operator</th>
                                            <th>No Mesin</th>
                                            <th>Tgl Proses</th>
                                            <th>NG Qty</th>
                                            <th>Persentase</th>
                                            <th>NG Name</th>

                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_close">Close</button>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal_config" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Setting Parameter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="frm_setting">
                    <div class="form-row">
                        <div class="form-group col-md-2"><label>Line :</label></div>
                        <div class="form-group col-md-6">
                            <select name="kode_line" id="kode_line" class="form-control" data-placeholder="Pilih Line"
                                style="width: 100%;">
                                <option value="">---Line---</option>
                                @foreach($location as $value=>$i)
                                <option value="{{$i->line_proses}}">{{$i->nama_line}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2"><label>Periode :</label></div>
                        <div class="form-group col-md-6">
                            <select name="periode" id="periode" class="form-control" data-placeholder="Pilih periode"
                                style="width: 100%;">
                                <option value="">---periode---</option>
                                <option value="dayly">Dayly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2"><label>Jenis NG :</label></div>
                        <div class="form-group col-md-6">
                            <select name="" id="jenis_ng" class="form-control select2" data-placeholder="Pilih NG"
                                style="width: 100%;">
                                <option value="">---pilih NG---</option>
                                @foreach($jenis_ng as $o)
                                <option value="{{$o->kode_ng}}">{{$o->type_ng}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <table class="table table-bordered" id="tb_jenis">
                            <thead>
                                <tr>
                                    <th>Jenis NG</th>
                                    <th style="width: 20px">Hapus</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div id="loadingscreen" class="eloading">
    <div id="text" class="spiner"><i class="fas fa-2x fa-sync fa-spin"></i></div>
</div>

@endsection

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        var key = localStorage.getItem('npr_token');
        $(function(){
            $(".select2").select2({
                theme:'bootstrap4'
            });
        });
        var itemDel = [];
        var tgl1 = $("#tanggalawal").val();
        var tgl2 = $("#tanggalakhir").val();
        var proses1 = $("#prosesawal").val();
        var proses2 = $("#prosesakhir").val();
        var x = {
            tanggalawal : tgl1,
            tanggalakhir : tgl2,
            prosesawal : proses1,
            prosesakhir : proses2,
        }
        var ctg = document.getElementById('chart_group').getContext('2d');
        var chartgr = new Chart(ctg, {
                                type: 'bar',
                                data: {

                                },
                                options: {}
                            });
        var ctm = document.getElementById('type_mn').getContext('2d');
        var chartyp = new Chart(ctm, {
                                type: 'line',
                                data: {

                                },
                                options: {}
                            });

        var ctn = document.getElementById('material_mn').getContext('2d');
        var chartmat = new Chart(ctn, {
                                type: 'line',
                                data: {

                                },
                                options: {}
                            });
        var ctp = document.getElementById('monitoring_ng').getContext('2d');
        var charmonitoring = new Chart(ctp, {
                                type: 'line',
                                data: {
                                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                    datasets: []
                                },
                                options: {
                                    tooltips: {
                                                callbacks: {
                                                    title: function (tooltipItem, data) {
                                                        //console.log(data['datasets'][tooltipItem[0]['datasetIndex']]['label']);
                                                    
                                                    return data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
                                                    },
                                                    label: function (tooltipItem, data) {
                                                    
                                                    return tooltipItem.yLabel + ' %';
                                                    }

                                                },
                                                backgroundColor: '#FFF',
                                                titleFontSize: 14,
                                                titleFontColor: '#0066ff',
                                                bodyFontColor: '#000',
                                                bodyFontSize: 12,
                                                displayColors: false
                                                },
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true,
                                                    
                                                    callback: function(value, index, values) {
                                                        if (parseInt(value) >= 1000) {
                                                            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                        } else {
                                                            return value + '%';
                                                        }
                                                    }
                                                }
                                            }]
                                        }
                                    }
                            });
        var a = {
            dwg: 1,
        }                   
        get_data(APP_URL+"/api/produksi/graphmonth",key,a).done(function(resp){
           if (resp.success) {
            var labelt = [];
            var vcf = [];
            var vccr = [];
            var vof = [];
            var vocr = [];
            var vl = [];
            var npr = [];
            var npmi = [];
           var mnth = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sept','Okt','Nov','Des'];
            var v = resp.data;
            for(var i in v){
                labelt.push(mnth[i]);
                (v[i].COMP_F == 0) ? vcf.push('N/A') : vcf.push(v[i].COMP_F);
                (v[i].COMP_Cr == 0) ? vccr.push('N/A') : vccr.push(v[i].COMP_Cr);
                (v[i].OIL_F == 0) ? vof.push('N/A') : vof.push(v[i].OIL_F);
                (v[i].OIL_Cr == 0) ? vocr.push('N/A') : vocr.push(v[i].OIL_Cr);
                (v[i].LINER == 0) ? vl.push('N/A') : vl.push(v[i].LINER);

                (v[i].NPR == 0) ? npr.push('N/A') : npr.push(v[i].NPR);
                (v[i].NPMI == 0) ? npmi.push('N/A') : npmi.push(v[i].NPMI);
               
             }
             var u = {
                 compf:vcf,
                 compcr:vccr,
                 oilf:vof,
                 oilcr:vocr,
                 liner:vl,
             }
             var z = {
                 npr:npr,
                 npmi:npmi,
             }
             chartMonth_t( labelt, u, chartyp);
             chartMonth_m( labelt, z, chartmat);
           }
        }).fail(function(){

        });
        tampil_srate(x,key);
        monitoring_chart(key, charmonitoring);
  
 
        $("#btn-letsgo").click(function () {
            tgl1 = $("#tanggalawal").val();
            tgl2 = $("#tanggalakhir").val();
            proses1 = $("#prosesawal").val();
            proses2 = $("#prosesakhir").val();
           
            var p = {
            tanggalawal : tgl1,
            tanggalakhir : tgl2,
            prosesawal : proses1,
            prosesakhir : proses2,
        }
        
        tampil_srate(p,key);

        });

        
        $(".srate").click(function(e){
            e.preventDefault();
            var d = this.id;
            var label = [];
            var value = [];
            var jmlh = [];
            var x_v = 0;
            var m = {
                jenis : d,
                awal : tgl1,
                akhir : tgl2,
                pros1 : proses1,
                pros2 : proses2,
            }

            var tb_item =   $('#tb_item').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    searching: true,
                                    responsive: true,
                                    ordering: false,
                                    destroy: true,
                                    ajax: {
                                                    url: APP_URL+'/api/produksi/itemng',
                                                    type: "POST",
                                                    headers: { "token_req": key },
                                                    data: function(w){
                                                        w.jenis = d;
                                                        w.awal = tgl1;
                                                        w.akhir = tgl2;
                                                        w.pros1 = proses1;
                                                        w.pros2 = proses2;
                                                        w.ngtyp = x_v;
                                                    }
                                                    
                                                },
                                    columnDefs:[
                                        {
                                            targets: [ 0 ],
                                            visible: false,
                                            searchable: false
                                        },
                                     
                                    ],
                                
                                    columns: [
                                        { data: 'id_hasil_produksi', name: 'id_hasil_produksi' },
                                        { data: 'part_no', name: 'part_no' },
                                        { data: 'lot_no', name: 'lot_no' },
                                        { data: 'nama_line', name: 'nama_line' },
                                        { data: 'operator', name: 'operator' },
                                        { data: 'no_mesin', name: 'no_mesin' },
                                        { data: 'tgl_proses', name: 'tgl_proses' },
                                        { data: 'ng_qty', name: 'ng_qty' },
                                        { data: 'prosentase', name: 'prosentase',render: $.fn.dataTable.render.number(',', '.', 2,'',' %') },
                                       // { data: 'prosentase', name: 'prosentase',render: function(data,type,row){ return number(data.prosentase)} },
                                        { data: 'ng_type', name: 'ng_type' },
                                    ]
                                });

            get_data(APP_URL+"/api/produksi/groupchart",key,m).done(function(resp){
            //console.log(resp);
            var ch = resp.chart;
            for(var i in ch){

                    label.push(ch[i].ng_type);
                    value.push(ch[i].persen);
                    jmlh.push(ch[i].qty);
            }
            chartgr.data = {
                                  labels: label,
                                  datasets: [
                                    {
                                        yAxisID: 'B',
                                        label: 'Qty',
                                        fill: false,
                                        borderColor: 'rgb(255, 153, 51)',
                                        pointBorderWidth: 3,
                                        lineTension: 0.2,
                                        data: value,
                                        type: 'line',
                                        position: 'right',
                                    },
                                    {
                                        yAxisID: 'A',
                                      label: 'NG',
                                      backgroundColor: 'rgb(51, 153, 255)',
                                      borderColor: 'rgb(51, 153, 255)',
                                      data: jmlh,
                                      position: 'left',
                                  },
                                   
                                  ]
                   };
                   chartgr.options = {
                    tooltips: {
                        callbacks: {
                            title: function (tooltipItem, data) {
                            return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function (tooltipItem, data) {
                            //return formatter.format(data['datasets']['index']['data'][tooltipItem['index']]);
                            //return data['datasets']['index']['data'][tooltipItem['index']];
                            if (tooltipItem.datasetIndex == 0) {
                                return tooltipItem.yLabel + ' %';
                            }
                            return tooltipItem.yLabel + ' Pcs';
                            }

                        },
                        backgroundColor: '#FFF',
                        titleFontSize: 16,
                        titleFontColor: '#0066ff',
                        bodyFontColor: '#000',
                        bodyFontSize: 14,
                        displayColors: false
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
                                ticks:{
                                    callback: function(value, index, ticks) {
                                        return value+' %';
                                    }
                                }
                            },
                               ]
                        },
                    onClick: function (c, i) {
                        e = i[0];
                        x_v = this.data.labels[e._index];
                        //console.log(x_value);
                        tb_item.ajax.reload();
                        $("#collapseOne").collapse("show");

                      
                    }
                   };
                   chartgr.update();
            $("#GroupTitle").html(d);
            $("#part_modal").modal("toggle");
            }).fail(function(){

            });
            
            $("#mdgroup").modal("toggle");
        });

        $("#tb_peritem").on("click",".itemdetails",function(e){
            e.preventDefault();
            var d = this.id;
            var label = [];
            var value = [];
            var x_v = 0;
            var m = {
                id : d,
                awal : tgl1,
                akhir : tgl2,
                pros1 : proses1,
                pros2 : proses2,
            }

            var tb_item =   $('#tb_item').DataTable({
                                    processing: true,
                                    serverSide: true,
                                    searching: true,
                                    responsive: true,
                                    ordering: false,
                                    destroy: true,
                                    ajax: {
                                                    url: APP_URL+'/api/produksi/perproses',
                                                    type: "POST",
                                                    headers: { "token_req": key },
                                                    data: function(w){
                                                        w.id = d;
                                                    }
                                                    
                                                },
                                    columnDefs:[
                                        {
                                            targets: [ 0 ],
                                            visible: false,
                                            searchable: false
                                        },
                                     
                                    ],
                                
                                    columns: [
                                        { data: 'id_hasil_produksi', name: 'id_hasil_produksi' },
                                        { data: 'part_no', name: 'part_no' },
                                        { data: 'lot_no', name: 'lot_no' },
                                        { data: 'nama_line', name: 'nama_line' },
                                        { data: 'operator', name: 'operator' },
                                        { data: 'no_mesin', name: 'no_mesin' },
                                        { data: 'tgl_proses', name: 'tgl_proses' },
                                        { data: 'ng_qty', name: 'ng_qty' },
                                        { data: 'prosentase', name: 'prosentase',render: $.fn.dataTable.render.number(',', '.', 2,'',' %') },
                                       // { data: 'prosentase', name: 'prosentase',render: function(data,type,row){ return number(data.prosentase)} },
                                        { data: 'ng_type', name: 'ng_type' },
                                    ]
                                });

            get_data(APP_URL+"/api/produksi/ngperitem",key,m).done(function(resp){
            //console.log(resp);
            var ch = resp.chart;
            for(var i in ch){

                    label.push(ch[i].ng_type);
                    value.push(ch[i].qty);
            }
            chartgr.data = {
                                  labels: label,
                                  datasets: [
                                    {
                                      label: 'NG',
                                      backgroundColor: 'rgb(51, 153, 255)',
                                      borderColor: 'rgb(51, 153, 255)',
                                      data: value,
                                  },
                                   
                                  ]
                   };
                   chartgr.options = {
                    onClick: function (c, i) {
                        e = i[0];
                        x_v = this.data.labels[e._index];
                        //console.log(x_value);
                        tb_item.ajax.reload();
                        $("#collapseOne").collapse("show");

                      
                    }
                   };
                   chartgr.update();
            $("#GroupTitle").html(d);
            $("#part_modal").modal("toggle");
            }).fail(function(){

            });
            
            $("#mdgroup").modal("toggle");
        });
        $("#jenis_ng").on('select2:select', function () {
            var jenis = $(this).children("option:selected").html();
            var kode = $(this).children("option:selected").val();
           
           var codes = [];
            var sama = false;
            codes = $("input[name='kode_ng[]']").map(function () {
                return this.value;
            }).get();

            for (r in codes) {
                if (codes[r] == kode) {
                    sama = true;
                }
            }
            if (!sama) {
                  
                    var baris_baru = '<tr><td><input type ="hidden" name="kode_ng[]" value="' + kode + '" />' + jenis + '</td><td><button type="button" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#tb_jenis tbody').append(baris_baru);
                    $("#jenis_ng").select2('focus');
                  
                } else {
                    alert("NG Sudah ada !")
                }
           
        });

        $('#tb_jenis').on('click', '.btnhapus', function () {
            var currentRow = $(this).closest("tr");
            var cellval = currentRow.find("td:eq(0) input").val();
            itemDel.push(cellval);
            console.log(itemDel);
            currentRow.remove();
           

        });

        $("#frm_setting").submit(function(e){
            e.preventDefault();
            var datas = $(this).serialize();
            datas = datas + "&itemDel="+itemDel;
          
            get_data(APP_URL+"/api/config/ng",key,datas).done(function(resp){
                if (resp.success) {
                    window.location = window.location;
                    $("#modal_config").modal("toggle");
                }
            }).fail(function(){

            });
        });

        $("#btn_conf").click(function(){
            itemDel = [];
            var y = {
                "id": 1,
            }
            get_data(APP_URL+"/api/config/get_monitoring",key,y).done(function(resp){
                $("#periode").val(resp.period);
                $("#kode_line").val(resp.kode_line);
                $('#tb_jenis tbody').empty();
                if (resp.success) {
                    for (var i in resp.datas) {
                    var baris_baru = '<tr><td><input type ="hidden" name="kode_ng[]" value="' + resp.datas[i].kode_ng + '" />' + resp.datas[i].type_ng + '</td><td><button type="button" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#tb_jenis tbody').append(baris_baru);
                    }
                    $("#modal_config").modal("toggle");
                }
            }).fail(function(){

            });
           
        });

    });

var ctx = document.getElementById('ng-chart').getContext('2d');
  var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {

                        },
                        options: {}
                    });

function tampil_table(dt){
    var detail = $("#tb_success").DataTable({
            "data":dt,
            "ordering": false,
            "columns":[
                {data:'item', name: 'item'},
                {data:'zoukei', name:'zoukei'},
                {data: 'kensa', name:'kensa'}
            ]
        });
}

function chartMonth_m( lab, val, chart){

        
chart.data = {
               labels: lab,
               datasets: [
                 {
                    label: 'NPR Sozai',
                    fill: false,
                    borderColor: 'rgb(255, 0, 0)',
                    pointBorderWidth: 3,
                    lineTension: 0.2,
                    data: val.npr,
                    type: 'line'
               },
               {
                    label: 'NPMI Sozai',
                    fill: false,
                    borderColor: 'rgb(0, 153, 204)',
                    pointBorderWidth: 3,
                    lineTension: 0.2,
                    data: val.npmi,
                    type: 'line'
               },
              
                
               ]
};
chart.options = {
    tooltips: {
          callbacks: {
            title: function (tooltipItem, data) {
                //console.log(data['datasets'][tooltipItem[0]['datasetIndex']]['label']);
               
              return data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
            },
            label: function (tooltipItem, data) {
               
              return tooltipItem.yLabel + ' %';
            }

          },
          backgroundColor: '#FFF',
          titleFontSize: 16,
          titleFontColor: '#0066ff',
          bodyFontColor: '#000',
          bodyFontSize: 14,
          displayColors: false
        },
    scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        min: 0,
                                        max: 100,// Your absolute max value
                                        callback: function (value) {
                                        return value + '%'; // convert it to percentage
                                        },
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage',
                                    },
                                    },
                            ],
                            },
};
chart.update();

}

function monitoring_chart( key,charmonitoring){
    var a = {
        a:1,
    }
   
    get_data(APP_URL+"/api/config/monitoring_chart",key,a).done(function(resp){
            if (resp.success) {
          
            var v = resp.data;
           
            
            for (lab in v[0]) {
            var newDataset = {
                            label: [lab],
                            fill: false,
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            borderColor: getRandomColor(),
                            data: []
                            };
               
                for(var i in v){
                    (v[i][lab] == 0) ? newDataset.data.push('N/A') : newDataset.data.push(v[i][lab]);
                    
                    //newDataset.data.push(v[i][lab]);
                  
                }
                    charmonitoring.config.data.datasets.push(newDataset);
            }

            
             charmonitoring.update();
        
            }
        });

}

function chartMonth_t( lab, val, chart){

        
        chart.data = {
                    labels: lab,
                    datasets: [
                        {
                            label: 'COMP-F',
                            fill: false,
                            borderColor: 'rgb(0, 102, 255)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: val.compf,
                            type: 'line'
                    },
                    {
                            label: 'COMP-Cr',
                            fill: false,
                            borderColor: 'rgb(255, 255, 26)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: val.compcr,
                            type: 'line'
                    },
                    {
                            label: 'OIL-F',
                            fill: false,
                            borderColor: 'rgb(255, 0, 255)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: val.oilf,
                            type: 'line'
                    },
                    {
                            label: 'OIL-Cr',
                            fill: false,
                            borderColor: 'rgb(102, 255, 102)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: val.oilcr,
                            type: 'line'
                    },
                    {
                            label: 'LINER',
                            fill: false,
                            borderColor: 'rgb(153, 102, 51)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: val.liner,
                            type: 'line'
                    },
                        
                    ]
                   
        };
        chart.options = {
            tooltips: {
          callbacks: {
            title: function (tooltipItem, data) {
                //console.log(data['datasets'][tooltipItem[0]['datasetIndex']]['label']);
               
              return data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
            },
            label: function (tooltipItem, data) {
               
              return tooltipItem.yLabel + ' %';
            }

          },
          backgroundColor: '#FFF',
          titleFontSize: 16,
          titleFontColor: '#0066ff',
          bodyFontColor: '#000',
          bodyFontSize: 14,
          displayColors: false
        },
            scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        min: 0,
                                        max: 100,// Your absolute max value
                                        callback: function (value) {
                                        return value + '%'; // convert it to percentage
                                        },
                                    },
                                    scaleLabel: {
                                        display: true,
                                        labelString: 'Percentage',
                                    },
                                    },
                            ],
                            },
        };
        chart.update();

}


function tampil_chart( lab, val, chart){

        
                   chart.data = {
                                  labels: lab,
                                  datasets: [
                                    {
                                      label: 'NG',
                                      backgroundColor: 'rgb(51, 153, 255)',
                                      borderColor: 'rgb(51, 153, 255)',
                                      data: val,
                                  },
                                   
                                  ]
                   };
                   chart.options = {

                   };
                   chart.update();
              
}

function tampil_srate(datas, key){
    var label = [];
    var value = [];
    var final = datas.prosesakhir;
    get_data(APP_URL+"/api/successrate",key,datas).done(function(resp){
        if (resp.success) {
            // alert(resp.data);
            var dt = resp.kensa;
            var nogood = resp.ng;
            var badI = resp.items;
            $("#successrate").html(resp.all+' %');
            $("#compf").html(resp.compf+' %');
            $("#compcr").html(resp.compcr+' %');
            $("#oilf").html(resp.oilf+' %');
            $("#oilcr").html(resp.oilcr+' %');
            $("#j_pro").html(dt.zokei+' Pcs');
            $("#j_camu").html(dt.camu+' Pcs');
            $("#j_inc").html(dt.incoming+' Pcs');
            $("#j_finish").html(dt.finish+' Pcs');
            $("#j_lot").html(dt.lot);
            var zc = Number(dt.camu)/Number(dt.zokei) * 100;
            var nzc = 100 - zc;
            $("#z-c").html(zc.toFixed(2)+' %');
            $("#n_z-c").html(nzc.toFixed(2)+' %');
            zc = Number(dt.incoming)/Number(dt.camu) * 100;
            nzc = 100 - zc;
            $("#c-k").html(zc.toFixed(2)+' %');
            $("#n_c-k").html(nzc.toFixed(2)+' %');
            zc = Number(dt.finish)/Number(dt.incoming) * 100;
            nzc = 100 - zc;
            $("#k-f").html(zc.toFixed(2)+' %');
            $("#n_k-f").html(nzc.toFixed(2)+' %');
            zc = Number(dt.finish)/Number(dt.camu) * 100;
            nzc = 100 - zc;
            $("#c-f").html(zc.toFixed(2)+' %');
            $("#n_c-f").html(nzc.toFixed(2)+' %');
            $("#tb_ng tbody").empty();
            for (var i in nogood) {
                    label.push(nogood[i].ng_type);
                    value.push(nogood[i].qty);
                    if (i <= 9) {
                    var pr = Number(nogood[i].persen);
                    var no = 1 + Number(i);
                    var newrow = '<tr><td>'+no+'</td><td>'+nogood[i].ng_type+'</td><td>'+Number(nogood[i].qty)+'</td><td>'+pr.toFixed(2)+' %</td></tr>';

                    $('#tb_ng tbody').append(newrow);  
                        
                    }
                }
                $("#tb_peritem tbody").empty();
            for (var i in badI){
                if (i <= 9) {
                    var pr = Number(badI[i].perlot);
                    var no = 1 + Number(i);
                    var newrow = '<tr><td>'+no+'</td><td>'+badI[i].part_no+'</td><td>'+badI[i].lot_no+'</td><td>'+Number(badI[i].start_qty)+'</td><td>'+Number(badI[i].finish_qty)+'</td><td><a href="" id="'+badI[i].lot_no+'" class="itemdetails">'+pr.toFixed(2)+' %</a></td></tr>';

                    $('#tb_peritem tbody').append(newrow);  
                }
            }
            $("#judul_grafik").html(final);
            tampil_chart(label, value ,chart);
          
         
        } else
            alert(resp.message);
     
            }).fail(function(){

            });
  
}
function get_data(url,key,datas){
    return $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        headers: { "token_req": key },
        data: datas,
    });
}
function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
                }
</script>

@endsection