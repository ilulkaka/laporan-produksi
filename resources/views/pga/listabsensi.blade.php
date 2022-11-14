@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">Inquery Absensi</h3>
                    </div>
                </div>
                <div class="row align-center">

                </div>
            </div>
            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <!-- <div class="row">
                <label for="" class="col-md-1 ">Status : </label>
                <select name="status_k" id="status_k" class="form-control col-md-2" value="Selesai">
                    <option value="All">All</option>
                    <option value="Tetap">Tetap</option>
                    <option value="Kontrak">Kontrak</option>
                </select>
                <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
            </div>
            <br>-->
            <table class="table table-hover text-nowrap" id="tb_absen">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>periode</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Total H. Krj</th>
                        <th>Aktual H. Krj</th>
                        <th>DL</th>
                        <th>Alpa</th>
                        <th>S1</th>
                        <th>S2</th>
                        <th>ITU</th>
                        <th>CT</th>
                        <th>CH</th>
                        <th>CP</th>
                        <th>C Haid</th>
                        <th>C Kmatian</th>
                        <th>C Khitan</th>
                        <th>C Haji</th>
                        <th>C Kelahiran</th>
                        <th>Izin SP</th>
                        <th>Total Absen</th>
                        <th>Avg kehadiran</th>
                        <th>Avg Dept</th>
                        <th>Avg NPMI</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var listabsensi = $('#tb_absen').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            ajax: {
                url: APP_URL + '/api/pga/inqueryabsensi',
                type: "POST",
                headers: { "token_req": key },
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            ],

            columns: [
                { data: 'id_no', name: 'id_no' },
                { data: 'periode_absen', name: 'periode_absen' },
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'tot_jadwal', name: 'tot_jadwal' },
                { data: 'tot_aktual', name: 'tot_aktual' },
                { data: 'dinas_luar', name: 'dinas_luar' },
                { data: 'alpa', name: 'alpa' },
                { data: 'sakit_faskes', name: 'sakit_faskes' },
                { data: 'sakit_nonfaskes', name: 'sakit_nonfaskes' },
                { data: 'itu', name: 'itu' },
                { data: 'cuti_tahunan', name: 'cuti_tahunan' },
                { data: 'cuti_hamil', name: 'cuti_hamil' },
                { data: 'cuti_nikah', name: 'cuti_nikah' },
                { data: 'cuti_haid', name: 'cuti_haid' },
                { data: 'cuti_kematian', name: 'cuti_kematian' },
                { data: 'cuti_khitan_anak', name: 'cuti_khitan_anak' },
                { data: 'cuti_haji', name: 'cuti_haji' },
                { data: 'cuti_kelahiran', name: 'cuti_kelahiran' },
                { data: 'ijin_serikat', name: 'ijin_serikat' },
                { data: 'tot_absen', name: 'tot_absen' },
                {
                    data: 'avg_absen', name: 'avg_absen',
                    render: function (data, type, row) {
                        return parseFloat(data * 100).toFixed(2) + ' %';
                    }
                },
                {
                    data: 'avg_dept', name: 'avg_dept',
                    render: function (data, type, row) {
                        return parseFloat(data * 100).toFixed(2) + ' %';
                    }
                },
                {
                    data: 'avg_npmi', name: 'avg_npmi',
                    render: function (data, type, row) {
                        return parseFloat(data * 100).toFixed(2) + ' %';
                    }
                },
            ],
        });
    });



</script>

@endsection