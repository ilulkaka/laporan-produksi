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
  <div class="card card-warning">
    <div class="card-header">
      <h3 class="card-title">Request Perbaikan</h3>
    </div>
    <div class="card-body table-responsive p-0">
      <table class="table-hover text-nowrap table-striped" id="list-request">
        <thead>
          <th>Id</th>
          <th>Tanggal</th>
          <th>Maintenance</th>
          <th>Dept</th>
          <th>Shift</th>
          <th>No. Request</th>
          <th>Nama Mesin</th>
          <th>No. Induk Mesin</th>
          <th>Masalah</th>
          <th>Kondisi</th>
          <th>Klasifikasi</th>
          <th>action</th>
        </thead>
      </table>
    </div>

  </div>
</div>
<div class="row">
  <div class="card card-success">
    <div class="card-header">
      <h3 class="card-title">Request Selesai</h3>
      <br>
      <div class="row align-center">
        <input type="date" class="form-control col-sm-3" id="tgl1" value="{{date('Y-m').'-01'}}">
        <label for="" class="col-md-2 text-center">Sampai</label>
        <input type="date" class="form-control col-sm-3" id="tgl2" value="{{date('Y-m-d')}}">
        <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>
      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
      <table class="table-hover text-nowrap table-striped" id="tb_selesai">
        <thead>
          <th>Id</th>
          <th>Tanggal</th>
          <th>Operator MTC</th>
          <th>Dept</th>
          <th>Shift</th>
          <th>No. Request</th>
          <th>Nama Mesin</th>
          <th>No. Induk Mesin</th>
          <th>Masalah</th>
          <th>Tindakan</th>
          <th>Status</th>
          <th>Klasifikasi</th>
        </thead>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="pending-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pending Perbaikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-pending">
          @csrf
          <input type="hidden" id="id-req" name="id-req">
          <div class="row">
            <div class="col col-md-3"><label>No. :</label></div>
            <div class="col col-md-4">
              <label id="no-perbaikan"></label>
            </div>
          </div>

          <div class="row">
            <div class="col col-md-3"><label>Departemen :</label></div>
            <div class="col col-md-8">
              <label id="dept"></label>
            </div>
          </div>
          <div class="row">
            <div class="col col-md-3"><label>Shift :</label></div>
            <div class="col col-md-4">
              <label id="shift"></label>
            </div>
          </div>
          <div class="row">
            <div class="col col-md-3"><label>No. Mesin :</label></div>
            <div class="col col-md-4">
              <label id="no-mesin"></label>

            </div>
          </div>
          <div class="row">
            <div class="col col-md-3"><label>Nama Mesin :</label></div>

            <div class="col col-md-8">
              <label id="nama_mesin"></label>
            </div>
          </div>

          <div class="row">
            <div class="col col-md-3"><label>Masalah :</label></div>
            <div class="col col-md-8">
              <label id="masalah"></label>
            </div>
          </div>
          <div class="form-row">
            <div class="col col-md-3"><label>Kondisi :</label></div>
            <div class="col col-md-8">
              <label id="kondisi"></label>
            </div>
          </div>

          <div class="form-row">
            <div class="col col-md-2"><label>Jadwal :</label></div>
            <div class="form-group col-md-5">
              <label for="">Dari :</label>
              <input type="date" class="form-control" name="jadwal1" id="jadwal1" required>
            </div>

            <div class="form-group col-md-5">
              <label for="">Sampai :</label>
              <input type="date" class="form-control" name="jadwal2" id="jadwal2" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3"><label>Keterangan :</label></div>
            <div class="form-group col-md-8">
              <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan">
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var tb_list_req =  $('#list-request').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            responsive: true,
                            ordering: false,
                            ajax: {
                                            url: APP_URL+'/api/list_req',
                                            type: "POST",
                                            headers: { "token_req": key },
                                            
                                        },
                            columnDefs:[
                                {
                                    targets: [ 0 ],
                                    visible: false,
                                    searchable: false
                                },
                                {
                                targets: [11],
                                data: null,
                                defaultContent: "<button class='btn btn-success'><i class='fa fa-check'></i></button><button class='btn btn-warning'><i class='fa fa-exclamation-triangle'></i></button>"
                                  /*
                                    render: function(data, type, row, meta){
                                      if (data.no_induk_mesin == "NM") {
                                        return "0";
                                      }else{

                                        return "<button class='btn btn-success'><i class='fa fa-check'></i></button>";
                                      }
                                    }
                                    */
                                }
                            ],
                        
                            columns: [
                                { data: 'id_perbaikan', name: 'id_perbaikan' },
                                { data: 'tanggal_rusak', name: 'tanggal_rusak' },
                                { data: 'operator', name: 'operator' },
                                { data: 'departemen', name: 'departemen' },
                                { data: 'shift', name: 'shift' },
                                { data: 'no_perbaikan', name: 'no_perbaikan' },
                                { data: 'nama_mesin', name: 'nama_mesin' },
                                { data: 'no_induk_mesin', name: 'no_induk_mesin' },
                                { data: 'masalah', name: 'masalah' },
                                { data: 'kondisi', name: 'kondisi' },
                                { data: 'klasifikasi', name: 'klasifikasi' },
                            
                            ]
                        });

        
    $("#list-request").on('click','.btn-success',function(){
        var data = tb_list_req.row( $(this).parents('tr') ).data();
       
        window.location.href = "{{ url('/maintenance/completion')}}/"+data.id_perbaikan;
    });
    $("#list-request").on('click','.btn-warning',function(){
        var data = tb_list_req.row( $(this).parents('tr') ).data();
       $("#no-perbaikan").html(data.no_perbaikan);
       $("#dept").html(data.departemen);
       $("#id-req").val(data.id_perbaikan);
       $("#shift").html(data.shift);
       $("#no-mesin").html(data.no_induk_mesin);
       $("#nama_mesin").html(data.nama_mesin);
       $("#masalah").html(data.masalah);
       $("#kondisi").html(data.kondisi);
       $("#pending-modal").modal("show");
    });

   
    $("#form-pending").submit(function(e){
      e.preventDefault();
      var c = confirm("Apakah anda akan menyimpan data ini ?");
      if (c) {
        var data =  $(this).serialize();
        $.ajax({
                url: APP_URL+'/maintenance/pending',
                type: 'POST',
                dataType: 'json',
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = APP_URL+'/maintenance/schedule';
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

    var tb_selesai = $("#tb_selesai").DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                  url: APP_URL+'/api/req_selesai',
                  type: "POST",
                  headers: { "token_req": key },
                  data: function (d) {
                        d.tgl_awal = $("#tgl1").val();
                        d.tgl_akhir = $("#tgl2").val();
                      }
              },
        columnDefs:[
          {
              targets: [ 0 ],
              visible: false,
              searchable: false
          },
        ],
    
        columns: [
            { data: 'id_perbaikan', name: 'id_perbaikan' },
            { data: 'tanggal_rusak', name: 'tanggal_rusak' },
            { data: 'operator', name: 'operator' },
            { data: 'departemen', name: 'departemen' },
            { data: 'shift', name: 'shift' },
            { data: 'no_perbaikan', name: 'no_perbaikan' },
            { data: 'nama_mesin', name: 'nama_mesin' },
            { data: 'no_induk_mesin', name: 'no_induk_mesin' },
            { data: 'masalah', name: 'masalah' },
            { data: 'tindakan', name: 'tindakan' },
            { data: 'status', name: 'status' },
            { data: 'klasifikasi', name: 'klasifikasi' },
        
        ]
    });

    $("#btn_refresh").click(function(){
      tb_selesai.ajax.reload();
    });
});
</script>
@endsection