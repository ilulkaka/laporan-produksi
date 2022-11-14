@extends('layout.main')
@section('content')
<div class="text-center">
  <h3>Total Jam Kerusakan : <b>{{number_format($total_jam[0]->total,1)}}</b> Jam</h3>
</div>
<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{$total_request}}</h3>

        <p>Request Masuk</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <div class="small-box-footer">Total Request</div>

    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{$prosentase}}<sup style="font-size: 20px">%</sup></h3>

        <p>Terselesaikan</p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <div class="small-box-footer">Progress</div>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>{{$total_pending}}</h3>

        <p>Perbaikan Pending</p>
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
        <h3>{{$total_rusak}}</h3>

        <p>Request Open</p>
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
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <h3 class="card-title"><b>List Perbaikan</b></h3>


        </div>
        <div class="row">
          @if(Session('nik') != '000000')
          <div>
            <a href="{{url('/maintenance/input')}}" class="btn btn-success">Input Perbaikan</a>
          </div>
          @else
          @endif

        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap" id="tb_perbaikan">
          <thead>
            <tr>
              <th>id</th>
              <th>No Perbaikan</th>
              <th>Departement</th>
              <th>Shift</th>
              <th>tanggal Rusak</th>
              <th>No Induk Mesin</th>
              <th>Mesin</th>
              <th>Masalah</th>
              <th>Kondisi</th>

            </tr>
          </thead>

        </table>
      </div>


    </div>

  </div>
</div>

@if(Session('nik') != '000000')
<!-- Modal -->
<div class="modal fade" id="perbaikan-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pelaksana Perbaikan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id-req">
        <div class="row">
          <div class="col col-md-3"><label>No. :</label></div>
          <div class="col col-md-4">
            <label id="no-perbaikan"></label>
          </div>
        </div>

        <div class="row">
          <div class="col col-md-3"><label>Departemen :</label></div>
          <div class="col col-md-8">
            <label id="dept"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>No. Mesin :</label></div>
          <div class="col col-md-4">
            <label id="no-mesin"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Nama Mesin :</label></div>
          <div class="col col-md-8">
            <label id="nama-mesin"></label>
          </div>
        </div>
        <div class="row">
          <div class="col col-md-3"><label>Masalah :</label></div>
          <div class="col col-md-8">
            <label id="masalah"></label>
          </div>
        </div>
        <div class="form-row">
          <div class="col col-md-3"><label>Operator :</label></div>
          <div class="col col-md-8"><label id="mtc-operator"></label></div>
        </div>
        <div class="form-row">
          <div class="col col-md-3"><label>Operator :</label></div>
          <div class="col col-md-6">
            <select name="" id="operator" class="form-control">
              <option value="">------Pilih Operator------</option>
              @foreach($operator as $o)
              <option value="{{$o->NIK}}">{{$o->NAMA}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col col-md-3"><label>Klasifikasi :</label></div>
          <div class="col col-md-2">

            <select name="klasifikasi" id="klasifikasi" class="form-control">
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col col-md-10">
            <ul>
              <li>A : Mesin/Alat masih bisa beroperasi dan hanya perbaikan ringan</li>
              <li>B : Mesin/Alat masih bisa beroperasi dan harus dihentikan saat perbaikan</li>
              <li>C : Mesin/Alat tidak bisa beroperasi</li>
              <li>D : Mesin/Alat Stop atau Over Haul dan dikerjakan pada hari libur</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

@section('script')



<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    var key = localStorage.getItem('npr_token');
    var nama_operator;
    var list_perbaikan = $('#tb_perbaikan').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/perbaikan',
        type: "POST",
        headers: { "token_req": key },
      },
      columnDefs: [
        {
          targets: [0],
          visible: false,
          searchable: false
        }
      ],

      columns: [
        { data: 'id_perbaikan', name: 'id_perbaikan' },
        { data: 'no_perbaikan', name: 'no_perbaikan' },
        { data: 'departemen', name: 'departemen' },
        { data: 'shift', name: 'shift' },
        { data: 'tanggal_rusak', name: 'tanggal_rusak' },
        { data: 'no_induk_mesin', name: 'no_induk_mesin' },
        { data: 'nama_mesin', name: 'nama_mesin' },
        { data: 'masalah', name: 'masalah' },
        { data: 'kondisi', name: 'kondisi' },

      ]
    });

    $("#tb_perbaikan").on('click', 'tr', function () {
      var data = list_perbaikan.row(this).data();
      $("#no-perbaikan").html(data.no_perbaikan);
      $("#dept").html(data.departemen);
      $("#no-mesin").html(data.no_induk_mesin);
      $("#nama-mesin").html(data.nama_mesin);
      $("#masalah").html(data.masalah);
      $("#id-req").val(data.id_perbaikan);
      $("#mtc-operator").empty();

      p = [];
      $('#perbaikan-modal').modal("show");

    });
    var p = [];
    $("select#operator").change(function () {


      var t;
      if (p.length === 0) {

        t = $("#operator").val();

        p.push(t);
        nama_operator = $("#operator option:selected").html();
      } else {

        t = $("#operator").val();

        p.push(t);
        nama_operator = nama_operator + ", " + $("#operator option:selected").html();
      }

      $("#mtc-operator").html(nama_operator);

    });

    $("#btn-save").click(function () {


      var id = $("#id-req").val();
      var klas = $("#klasifikasi").val();
      $.ajax({
        type: "POST",
        url: APP_URL + "/api/pelaksana",
        headers: { "token_req": key },
        data: { "operator": p, "no_req": id, "klasifikasi": klas },
        dataType: "json",

        success: function (response) {
          var hasil = response.respon;

          if (hasil == "operatornull") {
            alert("Pilih operator terlebih dahulu !");
          } else {
            window.location = APP_URL + '/maintenance/perbaikan';
          }

        }

      });
    });

  });
</script>
@endsection