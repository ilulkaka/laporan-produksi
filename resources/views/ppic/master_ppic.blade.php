@extends('layout.main')
@section('content')



<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12 float-left">
                        <h3 class="card-title"><b> Master PPIC</b></h3>
                    </div>
                </div>
                <div class="row align-center">

                </div>
            </div>
            <div class="card-tools">

            </div>
        </div>


        <div class="row">
            <label for="" class="col-md-1 ">Status : </label>
            <select name="status_master" id="status_master" class="form-control col-md-2">
                <option value="All">All</option>
                <option value="Open">Open</option>
                <option value="Close">Close</option>
            </select>
            <button class="btn btn-primary btn-flat" id="btn_reload_status"><i class="fa fa-sync"></i></button>
        </div>
        <hr>
        <div class="card-tools">

        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap" id="tb_master_ppic">
                <thead>
                    <tr>
                        <th>Part No</th>
                        <th>Grouping</th>
                        <th>PAS</th>
                        <th>Material</th>
                        <th>Futatsuwari</th>
                        <th>Mark</th>
                        <th>Master Naiara</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            @if(Session::get('dept') == 'PPIC' || Session::get('dept') == 'Admin')
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
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Master</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Part No</label>
                    </div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <select name="part_no" id="part_no"
                            class="form-control select2 @error('part_no') is-invalid @enderror" style="width: 100%;"
                            required>
                            <option value="">Part No ...</option>
                            @foreach($part as $i)
                            <option value="{{$i->i_item_cd}}">{{$i->i_item_cd }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3"><label>Grouping</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <select name="grouping" id="grouping" class="form-control" required>
                            <option value="">Grouping ...</option>
                            <option value="PUTIH">PUTIH</option>
                            <option value="BIRU">BIRU</option>
                            <option value="KUNING">KUNING</option>
                            <option value="PINK">PINK</option>
                            <option value="PinkU">Pink-U</option>
                            <option value="HijauReguler">HIJAU Reguler</option>
                            <option value="HijauNaishu">HIJAU Naishu</option>
                            <option value="HijauUchicatto">HIJAU Uchicatto</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3"><label>Material</label></div>
                    <label>:</label>
                    <div class="col col-md-3">
                        <select name="material" id="material" class="form-control" required>
                            <option value="">Choose . . .</option>
                            <option value="NPR">NPR</option>
                            <option value="NPR-H">NPR-H</option>
                            <option value="A1KC">A1KC</option>
                            <option value="A1KD">A1KD</option>
                            <option value="OIL">OIL</option>
                        </select>
                    </div>
                </div>
                <p>

                </p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal"
                        id="btn-close">Close</button>
                    <button type="button" class="btn btn-primary btn-flat" id="btn-save">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Edit-->
<div class="modal fade" id="edit-master-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Master Grouping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id-master">

                <div class="row">
                    <div class="form-group col col-md-4"><label>Part No</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="e-part_no"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col col-md-4"><label>Grouping</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <select name="e-grouping" id="e-grouping" class="form-control" required>
                            <option value="PUTIH">PUTIH</option>
                            <option value="BIRU">BIRU</option>
                            <option value="KUNING">KUNING</option>
                            <option value="PINK">PINK</option>
                            <option value="PinkU">Pink-U</option>
                            <option value="HijauReguler">HIJAU Reguler</option>
                            <option value="HijauNaishu">HIJAU Naishu</option>
                            <option value="HijauUchicatto">HIJAU Uchicatto</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col col-md-4"><label>Material</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <select name="e-material" id="e-material" class="form-control" required>
                            <option value="NPR">NPR</option>
                            <option value="NPR-H">NPR-H</option>
                            <option value="A1KC">A1KC</option>
                            <option value="A1KD">A1KD</option>
                            <option value="OIL">OIL</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col col-md-4"><label>PAS</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <select name="e-pas" id="e-pas" class="form-control" required>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col col-md-4"><label>Futatsuwari</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <select name="e-futatsuwari" id="e-futatsuwari" class="form-control" required>
                            <option value="Reguler">Reguler</option>
                            <option value="Futatsuwari">Futatsuwari</option>
                            <option value="Belum Futatsuwari">Belum Futatsuwari</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col col-md-4"><label>Mark</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <select name="e-mark" id="e-mark" class="form-control" required>
                            <option value="NO Mark">NO Mark</option>
                            <option value="SS">SS</option>
                            <option value="RM">RM</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col col-md-4"><label>Master NAIARA</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <select name="e-masternaiara" id="e-masternaiara" class="form-control" required>
                            <option value="">Select ... </option>
                            <option value="KAV">KAV</option>
                            <option value="ODM">ODM</option>
                            <option value="OBB">OBB</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-flat" id="btn-update">Update</button>
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

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });


    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var master_ppic = $('#tb_master_ppic').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/ppic/list_master_ppic',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.status_master = $("#status_master").val();
                }
            },
            columnDefs: [
                /*{
                    targets: [7],
                    data: null,
                    render: function (data, type, row, meta) {
                        var pas = data.pas;
                        var material = data.material;
                        var futatsuwari = data.futatsuwari;
                        var mark = data.mark;

                        if (pas == "" || pas == null || material == "" || material == null || futatsuwari == "" || futatsuwari == null || mark == "" || mark == null) {
                            return "Open";
                        } else {
                            return "Close";

                        }
                    }

                },*/
                {
                    targets: [8],
                    data: null,
                    defaultContent: "<button class='btn btn-primary btn-sm btn-flat'><i class='fa fa-edit'></i></button>"

                }
            ],

            columns: [
                { data: 'part_no', name: 'part_no' },
                { data: 'grouping', name: 'grouping' },
                { data: 'pas', name: 'pas' },
                { data: 'material', name: 'material' },
                { data: 'futatsuwari', name: 'futatsuwari' },
                { data: 'mark', name: 'mark' },
                { data: 'masternaiara', name: 'masternaiara' },
                { data: 'status', name: 'status' },
            ],
        });

        $("#btn_reload_status").click(function () {
            master_ppic.ajax.reload();
        });


        $('#tb_master_ppic').on('click', '.btn-primary', function () {
            var data = master_ppic.row($(this).parents('tr')).data();
            $("#e-part_no").html(data.part_no);
            $("#e-grouping").val(data.grouping);
            $("#e-pas").val(data.pas);
            $("#e-material").val(data.material);
            $("#e-futatsuwari").val(data.futatsuwari);
            $("#e-mark").val(data.mark);
            $("#e-masternaiara").val(data.masternaiara);
            //$('#e-material option[value=' + data.material + ']').attr('selected', 'selected');
            //$('#e-futatsuwari option[value=' + data.futatsuwari + ']').attr('selected', 'selected');
            //$('#e-mark option[value=' + data.mark + ']').attr('selected', 'selected');
            $('#edit-master-modal').modal('show');
        });


        $("#btn-add").click(function () {
            $('#add-modal').modal('show');
        });

        $("#btn-save").click(function () {
            var part_no = $('#part_no').val();
            var grouping = $('#grouping').val();
            var material = $('#material').val();

            if (part_no == "" || grouping == "" || material == "") {
                alert('Please Input your Part No and Grouping .');
            } else {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/ppic/save_add_master",
                    headers: { "token_req": key },
                    data: { "part_no": part_no, "grouping": grouping, "material": material },
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