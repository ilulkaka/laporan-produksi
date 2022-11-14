@extends('layout.main')
@section('content')

@foreach($tb_user as $p)
<form action="{{url('/user-edit/update')}}" method="post">
	@csrf
	<div class="card card-secondary">
		<div class="card-header">
			<div class="card card-info">
				<div class="card-header">
					<div class="row">

						<div class="col-12">
							<h3 class="card-title">Edit User</h3>
						</div>
					</div>
				</div>
				<div class="card-tools">

				</div>
			</div>
			<!--

		-->
			<div class="form-row">
				<div class="form-group col-md-4">
					<input type="hidden" value="{{$p->id}}" name="id">
				</div>
			</div>

			<div class="form-group row">
				<label for="user_name" class="col-sm-2 col-form-label">User Name</label>
				<div class="col-sm-5">
					<input type="text" required="required" name="user_name" class="form-control"
						value="{{ $p->user_name }}" placeholder="User Name">
					<input type="hidden" value="{{$p->id}}" name="id">
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-5">
					<input type="password" required="required" name="password" value="{{ $p->password}}"
						class="form-control" placeholder="Masukkan password baru.">
				</div>
			</div>
			<div class="form-group row">
				<label for="departemen" class="col-sm-2 col-form-label">Departemen</label>
				<div class="col-sm-4">
					<select value="{{ $p->departemen }}" class="form-control" id="departemen" name="departemen">
						<option value="{{ $p->departemen }}">{{ $p->departemen }}</option>
						@foreach($departemen as $k)
						<option>{{$k->DEPT_SECTION}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="line_process" class="col-sm-2 col-form-label">Line Process</label>
				<div class="col-sm-2">
					<input type="text" required="required" name="line_process" class="form-control"
						value="{{ $p->line_process }}" placeholder="line_process">
					<input type="hidden" value="{{$p->id}}" name="id">
				</div>
			</div>
			<!-- <div class="form-group row">
				<label for="level_user" class="col-sm-2 col-form-label">Level User</label>
				<div class="col-sm-5">
					<input type="text" required="required" name="level_user" readonly class="form-control"
						value="{{ $p->level_user }}" placeholder="level_user">
					<input type="hidden" value="{{$p->id}}" name="id">
				</div>
			</div> -->

			<div class="form-group row">
				<label for="level_user" class="col-sm-2 col-form-label">Level</label>
				<div class="col-sm-3">
					<select class="form-control" id="level_user" name="level_user">
						<option>{{ $p->level_user }}</option>
						@foreach($level as $t)
						<option>{{$t->NAMA_JABATAN}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="" class="col-sm-2 col-form-label"></label>
				<div class="col-sm-5">
					<input type="submit" class="btn btn-success" value="Simpan Data">
				</div>
			</div>
		</div>
	</div>
</form>
@endforeach

@endsection