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

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">

                </div>

                <h3 class="profile-username text-center" id="no_masalah">{{$masalah->no_kartu}}</h3>
                <p class="text-muted text-center">Klasifikasi Masalah :</p>
                <strong>
                    <p class="text-muted text-center">{{$masalah->klasifikasi}}</p>
                </strong>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Status </b>
                        @if($masalah->status_masalah == 'Open')
                        <a class="float-right btn btn-warning btn-xs">{{$masalah->status_masalah}}</a>
                        @else
                        <a class="float-right btn btn-success btn-xs">{{$masalah->status_masalah}}</a>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <b>Progress </b>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100" style="width: {{$status['persen'] * 100}}%">
                                <span> <strong>{{number_format($status['persen'] * 100,2)}}% Complete</strong></span>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Detail</h3>
                @if($masalah->informer == Session::get('id'))
                <a href="#" class="float-right" id="edit_details"><i class="fa fa-edit"></i> Edit</a>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Masalah</strong>

                <p class="text-muted" id="t_masalah">{{$masalah->masalah}}</p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>

                <p class="text-muted" id="t_lokasi">{{$masalah->lokasi}}</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Pelapor</strong>

                <p class="text-muted" id="t_pelapor">{{$karyawan->NAMA}}</p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Penyebab</strong>

                <p class="text-muted" id="t_penyebab">{{$masalah->penyebab}}</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @if($masalah->status_masalah == 'Open' && $masalah->informer == Session::get('id'))

        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-danger" id="btn_delete"><i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
        @endif
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Tindakan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>

                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">

                    <div class="active tab-pane" id="activity">
                        <div class="row">
                            <div class="col-md-10"></div>
                            @if($masalah->informer == Session::get('id'))
                            <div class="col-md-2">
                                <button class="btn btn-success float-right" id="btn_tindakan"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            @endif
                        </div>

                        <!-- Post -->
                        @foreach ($tindakan as $item)

                        <div class="post">
                            <div class="user-block">
                                @if($item->status_tindakan == 'Close')
                                <img class="img-circle" src="{{asset('/assets/img/check_icon.png')}}" alt="user image">
                                @else
                                <img class="img-circle" src="{{asset('/assets/img/info.png')}}" alt="user image">
                                @endif
                                <span class="username">
                                    <a href="#" id="pic_{{$item->id_tindakan}}">{{$item->pic_tindakan}}</a>

                                </span>
                                <span class="description">Dibuat {{$item->created_at}}</span>
                            </div>
                            <!-- /.user-block -->
                            <p>

                                {{$item->isi_tindakan}}
                            </p>
                            @if($item->file_lampiran != null)
                            <a href="#" class="link-black text-sm link-lampiran" name="{{$item->file_lampiran}}"><i
                                    class="fas fa-paperclip mr-1"></i>
                                Lampiran
                            </a>
                            @endif

                            <p>
                                @if($item->status_tindakan == 'Close')
                                <div class="text-sm btn btn-success btn-xs">
                                    <i class="fas fa-star mr-1"></i> Close
                                </div>
                                <a href="#" class="link-black text-sm"><i class="far fa-calendar-check mr-1"></i>
                                    Selesai
                                    : {{$item->tgl_selesai}}</a>
                                @else
                                <div class="text-sm btn btn-warning btn-xs">
                                    <i class="far fa-star mr-1"></i> Open
                                </div>
                                <a href="#" class="link-black text-sm"><i class="far fa-calendar-check mr-1"></i> Target
                                    : {{$item->tgl_deadline}}</a>
                                @endif



                                @if($masalah->informer == Session::get('id'))
                                <span class="float-right">
                                    <a href="#" class="link-black text-sm btn-edit" id="{{$item->id_tindakan}}">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                </span>
                                @endif
                            </p>


                        </div>
                        <!-- /.post -->
                        @endforeach


                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- The timeline -->
                        <div class="timeline timeline-inverse">
                            <!-- timeline time label -->

                        </div>
                    </div>
                    <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<div class="modal fade" id="modal_tindakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tindakan">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Isi Tindakan</label></div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_masalah" name="id_masalah" value="{{$masalah->id_masalah}}">
                            <textarea class="form-control" name="isi_tindakan" id="isi_tindakan" cols="50" rows="5"
                                placeholder="Tindakan" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Rencana Selesai</label></div>
                        <div class="col col-md-6">
                            <input type="date" id="tgl_deadline" name="tgl_deadline" class="form-control" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Penanggung Jawab</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="pic" name="pic" class="form-control"
                                placeholder="Nama Penanggung Jawab">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <input type="submit" class="btn btn-primary" id="btn_simpan" name="btn_simpan" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLongTitle">Edit Tindakan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit" enctype="multipart/form-data" name="form_edit" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Isi Tindakan</label></div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_tindakan" name="id_tindakan">
                            <textarea class="form-control" name="edit_tindakan" id="edit_tindakan" cols="50" rows="5"
                                placeholder="Tindakan" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Rencana Selesai</label></div>
                        <div class="col col-md-6">
                            <input type="date" id="edit_deadline" name="edit_deadline" class="form-control" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Penanggung Jawab</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="edit_pic" name="edit_pic" class="form-control"
                                placeholder="Nama Penanggung Jawab">

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Status Tindakan</label></div>
                        <div class="col col-md-6 id2">
                            <select class="form-control" name="status_tind" id="status_tind">
                                <option value="Open">Open</option>
                                <option value="Close">Close</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-4"><label>Tanggal Selesai</label></div>
                        <div class="col col-md-6">
                            <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col col-md-4"><label>File Lampiran</label></div>
                        <div class="col col-md-6">
                            <input type="file" class="form-control" id="lampiran" name="lampiran">
                        </div>
                    </div>

                    <div class="modal-footer">
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <button type="button" id="btn_hapus" class="btn btn-danger"><i class="fa fa-trash"></i>
                                Delete</button>
                        </div>
                        <div class="col-md-4">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            <input type="submit" class="btn btn-primary" id="edit_simpan" name="edit_simpan"
                                value="Update">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_masalah_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Masalah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_edit_masalah">
                    @csrf
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Masalah</label></div>
                        <div class="col col-md-6">
                            <input type="hidden" id="id_masalah" name="id_masalah" value="{{$masalah->id_masalah}}">
                            <input type="text" class="form-control" name="edit_masalah" id="edit_masalah" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Lokasi</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="edit_lokasi" name="edit_lokasi" class="form-control" required>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col col-md-4"><label>Penyebab</label></div>
                        <div class="col col-md-6">
                            <input type="text" id="edit_penyebab" name="edit_penyebab" class="form-control">

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <input type="submit" class="btn btn-primary" id="edit_simpan" name="edit_simpan" value="Simpan">
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

<script>
    $(document).ready(function(){
        var key = localStorage.getItem('npr_token');
        $("#btn_tindakan").click(function(){
            $("#modal_tindakan").modal("show");
        });

        $("#form_tindakan").submit(function(e){
            e.preventDefault();
            var datas = $(this).serialize();
            var btn = $("#btn_simpan");
        
            btn.attr('disabled', true);
                $.ajax({
                    type: "POST",
                    url: APP_URL+"/masalah/tindakan",
                    
                    data:datas ,
                    dataType: "json",
                })
                .done(function(resp) {
                if (resp.success) {
                //alert("Data Sudah Complete.");
               location.reload();
                }
                else
               location.reload();
            })
            .fail(function() {
                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
        
            });
            });

            $(".btn-edit").click(function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url: APP_URL+"/api/tindakan/"+id,
                    headers: {
                            "token_req": key
                            },
                    
                    dataType: "json",
                })
                .done(function(resp) {
                if (resp.success) {
                    $("#id_tindakan").val(resp.data.id_tindakan);
                    $("#edit_tindakan").html(resp.data.isi_tindakan);
                    $("#edit_deadline").val(resp.data.tgl_deadline);
                    $("#edit_pic").val(resp.data.pic_tindakan);
                    $("#tgl_selesai").val(resp.data.tgl_selesai);
                    $("div.id2 select").val(resp.data.status_tindakan);
                    $("#modal_edit").modal("show");
                }
            
              
            })
            .fail(function() {
                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
        
            });
               
                
            });

            $("#btn_hapus").click(function(){
              var id_tindakan = $("#id_tindakan").val();
                var r = confirm("Apakah akan menghapus data ini?")
                if(r){

                    $.ajax({
                            type: "POST",
                            url: APP_URL+"/api/tindakan/delete",
                            headers: {
                                    "token_req": key
                                    },
                            data : {id : id_tindakan},
                            dataType: "json",
                        })
                        .done(function(resp) {
                        if (resp.success) {
                            location.reload();
                        }else{
                            alert(resp.message);
                        }
                    
                    
                    })
                    .fail(function() {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                
                    });
                }
            });

            $("#form_edit").submit(function(e){
                e.preventDefault();
               //var datas = $(this).serialize();
               //var form = document.getElementById('form_edit');
               var datas = new FormData(this);
               //var file = document.getElementById('lampiran').files[0];

              

                var c = confirm("Apakah anda akan merubah data ?");

                if(c){
                    var btn = $("#edit_simpan");
        
                    btn.attr('disabled', true);
                        $.ajax({
                            type: "POST",
                            url: APP_URL+"/tindakan/update",
                            
                            data:datas ,
                            processData: false,
                            contentType:false,
                        })
                        .done(function(resp) {
                        if (resp.success) {
                       
                            location.reload();
                        }else{
                            location.reload();
                        }
                       
                    })
                    .fail(function() {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                
                    });
                }
            
            });

            $("#btn_delete").click(function(){
                var data = $("#id_masalah").val();
                var nomer = $("#no_masalah").html();
                var conf = confirm("Apakah masalah No. "+nomer+" akan dihapus?");
                if (conf) {
                    $.ajax({
                            type: "POST",
                            url: APP_URL+"/api/hapus/masalah",
                            headers: { "token_req": key },
                            data:{"id": data} ,
                            dataType: "json",
                        })
                        .done(function(resp) {
                        if (resp.success) {
                        alert("Hapus request berhasil");
                        window.location.href = "{{ route('req_masalah')}}";
                        }
                        else
                        {
                            alert(resp.message)
                            location.reload();
                        }
                    })
                    .fail(function() {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                
                    });
                }
            });

            $("#edit_details").click(function(e){
                e.preventDefault();
                $("#edit_masalah").val($("#t_masalah").text());
                $("#edit_lokasi").val($("#t_lokasi").text());
                $("#edit_penyebab").val($("#t_penyebab").text());
                $("#edit_masalah_modal").modal("show");
                
               
            });

            $("#form_edit_masalah").submit(function(e){
                e.preventDefault();
                var datas = $(this).serialize();
                var p = confirm("Apakah anda akan merubah data ini ?");

                if(p){
                    $.ajax({
                            type: "POST",
                            url: APP_URL+"/api/update_masalah",
                            headers: { "token_req": key },
                            data:datas ,
                            dataType: "json",
                        })
                        .done(function(resp) {
                        if (resp.success) {
                        alert(resp.message);
                        location.reload();
                        }
                        else
                        {
                            alert(resp.message)
                            location.reload();
                        }
                    })
                    .fail(function() {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                
                    });
                }
            });

            $(".link-lampiran").click(function(e){
                e.preventDefault();
                var id = $(this).attr('name');
                var fpath = APP_URL+"/storage/file/tindakan/"+id;
                window.open(fpath, '_blank');
            });

    });
</script>

@endsection