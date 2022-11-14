<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Evaluasi Pelatihan Eksternal Setelah tiga bulan</title>
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
                <h2 style="padding: -0%;"><u> Evaluasi Pelatihan Eksternal </u></h2>
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
                            <td style="height: 1%; text-align: left;"><b>1. Ada peningkatan skill setelah mengikuti
                                    training ? <br> </b>
                            </td>
                            @if ($eval3bln[0]->ada_peningkatan = 'Y')
                            <td style="height: -15%; text-align: left;">Ya<br></td>
                            <td style="height: 1%; text-align: left;"> <br>
                                @else
                            <td style="height: -15%; text-align: left;">Tidak<br></td>
                            <td style="height: 1%; text-align: left;"> <br>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <br>
            <br>

            <p style="padding-left: 6px;">
                <b style="font-size: 16px;">2. Skill kompetensi <u>Sebelum</u> mengikuti training ? </b>
                <textarea style="font-size: small;">{{$eval3bln[0]->skill_sebelum}}</textarea><br>

                <b style="font-size: 16px;">3. Skill kompetensi <u>Setelah</u> mengikuti training ? </b>
                <textarea style="font-size: small;">{{$eval3bln[0]->skill_sesudah}}</textarea><br>

                <b style="font-size: 16px;">4. Apakah hasil pelatihan dapat bermanfaat untuk pekerjaan ? dan
                    Apakah dapat dijadikan referensi ilmu pengetahuan ? </b>
                <textarea style="font-size: small;">{{$eval3bln[0]->hasil_pelatihan}}</textarea><br>

                <b style="font-size: 16px;">5. Saran / Usulan ? </b>
                <textarea style="font-size: small;">{{$eval3bln[0]->usulan}}</textarea>

            </p>

        </div>
        <!-- /.col -->
    </div>



    <br>

    <div id="footer">
        <br>
        <div class="col col-md-4" style="float: right;">
            <table cellspacing="1" bgcolor="#BDB9B8" style="margin-right:20px; position: relative;">
                <thead>
                    <tr bgcolor="#ffffff">
                        <th style="font-size: x-small; width: 100px;">Atasan Peserta</th>
                    </tr>
                </thead>

                <tbody>
                    <tr bgcolor="#ffffff">

                        <td style="height: 70px; font-size: x-small;"> {{$eval3bln[0]->atasan}} <br> <i
                                style="font-size: xx-small;">{{$eval3bln[0]->tgl_approve}} </i>
                            <br><br> <i style="font-size: xx-small;">Digital Sign</i>
                        </td>

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
        <small style="float: left;">No. Form : FM / GA / 007 / 15C</small>
        <br>
        <small style="float: left;">No. Rev : 02</small>

        <b style="font-size: small;"></b><small style="font-size: small; "></small>
        <small style="font-size: x-small;float: right; padding-right: 0%;"><i> Tanggal Cetak : {{$printdate}}
            </i></small>
    </div>
</body>


</html>