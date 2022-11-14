@extends('layout.main')
@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(Session::has('alert-danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{Session::get('alert-danger')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">

    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <h3 class="card-title">Grafik Jam Kerusakan <i id="periode"></i></h3>
                </div>


            </div>

            <div class="card-body">
                <div>
                    <canvas id="chartjam"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">

                    <label for="" id="totaljam"></label>
                </div>
                <div class="row">

                    <label for="" id="totmenunggu"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="col col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Jam Kerusakan</h3>

            </div>
            <div class="card-body">
                <div>
                    <canvas id="chartsasaran"></canvas>
                </div>
            </div>

            <!-- /.card-body -->
        </div>

    </div>

</div>
<div class="row">

    @if(Session('nik') != '000000')
    <table>
        <tbody>
            <tr>
                <td>
                    <button class="btn btn-secondary" id="btn-rekap">Rekap Jam kerusakan</button>
                </td>
                <td>
                    <button class="btn btn-primary" id="btn-target">Setting target</button>
                </td>
            </tr>
        </tbody>
    </table>
    @endif
</div>

<div class="row">
    <div class="card col-md12">
        <div class="card-header">
            <h3>Daftar Jam Kerusakan</h3>

            <div class="row align-center">
                <label for="" class="col-md-2 text-center">Periode</label>
                <input type="month" class="form-control col-sm-4" id="tgl2" value="{{date('Y-m')}}">
                <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>

            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table-hover text-nowrap" id="tb_kerusakan">
                    <thead>
                        <th>No Perbaikan</th>
                        <th>Departemen</th>
                        <th>No Mesin</th>
                        <th>Nama Mesin</th>
                        <th>Klasifikasi</th>
                        <th>Status</th>
                        <th>Tgl Rusak</th>
                        <th>Tgl Mulai Perbaikan</th>
                        <th>Tgl Selesai</th>
                        <th>Jam kerusakan</th>
                    </thead>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-success" id="btn-excel">Download Excel</button>
        </div>
    </div>

</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-rekap"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rekap Jam Kerusakan Mesin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_rekap">

                    @csrf
                    <div class="row">
                        <div class="col col-md-2">
                            <label for="">Periode : </label>
                        </div>
                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="tgl1" id="tgl1" required>
                        </div>

                        <div class="col col-md-4">
                            <input type="date" class="form-control" name="tgl2" id="tgl2" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-success" id="simpan_rekap">Simpan Rekap</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-detail"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labeldetail"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <table class="table table-sm" id="tb_detail">
                    <thead>
                        <th>No Induk Mesin</th>
                        <th>Nama Mesin</th>
                        <th>Jam menunggu</th>
                        <th>Jam Rusak</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-target"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setting Target Sasaran Mutu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_target">

                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="">Periode : </label>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="month" class="form-control" id="tgl1" name="tgl1" value="{{date('Y-m')}}"
                                required>
                        </div>

                        <div class="form-group col-md-4">
                            <input type="month" class="form-control" id="tgl2" name="tgl2" value="{{date('Y-m')}}"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="">Departemen :</label>
                        </div>
                        <div class="form-group col-md-6">
                            <select class="form-control" name="departemen" id="">
                                <option value="">Pilih departemen</option>
                                @foreach($dept as $k)
                                <option value="{{$k->DEPT_SECTION}}">{{$k->DEPT_SECTION}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="">Nilai Target :</label>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="number" name="target" class="form-control">
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-success" id="simpan_target">Simpan Target</button>
                </form>
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
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var ctx = document.getElementById('chartjam').getContext('2d');
        var klas = ['C','B'];
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {},
            options: {}
        });
        var ctg = document.getElementById('chartsasaran').getContext('2d');
        var chartgr = new Chart(ctg, {
                                type: 'line',
                                data: {

                                },
                                options: {}
                            });
        var tb_jamrusak = $('#tb_kerusakan').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/maintenance/jam_kerusakan',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode = $("#tgl2").val();
                    d.klas = klas;
                },
            },
            columnDefs: [

            ],

            columns: [
                { data: 'no_perbaikan', name: 'no_perbaikan' },
                { data: 'departemen', name: 'departemen' },
                { data: 'no_induk_mesin', name: 'no_induk_mesin' },
                { data: 'nama_mesin', name: 'nama_mesin' },
                { data: 'klasifikasi', name: 'klasifikasi' },
                { data: 'status_perbaikan', name: 'status_perbaikan' },
                { data: 'tgl_rusak', name: 'tgl_rusak' },
                { data: 'tgl_mulai', name: 'tgl_mulai' },
                { data: 'tgl_selesai', name: 'tgl_selesai' },
                { data: 'jam_rusak', name: 'jam_rusak', render: $.fn.dataTable.render.number(',', '.', 2) },

            ]
        });
        tampil_chart($("#tgl2").val(), chart, key);

        var a = {
            dwg: 1,
        }  
        action_data(APP_URL+"/api/mtc/sasaranmutu",a,key).done(function(resp){
        if (resp.success) {
            var label = [];
            var tcast = [];
            var tgrind = [];
            var tmach = [];
            var vcast = [];
            var vgrind = [];
            var vmach = [];
            var tTotal = [];
            var vTotal = [];
           var mnth = ['0','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sept','Okt','Nov','Des'];
            var v = resp.data;
            for(var i in v){
                label.push(mnth[i]);
                tcast.push(v[i].tCast);
                tgrind.push(v[i].tGrind);
                tmach.push(v[i].tMach);
                vcast.push(v[i].hCast);
                vgrind.push(v[i].hGrind);
                vmach.push(v[i].hMach);
                tTotal.push(v[i].tTotal);
                vTotal.push(v[i].hTotal);
             }

             var u = {
                 target:tTotal,
                 hasil:vTotal,
                
             }
            
             chartjam( label, u, chartgr);
           
           }
    }).fail(function(){

    });
        $("#btn_refresh").click(function () {
            tb_jamrusak.ajax.reload();
            tampil_chart($("#tgl2").val(), chart, key);
        });

        $("#btn-rekap").click(function () {
            $("#modal-rekap").modal('show');
        });
        $("#btn-target").click(function () {
            $("#modal-target").modal('show');
        });
        $("#frm_rekap").submit(function (e) {
            e.preventDefault();
            var datas = $(this).serialize();
            var c = confirm("Apakah anda akan menyimpan rekap jam kerusakan ?");
            if (c) {
                $.ajax({
                    url: APP_URL + '/maintenance/postreport',
                    type: 'POST',
                    dataType: 'json',
                    data: datas,
                })
                    .done(function (resp) {
                        if (resp.success) {

                            alert(resp.message);
                            window.location.href = "{{ route('laporan_mtc')}}";
                        }
                        else
                            alert(resp.message);
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    })
                    .always(function () {

                    });
            }
        });

        $("#frm_target").submit(function(e){
            e.preventDefault();
            var datas = $(this).serialize();
            $.ajax({
                    url: APP_URL + '/maintenance/settarget',
                    type: 'POST',
                    dataType: 'json',
                    data: datas,
                })
                    .done(function (resp) {
                        if (resp.success) {

                            alert(resp.message);
                            
                        }
                        else
                            alert(resp.message+ " Periode : "+resp.periode+" Target : "+resp.target_before);
                    })
                    .fail(function () {
                       

                    })
                    .always(function () {

                    });
        });

        $("#btn-excel").click(function () {

            var period = $("#tgl2").val();
            var p = {
                periode: period,
            };

            action_data(APP_URL + "/api/maintenance/exceljam", p, key).done(function (resp) {
                var fpath = resp.file;
                window.open(fpath, '_blank');
            });

        });
    });
    function tampil_chart(per, chart, key) {
        $("#periode").html(per);
        $.ajax({
            url: APP_URL + "/api/maintenance/grafikjam",
            method: "POST",
            data: { "periode": per },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value2 = [];
                var totaljam = 0;
                var totalmenunggu = 0;
                for (var i in data) {
                    label.push(data[i].departemen);
                    value.push(data[i].jam);
                    value2.push(data[i].menunggu);
                    totaljam = totaljam + Number(data[i].jam);
                    totalmenunggu = totalmenunggu + Number(data[i].menunggu);
                }

                chart.data = {
                    labels: label,
                    datasets: [
                        {
                            label: 'Jam Kerusakan',
                            backgroundColor: 'rgb(255, 53, 153)',
                            borderColor: 'rgb(255, 53, 153)',
                            data: value,
                        },
                        {
                            label: 'Jam Menunggu',
                            backgroundColor: 'rgb(51, 153, 255)',
                            borderColor: 'rgb(51, 153, 255)',
                            data: value2,
                        }

                    ]
                };
                chart.options = {

                    onClick: function (c, i) {
                        e = i[0];
                        var x_value = this.data.labels[e._index];
                        var tgl = $("#tgl2").val();
                        var p = {
                            dept: x_value,
                            period: tgl
                        };
                        action_data(APP_URL + "/api/maintenance/detailjam", p, key).done(function (resp) {
                            $("#tb_detail tbody").empty();

                            for (var i in resp) {
                                var newrow = '<tr><td>' + resp[i].no_induk_mesin + '</td><td>' + resp[i].nama_mesin + '</td><td>' + Number(resp[i].jam_menunggu).toFixed(2) + ' Jam</td><td>' + Number(resp[i].jam_rusak).toFixed(2) + ' Jam</td></tr>';
                                $('#tb_detail tbody').append(newrow);
                            }
                        });
                        //get_details(x_value,tgl, key);
                        $("#labeldetail").html("TOP 5 Kerusakan " + x_value);
                        $("#modal-detail").modal("toggle");
                    }
                };
                chart.update();
                $("#totaljam").html("Total Jam Kerusakan : " + totaljam.toFixed(2) + " Jam");
                $("#totmenunggu").html("Total Jam Menunggu : " + totalmenunggu.toFixed(2) + " Jam");
            }

        });



    }
    function chartjam( lab, val, chart){

        
chart.data = {
            labels: lab,
            datasets: [
                {
                    label: 'Sasaran',
                    fill: false,
                    borderColor: 'rgb(0, 102, 255)',
                    pointBorderWidth: 3,
                    lineTension: 0.2,
                    data: val.target,
                    type: 'line'
            },
            {
                    label: 'Hasil',
                    fill: false,
                    borderColor: 'rgb(255, 102, 26)',
                    pointBorderWidth: 3,
                    lineTension: 0.2,
                    data: val.hasil,
                    type: 'line'
            },
            
           
                
            ]
           
};
chart.options = {
    tooltips: {
  callbacks: {
    title: function (tooltipItem, data) {
      
       
      return data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
    },
    label: function (tooltipItem, data) {
       
      return tooltipItem.yLabel + ' Jam';
    }

  },
  backgroundColor: '#FFF',
  titleFontSize: 16,
  titleFontColor: '#0066ff',
  bodyFontColor: '#000',
  bodyFontSize: 14,
  displayColors: false
},

};
chart.update();

}

    function action_data(url, datas, key) {
        return $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            headers: { "token_req": key },
            data: datas,
        });
    }
</script>
@endsection