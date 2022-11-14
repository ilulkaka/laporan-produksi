@extends('layout.main')
@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">

                    <h3 class="card-title">Grafik Lembur<i id="periode"></i></h3>
                </div>

                <div class="row align-center">
                    <input type="date" class="form-control col-sm-4" id="tgl1" value="{{date('Y-m').'-01'}}">
                    <label for="" class="col-md-2 text-center">Sampai</label>
                    <input type="date" class="form-control col-sm-4" id="tgl2" value="{{date('Y-m-d')}}">
                    <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>
                </div>
            </div>

            <div class="card-body">
                <div>
                    <canvas id="chartlembur"></canvas>
                </div>
            </div>
        </div>



    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 id="judul_grafik" class="card-title">Data Lembur</h3>

                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tb_lembur">
                    <thead>
                        <tr>

                            <th>Section</th>

                            <th>Total Jam</th>
                            <th>Quota Lembur</th>
                            <th>Selisih</th>
                            <th>Member</th>
                            <th>Quota / Memb</th>
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
</div>



<div class="modal fade bd-example-modal-lg" id="detail-modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle">Detail Lembur</h5>

                <p id="tgl-awal"></p>
                <p>Sampai</p>
                <p id="tgl-akhir"></p>



            </div>
            <div class="modal-body">

                <table class="table table-responsive" id="tb_detail">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Section</th>
                            <th>Jabatan</th>
                            <th>Total</th>

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
                    <button type="button" class="btn btn-secondary" id="btn-close">Close</button>
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
    $(document).ready(function () {

        var key = localStorage.getItem('npr_token');

        var ctx = document.getElementById('chartlembur').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {

            },
            options: {}
        });

        var awal = $("#tgl1").val();
        var akhir = $("#tgl2").val();

        tampil_chart(awal, akhir, chart, key);

        $("#btn_refresh").click(function () {
            var awal = $("#tgl1").val();
            var akhir = $("#tgl2").val();

            tampil_chart(awal, akhir, chart, key);
        });
        $("#btn-close").click(function () {

            $('#detail-modal').modal('hide');
            $('#tb_detail').dataTable().fnDestroy();
            $('#tb_detail').empty();
        });


    });







    function tampil_chart(awal, akhir, chart, key) {

        $.ajax({
            url: APP_URL + "/api/grafiklembur",
            method: "POST",
            data: { "tgl_awal": awal, "tgl_akhir": akhir },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var Tvalue = [];
                var Mvalue = [];
                var jm = 0;
                var tot = 0;
                var tot2 = 0;
                var jmlmem = 0;

                $("#tb_lembur tbody").empty();
                $("#tb_lembur tfoot").empty();

                for (var i in data) {
                    label.push(data[i].DEPT_SECTION);
                    value.push(data[i].jam);
                    Tvalue.push(data[i].target_jam);
                    Mvalue.push(data[i].totmember);
                    jm = data[i].jam;
                    jm2 = data[i].target_jam;
                    sel = jm2 - jm;
                    totmem = jm2 / data[i].totmember;
                    totmem1 = totmem.toFixed(2);

                    if (sel < 0) {
                        td = '<td style="color: rgb(150, 7, 7);">' + sel.toFixed(2) + '</td>';
                    } else {
                        td = '<td style="color: rgb(7, 150, 7);">' + sel.toFixed(2) + '</td>';
                    }


                    tot = tot + Number(jm)
                    tot2 = tot2 + Number(jm2)
                    jmlmem = jmlmem + Number(totmem1);

                    var newrow = '<tr><td>' + data[i].DEPT_SECTION + '</td><td>' + Number(jm) + '</td><td>' + Number(jm2) + '</td>' + td + '<td>' + data[i].totmember + '</td>' + '<td>' + totmem1 + '</td></tr>';

                    $('#tb_lembur tbody').append(newrow);
                }
                var p = tot2 - tot;
                var p1 = tot2 / jmlmem;

                $("#tb_lembur tfoot").append('<tr><th>Total :</th><th>' + tot.toFixed(2) + '</th><th>' + tot2.toFixed(2) + '</th><th>' + p.toFixed(2) + '</th>' + '<th>' + jmlmem.toFixed(0) + '</th>' + '<th>' + p1.toFixed(2) + '</th></tr>')

                chart.data = {
                    labels: label,
                    datasets: [
                        {
                            label: 'Quota Lembur',
                            fill: false,
                            borderColor: 'rgb(255, 153, 51)',
                            pointBorderWidth: 3,
                            lineTension: 0.2,
                            data: Tvalue,
                            type: 'line'
                        },
                        {
                            label: 'Jam Lembur',
                            backgroundColor: 'rgb(51, 153, 255)',
                            borderColor: 'rgb(51, 153, 255)',
                            data: value,
                        }

                    ]
                };
                chart.options = {

                    onClick: function (c, i) {
                        e = i[0];

                        var x_value = this.data.labels[e._index];
                        var y_value = this.data.datasets[0].data[e._index];

                        get_details(x_value, awal, akhir, key);
                        $("#tgl-awal").html(awal);
                        $("#tgl-akhir").html(akhir);
                        $('#ModalLongTitle').html(x_value);
                        $('#detail-modal').modal('show');

                    }
                };
                chart.update();
            }

        });



    }



    function get_details(kel, awal, akhir, key) {
        var tb_lembur = $("#tb_detail").DataTable({

            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/detail_lembur',
                type: "POST",
                headers: { "token_req": key },
                data: { "dept": kel, "awal": awal, "akhir": akhir },

            },
            columns: [

                { data: 'NIK', name: 'NIK' },
                { data: 'NAMA', name: 'NAMA' },
                { data: 'NAMA_SECTION', name: 'NAMA_SECTION' },
                { data: 'NAMA_JABATAN', name: 'NAMA_JABATAN' },
                { data: 'total_jam', name: 'total_jam' },

            ]
        });
    }

</script>
@endsection