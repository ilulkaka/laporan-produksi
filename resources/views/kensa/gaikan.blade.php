@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <form action="{{url('/kensa/gaikan')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card card-secondary">
                <div class="card-header">
                    <div class="col-12">
                        <h3 class="card-title">Report Gaikan Kensa</h3>
                    </div>
                </div>
                <div class="card-tools">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-1">
                    <label for="nik">NIK</label>
                    <select name="nik" id="nik" class="form-control select2 @error('nik') is-invalid @enderror"
                        style="width: 100%;" required>
                        <option>NIK</option>
                        @foreach($nomerinduk as $i)
                        <option value="{{$i->nama}}">{{$i->nik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="nama">Nama Operator</label>
                    <input type="hidden" name="nonik" id="nonik" value="" required>
                    <input type="text" class="form-control @error('nama')is-invalid @enderror" name="nama" id="nama"
                        value="" placeholder="Nama Operator" required disabled>
                </div>
                <div class="form-group col-md-1">
                    <label for="tempat_kejadian">No</label>
                    <input type="text" class="form-control" name="no_meja" id="no_meja" placeholder="No Meja" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="tgl_kejadian">Tanggal Gaikan</label>
                    <input type="date" class="form-control" value="{{date('Y-m-d')}}" name="gaikan_date"
                        id="gaikan_date" placeholder="Tanggal Kejadian" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="tempat_kejadian">Barcode No</label>
                    <input type="text" class="form-control" name="barcode_no" id="barcode_no" placeholder="Barcode No"
                        required>
                </div>
                <div class="form-group col-md-2">
                    <label for="tempat_kejadian">Finish Qty</label>
                    <input type="number" class="form-control" name="finish_qty" id="finish_qty" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputpart">NG</label>

                    <button type="button" class="btn-xs btn-success" id="btn_parts"><i class="fa fa-plus"></i></button>
                    <table class="table table-bordered" id="tb_use">
                        <thead>
                            <tr>
                                <th style="width: 100px">NG Code</th>
                                <th>NG Type</th>
                                <th style="width: 90px">NG Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>

            <hr>
            <input type="submit" value="simpan" class="btn btn-success btn-flat">
            <!--<td><a href="{{url('/hse/hklist')}}" class="btn btn-secondary btn-flat">List HH/KY</a></td>-->
        </form>
    </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script>
    $(function () {

        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var dept = "{{Session::get('dept')}}";

        $("#nik").change(function () {
            var noinduk = $(this).children("option:selected").html();
            var namaoperator = $(this).children("option:selected").val();
            //    var dept = $(this).children("option:selected").val();
            var per = $("#periode").val();
            $("#nonik").val(noinduk);
            $("#nama").val(namaoperator);
            //    $("#departemen").val(dept);

        });

    });

</script>
@endsection