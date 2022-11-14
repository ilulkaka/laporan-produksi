@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">List No Registration</h3>
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
            <table class="table table-hover text-nowrap" id="tb_noinduk">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Arrive date</th>
                        <th>Machine</th>
                        <th>Jigu</th>
                        <th>Kigou</th>
                        <th>Size</th>
                        <th>No Registration</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <label>QA Dept</label>
            <button type="button" class="float-right" id="request-manual" style="color: blue;">Please Click here if No
                data in
                table</button>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>


<!--Modal Prosess-->
<div class="modal fade" id="modal-proses" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Process Request Jigu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="edit-noinduk">
                <div class="row">
                    <div class="col col-md-4"><label>No. Registration</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="edit-noindukjigu"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-3"><label>Machine</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-machine"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-3"><label>Jigu</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-jigu"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-3"><label>Kigou</label></div>
                    <label>:</label>
                    <div class="col col-md-8">
                        <label id="edit-kigou"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-3"><label>Size</label></div>
                    <label>:</label>
                    <div class="col col-md-8">
                        <label id="edit-size"></label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col col-md-4"><label>User</label>
                        <input type="text" class="form-control" id="edit-user" required>
                    </div>
                    <div class="col col-md-3"><label>Type Request</label>
                        <select name="edit-typerequest" id="edit-typerequest" class="form-control">
                            <option value="New">New</option>
                        </select>
                    </div>

                    <div class="col col-md-5"><label>No Registration Old</label>
                        <input type="text" class="form-control" id="edit-registrationold" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col col-md-2"><label>Reason</label></div>
                    <label>:</label>
                    <div class="col col-md-19">
                        <input type="text" class="form-control" id="edit-reason" required>
                    </div>
                </div>
                <p></p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-process">Process</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_request_manual" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="user">User</label>
                        <input type="text" class="form-control" name="m-user" id="m-user" placeholder="user" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nama_mesin">Machine</label>
                        <select name="m-nama_mesin" id="m-nama_mesin"
                            class="form-control select2 @error('nama_mesin') is-invalid @enderror" style="width: 100%;"
                            required>
                            <option value="">Choose...</option>
                            @foreach($mesin as $m)
                            <option value="{{$m->nama_mesin}}">{{$m->nama_mesin }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nama_jigu">Jigu</label>
                        <select name="m-nama_jigu" id="m-nama_jigu"
                            class="form-control select2 @error('nama_jigu') is-invalid @enderror" style="width: 100%;"
                            required>
                            <option value="">Choose...</option>
                            @foreach($mesin as $m)
                            <option value="{{$m->nama_jigu}}">{{$m->nama_jigu }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="kigou">Kigou</label>
                        <input type="text" class="form-control" name="m-kigou" id="m-kigou" placeholder="kigou">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="ukuran">Size</label>
                        <input type="text" class="form-control" name="m-ukuran" id="m-ukuran" placeholder="Size Jigu">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="qty">Qty</label>
                        <input type="number" class="form-control" name="m-qty" id="m-qty" value="1" placeholder="qty">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="kode_gambar">Drawing No</label>
                        <input type="text" class="form-control" name="m-kode_gambar" id="m-kode_gambar"
                            placeholder="Drawing Number">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    <input type="submit" class="btn btn-primary" id="btn_simpan" name="btn_simpan" value="Save & Print">
                </div>
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
        var listjigu = $('#tb_noinduk').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: APP_URL + '/api/jigu/inquerynoinduk',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.status_order = $("#status_order").val();
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
                    if (data.status == 'Stock') {
                        return "<button class='btn btn-primary btn-xs'>Process</button>";
                    } else if (data.status == 'Ordered') {
                        return "<button class='btn btn-danger btn-xs'>Print</button>";
                    } else {
                        return "";
                    }
                }
            }
            ],

            columns: [
                { data: 'id_noinduk_jigu', name: 'id_noinduk_jigu' },
                { data: 'tgl_datang', name: 'tgl_datang' },
                { data: 'nama_mesin', name: 'nama_mesin' },
                { data: 'nama_jigu', name: 'nama_jigu' },
                { data: 'kigou', name: 'kigou' },
                { data: 'ukuran', name: 'ukuran' },
                { data: 'no_induk_jigu', name: 'no_induk_jigu' },
                { data: 'status', name: 'status' },
            ]
        });

        $('#tb_noinduk').on('click', '.btn-primary', function () {
            var data = listjigu.row($(this).parents('tr')).data();
            $("#edit-noinduk").val(data.id_noinduk_jigu);
            $("#edit-noindukjigu").html(data.no_induk_jigu);
            $("#edit-machine").html(data.nama_mesin);
            $("#edit-jigu").html(data.nama_jigu);
            $("#edit-kigou").html(data.kigou);
            $("#edit-size").html(data.ukuran);
            $('#modal-proses').modal('show');
        });

        $("#btn-process").click(function () {
            var idjigu = $("#edit-noinduk").val();
            var noinduk = $("#edit-noindukjigu").html();
            var machine = $("#edit-machine").html();
            var jigu = $("#edit-jigu").html();
            var kigou = $("#edit-kigou").html();
            var size = $("#edit-size").html();
            var user = $("#edit-user").val();
            var type = $("#edit-typerequest").val();
            var old = $("#edit-registrationold").val();
            var reason = $("#edit-reason").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/jigu/process",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "noinduk": noinduk, "nama_mesin": machine, "jigu": jigu, "kigou": kigou, "size": size, "user": user, "type": type, "reason": reason, "old": old,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Create data Success.");
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        location.reload();
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });


        $('#tb_noinduk').on('click', '.btn-danger', function () {
            var data = listjigu.row($(this).parents('tr')).data();

            var conf = confirm("No. " + data.no_induk_jigu);
            if (conf) {
                window.open(APP_URL + "/cetak_permintaan_jigu/" + data.id_noinduk_jigu, '_blank');
            }

        });

        $("#request-manual").click(function () {
            $('#modal_request_manual').modal("show");
        });

        $("#btn_simpan").click(function () {
            var user = $("#m-user").val();
            var mesin = $("#m-nama_mesin").val();
            var jigu = $("#m-nama_jigu").val();
            var kigou = $("#m-kigou").val();
            var ukuran = $("#m-ukuran").val();
            var qty = $("#m-qty").val();
            var kode_gambar = $("#m-kode_gambar").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/jigu/requestmanual",
                headers: {
                    "token_req": key
                },
                data: {
                    "user": user,
                    "mesin": mesin, "jigu": jigu, "kigou": kigou, "ukuran": ukuran, "qty": qty, "kode_gambar": kode_gambar,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert(resp.message);
                        window.open(APP_URL + "/cetak_request_manual", '_blank');
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        location.reload();
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

    });




</script>

@endsection