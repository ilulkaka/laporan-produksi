@extends('layout.main')
@section('content')

@if(Session::has('alert-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{Session::get('alert-success')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="card">
  <div class="card-header">
    <div class="card card-warning">
      <div class="card-header">
        <div class="row">

          <div class="col-12">
            <h3 class="card-title">List User</h3>
          </div>
        </div>
      </div>
      <div class="card-tools">

      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap" id="tb_user">
        <thead>
          <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Departement</th>
            <th>NIK</th>
            <th>Level User</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="card-footer">

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    var key = localStorage.getItem('npr_token');
    var listuser = $('#tb_user').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/admin/listuser',
        type: "POST",
        headers: {
          "token_req": key
        },
      },
      columnDefs: [{

        targets: [0],
        visible: true,
        searchable: false
      },
      {
        targets: [5],
        data: null,
        defaultContent: "<button class='btn btn-success'><i class='fa fa-edit'></i></button><button class='btn btn-danger'><i class='fa fa-trash'></i></button>"
      }

      ],

      columns: [
        { data: 'id', name: 'id' },
        { data: 'user_name', name: 'user_name' },
        { data: 'departemen', name: 'departemen' },
        { data: 'nik', name: 'nik' },
        { data: 'level_user', name: 'level_user' },
      ],
    });

    $("#tb_user").on('click', '.btn-danger', function () {
      var data = listuser.row($(this).parents('tr')).data();

      var conf = confirm("Apakah User " + data.user_name + " akan dihapus?");
      if (conf) {
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/admin/hapususer",
          headers: {
            "token_req": key
          },
          data: {
            "id": data.id
          },
          dataType: "json",
        })
          .done(function (resp) {
            if (resp.success) {
              alert("Hapus request berhasil");
              window.location.href = "{{ route('list-user')}}";
            } else
              $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
          })
          .fail(function () {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
          });
      }
    });

    $("#tb_user").on('click', '.btn-success', function () {
      var data = listuser.row($(this).parents('tr')).data();
      window.location.href = APP_URL + "/user-edit/edit/" + data.id;
    });

  });
</script>

@endsection