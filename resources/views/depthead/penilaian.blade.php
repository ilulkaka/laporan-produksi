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

<form action="{{url('depthead/input_penilaian')}}" method="post">
    {{csrf_field()}}
    <div class="row">

        <div class="card card-info col-12">
            <div class="card-header">

                <h3 class="card-title">Penilaian Entry</h3><br>
                <h6>Untuk Staff dan Operator</h6>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="periode">Periode</label>
                    <input type="month" class="form-control" name="periode" id="periode" placeholder="Periode" required>
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
                    <input type="text" class="form-control @error('nama')is-invalid @enderror" name="nama" id="nama"
                        placeholder="Nama Operator">
                </div>
                <div class="form-group col-md-3">
                    <input type="hidden" class="form-control @error('dept_group')is-invalid @enderror" name="departemen"
                        id="departemen" placeholder="departemen" required>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="height: 600px; overflow-y: auto;">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>1. Job Performance / Penilaian Kinerja</b> <i>(Tindakan tegas yang diambil
                            dalam
                            tugas
                            yang menjadi tanggung jawabnya)</i></h3>
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
                                <td><b>Dandori / Persiapan kerja</b></td>
                                <td>Apakah melaksanakan dandori secara efektif sesuai dengan standart yang sudah
                                    ditentukan, dan
                                    bekerja secara efisien?
                                    Apakah melakukan persiapan sebelum bekerja?
                                </td>
                                <td><input type="number" class="form-control gol1" id="dandori" name="dandori" min=1
                                        max=5 title="
                                            Point 5 = Dibandingkan dengan teman seangkatannya jauh lebih unggul. 
                                            Point 4 = Dibandingkan dengan teman seangkatannya lebih unggul.
                                            Point 3 = Mengerjakan tanpa masalah dan tidak ada masalah khusus.
                                            Point 2 = Ada sedikit masalah.
                                            Point 1 = Bermasalah." required>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>Kecepatan Kerja</b></td>
                                <td>Walaupun Misalnya tiba-tiba pekerjaan urgent datang atau jumlahnya bertambah, tetap
                                    bisa
                                    fokus
                                    bekerja dan dapat menyelesaikannya dalam tenggang waktu yang diharapkan.
                                </td>
                                <td><input type="number" class="form-control gol1" id="kecepatan" name="kecepatan" min=1
                                        max=5 title="
                                        Point 5 = Dibandingkan dengan teman seangkatannya jauh lebih unggul. 
                                        Point 4 = Dibandingkan dengan teman seangkatannya lebih unggul.
                                        Point 3 = Mengerjakan tanpa masalah dan tidak ada masalah khusus.
                                        Point 2 = Ada sedikit masalah.
                                        Point 1 = Bermasalah." required></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>Ketelitian / Akurasi Kerja</b></td>
                                <td>Apakah pekerjaan dilakukan sesuai dengan kriteria, tidak ada kesalahan dan secara
                                    konten/isi
                                    juga bagus?
                                </td>
                                <td><input type="number" class="form-control gol1" id="ketelitian" name="ketelitian"
                                        min=1 max=5 title="
                                        Point 5 = Dibandingkan dengan teman seangkatannya jauh lebih unggul. 
                                        Point 4 = Dibandingkan dengan teman seangkatannya lebih unggul.
                                        Point 3 = Mengerjakan tanpa masalah dan tidak ada masalah khusus.
                                        Point 2 = Ada sedikit masalah.
                                        Point 1 = Bermasalah." required></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><b>kaizen / Improvement</b></td>
                                <td>SS : <label id="ss" name="ss">Auto</label><br>
                                    KY : <label id="hh" name="hh">Auto</label>
                                </td>
                                <td><input type="number" class="form-control gol1" id="improvement" name="improvement"
                                        min=1 max=5 value="0" disabled></td>

                            </tr>
                            <tr>
                                <td>5.</td>
                                <td><b>Sikap Kerja - Manner</b></td>
                                <td>Apakah bersalam dengan baik, merespon dengan sikap yang menyenangkan, sopan santun?
                                    Apakah selalu memakai Alat pelindung yang ditentukan?
                                    Apakah selalu mematuhi 5S ?
                                </td>
                                <td><input type="number" class="form-control gol1" id="sikap_kerja" name="sikap_kerja"
                                        min=1 max=5 title="
                                        Point 5 = Dibandingkan dengan teman seangkatannya jauh lebih unggul. 
                                        Point 4 = Dibandingkan dengan teman seangkatannya lebih unggul.
                                        Point 3 = Mengerjakan tanpa masalah dan tidak ada masalah khusus.
                                        Point 2 = Ada sedikit masalah.
                                        Point 1 = Bermasalah." required></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td><b>Penyelesaian Masalah / Trouble</b></td>
                                <td>Apakah bila terjadi masalah, secepatnya menyelesaikannya dengan berkonsultasi dan
                                    mendapat
                                    instruksi dari atasan ?
                                </td>
                                <td><input type="number" class="form-control gol1" id="penyelesaian_masalah"
                                        name="penyelesaian_masalah" min=1 max=5 title="
                                            Point 5 = Dibandingkan dengan teman seangkatannya jauh lebih unggul. 
                                            Point 4 = Dibandingkan dengan teman seangkatannya lebih unggul.
                                            Point 3 = Mengerjakan tanpa masalah dan tidak ada masalah khusus.
                                            Point 2 = Ada sedikit masalah.
                                            Point 1 = Bermasalah." required></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td><b>Ho - Ren - So (Lapor - Kontak - Konsultasi)</b></td>
                                <td>Bukan hanya tentang waktu melapor saja, tapi juga dengan isi yang akurat dan
                                    ditambah
                                    dengan
                                    pemikiran atau ide sendiri.
                                </td>
                                <td><input type="number" class="form-control gol1" id="horenso" name="horenso" min=1
                                        max=5 title="
                                        Point 5 = Dibandingkan dengan teman seangkatannya jauh lebih unggul. 
                                        Point 4 = Dibandingkan dengan teman seangkatannya lebih unggul.
                                        Point 3 = Mengerjakan tanpa masalah dan tidak ada masalah khusus.
                                        Point 2 = Ada sedikit masalah.
                                        Point 1 = Bermasalah." required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Point 5</a> = Dibandingkan dengan teman
                        seangkatannya
                        <b>jauh</b> lebih
                        unggul ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 4</a> = Dibandingkan dengan teman
                        seangkatannya
                        <b>lebih</b> unggul</i><br>
                    <i style="font-size: small;"><a style="color:red;">Point 3</a> = Mengerjakan tanpa masalah dan tidak
                        ada
                        masalah
                        khusus ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 2</a> = Ada sedikit masalah ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 1</a> = Bermasalah</i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r1" style="margin-right: 50px">0</label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>2. CAPABILITY / Penilaian kemampuan</b> <i>(Apakah memiliki pengetahuan
                            dan
                            kemampuan
                            untuk
                            melakukan tugas yang menjadi tanggung jawabnya?)</i></h3>
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
                                <td>Apakah mempunyai Keterampilan dan pengetahuan teknis pekerjaannya?
                                    Apakah memiliki pengetahuan keahlian tentang mesin, keselamatan, kualitas yang
                                    diperlukan
                                    untuk
                                    menjalankannya.
                                </td>
                                <td><input type="number" class="form-control gol2" id="pengetahuan" name="pengetahuan"
                                        min=1 max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                           Point 4 = Excellent.
                                           Point 3 = Level dimana pekerjaan dilakukan tanpa masalah .
                                           Point 2 = Ada beberapa poin yang memerlukan diklat.
                                           Point 1 = Masih banyak memerlukan pelatihan." required></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>kemampuan memahami, memutuskan</b></td>
                                <td>Apakah mempunyai kemampuan memahami dan memutuskan?
                                    Apakah dapat memahami suatu hal dengan benar, dapat memberikan kesimpulan dengan
                                    cepat
                                    dengan
                                    tindakan tepat?
                                </td>
                                <td><input type="number" class="form-control gol3" id="keputusan" name="keputusan" min=1
                                        max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                        Point 4 = Excellent.
                                        Point 3 = Level dimana pekerjaan dilakukan tanpa masalah .
                                        Point 2 = Ada beberapa poin yang memerlukan diklat.
                                        Point 1 = Masih banyak memerlukan pelatihan." required></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>kemampuan mengekpresikan</b></td>
                                <td>Apakah mempunyai kemampuan memahami dan memutuskan?
                                    Apakah dapat memahami suatu hal dengan benar, dapat memberikan kesimpulan dengan
                                    cepat
                                    dengan
                                    tindakan tepat?
                                </td>
                                <td><input type="number" class="form-control gol3" id="eskpresi" name="ekspresi" min=1
                                        max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                        Point 4 = Excellent.
                                        Point 3 = Level dimana pekerjaan dilakukan tanpa masalah .
                                        Point 2 = Ada beberapa poin yang memerlukan diklat.
                                        Point 1 = Masih banyak memerlukan pelatihan." required></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td><b>kemampuan merencanakan</b></td>
                                <td>Apakah mempunyai kemampuan mengumpulkan informasi?
                                    Apakah mempunyai kemampuan merencanakan pekerjaan yang akan dilaksanakan, dan
                                    bekerja
                                    sesuai
                                    prosedur?
                                </td>
                                <td><input type="number" class="form-control gol3" id="perencanaan" name="perencanaan"
                                        min=1 max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                        Point 4 = Excellent.
                                        Point 3 = Level dimana pekerjaan dilakukan tanpa masalah .
                                        Point 2 = Ada beberapa poin yang memerlukan diklat.
                                        Point 1 = Masih banyak memerlukan pelatihan." required></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td><b>kemampuan fisik dan mental dalam merespon</b></td>
                                <td>Apakah mempunyai kemampuan untuk tidak abai pada masalah, bekerja lebih keras dan
                                    fokus?
                                </td>
                                <td><input type="number" class="form-control gol3" id="respon" name="respon" min=1 max=5
                                        title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                        Point 4 = Excellent.
                                        Point 3 = Level dimana pekerjaan dilakukan tanpa masalah .
                                        Point 2 = Ada beberapa poin yang memerlukan diklat.
                                        Point 1 = Masih banyak memerlukan pelatihan." required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Point 5</a> = Sangat Excellent dan tidak ada
                        orang
                        lain
                        yang
                        mengalahkan ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 4</a> = Excellent</i><br>
                    <i style="font-size: small;"><a style="color:red;">Point 3</a> = Level dimana pekerjaan dilakukan
                        tanpa
                        masalah
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 2</a> = Ada beberapa poin yang memerlukan
                        diklat
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 1</a> = Masih banyak memerlukan
                        pelatihan</i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r2" style="margin-right: 50px">0</label>
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

                                <td><input type="number" class="form-control gol4" id="kedisiplinan" name="kedisiplinan"
                                        value="0" min=1 max=5 disabled>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td><b>kerja sama</b></td>
                                <td>diluar pekerjaan yang menjadi tanggung jawabnya, Apakah mempunyai tingkat motivasi
                                    untuk
                                    melakukan kegiatan positif dalam tim work, dan menyamakan visi dengan yang lainnya?
                                </td>
                                <td><input type="number" class="form-control gol4" id="kerjasama" name="kerjasama" min=1
                                        max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                        Point 4 = Excellent.
                                        Point 3 = Level dimana pekerjaan dilakukan tanpa masalah.
                                        Point 2 = Ada beberapa poin yang memerlukan diklat.
                                        Point 1 = Masih banyak memerlukan pelatihan." required></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td><b>Antusiasme</b></td>
                                <td>Melakukan kegiatan diluar ruang lingkup pekerjaannya dengan termotivasi.
                                    melakukan dengan sukarela perbaikan kerja, pengembangan diri, dan termotivasi untuk
                                    melakukan
                                    hal-hal baru (diluar pekerjaan yang diinstruksikan)
                                </td>
                                <td><input type="number" class="form-control gol4" id="antusiasme" name="antusiasme"
                                        min=1 max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                        Point 4 = Excellent.
                                        Point 3 = Level dimana pekerjaan dilakukan tanpa masalah.
                                        Point 2 = Ada beberapa poin yang memerlukan diklat.
                                        Point 1 = Masih banyak memerlukan pelatihan." required></td>
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
                                <td><input type="number" class="form-control gol4" id="tanggung_jawab"
                                        name="tanggung_jawab" min=1 max=5 title="Point 5 = Sangat Excellent dan tidak ada orang lain yang mengalahkan.
                                            Point 4 = Excellent.
                                            Point 3 = Level dimana pekerjaan dilakukan tanpa masalah.
                                            Point 2 = Ada beberapa poin yang memerlukan diklat.
                                            Point 1 = Masih banyak memerlukan pelatihan." required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <i style="font-size: small;"><a style="color:red;">Point 5</a> = Sangat Excellent dan tidak ada
                        orang
                        lain
                        yang
                        mengalahkan ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 4</a> = Excellent</i><br>
                    <i style="font-size: small;"><a style="color:red;">Point 3</a> = Level dimana pekerjaan dilakukan
                        tanpa
                        masalah
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 2</a> = Ada beberapa poin yang memerlukan
                        diklat
                        ||</i>
                    <i style="font-size: small;"><a style="color:red;">Point 1</a> = Masih banyak memerlukan
                        pelatihan</i>
                    <div class="row float-right">
                        <label for="">Rata-Rata : </label>
                        <label for="" id="r3" style="margin-right: 50px">0</label>
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
            <a href="{{url('/PDF/Pedoman Penilaian Karyawan Umum.pdf')}}" target="_blank">
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
                var r2 = parseFloat($("#pengetahuan").val())
                var r3 = parseFloat($("#r2").html());
                var r4 = parseFloat($("#r3").html());

                var kl = akumulasi(r1, r2, r3, r4);
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
                var r2 = y;
                var r3 = parseFloat($("#r2").html());
                var r4 = parseFloat($("#r3").html());

                var kl = akumulasi(r1, r2, r3, r4);
                $("#rank").html(kl);
            }
        });

        $(".gol3").on("change paste keyup", function () {
            var g = parseFloat($(this).val());
            if (g > 5) {
                alert('Nilai maksimal adalah 5 !');
                $(this).val(1);
            } else {
                var g1 = 0;
                var y = 0;
                var ind1 = 0;
                $(".gol3").each(function () {
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
                var r2 = parseFloat($("#pengetahuan").val())
                var r3 = parseFloat($("#r2").html());
                var r4 = parseFloat($("#r3").html());

                var kl = akumulasi(r1, r2, r3, r4);
                $("#rank").html(kl);
                //console.log(r1.toFixed(2));
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
                $("#r3").html(b1.toFixed(2));
                var r1 = parseFloat($("#r1").html());
                var r2 = parseFloat($("#pengetahuan").val())
                var r3 = parseFloat($("#r2").html());
                var r4 = parseFloat($("#r3").html());

                var kl = akumulasi(r1, r2, r3, r4);
                $("#rank").html(kl);
                //console.log(r1.toFixed(2));
            }
        });

    });

    function akumulasi(r1, r2, r3, r4) {
        var k1 = parseFloat(r1);
        var k2 = parseFloat(r2);
        var k3 = parseFloat(r3);
        var k4 = parseFloat(r4);
        var tot = ((k1 * 0.4 * 20) + (k2 * 0.1 * 20) + (k3 * 0.1 * 20) + (k4 * 0.4 * 20));
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
            data: { "periode": periode, "mode": "umum", "type": "Performance" },
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