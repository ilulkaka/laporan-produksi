<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>List Permintaan</title>
</head>


<body>
	<style type="text/css">
		table tr td {
			font-size: 12pt;
			padding: 10px;
		}


		table tr th {
			font-size: 11pt;
			padding: 7px;
			border-style: solid;
			align: center;
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

		button {
			border-radius: 0
		}

		button:focus {
			outline: 1px dotted;
			outline: 5px auto -webkit-focus-ring-color
		}

		button,
		input,
		optgroup,
		select,
		textarea {
			margin: 0;
			font-family: inherit;
			font-size: inherit;
			line-height: inherit
		}

		small {
			font-size: 80%
		}

		sub,
		sup {
			position: relative;
			font-size: 75%;
			line-height: 0;
			vertical-align: baseline
		}

		sub {
			bottom: -.25em
		}

		sup {
			top: -.5em
		}

		a {
			color: #007bff;
			text-decoration: none;
			background-color: transparent
		}

		a:hover {
			color: #0056b3;
			text-decoration: underline
		}

		a:not([href]):not([tabindex]) {
			color: inherit;
			text-decoration: none
		}

		a:not([href]):not([tabindex]):focus,
		a:not([href]):not([tabindex]):hover {
			color: inherit;
			text-decoration: none
		}

		a:not([href]):not([tabindex]):focus {
			outline: 0
		}

		code,
		kbd,
		pre,
		samp {
			font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
			font-size: 1em
		}

		pre {
			margin-top: 0;
			margin-bottom: 1rem;
			overflow: auto
		}

		figure {
			margin: 0 0 1rem
		}

		img {
			vertical-align: middle;
			border-style: none
		}

		svg {
			overflow: hidden;
			vertical-align: middle
		}
	</style>

	<table>
		<tr>
			<td width="70" align="left"><img src="assets\img\npmi.jpg" width="70%"></td>
			<td width="350" align="center">
				<h2>Permintaan Kerja</h2>
				<h4><a href="">Technical Engineering</a></h4>
			</td>
			<hr>
		</tr>
	</table>

	<div class="row">
		<div class="col-12">
			<b style="font-size: small;">FROM : </b><small style="font-size: small;">{{$list->dept}}</small>
			<small style="font-size: small;float: right;">Tanggal Permintaan :
				{{$list->tanggal_permintaan}}</small>
			<br>
			<b style="font-size: small;">No. Permintaan :</b> <small
				style="font-size: small;">{{$list->no_laporan}}</small> <br>
			<b style="font-size: small;">Permintaan :</b> <small style="font-size: small;">{{$list->permintaan}}</small>
		</div>
		<!-- /.col -->
	</div>
	<br>

	<table border="1" align="center" width="525" style="margin-top: 10px;">
		<thead style="text-align: center;">


			<tr>
				<th>Nouki</th>
				<th>Nama Mesin</th>
				<th>Nama Jigu / Spare Part</th>
				<th>Ukuran</th>
				<th>Qty</th>
			</tr>

		</thead>
		<tbody>
			<tr>
				<td>{{$list->nouki}}</td>
				<td>{{$list->nama_mesin}}</td>
				<td>{{$list->nama_item}}</td>
				<td>{{$list->ukuran}}</td>
				<td>{{number_format($list->qty,0)}}</td>
			</tr>
		</tbody>
	</table>

	<table border="1" align="center" width="525" style="margin-top: 10px;">
		<tbody>

			<tr>
				<td colspan="2"><b>Alasan :</b> {{$list->alasan}}</td>
				<td align="center" width="130"><b>Waktu Pengerjaan</b></td>
			</tr>
			<tr>
				<td colspan="2"><b>Permintaan Perbaikan :</b> {{$list->permintaan_perbaikan}}</td>
				<td>Tanggal : {{$list->tanggal_selesai}}</td>
			</tr>
			<tr>
				<td><b>Tindakan Perbaikan :</b> {{$list->tindakan_perbaikan}}</td>
				<td width="100">Material :</td>
				<td>Operator :</td>
			</tr>
		</tbody>
	</table>

	<table align="right" border="0" cellspacing="3" cellpadding="3">
		<tr>
			<td align="center" widht="160">Request By : {{$list->nama_user}}</td>
			<td>||</td>
			<td align="right" width="100">Accept By : {{$list->accept_by}}</td>
	</table>
	<br>
	<font size="1">No. Form : FM/TCH/034/15C</font>
	<br>
	<font size="1">No. Rev : 04</font>
	<small style="font-size: 14px;float: right; padding-right: 90px;">Paraf Terima barang :
		<br>
	</small>
	------------------------------------------------------------------------------------------------------------------------------------
</body>

</html>