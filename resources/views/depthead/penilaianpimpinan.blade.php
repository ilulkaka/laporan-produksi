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

<form action="{{url('depthead/input_penilaian_pimpinan')}}" method="post">
    {{csrf_field()}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card card-danger">
                        <div class="card-header">
                            <div class="col-6">
                                <h3 class="card-title">Penilaian Entry</h3><br>
                                <h6>Untuk SUPERVISOR, FOREMAN, LEADER</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label for="periode">Periode</label>
                            <input type="month" class="form-control" name="periode" id="periode" placeholder="Periode"
                                required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nik">NIK</label>
                            <select name="nik" id="nik" class="form-control select2 @error('nik') is-invalid @enderror"
                                style="width: 100%;" required>
                                <option>Pilih NIK</option>

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="nama">Nama Operator</label>
                            <input type="hidden" name="nonik" id="nonik">
                            <input type="hidden" id="jenis">
                            <input type="text" class="form-control @error('nama')is-invalid @enderror" name="nama"
                                id="nama" placeholder="Nama Operator">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="hidden" class="form-control @error('dept_group')is-invalid @enderror"
                                name="departemen" id="departemen" placeholder="departemen" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="height: 600px; overflow-y: auto;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>1. Job Performance </b> <i>(Evaluasi Hasil / Kinerja)</i></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th style="width: 250px">Kriteria</th>
                                <th>Deskripsi</th>
                                <th style="width: 100px">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td><b>Keselamatan (S)</b></td>
                                <td>Apakah ditempat kerja yang menjadi tanggung jawabnya tidak terjadi kecelakaan? <br>
                                    Apakah tingkat kesadaran akan K-3 tinggi, dan banyak kegiatan K-3 yang dilakukan?
                                </td>
                                <td><input type="number" class="form-control gol1" id="keselamatan" name="keselamatan"
                                        min=1 max=5 required>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>Kualitas (Q)</b></td>
                                <td>Apakah ditempat kerja yg menjadi tanggung jawabnya tidak terjadi permasalahan
                                    kualitas?
                                </td>
                                <td><input type="number" class="form-control gol1" id="kualitas" name="kualitas" min=1
                                        max=5 required></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>Penurunan Biaya (C)</b></td>
                                <td>Apakah ada usaha untuk Penurunan biaya? <br>
                                    Apakah pembelian material, spare part dll terkontrol sehingga tidak ada yang
                                    sia-sia?
                                </td>
                                <td><input type="number" class="form-control gol1" id="biaya" name="biaya" min=1 max=5
                                        required></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><b>Pemenuhan Pengiriman (D)</b></td>
                                <td>Apakah pemenuhan nouki harian terkontrol dengan baik? <br>
                                    Apakah memahami prioritas kerja (nouki, dll) dan dapat mengontrol progresnya?
                                </td>
                                <td><input type="number" class="form-control gol1" id="pengiriman" name="pengiriman"
                                        min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td><b>Pemenuhan Rencana Penjualan (P)</b></td>
                                <td>Bagaimana dengan pencapaian rencana penjualan (pcs, maupun jumlah uang)? <br>
                                    Apakah rencana produksi dipahami, sehingga berkontribusi pada kegiatan produksi
                                    harian?
                                </td>
                                <td><input type="number" class="form-control gol1" id="penjualan" name="penjualan" min=1
                                        max=5 required></td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Pedoman Penilaian</a> = Terlampir</i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r1" style="margin-right: 50px">0</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>2. JOB Performance</b><i> (Evaluasi Proses)</i></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th style="width: 250px">Kriteria</th>
                                <th>Deskripsi</th>
                                <th style="width: 100px">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td><b>Kontrol Progres Pekerjaan</b></td>
                                <td>Apakah kondisi progress pekerjaan dipahami?. Apakah deadline nouki dipatuhi? <br>
                                    Apakah pekerjaan di follow up dan tidak hanya diserahkan ke anak buah?
                                </td>
                                <td><input type="number" class="form-control gol2" id="kontrol_progres"
                                        name="kontrol_progres" min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>Improvement Pekerjaan</b></td>
                                <td>SS : <label id="ss" name="ss">Auto</label><br>
                                    KY : <label id="hh" name="hh">Auto</label>
                                </td>

                                <td><input type="number" class="form-control gol2" id="improvement" name="improvement"
                                        min=1 max=5 disabled></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>Problem solving</b></td>
                                <td>Apakah terhadap terjadinya trouble pekerjaan dan orang, telah dipahami masalahnya
                                    dan telah
                                    dilakukan analisa dengan tepat?
                                    Apakah tindakan/solusinya tepat?
                                </td>
                                <td><input type="number" class="form-control gol2" id="penyelesaian_masalah"
                                        name="penyelesaian_masalah" min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><b>Pembinaan bawahan Motovasi bawahan</b></td>
                                <td>Apakah dilakukan pembinaan terencana sesuai dengan kemampuan bawahan? <br>
                                    Apakah selalu menjalin komunikasi dan berusaha meningkatkan motovasi bawahan?
                                </td>
                                <td><input type="number" class="form-control gol2" id="motivasi_bawahan"
                                        name="motivasi_bawahan" min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td><b>Ho - Ren - So (Lapor - Kontak - Konsultasi)</b></td>
                                <td>Apakah secara sukarela memberikan informasi dan pendapat lebih dini ke atasan?
                                </td>
                                <td><input type="number" class="form-control gol2" id="horenso" name="horenso" min=1
                                        max=5 required>
                                </td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td><b>Koordinasi pekerjaan dengan bagian terkait</b></td>
                                <td>Apakah melakukan koordinasi yang baik dengan departemen terkait? <br>
                                    Apakah telah memiliki hubungan saling percaya antar departemen dalam penyelesaian
                                    masalah
                                    yang timbul?
                                </td>
                                <td><input type="number" class="form-control gol2" id="koordinasi_pekerjaan"
                                        name="koordinasi_pekerjaan" min=1 max=5 required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Pedoman Penilaian</a> = Terlampir</i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r2" style="margin-right: 50px">0</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>3. CAPABILITY</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th style="width: 250px">Kriteria</th>
                                <th>Deskripsi</th>
                                <th style="width: 100px">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td><b>Pengetahuan / Keterampilan</b></td>
                                <td>Apakah mempunyai Keterampilan dan pengetahuan teknis pekerjaannya? <br>
                                    Apakah memiliki pengetahuan keahlian tentang mesin, keselamatan, kualitas yang
                                    diperlukan
                                    untuk
                                    menjalankannya.
                                </td>
                                <td><input type="number" class="form-control gol3" id="pengetahuan" name="pengetahuan"
                                        min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>Kemampuan memahami, memutuskan</b></td>
                                <td>Apakah mempunyai kemampuan memahami dan memutuskan?
                                    Apakah dapat memahami suatu hal dengan benar, dapat memberikan kesimpulan dengan
                                    cepat
                                    dengan
                                    tindakan tepat?
                                </td>
                                <td><input type="number" class="form-control gol4" id="keputusan" name="keputusan" min=1
                                        max=5 required></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>kemampuan merencanakan</b></td>
                                <td>Apakah mempunyai kemampuan merencanan pekerjaan yang menjadi tanggung jawabnya? <br>
                                    Apakah melaksanakan pekerjaan dengan rencana, procedure dan tahapan yang buat?
                                </td>
                                <td><input type="number" class="form-control gol4" id="perencanaan" name="perencanaan"
                                        min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><b>Kemampuan negosiasi</b></td>
                                <td>Kemampuan menyatakan, berkomunikasi ada tidak? <br>
                                    Apakah dalam meeting atau yang lain, menyatakan pendapatnya secara aktif serta dapat
                                    memahami persoalan dengan baik?
                                </td>
                                <td><input type="number" class="form-control gol4" id="negosiasi" name="negosiasi" min=1
                                        max=5 required></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td><b>kemampuan fisik dan mental dalam merespon</b></td>
                                <td>Apakah mempunyai kemampuan untuk tidak abai pada masalah, bekerja lebih keras dan
                                    fokus?
                                </td>
                                <td><input type="number" class="form-control gol4" id="respon" name="respon" min=1 max=5
                                        required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Point 5</a> = tidak ada karyawan lain yang lebih
                        menonjol
                        dan unggul darinya ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 4</a> = Excellent</i><br>
                    <i style="font-size: small;"><a style="color:red;">Point 3</a> = Mengerjakan tanpa masalah dan tidak
                        ada
                        masalah khusus ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 2</a> = Ada beberapa poin yang membutuhkan
                        pendidikan dan pelatihan
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 1</a> = Masih memerlukan pendidikan yang
                        memadahi</i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r4" style="margin-right: 50px">0</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>3. SIKAP, KESADARAN</b></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th style="width: 250px">Kriteria</th>
                                <th>Deskripsi</th>
                                <th style="width: 100px">Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td><b>Kedisiplinan</b></td>
                                <td>Prosentase : <label id="prosentase" name="prosentase">Auto</label><br>
                                    Prosentase Dept : <label id="prosentase_dept" name="prosentase_dept">Auto</label>
                                </td>
                                <td><input type="number" class="form-control gol5" id="kedisiplinan" name="kedisiplinan"
                                        min=1 max=5 disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>kerja sama</b></td>
                                <td>diluar pekerjaan yang menjadi tanggung jawabnya, Apakah mempunyai tingkat motivasi
                                    untuk
                                    melakukan kegiatan positif dalam tim work, dan menyamakan visi dengan yang lainnya?
                                </td>
                                <td><input type="number" class="form-control gol5" id="kerjasama" name="kerjasama" min=1
                                        max=5 required></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>Antusiasme</b></td>
                                <td>Melakukan kegiatan diluar ruang lingkup pekerjaannya dengan termotivasi.
                                    melakukan dengan sukarela perbaikan kerja, pengembangan diri, dan termotivasi untuk
                                    melakukan
                                    hal-hal baru (diluar pekerjaan yang diinstruksikan)
                                </td>
                                <td><input type="number" class="form-control gol5" id="antusiasme" name="antusiasme"
                                        min=1 max=5 required></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><b>Tanggung Jawab</b></td>
                                <td>Mempunyai tanggung jawab penuh dilingkungan pekerjaannya. tingkat kemampuan untuk
                                    melakukan
                                    pekerjaannya sendiri.
                                    melakukan pekerjaannya sendiri dengan antusias dan aktif disebut "ber tanggung
                                    jawab".
                                </td>
                                <td><input type="number" class="form-control gol5" id="tanggung_jawab"
                                        name="tanggung_jawab" min=1 max=5 required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Point 5</a> = Tidak ada karyawan lain yang lebih
                        menonjol
                        dan unggul darinya
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 4</a> = Excellent</i><br>
                    <i style="font-size: small;"><a style="color:red;">Point 3</a> = Mengerjakan tanpa masalah dan tidak
                        ada
                        masalah khusus
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 2</a> = Ada beberapa poin yang membutuhkan
                        pendidikan dan pelatihan
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 1</a> = Masih memerlukan pendidikan yang
                        memadai
                    </i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r5" style="margin-right: 50px">0</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row justify-content-center">
                <div class="text-center">

                    <label for="">Rank : </label>

                    <h2 id="rank">A</h2>
                </div>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-header">
            <a href="{{url('/PDF/Pedoman Penilaian Leader Up.pdf')}}" target="_blank">
                <i class="fas fa-file-pdf nav-icon"> <u> Pedoman Penilaian</u></i>
            </a>
            <button type="submit" class="btn btn-primary float-right">Simpan</button>
        </div>
        <!-- /.card-header -->
    </div>
</form>
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

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var dept = "{{Session::get('dept')}}";
        $("#nik").prop("disabled", "disabled");
        $("#nik").change(function () {
            var noinduk = $(this).children("option:selected").html();
            var namaoperator = $(this).children("option:selected").val();
            var dept = $(this).children("option:selected").val();
            var per = $("#periode").val();
            $("#nonik").val(noinduk);
            $("#nama").val(namaoperator);
            $("#departemen").val(dept);

            $.ajax({
                type: "POST",
                url: APP_URL + "/api/getklas",
                headers: { "token_req": key },
                data: { "nonik": noinduk, "periode": per },
                dataType: "json",
            })
                .done(function (resp) {
                    $("#kedisiplinan").val(resp.hasil);
                    $("#prosentase").html(resp.prosentase);
                    $("#prosentase_dept").html(resp.prosentase_dept);
                    $("#jenis").val(resp.jenis);
                    $("#improvement").val(resp.poinkaizen);
                    $("#ss").html(resp.ss);
                    $("#hh").html(resp.hh);
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $("#periode").change(function () {
            ambilNik($(this).val(), key);
            $("#nik").prop("disabled", false);
        });
        $(".gol1").on("change paste keyup", function () {
            var g = parseFloat($(this).val());
            if (g > 5) {
                alert('Nilai maksimal adalah 5 !');
                $(this).val(1);
            } else {
                var g1 = 0;
                var y = 0;
                var ind1 = 0;
                $(".gol1").each(function () {
                    if ($(this).val() != '') {
                        y = parseFloat($(this).val());
                    } else {
                        y = 0;
                    }
                    g1 = g1 + y;
                    ind1 = ind1 + 1;

                });
                var b1 = g1 / ind1;
                $("#r1").html(b1.toFixed(2));
                var r1 = parseFloat($("#r1").html());
                var r2 = parseFloat($("#r2").html());
                var r3 = parseFloat($("#pengetahuan").val())
                var r4 = parseFloat($("#r4").html());
                var r5 = parseFloat($("#r5").html());
                var j = $("#jenis").val();
                var kl = akumulasi(r1, r2, r3, r4, r5, j);
                $("#rank").html(kl);
                //console.log(r1.toFixed(2));
            }
        });
        $(".gol2").on("change paste keyup", function () {
            var g = parseFloat($(this).val());
            if (g > 5) {
                alert('Nilai maksimal adalah 5 !');
                $(this).val(1);
            } else {
                var g1 = 0;
                var y = 0;
                var ind1 = 0;
                $(".gol2").each(function () {
                    if ($(this).val() != '') {
                        y = parseFloat($(this).val());
                    } else {
                        y = 0;
                    }
                    g1 = g1 + y;
                    ind1 = ind1 + 1;

                });
                var b1 = g1 / ind1;
                $("#r2").html(b1.toFixed(2));
                var r1 = parseFloat($("#r1").html());
                var r2 = b1.toFixed(2);
                var r3 = parseFloat($("#pengetahuan").val())
                var r4 = parseFloat($("#r4").html());
                var r5 = parseFloat($("#r5").html());
                var j = $("#jenis").val();
                var kl = akumulasi(r1, r2, r3, r4, r5, j);
                $("#rank").html(kl);
                //console.log(r1.toFixed(2));
            }
        });

        $("#pengetahuan").on("change paste keyup", function () {
            var g = parseFloat($(this).val());
            if (g > 5) {
                alert('Nilai maksimal adalah 5 !');
                $(this).val(1);
            } else {
                var g1 = 0;
                var y = 0;

                if ($(this).val() != '') {
                    y = parseFloat($(this).val());
                } else {
                    y = 0;
                }

                var r1 = parseFloat($("#r1").html());
                var r2 = parseFloat($("#r2").html());
                var r3 = y;
                var r4 = parseFloat($("#r4").html());
                var r5 = parseFloat($("#r5").html());
                var j = $("#jenis").val();
                var kl = akumulasi(r1, r2, r3, r4, r5, j);
                $("#rank").html(kl);
            }
        });
        $(".gol4").on("change paste keyup", function () {
            var g = parseFloat($(this).val());
            if (g > 5) {
                alert('Nilai maksimal adalah 5 !');
                $(this).val(1);
            } else {
                var g1 = 0;
                var y = 0;
                var ind1 = 0;
                $(".gol4").each(function () {
                    if ($(this).val() != '') {
                        y = parseFloat($(this).val());
                    } else {
                        y = 0;
                    }
                    g1 = g1 + y;
                    ind1 = ind1 + 1;

                });
                var b1 = g1 / ind1;
                $("#r4").html(b1.toFixed(2));
                var r1 = parseFloat($("#r1").html());
                var r2 = parseFloat($("#r2").html());
                var r3 = parseFloat($("#pengetahuan").val())
                var r4 = b1.toFixed(2);
                var r5 = parseFloat($("#r5").html());
                var j = $("#jenis").val();
                var kl = akumulasi(r1, r2, r3, r4, r5, j);
                $("#rank").html(kl);
                //console.log(r1.toFixed(2));
            }
        });
        $(".gol5").on("change paste keyup", function () {
            var g = parseFloat($(this).val());
            if (g > 5) {
                alert('Nilai maksimal adalah 5 !');
                $(this).val(1);
            } else {
                var g1 = 0;
                var y = 0;
                var ind1 = 0;
                $(".gol5").each(function () {
                    if ($(this).val() != '') {
                        y = parseFloat($(this).val());
                    } else {
                        y = 0;
                    }
                    g1 = g1 + y;
                    ind1 = ind1 + 1;

                });
                var b1 = g1 / ind1;
                $("#r5").html(b1.toFixed(2));
                var r1 = parseFloat($("#r1").html());
                var r2 = parseFloat($("#r2").html());
                var r3 = parseFloat($("#pengetahuan").val());
                var r4 = parseFloat($("#r4").html());
                var r5 = b1.toFixed(2);
                var j = $("#jenis").val();
                var kl = akumulasi(r1, r2, r3, r4, r5, j);
                $("#rank").html(kl);
                //console.log(r1.toFixed(2));
            }
        });
    });

    function akumulasi(r1, r2, r3, r4, r5, j) {
        var k1 = parseFloat(r1);
        var k2 = parseFloat(r2);
        var k3 = parseFloat(r3);
        var k4 = parseFloat(r4);
        var k5 = parseFloat(r5);
        var tot = 0;
        if (j == 'indirect') {
            tot = ((k1 * 0.1 * 20) + (k2 * 0.25 * 20) + (k3 * 0.1 * 20) + (k4 * 0.25 * 20) + (k5 * 0.3 * 20));
        } else {

            tot = ((k1 * 0.3 * 20) + (k2 * 0.25 * 20) + (k3 * 0.05 * 20) + (k4 * 0.1 * 20) + (k5 * 0.3 * 20));
        }
        if (tot >= 86) {
            return "S";
        } else if (tot >= 71) {
            return "A";
        } else if (tot >= 51) {
            return "B";
        } else if (tot >= 35) {
            return "C";
        } else {
            return "D";
        }
    }

    function ambilNik(periode, key) {
        $("#nik").empty();
        $("#nik").append("<option>PILIH NIK</option>")
        $.ajax({
            type: "POST",
            url: APP_URL + "/api/ambilnik",
            headers: { "token_req": key },
            data: { "periode": periode, "mode": "atasan", "type": "Performance" },
            dataType: "json",
        })
            .done(function (resp) {

                for (var i in resp) {
                    $("#nik").append(new Option(resp[i].nik, resp[i].nama));

                }

            })
            .fail(function () {
                alert('Gagal koenksi ke server');

            });
    }

</script>
@endsection