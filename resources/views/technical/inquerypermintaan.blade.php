@extends('layout.main')
@section('content')


<div class="card card-warning card-tabs">
  <div class="card-header p-0 pt-1">
    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
          role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Permintaan Menunggu Persetujuan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
          role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Permintaan sudah diterima TCH</a>
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
                <th>Jenis Permintaan</th>
                <th>Nama Mesin</th>
                <th>Nama Item</th>
                <th>Ukuran</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Nouki</th>
                <th>Permintaan Perbaikan</th>
                <th>Accept By</th>
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
          <select name="sstatus" id="sstatus" class="form-control col-md-2" value="proses">

            <option value="Proses">Proses</option>
            <option value="Close">Close</option>
            <option value="Waiting User">Waiting User</option>
            <option value="All">All</option>
          </select>
          <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
        </div>
        <br>
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap" id="tb_permintaan_kerja_1">
            <thead>
              <tr>
                <th>id</th>
                <th>Tanggal</th>
                <th>No Laporan</th>
                <th>Dept</th>
                <th>User</th>
                <th>Permintaan</th>
                <th>Jenis Permintaan</th>
                <th>Nama Mesin</th>
                <th>Nama Item</th>
                <th>Ukuran</th>
                <th>Satuan</th>
                <th>Qty</th>
                <th>Nouki</th>
                <th>Permintaan Perbaikan</th>
                <th>operator tch</th>
                <th>Material</th>
                <th>Tgl Selesai TCH</th>
                <th>Qty Tch</th>
                <th>Status</th>
                <th>Qty terima user</th>
                <th>Tgl Terima user</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="edit-modal-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Permintaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id-permintaan-2">
        <div class="row">
          <div class="col col-md-4"><label>No. Permintaan</label></div>
          <label>:</label>
          <div class="col col-md-4">
            <label id="no_laporan1_1"></label>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id-permintaan-2">
            <div class="row">
              <div class="col col-md-4"><label>No. Permintaan</label></div>
              <label>:</label>
              <div class="col col-md-4">
                <label id="no_laporan1_1"></label>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Jenis Permintaan</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <label id="edit-jenisitem-1"></label>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Departemen</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <label id="dept-1"></label>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-4"><label>Nama Item</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <label id="edit-namaitem-1"></label>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-4"><label>Ukuran</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <label id="edit-ukuran-1"></label>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Qty</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <input type="hidden" id="qty_req">
                <label id="edit-qty-1"></label>
              </div>
            </div>

            <div class="row">
              <div class="col col-md-4"><label>Tanggal Selesai TCH</label></div>
              <label>:</label>
              <div class="col col-md-6"><input type="date" class="form-control" id="edit-tanggal_selesai_1" required>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Material</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <select name="edit-material-1" id="edit-material-1" class="form-control" required>
                  <option value="">Choose...</option>
                  @if(Session::get('dept') == 'MEASUREMENT & KALIBRASI')
                  <option value="NFKO-2">NFKO-2</option>
                  <option value="NFKO-3">NFKO-3</option>
                  <option value="NFKO-14">NFKO-14</option>
                  <option value="NFKO-15">NFKO-15</option>
                  <option value="NFKO-16">NFKO-16</option>
                  <option value="NFKO-21">NFKO-21</option>
                  <option value="NFKO-16X2">NFKO-16X2</option>
                  <option value="NIK-220-0">NIK-220-0</option>
                  @else
                  <option value="-">-</option>
                  <option value="S45C">S45C</option>
                  <option value="SUS304">SUS 304</option>
                  <option value="FC25">FC25</option>
                  <option value="BRONZE">BRONZE</option>
                  <option value="HEXA">HEXA</option>
                  <option value="NYLON">NYLON</option>
                  <option value="NFKO-2">NFKO-2</option>
                  <option value="NFKO-3">NFKO-3</option>
                  <option value="NFKO-14">NFKO-14</option>
                  <option value="NFKO-15">NFKO-15</option>
                  <option value="NFKO-21">NFKO-21</option>
                  <option value="NFKO-16X2">NFKO-16X2</option>
                  <option value="NIK-220-0">NIK-220-0</option>
                  <option value="Brass / Kuningan">Brass / Kuningan</option>
                  <option value="ETC">ETC</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Operator TCH</label></div>
              <label>:</label>
              <div class="col-12 col-sm-6">
                <div class="col col-md-12">
                  <h10>Select multiple Operator</h10>
                </div>
                <div class="form-group">
                  <div class="select2-purple">
                    <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Select a Operator"
                      data-dropdown-css-class="select2-purple" style="width: 100%;" data-select2-id="15" tabindex="-1"
                      aria-hidden="true" name="edit-operator-tch" id="edit-operator-tch">
                      @if(Session::get('dept') == 'MEASUREMENT & KALIBRASI')
                      <option value="MUHAMMAD FADIL RIADI">MUHAMMAD FADIL RIADI</option>
                      @else
                      @foreach ($oprtch as $opr)
                      <option value="{{$opr->nama}}">{{$opr->nama}}</option>
                      @endforeach

                      @endif
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Qty Selesai</label></div>
              <label>:</label>
              <div class="col col-md-6"><input type="number" class="form-control" id="qty_selesai" min="0"
                  placeholder="Jumlah selesai" required></div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Tindakan Perbaikan</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <select type="text" class="form-control" name="operator" id="edit-tindakan_perbaikan_1"
                  placeholder="Tindakan Perbaikan" required>
                  <option value="">Pilih...</option>
                  <option value="Repair">Repair</option>
                  <option value="Buat Baru">Buat Baru</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col col-md-4"><label>Status</label></div>
              <label>:</label>
              <div class="col col-md-6">
                <select name="edit-status" id="edit-status-1" class="form-control" required>
                  <option value="Close">Close</option>
                  <option value="Pending">Pending</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" id="btn-save-1">Update</button>
            </div>
          </div>
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
        <input type="hidden" id="id-permintaan-1">
        <div class="row">
          <div class="col col-md-4"><label>No. Permintaan</label></div>
          <label>:</label>
          <div class="col col-md-4">
            <label id="no_laporan1"></label>
          </div>
        </div>

        <div class="row">
          <div class="col col-md-4"><label>Departemen</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <label id="dept"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>User</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <label id="nama_user"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Nama Item</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <label id="edit-namaitem"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Jenis Item</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <label id="edit-jenisitem"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Ukuran</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <label id="edit-ukuran"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-4"><label>Qty</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <label id="edit-qty"></label>
          </div>
        </div>

        <div class="row">
          <div class="col col-md-4"><label>Status</label></div>
          <label>:</label>
          <div class="col col-md-6">
            <select name="edit-status" id="edit-status" class="form-control" required>
              <option value="Open">Open</option>
              <option value="Proses">Proses</option>
              <option value="Tolak">Tolak</option>
              <option value="Pending">Pending</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-save">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')


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

    $('#tb_permintaan_kerja').ready(function () {
      var key = localStorage.getItem('npr_token');
      var list_permintaan = $('#tb_permintaan_kerja').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: {
          url: APP_URL + '/api/inquerypermintaan_all',
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
          targets: [16],
          data: null,
          defaultContent: "<button class='btn btn-primary'><i class='fas fa-check'></i></button>"
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
          data: 'accept_by',
          name: 'accept_by'
        },
        {
          data: 'status',
          name: 'status'
        },
        ]
      });


      $('#tb_permintaan_kerja').on('click', '.btn-primary', function () {
        var data = list_permintaan.row($(this).parents('tr')).data();
        $("#id-permintaan-1").val(data.id_permintaan);
        $("#no_laporan1").html(data.no_laporan);
        $("#dept").html(data.dept);
        $("#nama_user").html(data.nama_user);
        $("#edit-namaitem").html(data.nama_item);
        $("#edit-jenisitem").html(data.jenis_item);
        $("#edit-ukuran").html(data.ukuran);
        $("#edit-qty").html(data.qty);
        $('#edit-status option[value=' + data.status + ']').attr('selected', 'selected');
        $('#edit-modal').modal('show');
      });



      $("#btn-save").click(function () {
        var accept_by = $("#edit-accept_by").val();
        var status = $("#edit-status").val();
        var id_permintaan = $("#id-permintaan-1").val();
        //alert("No. " + id_permintaan);
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/update_permintaan_tch",
          headers: {
            "token_req": key
          },
          data: {
            "id": id_permintaan,
            "accept_by": accept_by,
            "status": status
          },
          dataType: "json",
        })
          .done(function (resp) {
            if (resp.success) {
              alert("Update request berhasil");
              if (resp.proses == 'Proses') {
                window.open(APP_URL + "/cetak_permintaan_tch/" + id_permintaan, '_blank');
              }
              //window.location.href = "{{ route('req_permintaan_tch')}}";
              location.reload();
            } else
              $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
          })
          .fail(function () {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

          });
      });

      var key = localStorage.getItem('npr_token');
      var list_permintaan_1 = $('#tb_permintaan_kerja_1').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: {
          url: APP_URL + '/api/inquerypermintaan_tch_all',
          type: "POST",
          headers: {
            "token_req": key
          },
          data: function (d) {
            d.sstatus = $("#sstatus").val();
          }

        },

        columnDefs: [{
          targets: [0],
          visible: false,
          searchable: false
        },
        {
          targets: [21],
          data: null,
          //defaultContent: "<button class='btn btn-success'>Complited</button>"
          render: function (data, type, row, meta) {
            if (data.status1 == "Close" || data.status1 == "Tolak") {
              return " ";
            } else {
              return "<button class='btn btn-success btn-sm btn-flat'>Complete</button><button class='btn btn-danger btn-sm btn-flat'>print</button>";
            }
          }
        }
        ],

        columns: [{ data: 'id_permintaan', name: 'id_permintaan' },
        { data: 'tanggal_permintaan', name: 'tanggal_permintaan' },
        { data: 'no_laporan', name: 'no_laporan' },
        { data: 'dept', name: 'dept' },
        { data: 'nama_user', name: 'nama_user' },
        { data: 'permintaan', name: 'permintaan' },
        { data: 'jenis_item', name: 'jenis_item' },
        { data: 'nama_mesin', name: 'nama_mesin' },
        { data: 'nama_item', name: 'nama_item' },
        { data: 'ukuran', name: 'ukuran' },
        { data: 'satuan', name: 'satuan' },
        { data: 'qty', name: 'qty', render: $.fn.dataTable.render.number(',', '.', 0, '') },
        { data: 'nouki', name: 'nouki' },
        { data: 'permintaan_perbaikan', name: 'permintaan_perbaikan' },
        { data: 'operator_tch', name: 'operator_tch' },
        { data: 'material', name: 'material' },
        { data: 'tanggal_selesai_tch', name: 'tanggal_selesai_tch' },
        { data: 'qty_selesai_tch', name: 'qty_selesai_tch', render: $.fn.dataTable.render.number(',', '.', 0, '') },
        { data: 'status1', name: 'status1' },
        { data: 'qty_selesai', name: 'qty_selesai', render: $.fn.dataTable.render.number(',', '.', 0, '') },
        { data: 'tanggal_selesai', name: 'tanggal_selesai' },
        ]
      });

      $("#btn_reload_status").click(function () {
        list_permintaan_1.ajax.reload();
      });

      $('#tb_permintaan_kerja_1').on('click', '.btn-success', function () {
        var data = list_permintaan_1.row($(this).parents('tr')).data();
        $("#id-permintaan-2").val(data.id_permintaan);
        $("#no_laporan1_1").html(data.no_laporan);
        $("#dept-1").html(data.dept);
        $("#nama_user_1").html(data.nama_user);
        $("#edit-namaitem-1").html(data.nama_item);
        $("#edit-jenisitem-1").html(data.jenis_item);
        $("#edit-ukuran-1").html(data.ukuran);
        $("#edit-qty-1").html(data.qty);
        $("#edit-accept_by_1").html(data.accept_by);
        $("#edit-tanggal_selesai_1").val(data.tanggal_selesai);
        $("#edit-material-1").val(data.material);
        $("#edit-operator-tch").val(data.operator_tch);
        $('#edit-status-1 option[value=' + data.status + ']').attr('selected', 'selected');
        $('#edit-modal-1').modal('show');
      });

      $("#btn-save-1").click(function () {
        var tanggal_selesai = $("#edit-tanggal_selesai_1").val();
        var accept_by = $("#edit-accept_by").val();
        var status = $("#edit-status-1").val();
        var material = $("#edit-material-1").val();
        var operator_tch = $("#edit-operator-tch").val();
        var id_permintaan = $("#id-permintaan-2").val();
        var qty = $("#qty_selesai").val();
        var tindakan_perbaikan = $("#edit-tindakan_perbaikan_1").val();
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/technical/selesai",
          headers: {
            "token_req": key
          },
          data: {
            "id": id_permintaan,
            "tanggal_selesai": tanggal_selesai,
            "status": status,
            "material": material,
            "operator_tch": operator_tch,
            "qty": qty,
            "tindakan_perbaikan": tindakan_perbaikan,
          },
          dataType: "json",
        })
          .done(function (resp) {
            if (resp.success) {
              alert("Update request berhasil");
              //window.location.href = "{{ route('req_permintaan_tch')}}";
              //location.href = "#custom-tabs-one-profile";
              //location.reload();
              $('#edit-modal-1').modal('toggle');
              list_permintaan_1.ajax.reload();
            } else
              alert(resp.message);

          })
          .fail(function () {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

          });
      });

      $('#tb_permintaan_kerja_1').on('click', '.btn-danger', function () {
        var data = list_permintaan_1.row($(this).parents('tr')).data();

        var conf = confirm("No. " + data.no_laporan);
        if (conf) {
          window.open(APP_URL + "/cetak_permintaan_tch/" + data.id_permintaan, '_blank');
          //window.location.href = APP_URL+"/cetak_permintaan_tch/"+data.id_permintaan;

          /*
             $.ajax({
                   type: "POST",
                   url: APP_URL+"/api/cetak_permintaan_tch",
                   headers: { "token_req": key },
                   data:{"id": data.id_permintaan} ,
                   dataType: "json",
               })
               .done(function(resp) {
               if (resp.success) {
                 alert("Hapus request berhasil");
                 window.location.href = "{{ route('req_permintaan')}}";
               }
               else
               $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
           })
           .fail(function() {
               $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
          
           });
           */
        }

      });


      $('#filtertanggal').click(function () {
        var data = list_permintaan.row($(this).parents('tr')).data();
        var id = $(this).attr('id_permintaan');

        {
          $.ajax({
            url: APP_URL + "/api/cetak_permintaan_tch",
            method: 'POST',
            headers: {
              "token_req": key
            },
            data: {
              id: id
            },
            dataType: "json",
            success: function () {
              alert(data);
              $('#tb_permintaan_kerja').DataTable().ajax.reload();
            }
          })
        }
      });


      $('.check_all').click(function () {
        $('.checkbox').prop('checked', this.checked);
        if ($(this).is(':checked')) {
          $('.check').addClass('removeRow');
        } else {
          $('.check').removeClass('removeRow');
        }
      });

    });
  });
</script>

@endsection