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

<div class="card">
  <div class="card-header">

    <form action="{{url('/produksi/inputpermintaanproduksi')}}" method="post">

      @csrf
      <div class="row">
        <div class="form-group col-md-1">
          <label for="tujuan">Tujuan</label>
          <select name="tujuan" id="tujuan" class="form-control" required>
            <option value="">Choose...</option>
            <option value="TCH">TCH</option>
            <option value="QA">QA</option>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="permintaan">Permintaan</label>
          <input type="hidden" nama="permintaan" id="permintaan">
          <input type="hidden" name="unik" id="unik">
          <select name="permintaan1" id="permintaan1" class="form-control" required>
            <option value="">Choose...</option>
            <option value="KR">REPAIR</option>
            <option value="KG">PEMBUATAN GAMBAR</option>
            <option value="KP">PEMBUATAN JIGU / SPARE PART</option>
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="no_laporan">No Laporan</label>
          <input type="text" class="form-control" name="no_laporan_1" id="no_laporan_1" disabled>
          <input type="hidden" name="no_laporan" id="no_laporan">
        </div>
        <div class="form-group col-md-2">
          <label for="jenis_item">Jenis Item</label>
          <select name="jenis_item" id="jenis_item" class="form-control" required>
            <option value="">Choose...</option>
            <option value="Jigu">Jigu</option>
            <option value="Spare Part">Spare Part</option>
            <option value="Gambar">Gambar</option>
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="nouki">Nouki</label>
          <input type="date" class="form-control" name="nouki" id="nouki" placeholder="nouki" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-3">
          <label for="nama_mesin">Nama Mesin</label>
          <input type="text" class="form-control" name="nama_mesin" id="nama_mesin" placeholder="Nama Mesin" required>
        </div>
        <div class="form-group col-md-3">
          <label for="nama_item">Nama item</label>
          <input type="text" class="form-control" name="nama_item" id="nama_item" required>
        </div>
        <div class="form-group col-md-2">
          <label for="ukuran">Ukuran</label>
          <input type="text" class="form-control" name="ukuran" id="ukuran">
        </div>
        <div class="form-group col-md-1">
          <label for="qty">Qty</label>
          <input type="number" class="form-control" name="qty" id="qty" required>
        </div>
        <div class="form-group col-md-2">
          <label for="satuan">Satuan</label>
          <select name="satuan" id="satuan" class="form-control">
            <option selected>Choose...</option>
            <option>Pcs</option>
            <option>Set</option>
          </select>
        </div>
      </div>
      <div class="row">
      </div>
      <div class="row">
        <div class="form-group col-md-6">
          <label for="alasan">Alasan</label>
          <input type="text" class="form-control" name="alasan" id="alasan" required>
        </div>
        <div class="form-group col-md-5">
          <label for="permintaan_perbaikan">Permintaan Perbaikan</label>
          <input type="text" class="form-control" name="permintaan_perbaikan" id="permintaan_perbaikan" required>
        </div>
      </div>
      @if ($jigu_selesai > 0 )
      <input type="submit" value="Jigu request has been completed, Please Confirm ." class="btn btn-warning"
        id="btn_error">
      @else
      <input type="submit" value="simpan" class="btn btn-primary">
      @endif
    </form>
  </div>
</div>




<div class="card card-info card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
          role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Permintaan Menunggu Persetujuan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
          role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Status Permintaan</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-one-tabContent">
      <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
        aria-labelledby="custom-tabs-one-home-tab">

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap" id="tb_permintaan_kerja">
            <thead>
              <tr>
                <th>id</th>
                <th>Tanggal</th>
                <th>No Laporan</th>
                <th>Dept</th>
                <th>User</th>
                <th>Permintaan</th>
                <th>Jenis Item</th>
                <th>Nama Mesin</th>
                <th>Nama Item</th>
                <th>Ukuran</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Nouki</th>
                <th>Permintaan Perbaikan</th>
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
        <div class="card-body table-responsive p-0">

          <div class="row">
            <div class="form-group col-md-2">
              <label for="beginning">Beginning</label>
              <input type="date" class="form-control" id="tgl_req1" value="{{date('Y-m').'-01'}}">
            </div>
            <div class="form-group col-md-2">
              <label>Ending</label>
              <input type="date" class="form-control" id="tgl_req2" value="{{date('Y-m-d')}}">
            </div>
            <div class="form-group col-md-2">
              <label> Status : </label>
              <select name="status_req" id="status_req" class="form-control" value="All">
                <option value="All">All</option>
                <option value="Open">Open</option>
                <option value="Proses">Proses</option>
                <option value="Tolak">Tolak</option>
                <option value="Pending">Pending</option>
              </select>
            </div>
            <div class="form-group col-md-1">
              <label> Reload </label>
              <button class="btn btn-primary" id="btn_req_refresh"><i class="fa fa-sync"></i></button>
            </div>
          </div>
          <table class="table table-hover text-nowrap" id="tb_permintaan_kerja_1">
            <thead>
              <tr>
                <th>id</th>
                <th>Tanggal</th>
                <th>No Laporan</th>
                <th>Dept</th>
                <th>User</th>
                <th>Permintaan</th>
                <th>Jenis Item</th>
                <th>Nama Mesin</th>
                <th>Nama Item</th>
                <th>Ukuran</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Nouki</th>
                <th>Permintaan Perbaikan</th>
                <th>operator tch</th>
                <th>Material</th>
                <th>Accept By</th>
                <th>Status</th>
                <th>Tanggal Selesai</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="card-footer">

          <button class="btn btn-success" id="btn_excel_req">Download Excel</button>
        </div>
      </div>
    </div>
  </div>
</div>




<div class="card card-info card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#jigu_selesai" role="tab"
          aria-controls="jigu_selesai" aria-selected="true">Jigu Selesai @if ($jigu_selesai > 0 )<span
            class="badge badge-danger">{{$jigu_selesai}}</span> @endif</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#list_selesai" role="tab"
          aria-controls="list_selesai" aria-selected="false">Penerimaan</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="custom-tabs-two-tabContent">
      <div class="tab-pane fade active show" id="jigu_selesai" role="tabpanel"
        aria-labelledby="custom-tabs-one-home-tab">

        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">

          <table class="table table-hover text-nowrap" id="tb_selesai">
            <thead>
              <tr>
                <th>id</th>
                <th>Tanggal Selesai</th>
                <th>No Laporan</th>
                <th>Dept</th>
                <th>User</th>
                <th>Permintaan</th>
                <th>Jenis Item</th>
                <th>Nama Mesin</th>
                <th>Nama Item</th>
                <th>Ukuran</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Permintaan Perbaikan</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>

      <div class="tab-pane fade" id="list_selesai" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
        <div class="card-body table-responsive p-0">
          <div class="row justify-center">

            <input type="date" class="form-control col-md-2" id="tgl1" value="{{date('Y-m').'-01'}}">
            <label for="" class="col-md-2 text-center">Sampai</label>
            <input type="date" class="form-control col-md-2" id="tgl2" value="{{date('Y-m-d')}}">
            <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>
          </div>
          <table class="table table-hover text-nowrap" id="tb_listselesai">
            <thead>
              <tr>
                <th>id</th>
                <th>Tanggal Selesai</th>
                <th>No Laporan</th>
                <th>Dept</th>
                <th>User</th>
                <th>Permintaan</th>
                <th>Jenis Item</th>
                <th>Nama Mesin</th>
                <th>Nama Item</th>
                <th>Ukuran</th>
                <th>Qty OK</th>
                <th>Satuan</th>
                <th>Penerima</th>
                <th>Permintaan Perbaikan</th>
                <th>Operator Technical</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="card-footer">

          <button class="btn btn-success" id="btn_excel">Download Excel</button>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Permintaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id-permintaan">
        <div class="row">
          <div class="col col-md-4"><label>No. Permintaan :</label></div>
          <div class="col col-md-4">
            <label id="no_laporan1"></label>
          </div>
        </div>

        <div class="row">
          <div class="col col-md-4"><label>Departemen :</label></div>
          <div class="col col-md-8">
            <label id="dept"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>User :</label></div>
          <div class="col col-md-8">
            <label id="nama_user"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Permintaan :</label></div>
          <div class="col col-md-8">
            <label id="permintaan2"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Ukuran :</label></div>
          <div class="col col-md-8"><input type="text" id="editukuran1"></div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Qty :</label></div>
          <div class="col col-md-8"><input type="number" id="qty1"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Print -->
<div class="modal fade" id="modal_terima" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Barang Selesai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col col-md-4"><label>Jumlah OK :</label></div>
          <div class="col col-md-4">
            <input type="hidden" id="id_selesai" name="id_selesai">
            <input type="number" class="form-control" name="qty_ok" id="qty_ok">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')



<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    var key = localStorage.getItem('npr_token');
    var dept = "{{Session::get('dept')}}";
    var list_permintaan = $('#tb_permintaan_kerja').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      responsive: true,
      ordering: false,

      ajax: {
        url: APP_URL + '/api/inquerypermintaan',
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
        targets: [15],
        data: null,
        defaultContent: "<button class='btn btn-success'><i class='fa fa-edit'></i></button><button class='btn btn-danger'><i class='fa fa-trash'></i></button>"

      }
      ],

      columns: [{
        data: 'id_permintaan',
        name: 'id_permintaan'
      },
      {
        data: 'tanggal_permintaan',
        name: 'tanggal_permintaan'
      },
      {
        data: 'no_laporan',
        name: 'no_laporan'
      },
      {
        data: 'dept',
        name: 'dept'
      },
      {
        data: 'nama_user',
        name: 'nama_user'
      },
      {
        data: 'permintaan',
        name: 'permintaan'
      },
      {
        data: 'jenis_item',
        name: 'jenis_item'
      },
      {
        data: 'nama_mesin',
        name: 'nama_mesin'
      },
      {
        data: 'nama_item',
        name: 'nama_item'
      },
      {
        data: 'ukuran',
        name: 'ukuran'
      },
      {
        data: 'satuan',
        name: 'satuan'
      },
      {
        data: 'qty',
        name: 'qty',
        render: $.fn.dataTable.render.number(',', '.', 0, '')
      },
      {
        data: 'nouki',
        name: 'nouki'
      },
      {
        data: 'permintaan_perbaikan',
        name: 'permintaan_perbaikan'
      },
      {
        data: 'status',
        name: 'status'
      },
      ],
      fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
        if (data.status == "Tolak") {
          $('td', nRow).css('background-color', '#ff9966');
          $('td', nRow).css('color', 'White');
        }
      },
    });

    $("#tb_permintaan_kerja").on('click', '.btn-success', function () {
      var data = list_permintaan.row($(this).parents('tr')).data();
      $("#id-permintaan").val(data.id_permintaan);
      $("#no_laporan1").html(data.no_laporan);
      $("#dept").html(data.dept);
      $("#nama_user").html(data.nama_user);
      $("#permintaan2").html(data.permintaan);
      $("#editukuran1").val(data.ukuran);
      $("#qty1").val(data.qty);
      $('#edit-modal').modal('show');
    });


    $("#btn-save").click(function () {
      var ukuran = $("#editukuran1").val();
      var qty = $("#qty1").val();
      var id_permintaan = $("#id-permintaan").val();
      $.ajax({
        type: "POST",
        url: APP_URL + "/api/update_permintaan",
        headers: {
          "token_req": key
        },
        data: {
          "id": id_permintaan,
          "ukuran": ukuran,
          "qty": qty
        },
        dataType: "json",
      })
        .done(function (resp) {
          if (resp.success) {
            alert("Update request berhasil");
            window.location.href = "{{ route('req_permintaan')}}";
          } else
            $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
        })
        .fail(function () {
          $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

        });
    });


    $("#tb_permintaan_kerja").on('click', '.btn-danger', function () {
      var data = list_permintaan.row($(this).parents('tr')).data();

      var conf = confirm("Apakah request No. " + data.no_laporan + " akan dihapus?");
      if (conf) {
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/hapus/permintaan",
          headers: {
            "token_req": key
          },
          data: {
            "id": data.id_permintaan
          },
          dataType: "json",
        })
          .done(function (resp) {
            if (resp.success) {
              alert("Hapus request berhasil");
              window.location.href = "{{ route('req_permintaan')}}";
            } else
              $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
          })
          .fail(function () {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

          });
      }

    });



    $("select#permintaan1").change(function () {
      var d = new Date();
      var tahun = d.getFullYear();
      var bulan = d.getMonth() + 1;
      var tanggal = d.getDate();
      var dept = $("#permintaan1").val();
      var permintaan = $("#permintaan1 option:selected").text();
      $("#permintaan").val(permintaan);
      $("#unik").val(permintaan);
      var tgl = tahun + "-" + bulan + "-" + tanggal;
      $.ajax({
        type: "POST",
        url: APP_URL + "/api/nomer_permintaan",
        headers: {
          "token_req": key
        },
        data: {
          "permintaan": dept,
          "tanggal_permintaan": tgl
        },
        dataType: "json",

        success: function (response) {
          var nomer = response[0].no_laporan;
          $("#no_laporan").val(nomer);
          $("#no_laporan_1").val(nomer);

        }

      });
    });

    var key = localStorage.getItem('npr_token');
    var list_permintaan_1 = $('#tb_permintaan_kerja_1').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/inquerypermintaan_tch',
        type: "POST",
        headers: {
          "token_req": key
        },
        data: function (d) {
          d.tgl_awal = $("#tgl_req1").val();
          d.tgl_akhir = $("#tgl_req2").val();
          d.status_req1 = $("#status_req").val();
        }
      },

      columnDefs: [{
        targets: [0],
        visible: false,
        searchable: false
      }],

      columns: [{
        data: 'id_permintaan',
        name: 'id_permintaan'
      },
      {
        data: 'tanggal_permintaan',
        name: 'tanggal_permintaan'
      },
      {
        data: 'no_laporan',
        name: 'no_laporan'
      },
      {
        data: 'dept',
        name: 'dept'
      },
      {
        data: 'nama_user',
        name: 'nama_user'
      },
      {
        data: 'permintaan',
        name: 'permintaan'
      },
      {
        data: 'jenis_item',
        name: 'jenis_item'
      },
      {
        data: 'nama_mesin',
        name: 'nama_mesin'
      },
      {
        data: 'nama_item',
        name: 'nama_item'
      },
      {
        data: 'ukuran',
        name: 'ukuran'
      },
      {
        data: 'satuan',
        name: 'satuan'
      },
      {
        data: 'qty',
        name: 'qty',
        render: $.fn.dataTable.render.number(',', '.', 0, '')
      },
      {
        data: 'nouki',
        name: 'nouki'
      },
      {
        data: 'permintaan_perbaikan',
        name: 'permintaan_perbaikan'
      },
      {
        data: 'operator_tch',
        name: 'operator_tch'
      },
      {
        data: 'material',
        name: 'material'
      },
      {
        data: 'accept_by',
        name: 'accept_by'
      },
      {
        data: 'status',
        name: 'status'
      },
      {
        data: 'tanggal_selesai',
        name: 'tanggal_selesai'
      },
      ]
    });

    $("#btn_req_refresh").click(function () {
      list_permintaan_1.ajax.reload();
    });

    $("#btn_excel_req").click(function () {
      var tgl_awal = $('#tgl_req1').val();
      var tgl_akhir = $('#tgl_req2').val();

      var c = confirm("Apakah anda akan download list periode " + tgl_awal + " - " + tgl_akhir + " ?");
      if (c) {
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/technical/eksportpermintaan",
          headers: { "token_req": key },
          data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir },
          dataType: "json",

          success: function (response) {
            var fpath = response.file;
            window.open(fpath, '_blank');

          }

        });

      }
    });

    var jigu_selesai = $('#tb_selesai').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/produksi/jiguselesai',
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
        targets: [13],
        data: null,

        render: function (data, type, row, meta) {

          return "<button class='btn btn-success'><i class='fa fa-check'></i></button>";


        }
      }
      ],

      columns: [{
        data: 'id_jigu_selesai',
        name: 'id_jigu_selesai'
      },
      {
        data: 'tanggal',
        name: 'tanggal'
      },
      {
        data: 'no_laporan',
        name: 'no_laporan'
      },
      {
        data: 'dept',
        name: 'dept'
      },
      {
        data: 'nama_user',
        name: 'nama_user'
      },
      {
        data: 'permintaan',
        name: 'permintaan'
      },
      {
        data: 'jenis_item',
        name: 'jenis_item'
      },
      {
        data: 'nama_mesin',
        name: 'nama_mesin'
      },
      {
        data: 'nama_item',
        name: 'nama_item'
      },
      {
        data: 'ukuran',
        name: 'ukuran'
      },
      {
        data: 'jumlah',
        name: 'jumlah',
        render: $.fn.dataTable.render.number(',', '.', 0, '')
      },
      {
        data: 'satuan',
        name: 'satuan'
      },

      {
        data: 'permintaan_perbaikan',
        name: 'permintaan_perbaikan'
      },


      ]
    });
    $("#tb_selesai").on('click', '.btn-success', function () {
      var data = jigu_selesai.row($(this).parents('tr')).data();
      $("#qty_ok").val(data.jumlah);
      $("#id_selesai").val(data.id_jigu_selesai);
      $("#modal_terima").modal("show");
    });

    $("#btn-simpan").click(function () {
      var id_selesai = $("#id_selesai").val();
      var qty = $("#qty_ok").val();

      $.ajax({
        type: "POST",
        url: APP_URL + "/api/produksi/terimajigu",
        headers: {
          "token_req": key
        },
        data: {
          "id": id_selesai,
          "qty": qty,
        },
        dataType: "json",
      })
        .done(function (resp) {
          if (resp.success) {
            alert(resp.message);
            window.location.href = "{{ route('req_permintaan')}}";
          } else
            alert(resp.message);
        })
        .fail(function () {
          $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

        });
    });

    var list_selesai = $('#tb_listselesai').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/produksi/listselesai',
        type: "POST",
        headers: {
          "token_req": key
        },
        data: function (d) {
          d.tgl_awal = $("#tgl1").val();
          d.tgl_akhir = $("#tgl2").val();
        }
      },

      columnDefs: [{
        targets: [0],
        visible: false,
        searchable: false
      },

      ],

      columns: [{
        data: 'id_jigu_selesai',
        name: 'id_jigu_selesai'
      },
      {
        data: 'tgl_selesai',
        name: 'tgl_selesai'
      },
      {
        data: 'no_laporan',
        name: 'no_laporan'
      },
      {
        data: 'dept',
        name: 'dept'
      },
      {
        data: 'nama_user',
        name: 'nama_user'
      },
      {
        data: 'permintaan',
        name: 'permintaan'
      },
      {
        data: 'jenis_item',
        name: 'jenis_item'
      },
      {
        data: 'nama_mesin',
        name: 'nama_mesin'
      },
      {
        data: 'nama_item',
        name: 'nama_item'
      },
      {
        data: 'ukuran',
        name: 'ukuran'
      },
      {
        data: 'qty_ok',
        name: 'qty_ok',
        render: $.fn.dataTable.render.number(',', '.', 0, '')
      },
      {
        data: 'satuan',
        name: 'satuan'
      },
      {
        data: 'penerima',
        name: 'penerima'
      },
      {
        data: 'permintaan_perbaikan',

        name: 'permintaan_perbaikan'
      },
      {
        data: 'operator_tch',
        name: 'operator_tch'
      },


      ]
    });

    $("#btn_refresh").click(function () {

      list_selesai.ajax.reload();
    });

    $("#btn_error").click(function () {
      alert("Jigu request has been completed, Please Confirm .");
    });

    $("#btn_excel").click(function () {
      var tgl_awal = $('#tgl1').val();
      var tgl_akhir = $('#tgl2').val();

      var c = confirm("Apakah anda akan download list periode " + tgl_awal + " - " + tgl_akhir + " ?");
      if (c) {
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/technical/listselesai",
          headers: { "token_req": key },
          data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir },
          dataType: "json",

          success: function (response) {
            var fpath = response.file;
            window.open(fpath, '_blank');

          }

        });

      }
    });

  });
</script>

@endsection