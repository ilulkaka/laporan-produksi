@extends('layout.main')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-address-book"></i>
                    List PKWT
                </h3>
            </div>

            <blockquote class="quote-secondary">
                <div class="row">
                    <label class="col-md-2"> Tanggal Habis Kontrak</label>
                    <input type="month" class="form-control rounded-0 col-md-2" id="tgl_habiskontrak" value="">
                    <br>
                    <button class="btn btn-primary form-control rounded-0 col-md-1" id="btn_reload"><i
                            class="fa fa-sync"></i></button>
                </div>
                <hr>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-wrap" id="tb_penilaian_pkwt">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th style="width: 130px;">Mulai Kontrak</th>
                                <th style="width: 130px;">Selesai Kontrak</th>
                                <th style="width: 15px; text-align: center;">Lama Kontrak</th>
                                <th style="width: 15px; text-align: center;">Kontrak Ke</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </blockquote>
            <div class="card-footer">
                <li class="nav-item float-right">
                    <a href="{{url('/PDF/Deskripsi Penilaian Karyawan Kontrak.pdf')}}" target="_blank">
                        <i class="fas fa-file-pdf nav-icon"> Deskripsi Penilaian Karyawan Kontrak</i>
                    </a>
                </li>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Penilaian PKWT (upp) -->
<div class="modal fade" id="modal_upp" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle" style="color:blue;"><b> Update Penilaian </b>
                    (PKWT)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>


            <div class="modal-body">
                <form id="form_upp" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <tbody>
                                <tr>
                                    <td style="width:22% ;">

                                        <input type="hidden" id="upp_idpkwt" name="upp_idpkwt"
                                            class="form-control rounded-0 col-md-7">
                                        <dir class="form-group" style="padding-left: 1%;">
                                            <div class="row">
                                                <div class="input-group">
                                                    <strong>NIK</strong>
                                                    <label style="padding-left: 15%;"> Nama</label>
                                                    <label style="padding-left:46%">Mulai Kontrak</label>
                                                    <label style="padding-left:7%">Selesai Kontrak</label>
                                                </div>
                                                <div class="input-group">
                                                    <label id="upp_nik1" name="upp_nik1"
                                                        style="text-align: center; color: green;"
                                                        class="form-control rounded-0 col-md-2"
                                                        placeholder="NIK"></label>
                                                    <label id="upp_nama1" name="upp_nama1" style="color: green;"
                                                        class="form-control rounded-0 col-md-8"
                                                        placeholder="NAMA"></label>
                                                    <label id="upp_mulai" name="upp_mulai" style="color: green;"
                                                        class="form-control rounded-0 col-md-2"
                                                        placeholder="NIK"></label>
                                                    <label id="upp_selesai" name="upp_selesai" style="color: green;"
                                                        class="form-control rounded-0 col-md-2"
                                                        placeholder="NAMA"></label>
                                                    <input type="hidden" id="upp_nik" name="upp_nik">
                                                    <input type="hidden" id="upp_nama" name="upp_nama">
                                                </div>
                                        </dir>
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    </div>

                    <hr>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>Unsur yang dinilai </b>(KPI)</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td><b>Inisiatif</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5.
                                                Komunikasi dengan rekan kerja dan atasan sangat baik <br>
                                                4. Jika ada masalah segera lapor <br>
                                                3. Jika ada masalah, ada laporan namun agak lambat <br>
                                                2. Jika ada masalah kadang-kadang melapor <br>
                                                1. Jika ada masalah sering tidak lapor </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_inisiatif" name="upp_inisiatif" value=""
                                                min="1" max="5" class="form-control rounded-0 col-md-12" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td><b>Kerjasama</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5.
                                                Sangat Baik <br>
                                                4. Baik <br>
                                                3. Rata-rata <br>
                                                2. Buruk <br>
                                                1. Sangat Buruk </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_kerjasama" name="upp_kerjasama"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td><b>Sumbang saran</b>
                                            <label></label><br>
                                        </td>
                                        <td style=" font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> SS : </i> <label id="upp_ss" name="upp_ss">0</label>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="hidden" id="upp_point_ss" name="upp_point_ss"
                                                class="form-control rounded-0 col-md-12">
                                            <input type="number" id="upp_point_ss1" name="upp_point_ss1"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td><b>Kiken Yochi</b>
                                            <label></label><br>
                                        </td>
                                        <td style=" font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> KY : </i><label id="upp_ky" name="upp_ky">0</label>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="hidden" id="upp_point_ky" name="upp_point_ky"
                                                class="form-control rounded-0 col-md-12">
                                            <input type="number" id="upp_point_ky1" name="upp_point_ky1"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>5.</td>
                                        <td><b>Kuantitas Kerja</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Kuantitas cepat dan tidak pernah membuat NG <br>
                                                4. Kuantitas Rata-rata mencapai 100% dari target <br>
                                                3. Kuantitas Rata-rata 80% dari target <br>
                                                2. Kuantitas Rata-rata 70% dari target <br>
                                                1. Kuantitas Rata-rata 60% dari target </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_kuantitas" name="upp_kuantitas"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>6.</td>
                                        <td><b>Kualitas Kerja</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Pekerjaan cepat dan tidak pernah membuat NG <br>
                                                4. Tidak pernah membuat NG <br>
                                                3. Pernah 1 kali membuat NG <= 50 Pcs <br>
                                                    2. 1 kali membuat produk NG yang berjumlah diatas 50 Pcs <br>
                                                    1. 2 kali membuat produk NG yang berjumlah > 50 Pcs / 1 kali klaim
                                                    Customer </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_kualitas" name="upp_kualitas"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>7.</td>
                                        <td><b>Absensi</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> Input dari PGA <br> </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="hidden" id="upp_absensi" name="upp_absensi"
                                                class="form-control rounded-0 col-md-12">
                                            <input type="number" id="upp_absensi1" name="upp_absensi1"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>8.</td>
                                        <td><b>Pulang Cepat / Datang Lambat</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> Input dari PGA <br> </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="hidden" id="upp_imp" name="upp_imp"
                                                class="form-control rounded-0 col-md-12">
                                            <input type="number" id="upp_imp1" name="upp_imp1"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>9.</td>
                                        <td><b>Ketaatan</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Dapat menjadi contoh bagi yang lain <br>
                                                4. Tepat waktu dan taat SOP dll <br>
                                                3. Cukup menjaga aturan setidaknya untuk dirinya sendiri <br>
                                                2. kadang-kadang banyak alasan jika diperintah atasan dan kadang-kadang
                                                tidak sesuai SOP <br>
                                                1. Pernah mendapat peringatan lisan dan sering tidak ikut perintah / SOP
                                            </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_ketaatan" name="upp_ketaatan"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>10.</td>
                                        <td><b>Perilaku</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> Sesuai pilihan jawaban <br> </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_perilaku" name="upp_perilaku"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>11.</td>
                                        <td><b>Motivasi</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Keterlibatan di perusahaan sangat tinggi, QCC <br>
                                                4. Memiliki perhatian cukup tinggi terhadap perusahaan <br>
                                                3. Cukup menjaga aturan setidaknya untuk dirinya sendiri <br>
                                                2. kadang-kadang Mengeluh <br>
                                                1. Sering mengeluh </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="upp_motivasi" name="upp_motivasi"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                required>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <tbody>
                                <tr>
                                    <div class="row col-md-12">
                                        <button type="button" class="btn btn-primary btn-flat col-md-3"
                                            id="btn_upp_ambil"><i class="fa fa-floppy-o"></i> Ambil data SS, KY,
                                            Absensi</button>
                                        <div class="col col-md-2">
                                            <strong>Total Point</strong>
                                            <input name="upp_total_point" id="upp_total_point"
                                                class="form-control rounded-0 col-md-10">
                                        </div>
                                        <div class="col-md-2">
                                            <strong>Standart</strong>
                                            <label style="color: red;">Minimal 40 Point</label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col col-md-3"><label>Keputusan</label></div>
                                        <label>:</label>
                                        <div class="col-12 col-sm-3">
                                            <div class="form-group">
                                                <select class="form-control rounded-0" name="upp_keputusan"
                                                    id="upp_keputusan">
                                                    <option value="">Pilih Jawaban ...</option>
                                                    <option value="Lanjut">Lanjut</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col col-md-3"><label>Catatan Tambahan</label></div>
                                        <label>:</label>
                                        <div class="col col-md-8">
                                            <textarea name="upp_catatan_tambahan" id="upp_catatan_tambahan"
                                                class="form-control rounded-0" cols="120" rows="2"></textarea>
                                        </div>
                                    </div>
                                </tr>
                            </tbody>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-primary btn-flat" id="btn_upp_update"><i
                            class="fa fa-floppy-o"></i> Update</button>
                    <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal"><i
                            class="fa fa-sign-out"></i> Close</button>

                </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal View Penilaian PKWT (vpp) -->
<div class="modal fade" id="modal_vpp" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl  modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle" style="color:blue;"><b> View Penilaian </b>
                    (PKWT)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>


            <div class="modal-body">
                <form id="form_vpp" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <tbody>
                                <tr>
                                    <td style="width:22% ;">

                                        <input type="hidden" id="vpp_idpkwt" name="vpp_idpkwt"
                                            class="form-control rounded-0 col-md-7">
                                        <dir class="form-group" style="padding-left: 1%;">
                                            <div class="row">
                                                <div class="input-group">
                                                    <strong>NIK</strong>
                                                    <label style="padding-left: 15%;"> Nama</label>
                                                    <label style="padding-left:46%">Mulai Kontrak</label>
                                                    <label style="padding-left:7%">Selesai Kontrak</label>
                                                </div>
                                                <div class="input-group">
                                                    <label id="vpp_nik1" name="vpp_nik1"
                                                        style="text-align: center; color: green;"
                                                        class="form-control rounded-0 col-md-2"
                                                        placeholder="NIK"></label>
                                                    <label id="vpp_nama1" name="vpp_nama1" style="color: green;"
                                                        class="form-control rounded-0 col-md-8"
                                                        placeholder="NAMA"></label>
                                                    <label id="vpp_mulai" name="vpp_mulai" style="color: green;"
                                                        class="form-control rounded-0 col-md-2"
                                                        placeholder="NIK"></label>
                                                    <label id="vpp_selesai" name="vpp_selesai" style="color: green;"
                                                        class="form-control rounded-0 col-md-2"
                                                        placeholder="NAMA"></label>
                                                    <input type="hidden" id="vpp_nik" name="vpp_nik">
                                                    <input type="hidden" id="vpp_nama" name="vpp_nama">
                                                </div>
                                        </dir>
                                    </td>
                                </tr>
                            </tbody>
                        </div>
                    </div>

                    <hr>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>Unsur yang dinilai </b>(KPI)</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td><b>Inisiatif</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5.
                                                Komunikasi dengan rekan kerja dan atasan sangat baik <br>
                                                4. Jika ada masalah segera lapor <br>
                                                3. Jika ada masalah, ada laporan namun agak lambat <br>
                                                2. Jika ada masalah kadang-kadang melapor <br>
                                                1. Jika ada masalah sering tidak lapor </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_inisiatif" name="vpp_inisiatif" value=""
                                                min="1" max="5" class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td><b>Kerjasama</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5.
                                                Sangat Baik <br>
                                                4. Baik <br>
                                                3. Rata-rata <br>
                                                2. Buruk <br>
                                                1. Sangat Buruk </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_kerjasama" name="vpp_kerjasama"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3.</td>
                                        <td><b>Sumbang saran</b>
                                            <label></label><br>
                                        </td>
                                        <td style=" font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> SS : </i> <label id="vpp_ss" name="vpp_ss">0</label>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_point_ss" name="vpp_point_ss"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4.</td>
                                        <td><b>Kiken Yochi</b>
                                            <label></label><br>
                                        </td>
                                        <td style=" font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> KY : </i><label id="vpp_ky" name="vpp_ky">0</label>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_point_ky" name="vpp_point_ky"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>5.</td>
                                        <td><b>Kuantitas Kerja</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Kuantitas cepat dan tidak pernah membuat NG <br>
                                                4. Kuantitas Rata-rata mencapai 100% dari target <br>
                                                3. Kuantitas Rata-rata 80% dari target <br>
                                                2. Kuantitas Rata-rata 70% dari target <br>
                                                1. Kuantitas Rata-rata 60% dari target </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_kuantitas" name="vpp_kuantitas"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>6.</td>
                                        <td><b>Kualitas Kerja</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Pekerjaan cepat dan tidak pernah membuat NG <br>
                                                4. Tidak pernah membuat NG <br>
                                                3. Pernah 1 kali membuat NG <= 50 Pcs <br>
                                                    2. 1 kali membuat produk NG yang berjumlah diatas 50 Pcs <br>
                                                    1. 2 kali membuat produk NG yang berjumlah > 50 Pcs / 1 kali klaim
                                                    Customer </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_kualitas" name="vpp_kualitas"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>7.</td>
                                        <td><b>Absensi</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> Input dari PGA <br> </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_absensi" name="vpp_absensi"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>8.</td>
                                        <td><b>Pulang Cepat / Datang Lambat</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> Input dari PGA <br> </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_imp" name="vpp_imp"
                                                class="form-control rounded-0 col-md-12" disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>9.</td>
                                        <td><b>Ketaatan</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Dapat menjadi contoh bagi yang lain <br>
                                                4. Tepat waktu dan taat SOP dll <br>
                                                3. Cukup menjaga aturan setidaknya untuk dirinya sendiri <br>
                                                2. kadang-kadang banyak alasan jika diperintah atasan dan kadang-kadang
                                                tidak sesuai SOP <br>
                                                1. Pernah mendapat peringatan lisan dan sering tidak ikut perintah / SOP
                                            </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_ketaatan" name="vpp_ketaatan"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>10.</td>
                                        <td><b>Perilaku</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> Sesuai pilihan jawaban <br> </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_perilaku" name="vpp_perilaku"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                disabled>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>11.</td>
                                        <td><b>Motivasi</b>
                                            <label></label><br>
                                        </td>
                                        <td
                                            style="font-size: small; font-family:'Courier New', Courier, monospace; color: brown;">
                                            <i> 5. Keterlibatan di perusahaan sangat tinggi, QCC <br>
                                                4. Memiliki perhatian cukup tinggi terhadap perusahaan <br>
                                                3. Cukup menjaga aturan setidaknya untuk dirinya sendiri <br>
                                                2. kadang-kadang Mengeluh <br>
                                                1. Sering mengeluh </i>
                                        </td>

                                        <td style="width:18% ;">
                                            <input type="number" id="vpp_motivasi" name="vpp_motivasi"
                                                class="form-control rounded-0 col-md-12" value="" min="1" max="5"
                                                disabled>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <tbody>
                                <tr>
                                    <div class="row col-md-12">
                                        <div class="col col-md-2">
                                            <strong>Total Point</strong>
                                            <label name="vpp_total_point" id="vpp_total_point"
                                                class="form-control rounded-0"></label>
                                            <strong style="color: red;">Minimal 40 Point</strong>
                                        </div>

                                        <div class="col col-md-2">
                                            <strong>Keputusan</strong>
                                            <label name="vpp_keputusan" id="vpp_keputusan"
                                                class="form-control rounded-0"></label>
                                        </div>

                                        <div class="col col-md-4">
                                            <strong>Penilai</strong>
                                            <label name="vpp_penilai" id="vpp_penilai"
                                                class="form-control rounded-0 col-md-12"></label>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col col-md-3"><label>Catatan Tambahan</label></div>
                                        <label>:</label>
                                        <div class="col col-md-8">
                                            <textarea name="vpp_catatan_tambahan" id="vpp_catatan_tambahan"
                                                class="form-control rounded-0" cols="120" rows="2" disabled></textarea>
                                        </div>
                                    </div>
                                </tr>
                            </tbody>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <div class="float-right ">
                    <button type="button" class="btn btn-block btn-outline-danger btn-flat" data-dismiss="modal"><i
                            class="fa fa-sign-out"></i> Close</button>

                </div>
                </form>

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
<script src="{{asset('/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>


<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4',
            tags: true,

        })
    })

    $(document).ready(function () {

        var key = localStorage.getItem('npr_token');
        var tgl_sekarang = new Date();

        var list_penilaian_pkwt = $('#tb_penilaian_pkwt').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: true,
            ajax: {
                url: APP_URL + '/api/pga/inquery_penilaian_pkwt',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.tgl_habiskontrak = $("#tgl_habiskontrak").val();
                }
            },
            columnDefs: [{
                targets: [0],
                visible: true,
                searchable: true
            },
            {
                targets: [6],
                data: null,
                render: function (data, type, row, meta) {
                    if (data.nilai_pkwt == 'Y') {
                        return "<button type='button' class='btn btn-block btn-outline-success btn-flat btn-xs'>View</button>";
                    } else {
                        return "<button type='button' class='btn btn-block btn-outline-primary btn-flat btn-xs'>Penilaian</button>";
                    }
                }
            },
            ],

            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'mulai_kontrak', name: 'mulai_kontrak' },
                { data: 'selesai_kontrak', name: 'selesai_kontrak' },
                { data: 'lama_kontrak', name: 'lama_kontrak', className: 'text-center', },
                { data: 'kontrak_ke', name: 'kontrak_ke', className: 'text-center', },
            ],
            /*fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                if (data.selesai_kontrak) {
                    $('td', nRow).css('background-color', '#ff9966');
                    $('td', nRow).css('color', 'White');
                }
            },*/
        });

        $("#btn_reload").click(function () {
            list_penilaian_pkwt.ajax.reload();
        });


        $('#tb_penilaian_pkwt').on('click', '.btn-outline-primary', function () {
            var data = list_penilaian_pkwt.row($(this).parents('tr')).data();
            $("#upp_idpkwt").val(data.id_pkwt);
            $("#upp_nik1").html(data.nik);
            $("#upp_nik").val(data.nik);
            $("#upp_nama1").html(data.nama);
            $("#upp_nama").val(data.nama);
            $("#upp_mulai").html(data.mulai_kontrak);
            $("#upp_selesai").html(data.selesai_kontrak);

            $("#modal_upp").modal('show');
        });

        $('#tb_penilaian_pkwt').on('click', '.btn-outline-success', function () {
            var data = list_penilaian_pkwt.row($(this).parents('tr')).data();
            $("#vpp_idpkwt").val(data.id_pkwt);
            $("#vpp_nik1").html(data.nik);
            $("#vpp_nik").val(data.nik);
            $("#vpp_nama1").html(data.nama);
            $("#vpp_nama").val(data.nama);
            $("#vpp_mulai").html(data.mulai_kontrak);
            $("#vpp_selesai").html(data.selesai_kontrak);
            get_penilaian(data.id_pkwt, key);
            $("#modal_vpp").modal('show');
        });

        $("#btn_upp_update").prop('disabled', true);

        $("#form_upp").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            var inisiatif = parseInt($("#upp_inisiatif").val());
            var kerjasama = parseInt($("#upp_kerjasama").val());
            var kuantitas = parseInt($("#upp_kuantitas").val());
            var kualitas = parseInt($("#upp_kualitas").val());
            var ketaatan = parseInt($("#upp_ketaatan").val());
            var perilaku = parseInt($("#upp_perilaku").val());
            var motivasi = parseInt($("#upp_motivasi").val());
            var ss = parseInt($("#upp_point_ss").val());
            var ky = parseInt($("#upp_point_ky").val());
            var absensi = parseInt($("#upp_absensi").val());
            var imp = parseInt($("#upp_imp").val());
            //alert(ss);
            var cek_total = (inisiatif + kerjasama + kuantitas + kualitas + ketaatan + perilaku + motivasi + ss + ky + absensi + imp);
            var cek_point = $("#upp_total_point").val();

            if (cek_total == cek_point) {
                $.ajax({
                    url: APP_URL + '/api/pga/form_upp',
                    headers: {
                        "token_req": key
                    },
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $("#modal_upp").modal('toggle');
                            list_penilaian_pkwt.ajax.reload();
                        } else {
                            alert(resp.message);
                        }
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    })
                    .always(function () {
                    });
            } else {
                alert('Problem Total Point, Klik Buton "Ambil data SS, KY, Absensi" .');
            }
        });

        $("#btn_upp_ambil").click(function () {
            var upp_idpkwt = $("#upp_idpkwt").val();
            var upp_nik = $("#upp_nik").val();
            var upp_mulai = $("#upp_mulai").html();
            var upp_selesai = $("#upp_selesai").html();

            var inisiatif = parseInt($("#upp_inisiatif").val());
            var kerjasama = parseInt($("#upp_kerjasama").val());
            var kuantitas = parseInt($("#upp_kuantitas").val());
            var kualitas = parseInt($("#upp_kualitas").val());
            var ketaatan = parseInt($("#upp_ketaatan").val());
            var perilaku = parseInt($("#upp_perilaku").val());
            var motivasi = parseInt($("#upp_motivasi").val());

            $("#btn_upp_update").prop('disabled', false);

            $.ajax({
                url: APP_URL + '/api/pga/btn_upp_ambil',
                headers: {
                    "token_req": key
                },
                type: 'POST',
                dataType: 'json',
                data: { 'upp_idpkwt': upp_idpkwt, 'upp_nik': upp_nik, 'upp_mulai': upp_mulai, 'upp_selesai': upp_selesai },
            })
                .done(function (resp) {
                    if (resp.success) {
                        $("#upp_absensi").val(resp.absen);
                        $("#upp_imp").val(resp.imp);
                        $("#upp_absensi1").val(resp.absen);
                        $("#upp_imp1").val(resp.imp);
                        $("#upp_ss").html(resp.ss);
                        $("#upp_point_ss").val(resp.point_ss);
                        $("#upp_point_ss1").val(resp.point_ss);
                        $("#upp_ky").html(resp.ky);
                        $("#upp_point_ky").val(resp.point_ky);
                        $("#upp_point_ky1").val(resp.point_ky);
                        $("#upp_total_point").val(resp.point_ss + resp.point_ky + resp.imp + resp.absen + inisiatif + kerjasama + kuantitas + kualitas + ketaatan + perilaku + motivasi);
                    } else {
                        alert(resp.message);
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                })
                .always(function () {
                });
        })

    });

    function get_penilaian(id, key) {
        $.ajax({
            url: APP_URL + '/api/pga/get_penilaian_view',
            headers: {
                "token_req": key
            },
            type: 'POST',
            dataType: 'json',
            data: { 'id_pkwt': id },
        })
            .done(function (resp) {
                if (resp.success) {
                    $("#vpp_inisiatif").val(resp.ini);
                    $("#vpp_kerjasama").val(resp.ker);
                    $("#vpp_kuantitas").val(resp.kuan);
                    $("#vpp_kualitas").val(resp.kual);
                    $("#vpp_absensi").val(resp.abs);
                    $("#vpp_imp").val(resp.imp);
                    $("#vpp_ketaatan").val(resp.ket);
                    $("#vpp_perilaku").val(resp.per);
                    $("#vpp_motivasi").val(resp.mot);
                    $("#vpp_point_ss").val(resp.ss);
                    $("#vpp_point_ky").val(resp.ky);
                    $("#vpp_total_point").html(resp.ini + resp.ker + resp.kuan + resp.kual + resp.imp + resp.abs + resp.ket + resp.per + resp.mot + resp.ss + resp.ky);
                    $("#vpp_keputusan").html(resp.kep);
                    $("#vpp_penilai").html(resp.penilai);
                    $("#vpp_catatan_tambahan").html(resp.cat_tam);
                } else {
                    alert(resp.message);
                }
            })
            .fail(function () {
                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

            })
            .always(function () {
            });
    }


</script>

@endsection