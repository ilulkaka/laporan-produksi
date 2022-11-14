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
        <h3>Daftar Log</h3>
        <div class="row text-center">

            <input type="date" class="form-control col-md-4" id="tgl_awal" value="{{date('Y-m').'-01'}}">
            <label for="" class="col-md-2 text-center">Sampai</label>
            <input type="date" class="form-control col-md-4" id="tgl_akhir" value="{{date('Y-m-d')}}">
            <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>

        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap" id="tb_log">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Tanggal</th>
                    <th>User</th>
                    <th>Aktifitas</th>
                    <th>Pesan</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection
@section('script')
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script>
    $(document).ready(function(){
        var key = localStorage.getItem('npr_token');
        var logs = $('#tb_log').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/admin/listlog',
        type: "POST",
        headers: {
          "token_req": key
        },
        data: function(d){
                            d.tgl_awal = $("#tgl_awal").val();
                            d.tgl_akhir = $("#tgl_akhir").val();
                        }
      },
      columnDefs: [{

        targets: [0],
        visible: false,
        
      },

      ],

      columns: [
        { data: 'record_no', name: 'record_no' },
        { data: 'created_at', name: 'created_at' },
        { data: 'user_name', name: 'user_name' },
        { data: 'activity', name: 'activity' },
        { data: 'message', name: 'message' },
        
      ],
    });
    $("#btn_reload").click(function(){
    var date1 = $("#tgl_awal").val();
    var date2 = $("#tgl_akhir").val();
    logs.ajax.reload();
    });
});
</script>
@endsection