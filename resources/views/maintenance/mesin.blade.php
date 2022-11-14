@extends('layout.main')
@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('success')}}
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

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mesin Berhenti</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered" id="tb_mesinoff">
                    <thead>
                        <tr>
                            <th>Nomer Induk Mesin</th>
                            <th>Nama Mesin</th>
                            <th>No Mesin</th>
                            <th>Tanggal Rusak</th>
                            <th>Masalah</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mesinoff as $mesin)
                        <tr>
                            <td>{{$mesin->no_induk_mesin}}</td>
                            <td>{{$mesin->nama_mesin}}</td>
                            <td>{{$mesin->no_urut_mesin}}</td>
                            <td>{{$mesin->tanggal_rusak}}</td>
                            <td>{{$mesin->masalah}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mesin Overhole</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>No Mesin</th>
                            <th>Nama Mesin</th>
                            <th>Tgl Start</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Mesin</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-success" id="tambah_mesin">Tambah Mesin</button>

                <table class="table table-bordered" id="tb_mesin">
                    <thead>
                        <tr>
                            <th>Id mesin</th>
                            <th>Nama Mesin / Alat</th>
                            <th>No. Induk</th>
                            <th>No. Urut</th>
                            <th>Merk</th>
                            <th>Type</th>
                            <th>Tahun Produksi</th>
                            <th>Lokasi</th>
                            <th>Factory</th>
                            <th>Kondisi</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th>History</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Daftar Program Mesin</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-success" id="tambah_program">Tambah Program</button>

                <table class="table table-bordered" id="tb_program">
                    <thead>
                        <tr>
                            <th>Id mesin</th>
                            <th>Nama Mesin / Alat</th>
                            <th>No. Induk</th>
                            <th>No. Urut</th>
                            <th>Type PLC</th>
                            <th>Tgl Update</th>
                            <th>User</th>
                            <th>Keterangan</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">

            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="tambah_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="frm_mesin">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Tambah Mesin Baru</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nomerinduk">Nomer Induk Mesin</label>
                            <input type="text" class="form-control" name="nomerinduk" id="nomerinduk"
                                placeholder="Nomer Induk Mesin" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="nama_mesin">Nama Mesin</label>
                            <input type="text" class="form-control" name="nama_mesin" id="nama_mesin"
                                placeholder="Nama Mesin" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="no_urut">No. Urut</label>
                            <input type="number" class="form-control" name="no_urut" id="no_urut" placeholder="No. Urut"
                                required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="merk_mesin">Merek Mesin</label>
                            <input type="text" class="form-control" name="merk_mesin" id="merk_mesin"
                                placeholder="Merek Mesin">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tahun_mesin">Tahun Pembuatan</label>
                            <input type="text" class="form-control" name="tahun_mesin" id="tahun_mesin"
                                placeholder="Tahun Pembuatan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="type_mesin">Type Mesin</label>
                            <input type="text" class="form-control" name="type_mesin" id="type_mesin"
                                placeholder="Tahun Pembuatan">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="kategori">Kategori Mesin</label>
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="normal">Normal</option>
                                <option value="krusial">Krusial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi"
                                placeholder="Lokasi Mesin">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="factory">Factory</label>
                            <select name="factory" id="factory" class="form-control">
                                <option value="">Pilih Factory</option>
                                <option value="1">I</option>
                                <option value="2">II</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="kondisi">Kondisi Mesin</label>
                            <select name="kondisi" id="kondisi" class="form-control">
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan"
                                placeholder="Keterangan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">


                    <input type="submit" class="btn btn-success" value="Save">

                    <button type="button" class="btn btn-secondary" id="btn-close">Close</button>


                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="frm_editmesin">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Data Mesin</h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nomerinduk">Nomer Induk Mesin</label>
                            <input type="hidden" id="e_id" name="id_mesin">
                            <input type="text" id="e_nomerinduk" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="nama_mesin">Nama Mesin</label>
                            <input type="text" class="form-control" name="nama_mesin" id="e_nama_mesin" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="no_urut">No. Urut</label>
                            <input type="number" class="form-control" name="no_urut" id="e_no_urut" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="merk_mesin">Merek Mesin</label>
                            <input type="text" class="form-control" name="merk_mesin" id="e_merk_mesin">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tahun_mesin">Tahun Pembuatan</label>
                            <input type="text" class="form-control" name="tahun_mesin" id="e_tahun_mesin">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="type_mesin">Type Mesin</label>
                            <input type="text" class="form-control" name="type_mesin" id="e_type_mesin">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="kategori">Kategori Mesin</label>
                            <select name="kategori" id="e_kategori" class="form-control">
                                <option value="normal">Normal</option>
                                <option value="krusial">Krusial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="e_lokasi">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="factory">Factory</label>
                            <select name="factory" id="e_factory" class="form-control">
                                <option value="">Pilih Factory</option>
                                <option value="1">I</option>
                                <option value="2">II</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="kondisi">Kondisi Mesin</label>
                            <select name="kondisi" id="e_kondisi" class="form-control">
                                <option value="OK">OK</option>
                                <option value="NG">NG</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="e_keterangan">
                        </div>
                    </div>
                    <div class="row">
                        <div id="accordion">

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                            class="collapsed" aria-expanded="false">
                                            Delete
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse in collapse" style="">
                                    <div class="card-body">
                                        <button type="button" class="btn btn-danger" id="btn_delete"><i
                                                class="fa fa-trash"></i> Hapus Mesin</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer justify-content-between">


                    <input type="submit" class="btn btn-success" value="Save">

                    <button type="button" class="btn btn-secondary" id="e_btn-close">Close</button>


                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="program_modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Program</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/maintenance/addprogram')}}" method="post" id="frm_program"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nomerinduk">Nomer Induk Mesin</label>
                            <select name="no-mesin" class="form-control select2">
                                <option value="">--Pilih No Mesin--</option>
                                @foreach($mesinlist as $o)
                                <option value="{{$o->no_induk}}">{{$o->no_induk}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="nama_mesin">Type PLC</label>
                            <input type="text" class="form-control" name="type-plc" id="type-plc" placeholder="Type PLC"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="nama_mesin">Keterangan</label>
                            <textarea name="ket_prog" class="form-control" cols="30" rows="2" placeholder="Keterangan"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">File Lampiran</label>
                        <input name="file_prog" type="file" class="form-control" required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                <input type="submit" class="btn btn-primary" value="Save Change">
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade bd-example-modal-lg" id="detail_prog" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-header">
                <h3>List Program</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Nomer Induk Mesin : </label>
                        <label for="nomerinduk" id="p_no_induk"></label>

                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered" id="list_file">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Tgl Update</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer justify-content-between">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href=""></a>

            </div>
        </div>

    </div>
</div>


@endsection

@section('script')
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/js/select2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.select2').select2({
        theme: 'bootstrap4'
        })
        var key = localStorage.getItem('npr_token');
        var list_mesin = $('#tb_mesin').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            ordering: false,

            ajax: {
            url: APP_URL + '/api/listmesin',
            type: "POST",
            headers: {
            "token_req": key
            },
        },
            columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false
            },
            {
                targets: [12],
                data: null,
                render: function(data, type, row, meta){
                    if (data.no_induk == null) {
                        return "-";
                    }
                    return "<a href=\"{{url('/maintenance/history/')}}/"+data.no_induk+"\" class='btn btn-primary'><i class='fa fa-clock'></i></a>";
                },
            },
            {
                targets: [13],
                data: null,
                render: function(data, type, row, meta){
                    return "<button class='btn btn-success'><i class='fa fa-edit'></i></button>";
                },
            }],
            columns: [{
                    data: 'id_mesin',
                    name: 'id_mesin'
                },
                {
                    data: 'nama_mesin',
                    name: 'nama_mesin'
                },
                {
                    data:'no_induk',
                    name:'no_induk'
                },{
                    data:'no_urut',
                    name:'no_urut'
                },{
                    data:'merk_mesin',
                    name:'merk_mesin'
                },{
                    data:'type_mesin',
                    name:'type_mesin'
                },{
                    data:'tahun_pembuatan',
                    name:'tahun_pembuatan'
                },{
                    data:'lokasi',
                    name:'lokasi'
                },{
                    data:'factory',
                    name:'factory'
                },
                {
                    data:'kondisi',
                    name:'kondisi'
                },{
                    data:'kategori_mesin',
                    name:'kategori_mesin'
                },{
                    data:'keterangan',
                    name:'keterangan'
                }
                
                ],
           
        });

var list_prog = $('#tb_program').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            ordering: false,

            ajax: {
            url: APP_URL + '/api/listprog',
            type: "POST",
            headers: {
            "token_req": key
            },
        },
            columnDefs: [{
            targets: [0],
            visible: false,
            searchable: false
            },
            {
                targets: [8],
                data: null,
                render: function(data, type, row, meta){
                    return "<button class='btn btn-info'><i class='fa fa-file'></i></button>";
                },
            }
           ],
            columns: [{
                    data: 'record_id',
                    name: 'record_id'
                },
                {
                    data: 'nama_mesin',
                    name: 'nama_mesin'
                },
                {
                    data: 'no_induk_mesin',
                    name: 'no_induk_mesin'
                },
                {
                    data:'no_urut',
                    name:'no_urut'
                },
                {
                    data:'type_plc',
                    name:'type_plc'
                },
                {
                    data:'tgl_update',
                    name:'tgl_update'
                },
                {
                    data:'user_name',
                    name:'user_name'
                },
                {
                    data:'keterangan',
                    name:'keterangan'
                }
                
                ],
           
});
       
        $("#tambah_mesin").click(function(){
            $('#tambah_modal').modal('show');
        });
        $("#btn-close").click(function(){
            $('#tambah_modal').modal('hide');
        });
        $("#tb_mesin").on('click', '.btn-success', function () {
            var data = list_mesin.row($(this).parents('tr')).data();
            $("#e_id").val(data.id_mesin);
            $("#e_nomerinduk").val(data.no_induk);
            $("#e_nama_mesin").val(data.nama_mesin);
            $("#e_no_urut").val(data.no_urut);
            $("#e_merk_mesin").val(data.merk_mesin);
            $("#e_tahun_mesin").val(data.tahun_pembuatan);
            $("#e_type_mesin").val(data.type_mesin);
            $("#e_kategori").val(data.kategori_mesin);
            $("#e_lokasi").val(data.lokasi);
            $("#e_factory").val(data.factory);
            $("#e_kondisi").val(data.kondisi);
            $("#e_keterangan").val(data.keterangan);
            $("#edit_modal").modal('show');
        });

        $("#tb_mesin").on('click', '.btn-primary', function(){

        });
        $("#e_btn-close").click(function(){
            $("#edit_modal").modal('hide');
        });
        $("#btn_delete").click(function(){
            var r = confirm("Apakah anda akan menghapus mesin "+$("#e_nomerinduk").val()+" ?");
            var id = $("#e_id").val();
            if (r) {
                $.ajax({
                url: APP_URL+'/maintenance/delmesin',
                type: 'POST',
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {"id":id},
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = "{{ route('mesin')}}";
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
            }
        });
        $("#frm_mesin").submit(function(e){
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL+'/maintenance/postmesin',
                type: 'POST',
                dataType: 'json',
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = "{{ route('mesin')}}";
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
        });
        $("#frm_editmesin").submit(function(e){
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                url: APP_URL+'/maintenance/editmesin',
                type: 'POST',
                dataType: 'json',
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = "{{ route('mesin')}}";
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
        });

        $("#tambah_program").click(function(){
            $('#program_modal').modal('show');
        });

        $("#tb_program").on('click','.btn-info', function(){
            var data = list_prog.row($(this).parents('tr')).data();
            $.ajax({
                url: APP_URL+'/api/getlist_prog',
                type: 'POST',
                dataType: 'json',
                headers: {
                        "token_req": key
                        },
                data: {'no_induk':data.no_induk_mesin},
                })
                .done(function(resp) {
                    if (resp.success) {
                        var datas = resp.data;
                       $("#list_file tbody").empty();
                       for (var i in datas) {
                          var newrow = '<tr><td><a href="#">'+datas[i].link_file+'</a></td><td>'+datas[i].tgl_update+'</td><td>'+datas[i].keterangan+'</td></tr>'
                          $('#list_file tbody').append(newrow);
                       }

                       
                        $("#p_no_induk").html(data.no_induk_mesin);
                        $("#detail_prog").modal('show');
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
        });

        $("#list_file").on('click','a', function(e){
            e.preventDefault();
            var file = $(this).text();
            var nomer_mesin = $("#p_no_induk").text();

            $.ajax({
                url: APP_URL+'/api/download-prog/'+nomer_mesin+'/'+file,
                type: 'GET',
                dataType: 'json',
                headers: {
                        "token_req": key
                        },
               
                })
                .done(function(resp) {
                    if (resp.success) {
                     
                      window.open(resp.url, '_blank')
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                  
                   
                })
                .always(function() {
                  
                });
                
        });
        /*
        $("#frm_program").submit(function(e){
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                url: APP_URL+'/maintenance/addprogram',
                type: 'POST',
                dataType: 'json',
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = "{{ route('mesin')}}";
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
        });
        */
    });
</script>
@endsection