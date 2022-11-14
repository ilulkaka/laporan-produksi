<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laporan Pelatihan Eksternal</title>
</head>


<body>
    <style type="css/text">
        .table1 {
    font-family: sans-serif;
    color: #444;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #f2f5f7;
}

.table1 tr th{
    background: #a6afb3;
    color: #fff;
    font-weight: normal;
}


.table1, th, td {
    padding: 5px 5px;
    text-align: center;
}

.table1 tr:hover {
    background-color: #f5f5f5;
}

.table1 tr:nth-child(even) {
    background-color: #f2f2f2;
}


    #footer {
      position: fixed;
      right: 0px;
      bottom: 170px;
      text-align: center;
      border-top: 1px solid black;
    }

    #footer .page:after {
      content: counter(page, decimal);
    }

    @page {
      margin: 20px 30px 40px 50px;
    }


    </style>


    <table>
        <tr>
            <td width="70" align="left" style="padding: -0%;"><img src="assets\img\npmi.jpg" width="70%"></td>
            <td width="350" align="center">
                <h2 style="padding: -0%;"><u> Laporan Pelatihan Eksternal </u></h2>
            </td>
            <hr>
        </tr>
    </table>

    <div class="row">

        <div class="col-12">

            <div class="col col-md-12" style="float: left;">
                <table cellspacing="1" bgcolor="white" style="margin-right:20px; position: relative;">
                    <thead>
                        <tr bgcolor="#ffffff">
                            <th style=" width: 100px; text-align: left; " colspan="2">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr bgcolor="#ffffff">
                            <td style="height: 1%; text-align: left;"><b>NIK<br>NAMA</b>
                            </td>
                            <td style="height: -15%; text-align: right;">:<br>:<br></td>
                            <td style="height: 1%; text-align: left;">{{$list->nik}} <br>{{$list->nama}}
                            </td>
                        </tr>
                    </tbody>

                    <tbody>
                        <tr bgcolor="#ffffff">
                            <td style="height: 1%; text-align: left;"><b>Materi Pelatihan<br>Penyelenggara<br>Tempat
                                    Pelatihan<br>Instruktur</b>
                            </td>
                            <td style="height: -15%; text-align: right;">:<br>:<br>:<br>:</td>
                            <td style="height: 1%; text-align: left;">{{$list->materi_pelatihan}} <br>
                                {{$list->penyelenggara}} <br>{{$list->tempat_pelatihan}} <br> {{$list->instruktur}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p></p>
            <br>

            <b style="font-size: small;"></b><small style="font-size: small; "></small>
            <small style="font-size: small;float: right;">Rencana Mulai :
                {{$list->tgl_pelatihan}}</small>
            <br>
            <b style="font-size: small;"></b> <small style="font-size: small;"></small>
            <small style="font-size: small;float: right;">Rencana Selesai :
                {{$list->sampai}}</small>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <p style="padding-left: 6px;">
                <b style="font-size: small;">Point Pelatihan :</b>
                <textarea style="font-size: small;">{{$list->poin_pelatihan}}</textarea>

                <b style="font-size: small;">Kesan/Pendapat Pelatihan :</b>
                <textarea style="font-size: small;">{{$list->pendapat}}</textarea>

                <b style="font-size: small;">Bentuk Pengayaan Pribadi :</b>
                <textarea style="font-size: small;">{{$list->bentuk_pengayaan}}</textarea>

                <b style="font-size: small;">Diaplikasikan untuk :</b>
                <textarea style="font-size: small;">{{$list->diaplikasikan_untuk}}</textarea>

                <b style="font-size: small;">Komentar Atasan :</b>
                <textarea style="font-size: small;">{{$list->komentar_atasan}}</textarea>
            </p>

            <div class="col col-md-12" style="float: left;">
                <table cellspacing="1" bgcolor="white" style="margin-right:20px; position: relative;">
                    <thead>
                        <tr bgcolor="#ffffff">
                            <th style=" width: 100px; text-align: left; " colspan="2">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr bgcolor="#ffffff">
                            <td style="height: 1%; text-align: left;"><b>1. Pelatihan yang diberikan sesuai dengan
                                    kebutuhan sehari-hari<br>
                                    2. Metode dan alat bantu pelatihan yang digunakan <br>
                                    3. Pemahaman pengajar terhadap materi yang diberikan <br>
                                    4. Cara pengajar mengajar/menjelaskan materi kepada peserta </b>
                            </td>
                            <td style="height: -15%; text-align: right;">:<br>:<br>:<br>:<br></td>
                            <td style="height: 1%; text-align: left;">{{$eval[0]->kebutuhan}} <br> {{$eval[0]->metode}}
                                <br>{{$eval[0]->pemahaman}} <br> {{$eval[0]->pengajar}}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <!--<table>
                    <tbody>
                        <tr bgcolor="#ffffff">
                            <td style="height: 1%; text-align: left;"><b>5. Kelebihan program pelatihan
                                    <br>
                                    6. Kekurangan program pelatihan </b>
                            </td>
                            <td style="height: -15%; text-align: left; padding-left: -5%;">:<br>:<br></td>
                            <td style="height: 1%; text-align: left;">{{$eval[0]->kelebihan}} <br>
                                {{$eval[0]->kekurangan}}

                            </td>
                        </tr>

                        <tr bgcolor="#ffffff">
                            <td style="height: 1%; text-align: left;"><b>7. Saran - saran dari peserta untuk perbaikan
                                </b>
                            </td>
                            <td style="height: -15%; text-align: left; padding-left: -5%;">:<br></td>
                            <td style="height: 1%; text-align: left;">{{$eval[0]->saran}}

                            </td>
                        </tr>
                    </tbody>
                </table>-->

                <b style="font-size: 16px; padding-left: 1%;">5. Kelebihan program pelatihan :</b><br>
                <input style="font-size: 16px; padding-left: 5%; text-align: left;">{{$eval[0]->kelebihan}}
                <br>
                <b style="font-size: 16px; padding-left: 1%;">6. Kekurangan program pelatihan :</b><br>
                <label style="font-size: 16px; padding-left: 5%;">{{$eval[0]->kekurangan}}</label>
                <br>
                <b style="font-size: 16px; padding-left: 1%;">7. Saran - saran dari peserta untuk perbaikan :</b><br>
                <label style="font-size: 16px; padding-left: 5%;">{{$eval[0]->saran}}</label>
            </div>

        </div>
        <!-- /.col -->
    </div>



    <br>

    <div id="footer">

        <!--<div class="col col-md-12" style="float: left;">
            <table cellspacing="1" bgcolor="white" style="margin-right:20px; position: relative;">
                <thead>
                    <tr bgcolor="#ffffff">
                        <th style=" width: 100px; text-align: left; " colspan="2"><u>Keterangan
                                Evaluasi</u>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr bgcolor="#ffffff">
                        <td style="height: 1%; text-align: right;">2 :<br> 1 :<br> <br>0 :</td>
                        <td style="height: 80px; text-align: left;">Dapat melakukan pekerjaan sendiri <br>Dapat
                            melakukan pekerjaan dengan
                            <br>
                            bertanya ke orang lain <br> Perlu dilakukan training kembali
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>-->
        <br>
        <div class="col col-md-4" style="float: right;">
            <table cellspacing="1" bgcolor="#BDB9B8" style="margin-right:20px; position: relative;">
                <thead>
                    <tr bgcolor="#ffffff">
                        <th style="font-size: x-small; width: 100px;">Disahkan</th>
                        <th style="font-size: x-small; width: 100px;">Dibuat</th>
                    </tr>
                </thead>

                <tbody>
                    <tr bgcolor="#ffffff">

                        <td style="height: 70px; font-size: x-small;"> {{$sign[0]->disahkan}} <br> <i
                                style="font-size: xx-small;"> {{$sign[0]->tgl_disahkan}} </i> <br><br> <i
                                style="font-size: xx-small;">Digital Sign</i> </td>
                        <td style="height: 70px; font-size: x-small;"> {{$sign[0]->dibuat}} <br> <i
                                style="font-size: xx-small;"> {{$sign[0]->tgl_dibuat}} </i> <br><br> <i
                                style="font-size: xx-small;">Digital Sign</i> </td>

                        <!--<td style="height: 70px;">Digital Sign Scan : {!! QrCode::size(60)->generate($l->no_induk);</td>-->
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br><br><br>
        <br><br>
        <br>
        <!--<p class="page" style="float: left;">Page
        </p>-->
        <small style="float: left;">No. Form : FM / GA / 022 / 15C</small>
        <br>
        <small style="float: left;">No. Rev : 01</small>

        <b style="font-size: small;"></b><small style="font-size: small; "></small>
        <small style="font-size: x-small;float: right; padding-right: 0%;"><i> Tanggal Cetak : {{$printdate}}
            </i></small>
    </div>
</body>


</html>