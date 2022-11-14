@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">List Daichou</h3>
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
                <label for="" class="col-md-1 ">Location : </label>
                <select name="c_location" id="c_location" class="form-control col-md-2">
                    <option value="All">All</option>
                    @foreach($loc as $l)
                    <option value="{{$l->lokasi}}">{{$l->lokasi}}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
            </div>
            <br> -->
            <table class="table table-hover text-nowrap" id="tb_listdaichou">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>No Induk</th>
                        <th>Machine</th>
                        <th>Jigu</th>
                        <th>Size</th>
                        <th>Kigou</th>
                        <th>Location</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <!--    <button class="btn btn-secondary btn-flat" id="btn-print">Print</button> -->
            <button class="btn btn-success btn-flat" id="btn-excel">Download Excel</button>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<!-- Modal excel -->
<div class="modal fade" id="modal-excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Print Out Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
                <div class="row">
                    <div class="col col-md-3"><label>List Data</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <select name="e-data" id="e-data" class="form-control" required>
                            <option value="daichou">Daichou</option>
                            <option value="pengeluaranjigu">Pengeluaran Jigu</option>
                        </select>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <label for="" class="col-md-3">Period</label>
                    <label>:</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" id="tgl_awal" name="tgl_awal"
                            value="{{date('Y-m').'-01'}}">
                    </div>
                    <label>~</label>
                    <div class="col col-md-4">
                        <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir"
                            value="{{date('Y-m-d')}}">
                    </div>
                </div>
                </p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-export-excel">Export Excel</button>
                </div>
            </div>
        </div>
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
            var lokasi = $('#c_location').val();
            var listdaichou = $('#tb_listdaichou').DataTable({
                processing: true,
                serverSide: true,
                searching: true,

                ajax: {
                    url: APP_URL + '/api/qa/listdaichou',
                    type: "POST",
                    headers: { "token_req": key },
                    data: { "lokasi": lokasi },
                    /*data: function (d) {
                        d.lokasi = $("#c_location").val();
                    }*/
                },

                columnDefs: [{
                    targets: [0],
                    visible: false,
                    searchable: false
                }
                ],

                columns: [
                    { data: 'id_jigu', name: 'id_jigu' },
                    { data: 'no_induk', name: 'no_induk' },
                    { data: 'nama_mesin', name: 'nama_mesin' },
                    { data: 'nama_jigu', name: 'nama_jigu' },
                    { data: 'ukuran', name: 'ukuran' },
                    { data: 'kigou', name: 'kigou' },
                    { data: 'lokasi', name: 'lokasi' },
                ]
            });

            $("#btn_reload_status").click(function () {
                listdaichou.ajax.reload();
            });

            $("#tgl_awal").prop("disabled", true);
            $("#tgl_akhir").prop("disabled", true);

            $("#e-data").change(function () {
                var value = $(this).val();
                if (value == 'daichou') {
                    $("#tgl_awal").prop("disabled", true);
                    $("#tgl_akhir").prop("disabled", true);
                } else {
                    $("#tgl_awal").prop("disabled", false);
                    $("#tgl_akhir").prop("disabled", false);
                }
            });

            $("#btn-excel").click(function () {
                $("#modal-excel").modal('show');
            });

            $("#btn-export-excel").click(function () {
                var data = $("#e-data").val();
                var tawal = $("#tgl_awal").val();
                var takhir = $("#tgl_akhir").val();
                var conf = confirm("Do you want to Download Excel ?");
                if (conf) {
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/qa/listdaichou/get_excel",
                        headers: { "token_req": key },
                        data: { 'data': data, 'tawal': tawal, 'takhir': takhir },
                        dataType: "json",

                        success: function (response) {
                            var fpath = response.file;
                            window.open(fpath, '_blank');
                        }
                    });
                }
            });


        });


    </script>
    @endsection