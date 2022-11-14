<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SS selesai dikerjakan</title>
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
      bottom: 10px;
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

    <!--
    <table>
        <tr>
            <td>
                <h5 style="position: fixed; margin-top: 0px;">DAFTAR PENERIMA HADIAH (SUMBANG SARAN)</h5>
            </td>
        </tr>
    </table>
    <br>
    <div class="row">
        <div class="col-12">
            <b style="font-size: small;">FROM : </b><small style="font-size: small;"></small>
            <small style="font-size: small;float: right;">Tanggal Permintaan :
            </small>
            <br>
            <b style="font-size: small;">No. Permintaan :</b> <small style="font-size: small;"></small> <br>
            <b style="font-size: small;">Permintaan :</b> <small style="font-size: small;"></small>
        </div>
    </div>-->

    <div class="row">
        <div class="col-12">
            <b style="font-size: small;">DAFTAR PENERIMA HADIAH (SUMBANG SARAN) </b><small
                style="font-size: small;"></small>
            <small style="font-size:x-small;float: right; color:black;"><i> Print Date :
                    {{$printdate}}</i>
            </small>
            <br>
        </div>
    </div>


    <table class="table1">
        <thead>
            <tr>
                <th style="font-size:x-small;">No</th>
                <th style="font-size:x-small;">No Ide</th>
                <th style="font-size:x-small;">Tgl Dibuat</th>
                <th style="font-size:x-small;">Nama</th>
                <th style="font-size:x-small;">NIK</th>
                <th style="font-size:x-small;">Section</th>
                <th style="font-size:x-small;">Tema Ide</th>
                <th style="font-size:x-small;">Tujuan</th>
                <th style="font-size:x-small;">Point</th>
                <th style="font-size:x-small;">Reward</th>
            </tr>

        </thead>
        <tbody>
            <?php $no = 0;?>
            @foreach ($insentif1 as $i)
            <?php $no++ ;?>
            <tr>
                <td style="font-size:xx-small;">{{$no}}</td>
                <td style=" font-size:xx-small;">{{$i->no_ss}}</td>
                <td style=" font-size:xx-small;">{{$i->tgl_penyerahan}}</td>
                <td style=" font-size:xx-small;">{{$i->nama}}</td>
                <td style=" font-size:xx-small;">{{$i->nik}}</td>
                <td style="font-size:xx-small;">{{$i->bagian}}</td>
                <td style="font-size:xx-small;">{{$i->tema_ss}}</td>
                <td style=" font-size:xx-small;">{{$i->tujuan_ss}}</td>
                <td style=" font-size:xx-small;">{{$i->poin_ss}}</td>
                <td style=" font-size:xx-small;">{{$i->reward}}</td>
            </tr>
            @endforeach


        </tbody>
    </table>

    <br>

    <div class="col col-md-4" style="float: left;">
        <table cellspacing="1" bgcolor="#BDB9B8" style="margin-left:25px">
            <tr bgcolor="#ffffff">
                <th style="font-size: x-small; width: 100px; ">Diterima Oleh</th>
            </tr>
            <tbody>
                <tr bgcolor="#ffffff">
                    <td style="height: 70px;"></td>
                </tr>
            </tbody>
        </table>
    </div>
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
                    <td style="height: 70px;"></td>
                    <td style="height: 70px;"></td>
                    <td style="height: 70px;"></td>
                </tr>
            </tbody>
        </table>
    </div>


    <div id="footer">
        <p class="page">Page </p>
    </div>

</body>

</html>