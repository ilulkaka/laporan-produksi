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
    <div class="card col-md-6">
        <div class="card-header">
            <h3>Data Permintaan Kerja</h3>

        </div>
        <div class="card-body">
            <form action="{{url('/technical/importexcel')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">File :</label>
                <input type="file" class="form-control" name="import_file" id="import_file">
                <input type="submit" value="Import">

            </form>
        </div>
    </div>
    <div class="card col-md-6">
        <div class="card-header">
            <h3>Data Mesin</h3>

        </div>
        <div class="card-body">
            <form action="{{url('/maintenance/importmesin')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">File :</label>
                <input type="file" class="form-control" name="list_mesin" id="list_mesin">
                <input type="submit" value="Upload">
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="card col-md-6">
        <div class="card-header">
            <h3>File : Upload SS</h3>
        </div>
        <div class="card-body">

            <form action="{{url('/ss/importexcelss')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">File :</label>
                <input type="file" class="form-control" name="import_file_ss" id="import_file_ss">
                <input type="submit" value="Import SS">
            </form>
        </div>
    </div>
    <div class="card col-md-6">
        <div class="card-header">
            <h3>File : Upload HH / KY</h3>
        </div>
        <div class="card-body">

            <form action="{{url('/hh/importexcelhh')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="">File :</label>
                <input type="file" class="form-control" name="import_file_hh" id="import_file_hh">
                <input type="submit" value="Import HH">
            </form>
        </div>

    </div>
</div>

<div class="row">
    <div class="card col-md-6">
        <div class="card-header">
            <h3>Hapus temporary excel file</h3>

        </div>
        <div class="card-body">
            <form action="{{url('/admin/deletefile')}}" method="POST">
                @csrf
                <label for="">Delete Temporary excel file :</label>

                <input class="btn btn-danger" type="submit" value="Delete All">


            </form>
            <div class="col col-sm-12">
                <div class="form-group">
                    <label>List file</label>
                    <select multiple="" class="form-control">
                        @foreach ($list_file as $item)

                        <option>{{$item}}</option>
                        @endforeach

                    </select>
                </div>
                <label>Total {{$total}} file</label>
            </div>
        </div>
    </div>

    <div class="card col-md-6">
        <div class="card-header">
            <h3>Encrypt</h3>

        </div>
        <div class="card-body">
            <div class="col col-sm-12">
                <div class="row">
                    <div class="form-group">
                        <label>Text</label>
                        <input type="text" class="form-control" id="enc" name="enc">
                    </div>
                    <button type="button" class="btn btn-primary btn-flat btn-sm float-right" id="btn_enc"
                        name="btn_enc">Encrypt</button>
                    <textarea name="hasile" id="hasile" class="form-control" cols="30" rows="4"></textarea>
                </div>
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

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');

        $("#btn_enc").click(function () {
            var enc = $("#enc").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/get_encrypt",
                headers: { "token_req": key },
                data: { "enc": enc },
                dataType: "json",


                success: function (response) {
                    $("#hasile").val(response.enc);
                }
            });
        });
    });

</script>
@endsection