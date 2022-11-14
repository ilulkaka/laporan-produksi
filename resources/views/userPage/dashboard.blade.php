@extends('layout.main')
@section('content')


<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{number_format($acp9909->qty,0)}} Pcs</h3>

        <p>Produksi</p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="{{url('produksi/report')}}" class="small-box-footer">More info <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{number_format($salespcs->qty,0)}} Pcs</h3>

        <p>Sales</p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="{{url('produksi/report')}}" class="small-box-footer">More info <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <!-- <h3>Detail</h3> -->
        <h3 id="success-rate"></h3>

        <p>Success Rate</p>
      </div>
      <div class="icon">
        <i class="fas fa-percent"></i>
      </div>
      <a href="{{url('produksi/NGreport')}}" class="small-box-footer">More info <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{number_format($lembur->lembur,2)}} Jam</h3>

        <p>Total Jam Lembur</p>
      </div>
      <div class="icon">
        <i class="fas fa-clock"></i>
      </div>
      <a href="{{url('produksi/lembur')}}" class="small-box-footer">More info <i
          class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

<div class="row">
  <div class="col-md-12">
    <div class="card card-secondary">
      <div class="card-header">
        <h5 class="card-title">Annual Recap</h5>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <div class="btn-group">
            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
              <i class="fas fa-wrench"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" role="menu">
              <a href="#" class="dropdown-item">Action</a>
              <a href="#" class="dropdown-item">Another action</a>
              <a href="#" class="dropdown-item">Something else here</a>
              <a class="dropdown-divider"></a>
              <a href="#" class="dropdown-item">Separated link</a>
            </div>
          </div>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p class="text-center">
              <strong>Level of risk, {{$tahun}}</strong>
              <input type="hidden" id="tahun" name="tahun" value="{{$tahun}}">
            </p>

            <div class="col col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                      <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                      <div class=""></div>
                    </div>
                  </div>
                  <canvas id="chartpie"
                    style="min-height: 250px; height: 250px; max-height: 950px; max-width: 100%; display: block; width: 950px;"
                    width="950" height="650" class="chartjs-render-monitor"></canvas>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="card-footer">
              @foreach ($dhh as $h)
              <div class="row">
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                    <h5 class="description-header">{{$h->masuk}}</h5>
                    <span class="description-text">Hiyarihatto IN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                    <h5 class="description-header">{{$h->Close1}}</h5>
                    <span class="description-text">Hiyarihatto Close</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                @endforeach
                @foreach ($dky as $k)
                <div class="col-sm-3 col-6">
                  <div class="description-block border-right">
                    <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 0%</span>
                    <h5 class="description-header">{{$k->masuk}}</h5>
                    <span class="description-text">Kiken Yochi IN</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-3 col-6">
                  <div class="description-block">
                    <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 0%</span>
                    <h5 class="description-header">{{$k->Close1}}</h5>
                    <span class="description-text">Kiken Yochi Close</span>
                  </div>
                  <!-- /.description-block -->
                </div>
              </div>
              @endforeach
              <!-- /.row -->
            </div>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <p class="text-center">
              <strong>SS Goal Completion {{$tahun}}</strong>
              <a href="{{url('/iso/sspoint')}}" class="link-red text-md float-right"><i
                  class="fa fa-hand-point-right mr-1">
                </i><u> Point SS</u>
              </a>
            </p>

            @foreach ($pross as $p)
            <div class="progress-group">
              {{$p->dept_group}} - {{($p->jml)}}
              <span class="float-right"><b>{{$p->jml_ss}}</b>/{{($p->jml * 2)}}</span>
              <div class="progress progress-lg">
                <div class="progress-bar bg-primary" style="width: {{($p->prosentase)}}%">{{($p->prosentase)}} %</div>
              </div>
            </div>
            @endforeach
            <!-- /.progress-group -->
            <!-- /.progress-group -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- ./card-body -->

      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>


<!-- /.row -->
<!-- Main row -->
<div class="row">


  <div class="col-md-12">

    <!-- BAR CHART -->
    <div class="card card-success">
      <div class="card-header">
        <div class="row">

          <h3 class="card-title">PLan VS Actual <i id="periode"></i></h3>
        </div>

        <div class="row align-center">
          <input type="date" class="form-control col-md-2" id="tgl_awal">
          <label for="" class="col-md-2 text-center">Sampai</label>
          <input type="date" class="form-control col-md-2" id="tgl_akhir">
          <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
        </div>
      </div>
      <div class="card-body">
        <div>
          <canvas id="barChart"></canvas>
        </div>
      </div>
      <!-- /.card-body -->
    </div>

    <div class="card">
      <div class="card-header">

      </div>
      <div class="card-body">
        <table class="table table-bordered" id="tb_det">
          <thead>
            <tr>
              <th>Nama Kelompok</th>
              <th>Plan Amount</th>
              <th>Used Amount</th>
              <th>Selisih</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </div>


</div>
<div class="row">
  <div class="col-md-6">

    <!-- BAR CHART -->
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Jam Kerusakan <i id="periode"></i></h3>

      </div>
      <div class="card-body">
        <div>
          <canvas id="chartjam"></canvas>
        </div>
      </div>
      <div class="card-footer">
        <label for="" id="totaljam"></label>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </div>
  <div class="col-md-6">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Daftar Mesin Stop <i id="periode"></i></h3>

      </div>
      <div class="card-body">
        <table class="table table-bordered" id="tb_mesinoff">
          <thead>
            <tr>
              <th>Nomer Induk Mesin</th>
              <th>Nama Mesin</th>
              <th>No Mesin</th>
              <th>Tanggal Rusak</th>
              <th>Masalah</th>

            </tr>
          </thead>
          <tbody>
            @foreach($mesinoff as $mesin)
            <tr>
              <td>{{$mesin->no_induk_mesin}}</td>
              <td>{{$mesin->nama_mesin}}</td>
              <td>{{$mesin->no_urut_mesin}}</td>
              <td>{{$mesin->tanggal_rusak}}</td>
              <td>{{$mesin->masalah}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
<!-- /.row (main row) -->

<!-- Large modal -->


<div class="modal fade bd-example-modal-lg" id="detail-modal" tabindex="-1" role="dialog"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLongTitle">Modal title</h5>

        <p id="tgl-awal"></p>
        <p>Sampai</p>
        <p id="tgl-akhir"></p>


        </button>
      </div>
      <div class="modal-body">

        <table class="table table-responsive" id="tb_detail">
          <thead>
            <tr>
              <th>Item Code</th>
              <th>Item</th>
              <th>Spesifikasi</th>
              <th>Quota</th>
              <th>Pemakaian</th>
              <th>Selisih</th>
              <th>Uom</th>
            </tr>
          </thead>
        </table>

      </div>
      <div class="modal-footer">

        <div class="col col-md-3">
          <button class="btn btn-success" id="btn-excel">Excel</button>
        </div>
        <div class="col col-md-4"></div>
        <div class="col col-md-3">
          <button type="button" class="btn btn-secondary" id="btn-close">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-detail"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="labeldetail"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


        <table class="table table-sm" id="tb_detail">
          <thead>
            <th>No Induk Mesin</th>
            <th>Nama Mesin</th>
            <th>Jam Rusak</th>

          </thead>
          <tbody>

          </tbody>
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-hhky"
  aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_hhky">Jenis</h5>
        <h5 class="modal-title" id="lbl_hhky1"> Dept</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="table-responsive col-md-12">
        <table class="table table-responsive text-nowrap" id="tb_lokasi_hhky">
          <thead>
            <th>Id hhky</th>
            <th>Tempat Kejadian</th>
            <th style="width: max-content;">Bagian</th>
            <th>Masalah</th>
            <th>Level Resiko</th>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<!-- ChartJS -->
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script>
  $(document).ready(function () {
    var key = localStorage.getItem('npr_token');

    var ctxhhky = document.getElementById('chartpie').getContext('2d');
    var charthhky = new Chart(ctxhhky, {
      type: 'bar',
      data: {},
      options: {}
    });

    tampil_charthhky(charthhky, key);

    var d = new Date();
    var tahun = d.getFullYear();
    var bulan = ("0" + (d.getMonth() + 1)).slice(-2);

    var tanggal = ("0" + d.getDate()).slice(-2);




    var formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
    });
    //grafik plan vs actual
    var ctx = document.getElementById('barChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {},
      options: {}
    });
    //Grafik jam kerusakan mesin
    var ctxjam = document.getElementById('chartjam').getContext('2d');
    var chartjam = new Chart(ctxjam, {
      type: 'bar',
      data: {},
      options: {}
    });

    tampil_chart(key, tahun + "-" + bulan + "-01", tahun + "-" + bulan + "-" + tanggal, chart)
    chart_jamkerusakan(tahun + '-' + bulan, chartjam, key);
    get_success(tahun + '-' + bulan + '-01', tahun + '-' + bulan + '-' + tanggal, key);


    function tampil_chart(key, awal, akhir, chart) {

      $.ajax({
        url: APP_URL + "/api/pemakaian",
        method: "POST",
        data: { "tgl_awal": awal, "tgl_akhir": akhir },
        dataType: "json",
        headers: { "token_req": key },
        success: function (data) {

          var label = [];
          var value = [];
          var Tvalue = [];
          var Tplan = 0;
          var Tuse = 0;
          var Tselisih = 0;

          var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
          });

          $("#tb_det tbody").empty();
          $("#tb_det tfoot").empty();

          for (var i in data) {
            label.push(data[i].nama_kelompok);
            value.push(data[i].amount);
            Tvalue.push(data[i].pakai);

            Tplan = Tplan + Number(data[i].amount);
            Tuse = Tuse + Number(data[i].pakai);

            if (data[i].sisa < 0) {
              td = '<td style="color: rgb(150, 7, 7);">' + formatter.format(data[i].sisa) + '</td>';
            } else {
              td = '<td style="color: rgb(7, 150, 7);">' + formatter.format(data[i].sisa) + '</td>';
            }

            var newrow = '<tr><td>' + data[i].nama_kelompok + '</td><td>' + formatter.format(data[i].amount) + '</td><td>' + formatter.format(data[i].pakai) + '</td>' + td + '</tr>';

            $('#tb_det tbody').append(newrow);
          }
          var ss = Tplan - Tuse;

          $("#tb_det tfoot").append('<tr><th>Total :</th><th>' + formatter.format(Tplan) + '</th><th>' + formatter.format(Tuse) + '</th><th>' + formatter.format(ss) + '</th></tr>');


          chart.data = {
            labels: label,
            datasets: [{
              label: 'Plan Budgeting',
              backgroundColor: 'rgb(255, 99, 132)',
              borderColor: 'rgb(255, 99, 132)',
              data: value
            },
            {
              label: 'Actual',
              backgroundColor: 'rgb(51, 153, 255)',
              borderColor: 'rgb(255, 99, 132)',
              data: Tvalue
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
                  //return formatter.format(data['datasets']['index']['data'][tooltipItem['index']]);
                  return formatter.format(tooltipItem.yLabel);
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
                  // Include a dollar sign in the ticks
                  callback: function (value, index, values) {
                    return formatter.format(value);
                  }
                }
              }]
            },

            onClick: function (c, i) {
              e = i[0];

              var x_value = this.data.labels[e._index];
              var y_value = this.data.datasets[0].data[e._index];

              get_details(x_value, awal, akhir, key);
              $("#tgl-awal").html(awal);
              $("#tgl-akhir").html(akhir);
              $('#ModalLongTitle').html(x_value);
              $('#detail-modal').modal('show');
            }

          };
          chart.update();
        }
      });
    }

    function chart_jamkerusakan(per, chart, key) {
      $("#periode").html(per);
      $.ajax({
        url: APP_URL + "/api/maintenance/grafikjam",
        method: "POST",
        data: { "periode": per },
        dataType: "json",
        headers: { "token_req": key },
        success: function (data) {
          var label = [];
          var value = [];
          var totaljam = 0;
          for (var i in data) {
            label.push(data[i].departemen);
            value.push(data[i].jam);
            totaljam = totaljam + Number(data[i].jam);
          }

          chart.data = {
            labels: label,
            datasets: [
              {
                label: 'Jam Kerusakan',
                backgroundColor: 'rgb(51, 153, 255)',
                borderColor: 'rgb(51, 153, 255)',
                data: value,
              }

            ]
          };
          chart.options = {

            onClick: function (c, i) {
              e = i[0];
              var x_value = this.data.labels[e._index];
              //var tgl = $("#tgl2").val();
              var tgl = tahun + '-' + bulan;
              var p = {
                dept: x_value,
                period: tgl
              };
              action_data(APP_URL + "/api/maintenance/detailjam", p, key).done(function (resp) {
                $("#tb_detail tbody").empty();

                for (var i in resp) {
                  var newrow = '<tr><td>' + resp[i].no_induk_mesin + '</td><td>' + resp[i].nama_mesin + '</td><td>' + Number(resp[i].jam_rusak).toFixed(2) + ' Jam</td></tr>';
                  $('#tb_detail tbody').append(newrow);
                }
              });
              //get_details(x_value,tgl, key);
              $("#labeldetail").html("TOP 5 Kerusakan " + x_value);
              $("#modal-detail").modal("toggle");
            }
          };
          chart.update();
          $("#totaljam").html("Total Jam Kerusakan : " + totaljam.toFixed(2) + " Jam");
        }

      });



    }

    $("#tgl_awal").val(tahun + "-" + bulan + "-01");
    $("#tgl_akhir").val(tahun + "-" + bulan + "-" + tanggal);

    var beg_date = $("#tgl_awal").val();
    var end_date = $("#tgl_akhir").val();


    $("#btn_reload").click(function () {
      var awal = $("#tgl_awal").val();
      var akhir = $("#tgl_akhir").val();
      tampil_chart(key, awal, akhir, chart);
    });


    $("#btn-close").click(function () {

      $('#detail-modal').modal('hide');
      $('#tb_detail').dataTable().fnDestroy();
      $('#tb_detail').empty();
    });
    $("#btn-excel").click(function () {
      var dept = $('#ModalLongTitle').html();
      var tgl_awal = $('#tgl-awal').html();
      var tgl_akhir = $('#tgl-akhir').html();
      $.ajax({
        type: "POST",
        url: APP_URL + "/api/produksi/pemaikain_excel",
        headers: { "token_req": key },
        data: { "dept": dept, "tanggal_awal": tgl_awal, "tanggal_akhir": tgl_akhir },
        dataType: "json",

        success: function (response) {
          var fpath = response.file;
          window.open(fpath, '_blank');

        }

      });
    });

  });

  function renderChart(value, label, awal, akhir, key) {

    var lables = this.label;
    var values = this.value;

    var formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
    });

    var ctx = document.getElementById('barChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: label,
        datasets: [{
          label: 'Total Pemakaian dari Warehouse',
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          data: value
        }]
      },
      options: {
        tooltips: {
          callbacks: {
            title: function (tooltipItem, data) {
              return data['labels'][tooltipItem[0]['index']];
            },
            label: function (tooltipItem, data) {
              return formatter.format(data['datasets'][0]['data'][tooltipItem['index']]);
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
              // Include a dollar sign in the ticks
              callback: function (value, index, values) {
                return formatter.format(value);
              }
            }
          }]
        },

        onClick: function (c, i) {
          e = i[0];

          var x_value = this.data.labels[e._index];
          var y_value = this.data.datasets[0].data[e._index];

          get_details(x_value, awal, akhir, key);
          $("#tgl-awal").html(awal);
          $("#tgl-akhir").html(akhir);
          $('#ModalLongTitle').html(x_value);
          $('#detail-modal').modal('show');
        }
      }
    });

  }

  function getData(key, tgl_awal, tgl_akhir) {

    $.ajax({
      url: APP_URL + "/api/pemakaian",
      method: "POST",
      data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir },
      dataType: "json",
      headers: { "token_req": key },
      success: function (data) {
        //console.log(data);
        var label = [];
        var value = [];



        //console.log(tahun+'-'+bulan+'-'+tanggal);
        for (var i in data) {
          label.push(data[i].dept);
          value.push(data[i].total);
        }

        renderChart(value, label, tgl_awal, tgl_akhir, key);
      }
    });
  }
  function get_details(jenis, tgl_awal, tgl_akhir, key) {
    var list_perbaikan = $('#tb_detail').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      searching: true,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/detail_pakai',
        type: "POST",
        headers: { "token_req": key },
        data: { "jenis": jenis, "awal": tgl_awal, "akhir": tgl_akhir },

      },

      columns: [
        { data: 'item_code', name: 'item_code' },
        { data: 'item', name: 'item' },
        { data: 'spesifikasi', name: 'spesifikasi' },
        { data: 'quota', name: 'quota', render: $.fn.dataTable.render.number(',', '.', 2, '') },
        { data: 'pemakaian', name: 'pemakaian', render: $.fn.dataTable.render.number(',', '.', 2, '') },
        { data: 'selisih', name: 'selisih', render: $.fn.dataTable.render.number(',', '.', 2, '') },
        { data: 'uom', name: 'uom' },
      ]
    });
  }

  function get_success(tgl1, tgl2, key) {
    $("#success-rate").html('Loading...');
    $.ajax({
      url: APP_URL + "/api/dashboard/successrate",
      method: "POST",
      data: { "tgl_awal": tgl1, "tgl_akhir": tgl2 },
      dataType: "json",
      headers: { "token_req": key },
      success: function (data) {
        //console.log(data);
        $("#success-rate").html(data + ' %');
      }
    });
  }
  function action_data(url, datas, key) {
    return $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      headers: { "token_req": key },
      data: datas,
    });
  }

  function tampil_charthhky(charthhky, key) {

    $.ajax({
      url: APP_URL + "/api/dhhky",
      method: "POST",
      dataType: "json",
      headers: { "token_req": key },
      success: function (data) {
        var label = [];
        var value = [];
        var value1 = [];
        var hhclose = [];
        var kyclose = [];
        var coloR = [];
        var dynamicColors = function () {
          var r = Math.floor(Math.random() * 255);
          var g = Math.floor(Math.random() * 255);
          var b = Math.floor(Math.random() * 255);
          return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (var i in data) {
          label.push(data[i].bagian);

          value.push(data[i].HH);
          value1.push(data[i].KY);
          hhclose.push(data[i].HHclose);
          kyclose.push(data[i].KYclose);
          coloR.push(dynamicColors());
        }

        charthhky.data = {
          labels: label,
          datasets: [
            {
              label: 'HH Open',
              lbl: 'HH',
              fill: true,
              borderColor: 'rgb(46, 139, 87)',
              backgroundColor: 'rgb(255,0,127)',
              data: value,
              type: 'bar'



            },
            {
              label: 'KY Open',
              lbl: 'KY',
              fill: true,
              backgroundColor: 'rgb(51, 153, 255)',
              borderColor: 'rgb(255, 99, 132)',
              data: value1,
              type: 'bar'
            }
          ]
        };
        charthhky.options = {
          scales: {
            yAxes: [
              {
                id: 'A',
                type: 'linear',
                position: 'left',
                beginAtZero: true,
              },

            ]
          },
          onClick: function (e, i) {
            c = i[0];
            //alert(e);
            const activePoints = charthhky.getElementsAtEventForMode(e, 'nearest', {
              intersect: true
            }, false)
            var indexNo = activePoints[0]._datasetIndex;
            var x_value = this.data.datasets[indexNo].lbl;


            var y_value = this.data.labels[c._index];
            //console.log(y_value);
            //var x_value1 = this.data.datasets[0].lbl[index];

            $('#lbl_hhky').html(x_value + '_');
            $('#lbl_hhky1').html(y_value);


            get_lokasi_hhky(x_value, y_value, key);
            $('#modal-hhky').modal('show');
          },
        };
        charthhky.update();
      }

    });
  }

  function get_lokasi_hhky(jenis, departemen, key) {
    //var lbl = $('#lbl_hhky').html();
    //alert(lbl);
    var lokasi_hhky = $('#tb_lokasi_hhky').DataTable({
      destroy: true,
      processing: true,
      serverSide: true,
      searching: false,
      ordering: false,
      ajax: {
        url: APP_URL + '/api/dlokasi_hhky',
        type: "POST",
        headers: { "token_req": key },
        data: { "jenis": jenis, "departemen": departemen },
      },
      columnDefs: [{

        targets: [0],
        visible: false,
        searchable: false
      },
      ],

      columns: [
        { data: 'id_hhky', name: 'id_hhky' },
        { data: 'tempat_kejadian', name: 'tempat_kejadian' },
        { data: 'pada_saat', name: 'pada_saat' },
        { data: 'menjadi', name: 'menjadi' },
        { data: 'level_resiko', name: 'level_resiko' },
      ],
      fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
        if (data.level_resiko == "III") {
          $('td', nRow).css('background-color', '#ff9966');
          $('td', nRow).css('color', 'black');
        } if (data.level_resiko == "IV" || data.level_resiko == "V") {
          $('td', nRow).css('background-color', 'red');
          $('td', nRow).css('color', 'white');
        }
      },
    });
  }

</script>
@endsection