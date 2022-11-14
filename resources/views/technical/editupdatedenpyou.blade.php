@extends('layout.main')
@section('content')

@foreach($ud as $u)
<form action="/technical/input" method="post">
{{csrf_field()}}
  <div class="row">
    <div class="form-group col-md-3">
      <label for="tanggal">Tanggal</label>
      <input value="{{$tanggal}}" class="form-control" name="tanggal" id="tanggal">
    </div>
    <div class="form-group col-md-6">
            <label for="partno">Part No</label>
            <select name="i_item_cd" id="Partno" class="form-control select2 @error('i_item_cd') is-invalid @enderror" style="width: 100%;" required>
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
    <select class="form-control" name="proses" id="proses">
    <option value="">Pilih nama Proses</option>
      @foreach ($koujun as $k)
      <option value="{{$k->Proses}}">{{$k->Proses}}</option>
      @endforeach
    </select>
  </div>
  <div class="form-group col-md-3">
    <label for="jigu">Jigu</label>
    <input type="text" class="form-control" name="jigu" id="jigu" placeholder="Alat">
  </div>
    <div class="form-group col-md-2">
      <label for="ukuransalah">Ukuran Salah</label>
      <input type="text" class="form-control" name="ukuransalah" id="ukuransalah">
    </div>
    <div class="form-group col-md-2">
    <label for="ukuranbenar">Ukuran Benar</label>
      <input type="text" class="form-control" name="ukuranbenar" id="ukuranbenar">
    </div>
    <div class="form-group col-md-2">
      <label for="status">Status</label>
      <select name="status" id="status" class="form-control">
        <option selected>Choose...</option>
        <option>Open</option>
        <option>Close</option>
        <option>Pending</option>
      </select>
    </div>
  </div>
  <div class="row">
  <div class="form-group col-md-5">
      <label for="keterangan">Keterangan</label>
      <input type="text" class="form-control" name="keterangan" id="keterangan">
    </div>
    <div class="form-group col-md-3">
      <label for="modified">Update</label>
      <input value="{{$tanggal}}" class="form-control" name="modified" id="modified">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="/technical/inquery-update" class="btn btn-secondary"> List Update Denpyou</a>
</form>
@endforeach

@endsection