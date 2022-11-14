@extends('layout.main')
@section('content')

@if(Session::has('alert-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('alert-success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(Session::has('alert-danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{Session::get('alert-danger')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card col-md-12">
    <div class="card-header">
        <form action="{{url('/produksi/tambahnomerinduk')}}" method="post">
            {{csrf_field()}}


            <div class="card card-info">
                <div class="card-header">
                    <div class="col-12">
                        <h3 class="card-title">New Registration Number</h3>
                    </div>
                </div>
                <div class="card-tools">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="tgl_datang">Arrival Date</label>
                    <input type="date" class="form-control" name="tgl_datang" id="tgl_datang"
                        placeholder="Tanggal ditemukan" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="iclno">No Icl</label>
                    <select name="icl_no" id="icl_no" class="form-control select2 @error('icl_no') is-invalid @enderror"
                        style="width: 100%;" required>
                        <option value="">Choose...</option>
                        @foreach($icl as $i)
                        <option value="{{$i->item_code}}">{{$i->icl_no }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="item_cd">Item Code</label>
                    <input type="hidden" name="icl_no_1" id="icl_no_1">
                    <input type="text" class="form-control @error('item_cd')is-invalid @enderror" name="item_cd"
                        id="item_cd" placeholder="item cd" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="no_gambar">Drawing No</label>
                    <input type="text" class="form-control" name="no_gambar" id="no_gambar"
                        placeholder="Drawing Number">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="nama_mesin">Machine</label>
                    <select name="nama_mesin" id="nama_mesin"
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
                    <select name="nama_jigu" id="nama_jigu"
                        class="form-control select2 @error('nama_jigu') is-invalid @enderror" style="width: 100%;"
                        required>
                        <option value="">Choose...</option>
                        @foreach($mesin as $m)
                        <option value="{{$m->nama_jigu}}">{{$m->nama_jigu }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="kigou">Kigou</label>
                    <input type="text" class="form-control" name="kigou" id="kigou" placeholder="kigou">
                </div>
                <div class="form-group col-md-2">
                    <label for="ukuran">Size</label>
                    <input type="text" class="form-control" name="ukuran" id="ukuran" placeholder="Size Jigu">
                </div>
                <div class="form-group col-md-1">
                    <label for="qty">Qty</label>
                    <input type="number" class="form-control" name="qty" id="qty" value="1" placeholder="qty">
                </div>
            </div>
            <div class="row">
            </div>
            <div class="row">
                <div class="form-group col-md-8">
                    <label for="no_induk_jigu">No Registration</label>
                    <input type="text" style="font-size:x-large; color: red; font-weight: bold; text-align: center;"
                        value="" class="form-control" name="no_induk_jigu_1" id="no_induk_jigu_1" disabled>
                    <input type="hidden" value="" class="form-control" name="no_induk_jigu" id="no_induk_jigu">
                </div>
                <div class="form-group col-md-4">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" name="location" id="location" placeholder="location">
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>

</form>

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
            <div class="row">
                <label for="" class="col-md-1 ">Status : </label>
                <select name="status_order" id="status_order" class="form-control col-md-2" value="Ordered">
                    <option value="Ordered">Oredered</option>
                    <option value="All">All</option>
                    <option value="Stock">Stock</option>
                    <option value="CheckOut">CheckOut</option>
                    <option value="Out">Out</option>
                </select>
                <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
            </div>
            <br>
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
            <label>WareHouse Dept</label>
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
                    <div class="col col-md-4"><label>ICL No</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="edit-iclno"></label>
                    </div>

                    <div class="col col-md-4"><label>Item Cd</label></div>
                    <label>:</label>
                    <div class="col col-md-5">
                        <label id="edit-itemcd"></label>
                    </div>
                </div>
                <div class="row">
                    <table border="1" align="center" width="460" style="margin-top: 10px;">
                        <thead style="text-align: center;">
                            <tr>
                                <th>Machine</th>
                                <th>Jigu</th>
                                <th>Kigou</th>
                                <th>Size</th>
                                <th>Qty</th>
                                <th>Location</th>
                            </tr>

                        </thead>
                        <tbody style="text-align: center;">
                            <tr>
                                <td id="edit-machine" name="edit-machine"></td>
                                <td id="edit-jigu" name="edit-jigu"></td>
                                <td id="edit-kigou" name="edit-kigou"></td>
                                <td id="edit-size" name="edit-size"></td>
                                <td id="edit-qty" name="edit-qty"></td>
                                <td id="edit-location" name="edit-location"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col col-md-4" id="checkout" name="checkout">CheckOut</div>
                </div>
                <hr>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-checkout">CheckOut</button>
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
<script>
    $(function () {

        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var dept = "{{Session::get('dept')}}";

        $("#icl_no").change(function () {
            var noinduk = $(this).children("option:selected").html();
            var namaoperator = $(this).children("option:selected").val();
            //    var dept = $(this).children("option:selected").val();
            $("#icl_no_1").val(noinduk);
            $("#item_cd").val(namaoperator);
        });

        var key = localStorage.getItem('npr_token');

        $("#tgl_datang").change(function () {
            //alert('test');
            var tgl = new Date(this.value);
            var tahun = tgl.getFullYear();
            var bulan = ("0" + (tgl.getMonth() + 1)).slice(-2);
            var tanggal = ("0" + tgl.getDate()).slice(-2);
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/nomer_induk_jigu",
                headers: { "token_req": key },
                data: { "tgl": tahun + '-' + bulan + '-' + tanggal },
                dataType: "json",


                success: function (response) {
                    var nomer = response[0].no_laporan;
                    $("#no_induk_jigu").val(nomer);
                    $("#no_induk_jigu_1").val(nomer);

                }
            });
        });


        var listnoinduk = $('#tb_noinduk').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: APP_URL + '/api/jigu/inquerynoinduk_warehouse',
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
                        return "";
                    } else if (data.status == 'Ordered') {
                        return "<button class='btn btn-success btn-xs'>CheckOut</button>";
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
                //{ data: 'no_icl', name: 'no_icl' },
                //{ data: 'item_cd', name: 'item_cd' },
                //{ data: 'lokasi', name: 'lokasi' },
            ]
        });

        $("#btn_reload_status").click(function () {
            listnoinduk.ajax.reload();
        });

        $('#tb_noinduk').on('click', '.btn-success', function () {
            var data = listnoinduk.row($(this).parents('tr')).data();
            $("#edit-noinduk").val(data.id_noinduk_jigu);
            $("#edit-noindukjigu").html(data.no_induk_jigu);
            $("#edit-machine").html(data.nama_mesin);
            $("#edit-jigu").html(data.nama_jigu);
            $("#edit-kigou").html(data.kigou);
            $("#edit-size").html(data.ukuran);
            $("#edit-qty").html(data.qty);
            $("#edit-location").html(data.lokasi);
            $("#edit-iclno").html(data.no_icl);
            $("#edit-itemcd").html(data.item_cd);
            $('#modal-proses').modal('show');
        });

        $("#btn-checkout").click(function () {
            var idjigu = $("#edit-noinduk").val();
            var status = $("#checkout").html();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/jigu/checkout",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idjigu, "status": status,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("CheckOut Success.");
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        location.reload();
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Unable connect to server !!!</div></div>");

                });
        });

    });

</script>
@endsection