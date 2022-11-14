@extends('layout.main')
@section('content')


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Data Mesin
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <dl class="row">

                    <dt class="col-sm-2">No Induk Mesin</dt>
                    <dd class="col-sm-10">{{$mesin->no_induk}}</dd>
                    <dt class="col-sm-2">Nama Mesin</dt>
                    <dd class="col-sm-10">{{$mesin->nama_mesin}}</dd>
                    <dt class="col-sm-2">Type Mesin</dt>
                    <dd class="col-sm-10">{{$mesin->type_mesin}}</dd>
                    <dt class="col-sm-2">Merk Mesin</dt>
                    <dd class="col-sm-10">{{$mesin->merk_mesin}}</dd>
                    <dt class="col-sm-2">Lokasi</dt>
                    <dd class="col-sm-10">{{$mesin->lokasi}}</dd>
                    <dt class="col-sm-2">Kategori</dt>
                    <dd class="col-sm-10">{{$mesin->kategori_mesin}}</dd>
                </dl>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title" id="periode">MTBF & MTTR</h3>

            </div>
            <div class="card-body">
                <div>
                    <canvas id="chartmtbf"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">

                    <label for="" class="col-md-2 text-center">Periode</label>
                    <select name="" id="period" class="form-control col-md-2">
                        @for($year = (int)date('Y'); 2021 <= $year; $year--) <option value="{{$year}}">{{$year}}
                            </option>
                            @endfor
                    </select>
                    <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">History Mesin</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="tb_history">
                    <thead>
                        <tr>
                            <th>id_perbaikan</th>
                            <th>Tanggal Rusak</th>
                            <th>No Perbaikan</th>
                            <th>Masalah</th>
                            <th>Kondisi</th>
                            <th>Penyebab</th>
                            <th>Tindakan</th>
                            <th>Status</th>
                            <th>Tanggal Selesai</th>
                            <th>Spareparts</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>

</div>


<div class="modal fade bd-example-modal" id="part_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle">Daftar Sparepart</h5>
                <h5 id="no_req"></h5>
            </div>
            <div class="modal-body">
                <table class="table table-responsive" id="tb_part">
                    <thead>
                        <tr>
                            <th>Item code</th>
                            <th>Nama Part</th>
                            <th>Qty</th>

                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <div class="col col-md-3">
                    <button class="btn btn-success disabled" id="btn-excel">Excel</button>
                </div>
                <div class="col col-md-4"></div>
                <div class="col col-md-3">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_close">Close</button>
                </div>
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
    $(document).ready(function(){
        var key = localStorage.getItem('npr_token');
        var list_history = $('#tb_history').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            ordering: false,

            ajax: {
            url: APP_URL + '/api/maintenance/historymesin',
            type: "POST",
            headers: {
            "token_req": key
            },
            data:{'no_mesin' : '{{$mesin->no_induk}}' },
             },
            columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false
            },
            {
            targets: [9],
            data : null,
            render : function(data, type, row, meta){
                if (data.status == 'complete') {
                    return "<button class='btn btn-primary'>List</button>";
                }else{
                    return "-";
                }
            },
            },
           
           ],
            columns: [{
                    data: 'id_perbaikan',
                    name: 'id_perbaikan'
                },
                {
                    data: 'tanggal_rusak',
                    name: 'tanggal_rusak'
                },
                {
                    data: 'no_perbaikan',
                    name: 'no_perbaikan'
                },
                {
                    data:'masalah',
                    name:'masalah'
                },{
                    data:'kondisi',
                    name:'kondisi'
                },{
                    data:'penyebab',
                    name:'penyebab'
                },{
                    data:'tindakan',
                    name:'tindakan'
                },{
                    data:'status',
                    name:'status'
                },{
                    data:'tanggal_selesai',
                    name:'tanggal_selesai'
                },],
           
        });
        var ctx = document.getElementById('chartmtbf').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {},
            options: {}
        });
        var no_mes = '{{$mesin->no_induk}}';
        var c = {
            no: no_mes,
            periode: $("#period").val()
        }
        tampil_chart(c,chart,key);
        $("#tb_history").on('click', '.btn-primary', function(){
            var data = list_history.row($(this).parents('tr')).data();
            $("#no_req").html(data.no_perbaikan);
            getpart(data.id_perbaikan, key);
            $("#part_modal").modal("show");
           
        });
        $("#btn_close").click(function(){
            $('#tb_part').dataTable().fnDestroy();
            $('#tb_part').empty();
        });
        $("#btn_reload").click(function(){
            var b ={
                no: no_mes,
                periode: $("#period").val()
            };
            tampil_chart(b,chart,key);
        });
    });

    function tampil_chart(per, chart, key) {
        
        $.ajax({
            url: APP_URL + "/api/maintenance/mtbf",
            method: "POST",
            data: { "periode": per.periode, "no" : per.no },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var upt = [];
                var jam_rusak = [];
                var jcase = [];
                var mtbf = [];
                var mttr = [];
                var whour = [];
                var totaljam = 0;
                var totalmenunggu = 0;
                for (var i in data) {
                    label.push(data[i].bulan);
                    upt.push(data[i].uptime);
                    jam_rusak.push(data[i].jam_rusak);
                    jcase.push(data[i].jumlah_case);
                    mtbf.push(data[i].mtbf);
                    mttr.push(data[i].mttr);
                    whour.push(data[i].durasi);
                    //totaljam = totaljam + Number(data[i].jam);
                    //totalmenunggu = totalmenunggu + Number(data[i].menunggu);
                }

                chart.data = {
                    labels: label,
                    datasets: [
                        {
                            label: 'Production Time',
                            fill: false,
                            borderColor: 'rgb(163, 194, 194)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: whour,
                            type: 'line'
                        },
                        {
                            label: 'Up Time',
                            fill: false,
                            borderColor: 'rgb(0, 204, 0)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: upt,
                            type: 'line'
                        },
                        {
                            label: 'Down Time',
                            backgroundColor: 'rgb(255, 0, 0)',
                            borderColor: 'rgb(255, 0, 0)',
                            data: jam_rusak,
                        },
                        {
                            label: 'Jumlah Case',
                            backgroundColor: 'rgb(0, 0, 0)',
                            borderColor: 'rgb(51, 153, 255)',
                            data: jcase,
                        },
                        {
                            label: 'MTBF',
                            backgroundColor: 'rgb(255, 204, 0)',
                            borderColor: 'rgb(255, 204, 0)',
                            data: mtbf,
                        },
                        {
                            label: 'MTTR',
                            backgroundColor: 'rgb(0, 102, 255)',
                            borderColor: 'rgb(51, 153, 102)',
                            data: mttr,
                        },

                    ]
                };
                chart.options = {
                   
                    onClick: function (c, i) {
                        e = i[0];
                        var x_value = this.data.labels[e._index];
                        var tgl = $("#tgl2").val();
                       
                     
                    }
                };
                chart.update();
                $("#periode").html("MTBF & MTTR " + per.periode);
              
            }

        });



    }


    function getpart(id, key){
        $("#tb_part").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                ordering: false,

                ajax: {
                url: APP_URL + '/api/maintenance/partlist',
                type: "POST",
                headers: {
                "token_req": key
                },
                data:{'id_perbaikan' : id },
            },
                columnDefs: [
               
            ],
                columns: [{
                        data: 'item_code',
                        name: 'item_code'
                    },
                    {
                        data: 'nama_part',
                        name: 'nama_part'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                   ],
            });
    }
</script>
@endsection