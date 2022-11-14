<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SS Masuk</title>
</head>

<body>

    <style type="css/text">
        .upper { text-transform: uppercase; }
        .lower { text-transform: lowercase; }
        .cap   { text-transform: capitalize; }
        .small { font-variant:   small-caps; }
        .table1 {
    font-family: sans-serif;
    color: #444;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid #f2f5f7;
}

.table1 tr th{
    background: #57acd1;
    color: #fff;
    font-weight: normal;
}

.table1, th, td {
    padding: 2px 0px;
    text-align: center;
    padding-bottom: 0px;
}

.table1 tr:hover {
    background-color: #f5f5f5;
}

.table1 tr:nth-child(even) {
    background-color: #d0d3d2e3;
}


    #footer {
      position: fixed;
      right: 0px;
      bottom: 5px;
      text-align: center;
      border-top: 1px solid black;
    }

    #footer .page:after {
      content: counter(page, decimal);
    }

    @page {
      margin: 20px 30px 40px 40px;
    }


    </style>

    <!--    <table>
        <tr>
            <td>
                <h5 style="position: fixed; margin-top: 0px;">DAFTAR KARYAWAN YANG MEMASUKKAN IDE SERTA STATUS IDE
                    <p style="text-align: left; margin-bottom: 0px;padding-bottom: 0px;">Periode :
                        {{date("d-M-Y",strtotime($tgl_awal))}} ~
                        {{date("d-M-Y",strtotime($tgl_akhir))}}
                </h5>
            </td>
        </tr>
    </table>
    -->

    <div class="row">
        <div class="col-12">
            <b style="font-size: small;">DAFTAR KARYAWAN YANG MEMASUKKAN IDE SERTA STATUS IDE </b><small
                style="font-size: small;"></small>
            <br>
            <b style="font-size: small;">Periode :
                {{date("d-M-Y",strtotime($tgl_awal))}} ~
                {{date("d-M-Y",strtotime($tgl_akhir))}}</b> <small style="font-size: small;"></small>
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
                <th style="font-size:x-small;">Nama</th>
                <th style="font-size:x-small;">NIK</th>
                <th style="font-size:x-small;">Level</th>
                <th style="font-size:x-small;">Dept</th>
                <th style="font-size:x-small;">Masuk</th>
                <th style="font-size:x-small;">Tunda</th>
                <th style="font-size:x-small; color: crimson;">Ditolak</th>
                <th style="font-size:x-small; color: yellow;">Pengerjaan</th>
                <th style="font-size:x-small; color: darkgreen;">Selesai</th>
            </tr>

        </thead>
        <tbody>
            <?php $no = 0;?>
            @foreach ($jumlahss as $f)
            <?php $no++ ;?>
            <tr>
                <td style=" font-size:xx-small;">{{$no}}</td>
                <td style=" text-align: left; font-size:xx-small;"> {{$f->NAMA}}</td>
                <td style=" font-size:xx-small;">{{$f->NIK}}</td>
                <td class="upper" style=" font-size:xx-small;">{{$f->nama_jabatan}}</td>
                <td class="upper" style=" font-size:xx-small;">{{$f->dept_section}}</td>
                @if ($f->Masuk + $f->ET1 == 0)
                <td style=" font-size:xx-small;"></td>
                @else
                <td style=" font-size:xx-small;">{{$f->Masuk + $f->ET1}}</td>
                @endif
                <td style=" font-size:xx-small;">{{$f->Tunda}}</td>
                <td style=" font-size:xx-small; color: crimson;">{{$f->Ditolak}}</td>
                @if ($f->Pengerjaan + $f->ET2 == 0)
                <td style=" font-size:xx-small;"></td>
                @else
                <td style=" font-size:xx-small;">{{number_format ($f->Pengerjaan + $f->ET2)}}</td>
                @endif
                <td style=" font-size:xx-small; color: darkgreen;">{{$f->Selesai}}</td>
                @endforeach
            </tr>



        </tbody>
    </table>

    <!--
    <div id="footer">
        <p class="page">Page </p>
    </div>
    -->

</body>

</html>