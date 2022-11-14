@extends('layout.main')
@section('content')

<form action="/technical/inputpermintaan" method="post">
  @csrf
  <div class="row">
    <div class="form-group col-md-3">
      <label for="tujuan">Tujuan</label>
      <select name="tujuan" id="tujuan" class="form-control">
        <option selected>Choose...</option>
        <option>TECH</option>
        <option>QA</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="tanggal_permintaan">Tanggal Permintaan</label>
      <input type="date" class="form-control" name="tanggal_permintaan" id="tanggal_permintaan">
    </div>
    <div class="form-group col-md-3">
      <label for="no_laporan">No Laporan</label>
      <input type="text" class="form-control" name="no_laporan" id="no_laporan">
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-3">
      <label for="permintaan">Permintaan</label>
      <select name="permintaan" id="permintaan" class="form-control">
        <option selected>Choose...</option>
        <option>REPAIR</option>
        <option>PEMBUATAN GAMBAR</option>
        <option>PEMBUATAN JIGU / SPARE PART</option>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="nama_mesin">Nama Mesin</label>
      <input type="text" class="form-control" name="nama_mesin" id="nama_mesin" placeholder="Nama Mesin">
    </div>
    <div class="form-group col-md-2">
      <label for="Jenis_item">Jenis Item</label>
      <select name="satuan" id="Jenis_item" class="form-control">
        <option selected>Choose...</option>
        <option>Jigu</option>
        <option>Spare Part</option>
        <option>Gambar</option>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="nama_item">Nama item</label>
      <input type="text" class="form-control" name="nama_item" id="nama_item">
    </div>
    <div class="form-group col-md-2">
      <label for="material">Material</label>
      <input type="text" class="form-control" name="material" id="material">
    </div>
    <div class="form-group col-md-2">
      <label for="ukuran">Ukuran</label>
      <input type="text" class="form-control" name="ukuran" id="ukuran">
    </div>
    <div class="form-group col-md-1">
      <label for="qty">Qty</label>
      <input type="text" class="form-control" name="qty" id="qty">
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
    <div class="form-group col-md-4">
      <label for="alasan">Alasan</label>
      <input type="text" class="form-control" name="alasan" id="alasan">
    </div>
    <div class="form-group col-md-3">
      <label for="permintaan_perbaikan">Permintaan Perbaikan</label>
      <input type="text" class="form-control" name="permintaan_perbaikan" id="permintaan_perbaikan">
    </div>
    <div class="form-group col-md-2">
      <label for="accept_by">Accept By</label>
      <input type="text" class="form-control" name="accept_by" id="accept_by">
    </div>
    <div class="form-group col-md-2">
      <label for="status">Status</label>
      <select name="status" id="status" class="form-control">
        <option selected>Choose...</option>
        <option>Tolak</option>
        <option>Proses</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-4">
      <label for="tindakan_perbaikan">Tindakan Perbaikan</label>
      <input type="text" class="form-control" name="tindakan_perbaikan" id="tindakan_perbaikan"
        placeholder="Tindakan perbaikan diisi oleh dept tech">
    </div>
    <div class="form-group col-md-2">
      <label for="operator_tch">Operator Tch</label>
      <input type="text" class="form-control" name="operator_tch" id="operator_tch">
    </div>
    <div class="form-group col-md-3">
      <label for="tanggal_selesai">tanggal_selesai</label>
      <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
    </div>
  </div>
  <input type="submit" value="simpan" class="btn btn-primary">
  <a href="/technical/inquery-permintaan" class="btn btn-secondary"> List Permintaan Perbaikan</a>
</form>

@endsection