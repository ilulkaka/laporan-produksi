<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Form Request Jigu</title>
</head>

<body>
    <style type="text/css">
        table tr td {
            font-size: 12pt;
            padding: 10px;
        }


        table tr th {
            font-size: 12pt;
            padding: 7px;

        }

        table {
            border-collapse: collapse
        }

        caption {
            padding-top: .75rem;
            padding-bottom: .75rem;
            color: #6c757d;
            text-align: left;
            caption-side: bottom
        }

        th {
            text-align: inherit
        }

        label {
            display: inline-block;
            margin-bottom: .5rem
        }
    </style>

    <table>
        <tr>
            <td width="70" align="left"><img src="assets\img\npmi.jpg" width="70%"></td>
            <td width="525" align="center">
                <h2>REQUEST JIGU</h2>
            </td>
            <hr>
        </tr>
    </table>
    @foreach ($nourut as $l)
    <div class="row">
        <div class="col-12">
            <b style="font-size: small;">FROM : </b><small style="font-size: small;">{{Session::get('dept')}}</small>
            <small style="font-size: small;float: right;">Issue Date : {{date('d M Y H:m:s')}} </small>
            <br>
            <b style="font-size: small;">Type Request :</b> <small style="font-size: small;">Out Of Stock</small><small
                style="font-size: small;float: right;">WareHouse Dept</small> <br>
            <b style="font-size: small;">Request Date :</b> <small style="font-size: small;"> {{date('d M Y')}}</small>
            <small style="font-size: small;float: right;">Scan : {!!
                QrCode::size(60)->generate($l->id_requestjigu_manual);
                !!}</small>
        </div>
        <!-- /.col -->
    </div>
    <br>
    <br>
    <br>

    <table border="1" align="center" width="550" style="margin-top: 10px;">
        <thead style="text-align: center;">


            <tr>
                <th>No. Drawing</th>
                <th>Machine</th>
                <th>Jigu</th>
                <th>Kigou / Size</th>
                <th>Qty</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>{{$l->kode_gambar}}</td>
                <td>{{$l->nama_mesin}}</td>
                <td>{{$l->nama_jigu}}</td>
                <td>{{$l->kigou}} / {{$l->ukuran}}</td>
                <td>{{number_format($l->qty,0)}}</td>
            </tr>
        </tbody>
    </table>

    <table border="1" align="center" width="550" style="margin-top: 10px;">
        <tbody>

            <tr>
                <td colspan="2"><b>Reason :</b> Out of Stock</td>
                <td>User : {{$l->user}}</td>
            </tr>
            <tr>
                <td colspan="2"><b>No. Induk :</b> </td>
                <td width="130" rowspan="2">Leader / Foreman : <br> {{Session::get('name')}} </td>
            </tr>
            <tr>
                <td colspan="2"><b>Location : </b></td>
            </tr>
        </tbody>
    </table>

    <table align="right" border="0" width="525" cellspacing="3" cellpadding="3">
        <tr>
            <td align="right" width="320">Operator QA</td>
            <td align="right"> || </td>
            <td align="left" width="170">Operator WH </td>
    </table>
    <br>
    <br>
    <br>
    <font size="1">No. Form : FM/TCH/043/15C</font>
    <br>
    <font size="1">No. Rev : 04</font>
    <br>
    <br>

</body>
@endforeach

<table>
    <tr>
        <td width="70" align="left"><img src="assets\img\npmi.jpg" width="70%"></td>
        <td width="525" align="center">
            <h2>REQUEST JIGU</h2>
        </td>
        <hr>
    </tr>
</table>
@foreach ($nourut as $l)
<div class="row">
    <div class="col-12">
        <b style="font-size: small;">FROM : </b><small style="font-size: small;">{{Session::get('dept')}}</small>
        <small style="font-size: small;float: right;">Issue Date : {{date('d M Y H:m:s')}} </small>
        <br>
        <b style="font-size: small;">Type Request :</b> <small style="font-size: small;">Out Of Stock</small><small
            style="font-size: small;float: right;">QA Dept</small> <br>
        <b style="font-size: small;">Request Date :</b> <small style="font-size: small;"> {{date('d M Y')}}</small>
        <small style="font-size: small;float: right;">Scan : {!!
            QrCode::size(60)->generate($l->id_requestjigu_manual);
            !!}</small>
    </div>
    <!-- /.col -->
</div>
<br>
<br>
<br>

<table border="1" align="center" width="550" style="margin-top: 10px;">
    <thead style="text-align: center;">


        <tr>
            <th>No. Drawing</th>
            <th>Machine</th>
            <th>Jigu</th>
            <th>Kigou / Size</th>
            <th>Qty</th>
        </tr>

    </thead>
    <tbody>
        <tr>
            <td>{{$l->kode_gambar}}</td>
            <td>{{$l->nama_mesin}}</td>
            <td>{{$l->nama_jigu}}</td>
            <td>{{$l->kigou}} / {{$l->ukuran}}</td>
            <td>{{number_format($l->qty,0)}}</td>
        </tr>
    </tbody>
</table>

<table border="1" align="center" width="550" style="margin-top: 10px;">
    <tbody>

        <tr>
            <td colspan="2"><b>Reason :</b> Out of Stock</td>
            <td>User : {{$l->user}}</td>
        </tr>
        <tr>
            <td colspan="2"><b>No. Induk :</b> </td>
            <td width="130" rowspan="2">Leader / Foreman : <br> {{Session::get('name')}} </td>
        </tr>
        <tr>
            <td colspan="2"><b>Location : </b></td>
        </tr>
    </tbody>
</table>

<table align="right" border="0" width="525" cellspacing="3" cellpadding="3">
    <tr>
        <td align="right" width="320">Operator WH</td>
        <td align="right"> || </td>
        <td align="left" width="170">NOUKI </td>
</table>
<br>
<br>
<br>
<font size="1">No. Form : FM/TCH/043/15C</font>
<br>
<font size="1">No. Rev : 04</font>
<br>
<br>

@endforeach

</html>