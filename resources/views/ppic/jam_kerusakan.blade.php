@extends('layout.main')
@section('content')

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

@endsection

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var klas = ['C'];
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

        $("#btn_refresh").click(function () {
            tb_jamrusak.ajax.reload();
        });
    });

</script>
@endsection