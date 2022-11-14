@extends('layout.main')
@section('content')

<div class="card card-warning card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                    role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Approve Jam Operator</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                    role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Approve OK</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">
                <div class="row">
                    <div class="col col-md-1"><label> Line</label></div>
                    <div class="col col-md-2">
                        <select name="selectline" id="selectline"
                            class="form-control select2 @error('line_proses') is-invalid @enderror" style="width: 100%;"
                            required>
                            <option value="All">All</option>
                            @foreach($proses as $p)
                            <option value="{{$p->line_proses}}">{{$p->nama_line}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col col-md-1" style="text-align: right;"><label> Shift</label></div>

                    <div class="col col-md-2">
                        <select name="selectshift" id="selectshift" class="form-control select2" style="width: 100%;"
                            required>
                            <option value="All">All</option>
                            <option value="SHIFT1">SHIFT 1</option>
                            <option value="SHIFT2">SHIFT 2</option>
                            <option value="SHIFT3">SHIFT 3</option>
                            <option value="NONSHIFT">NON SHIFT</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
                </div>
                <hr>

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_approve_jam_operator">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tgl Proses</th>
                                <th>Operator</th>
                                <th>Line</th>
                                <th>Shift</th>
                                <th>Jam Total</th>
                                <th>Keterangan</th>
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
                    <div class="col col-md-2">
                        <input type="date" class="form-control" id="tgl_awal" value="{{date('Y-m').'-01'}}">
                    </div>
                    <label for="" class="col-md-1 text-center">Sampai</label>
                    <input type="date" class="form-control col-md-2" id="tgl_akhir" value="{{date('Y-m-d')}}">

                    <div class="col col-md-1" style="text-align: right;"><label> Line</label></div>
                    <div class="col col-md-2">
                        <select name="selectline_1" id="selectline_1" class="form-control select2" style="width: 100%;"
                            required>
                            <option value="All">All</option>
                            @foreach($proses as $p)
                            <option value="{{$p->line_proses}}">{{$p->nama_line}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-primary" id="btn_reload_1"><i class="fa fa-sync"></i></button>
                </div>
                <hr>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_approve_jam_operator_1">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Tgl Proses</th>
                                <th>Operator</th>
                                <th>Line</th>
                                <th>Shift</th>
                                <th>Jam Total</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Approved</th>
                                <th>Tgl Approve</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Edit Jam Kerja Operator-->
<div class="modal fade" id="modal-editjamopr" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Jam Kerja Operator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-jamkerjaoperator">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id_jam_kerja" name="id_jam_kerja">
                    <div class="row">
                        <div class="col col-md-3"><label>Tgl Proses</label></div>
                        <label>:</label>
                        <div class="col col-md-4">
                            <label id="e-tgljamkerja" name="e-tgljamkerja"></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-3"><label>Operator</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="e-operator" name="e-operator"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3"><label>Shift</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <label id="e-shift" name="e-shift"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-3"><label>Jam Total</label></div>
                        <label>:</label>
                        <div class="col col-md-3">
                            <input type="number" id="e-jamtotal" name="e-jamtotal" class="form-control" step="0.01">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-3"><label>Keterangan</label></div>
                        <label>:</label>
                        <div class="col col-md-8">
                            <textarea id="e-keterangan" name="e-keterangan" class="form-control"
                                placeholder="Keterangan" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary btn-flat" value="Update">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script>
    $(function () {

        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');

        var tb_approve_jam_operator = $('#tb_approve_jam_operator').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/produksi/i_approve_jam_operator',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.selectshift = $("#selectshift").val();
                    d.selectline = $("#selectline").val();
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
                defaultContent: "</button><button class='btn btn-danger btn-sm btn-flat'>Edit</button> </button><button class='btn btn-primary btn-sm btn-flat'>Approve</button>"
            },
            ],
            columns: [
                { data: 'id_jam_kerja', name: 'id_jam_kerja' },
                { data: 'tgl_jam_kerja', name: 'tgl_jam_kerja' },
                { data: 'operator', name: 'operator' },
                { data: 'line_proses', name: 'line_proses' },
                { data: 'shift', name: 'shift' },
                { data: 'jam_total', name: 'jam_total' },
                { data: 'ket', name: 'ket' },
                { data: 'status', name: 'status' },
            ]
        });

        $("#tb_approve_jam_operator").on('click', '.btn-danger', function () {
            var data = tb_approve_jam_operator.row($(this).parents('tr')).data();
            $("#id_jam_kerja").val(data.id_jam_kerja);
            $("#e-tgljamkerja").html(data.tgl_jam_kerja);
            $("#e-operator").html(data.operator);
            $("#e-shift").html(data.shift);
            $("#e-jamtotal").val(data.jam_total);
            $("#e-keterangan").val(data.ket);
            $("#modal-editjamopr").modal("show");
        });

        $("#form-jamkerjaoperator").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL + '/api/produksi/edit_jamkerjaoperator',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {

                        alert(resp.message);
                        location.reload();
                    }
                    else
                        alert(resp.message);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        });

        var tb_approve_jam_operator_1 = $('#tb_approve_jam_operator_1').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/produksi/i_approve_jam_operator_1',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.tgl_awal = $("#tgl_awal").val();
                    d.tgl_akhir = $("#tgl_akhir").val();
                    d.selectline_1 = $("#selectline_1").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            ],
            columns: [
                { data: 'id_jam_kerja', name: 'id_jam_kerja' },
                { data: 'tgl_jam_kerja', name: 'tgl_jam_kerja' },
                { data: 'operator', name: 'operator' },
                { data: 'line_proses', name: 'line_proses' },
                { data: 'shift', name: 'shift' },
                { data: 'jam_total', name: 'jam_total' },
                { data: 'ket', name: 'ket' },
                { data: 'status', name: 'status' },
                { data: 'approve', name: 'approve' },
                { data: 'tgl_approve', name: 'tgl_approve' },
            ]
        });

        $("#btn_reload").click(function () {
            tb_approve_jam_operator.ajax.reload();
        });

        $("#btn_reload_1").click(function () {
            tb_approve_jam_operator_1.ajax.reload();
        });

        $('#tb_approve_jam_operator').on('click', '.btn-primary', function () {
            var data = tb_approve_jam_operator.row($(this).parents('tr')).data();

            var conf = confirm(data.operator + "   " + data.shift + "   " + data.jam_total + " Jam" + "\n" + "Keterangan  : " + data.ket);
            if (conf) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/produksi/approve_jam_kerja",
                    headers: { "token_req": key },
                    data: { "id_jam_kerja": data.id_jam_kerja },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            //window.location = window.location;
                            location.reload();
                        }
                        else {
                            alert(resp.message);
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            }
        });

    });

</script>
@endsection