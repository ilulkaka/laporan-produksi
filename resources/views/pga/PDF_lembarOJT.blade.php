<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laporan Pelatihan internal</title>
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
                <h2 style="padding: -0%;"><u> Laporan Pelatihan Internal </u></h2>
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
                            <td style="height: 1%; text-align: left;"><b>NIK<br>NAMA<br>Departemen<br>Lokasi
                                    Pelatihan</b>
                            </td>
                            <td style="height: -15%; text-align: right;">:<br>:<br>:<br>:</td>
                            <td style="height: 1%; text-align: left;">{{$list->nik}} <br>{{$list->nama}}
                                <br>
                                {{$list->dept_pelatihan}} <br> {{$list->loc_pelatihan}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p></p>
            <br>

            <b style="font-size: small;"></b><small style="font-size: small; "></small>
            <small style="font-size: small;float: right;">Rencana Mulai :
                {{$list->rencana_mulai}}</small>
            <br>
            <b style="font-size: small;"></b> <small style="font-size: small;"></small>
            <small style="font-size: small;float: right;">Rencana Selesai :
                {{$list->rencana_selesai}}</small>
            <br>
            <b style="font-size: small;"></b> <small style="font-size: small;"></small>
            <small style="font-size: small;float: right;">aktual Mulai :
                {{$list->aktual_mulai}}</small>
            <br>
            <b style="font-size: small;"></b> <small style="font-size: small;"></small>
            <small style="font-size: small;float: right;">aktual selesai :
                {{$list->aktual_selesai}}</small>

            <br>
            <br>
            <p>
                <b style="font-size: small;">Tema Pelatihan :</b> <textarea
                    style="font-size: small;">{{$list->tema_pelatihan}}</textarea>

                <b style="font-size: small;">Level Pelatihan :</b> <small
                    style="font-size: small;">{{$list->level_pelatihan}}</small>

            </p>

        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-12">
            <table border="1" align="center" width="525" style="margin-top: 10px;" cellspacing="0">
                <thead style="text-align: center;">


                    <tr>
                        <th>Isi dan Tujuan</th>
                        <th>Instruktur</th>
                        <th>Evaluasi</th>
                        <th>Catatan</th>
                        <th>Ttd Peserta</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($isi as $i)
                    <tr>
                        <td
                            style=" font-size:small; text-transform: capitalize; text-align: left; font-family: 'Courier New', Courier, monospace; ">
                            {{$i->isi_tujuan}}
                        </td>
                        <td style=" font-size:x-small; width: 15%; font-family: 'Courier New', Courier, monospace;">
                            {{$i->instruktur}}</td>
                        <td style=" font-size:x-small; width: 5%; font-family: 'Courier New', Courier, monospace;">
                            {{$i->evaluasi}}</td>
                        <td style=" font-size:x-small; width: 20%; font-family: 'Courier New', Courier, monospace;">
                            {{$i->catatan}}</td>
                        <td style=" font-size:xx-small; width: 10%; font-family: 'Courier New', Courier, monospace;">
                            Sign<br>{{$list->nik}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <br>

    <div id="footer">

        <div class="col col-md-12" style="float: left;">
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
                        <td style="height: 1%; text-align: right;">2 :<br> 1 :<br> <br>
                            <!--0 :-->
                        </td>
                        <td style="height: 80px; text-align: left;">Dapat melakukan pekerjaan sendiri <br>Dapat
                            melakukan pekerjaan dengan
                            <br>
                            bertanya ke orang lain <br>
                            <!--Perlu dilakukan training kembali-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <div class="col col-md-4" style="float: right;">
            <table cellspacing="1" bgcolor="#BDB9B8" style="margin-right:20px; position: relative;">
                <thead>
                    <tr bgcolor="#ffffff">
                        <th style="font-size: x-small; width: 100px;">Disahkan</th>
                        <th style="font-size: x-small; width: 100px;">Diperiksa</th>
                        <th style="font-size: x-small; width: 100px;">Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr bgcolor="#ffffff">
                        @foreach($sign as $s)
                        <td style="height: 70px; font-size: x-small;"> {{$s->disahkan}} <br> <i
                                style="font-size: xx-small;"> {{$s->tgl_disahkan}} </i> <br><br> <i
                                style="font-size: xx-small;">Digital Sign</i> </td>
                        <td style="height: 70px; font-size: x-small;"> {{$s->diperiksa}} <br> <i
                                style="font-size: xx-small;"> {{$s->tgl_diperiksa}} </i> <br><br> <i
                                style="font-size: xx-small;">Digital Sign</i> </td>
                        <td style="height: 70px; font-size: x-small;"> {{$s->dibuat}} <br> <i
                                style="font-size: xx-small;"> {{$s->tgl_dibuat}} </i> <br><br> <i
                                style="font-size: xx-small;">Digital Sign</i> </td>
                        @endforeach
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
        <small style="float: left;">No. Form : FM / GA / 019 / 15C</small>
        <br>
        <small style="float: left;">No. Rev : 02</small>

        <b style="font-size: small;"></b><small style="font-size: small; "></small>
        <small style="font-size: x-small;float: right; padding-right: 0%; padding-top: -13px;"><i> Tanggal buat rencana
                :
                {{$list->created_at}}
            </i></small><br>
        <small style="font-size: x-small;float: right; padding-right: 0%; padding-top: -13px;"><i> Tanggal Cetak :
                {{$printdate}}
            </i></small>
    </div>
</body>


</html>