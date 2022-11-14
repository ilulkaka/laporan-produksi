@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">


        <div class="row">

            <div class="col-12">
                <h3 class="card-title"><u>List HH / KY</u></h3>
            </div>
        </div>

        <div class="modal-body">

            <div class="row">
                <div class="form-group col-md-2">
                    @csrf
                    <label for="beginning">Beginning</label>
                    <input type="date" class="form-control" id="tgl_awal" value="{{date('Y-m').'-01'}}">
                </div>
                <div class="form-group col-md-2">
                    <label>Ending</label>
                    <input type="date" class="form-control" id="tgl_akhir" value="{{date('Y-m-d')}}">
                </div>
                <div class="form-group col-md-2">
                    <label> Status : </label>
                    <select name="status_hk" id="status_hk" class="form-control" value="Selesai">
                        <option value="All">All</option>
                        <option value="Open">Open</option>
                        <option value="Close">Close</option>
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label> Jenis : </label>
                    <select name="jenis_hk" id="jenis_hk" class="form-control">
                        <option value="All">All</option>
                        @foreach($jenis as $j)
                        <option value="{{$j->p_hhky}}">{{$j->p_hhky }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-1">
                    <label> Reload </label>
                    <br>
                    <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
                </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap" id="tb_hk_inquery">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>No HK</th>
                            <th>Status</th>
                            <th>Jenis</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Bagian</th>
                            <th>Dimana</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-secondary btn-flat" id="btn-print">Print</button>
                <button type="submit" class="btn btn-success btn-flat" id="btn-excel">Download Excel</button>
                <button type="button" class="btn btn-primary btn-flat" id="btn-report"><a
                        href="{{url('hse/hhkyrekap')}}" style="color: white;">
                        Rekap
                    </a></button>
            </div>

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
        var listhk = $('#tb_hk_inquery').DataTable({
            processing: true,
            serverSide: true,
            searching: true,

            ajax: {
                url: APP_URL + '/api/listdatahk',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.status_hk = $("#status_hk").val();
                    d.tgl_awal = $("#tgl_awal").val();
                    d.tgl_akhir = $("#tgl_akhir").val();
                    d.jenis_hk = $("#jenis_hk").val();
                }
            },

            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [8],
                data: null,
                //defaultContent: "<button class='btn btn-success'>Complited</button>"
                render: function (data, type, row, meta) {
                    return "<button class='btn btn-primary btn-xs'>Detail</button>";
                }
            }
            ],

            columns: [
                { data: 'id_hhky', name: 'id_hhky' },
                { data: 'no_laporan', name: 'no_laporan' },
                { data: 'status_laporan', name: 'status_laporan' },
                { data: 'jenis_laporan', name: 'jenis_laporan' },
                { data: 'nama', name: 'nama' },
                { data: 'nik', name: 'nik' },
                { data: 'bagian', name: 'bagian' },
                { data: 'tempat_kejadian', name: 'tempat_kejadian' },
            ]
        });

        $("#tb_hk_inquery").on('click', '.btn-primary', function () {
            var data = listhk.row($(this).parents('tr')).data();
            window.location.href = APP_URL + "/hkdetail/" + data.id_hhky;
        });

        $("#btn_reload_status").click(function () {
            listhk.ajax.reload();
        });

        $("#btn-excel").click(function (e) {
            e.preventDefault();
            var tgl_awal = $("#tgl_awal").val();
            var tgl_akhir = $("#tgl_akhir").val();
            var status_hk = $("#status_hk").val();
            var jenis_hk = $("#jenis_hk").val();
            //alert(tgl_awal);
            //var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/hse/get_hseexcel",
                headers: { "token_req": key },
                //data: data,
                data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "status_hk": status_hk, "jenis_hk": jenis_hk },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        $("#modal-excel").modal('toggle');
                        var fpath = resp.file;
                        window.open(fpath, '_blank');
                        alert(resp.message);
                    } else
                        alert(resp.message);
                })

        });


    });


</script>
@endsection