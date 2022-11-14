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

<form action="{{url('/pga/import_absensi')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Upload Data Absensi</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <label for="">File :</label>
                <input type="file" class="form-control" name="import_file" id="import_file">

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <span class="float-right">
                    <a href="{{url('/PDF/Template Upload Absensi.xlsx')}}" class="link-black text-sm" target="_blank">
                        <i class="fa fa-download"></i> Template Excel
                    </a>
                </span>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function () {

    });



</script>

@endsection