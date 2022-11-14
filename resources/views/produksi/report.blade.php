@extends('layout.main')
@section('content')

<div class="row">
  <div class="col-md-12">

    <div class="card">
      <div class="card-header">
        <h3 class="p-2 mb-2 bg-secondary text-white">Target {{Date('F Y')}}
        </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">

          <thead>
            <tr>
              <th>Desc</th>
              <th>Periode</th>
              <th>Target</th>
              <th>Actual</th>
              <th>Diff</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Produksi</td>
              <td>{{date("Y-M")}}</td>
              <td>{{number_format($target->target,0)}}</td>
              <td>{{number_format($acp9909[0]->qty,0)}}</td>
              @if ($acp9909[0]->qty-$target->target < 0) <td style="color: red;">
                {{number_format($acp9909[0]->qty-$target->target,0)}}</td>
                @else
                <td style="color: rgb(7, 150, 7);">{{number_format($acp9909[0]->qty-$target->target,0)}}</td>
                @endif
            </tr>
          </tbody>
          <tbody>
            <tr>
              <td>Sales</td>
              <td>{{date('Y-M')}}</td>
              <td>{{number_format($t_sales->target,0)}}</td>
              <td>{{number_format($targetsales[0]->qty,0)}}</td>
              @if ($targetsales[0]->qty-$t_sales->target < 0) <td style="color: red;">
                {{number_format($targetsales[0]->qty-$t_sales->target,0)}}</td>
                @else
                <td style="color:rgb(7, 150, 7)">{{number_format($targetsales[0]->qty-$t_sales->target,0)}}</td>
                @endif
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="p-2 mb-2 bg-success text-white">Hasil Produksi PerHari </h3>
        <div class="row">
          <div class="col col-md-3">
            <select name="typering" id="typering" class="form-control" required>
              <option value="All">All</option>
              <option value="Cr">Cr</option>
              <option value="F">F</option>
            </select>
          </div>
          <div class="form-group col-md-5">
            <input type="date" class="form-control col-md-12" value="{{date('Y-m-d')}}" name="tgl" id="tgl"
              placeholder="Tanggal ditemukan" required>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered" id="tb_proses">
          <thead>
            <tr>
              <th>Kode Proses</th>
              <th>Nama Proses</th>
              <th>Qty</th>
              <th>Target</th>
              <th>Diff</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="p-2 mb-2 bg-success text-white">Hasil Produksi PerBulan </h3>
        <div class="row">
          <div class="form-group col-md-10">
            <div class="row align-center">
              <input type="date" class="form-control col-sm-5" value="{{date('Y-m').'-01'}}" name="tgl_p1" id="tgl_p1">
              <label for="" class="col-md-2 text-center"> Sampai </label>
              <input type="date" class="form-control col-sm-5" value="{{date('Y-m-d')}}" name="tgl_p2" id="tgl_p2">
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered" id="tb_proses_1">
          <thead>
            <tr>
              <th>Kode Proses</th>
              <th>Nama Proses</th>
              <th>Qty</th>
              <th>Target</th>
              <th>Diff</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
    </div>
  </div>


  <div class="col-md-6">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="p-2 mb-2 bg-primary text-white">Shikakari</h3>
        <div class="row">
          <div class="form-group col-md-5">
            <input type="date" class="form-control col-md-12" value="{{date('Y-m-d')}}" name="tgl" id="tgl"
              placeholder="Tanggal ditemukan" disabled>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered" id="tb_shikakari">

          <thead>
            <tr>
              <th>Kode Proses</th>
              <th>Nama Proses</th>
              <th>QTy</th>
              <th>Target</th>
              <th>Diff</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>

          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <!-- /.card -->
</div>

<div class="row">
  <div class="col-md-12">

    <div class="card">
      <div class="card-header">
        <h3 class="p-2 mb-2 bg-secondary text-white">Hasil Sales per <b>{{Date('Y-M').'-01'}}</b> Sampai
          <b>{{Date('Y-M-d')}}</b>
        </h3>

      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">

          <thead>
            <tr>
              <th>Customer</th>
              <th>Qty</th>
              <th>Amount</th>
              <th>Curr</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($salesproduksi ?? '' as $sales)
            <tr>
              <td>{{$sales -> i_del_dest_desc}}</td>
              <td>{{number_format($sales -> qty,0)}}</td>
              <td>{{number_format($sales -> amt,0)}}</td>
              <td>{{$sales -> i_curr_cd}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

<div class="row">
  <div class="col-md-12">

    <div class="card">
      <div class="card-header">
        <h3 class="p-2 mb-2 bg-secondary text-white">Group By Currency per <b>{{Date('Y-M').'-01'}}</b> Sampai
          <b>{{Date('Y-M-d')}}</b></h3>

      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table class="table table-bordered">

          <thead>
            <tr>
              <th>Curr</th>
              <th>Qty</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($totalamount ?? '' as $salesamt)
            <tr>
              <td>{{$salesamt -> i_curr_cd}}</td>
              <td>{{number_format($salesamt -> qty,0)}}</td>
              <td>{{number_format($salesamt -> amt,0)}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function () {
    var key = localStorage.getItem('npr_token');
    var peri = $("#tgl").val();
    var typering = $('#typering').val();
    load_table(peri, typering, key);

    $("#tgl").change(function () {
      var now = $('#tgl').val();
      var typering = $('#typering').val();
      load_table(now, typering, key);
    });

    var bln1 = $("#tgl_p1").val();
    var bln2 = $('#tgl_p2').val();
    load_table1(bln1, bln2, key);

    $("#tgl_p2").change(function () {
      var pbln1 = $('#tgl_p1').val();
      var pbln2 = $('#tgl_p2').val();
      load_table1(pbln1, pbln2, key);
    });
  });


  function load_table(tgl, typering, key) {
    $.ajax({
      url: APP_URL + "/api/produksi/getreport_produksi",
      method: "POST",
      data: { "tgl": tgl, "tgl1": tgl, "typering": typering },
      dataType: "json",
      headers: { "token_req": key },
      success: function (data) {
        var label = [];
        var value = [];
        var value2 = [];

        var q1 = 0;
        var q2 = 0;
        var totq1 = 0;
        var totq2 = 0;

        var jm = 0;
        var jm2 = 0;
        var tot = 0;
        var tot2 = 0;


        $("#tb_proses tbody").empty();
        $("#tb_proses tfoot").empty();
        $("#tb_shikakari tbody").empty();
        $("#tb_shikakari tfoot").empty();

        for (var i in data.hasilproduksi) {
          q1 = (data.hasilproduksi[i].i_acp_qty);
          q2 = (data.hasilproduksi[i].target_prod);
          dif = (data.hasilproduksi[i].i_acp_qty - data.hasilproduksi[i].target_prod);
          if (dif < 0) {
            td = '<td style="color: red;">' + Number(dif) + '</td>';
          } else {
            td = '<td style="color: rgb(7, 150, 7);">' + Number(dif) + '</td>';
          }
          totq1 = totq1 + Number(q1)
          totq2 = totq2 + Number(q2)
          var newrow = '<tr><td><name="i_ind_content[]" value="/>' + data.hasilproduksi[i].i_ind_content + '</td><td><name="v_name[]" value="/>' + data.hasilproduksi[i].v_name + '</td><td><name="i_acp_qty[]" value="/>' + data.hasilproduksi[i].i_acp_qty + '</td><td><name="target_prod[]" value="/>' + Number(data.hasilproduksi[i].target_prod) + '</td>' + td + '</tr>';
          $('#tb_proses tbody').append(newrow);
        }

        var hproduksi = totq1 - totq2;
        $("#tb_proses tfoot").append('<tr><th colspan="2">Total :</th><th>' + totq1.toLocaleString("en-US") + '</th><th>' + totq2.toLocaleString("en-US") + '</th><th>' + hproduksi.toLocaleString("en-US") + '</th></tr>')


        for (var i in data.h1) {
          jm = (data.h1[i].qty);
          jm2 = (data.h1[i].target);
          dif = (data.h1[i].qty - data.h1[i].target);
          if (dif < 0) {
            td = '<td style="color: red;">' + Number(dif) + '</td>';
          } else {
            td = '<td style="color: rgb(7, 150, 7);">' + Number(dif) + '</td>';
          }

          tot = tot + Number(jm)
          tot2 = tot2 + Number(jm2)
          var newrow = '<tr><td><name="v_loc_cd[]" value="' + data.h1[i].v_loc_cd + '" />' + data.h1[i].v_loc_cd + '</td><td><name="v_name[]" value="' + data.h1[i].v_name + '" />' + data.h1[i].v_name + '</td><td><name="qty[]" value="' + data.h1[i].qty + '" />' + data.h1[i].qty + '</td><td><name="target[]" value="/>' + Number(data.h1[i].target) + '</td>' + td + '</tr>';
          $('#tb_shikakari tbody').append(newrow);
        }
        var p = tot - tot2;
        $("#tb_shikakari tfoot").append('<tr><th colspan="2">Total :</th><th>' + tot.toLocaleString("en-US") + '</th><th>' + tot2.toLocaleString("en-US") + '</th><th>' + p.toLocaleString("en-US") + '</th></tr>')
      }

    });
  }


  function load_table1(tgl_p1, tgl_p2, key) {
    $.ajax({
      url: APP_URL + "/api/produksi/getreport_produksi",
      method: "POST",
      data: { "tgl": tgl_p1, "tgl1": tgl_p2 },
      dataType: "json",
      headers: { "token_req": key },
      success: function (data) {
        var label = [];
        var value = [];
        var value2 = [];
        var jm = 0;
        var jm2 = 0;
        var tot = 0;
        var tot2 = 0;

        $("#tb_proses_1 tbody").empty();
        $("#tb_proses_1 tfoot").empty();


        for (var i in data.hasilproduksi_monthly) {
          jm = (data.hasilproduksi_monthly[i].i_acp_qty);
          jm2 = (data.hasilproduksi_monthly[i].target_prod);
          dif = (data.hasilproduksi_monthly[i].i_acp_qty - data.hasilproduksi_monthly[i].target_prod);
          if (dif < 0) {
            td = '<td style="color: red;">' + Number(dif) + '</td>';
          } else {
            td = '<td style="color: rgb(7, 150, 7);">' + Number(dif) + '</td>';
          }

          tot = tot + Number(jm)
          tot2 = tot2 + Number(jm2)

          var newrow = '<tr><td><name="i_ind_content[]" value="/>' + data.hasilproduksi_monthly[i].i_ind_content + '</td><td><name="v_name[]" value="/>' + data.hasilproduksi_monthly[i].v_name + '</td><td><name="i_acp_qty[]" value="/>' + data.hasilproduksi_monthly[i].i_acp_qty + '</td><td><name="target_prod[]" value="/>' + Number(data.hasilproduksi_monthly[i].target_prod) + '</td>' + td + '</tr>';
          $('#tb_proses_1 tbody').append(newrow);
        }

        var p = tot - tot2;
        $("#tb_proses_1 tfoot").append('<tr><th colspan="2">Total :</th><th>' + tot.toLocaleString("en-US") + '</th><th>' + tot2.toLocaleString("en-US") + '</th><th>' + p.toLocaleString("en-US") + '</th></tr>')
      }

    });
  }



</script>
@endsection