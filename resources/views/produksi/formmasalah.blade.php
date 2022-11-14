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

<div class="card">
  <div class="card-header">
    <form action="{{url('/produksi/inputmasalah')}}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="card card-secondary">
        <div class="card-header">
          <div class="col-12">
            <h3 class="card-title">Kartu Berbagi Informasi Permasalahan</h3>
          </div>
        </div>
        <div class="card-tools">
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-2">
          <label for="no_kartu">No Kartu</label>
          <input type="text" value="" class="form-control" name="no_kartu_1" id="no_kartu_1" disabled>
          <input type="hidden" value="" class="form-control" name="no_kartu" id="no_kartu">
        </div>
        <div class="form-group col-md-3">
          <label for="klasifikasi">Klasifikasi</label>
          <select name="klasifikasi" id="klasifikasi" class="form-control">
            <option selected>Choose...</option>
            <option value="NG">NG</option>
            <option value="Qualitas">Qualitas</option>
            <option value="Mesin_Rusak">Mesin Rusak</option>
            <option value="Barang_Habis">Barang Habis</option>
            <option value="Safety">Safety</option>
            <option value="Lain-lain">Lain - Lain</option>
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="tanggal_ditemukan">Tanggal Ditemukan</label>
          <input type="date" class="form-control" name="tanggal_ditemukan" id="tanggal_ditemukan"
            placeholder="Tanggal ditemukan" required>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-2">
          <label for="lokasi">Lokasi</label>
          <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Dimana (Tempat Proses)">
        </div>
        <div class="form-group col-md-4">
          <label for="masalah">Masalah</label>
          <textarea class="form-control" name="masalah" id="masalah" cols="30" rows="4"
            placeholder="Apa Masalahnya (Tulis dengan ringkas)" required></textarea>
        </div>
        <div class="form-group col-md-4">
          <label for="penyebab">Penyebab</label>
          <textarea class="form-control" name="penyebab" id="penyebab" cols="30" rows="4"
            placeholder="Penyebab / Faktor yang dapat diperkirakan"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-4">
          <label for="penyebab">Lampiran Gambar</label>
          <input type="file" class="form-control" id="lampiran" name="lampiran">


        </div>
      </div>

      <input type="submit" value="simpan" class="btn btn-primary">
    </form>
  </div>
</div>
<div class="card card-success">
  <div class="card-header">
    <div class="row">

      <h3 class="card-title">Grafik Permasalahan <i id="periode"></i></h3>
    </div>

    <div class="row align-center">
      <input type="date" class="form-control col-md-2" id="tgl1" value="{{date('Y-m').'-01'}}">
      <label for="" class="col-md-2 text-center">Sampai</label>
      <input type="date" class="form-control col-md-2" id="tgl2" value="{{date('Y-m-d')}}">
      <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div>
      <canvas id="barChart"></canvas>
    </div>
  </div>
  <!-- /.card-body -->
</div>



<p>

<div class="card">
  <div class="card-header">
    <div class="card card-warning">
      <div class="card-header">
        <div class="row">

          <div class="col-12">
            <h3 class="card-title">List Masalah</h3>
          </div>
        </div>
        <div class="row align-center">



          <div class="row text-center">

            <input type="date" class="form-control col-md-4" id="tgl_awal" value="{{date('Y-m').'-01'}}">
            <label for="" class="col-md-2 text-center">Sampai</label>
            <input type="date" class="form-control col-md-4" id="tgl_akhir" value="{{date('Y-m-d')}}">
            <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>

          </div>


        </div>
      </div>
      <div class="card-tools">

      </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
      <table class="table table-hover text-nowrap" id="tb_masalah">
        <thead>
          <tr>
            <th>id</th>
            <th>Tanggal ditemukan</th>
            <th>Informer</th>
            <th>No Kartu</th>
            <th>Klasifikasi</th>
            <th>Lokasi</th>
            <th>Masalah</th>
            <th>Progres</th>
            <th>Lampiran</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="card-footer">

      <button class="btn btn-success" id="btn-excel">Download Excel</button>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>

</p>

<!-- Modal -->

<div class="modal fade" id="modal-img" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="img-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" alt="" id="img-lampiran" class="img-fluid" style="width:100%">
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    var key = localStorage.getItem('npr_token');

    var ctx = document.getElementById('barChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {},
      options: {}
    });
    var date1 = $("#tgl1").val();
    var date2 = $("#tgl2").val();

    tampil_chart(key, date1, date2, chart)

    function tampil_chart(key, awal, akhir, chart) {

      $.ajax({
        url: APP_URL + "/api/grafikmasalah",
        method: "POST",
        data: { "tgl_awal": awal, "tgl_akhir": akhir },
        dataType: "json",
        headers: { "token_req": key },
        success: function (data) {

          var label = [];
          var value = [];
          var value2 = [];



          for (var i in data) {
            label.push(data[i].klasifikasi);
            value.push(data[i].jumlah);
            value2.push(data[i].closed);
          }


          chart.data = {
            labels: label,
            datasets: [
              {
                label: 'Total Close',
                backgroundColor: 'rgb(51, 153, 255)',
                borderColor: 'rgb(51, 153, 255)',
                data: value2
              },
              {
                label: 'Total Permasalahan',
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: value
              }

            ]
          };
          chart.options = {
            tooltips: {
              callbacks: {
                title: function (tooltipItem, data) {
                  return data['labels'][tooltipItem[0]['index']];
                },
                label: function (tooltipItem, data) {
                  if (tooltipItem.datasetIndex > 0) {

                    return data['datasets'][tooltipItem.datasetIndex]['data'][tooltipItem['index']] + " Kasus";
                  } else {
                    return data['datasets'][tooltipItem.datasetIndex]['data'][tooltipItem['index']] + " Close";
                  }
                  //return tooltipItem.datasetIndex;
                }

              },
              backgroundColor: '#FFF',
              titleFontSize: 16,
              titleFontColor: '#0066ff',
              bodyFontColor: '#000',
              bodyFontSize: 14,
              displayColors: false
            },
            scales: {
              yAxes: [{
                ticks: {
                  stepSize: 1,
                  suggestedMax: 5,
                  suggestedMin: 0,
                  callback: function (value, index, values) {
                    return value;
                  }

                }
              }]
            },

            onClick: function (c, i) {
              e = i[0];

              var x_value = this.data.labels[e._index];
              var y_value = this.data.datasets[0].data[e._index];

              //get_details(x_value,awal, akhir, key);

            }

          };
          chart.update();
        }
      });
    }

    $("#btn_refresh").click(function () {
      var date1 = $("#tgl1").val();
      var date2 = $("#tgl2").val();
      tampil_chart(key, date1, date2, chart);
    });

    var list_masalah = $('#tb_masalah').DataTable({
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/inquerymasalah',
        type: "POST",
        headers: { "token_req": key },
        data: function (d) {
          d.tgl_awal = $("#tgl_awal").val();
          d.tgl_akhir = $("#tgl_akhir").val();
        }
      },

      columnDefs: [
        {
          targets: [0],
          visible: false,
          searchable: false
        },
        {
          targets: [8],
          defaultContent: "e",
          render: function (data, type, row, meta) {
            if (!data) {
              return "";
            } else {

              return '<div class="product-image-thumb active"><a href="#" class="img-lampiran"><img src="{{url("storage/img/masalah/")}}/' + data + '" alt=""></a></div>';
            }
          }

        },
        {
          targets: [10],
          data: null,
          defaultContent: "f",
          render: function (data, type, row, meta) {

            return "<button class='btn btn-primary'><i class='fas fa-question'></i></button>";

          }
        },
        {
          targets: [7],
          render: function (data, type, row, meat) {
            return "<div class='progress mb-3'><div class='progress-bar bg-success' role='progressbar' aria-valuenow='" + data + "' aria-valuemin='0' aria-valuemax='100' style='width: " + data + "%'><span style='padding:5px'> " + parseFloat(data).toFixed(2) + "% Complete</span></div></div>"
          }
        }



      ],

      columns: [
        { data: 'id_masalah', name: 'id_masalah' },
        { data: 'tanggal_ditemukan', name: 'tanggal_ditemukan' },
        { data: 'user_name', name: 'user_name' },
        { data: 'no_kartu', name: 'no_kartu' },
        { data: 'klasifikasi', name: 'klasifikasi' },
        { data: 'lokasi', name: 'lokasi' },
        { data: 'masalah', name: 'masalah' },
        { data: 'progress', name: 'progress' },
        { data: 'lampiran', name: 'lampiran' },
        { data: 'status_masalah', name: 'status_masalah' },
      ]
    });

    $("#btn_reload").click(function () {
      var date1 = $("#tgl_awal").val();
      var date2 = $("#tgl_akhir").val();
      list_masalah.ajax.reload();
    });

    $("#tanggal_ditemukan").change(function () {
      //alert('test');
      var tgl = new Date(this.value);
      var tahun = tgl.getFullYear();
      var bulan = ("0" + (tgl.getMonth() + 1)).slice(-2);
      var tanggal = ("0" + tgl.getDate()).slice(-2);
      $.ajax({
        type: "POST",
        url: APP_URL + "/api/nomer_masalah",
        headers: { "token_req": key },
        data: { "tgl": tahun + '-' + bulan + '-' + tanggal },
        dataType: "json",


        success: function (response) {
          var nomer = response[0].no_kartu;
          $("#no_kartu").val(nomer);
          $("#no_kartu_1").val(nomer);

        }
      });
    });



    $("#tb_masalah").on('click', '.btn-primary', function () {
      var data = list_masalah.row($(this).parents('tr')).data();

      window.location.href = APP_URL + "/produksi/masalah/" + data.id_masalah;

    });


    $("#tb_masalah").on('click', '.img-lampiran', function (e) {
      e.preventDefault();
      var data = list_masalah.row($(this).parents('tr')).data();
      $("#img-title").html(data.no_kartu);
      $("#img-lampiran").attr("src", '\{{url("storage/img/masalah/")}}/' + data.lampiran);
      $("#modal-img").modal("show");
    });

    $("#btn-excel").click(function () {

      var tgl_awal = $('#tgl_awal').val();
      var tgl_akhir = $('#tgl_akhir').val();

      var c = confirm("Apakah anda akan download list periode " + tgl_awal + " - " + tgl_akhir + " ?");
      if (c) {
        $.ajax({
          type: "POST",
          url: APP_URL + "/api/masalah/get_excel",
          headers: { "token_req": key },
          data: { "tanggal_awal": tgl_awal, "tanggal_akhir": tgl_akhir },
          dataType: "json",

          success: function (response) {
            var fpath = response.file;
            window.open(fpath, '_blank');

          }

        });

      }
    });
  });


</script>
@endsection