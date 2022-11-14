
@extends('layout.main')
@section('content')

<div class="row">
<form action="/maintenance/schedule" method="post">
@csrf
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="description">Description</label>
      <textarea class="form-control" name="description" id="description" rows="2"></textarea>
    </div>
    <div class="form-group col-md-2">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="no_induk_mesin">No Induk Mesin</label>
            <input type="text" class="form-control" name="no_induk_mesin" id="no_induk_mesin">
        </div>
        <div class="form-group col-md-2">
            <label for="nama_mesin">Nama Mesin</label>
            <input type="text" class="form-control" name="nama_mesin" id="nama_mesin">
        </div>
        <div class="form-group col-md-1">
            <label for="no_mesin">No Mesin</label>
            <input type="text" class="form-control" name="no_mesin" id="no_mesin" placeholder="Input Machine No">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="schedule">Tanggal Rencana Mulai</label>
            <input type="datetime-local" class="form-control" name="tanggal_rencana_mulai" id="tanggal_rencana_mulai">
        </div>
        <div class="form-group col-md-3">
            <label for="schedule">Tanggal Rencana Selesai</label>
            <input type="datetime-local" class="form-control" name="tanggal_rencana_selesai" id="tanggal_rencana_selesai">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-2">
            <label for="operator">Operator</label>
            <input type="text" class="form-control" name="operator" id="operator">
        </div>
        <div class="form-group col-md-2">
            <label for="item_code">Item Code</label>
            <select id="item_code" name="item_code" class="form-control">
                <option selected disabled>Part yang digunakan</option>
                <option>...</option>
            </select>
        </div>
        <div class="form-group col-md-1">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option selected disabled>Pilih Status...</option>
                <option>Open</option>
                <option>Close</option>
                <option>Pending</option>
            </select>
        </div>
        <div class="form-group col-md-1">
            <label for="hasil">Hasil</label>
            <select id="hasil" name="hasil" class="form-control">
                <option selected disabled>Pilih Hasil...</option>
                <option>Ok</option>
                <option>NG</option>
                <option>...</option>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan" rows="2"></textarea>
        </div>
    </div>
  <button type="submit" class="btn btn-primary">Update</button>
  <td><a href="/maintenance/listschedule" class="btn btn-secondary">List-Data</a></td>
</form>
</div>

@endsection