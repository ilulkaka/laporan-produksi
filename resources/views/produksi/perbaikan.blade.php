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

<link rel="stylesheet" href="{{asset('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<div class="card card-primary card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
          role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Perbaikan Mesin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
          role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Perbaikan Non Mesin</a>
      </li>

    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
        aria-labelledby="custom-tabs-one-home-tab">
        <form id="form_mesin" role="form">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="shift">Shift</label>
                  <select name="shift" id="shift" class="form-control" required>
                    <option value="">Pilih Shift...</option>
                    <option value="NonShift">Non Shift</option>
                    <option value="shift1">Shift 1</option>
                    <option value="shift2">Shift 2</option>
                    <option value="shift3">Shift 3</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="no-permintaan">No Permintaan</label>

                  <input type="hidden" name="no-permintaan" id="no-permintaan">
                  <input type="text" class="form-control @error('no-permintaan') is-invalid @enderror"
                    name="no-permintaan3" id="no-permintaan3" disabled>
                </div>


              </div>

              <div class="form-row">
                <div class="form-group col-md-4">
                  <label>No Induk Mesin</label>
                  <select id="no_induk_mesin" class="form-control select2 @error('no_induk_mesin') is-invalid @enderror"
                    style="width: 100%;" required>
                    <option>-------Pilih Nomer Mesin--------</option>
                    @foreach($mesin as $y)

                    <option value="{{$y->nama_mesin}}">{{$y->no_induk}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group col-md-8">
                  <label for="mesin">Mesin</label>
                  <input type="hidden" name="no_induk" id="no_induk">
                  <input type="text" class="form-control @error('mesin') is-invalid @enderror" name="mesin" id="mesin"
                    placeholder="Nama Mesin/Alat" disabled required>
                </div>

              </div>
              <div class="form-row">

                <div class="form-group col-md-4">
                  <label for="inputmasalah">Masalah</label>

                  <textarea name="masalah" class="form-control @error('masalah') is-invalid @enderror" id="masalah"
                    cols="30" rows="5" placeholder="Bagian yang bermasalah" required></textarea>
                </div>
                <div class="form-group col-md-8">
                  <label for="inputkondisi">Kondisi</label>

                  <textarea name="kondisi" class="form-control @error('kondisi') is-invalid @enderror" id="kondisi"
                    cols="30" rows="5" placeholder="Kondisi Mesin yang bermasalah"></textarea>
                </div>


              </div>
            </div>
            <div class="col-md-4 align-self-center">

              <table style="background-color: blanchedalmond; text-align:center">
                <th> Apakah Kerusakan Mesin Berdampak terhadap target produksi & perlu lapor PPIC ?</th>
                <tr>
                  <td> <input type="radio" name="ppic" id="inlineRadio1" value="N" checked>
                    <label class="form-check-label" for="inlineRadio1">Tidak</label>
                  </td>
                </tr>
                <tr>
                  <td> <input type="radio" name="ppic" id="inlineRadio2" value="Y">
                    <label class="form-check-label" for="inlineRadio2">Ya</label>
                  </td>
                </tr>
              </table>


            </div>

          </div>



          @if ($req_selesai > 0 )
          <button type="button" class="btn btn-warning" id="simpan_req">Mohon terima perbaikan yang sudah
            selesai</button>
          @else
          <button type="submit" class="btn btn-primary" id="simpan_req">Simpan</button>
          @endif
        </form>
      </div>
      <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
        aria-labelledby="custom-tabs-one-profile-tab">
        <form id="form_nonmesin" role="form">

          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-row">

                <div class="form-group col-md-4">
                  <label for="shift2">Shift</label>
                  <select name="shift2" id="shift2" class="form-control" required>
                    <option value="">Pilih Shift...</option>
                    <option value="NonShift">Non Shift</option>
                    <option value="shift1">Shift 1</option>
                    <option value="shift2">Shift 2</option>
                    <option value="shift3">Shift 3</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label for="no-permintaan2">No Permintaan</label>

                  <input type="hidden" name="no-permintaan2" id="no-permintaan2">
                  <input type="text" class="form-control @error('no-permintaan2') is-invalid @enderror"
                    name="no-permintaan4" id="no-permintaan4" disabled>
                </div>


              </div>

              <div class="form-row">
                <div class="form-group col-md-8">
                  <label for="mesin2">Nama Alat/Area</label>

                  <input type="text" class="form-control @error('mesin2') is-invalid @enderror" name="mesin2"
                    id="mesin2" placeholder="Nama Alat/Area" required>
                </div>

              </div>
              <div class="form-row">

                <div class="form-group col-md-6">
                  <label for="masalah2">Masalah</label>

                  <textarea name="masalah2" class="form-control @error('masalah') is-invalid @enderror" id="masalah2"
                    cols="30" rows="5" placeholder="Bagian yang bermasalah" required></textarea>
                </div>
                <div class="form-group col-md-6">
                  <label for="kondisi2">Kondisi</label>

                  <textarea name="kondisi2" class="form-control @error('kondisi2') is-invalid @enderror" id="kondisi2"
                    cols="30" rows="5" placeholder="Kondisi Mesin yang bermasalah"></textarea>
                </div>

              </div>
            </div>
            <div class="col-md-4 align-self-center">
              <table style="background-color: blanchedalmond; text-align:center">
                <th> Apakah Kerusakan Mesin Berdampak terhadap target produksi & perlu lapor PPIC ?</th>
                <tr>
                  <td> <input type="radio" name="ppic" id="inlineRadio1" value="N" checked>
                    <label class="form-check-label" for="inlineRadio1">Tidak</label>
                  </td>
                </tr>
                <tr>
                  <td> <input type="radio" name="ppic" id="inlineRadio2" value="Y">
                    <label class="form-check-label" for="inlineRadio2">Ya</label>
                  </td>
                </tr>
              </table>
            </div>

          </div>

          @if ($req_selesai > 0 )
          <button type="button" class="btn btn-warning" id="simpan_non">Mohon terima perbaikan yang sudah
            selesai</button>
          @else
          <button type="submit" class="btn btn-primary" id="simpan_non">Simpan</button>
          @endif
        </form>
      </div>


    </div>
  </div>
  <!-- /.card -->
</div>

<div class="card card-warning">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-two-per-tab" data-toggle="pill" href="#custom-tabs-two-per"
          role="tab" aria-controls="custom-tabs-two-per" aria-selected="true">Request Perbaikan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-selesai-tab" data-toggle="pill" href="#custom-tabs-two-selesai"
          role="tab" aria-controls="custom-tabs-two-selesai" aria-selected="false">Perbaikan Selesai @if ($req_selesai >
          0 )<span class="badge badge-danger">{{$req_selesai}}</span> @endif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-hyst-tab" data-toggle="pill" href="#custom-tabs-two-hyst" role="tab"
          aria-controls="custom-tabs-two-hyst" aria-selected="false">History</a>
      </li>
    </ul>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-two-tabContent">
      <div class="tab-pane fade active show" id="custom-tabs-two-per" role="tabpanel"
        aria-labelledby="custom-tabs-two-per-tab">
        <div class="table-responsive">
          <table class="table-hover" id="tb_perbaikan">
            <thead>
              <th>Id</th>
              <th>Tanggal</th>
              <th>Dept</th>
              <th>Shift</th>
              <th>User</th>
              <th>No. Request</th>
              <th>Nama Mesin</th>
              <th>No. Induk Mesin</th>
              <th>Masalah</th>
              <th>Kondisi</th>
              <th>Status</th>
              <th>action</th>
            </thead>
          </table>
        </div>
      </div>

      <div class="tab-pane fade" id="custom-tabs-two-selesai" role="tabpanel"
        aria-labelledby="custom-tabs-two-selesai-tab">
        <div class="table-responsive">
          <table class="table-hover text-nowrap" id="tb_selesai">
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
              <th>Tindakan</th>
              <th>Tgl Selesai</th>
              <th>action</th>
            </thead>
          </table>
        </div>
      </div>
      <div class="tab-pane fade" id="custom-tabs-two-hyst" role="tabpanel" aria-labelledby="custom-tabs-two-hyst-tab">
        <div class="row">
          <div class="col col-md-2"></div>
          <input type="date" class="form-control col-md-2" id="tgl1" value="{{date('Y-m').'-01'}}">
          <label for="" class="text-center col-md-2">Sampai</label>
          <input type="date" class="form-control col-md-2" id="tgl2" value="{{date('Y-m-d')}}">
          <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>
        </div>
        <div class="table-responsive">
          <table class="table-hover text-nowrap" id="tb_history">
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
              <th>Tindakan</th>
              <th>Tgl Selesai</th>

            </thead>
          </table>
        </div>
      </div>
    </div>

  </div>
  <!-- /.card-body -->
</div>

<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Request Perbaikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id-req">
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
            <select name="edit-shift" id="edit-shift" class="form-control" required>
              <option value="">Pilih Shift...</option>
              <option value="NonShift">Non Shift</option>
              <option value="shift1">Shift 1</option>
              <option value="shift2">Shift 2</option>
              <option value="shift3">Shift 3</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>No. Mesin :</label></div>
          <div class="col col-md-4">

            <select id="edit_no_mesin" class="form-control select2" style="width: 100%;" required>
              <option>-------Pilih Nomer Mesin--------</option>
              @foreach($mesin as $y)

              <option value="{{$y->item.' '.$y->spesifikasi}}">{{$y->item_code}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Nama Mesin :</label></div>
          <input type="hidden" name="edit_no_induk" id="edit_no_induk">
          <div class="col col-md-8">
            <label id="edit_nama_mesin"></label>
          </div>
        </div>

        <div class="row">
          <div class="col col-md-3"><label>Masalah :</label></div>
          <div class="col col-md-8">
            <textarea name="edit-masalah" id="edit-masalah" cols="30" rows="5">
              </textarea>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Kondisi :</label></div>
          <div class="col col-md-8">
            <textarea name="edit-kondisi" id="edit-kondisi" cols="30" rows="5">
              </textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-update">Update</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalinfo"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Keterangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">

              <h4 id="setatus"></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              <label for="">Sampai : </label>
              <h4 id="schd"></h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <p id="desk">

              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalconf"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-primary">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Perbaikan Selesai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">

          <div class="row">
            <div class="col-md-12 text-center">

              <p>Dengan melakukan konfirmasi permintaan ini berarti permintaan anda dinyatakan selesai, lakukan
                pemeriksaan kondisi hasil perbaikan dengan seksama.</p>
            </div>
          </div>
          <div class="row">

            <div class="col-md-12 text-center">
              <div class="icheck-danger d-inline" style="background-color:cornflowerblue">

                <input type="checkbox" id="checkboxPrimary1">
                <label for="checkboxPrimary1">Saya sudah memeriksa hasil perbaikan</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <p id="desk">

              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-light" id="btn_save">Save</button>

      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
   // $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4'
    })
});
</script>
<script type="text/javascript">
  $(document).ready(function () {
    var dept = "{{Session::get('dept')}}";
    var key = localStorage.getItem('npr_token');
    var id_selesai = 0;
    var tb_req =   $('#tb_perbaikan').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/req_perbaikan',
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
              targets: [10],
              
              render: function (data, type, row, meta){
                if (data == 'pending'||data == 'scheduled') {
                  return "<a href='#'' class='pending'>"+data+"</a>";
                }else{
                  return data;
                }
              }
            },
            {
              targets: [11],
              data: null,
              render: function (data, type, row, meta){
                if (data.status == 'open') {
                  return "<button class='btn btn-success'><i class='fa fa-edit'></i></button><button class='btn btn-danger'><i class='fa fa-trash'></i></button>";
                }else{
                  return "";
                }
              }
           
            }
        ],
       
        columns: [
            { data: 'id_perbaikan', name: 'id_perbaikan' },
            { data: 'tanggal_rusak', name: 'tanggal_rusak' },
            { data: 'departemen', name: 'departemen' },
            { data: 'shift', name: 'shift' },
            { data: 'user_name', name: 'user_name' },
            { data: 'no_perbaikan', name: 'no_perbaikan' },
            { data: 'nama_mesin', name: 'nama_mesin' },
            { data: 'no_induk_mesin', name: 'no_induk_mesin' },
            { data: 'masalah', name: 'masalah' },
            { data: 'kondisi', name: 'kondisi' },
            { data: 'status', name: 'status' },
           
        ]
    });

    var tb_selesai =   $('#tb_selesai').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/perbaikan_selesai',
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
              targets: [12],
              data: null,
              defaultContent: "<button class='btn btn-success'><i class='fa fa-check'></i></button><button class='btn btn-danger'><i class='fa fa-ban'></i></button>"
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
            { data: 'tindakan', name: 'tindakan' },
            { data: 'tanggal_selesai', name: 'tanggal_selesai' },
           
           
        ]
    });

    var tb_hist =   $('#tb_history').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/history_perbaikan',
                        type: "POST",
                        headers: { "token_req": key },
                        data: function(d){
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
            { data: 'kondisi', name: 'kondisi' },
            { data: 'tindakan', name: 'tindakan' },
            { data: 'tanggal_selesai', name: 'tanggal_selesai' },
           
           
        ]
    });
    $("#btn_refresh").click(function(){
      tb_hist.ajax.reload();
    });
    $("#checkboxPrimary1").click(function(){
        if (this.checked) {
            $("#btn_save").prop("disabled",false);
        }else{
            $("#btn_save").prop("disabled",true);
        }
    });
    $("#form_mesin").submit(function(e){
      e.preventDefault();
      var datas = $(this).serialize();
      var btn = $("#simpan_req");
      btn.attr('disabled', true);
      var pr = datas.split("&");
      
      if (pr[6].split("=")[1] == 'Y') {
        var conf = confirm("Permintaan ini akan disampaikan juga ke PPIC ?");
        if (conf) {
          update_data(APP_URL+"/request_perbaikan", key, datas).done(function(resp){
              if (resp.success) {
               
                window.location.href = "{{ route('req_perbaikan')}}";
              }else{
                alert(resp.message);
              }

           
           }).fail(function(){
              alert("error");
           }).always(function(){
              btn.attr('disabled', false);
           });
        }
        btn.attr('disabled', false);
      }else{
        update_data(APP_URL+"/request_perbaikan", key, datas).done(function(resp){
              if (resp.success) {
               
                window.location.href = "{{ route('req_perbaikan')}}";
              }else{
                alert(resp.message);
              }

           
           }).fail(function(){
              alert("error");
           }).always(function(){
              btn.attr('disabled', false);
           });
      }
     
    });

    $("#form_nonmesin").submit(function(e){
      e.preventDefault();
      var datas = $(this).serialize();
      var btn = $("#simpan_non");
      btn.attr('disabled', true);
      var pr = datas.split("&");
      //console.log(pr[6].split("=")[1]);
      if (pr[6].split("=")[1] == 'Y') {
        var conf = confirm("Permintaan ini akan disampaikan juga ke PPIC ?");
        if (conf) {
          update_data(APP_URL+"/request_nonmesin", key, datas).done(function(resp){
              if (resp.success) {
          
                window.location.href = "{{ route('req_perbaikan')}}";
              }else{
                alert(resp.message);
              }

           }).fail(function(){
              alert("error");
           }).always(function(){
            btn.attr('disabled', false);
           });
        }
        btn.attr('disabled', false);
      }else{
        update_data(APP_URL+"/request_nonmesin", key, datas).done(function(resp){
              if (resp.success) {
          
                window.location.href = "{{ route('req_perbaikan')}}";
              }else{
                alert(resp.message);
              }

           }).fail(function(){
              alert("error");
           }).always(function(){
            btn.attr('disabled', false);
           });
      }
     
    });

    $("#tb_perbaikan").on('click','.pending', function(e){
      e.preventDefault();
      var data = tb_req.row( $(this).parents('tr') ).data();
      var t = {
        id_perbaikan: data.id_perbaikan,
      };
      update_data(APP_URL+"/api/perbaikan/get_schedule", key, t).done(function(resp){
            if (resp.success) {
              console.log(resp.keterangan);
              var mulai = moment(resp.data.tanggal_rencana_mulai).format('YYYY-MM-DD');
              var selesai = moment(resp.data.tanggal_rencana_selesai).format('YYYY-MM-DD');
              $("#schd").html(selesai);
              $("#desk").html(resp.data.keterangan);
            }

           }).fail(function(){
              alert("error");
           });
     
      $("#setatus").html(data.status);
      
      $("#modalinfo").modal('toggle');
    });

    $("#tb_perbaikan").on('click','.btn-success',function(){
      var data = tb_req.row( $(this).parents('tr') ).data();
      $("#no-perbaikan").html(data.no_perbaikan);
      $("#id-req").val(data.id_perbaikan);
      $("#dept").html(data.departemen);
      $('#edit-shift option[value='+data.shift+']').attr('selected','selected');
      $("#select2-edit_no_mesin-container").html(data.no_induk_mesin);
      $("#edit_nama_mesin").html(data.nama_mesin);
      $("#edit-masalah").val(data.masalah);
      $("#edit-kondisi").val(data.kondisi);
      $("#edit_no_induk").val(data.no_induk_mesin);
      $("#edit-modal").modal("show");
    });


    $("#btn-update").click(function(){
     
            var shift = $("#edit-shift").val();
            var no_mesin = $("#edit_no_induk").val();
            var masalah = $("#edit-masalah").val();
            var kondisi = $("#edit-kondisi").val();
            var id_req = $("#id-req").val();
                $.ajax({
                type: "POST",
                url: APP_URL+"/api/update_request",
                headers: { "token_req": key },
                data:{"id":id_req, "shift": shift, "no_mesin": no_mesin, "masalah": masalah, "kondisi": kondisi} ,
                dataType: "json",
                })
                .done(function(resp) {
                    if (resp.success) {
                      alert("Update request berhasil");
                      window.location.href = "{{ route('req_perbaikan')}}";
                    }
                    else
                    $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
              
                });
    });

    $("#tb_perbaikan").on('click','.btn-danger',function(){
      var data = tb_req.row( $(this).parents('tr') ).data();
   
     var conf = confirm("Apakah request No. "+data.no_perbaikan+" akan dihapus?");
     if (conf) {
          $.ajax({
                type: "POST",
                url: APP_URL+"/api/hapus/perbaikan",
                headers: { "token_req": key },
                data:{"id": data.id_perbaikan} ,
                dataType: "json",
            })
            .done(function(resp) {
            if (resp.success) {
              alert("Hapus request berhasil");
              window.location.href = "{{ route('req_perbaikan')}}";
            }
            else
            $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
        })
        .fail(function() {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
       
        });
     }

    });

    $("select#shift").change(function(){

        var d = new Date();
        var tahun = d.getFullYear();
        var bulan = d.getMonth()+1;
        var tanggal = d.getDate();
       
        var tgl =tahun+"-"+bulan+"-"+tanggal;
        $.ajax({
            type: "POST",
            url: APP_URL+"/api/nomer_perbaikan",
            headers: { "token_req": key },
            data:{"tanggal": tgl} ,
            dataType: "json",

            success : function (response) {
               var nomer = response.no_perbaikan;
               
               $("#no-permintaan").val(nomer);
               $("#no-permintaan3").val(nomer);
                  
            }
           
        });
    });

    $("#no_induk_mesin").change(function(){
        var nama_mesin = $(this).children("option:selected").val();
        var no_mesin = $(this).children("option:selected").html();
        $("#no_induk").val(no_mesin)
        $("#mesin").val(nama_mesin);
    });

    $("select#shift2").change(function(){

        var d = new Date();
        var tahun = d.getFullYear();
        var bulan = d.getMonth()+1;
        var tanggal = d.getDate();
       
        var tgl =tahun+"-"+bulan+"-"+tanggal;
        $.ajax({
            type: "POST",
            url: APP_URL+"/api/nomer_perbaikan",
            headers: { "token_req": key },
            data:{"tanggal": tgl} ,
            dataType: "json",

            success : function (response) {
              var nomer = response.no_perbaikan;
             
              $("#no-permintaan2").val(nomer);
              $("#no-permintaan4").val(nomer);
                  
            }
          
        });
        });

        $("#edit_no_mesin").change(function(){
        var nama_mesin = $(this).children("option:selected").val();
        var no_mesin = $(this).children("option:selected").html();
        $("#edit_no_induk").val(no_mesin);
        $("#edit_nama_mesin").html(nama_mesin);
         });

         $("#tb_selesai").on('click','.btn-success',function(){
          id_selesai = tb_selesai.row( $(this).parents('tr') ).data();
          $("#btn_save").prop("disabled",true);
          $("#checkboxPrimary1").prop("checked",false);
          $("#modalconf").modal("toggle");
          /*
          var y = confirm("Apakah Perbaikan No. "+data.no_perbaikan+" sudah selesai?")

          if (y) {
            var id_req = {'id':data.id_perbaikan};
           update_data(APP_URL+"/api/perbaikan/complete", key, id_req).done(function(resp){
            if (resp.success) {
              alert(resp.message);
              window.location.href = "{{ route('req_perbaikan')}}";
            }else{
              alert(resp.message);
            }

           }).fail(function(){
              alert("error");
           });
          }
          */
         });
         $("#btn_save").click(function(){
          if($("#checkboxPrimary1").prop("checked")){
                var id_req = {'id':id_selesai.id_perbaikan};
              update_data(APP_URL+"/api/perbaikan/complete", key, id_req).done(function(resp){
                if (resp.success) {
                  //alert(resp.message);
                  window.location.href = "{{ route('req_perbaikan')}}";
                }else{
                  alert(resp.message);
                }

              }).fail(function(){
                  alert("error");
              });
          }else{
            alert("Konfirmasi pemeriksaan hasil perbaikan !")
          }
         });
         $("#tb_selesai").on('click','.btn-danger',function(){
          var data = tb_selesai.row( $(this).parents('tr') ).data();
          

          var y = confirm("Apakah Perbaikan No. "+data.no_perbaikan+" ditolak?")

          if (y) {
            var id_req = {'id':data.id_perbaikan};
           update_data(APP_URL+"/api/perbaikan/ditolak", key, id_req).done(function(resp){
            if (resp.success) {
              alert(resp.message);
              window.location.href = "{{ route('req_perbaikan')}}";
            }else{
              alert(resp.message);
            }

           }).fail(function(){
              alert("error");
           });
          }

         });


});

function update_data(link_url,key,p_data){
  return $.ajax({
            type: "POST",
            url: link_url,
            headers: { "token_req": key },
            data:p_data ,
            dataType: "json",
          
        });
}
</script>
@endsection