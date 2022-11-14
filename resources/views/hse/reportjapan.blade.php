@extends('layout.main')
@section('content')

<div class="col-md-6">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <div class="card card-primary card-flat">
                        <div class="card-header">
                            <div class="col-6">
                                <h3 class="card-title">Closing HH/KY</h3><br>
                            </div>
                        </div>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="periode">Periode</label>
                        </div>
                        <div class="col col-md-9">
                            <input type="month" class="form-control" name="periode_awal" id="periode_awal"
                                placeholder="Periode" required>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <button type="button" id="btn-closing-hhky"
                        class="btn btn-primary btn-flat float-right">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="card card-success">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="card-title" style="font-size:x-large">Rekap for Japan
                            </h3>
                            <input type="hidden" id="line" name="line">
                            <span class="float-right">
                                <button class="btn btn-sm" id="btn-entryjamoperator">
                                    <font color="white">
                                        <i style="font-size: small;">
                                        </i>
                                    </font>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-tools">

                </div>
            </div>
            <div class="row">
                <div class="col col-md-2">
                    <input type="date" class="form-control" id="tgl_awal" value="{{date('Y').'-01-01'}}">
                </div>
                <label for="" class="col-md-1 text-center">Sampai</label>
                <div class="col col-md-2">
                    <input type="date" class="form-control " id="tgl_akhir" value="{{date('Y-m-d')}}">
                </div>
                <div class="col col-md-1 text-right"><label> Jenis</label></div>

                <div class="col col-md-2">
                    <select name="selectjenis" id="selectjenis"
                        class="form-control select2 @error('jenis') is-invalid @enderror" style="width: 100%;" required>
                        <option value="">Select ... </option>
                        <option value="HH">HH</option>
                        <option value="KY">KY</option>
                    </select>
                </div>
                <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync btn-flat"></i></button>
            </div>

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered" id="tb_rekap">
                <thead>

                    <tr>
                        <th>Tahun</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>01</th>
                        <th>02</th>
                        <th>03</th>
                        <th>04</th>
                        <th>05</th>
                        <th>06</th>
                        <th>07</th>
                        <th>08</th>
                        <th>09</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
                    </tr>

                </thead>
                <tbody>

                </tbody>

                <tfoot>

                </tfoot>
            </table>
        </div>

        <hr>

        <div class="card-body">
            <table class="table table-bordered" id="tb_rekap_level">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>01</th>
                        <th>02</th>
                        <th>03</th>
                        <th>04</th>
                        <th>05</th>
                        <th>06</th>
                        <th>07</th>
                        <th>08</th>
                        <th>09</th>
                        <th>10</th>
                        <th>11</th>
                        <th>12</th>
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

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();
        var selectjenis = $('#selectjenis').val();
        var line = $('#line').val();
        //load_table(tgl_awal, tgl_akhir, key, selectjenis);
        load_table(tgl_awal, tgl_akhir, key, selectjenis);
        load_table_level(tgl_awal, tgl_akhir, key);


        $("#btn_reload").click(function () {
            var tgl_awal = $('#tgl_awal').val();
            var tgl_akhir = $('#tgl_akhir').val();
            var selectjenis = $('#selectjenis').val();
            var line = $('#line').val();
            //load_table(tgl_awal, tgl_akhir, key, selectshift, line);
            load_table(tgl_awal, tgl_akhir, key, selectjenis);
            load_table_level(tgl_awal, tgl_akhir, key);
        });

        $("#btn-closing-hhky").click(function (e) {
            e.preventDefault();
            var periode_awal = $("#periode_awal").val();
            //alert(tgl_awal);
            //var data = $(this).serialize();
            if (periode_awal == '' || periode_awal == null) {
                alert('Masukkan Periode .')
            } else {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/hse/closing_hhky",
                    headers: { "token_req": key },
                    //data: data,
                    data: { "periode_awal": periode_awal },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        } else
                            alert(resp.message);
                    })
            }
        });

    });


    function load_table(tgl_awal, tgl_akhir, key, selectjenis) {
        $.ajax({
            url: APP_URL + "/api/hse/hhkyrekapmonth",
            method: "POST",
            data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "selectjenis": selectjenis },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value2 = [];
                var totm1 = 0;
                var totm2 = 0;
                var totm3 = 0;
                var totm4 = 0;
                var totm5 = 0;
                var totm6 = 0;
                var totm7 = 0;
                var totm8 = 0;
                var totm9 = 0;
                var totm10 = 0;
                var totm11 = 0;
                var totm12 = 0;

                var tot12 = 0;
                var tot13 = 0;
                var tot14 = 0;
                var tot15 = 0;
                var tot16 = 0;
                var tot17 = 0;
                var tot18 = 0;
                var tot19 = 0;
                var tot110 = 0;
                var tot111 = 0;
                var tot112 = 0;

                var totmc1 = 0;
                var totmc2 = 0;
                var totmc3 = 0;
                var totmc4 = 0;
                var totmc5 = 0;
                var totmc6 = 0;
                var totmc7 = 0;
                var totmc8 = 0;
                var totmc9 = 0;
                var totmc10 = 0;
                var totmc11 = 0;
                var totmc12 = 0;

                var p1 = 0;
                var p2 = 0;
                var p3 = 0;
                var p4 = 0;
                var p5 = 0;
                var p6 = 0;
                var p7 = 0;
                var p8 = 0;
                var p9 = 0;
                var p10 = 0;
                var p11 = 0;
                var p12 = 0;

                $("#tb_rekap tbody").empty();
                $("#tb_rekap tfoot").empty();


                for (var i in data.list) {
                    thn = (data.list[i].year);
                    jenis = (data.list[i].jenis_laporan);
                    status = (data.list[i].status_laporan);
                    m1 = (data.list[i].m1);
                    m2 = (data.list[i].m2);
                    m3 = (data.list[i].m3);
                    m4 = (data.list[i].m4);
                    m5 = (data.list[i].m5);
                    m6 = (data.list[i].m6);
                    m7 = (data.list[i].m7);
                    m8 = (data.list[i].m8);
                    m9 = (data.list[i].m9);
                    m10 = (data.list[i].m10);
                    m11 = (data.list[i].m11);
                    m12 = (data.list[i].m12);

                    totm1 = totm1 + Number(m1)
                    totm2 = totm2 + Number(m2)
                    totm3 = totm3 + Number(m3)
                    totm4 = totm4 + Number(m4)
                    totm5 = totm5 + Number(m5)
                    totm6 = totm6 + Number(m6)
                    totm7 = totm7 + Number(m7)
                    totm8 = totm8 + Number(m8)
                    totm9 = totm9 + Number(m9)
                    totm10 = totm10 + Number(m10)
                    totm11 = totm11 + Number(m11)
                    totm12 = totm12 + Number(m12)

                    tot12 = totm1 + totm2
                    tot13 = totm1 + totm2 + totm3
                    tot14 = totm1 + totm2 + totm3 + totm4
                    tot15 = totm1 + totm2 + totm3 + totm4 + totm5
                    tot16 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6
                    tot17 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7
                    tot18 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8
                    tot19 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9
                    tot110 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9 + totm10
                    tot111 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9 + totm10 + totm11
                    tot112 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9 + totm10 + totm11 + totm12

                    var newrow = '<tr><td><name="cf[]" value="/>' + thn + '</td><td><name="cf[]" value="/>' + jenis + '</td><td><name="cf[]" value="/>' + status + '</td><td><name="cf[]" value="/>' + m1 + '</td><td><name="cf[]" value="/>' + m2 + '</td><td><name="cf[]" value="/>' + m3 + '</td><td><name="ccr[]" value="/>' + m4 + '</td><td><name="oif[]" value="/>' + m5 + '</td><td><name="oicr[]" value="/>' + m6 + '</td><td class="jumlah"><name="total[]" value="/>' + m7 + '</td><td class="total"><name="total[]" value="/>' + m8 + '</td><td class=""><name="total[]" value="/>' + m9 + '</td><td class=""><name="total[]" value="/>' + m10 + '</td><td class=""><name="total[]" value="/>' + m11 + '</td><td class=""><name="total[]" value="/>' + m12 + '</td></tr>';
                    $('#tb_rekap tbody').append(newrow);


                }

                for (var i in data.listclose) {
                    thn = (data.listclose[i].year);
                    jenis = (data.listclose[i].jenis_laporan);
                    status = (data.listclose[i].status_laporan);
                    mc1 = (data.listclose[i].m1);
                    mc2 = (data.listclose[i].m2);
                    mc3 = (data.listclose[i].m3);
                    mc4 = (data.listclose[i].m4);
                    mc5 = (data.listclose[i].m5);
                    mc6 = (data.listclose[i].m6);
                    mc7 = (data.listclose[i].m7);
                    mc8 = (data.listclose[i].m8);
                    mc9 = (data.listclose[i].m9);
                    mc10 = (data.listclose[i].m10);
                    mc11 = (data.listclose[i].m11);
                    mc12 = (data.listclose[i].m12);

                    totmc1 = totmc1 + Number(mc1)
                    totmc2 = totmc2 + Number(mc1) + Number(mc2)
                    totmc3 = totmc3 + Number(mc1) + Number(mc2) + Number(mc3)
                    totmc4 = totmc4 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4)
                    totmc5 = totmc5 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5)
                    totmc6 = totmc6 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6)
                    totmc7 = totmc7 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7)
                    totmc8 = totmc8 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8)
                    totmc9 = totmc9 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9)
                    totmc10 = totmc10 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9) + Number(mc10)
                    totmc11 = totmc11 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9) + Number(mc10) + Number(mc11)
                    totmc12 = totmc12 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9) + Number(mc10) + Number(mc11) + Number(mc12)

                    p1 = (totmc1 / totm1) * 100
                    p2 = (totmc2 / tot12) * 100
                    p3 = (totmc3 / tot13) * 100
                    p4 = (totmc4 / tot14) * 100
                    p5 = (totmc5 / tot15) * 100
                    p6 = (totmc6 / tot16) * 100
                    p7 = (totmc7 / tot17) * 100
                    p8 = (totmc8 / tot18) * 100
                    p9 = (totmc9 / tot19) * 100
                    p10 = (totmc10 / tot110) * 100
                    p11 = (totmc11 / tot111) * 100
                    p12 = (totmc12 / tot112) * 100
                }

                $("#tb_rekap tfoot").append('<tr><th colspan="3">Total Masuk :</th><th>' + totm1.toLocaleString("en-US") + '</th><th>' + totm2.toLocaleString("en-US") + '</th><th>' + totm3.toLocaleString("en-US") + '</th><th>' + totm4.toLocaleString("en-US") + '</th><th class="jumlah">' + totm5.toLocaleString("en-US") + '</th><th class="total">' + totm6.toLocaleString("en-US") + '</th><th class="">' + totm7.toLocaleString("en-US") + '</th><th class="">' + totm8.toLocaleString("en-US") + '</th><th class="">' + totm9.toLocaleString("en-US") + '</th><th class="">' + totm10.toLocaleString("en-US") + '</th><th class="">' + totm11.toLocaleString("en-US") + '</th><th class="">' + totm12.toLocaleString("en-US") + '</th></tr>')
                //$("#tb_rekap tfoot").append('<tr><th colspan="3">Akumulasi Total Masuk :</th><th>' + totm1.toLocaleString("en-US") + '</th><th>' + tot12.toLocaleString("en-US") + '</th><th>' + tot13.toLocaleString("en-US") + '</th><th>' + tot14.toLocaleString("en-US") + '</th><th class="jumlah">' + tot15.toLocaleString("en-US") + '</th><th class="total">' + tot16.toLocaleString("en-US") + '</th><th class="">' + tot17.toLocaleString("en-US") + '</th><th class="">' + tot18.toLocaleString("en-US") + '</th><th class="">' + tot19.toLocaleString("en-US") + '</th><th class="">' + tot110.toLocaleString("en-US") + '</th><th class="">' + tot111.toLocaleString("en-US") + '</th><th class="">' + tot112.toLocaleString("en-US") + '</th></tr>')
                $("#tb_rekap tfoot").append('<tr><th colspan="3">Prosentase :</th><th>' + parseFloat(p1).toFixed(0) + ' %' + '</th><th>' + parseFloat(p2).toFixed(0) + ' %' + '</th><th>' + parseFloat(p3).toFixed(0) + ' %' + '</th><th>' + parseFloat(p4).toFixed(0) + ' %' + '</th><th class="jumlah">' + parseFloat(p5).toFixed(0) + ' %' + '</th><th class="total">' + parseFloat(p6).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p7).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p8).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p9).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p10).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p11).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p12).toFixed(0) + ' %' + '</th></tr>')
            }

        });
    }

    function load_table_level(tgl_awal, tgl_akhir, key) {
        $.ajax({
            url: APP_URL + "/api/hse/hhkyrekaplevel",
            method: "POST",
            data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value2 = [];
                var totm1 = 0;
                var totm2 = 0;
                var totm3 = 0;
                var totm4 = 0;
                var totm5 = 0;
                var totm6 = 0;
                var totm7 = 0;
                var totm8 = 0;
                var totm9 = 0;
                var totm10 = 0;
                var totm11 = 0;
                var totm12 = 0;

                var tot12 = 0;
                var tot13 = 0;
                var tot14 = 0;
                var tot15 = 0;
                var tot16 = 0;
                var tot17 = 0;
                var tot18 = 0;
                var tot19 = 0;
                var tot110 = 0;
                var tot111 = 0;
                var tot112 = 0;

                var totmc1 = 0;
                var totmc2 = 0;
                var totmc3 = 0;
                var totmc4 = 0;
                var totmc5 = 0;
                var totmc6 = 0;
                var totmc7 = 0;
                var totmc8 = 0;
                var totmc9 = 0;
                var totmc10 = 0;
                var totmc11 = 0;
                var totmc12 = 0;

                var p1 = 0;
                var p2 = 0;
                var p3 = 0;
                var p4 = 0;
                var p5 = 0;
                var p6 = 0;
                var p7 = 0;
                var p8 = 0;
                var p9 = 0;
                var p10 = 0;
                var p11 = 0;
                var p12 = 0;

                $("#tb_rekap_level tbody").empty();
                $("#tb_rekap_level tfoot").empty();


                for (var i in data.listlevel) {
                    thn = (data.listlevel[i].year);
                    level = (data.listlevel[i].level_resiko);
                    status = (data.listlevel[i].status_laporan);
                    m1 = (data.listlevel[i].m1);
                    m2 = (data.listlevel[i].m2);
                    m3 = (data.listlevel[i].m3);
                    m4 = (data.listlevel[i].m4);
                    m5 = (data.listlevel[i].m5);
                    m6 = (data.listlevel[i].m6);
                    m7 = (data.listlevel[i].m7);
                    m8 = (data.listlevel[i].m8);
                    m9 = (data.listlevel[i].m9);
                    m10 = (data.listlevel[i].m10);
                    m11 = (data.listlevel[i].m11);
                    m12 = (data.listlevel[i].m12);

                    totm1 = totm1 + Number(m1)
                    totm2 = totm2 + Number(m2)
                    totm3 = totm3 + Number(m3)
                    totm4 = totm4 + Number(m4)
                    totm5 = totm5 + Number(m5)
                    totm6 = totm6 + Number(m6)
                    totm7 = totm7 + Number(m7)
                    totm8 = totm8 + Number(m8)
                    totm9 = totm9 + Number(m9)
                    totm10 = totm10 + Number(m10)
                    totm11 = totm11 + Number(m11)
                    totm12 = totm12 + Number(m12)

                    tot12 = totm1 + totm2
                    tot13 = totm1 + totm2 + totm3
                    tot14 = totm1 + totm2 + totm3 + totm4
                    tot15 = totm1 + totm2 + totm3 + totm4 + totm5
                    tot16 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6
                    tot17 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7
                    tot18 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8
                    tot19 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9
                    tot110 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9 + totm10
                    tot111 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9 + totm10 + totm11
                    tot112 = totm1 + totm2 + totm3 + totm4 + totm5 + totm6 + totm7 + totm8 + totm9 + totm10 + totm11 + totm12

                    var newrow = '<tr><td><name="cf[]" value="/>' + thn + '</td><td><name="cf[]" value="/>' + level + '</td><td><name="cf[]" value="/>' + status + '</td><td><name="cf[]" value="/>' + m1 + '</td><td><name="cf[]" value="/>' + m2 + '</td><td><name="cf[]" value="/>' + m3 + '</td><td><name="ccr[]" value="/>' + m4 + '</td><td><name="oif[]" value="/>' + m5 + '</td><td><name="oicr[]" value="/>' + m6 + '</td><td class="jumlah"><name="total[]" value="/>' + m7 + '</td><td class="total"><name="total[]" value="/>' + m8 + '</td><td class=""><name="total[]" value="/>' + m9 + '</td><td class=""><name="total[]" value="/>' + m10 + '</td><td class=""><name="total[]" value="/>' + m11 + '</td><td class=""><name="total[]" value="/>' + m12 + '</td></tr>';
                    $('#tb_rekap_level tbody').append(newrow);


                }

                for (var i in data.listlevelclose) {
                    thn = (data.listlevelclose[i].year);
                    level = (data.listlevelclose[i].level_resiko);
                    status = (data.listlevelclose[i].status_laporan);
                    mc1 = (data.listlevelclose[i].m1);
                    mc2 = (data.listlevelclose[i].m2);
                    mc3 = (data.listlevelclose[i].m3);
                    mc4 = (data.listlevelclose[i].m4);
                    mc5 = (data.listlevelclose[i].m5);
                    mc6 = (data.listlevelclose[i].m6);
                    mc7 = (data.listlevelclose[i].m7);
                    mc8 = (data.listlevelclose[i].m8);
                    mc9 = (data.listlevelclose[i].m9);
                    mc10 = (data.listlevelclose[i].m10);
                    mc11 = (data.listlevelclose[i].m11);
                    mc12 = (data.listlevelclose[i].m12);

                    totmc1 = totmc1 + Number(mc1)
                    totmc2 = totmc2 + Number(mc1) + Number(mc2)
                    totmc3 = totmc3 + Number(mc1) + Number(mc2) + Number(mc3)
                    totmc4 = totmc4 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4)
                    totmc5 = totmc5 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5)
                    totmc6 = totmc6 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6)
                    totmc7 = totmc7 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7)
                    totmc8 = totmc8 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8)
                    totmc9 = totmc9 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9)
                    totmc10 = totmc10 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9) + Number(mc10)
                    totmc11 = totmc11 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9) + Number(mc10) + Number(mc11)
                    totmc12 = totmc12 + Number(mc1) + Number(mc2) + Number(mc3) + Number(mc4) + Number(mc5) + Number(mc6) + Number(mc7) + Number(mc8) + Number(mc9) + Number(mc10) + Number(mc11) + Number(mc12)

                    p1 = (totmc1 / totm1) * 100
                    p2 = (totmc2 / tot12) * 100
                    p3 = (totmc3 / tot13) * 100
                    p4 = (totmc4 / tot14) * 100
                    p5 = (totmc5 / tot15) * 100
                    p6 = (totmc6 / tot16) * 100
                    p7 = (totmc7 / tot17) * 100
                    p8 = (totmc8 / tot18) * 100
                    p9 = (totmc9 / tot19) * 100
                    p10 = (totmc10 / tot110) * 100
                    p11 = (totmc11 / tot111) * 100
                    p12 = (totmc12 / tot112) * 100

                }

                $("#tb_rekap_level tfoot").append('<tr><th colspan="3">Total Masuk :</th><th>' + totm1.toLocaleString("en-US") + '</th><th>' + totm2.toLocaleString("en-US") + '</th><th>' + totm3.toLocaleString("en-US") + '</th><th>' + totm4.toLocaleString("en-US") + '</th><th class="jumlah">' + totm5.toLocaleString("en-US") + '</th><th class="total">' + totm6.toLocaleString("en-US") + '</th><th class="">' + totm7.toLocaleString("en-US") + '</th><th class="">' + totm8.toLocaleString("en-US") + '</th><th class="">' + totm9.toLocaleString("en-US") + '</th><th class="">' + totm10.toLocaleString("en-US") + '</th><th class="">' + totm11.toLocaleString("en-US") + '</th><th class="">' + totm12.toLocaleString("en-US") + '</th></tr>')
                //$("#tb_rekap_level tfoot").append('<tr><th colspan="3">Akumulasi Total Masuk :</th><th>' + totm1.toLocaleString("en-US") + '</th><th>' + tot12.toLocaleString("en-US") + '</th><th>' + tot13.toLocaleString("en-US") + '</th><th>' + tot14.toLocaleString("en-US") + '</th><th class="jumlah">' + tot15.toLocaleString("en-US") + '</th><th class="total">' + tot16.toLocaleString("en-US") + '</th><th class="">' + tot17.toLocaleString("en-US") + '</th><th class="">' + tot18.toLocaleString("en-US") + '</th><th class="">' + tot19.toLocaleString("en-US") + '</th><th class="">' + tot110.toLocaleString("en-US") + '</th><th class="">' + tot111.toLocaleString("en-US") + '</th><th class="">' + tot112.toLocaleString("en-US") + '</th></tr>')
                $("#tb_rekap_level tfoot").append('<tr><th colspan="3">Prosentase :</th><th>' + parseFloat(p1).toFixed(0) + ' %' + '</th><th>' + parseFloat(p2).toFixed(0) + ' %' + '</th><th>' + parseFloat(p3).toFixed(0) + ' %' + '</th><th>' + parseFloat(p4).toFixed(0) + ' %' + '</th><th class="jumlah">' + parseFloat(p5).toFixed(0) + ' %' + '</th><th class="total">' + parseFloat(p6).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p7).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p8).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p9).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p10).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p11).toFixed(0) + ' %' + '</th><th class="">' + parseFloat(p12).toFixed(0) + ' %' + '</th></tr>')
            }

        });
    }


</script>
@endsection