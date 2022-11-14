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
  <div class="card-header ui-sortable-handle" style="cursor: move;">
    <h3 class="card-title">
      <i class="fas fa-user"></i>
      New User Register
    </h3>
  </div><!-- /.card-header -->
  <div class="card-body">
    <div class="tab-content p-0">
      <!-- Morris chart - Sales -->
      <form action="{{url('/postregister')}}" method="post">
        @csrf
        <div class="form-group col-md-4">
          <label for="nama_user">Nama</label>
          <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Nama User" required>
        </div>
        <div class="form-group col-md-4">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group col-md-2">
          <label for="nik">NIK</label>
          <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomer Induk Karyawan" required>
        </div>
        <div class="form-group col-md-4">
          <label for="departemen">Departemen</label>
          <select class="form-control" id="departemen" name="departemen">
            <option value="">----pilih departemen----</option>
            @foreach($departemen as $k)
            <option>{{$k->DEPT_SECTION}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-md-4">
          <label for="line_process">Line</label>
          <select class="form-control" id="line_process" name="line_process">
            <option value="">----pilih line----</option>
            @foreach($line as $y)
            <option value="{{$y->id_line}}">{{$y->nama_line}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group col-md-4">
          <label for="level_user">Level</label>
          <select class="form-control" id="level_user" name="level_user">
            <option>----pilih level----</option>
            @foreach($level as $t)
            <option value="{{$t->NAMA_JABATAN}}">{{$t->NAMA_JABATAN}}</option>
            @endforeach
          </select>
        </div>
        <input type="submit" value="Simpan" class="btn btn-primary">

      </form>
    </div>
  </div><!-- /.card-body -->
</div>




@endsection

@section('script')


@endsection