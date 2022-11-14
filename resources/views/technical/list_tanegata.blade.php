@extends('layout.main')
@section('content')



<div class="card">
    <div class="card-header">
        <div class="card card-secondary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 float-left">
                        <h3 class="card-title"><b> MASTER TANEGATA</b></h3>
                    </div>
                </div>
                <div class="row align-center">

                </div>
            </div>
            <div class="card-tools">

            </div>
        </div>


        <!--<div class="row">
            <label for="" class="col-md-1 ">Status : </label>
            <select name="status_master" id="status_master" class="form-control col-md-2">
                <option value="All">All</option>
                <option value="Open">Open</option>
                <option value="Close">Close</option>
            </select>
            <button class="btn btn-primary btn-flat" id="btn_reload_status"><i class="fa fa-sync"></i></button>
        </div>
        <hr>-->
        <div class="card-tools">

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap" id="tb_master_tanegata">
                <thead>
                    <tr>
                        <th>Kode Tane</th>
                        <th>No Rak</th>
                        <th>D</th>
                        <th>B</th>
                        <th>T</th>
                        <th>DP</th>
                        <th style="white-space: normal; text-align: center;">Jml Omogata</th>
                        <th>DL</th>
                        <th>DS</th>
                        <th>IL</th>
                        <th>IS</th>
                        <th>B</th>
                        <th>T</th>
                        <th>NPRH</th>
                        <th>Kupingan</th>
                        <th>Remark</th>
                        <th>Tgl Cek</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            @if(Session::get('dept') == '' || Session::get('dept') == 'Admin')
            <button type="button" class="btn btn-secondary btn-flat" id="btn-add">Add</button>
            @endif
            <button type="button" class="btn btn-success btn-flat" id="btn-excel">Excel</button>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>


<!-- Modal Add -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_tanegata">

                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Kode Tane</label>
                        </div>
                        <label>:</label>
                        <div class="col col-md-3">
                            <input type="text" class="form-control" name="kode_tane" id="kode_tane" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>No Rak</label>
                        </div>
                        <label>:</label>
                        <div class="col col-md-3">
                            <input type="text" class="form-control" name="no_rak" id="no_rak" maxlength="4" required>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>D</label>
                            <input type="number" class="form-control" name="ut_d" id="ut_d" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>B</label>
                            <input type="number" class="form-control" name="ut_b" id="ut_b" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>T</label>
                            <input type="number" class="form-control" name="ut_t" id="ut_t" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>DP</label>
                            <input type="number" class="form-control" name="ut_dp" id="ut_dp" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Jml Omogata</label>
                            <input type="number" class="form-control" name="jml_omogata" id="jml_omogata">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>DL</label>
                            <input type="number" class="form-control" name="dl" id="dl" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>DS</label>
                            <input type="number" class="form-control" name="ds" id="ds" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>IL</label>
                            <input type="number" class="form-control" name="il" id="il" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>IS</label>
                            <input type="number" class="form-control" name="is" id="is" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>B</label>
                            <input type="number" class="form-control" name="b" id="b" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>T</label>
                            <input type="number" class="form-control" name="t" id="t" step="0.001">
                        </div>
                    </div>
                    <hr style="color: blue;">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>NPRH</label>
                            <select name="nprh" id="nprh" class="form-control" required>
                                <option value="">NPR / NPR-H ...</option>
                                <option value="NPR">NPR</option>
                                <option value="NPR-H">NPR-H</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Kupingan</label>
                            <select name="kupingan" id="kupingan" class="form-control" required>
                                <option value="">Pilih ...</option>
                                <option value="ADA">ADA</option>
                                <option value="TIDAK">TIDAK</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tgl Cek</label>
                            <input type="date" class="form-control" name="tgl_cek" id="tgl_cek">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <textarea name="keterangan" id="keterangan" cols="10" rows="2" class="form-control"
                                placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <p>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal"
                            id="btn-close">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" id="btn-save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Edit-->
<div class="modal fade" id="edit-master-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_tanegata">

                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>Kode Tane</label>
                        </div>
                        <label>:</label>
                        <div class="col col-md-3">
                            <input type="text" class="form-control" name="e-kode_tane" id="e-kode_tane" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>No Rak</label>
                        </div>
                        <label>:</label>
                        <div class="col col-md-3">
                            <input type="text" class="form-control" name="e-no_rak1" id="e-no_rak1" maxlength="4"
                                required disabled>
                            <input type="hidden" class="form-control" name="e-no_rak" id="e-no_rak" maxlength="4"
                                required>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>D</label>
                            <input type="number" class="form-control" name="e-ut_d" id="e-ut_d" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>B</label>
                            <input type="number" class="form-control" name="e-ut_b" id="e-ut_b" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>T</label>
                            <input type="number" class="form-control" name="e-ut_t" id="e-ut_t" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>DP</label>
                            <input type="number" class="form-control" name="e-ut_dp" id="e-ut_dp" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Jml Omogata</label>
                            <input type="number" class="form-control" name="e-jml_omogata" id="e-jml_omogata">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>DL</label>
                            <input type="number" class="form-control" name="e-dl" id="e-dl" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>DS</label>
                            <input type="number" class="form-control" name="e-ds" id="e-ds" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>IL</label>
                            <input type="number" class="form-control" name="e-il" id="e-il" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>IS</label>
                            <input type="number" class="form-control" name="e-is" id="e-is" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>B</label>
                            <input type="number" class="form-control" name="e-b" id="e-b" step="0.001">
                        </div>
                        <div class="form-group col-md-2">
                            <label>T</label>
                            <input type="number" class="form-control" name="e-t" id="e-t" step="0.001">
                        </div>
                    </div>
                    <hr style="color: blue;">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label>NPRH</label>
                            <select name="e-nprh" id="e-nprh" class="form-control" required>
                                <option value="">NPR / NPR-H ...</option>
                                <option value="NPR">NPR</option>
                                <option value="NPR-H">NPR-H</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Kupingan</label>
                            <select name="e-kupingan" id="e-kupingan" class="form-control" required>
                                <option value="">Pilih ...</option>
                                <option value="ADA">ADA</option>
                                <option value="TIDAK">TIDAK</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Tgl Cek</label>
                            <input type="date" class="form-control" name="e-tgl_cek" id="e-tgl_cek">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <textarea name="e-keterangan" id="e-keterangan" cols="10" rows="2" class="form-control"
                                placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                    <p>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal"
                            id="btn-close">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" id="e-btn-save">Save</button>
                    </div>
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

<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });


    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var master_tanegata = $('#tb_master_tanegata').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/technical/list_master_tanegata',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.status_master = $("#status_master").val();
                }
            },
            columnDefs: [
                {
                    targets: [17],
                    data: null,
                    defaultContent: "<button class='btn btn-primary btn-sm btn-flat'><i class='fa fa-edit'> Edit</i></button>"

                }
            ],

            columns: [
                { data: 'kode_tane', name: 'kode_tane' },
                { data: 'no_rak', name: 'no_rak' },
                { data: 'ut_d', name: 'ut_d' },
                { data: 'ut_b', name: 'ut_b' },
                { data: 'ut_t', name: 'ut_t' },
                { data: 'ut_dp', name: 'ut_dp' },
                { data: 'jml_omogata', name: 'jml_omogata' },
                { data: 'dl', name: 'dl' },
                { data: 'ds', name: 'ds' },
                { data: 'il', name: 'il' },
                { data: 'is', name: 'is' },
                { data: 'b', name: 'b' },
                { data: 't', name: 't' },
                { data: 'nprh', name: 'nprh' },
                { data: 'kupingan', name: 'kupingan' },
                { data: 'remark', name: 'remark' },
                { data: 'tgl_cek', name: 'tgl_cek' },
            ],
        });

        $("#btn_reload_status").click(function () {
            master_ppic.ajax.reload();
        });


        $('#tb_master_tanegata').on('click', '.btn-primary', function () {
            var data = master_tanegata.row($(this).parents('tr')).data();

            $("#e-kode_tane").val(data.kode_tane);
            $("#e-no_rak").val(data.no_rak);
            $("#e-no_rak1").val(data.no_rak);
            $("#e-ut_d").val(data.ut_d);
            $("#e-ut_b").val(data.ut_b);
            $("#e-ut_t").val(data.ut_t);
            $("#e-ut_dp").val(data.ut_dp);
            $("#e-jml_omogata").val(data.jml_omogata);
            $("#e-dl").val(data.dl);
            $("#e-ds").val(data.ds);
            $("#e-il").val(data.il);
            $("#e-is").val(data.is);
            $("#e-b").val(data.b);
            $("#e-t").val(data.t);
            $('#e-nprh option[value=' + data.nprh + ']').prop('selected', 'selected');
            $('#e-kupingan option[value=' + data.kupingan + ']').prop('selected', 'selected');
            $("#e-tgl_cek").val(data.tgl_cek);
            $("#e-keterangan").val(data.remark);

            $('#edit-master-modal').modal('show');
        });


        $("#btn-add").click(function () {
            $('#add-modal').modal('show');
        });

        //$("#btn-save").click(function () {
        $("#form_tanegata").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            //var kode = $("#kode_tane").val();
            //var rak = $("#ut_B").val();

            $.ajax({
                type: "POST",
                url: APP_URL + "/api/technical/save_add_master",
                headers: { "token_req": key },
                data: data,
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert(resp.message);
                        location.reload();
                    } else {
                        alert(resp.message);
                    }
                })

        });

        $("#form_edit_tanegata").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            //var kode = $("#kode_tane").val();
            //var rak = $("#no_rak").val();

            $.ajax({
                type: "POST",
                url: APP_URL + "/api/technical/save_edit_master",
                headers: { "token_req": key },
                data: data,
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert(resp.message);
                        location.reload();
                    } else {
                        alert(resp.message);
                    }
                })

        });

        $("#btn-update").click(function () {
            var part_no = $("#e-part_no").html();
            var grouping = $("#e-grouping").val();
            var pas = $("#e-pas").val();
            var material = $("#e-material").val();
            var futatsuwari = $("#e-futatsuwari").val();
            var mark = $("#e-mark").val();
            var mnaiara = $("#e-masternaiara").val();

            if (mnaiara == null || mnaiara == '') {
                alert('Master Naiara tidak boleh Null .')
            } else {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/ppic/edit_master",
                    headers: { "token_req": key },
                    data: { "part_no": part_no, "grouping": grouping, "pas": pas, "material": material, "futatsuwari": futatsuwari, "mark": mark, "mnaiara": mnaiara },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        } else {
                            alert(resp.message);
                        }
                    })
            }
        });


    });


</script>

@endsection