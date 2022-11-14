@extends('layout.main')
@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-12">
            <h3 class="card-title">Responsive Hover Table</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <!-- <a href="{{url('/technical/update')}}" class="btn btn-success">Input Update Denpyou</a> -->
            <button type="button" class="btn btn-primary" id="btn-excel">Excel</button>
          </div>
        </div>
        <div class="card-tools">
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap" id="tb_update">
          <thead>
            <tr>
              <th>id</th>
              <th>Tanggal</th>
              <th>Part No</th>
              <th>Jby</th>
              <th>Proses</th>
              <th>Jigu</th>
              <th>Ukuran Salah</th>
              <th>Ukuran Benar</th>
              <th>Status</th>
              <th>Keterangan</th>
              <th>Update</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Update Denpyou</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id-update">
        <div class="row">
          <div class="col col-md-3"><label>No.</label></div>
          <label>:</label>
          <div class="col col-md-4">
            <label id="id"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Part No</label></div>
          <label>:</label>
          <div class="col col-md-8">
            <label id="edit-partno"></label>
          </div>
        </div>

        <div class="row">
          <div class="col col-md-3"><label>Jigu</label></div>
          <label>:</label>
          <div class="col col-md-8">
            <label id="edit-jigu"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Ukuran Salah</label></div>
          <label>:</label>
          <div class="col col-md-4">
            <input type="text" id="edit-ukuransalah"></input>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Ukuran Benar</label></div>
          <label>:</label>
          <div class="col col-md-8">
            <input type="text" id="edit-ukuranbenar"></input>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Status</label></div>
          <label>:</label>
          <div class="col col-md-8">
            <select name="edit-status" id="edit-status" class="form-control" required>
              <option value="Open">Open</option>
              <option value="Close">Close</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Keterangan</label></div>
          <label>:</label>
          <div class="col col-md-8"><label id="edit-keterangan"></label></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
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
      var list_update = $('#tb_update').DataTable({
        processing: true,
        serverSide: true,
        searching: true,

        ajax: {
          url: APP_URL + '/api/updatedenpyou',
          type: "POST"
        },

        columnDefs: [
          {
            targets: [11],
            data: null,
            //defaultContent: "<button class='btn btn-success'>Complited</button>"
            render: function (data, type, row, meta) {
              if (data.status == "Close" || data.status == "Tolak") {
                return "";
              } else {
                return "<button class='btn btn-success'><i class='fa fa-edit'></i></button>";

              }
            }
          }
        ],

        columns: [
          { data: 'id_update', name: 'id_update' },
          { data: 'tanggal', name: 'tanggal' },
          { data: 'part_no', name: 'part_no' },
          { data: 'jby', name: 'jby' },
          { data: 'proses', name: 'proses' },
          { data: 'jigu', name: 'jigu' },
          { data: 'ukuran_salah', name: 'ukuran_salah' },
          { data: 'ukuran_benar', name: 'ukuran_benar' },
          { data: 'status', name: 'status' },
          { data: 'keterangan', name: 'keterangan' },
          { data: 'modified', name: 'modified' },
        ]
      });

      $('#tb_update').on('click', '.btn-success', function () {
        var data = list_update.row($(this).parents('tr')).data();
        $("#id-update").val(data.id_update);
        $("#id").html(data.id_update);
        $("#edit-partno").html(data.part_no);
        $("#edit-jigu").html(data.jigu);
        $("#edit-ukuransalah").val(data.ukuran_salah);
        $("#edit-ukuranbenar").val(data.ukuran_benar);
        $('#edit-status option[value=' + data.status + ']').attr('selected', 'selected');
        $("#edit-keterangan").html(data.keterangan);
        $('#update-modal').modal('show');
      });

      $("#btn-save").click(function () {
        var key = localStorage.getItem('npr_token');
        var ukuran_salah = $("#edit-ukuransalah").val();
        var ukuran_benar = $("#edit-ukuranbenar").val();
        var status = $("#edit-status").val();
        var id_update = $("#id-update").val();
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/edit_update_denpyou",
          headers: {
            "token_req": key
          },
          data: {
            "id": id_update,
            "ukuran_salah": ukuran_salah,
            "ukuran_benar": ukuran_benar,
            "status": status
          },
          dataType: "json",
        })
          .done(function (resp) {
            if (resp.success) {
              alert("Update request berhasil");
              window.location.href = "{{ route('req_update_denpyou')}}";
            } else
              $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
          })
          .fail(function () {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

          });
      });

      $("#btn-excel").click(function () {
        var key = localStorage.getItem('npr_token');
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/updatedenpyou/get_excel",
          headers: { "token_req": key },
          dataType: "json",

          success: function (response) {
            var fpath = response.file;
            window.open(fpath, '_blank');

          }

        });
      });

    });


  </script>

  @endsection