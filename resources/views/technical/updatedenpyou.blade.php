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

<div class="card">
  <div class="card-header">

    <form action="{{url('/technical/input')}}" method="post">
      {{csrf_field()}}
      <div class="row">
        <div class="form-group col-md-3">
          <label for="tanggal">Tanggal</label>
          <input value="{{$tanggal}}" class="form-control" name="tanggal" id="tanggal">
        </div>
        <div class="form-group col-md-4">
          <label for="partno">Part No</label>
          <select name="i_item_cd" id="Partno" class="form-control select2 @error('i_item_cd') is-invalid @enderror"
            style="width: 100%;" required>
            <option value="">Pilih Part No</option>
            @foreach($partno as $i)
            <option value="{{$i->i_item_cd}}">{{$i->i_item_cd}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-1">
          <label for="jby">Jby</label>
          <input type="text" class="form-control" name="jby" id="jby">
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-3">
          <label for="proses">Proses</label>
          <select class="form-control" name="proses" id="proses" required>
            <option value="">Pilih nama Proses</option>
            @foreach ($koujun as $k)
            <option value="{{$k->Proses}}">{{$k->Proses}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="jigu">Jigu</label>
          <input type="text" class="form-control" name="jigu" id="jigu" placeholder="Alat" required>
        </div>
        <div class="form-group col-md-2">
          <label for="ukuransalah">Ukuran Salah</label>
          <input type="text" class="form-control" name="ukuransalah" id="ukuransalah">
        </div>
        <div class="form-group col-md-2">
          <label for="ukuranbenar">Ukuran Benar</label>
          <input type="text" class="form-control" name="ukuranbenar" id="ukuranbenar" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-2">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control" required>
            <option>Open</option>
            <option>Close</option>
            <option>Pending</option>
          </select>
        </div>
        <div class="form-group col-md-5">
          <label for="keterangan">Keterangan</label>
          <input type="text" class="form-control" name="keterangan" id="keterangan">
        </div>
        <div class="form-group col-md-3">
          <label for="modified">Update</label>
          <input value="{{$tanggal}}" class="form-control" name="modified" id="modified" disabled>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="{{url('/technical/inquery-update')}}" class="btn btn-secondary"> List Update Denpyou</a>
      <a href="{{url('/ppic/f_master')}}" class="btn btn-success"> Master PPIC</a>
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


  });
</script>

@endsection