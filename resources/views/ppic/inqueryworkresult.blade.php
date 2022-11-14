@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">List Work Result</h3>
                    </div>

                    <div class="row text-center">
                        <input type="date" class="form-control col-md-4" id="tgl_awal" value="{{date('Y-m').'-01'}}">
                        <label for="" class="col-md-2 text-center">Sampai</label>
                        <input type="date" class="form-control col-md-4" id="tgl_akhir" value="{{date('Y-m-d')}}">
                        <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
                    </div>

                </div>
            </div>
            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap" id="tb_workresult">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>User Name</th>
                        <th>Tanggal Keluar</th>
                        <th>Barcode No</th>
                        <th>Part No</th>
                        <th>Jby</th>
                        <th>Lot No</th>
                        <th>Qty</th>
                        <th>No Tag</th>
                        <th>Nouki</th>
                        <th>Start</th>
                        <th>Tgl Kamu</th>
                        <th>Finish</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Comp/F</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-success" id="btn-excel">Excel</button>
            <button type="button" class="btn btn-success" id="btn-pdf">PDF</button>
            <a href="{{url('/technical/inquery-update')}}" class="btn btn-secondary"> List Update Denpyou</a>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>



<!-- Modal Excel -->
<div class="modal fade" id="excel-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Excel Work Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col col-md-12">

                    <input type="date" class="col col-md-4" id="tgl_awal" value="{{date('Y-m').'-01'}}">
                    <label for="" class="col-md-2 text-center">Sampai</label>
                    <input type="date" class="col col-md-4" id="tgl_akhir" value="{{date('Y-m-d')}}">
                </div>
                <div class="row">
                    <div class="col col-md-3"><label>Type Ring</label></div>
                    <label>:</label>
                    <div class="col col-md-7">
                        <select name="crf" id="crf" class="form-control" required>
                            <option value="All">All</option>
                            <option value="Cr">Cr</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                </div>
                <p>

                </p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-export">Export Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal PDF-->
<div class="modal fade" id="pdf-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">PDF Work Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="pdf" action="{{url ('pdfworkresult')}}" target="_blank">
                    <div class="col col-md-12">
                        @csrf
                        <input type="date" class="col col-md-4" id="tgl_awal_1" name="tgl_awal_1"
                            value="{{date('Y-m').'-01'}}">
                        <label for="" class="col-md-2 text-center">Sampai</label>
                        <input type="date" class="col col-md-4" id="tgl_akhir_1" name="tgl_akhir_1"
                            value="{{date('Y-m-d')}}">
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Type Ring</label></div>
                        <label>:</label>
                        <div class="col col-md-7">
                            <select name="crf_1" id="crf_1" class="form-control" required>
                                <option value="All">All</option>
                                <option value="Cr">Cr</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                    <p>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-export-pdf">Export PDF</button>
                    </div>
                </form>
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
        var workresult = $('#tb_workresult').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/inquery_workresult',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.tgl_awal = $("#tgl_awal").val();
                    d.tgl_akhir = $("#tgl_akhir").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [15],
                data: null,

                //defaultContent: "<button class='btn btn-success'>Complited</button>"
                render: function (data, type, row, meta) {
                    var stat = data.part_no;
                    if (stat.substr(3, 1) == "D" || stat.substr(3, 1) == "F") {
                        return "Cr";
                    } else {
                        return "F";

                    }
                }
            },
            {
                targets: [16],
                data: null,
                defaultContent: "<button class='btn btn-danger'><i class='fa fa-trash'></i></button>"

            }
            ],

            columns: [
                { data: 'id_workresult', name: 'id_workresult' },
                { data: 'user_name', name: 'user_name' },
                { data: 'tgl_keluar', name: 'tgl_keluar' },
                { data: 'barcode_no', name: 'barcode_no' },
                { data: 'part_no', name: 'part_no' },
                { data: 'jby', name: 'jby' },
                { data: 'lot_no', name: 'lot_no' },
                { data: 'qty', name: 'qty' },
                { data: 'no_tag', name: 'no_tag' },
                { data: 'nouki', name: 'nouki' },
                { data: 'start', name: 'start' },
                { data: 'msk_kamu', name: 'msk_kamu' },
                { data: 'finish', name: 'finish' },
                { data: 'customer', name: 'customer' },
                { data: 'masalah', name: 'masalah' },
            ],
            fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                if (data.masalah == "NG") {
                    $('td', nRow).css('background-color', '#ff9966');
                    $('td', nRow).css('color', 'White');
                }
            },
        });

        $("#btn_reload").click(function () {
            var date1 = $("#tgl_awal").val();
            var date2 = $("#tgl_akhir").val();
            workresult.ajax.reload();
        });

        $("#btn-excel").click(function () {
            var data = workresult.row($(this).parents('tr')).data();
            $('#excel-modal').modal('show');
        });

        $("#btn-pdf").click(function () {
            var data = workresult.row($(this).parents('tr')).data();
            $('#pdf-modal').modal('show');
        });

        $("#btn-export").click(function () {
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
            var crf = $('#crf').val();
            var part_no = $('#part_no').val();

            $.ajax({
                type: "POST",
                url: APP_URL + "/api/workresult/get_excel",
                headers: { "token_req": key },
                data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "crf": crf, "part_no": part_no },
                dataType: "json",

                /*   success: function (response) {
                       var fpath = response.file;
                       window.open(fpath, '_blank');
   
                   } */
            })
                .done(function (resp) {
                    if (resp.success) {
                        var fpath = resp.file;
                        window.open(fpath, '_blank');
                    } else
                        alert(resp.message);
                })

        });

        /*    $("#btn-export-pdf").click(function () {
                //var data = workresult.row($(this).parents('tr')).data();
                var tgl_awal = $('#tgl_awal_1').val();
                var tgl_akhir = $('#tgl_akhir_1').val();
                var crf = $('#crf_1').val();
                window.open(APP_URL + "/pdfworkresult/?tgl_awal=" + tgl_awal + "&tgl_akhir=" + tgl_akhir + "&crf=" + crf, '_blank');
    
    
            }); */

        $("#tb_workresult").on('click', '.btn-danger', function () {
            var data = workresult.row($(this).parents('tr')).data();
            var conf = confirm("Apakah Lot No. " + data.lot_no + " akan dihapus?");
            if (conf) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/hapus/workresult",
                    headers: {
                        "token_req": key
                    },
                    data: {
                        "id": data.id_workresult
                    },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert("Hapus request berhasil");
                            //window.location.href = "{{ route('req_workresult')}}";
                            workresult.ajax.reload();
                        } else
                            $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            }

        });
    });


</script>

@endsection