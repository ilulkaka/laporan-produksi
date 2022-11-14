@extends('layout.main')
@section('content')


<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{number_format($produksi->target,0)}} Pcs</h3>

        <p>Target Produksi</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer" id="set-produksi">Setting Target <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{number_format($sales->target,0)}} Pcs</h3>

        <p>Target Sales</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="#" class="small-box-footer" id="set-sales">Setting Target Sales <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>44</h3>

        <p>User Registrations</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>65</h3>

        <p>Unique Visitors</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

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

<div class="row">
  <div class="col-md-6">
    <form action="{{url('ppic/input_target_produksi')}}" method="post">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card card-primary">
                <div class="card-header">
                  <div class="col-6">
                    <h3 class="card-title">Setting Target</h3><br>
                  </div>
                </div>
                <div class="card-tools">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="periode">Periode</label>
                  <input type="month" class="form-control" name="periode" id="periode" placeholder="Periode"
                    value="{{date('Y-m')}}" required>
                </div>

                <div class="form-group col-md-3">
                  <label for="codetarget">Jenis</label>
                  <select name="codetarget" id="codetarget" class="form-control" required>
                    <option value="">Choose...</option>
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                  </select>
                </div>

              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="from">Location Cd</label>
                  <select class="form-control departemen" id="location_cd"
                    class="form-control select2 @error('location_cd') is-invalid @enderror"
                    placeholder="Dari Departemen">
                    <option>Location Code</option>
                    @foreach($locationcd as $l)
                    <option value="{{$l->v_name}}">{{$l->v_loc_cd }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-5">
                  <label for="namaproses">Process Name</label>
                  <input type="hidden" id="location_cd_1" name="location_cd_1">
                  <input type="text" class="form-control @error('namaproses') is-invalid @enderror" name="namaproses"
                    id="namaproses">
                </div>
                <div class="form-group col-md-3">
                  <label for="inputmasalah">Qty Target</label>
                  <input type="number" class="form-control @error('qtytarget') is-invalid @enderror" name="qtytarget"
                    id="qtytarget" required>
                </div>
              </div>
            </div>
            <div class="card-header">
              <button type="submit" class="btn btn-primary float-right">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="col-md-6">
    <form action="{{url('ppic/input_target_shikakari')}}" method="post">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <div class="card card-primary">
                <div class="card-header">
                  <div class="col-6">
                    <h3 class="card-title">Setting Shikakari</h3><br>
                  </div>
                </div>
                <div class="card-tools">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="periode">Periode</label>
                  <input type="month" class="form-control" name="periodeshikakari" id="periodeshikakari"
                    placeholder="Periode" value="{{date('Y-m')}}" required>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="from">Location Cd</label>
                  <select class="form-control departemen" id="location_cd_shikakari"
                    class="form-control select2 @error('location_cd') is-invalid @enderror"
                    placeholder="Dari Departemen">
                    <option>Location Code</option>
                    @foreach($locationcd as $l)
                    <option value="{{$l->v_name}}">{{$l->v_loc_cd }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-5">
                  <label for="namaproses">Process Name</label>
                  <input type="hidden" id="location_cd_shikakari_1" name="location_cd_shikakari_1">
                  <input type="text" class="form-control @error('namaproses') is-invalid @enderror"
                    name="namaproses_shikakari" id="namaproses_shikakari">
                </div>
                <div class="form-group col-md-3">
                  <label for="inputmasalah">Qty Target</label>
                  <input type="number" class="form-control @error('qtytarget') is-invalid @enderror"
                    name="qtytarget_shikakari" id="qtytarget_shikakari" required>
                </div>
              </div>
            </div>
            <div class="card-header">
              <button type="submit" class="btn btn-primary float-right">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Produksi -->
<div class="modal fade" id="setModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="periode">Periode</label>
            </div>
            <div class="form-group col-md-6">
              <input type="month" class="form-control" name="periodeproduksi" id="periodeproduksi"
                value="{{date('Y-m')}}" required>
            </div>
            <div class="form-group col-md-3">
              <label>(Month year)</label>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="target">Target</label>
            </div>
            <div class="form-group col-md-6">
              <input type="number" class="form-control" name="target" id="target" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Sales -->
<div class="modal fade" id="setModalsales" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalTitlesales">SET SALES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="periode">Periode</label>
            </div>
            <div class="form-group col-md-6">
              <input type="month" class="form-control" name="periodesales" id="periodesales" value="{{date('Y-m')}}"
                required>
            </div>
            <div class="form-group col-md-3">
              <label>(Month year)</label>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="target">Target</label>
            </div>
            <div class="form-group col-md-6">
              <input type="number" class="form-control" name="targetsales" id="targetsales" required>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-savesales">Save changes</button>
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
  $(function () {

    $('.select2').select2({
      theme: 'bootstrap4'
    })
  });
</script>

<script type="text/javascript">
  $(document).ready(function () {

    $("#location_cd").change(function () {
      var cd = $(this).children("option:selected").html();
      var namaproses = $(this).children("option:selected").val();
      $("#location_cd_1").val(cd);
      $("#namaproses").val(namaproses);
    });

    $("#location_cd_shikakari").change(function () {
      var cdshikakari = $(this).children("option:selected").html();
      var namaprosesshikakari = $(this).children("option:selected").val();
      $("#location_cd_shikakari_1").val(cdshikakari);
      $("#namaproses_shikakari").val(namaprosesshikakari);
    });

    $('#set-produksi').click(function (event) {
      event.preventDefault();
      $('#ModalTitle').html('Produksi');
      $('#setModal').modal('show');
    });

    $('#set-sales').click(function (event) {
      event.preventDefault();
      $('#ModalTitlesales').html('Sales');
      $('#setModalsales').modal('show');
    });

    $("#btn-save").click(function () {
      var target = $("#target").val();
      var periode = $("#periodeproduksi").val();
      var setting = $("#ModalTitle").html();

      $.ajax({
        type: "POST",
        url: APP_URL + "/api/set_target",
        data: { "set": setting, "periode": periode, "target": target },
        dataType: "json",
      })

        .done(function (resp) {
          if (resp.success) {
            alert("Update target success .");
            //window.location.href = "{{ route('req_permintaan_tch')}}";
            location.reload();
          } else
            alert(resp.message);

        })
        .fail(function () {
          $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

        });
    });

    $("#btn-savesales").click(function () {
      var targetsales = $("#targetsales").val();
      var periodesales = $("#periodesales").val();
      var settingsales = $("#ModalTitlesales").html();

      $.ajax({
        type: "POST",
        url: APP_URL + "/api/set_targetsales",
        data: { "setsales": settingsales, "periodesales": periodesales, "targetsales": targetsales },
        dataType: "json",
      })

        .done(function (resp) {
          if (resp.success) {
            alert("Update target success .");
            //window.location.href = "{{ route('req_permintaan_tch')}}";
            location.reload();
          } else
            alert(resp.message);

        })
        .fail(function () {
          $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

        });
    });

  });

</script>
@endsection