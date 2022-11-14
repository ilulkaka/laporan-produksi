@extends('layout.main')
@section('content')

<div class="card card-info card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                    role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">CheckOut Request</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                    role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">List Ordered</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <div class="row">
                        <label for="" class="col-md-1 ">Status : </label>
                        <select name="status_order" id="status_order" class="form-control col-md-2" value="CheckOut">
                            <option value="CheckOut">CheckOut</option>
                            <option value="Ordered">Repair</option>
                            <option value="In">In</option>
                            <option value="Out">Out</option>
                            <option value="All">All</option>
                        </select>
                        <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
                    </div>
                    <br>
                    <table class="table table-hover text-nowrap" id="tb_jigu">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Request date</th>
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
                <!-- /.card-body -->
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                aria-labelledby="custom-tabs-one-profile-tab">

                <div class="row">
                    <label for="" class="col-md-1 ">Status : </label>
                    <select name="ostatus" id="ostatus" class="form-control col-md-2" value="proses">

                        <option value="Order">Order</option>
                        <option value="Arrive">Arrive</option>
                        <option value="All">All</option>
                    </select>
                    <button class="btn btn-primary" id="btn_reload_status1"><i class="fa fa-sync"></i></button>
                </div>
                <br>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_order">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Machine</th>
                                <th>Kode Gambar</th>
                                <th>Jigu</th>
                                <th>Kigou</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Nouki</th>
                                <th>Received Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
                <input type="hidden" id="edit-idjigu">
                <div class="row">
                    <div class="col col-md-4"><label>No. Registration</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="edit-noindukjigu"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>Machine / Jigu</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-machine"></label>
                        <label> / </label>
                        <label id="edit-jigu"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Kigou / Size</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-kigou"></label>
                        <label> / </label>
                        <label id="edit-size"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Drawing No</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-drawingno"></label>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col col-md-4"><label>Corrective Action</label>
                        <select name="edit-correctiveaction" id="edit-correctiveaction" class="form-control">
                            <option value="NG">NG</option>
                            <option value="Repair">Repair</option>
                        </select>
                    </div>
                    <div class="col col-md-3"><label>Location</label>
                        <input type="text" class="form-control" id="edit-lokasi" name="edit-lokasi" required>
                    </div>
                    <div class="col col-md-1"><label>Cek</label>
                        <input type="button" class="btn btn-secondary" id="btn-lokasi" value="?">
                    </div>
                    <div class="col col-md-4"><label>No Registration Old</label>
                        <input type="text" class="form-control" id="edit-registrationold" name="edit-registrationold">
                    </div>
                </div>
                <hr>
                <!--<div class="row">
                    <div class="col col-md-3"><label>Kigou After</label>
                        <input type="text" class="form-control" id="edit-kigouafter" name="edit-kigouafter" required>
                    </div>
                    <div class="col col-md-3"><label>Size After</label>
                        <input type="text" class="form-control" id="edit-sizeafter" name="edit-sizeafter" required>
                    </div>-->
                <div class="col col-md-6"><label>Reason</label>
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

<!--Modal Repair-->
<!--<form action="{{url('qa/qarepair')}}" method="post">
    {{csrf_field()}} -->
<div class="modal fade" id="modal-repair" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Repair Jigu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="r-idjigu">
                <div class="row">
                    <div class="col col-md-4"><label>No. Registration</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="r-noindukjigu"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>Machine / Jigu</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="r-machine"></label>
                        <label> / </label>
                        <label id="r-jigu"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Kigou / Size</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="r-kigou"></label>
                        <label> / </label>
                        <label id="r-size"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Drawing No</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="r-drawingno"></label>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col col-md-5"><label>No. Request TCH</label>
                        <input type="hidden" class="form-control" id="r_requesttch_1" name="r_requesttch_1" required>
                        <input type="text" class="form-control" id="r_requesttch" name="r_requesttch" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-6"><label>Nouki</label>
                        <input type="date" class="form-control" id="r-nouki" name="r-nouki" required>
                    </div>
                    <div class="col col-md-3"><label>Kigou After</label>
                        <input type="text" class="form-control" id="r-kigouafter" name="r-kigouafter" required>
                    </div>
                    <div class="col col-md-3"><label>Size After</label>
                        <input type="text" class="form-control" id="r-sizeafter" name="r-sizeafter" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Reason</label>
                        <input type="text" class="form-control" id="r-reason" required>
                    </div>
                    <div class="col col-md-8"><label>Repair Request</label>
                        <input type="text" class="form-control" id="r-repairrequest" required>
                    </div>
                </div>
                <hr>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-repair">Update Repair</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Pengeluaran Jigu-->
<div class="modal fade" id="modal-in" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Dispensing Jigu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="i-idjigu">
                <div class="row">
                    <div class="col col-md-4"><label>No. Registration</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="i-noindukjigu"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>Machine / Jigu</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="i-machine"></label>
                        <label> / </label>
                        <label id="i-jigu"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Kigou / Size</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="i-kigou"></label>
                        <label> / </label>
                        <label id="i-size"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Drawing No</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="i-drawingno"></label>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col col-md-4"><label>Corrective Action</label>
                        <select name="i-correctiveaction" id="i-correctiveaction" class="form-control">
                            <option value="NG">NG</option>
                            <option value="Repair">Repair</option>
                        </select>
                    </div>
                    <div class="col col-md-4"><label>Status</label>
                        <select name="i-status" id="i-status" class="form-control">
                            <option value="Out">Out</option>
                        </select>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-in">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Tindakan jigu setelah di repair-->
<div class="modal fade" id="modal-inrepair" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Jigu After Repair</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="ir-idjigu">
                <div class="row">
                    <div class="col col-md-4"><label>No. Registration</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="ir-noindukjigu"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>Machine / Jigu</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="ir-machine"></label>
                        <label> / </label>
                        <label id="ir-jigu"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Kigou / Size</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="ir-kigou"></label>
                        <label> / </label>
                        <label id="ir-size"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Drawing No</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="ir-drawingno"></label>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col col-md-4"><label>Status</label>
                        <select name="ir-status" id="ir-status" class="form-control">
                            <option value="In">In</option>
                            <option value="Stock">Stock</option>
                        </select>
                    </div>
                    <div class="col col-md-4"><label>Location</label>
                        <input type="text" class="form-control" id="ir-location" name="ir-location" required>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-inrepair">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-jiguorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Nouki Date</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="o-requestjigu">
                <div class="row">
                    <div class="col col-md-4"><label>JIGU</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="o-jigu"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>NOUKI</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <input type="date" class="form-control" id="o-nouki" name="o-nouki">
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-order">Update</button>
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
        $("#edit-kigouafter").prop("disabled", true);
        $("#edit-sizeafter").prop("disabled", true);

        var key = localStorage.getItem('npr_token');
        var listjigu = $('#tb_jigu').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: APP_URL + '/api/qa/inqueryjigu',
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
                    if (data.status == 'CheckOut') {
                        return "<button class='btn btn-primary btn-xs'>Process</button>";
                    } else if (data.status == 'Process Repair' || data.status == 'Stock') {
                        return "<button class='btn btn-secondary1 btn-xs'><u>Edit</u></button> <button class='btn btn-danger1 btn-xs disabled'><u>Repair</u></button>";
                    } else if (data.status == 'In') {
                        return "<button class='btn btn-secondary btn-xs'>Edit</button>";
                    } else if (data.tindakan_perbaikan == 'Repair') {
                        return "<button class='btn btn-secondary btn-xs'>Edit</button> <button class='btn btn-danger btn-xs'>Repair</button>";
                    } else if (data.tindakan_perbaikan == 'NG') {
                        return "";
                    } else {
                        return "<button class='btn btn-secondary btn-xs'>Edit</button>";
                    }
                }
            }
            ],

            columns: [
                { data: 'id_jigu', name: 'id_jigu' },
                { data: 'tgl_permintaan', name: 'tgl_permintaan' },
                { data: 'nama_mesin', name: 'nama_mesin' },
                { data: 'nama_jigu', name: 'nama_jigu' },
                { data: 'kigou', name: 'kigou' },
                { data: 'ukuran', name: 'ukuran' },
                { data: 'no_induk', name: 'no_induk' },
                { data: 'status', name: 'status' },
            ]
        });

        var listjiguorder = $('#tb_order').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: APP_URL + '/api/qa/inqueryorder',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.ostatus = $("#ostatus").val();
                }
            },
            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            ],

            columns: [
                { data: 'user', name: 'user' },
                { data: 'nama_mesin', name: 'nama_mesin' },
                { data: 'kode_gambar', name: 'kode_gambar' },
                { data: 'nama_jigu', name: 'nama_jigu' },
                { data: 'kigou', name: 'kigou' },
                { data: 'ukuran', name: 'ukuran' },
                { data: 'qty', name: 'qty' },
                {
                    data: 'nouki', name: 'nouki', render: function (data, type, row, meta) {
                        if (data == null) {
                            return "<button class='btn far fa-calendar-plus btn-flat'>";
                        } else {
                            return data;
                        }
                    }
                },
                { data: 'tgl_datang', name: 'tgl_datang', },
                { data: 'status', name: 'status' },
            ]
        });

        $("#btn_reload_status").click(function () {
            listjigu.ajax.reload();
        });

        $("#btn_reload_status1").click(function () {
            listjiguorder.ajax.reload();
        });

        $('#tb_order').on('click', '.fa-calendar-plus', function () {
            var data = listjiguorder.row($(this).parents('tr')).data();
            $("#o-requestjigu").val(data.id_requestjigu_manual);
            $("#o-jigu").html(data.nama_jigu);
            $('#modal-jiguorder').modal('show');
        });

        $("#btn-order").click(function () {
            var idjigu = $("#o-requestjigu").val();
            var jigu = $("#o-jigu").html();
            var tgl = $("#o-nouki").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/noukimanual",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "jigu": jigu, "tgl": tgl,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Create data Success.");
                        //href="#custom-tabs-one-profile"
                        location.reload();
                    } else
                        alert(resp.message);
                    location.reload();
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });

        $('#tb_jigu').on('click', '.btn-primary', function () {
            var data = listjigu.row($(this).parents('tr')).data();
            $("#edit-idjigu").val(data.id_jigu);
            $("#edit-noindukjigu").html(data.no_induk);
            $("#edit-machine").html(data.nama_mesin);
            $("#edit-jigu").html(data.nama_jigu);
            $("#edit-kigou").html(data.kigou);
            $("#edit-size").html(data.ukuran);
            $("#edit-drawingno").html(data.kode_gambar);
            $("#edit-lokasi").val(data.lokasi1);
            $("#edit-registrationold").val(data.no_induk_lama);
            $('#modal-proses').modal('show');
        });

        $("#btn-process").click(function () {
            var idjigu = $("#edit-idjigu").val();
            var noinduk = $("#edit-noindukjigu").html();
            var machine = $("#edit-machine").html();
            var jigu = $("#edit-jigu").html();
            var kigou = $("#edit-kigou").html();
            var size = $("#edit-size").html();
            var user = $("#edit-user").val();
            var type = $("#edit-correctiveaction").val();
            var lokasi = $("#edit-lokasi").val();
            var old = $("#edit-registrationold").val();
            var reason = $("#edit-reason").val();
            var kigou_after = $("#edit-kigouafter").val();
            var ukuran_after = $("#edit-sizeafter").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/qaprocess",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "noinduk": noinduk, "nama_mesin": machine, "jigu": jigu, "kigou": kigou,
                    "size": size, "user": user, "type": type, "old": old, "lokasi": lokasi, "reason": reason,
                    "kigou_after": kigou_after, "ukuran_after": ukuran_after,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    $("#edit-lokasi").val(resp.m);
                    if (resp.success) {
                        alert("Create data Success.");
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        location.reload();
                    } else
                        alert(resp.message);
                    location.reload();
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });


        $('#tb_jigu').on('click', '.btn-danger', function () {
            var data = listjigu.row($(this).parents('tr')).data();
            $("#r-idjigu").val(data.id_jigu);
            $("#r-noindukjigu").html(data.no_induk);
            $("#r-machine").html(data.nama_mesin);
            $("#r-jigu").html(data.nama_jigu);
            $("#r-kigou").html(data.kigou);
            $("#r-size").html(data.ukuran);
            $("#r-drawingno").html(data.kode_gambar);
            $('#modal-repair').modal('show');
        });

        $("#btn-repair").click(function () {
            var idjigu = $("#r-idjigu").val();
            var noinduk = $("#r-noindukjigu").html();
            var machine = $("#r-machine").html();
            var jigu = $("#r-jigu").html();
            var kigou = $("#r-kigou").html();
            var size = $("#r-size").html();
            var user = $("#r-user").val();
            var type = $("#r-correctiveaction").val();
            var lokasi = $("#r-lokasi").val();
            var old = $("#r-registrationold").val();
            var reason = $("#r-reason").val();
            var kigou_after = $("#r-kigouafter").val();
            var ukuran_after = $("#r-sizeafter").val();
            var no_laporan = $("#r_requesttch").val();
            var nouki = $("#r-nouki").val();
            var repairrequest = $("#r-repairrequest").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/qarepair",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "noinduk": noinduk, "nama_mesin": machine, "jigu": jigu, "kigou": kigou,
                    "size": size, "user": user, "type": type, "old": old, "lokasi": lokasi, "reason": reason,
                    "kigou_after": kigou_after, "ukuran_after": ukuran_after, "no_laporan": no_laporan,
                    "nouki": nouki, "repairrequest": repairrequest,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Create data Success.");
                        location.reload();
                    } else
                        alert(resp.message);
                    location.reload();
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });

        $('#tb_jigu').on('click', '.btn-secondary', function () {
            var data = listjigu.row($(this).parents('tr')).data();
            $("#i-idjigu").val(data.id_jigu);
            $("#i-noindukjigu").html(data.no_induk);
            $("#i-machine").html(data.nama_mesin);
            $("#i-jigu").html(data.nama_jigu);
            $("#i-kigou").html(data.kigou);
            $("#i-size").html(data.ukuran);
            $("#i-drawingno").html(data.kode_gambar);
            $('#modal-in').modal('show');
        });

        $('#tb_jigu').on('click', '.btn-secondary1', function () {
            var data = listjigu.row($(this).parents('tr')).data();
            $("#ir-idjigu").val(data.id_jigu);
            $("#ir-noindukjigu").html(data.no_induk);
            $("#ir-machine").html(data.nama_mesin);
            $("#ir-jigu").html(data.nama_jigu);
            $("#ir-kigou").html(data.kigou);
            $("#ir-size").html(data.ukuran);
            $("#ir-drawingno").html(data.kode_gambar);
            $('#modal-inrepair').modal('show');
        });

        $("#btn-in").click(function () {
            var idjigu = $("#i-idjigu").val();
            var noinduk = $("#i-noindukjigu").html();
            var machine = $("#i-machine").html();
            var jigu = $("#i-jigu").html();
            var kigou = $("#i-kigou").html();
            var size = $("#i-size").html();
            var drawing = $("#i-drawingno").html();
            var corrective = $("#i-correctiveaction").val();
            var status = $("#i-status").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/inrepair",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "noinduk": noinduk, "machine": machine, "jigu": jigu, "kigou": kigou, "size": size, "drawing": drawing,
                    "corrective": corrective, "status": status,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Create data Success.");
                        location.reload();
                    } else
                        alert(resp.message);
                    location.reload();
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });

        $("#btn-inrepair").click(function () {
            var idjigu = $("#ir-idjigu").val();
            var noinduk = $("#ir-noindukjigu").html();
            var machine = $("#ir-machine").html();
            var jigu = $("#ir-jigu").html();
            var kigou = $("#ir-kigou").html();
            var size = $("#ir-size").html();
            var drawing = $("#ir-drawingno").html();
            var status = $("#ir-status").val();
            var location1 = $("#ir-location").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/inrepair",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "noinduk": noinduk, "machine": machine, "jigu": jigu, "kigou": kigou, "size": size, "drawing": drawing,
                    "location1": location1, "status": status,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Create data Success.");
                        location.reload();
                    } else
                        alert(resp.message);
                    location.reload();
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });


        $("#btn-lokasi").click(function () {
            var idjigu = $("#edit-idjigu").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/getlokasi",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    $("#edit-lokasi").val(resp.m);
                    if (resp.m == "") {
                        alert("Location not found, please input new location .");
                    }
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

        $("#edit-correctiveaction").change(function () {
            var value = $(this).val();
            if (value == 'Repair') {
                $("#edit-kigouafter").prop("disabled", false);
                $("#edit-sizeafter").prop("disabled", false);
            } else {
                $("#edit-kigouafter").prop("disabled", true);
                $("#edit-sizeafter").prop("disabled", true);
            }
        });

        $('#r-nouki').change(function () {
            var idjigu = $("#r-idjigu").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/qa/getnomertch",

                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    $("#r_requesttch").val(resp[0].no_laporan);
                    $("#r_requesttch_1").val(resp[0].no_laporan);
                    //].no_laporan);
                })
                .fail(function (resp) {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });

    });



</script>

@endsection