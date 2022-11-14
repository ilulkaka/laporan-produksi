@extends('produksi.template')
@section('head')
    <style>
        .tengah {
            text-align: center;
        }

        .kiri {
            text-align: left;
        }

        .kanan {
            text-align: right;
        }

        .eloading {
            position: fixed;
            /* Sit on top of the page content */
            display: none;
            /* Hidden by default */
            width: 100%;
            /* Full width (cover the whole page) */
            height: 100%;
            /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            /* Black background with opacity */
            z-index: 2;
            /* Specify a stack order in case you're using a different order for other elements */
            cursor: pointer;
            /* Add a pointer on hover */
        }

        .spiner {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }


        img {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }
    </style>

    <link rel="stylesheet" href="{{ asset('/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection
@section('content')


    @if (Session::has('alert-success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('alert-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(Session::has('alert-danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('alert-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form method="post" id="formbarcode">
        {{ csrf_field() }}
        <div class="card card-secondary">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-sm-3">
                        <h3 class="card-title" style="font-size: xx-large; text-align: center;"><a data-toggle="collapse"
                                data-parent="#accordion" href="#collapseOne" class="collapsed" aria-expanded="false">
                                {{ $line[0]->nama_line }}
                            </a></h3>
                        <input type="hidden" id="idline" name="idline" value="{{ $line[0]->kode_line }}">
                    </div>
                    <div class="col col-sm-6">
                        <h5 style="text-align: right;"><a data-toggle="collapse" data-parent="#accordion"
                                href="#collapseOne" class="collapsed" aria-expanded="false">
                                ALL SHIFT</a> || <label for="pcs" id="pcs">{{ number_format($totalshift, 2) }}
                            </label>
                            Pcs
                        </h5>
                    </div>
                    <div class="col col-sm-3">
                        <h5 style="text-align: center; background-color: rgb(38, 0, 255);">{{ $shift }} || <label
                                for="pcs" id="pcs">{{ number_format($shiftnow, 2) }}</label>
                            Pcs
                        </h5>
                        <input type="hidden" id="shift" name="shift" value="{{ $shift }}">
                    </div>

                </div>
            </div>
            <p></p>
            <div id="accordion">
                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                <div class="card card-primary">
                    <div id="collapseOne" class="panel-collapse in collapse"
                        style="font-family: 'Courier New', Courier, monospace;">

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="position-relative p-3 bg-info" style="height: 200px">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon bg-danger">
                                            Hasil %
                                        </div>
                                    </div>
                                    Rekap Hasil <br>
                                    <small></small>
                                    <h6>Rata - Rata Pcs/lot = <b>{{ $rataratalot }}</b> Pcs</h6>

                                    <div class="row invoice-info">
                                        <div class="col-sm-3 invoice-col">
                                            <font style="color:gold;"><b><u>Prosentase All Shift</u></b></font>
                                            <address>
                                                <h6>F = <b>{{ $prosentaseF }}</b> %</h6>
                                                <h6>CR = <b>{{ $prosentaseCR }}</b> %</h6>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-3 invoice-col">
                                            <font style="color:gold;"><b><u>Comp/OIL</u></b></font>
                                            <address>
                                                <h6>Comp-F = <b>{{ $compf }}</b></h6>
                                                <h6>Comp-CR = <b>{{ $compcr }}</b></h6>
                                                <h6>OIL-F = <b>{{ $oilf }}</b></h6>
                                                <h6>OIL-CR = <b>{{ $oilcr }}</b></h6>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-3 invoice-col">
                                            <font style="color:gold;"><b><u>SHAPE</u></b></font>
                                            <address>
                                                <h6>Non Uchi = <b>{{ $t1bf }}</b></h6>
                                                <h6>Uchicatto = <b>{{ $t1ic }}</b></h6>
                                            </address>
                                        </div>

                                        <div class="col-sm-3 invoice-col">
                                            <font style="color:gold;"><b><u>PROSES</u></b></font>
                                            <address>
                                                <h6>Reguler = <b>{{ $reg }}</b></h6>
                                                <h6>Proses 2x = <b>{{ $proses2x }}</b></h6>
                                                <h6>Tenaoshi = <b>{{ $tenaoshi }}</b></h6>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="position-relative p-3 bg-info" style="height: 200px">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon bg-danger">
                                            Hasil %
                                        </div>
                                    </div>
                                    Rekap Hasil <br>
                                    <small></small>
                                    <br>
                                    <div class="row invoice-info">
                                        <div class="col-sm-6 invoice-col">
                                            <font style="color:gold;"><b><u>Pcs</u></b></font>
                                            <address>
                                                <h6>SHIFT 1 = <b>{{ $s1 }}</b> Pcs</h6>
                                                <h6>SHIFT 2 = <b>{{ $s2 }}</b> Pcs</h6>
                                                <h6>SHIFT 3 = <b>{{ $s3 }}</b> Pcs</h6>
                                                <h6>NON SHIFT = <b>{{ $nonshift }}</b> Pcs</h6>
                                            </address>
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6 invoice-col">
                                            <font style="color:gold;"><b><u>PAS / Cycle</u></b></font>
                                            <address>
                                                <h6><b>{{ $pas1 }}</b></h6>
                                                <h6><b>{{ $pas2 }}</b></h6>
                                                <h6><b>{{ $pas3 }}</b></h6>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="sel">NIK</label>
                        <select name="sel" id="sel"
                            class="form-control select2 @error('nik') is-invalid @enderror" style="width: 100%;" required>
                            <option value="">NIK</option>
                            @foreach ($nomerinduk as $i)
                                <option value="{{ $i->nama }}">{{ $i->nik }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-7">
                        <label for="nama">Nama Operator</label>
                        <input type="hidden" name="nik" id="nik">
                        <input type="hidden" class="form-control @error('nama')is-invalid @enderror" name="operator"
                            id="operator" placeholder="Nama Operator">
                        <input type="text" class="form-control @error('nama')is-invalid @enderror" name="operator1"
                            id="operator1" placeholder="Nama Operator" disabled>
                    </div>
                    <div class="form-group col-md-3"><label>Remark</label>
                        <select name="remark" id="remark" class="form-control" required>
                            <option value="Reguler">Reguler</option>
                            <option value="Proses2x">Proses 2x</option>
                            <option value="Tenaoshi">Tenaoshi</option>
                        </select>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col col-md-7">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row">
                                    @if ($line[0]->kode_line == 320 || $line[0]->kode_line == 400)
                                        <div class="form-group col-md-2">
                                            <label for="tempat_kejadian">No Urut</label>
                                            <input type="text" class="form-control" name="no_urut" id="no_urut"
                                                placeholder="No Urut Proses" required>
                                        </div>
                                    @endif
                                    <div class="form-group col-md-2">
                                        <label for="tempat_kejadian">No Mesin</label>
                                        <input type="text" onkeypress="return hanyaAngka(event)" class="form-control"
                                            name="no_meja" id="no_meja" maxlength="2" placeholder="No Mesin"
                                            required>
                                    </div>

                                    <script>
                                        function hanyaAngka(evt) {
                                            var charCode = (evt.which) ? evt.which : event.keyCode
                                            if (charCode > 31 && (charCode < 48 || charCode > 57))

                                                return false;
                                            return true;
                                        }
                                    </script>

                                    <div class="form-group col-md-3">
                                        <label for="tgl_kejadian">Tanggal Proses</label>
                                        <input type="date" class="form-control" value="{{ $tgl }}"
                                            name="tgl_proses1" id="tgl_proses1" placeholder="Tanggal Kejadian"
                                            disabled="true">
                                        <input type="hidden" class="form-control" value="{{ $tgl }}"
                                            name="tgl_proses" id="tgl_proses" placeholder="Tanggal Kejadian">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tempat_kejadian">Barcode No</label>
                                        <input type="text" class="form-control" name="barcodeno" id="barcodeno"
                                            placeholder="Barcode No" required>
                                    </div>
                                    @if ($line[0]->kode_line == 320)
                                        <div class="form-group col-md-2">
                                            <label>Incoming Qty</label>
                                            <input type="number" class="form-control" name="incoming_qty"
                                                id="incoming_qty">
                                        </div>
                                    @endif
                                    @if ($line[0]->kode_line == 51)
                                        <div class="form-group col-md-2">
                                            <label>Haba Awal</label>
                                            <input type="number" class="form-control" name="ukuran_haba_awal"
                                                id="ukuran_haba_awal">
                                        </div>
                                    @endif
                                    @if ($line[0]->kode_line == 40 || $line[0]->kode_line == 51 || $line[0]->kode_line == 60)
                                        <div class="form-group col-md-2">
                                            @if ($line[0]->kode_line == 51)
                                                <label>Haba Finish</label>
                                            @else
                                                <label>Ukuran Haba</label>
                                            @endif
                                            <input type="number" class="form-control" name="ukuran_haba"
                                                id="ukuran_haba">
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Part No</label>
                                        <input type="text" class="form-control" name="partno" id="partno"
                                            placeholder="Part No">
                                        <input type="hidden" class="form-control" name="partno1" id="partno1">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="tempat_kejadian">Lot No</label>
                                        <input type="text" class="form-control" name="lotno" id="lotno"
                                            placeholder="Lot No">
                                        <input type="hidden" class="form-control" name="lotno1" id="lotno1">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="tempat_kejadian">Finish Qty</label>
                                        <input type="number" class="form-control" name="finish_qty" id="finish_qty">
                                        <input type="hidden" class="form-control" name="finish_qty1" id="finish_qty1">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="tempat_kejadian">Reject</label>
                                        <input type="number" class="form-control" name="reject" id="reject"
                                            value="0">
                                        <input type="hidden" class="form-control" name="reject1" id="reject1"
                                            value="0">
                                    </div>
                                </div>

                                @if ($line[0]->kode_line == 70 ||
                                    $line[0]->kode_line == 100 ||
                                    $line[0]->kode_line == 110 ||
                                    $line[0]->kode_line == 120 ||
                                    $line[0]->kode_line == 131 ||
                                    $line[0]->kode_line == 160 ||
                                    $line[0]->kode_line == 190 ||
                                    $line[0]->kode_line == 200)
                                    <div class="float-left form-group col-md-4">
                                        <div class="form-group">
                                            <label>Dandoriman</label>
                                            <select name="dandoriman" id="dandoriman" class="form-control select2"
                                                style="width: 100%;" required>
                                                <option value="">Dandoriman</option>
                                                @foreach ($deptdandori as $d)
                                                    <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 51 ||
                                    $line[0]->kode_line == 70 ||
                                    $line[0]->kode_line == 100 ||
                                    $line[0]->kode_line == 110 ||
                                    $line[0]->kode_line == 120 ||
                                    $line[0]->kode_line == 131 ||
                                    $line[0]->kode_line == 160 ||
                                    $line[0]->kode_line == 170 ||
                                    $line[0]->kode_line == 190 ||
                                    $line[0]->kode_line == 200)
                                    <div class="float-left col-md-3">
                                        <div class="form-group">
                                            <label>Dandori</label>
                                            <select name="dandori" id="dandori" class="form-control" required>
                                                <option value="">Select ...</option>
                                                <option value="None">None</option>
                                                <option value="SEMI">SEMI</option>
                                                <option value="FULL">FULL</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 140 || $line[0]->kode_line == 150)
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Shafto Panjang</label>
                                            <input type="number" class="form-control" name="shafto_pjg" id="shafto_pjg"
                                                min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Shafto Pendek</label>
                                            <input type="number" class="form-control" name="shafto_pdk" id="shafto_pdk"
                                                min="0" value="0">
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 40 ||
                                    $line[0]->kode_line == 51 ||
                                    $line[0]->kode_line == 100 ||
                                    $line[0]->kode_line == 110 ||
                                    $line[0]->kode_line == 120 ||
                                    $line[0]->kode_line == 170 ||
                                    $line[0]->kode_line == 190)
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Cycle</label>
                                            <input type="number" class="form-control" name="cycle" id="cycle"
                                                value="0">
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 40 ||
                                    $line[0]->kode_line == 51 ||
                                    $line[0]->kode_line == 100 ||
                                    $line[0]->kode_line == 110 ||
                                    $line[0]->kode_line == 120 ||
                                    $line[0]->kode_line == 140 ||
                                    $line[0]->kode_line == 150 ||
                                    $line[0]->kode_line == 170 ||
                                    $line[0]->kode_line == 190)
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Total Cycle</label>
                                            <input type="hidden" class="form-control" name="total_cycle"
                                                id="total_cycle">
                                            <input type="number" class="form-control" name="total_cycle1"
                                                id="total_cycle1" disabled>
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 70 ||
                                    $line[0]->kode_line == 160 ||
                                    $line[0]->kode_line == 200 ||
                                    $line[0]->kode_line == 210 ||
                                    $line[0]->kode_line == 320 ||
                                    $line[0]->kode_line == 400)
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Total Cycle</label>
                                            <input type="number" class="form-control" name="total_cycle"
                                                id="total_cycle" value="0">
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 51 || $line[0]->kode_line == 170)
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Dressing</label>
                                            <input type="number" class="form-control" name="dressing" id="dressing"
                                                value="0" required>
                                        </div>
                                    </div>
                                @endif
                                @if ($line[0]->kode_line == 30)
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Tanegata</label>
                                            <select name="tanegata" id="tanegata" class="form-control select2"
                                                style="width: 100%;" required>
                                                <option value="">Tanegata</option>
                                                @foreach ($tanegata as $t)
                                                    <option value="{{ $t->i_qry_mtrl }}">{{ $t->i_qry_mtrl }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="float-left col-md-3">
                                        <div class="form-group">
                                            <label>Cast No</label>
                                            <input type="text" class="form-control" name="cast_no" id="cast_no"
                                                required>
                                        </div>
                                    </div>
                                    <div class="float-left col-md-3">
                                        <div class="form-group">
                                            <label>Moulding Opr</label>
                                            <select name="moulding_opr" id="moulding_opr" class="form-control select2"
                                                style="width: 100%;" required>
                                                <option value="">Opr Moulding</option>
                                                @foreach ($oprmoulding as $o)
                                                    <option value="{{ $o->nama }}">{{ $o->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="float-left col-md-2">
                                        <div class="form-group">
                                            <label>Moulding No</label>
                                            <input type="number" class="form-control" name="moulding_no"
                                                id="moulding_no" min="1" max="10" required>
                                        </div>
                                    </div>
                                @endif
                                <div class="float-right">
                                    @if ($line[0]->kode_line < 320)
                                        <br>
                                    @endif
                                    <input type="button" value="simpan" class="btn btn-success btn-flat"
                                        style="padding-bottom: 20px;" id="btn_simpan" name="btn_simpan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col col-md-5">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="kode_ng">Kode NG</label>
                                        <select name="kode_ng" id="kode_ng" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">Kode NG</option>
                                            @foreach ($masterng as $m)
                                                <option value="{{ $m->type_ng }}">{{ $m->kode_ng }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="row align-items-end">
                                    <div class="form-group col-md-6">
                                        <label for="nama">Type NG</label>
                                        <input type="hidden" class="form-control" name="ng1" id="ng1">
                                        <input type="text" class="form-control" name="type_ng" id="type_ng"
                                            placeholder="Type NG" disabled>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="tempat_kejadian">NG Qty</label>
                                        <input type="number" class="form-control" name="ng_qty" id="ng_qty">
                                    </div>
                                    <div class="form-group col-md-2">

                                        <button type="button" class="btn btn-danger" id="btn_tambah">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--letak btn simpan sebelum-->
                        <div class="form-group col-md-12">
                            <p class="kanan">
                                <label for="">Sisa NG : </label>
                                <label for="diffrjt" id="diffrjt" style="color: red;">
                                    0
                                </label>
                            </p>
                        </div>

                    </div>
                </div>
                <table class="table table-bordered" id="tb_ng">
                    <thead>
                        <tr>
                            <th style="width: 200px">NG Code</th>
                            <th>NG Type</th>
                            <th style="width: 100px">NG Qty</th>
                            <th style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total :</th>
                            <th colspan="2" id="qty">qTY</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </form>

    <div id="loadingscreen" class="eloading">
        <div id="text" class="spiner"><i class="fas fa-spinner fa-spin"></i></div>
    </div>

    <div id="loadingscreen1" class="eloading">
        <p><img src="{{ asset('/assets/img/mobile-check.gif') }}" class="center-block img-circle" /></p>
    </div>


    <div class="card">
        <div class="card-header">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="card-title">Hasil Produksi PerHari</h3>
                            <span class="float-right">
                                @if ($line[0]->kode_line == 70)
                                    <button class="btn btn-sm" id="btn-shikakaricamu">
                                        <font color="blue"><i class="fas fa-list-ol mr-1"></i>
                                            <u> Shikakari CAMU</u>
                                        </font>
                                    </button>
                                @endif
                                <button class="btn btn-sm" id="btn-reportoperator">
                                    <font color="blue"><i class="fas fa-file-csv mr-1"></i>
                                        <u> Report Operator</u>
                                    </font>
                                </button>
                                @if ($line[0]->kode_line > 320)
                                    <button class="btn btn-sm" id="btn-rekapoperator">
                                        <font color="blue"><i class="fas fa-list-ol mr-1"></i>
                                            <u> Rekap Operator</u>
                                        </font>
                                    </button>
                                @endif
                                @if ($line[0]->kode_line == 320)
                                    <button class="btn btn-sm" id="btn-ceklot">
                                        <font color="blue"><i class="fas fa-check-double mr-1"></i>
                                            <u> Cek Input Vs Prones</u>
                                        </font>
                                    </button>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-tools">

                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="tb_hasil_produksi">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Part No</th>
                            <th>Lot No</th>
                            <th>Incoming</th>
                            <th>Finish Qty</th>
                            <th>NG Qty</th>
                            <th>Operator</th>
                            <th>Shift</th>
                            <th>No Mesin</th>
                            <th>Cycle</th>
                            @if ($line[0]->kode_line == 30)
                                <th>Opr moulding</th>
                            @else
                                <th>Dressing</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="card-footer">

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!--Modal NG-->
    <div class="modal fade bd-example-modal-lg" id="modal-NG" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detaillist">Detail NG</h5>
                </div>
                <div class="modal-body">

                    <table class="table" id="t_detail_NG">
                        <thead>
                            <tr>
                                <th>NG Code</th>
                                <th>NG Type</th>
                                <th>NG Qty</th>
                            </tr>
                        </thead>
                    </table>

                </div>
                <div class="modal-footer">
                    <div class="col col-md-3">
                        <button type="button" class="btn btn-secondary" id="btn-close-list">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!--Modal Rekap Operator-->
    <div class="modal fade bd-example-modal-lg" id="modal-rekapoperator" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detaillist">Rekap</h5>
                </div>
                <form id="modal-opr">
                    <div class="modal-body">
                        <div class="row align-left">
                            <label for="" class="col-md-2 text-left">Start </label>
                            <input type="date" class="form-control col-md-4" id="tgl1"
                                value="{{ date('Y-m') . '-01' }}">
                            <label for="" class="col-md-2 text-center">Sampai</label>
                            <input type="date" class="form-control col-md-4" id="tgl2"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <p></p>
                        <div class="row align-left">
                            <div class="col-md-2 text-left"><label>Operator</label></div>
                            <div class="col col-md-4">
                                <select name="opr" id="opr"
                                    class="form-control select2 @error('line_proses') is-invalid @enderror"
                                    style="width: 100%;" required>
                                    <option value="All">All</option>
                                    @foreach ($opr as $o)
                                        <option value="{{ $o->operator }}">{{ $o->operator }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-flat" id="btn-process">Process</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal List Rekap-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-listrekap"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rekap Operator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive p-0">
                    <div class="container">

                        <table id="tb_listrekap" class="table table-bordered table-striped dataTable">
                            <thead>
                                <th>Operator</th>
                                <th>Finish Qty</th>
                                <th>NG Qty</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="keluar" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cek Lot Prones-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-ceklot"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cek Lot No System Vs Prones System</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive p-0">
                    <div class="container">

                        <table id="tb_ceklot" class="table table-bordered table-striped dataTable">
                            <thead>
                                <th>Part No</th>
                                <th>Lot No</th>
                                <th>Status</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="keluar" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cek Lot Prones-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-ceklot-OK"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <font style="text-align: right; font-family: 'Courier New', Courier, monospace;">Cek
                            Lot No System Vs Prones System</font>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive p-0">
                    <div class="container">
                        <thead>
                            <th>
                                <font
                                    style="text-align: right; color: blue; font-family: 'Courier New', Courier, monospace;">
                                    Data OK .</font>
                            </th>
                        </thead>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="keluar" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal lapor NG-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-lapor"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <font style="text-align: right; font-family: 'Courier New', Courier, monospace;">Qty Finish kurang
                            dari Plan, Segera Lapor PPIC .</font>
                    </h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="keluar" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Report operator-->
    <div class="modal fade" id="modal-reportoperator" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Report Line / Operator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col col-md-12">
                        <input type="date" class="col-md-4" id="tgl_awal" value="{{ date('Y-m-d') }}">
                        <label for="" class="col-md-2 text-center">Sampai</label>
                        <input type="date" class="col-md-4" id="tgl_akhir" value="{{ date('Y-m-d') }}">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col col-md-3"><label>Line</label></div>
                        <label>:</label>
                        <div class="col col-md-7">
                            <select name="kode_line" id="kode_line"
                                class="form-control select2 @error('kode_line') is-invalid @enderror" style="width: 100%;"
                                required>
                                @foreach ($line as $l)
                                    <option value="{{ $l->kode_line }}">{{ $l->nama_line }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <p>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-flat" id="btn-preview">Preview</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal List CAMU-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-shikakaricamu"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SHIKAKARI CAMU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive p-0">
                    <div class="container">

                        <table id="tb_shikakaricamu" class="table table-bordered table-striped dataTable text-nowrap">
                            <thead>
                                <th>Part No</th>
                                <th>Lot No</th>
                                <th>Qty</th>
                                <th>Tgl In</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:center; ">TOTAL</th>
                                    <th style="text-align:center; font-size: large;"></th>
                                    <th style="text-align:center; font-size: large;"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="keluar" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function() {

            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });

        $(document).ready(function() {

            $("#sel").select2('focus');

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 50000
            });

            var fg = 0;

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    type: 'success',
                    title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                })
            });

            //$("#pcs").html(resp.sum);
            $("#btn_simpan").prop('disabled', true);
            partno.disabled = true;
            lotno.disabled = true;
            //loadingon();
            var key = localStorage.getItem('produksi_token');
            var totng = 0;
            var sisang = 0;

            var workresult = $('#tb_hasil_produksi').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/hasilproduksi',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                    data: function(d) {
                        d.shift = $("#shift").val();
                        d.line = $("#idline").val();
                        d.tgl = $("#tgl_proses").val();
                    }
                },
                columnDefs: [{

                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [10],
                        data: null,
                        //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                        render: function(data, type, row, meta) {
                            if (data.line_proses == 30) {
                                return data.moulding_opr;
                            } else {
                                return data.dressing;
                            }
                        }
                    },
                    {
                        targets: [11],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        defaultContent: "<button class='btn btn-success btn-sm btn-flat'>Detail NG</button><button class='btn btn-danger btn-sm btn-flat'>Hapus</button>"
                    },
                ],

                columns: [{
                        data: 'id_hasil_produksi',
                        name: 'id_hasil_produksi'
                    },
                    {
                        data: 'part_no',
                        name: 'part_no'
                    },
                    {
                        data: 'lot_no',
                        name: 'lot_no'
                    },
                    {
                        data: 'incoming_qty',
                        name: 'incoming_qty'
                    },
                    {
                        data: 'finish_qty',
                        name: 'finish_qty'
                    },
                    {
                        data: 'ng_qty',
                        name: 'ng_qty'
                    },
                    {
                        data: 'operator',
                        name: 'operator'
                    },
                    {
                        data: 'shift',
                        name: 'shift'
                    },
                    {
                        data: 'no_mesin',
                        name: 'no_mesin'
                    },
                    {
                        data: 'total_cycle',
                        name: 'total_cycle',
                        render: $.fn.dataTable.render.number(',', '.', 0, '')
                    },
                    //{ data: 'dressing', name: 'dressing' },
                ],
            });

            $("#sel").on('select2:select', function() {
                var nik = $(this).children("option:selected").html();
                var operator = $(this).children("option:selected").val();

                $("#nik").val(nik);
                $("#operator").val(operator);
                $("#operator1").val(operator);

                var idline = $("#idline").val();
                if (idline == 320 || idline == 400) {
                    $("#no_urut").focus();
                } else {
                    $("#no_meja").focus();
                }
            });

            $("#remark").change(function(e) {
                //var code = e.keyCode || e.which;
                var idline = $("#idline").val();

                if (idline == 131) {
                    $("#no_meja").focus();
                }

            });

            $("#kode_ng").on('select2:select', function() {
                var kodeng = $(this).children("option:selected").html();
                var typeng = $(this).children("option:selected").val();
                $("#ng1").val(kodeng);
                $("#type_ng").val(typeng);

                $("#ng_qty").focus();
            });

            $("#kode_ng").keydown(function(event) {
                if (event.keyCode >= 51) {
                    $("#ng_qty").focus();
                    alert('test');
                }
            });

            $("#no_urut").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#no_meja").focus();
                }
            });

            $("#no_meja").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#barcodeno").focus();
                }
            });

            $("#ukuran_haba_awal").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#ukuran_haba").focus();
                }
            });

            $("#ukuran_haba").keypress(function(event) {
                var idline = $("#idline").val();
                if (event.keyCode === 13) {
                    if (idline == 40) {
                        $("#cycle").val('');
                        $("#cycle").focus();
                    } else if (idline == 51) {
                        $("#dandori").focus();
                    } else {
                        $("#finish_qty").focus();
                    }
                }
            });

            $("#finish_qty").keypress(function(event) {
                var idline = $("#idline").val();
                var qty_finish = $("#finish_qty").val();

                if (event.keyCode === 13) {
                    if (qty_finish < fg) {
                        //alert('Lapor PPIC, Qty Finish kurang dari Plan .');
                        $('#modal-lapor').modal('show');
                        $("#reject").val('');
                        $("#reject").focus();
                    } else {
                        if (idline == 30) {
                            $("#tanegata").select2('focus');
                        } else if (idline == 70) {
                            $("#dandoriman").select2('focus');
                        } else {
                            $("#finish_qty1").val(qty_finish);
                            $("#reject").val('');
                            $("#reject").focus();
                        }
                    }
                }
            });


            $("#finish_qty").change(function(event) {
                var idline = $("#idline").val();
                var qty_finish = $("#finish_qty").val();
                var cycle = $("#cycle").val();

                if (idline == 51 || idline == 170) {
                    $("#total_cycle").val(qty_finish * cycle);
                    $("#total_cycle1").val(qty_finish * cycle);
                } else if (idline == 100 || idline == 110 || idline == 120 || idline == 190) {
                    $("#total_cycle").val(qty_finish / cycle);
                    $("#total_cycle1").val(qty_finish / cycle);
                }
            });

            $("#ng_qty").keypress(function(event) {
                if (event.keyCode === 13) {
                    $("#btn_tambah").focus();
                }
            });

            $("#reject").on('focus', function() {
                var qty_finish = $("#finish_qty").val();
                $("#finish_qty1").val(qty_finish);
                if ($("#incoming_qty").val() <= 0) {
                    alert("Please Input Incoming Qty .");
                    $("#incoming_qty").focus();
                }
            });

            $("#reject").keypress(function(event) {
                var idline = $("#idline").val();
                var qty_finish = $("#finish_qty").val();
                var cycle = $("#cycle").val();
                var reject = $("#reject").val();
                var totcycle = (Number(qty_finish) + Number(reject)) / Number(cycle);

                if (event.keyCode === 13) {
                    if ($("#reject").val() == '' || $("#reject").val() == null) {
                        alert('Please Input your Reject Qty .');
                    }
                    if (idline == 40) {
                        if ($("#reject").val() == 0) {
                            $("#total_cycle").val(totcycle);
                            $("#total_cycle1").val(totcycle);
                            $("#btn_simpan").prop('disabled', false);
                            $("#btn_simpan").focus();
                        } else if (idline == 40) {
                            $("#total_cycle").val(totcycle);
                            $("#total_cycle1").val(totcycle);
                            $("#kode_ng").select2('focus');
                            $("#btn_simpan").prop('disabled', true);
                        }
                    } else {
                        if ($("#reject").val() == 0) {
                            $("#btn_simpan").prop('disabled', false);
                            $("#btn_simpan").focus();
                        } else {
                            $("#kode_ng").select2('focus');
                            $("#btn_simpan").prop('disabled', true);
                        }
                    }
                    //$("#reject1").val(reject);
                }
            });

            $("#tanegata").on('select2:select', function() {
                $("#cast_no").focus();
            });

            $("#cast_no").keypress(function(event) {
                if (event.keyCode === 13) {
                    if ($("#cast_no").val() == '') {
                        alert(' Masukkan Cast No .');
                    } else {
                        $("#moulding_opr").select2('focus');
                    }
                }
            });

            $("#moulding_opr").on('select2:select', function() {
                if ($("#cast_no").val() == '') {
                    alert(' Masukkan Cast No .');
                    $("#cast_no").focus();
                } else {
                    $("#moulding_no").focus();
                }
            });

            $("#moulding_no").keypress(function(event) {
                var qty_finish = $("#finish_qty").val();
                if (event.keyCode === 13) {
                    if ($('#moulding_no').val() >= 11) {
                        alert('Moulding Nomer Max sampai 10');
                        $('#moulding_no').val('');
                    } else if ($('#moulding_no').val() <= '0') {
                        alert('Masukkan Nomer Moulding .');
                    } else {
                        $("#finish_qty1").val(qty_finish);
                        $("#reject").val('');
                        $("#reject").focus();
                    }
                }
            });

            $("#dandoriman").on('select2:select', function() {
                $("#dandori").focus();
            });

            $("#dandori").change(function() {
                var idline = $("#idline").val();

                if ($("#dandori").val() == '') {
                    alert('select dandori .');
                } else if (idline == 70 || idline == 160 || idline == 200) {
                    $("#total_cycle").val('');
                    $("#total_cycle").focus();
                } else if (idline == 131) {
                    $("#finish_qty").val('');
                    $("#finish_qty").focus();
                } else {
                    $("#cycle").val('');
                    $("#cycle").focus();
                }
            });

            $("#cycle").keypress(function(event) {
                var idline = $("#idline").val();
                if (event.keyCode === 13) {
                    if (idline == 40 || idline == 100 || idline == 110 || idline == 120 || idline == 190) {
                        $("#finish_qty").focus();
                    } else if (idline == 51 || idline == 170) {
                        $("#dressing").val('');
                        $("#dressing").focus();
                    } else {
                        $("#reject").focus();
                    }
                }
            });

            $("#cycle").change(function(event) {
                var idline = $("#idline").val();
                var qty_finish = $("#finish_qty").val();
                var cycle = $("#cycle").val();

                if (idline == 51 || idline == 170) {
                    $("#total_cycle").val(qty_finish * cycle);
                    $("#total_cycle1").val(qty_finish * cycle);
                } else if (idline == 100 || idline == 110 || idline == 120 || idline == 190) {
                    $("#total_cycle").val(qty_finish / cycle);
                    $("#total_cycle1").val(qty_finish / cycle);
                }
            });

            $("#total_cycle").keypress(function(event) {
                var idline = $("#idline").val();
                if (event.keyCode === 13) {
                    if (idline == 70) {
                        $("#reject").val('');
                        $("#reject").focus();
                    } else if (idline == 160 || idline == 200) {
                        if ($("#total_cycle").val() == null || $("#total_cycle").val() == '') {
                            alert('Total Cycle harus diisi .')
                        } else {
                            $("#finish_qty").focus();
                        }
                    }
                }
            });

            $("#shafto_pjg").keypress(function(event) {
                var idline = $("#idline").val();
                var pjg = Number($("#shafto_pjg").val());
                var pdk = Number($("#shafto_pdk").val());
                if (event.keyCode === 13) {
                    if (idline == 140 || idline == 150) {
                        if ($("#shafto_pjg").val() == '') {
                            $("#shafto_pjg").val('0');
                            $("#shafto_pdk").val('');
                            $("#shafto_pdk").focus();
                            $("#total_cycle").val(pjg + pdk);
                            $("#total_cycle1").val(pjg + pdk);
                        } else {
                            $("#shafto_pdk").val('');
                            $("#shafto_pdk").focus();
                            $("#total_cycle").val(pjg + pdk);
                            $("#total_cycle1").val(pjg + pdk);
                        }
                    }
                }
            });

            $("#shafto_pjg").change(function(event) {
                var idline = $("#idline").val();
                var pjg = Number($("#shafto_pjg").val());
                var pdk = Number($("#shafto_pdk").val());

                if (idline == 140 || idline == 150) {
                    $("#total_cycle").val(pjg + pdk);
                    $("#total_cycle1").val(pjg + pdk);
                }
            });

            $("#shafto_pdk").keypress(function(event) {
                var idline = $("#idline").val();
                var pjg = Number($("#shafto_pjg").val());
                var pdk = Number($("#shafto_pdk").val());
                if (event.keyCode === 13) {
                    if (idline == 150 || idline == 140) {
                        if ($("#shafto_pdk").val() == '') {
                            $("#shafto_pdk").val('0');
                            $("#finish_qty").val('');
                            $("#finish_qty").focus();
                            $("#total_cycle").val(pjg + pdk);
                            $("#total_cycle1").val(pjg + pdk);
                        } else {
                            $("#finish_qty").val('');
                            $("#finish_qty").focus();
                            $("#total_cycle").val(pjg + pdk);
                            $("#total_cycle1").val(pjg + pdk);
                        }
                    }
                }
            });

            $("#shafto_pdk").change(function(event) {
                var idline = $("#idline").val();
                var pjg = $("#shafto_pjg").val();
                var pdk = $("#shafto_pdk").val();
                var pjg1 = Number(pjg);
                var pdk1 = Number(pdk);

                if (idline == 150 || idline == 140) {
                    $("#total_cycle").val(pjg1 + pdk1);
                    $("#total_cycle1").val(pjg1 + pdk1);
                }
            });

            $("#dressing").keypress(function(event) {
                if (event.keyCode === 13) {
                    if ($("#dressing").val() == '') {
                        $("#finish_qty").focus();
                        $("#dressing").val('0');
                    } else {
                        $("#finish_qty").focus();
                    }
                }
            });

            $("#incoming_qty").keypress(function() {
                if (event.keyCode === 13) {
                    if ($("#incoming_qty").val() > 0) {
                        $("#reject").focus();
                    } else {
                        alert("Please Input Incoming Qty .");
                        $("#incoming_qty").focus();
                    }
                }
            });

            $("#btn_simpan").click(function() {
                //e.preventDefault();
                var datas = $("#formbarcode").serializeArray();
                var nik = $(".select_op").val();
                var diff = $("#diffrjt").html();

                if ($("#sel").val() == '' || $("#sel").val() == null) {
                    alert('NIK belum dipilih !');
                } else if ($("#barcodeno").val() == '' || $("#barcodeno").val() == null) {
                    alert('Barcode belum terisi !');
                } else if ($("#finish_qty").val() == '' || $("#finish_qty").val() == null || $(
                        "#finish_qty1").val() == '' || $("#finish_qty1").val() == null) {
                    alert('Qty finish belum terisi !');
                } else if ($("#reject").val() == '' || $("#reject").val() == null || $("#reject1").val() ==
                    '' || $("#reject1").val() == null) {
                    alert('Qty Reject belum terisi !');
                } else if (Number(diff) != 0) {
                    alert('Qty NG belum diisi !');
                } else {
                    $("#btn_simpan").prop('disabled', true);
                    document.getElementById("loadingscreen").style.display = "block";
                    $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/update_laporan_produksi",
                            headers: {
                                "token_req": key,
                            },
                            data: datas,
                            async: false,
                            dataType: "json",
                        })
                        .done(function(resp) {
                            document.getElementById("loadingscreen").style.display = "none";
                            $("#btn_simpan").prop('disabled', false);
                            if (resp.success) {
                                Toast.fire({
                                    type: 'success',
                                    title: resp.message,
                                })
                                window.location = window.location;
                                $("#sel").select2('focus');
                                //workresult.ajax.reload();
                            } else {
                                Toast.fire({
                                    type: 'error',
                                    title: resp.message,
                                })
                                //location.reload();
                            }
                        })
                        .fail(function() {
                            $("#error").html(
                                "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );
                        });
                }

            });


            $('#btn_tambah').click(function() {
                //var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="' + data.kode_ng + '" />' + data.kode_ng + '</td><td><input type ="hidden" name="part_name[]" value="' + data.type_ng + ' ' + data.type_ng + '" />' + data.type_ng + '</td><td><input type ="hidden" name="part_qty[]" value="' + qty + '" />' + qty + '</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                var nilai = $("#ng1").val();
                var type = $("#type_ng").val();
                var ng = $("#ng_qty").val();
                var diff = $("#diffrjt").html();
                var reject = $("#reject").val();
                var cek = Number(reject) - (totng + Number(ng));
                var codes = [];
                var sama = false;
                codes = $("input[name='kode_ng[]']").map(function() {
                    return this.value;
                }).get();

                for (r in codes) {
                    if (codes[r] == nilai) {
                        sama = true;
                    }
                }




                if (!type) {
                    alert('Type NG Belum diisi .');
                } else if (!ng) {
                    alert('Harap masukkan Qty NG .')
                } else if (cek < 0) {
                    alert('Qty Reject Lebih .');
                    $('#ng_qty').val('');
                } else {

                    if (!sama) {
                        totng = totng + Number(ng);
                        sisang = sisang - Number(ng);
                        var baris_baru = '<tr><td><input type ="hidden" name="kode_ng[]" value="' + nilai +
                            '" />' + nilai + '</td><td><input type ="hidden" name="type_ng[]" value="' +
                            type + '" />' + type +
                            '</td><td><input type ="hidden" name="qty_ng[]" value="' + ng + '" />' + ng +
                            '</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                        $('#tb_ng tbody').append(baris_baru);
                        $("#tb_use").append(baris_baru);
                        $('#type_ng').val('');
                        $('#ng_qty').val('');
                        $("#qty").html(totng);
                        $("#diffrjt").html(sisang);
                        $("#kode_ng").select2('focus');
                        if (sisang == 0) {
                            $("#btn_simpan").prop('disabled', false);
                            $("#btn_simpan").focus();
                        }
                    } else {
                        alert("NG Sudah ada !")
                    }


                }




                //$("#tb_ng tfoot").append('<tr><th colspan="2">Total :</th><th>' + totng + '</th><th>' + + '</th><th>' + + '</th></tr>')
            });


            $('#tb_ng').on('click', '.btnSelect', function() {
                var currentRow = $(this).closest("tr");
                var col3 = currentRow.find("td:eq(2)").text(); // get current row 3rd TD
                var te = $("#diffrjt").html();
                sisang = Number(col3) + sisang;
                totng = totng - Number(col3);
                $("#diffrjt").html(sisang);
                currentRow.remove();
                $("#qty").html(totng);
                //$("#tb_ng tfoot").empty();
                //$("#tb_ng tfoot").append('<tr><th colspan="2">Total :</th><th>' + totng + '</th><th>' + + '</th><th>' + + '</th></tr>')

            });

            //$("#barcodeno").change(function () {
            $("#barcodeno").keypress(function() {
                if ($("#no_meja").val() == '' || $("#no_meja").val() == null) {
                    alert('Please Input your Machine Number .')
                } else if (event.keyCode === 13) {
                    var key = localStorage.getItem('produksi_token');
                    var dept = "{{ Session::get('dept') }}";
                    var title = $("#title").val();
                    var barcode_no = $("#barcodeno").val();
                    var kodeline = $("#idline").val();
                    var remark = $("#remark").val();
                    //alert(kodeline);
                    $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/produksi/getbarcode",
                            headers: {
                                "token_req": key,
                            },
                            data: {
                                "barcode_no": barcode_no,
                                "title": title,
                                "kodeline": kodeline,
                                "remark": remark,
                            },

                            dataType: "json",
                        })
                        .done(function(resp) {
                            //loadingoff();
                            if (resp.message == 'Kensa' && kodeline == '320') {

                                $("#partno").val(resp.codekensa[0].i_item_cd);
                                $("#lotno").val(resp.codekensa[0].i_seiban);
                                $("#finish_qty").val(resp.codekensa[0].i_acp_qty);
                                $("#reject").val(resp.rjt);
                                $("#partno1").val(resp.codekensa[0].i_item_cd);
                                $("#lotno1").val(resp.codekensa[0].i_seiban);
                                $("#finish_qty1").val(resp.codekensa[0].i_acp_qty);
                                $("#reject1").val(resp.rjt);
                                $("#diffrjt").html(resp.rjt);
                                sisang = resp.rjt;
                                finish_qty.disabled = true;
                                //reject.disabled = true;
                                //$("#kode_ng").select2('focus');
                                $("#incoming_qty").focus();
                            } else if (resp.message == 'Produksi' && kodeline != '320') {

                                $("#partno").val(resp.codekensa[0].i_item_cd);
                                $("#partno1").val(resp.codekensa[0].i_item_cd);
                                $("#lotno").val(resp.codekensa[0].i_seiban);
                                $("#lotno1").val(resp.codekensa[0].i_seiban);
                                $("#ukuran_haba").val(resp.b);
                                fg = Number(resp.fg);

                                if (kodeline == '40') {
                                    $("#ukuran_haba").focus();
                                } else if (kodeline == '60') {
                                    $("#ukuran_haba").val('');
                                    $("#ukuran_haba").focus();
                                } else if (kodeline == '51') {
                                    $("#ukuran_haba_awal").focus();
                                } else if (kodeline == '100' || kodeline == '110' || kodeline ==
                                    '120' || kodeline == '131' || kodeline == '160' || kodeline ==
                                    '190' || kodeline == '200'
                                ) {
                                    //$("#finish_qty").focus();
                                    $("#dandoriman").select2('focus');
                                } else if (kodeline == '140' || kodeline == '150') {
                                    $("#shafto_pjg").val('');
                                    $("#shafto_pjg").focus();
                                } else if (kodeline == '160') {
                                    $("#total_cycle").val('');
                                    $("#total_cycle").focus();
                                } else if (kodeline == '170') {
                                    $("#dandori").focus();
                                } else {
                                    $("#finish_qty").focus();
                                }

                            } else {
                                alert(resp.message);
                                $("#partno").val('');
                                $("#lotno").val('');
                                $("#finish_qty").val('');
                                $("#reject").val('');
                                $("#partno1").val('');
                                $("#lotno1").val('');
                                $("#finish_qty1").val('');
                                //$("#reject1").val('');
                            }
                        })
                        .fail(function() {
                            $("#error").html(
                                "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );
                        });
                }
            });

            $("#reject").change(function() {
                var d = $("#reject").val();
                d = Number(d);
                if (d - totng < 0) {
                    alert('Qty NG salah');
                    $("#reject").val(sisang + totng);
                } else {
                    sisang = d;
                    $("#diffrjt").html(sisang);
                }

            });

            $('#tb_hasil_produksi').on('click', '.btn-success', function() {
                var data = workresult.row($(this).parents('tr')).data();
                get_details_ng(data, key);
                $("#detaillist").html('Detail NG :  ' + data.part_no + '  -> ' + data.lot_no);
                $('#modal-NG').modal('show');
            });

            $("#btn-close-list").click(function() {
                $('#modal-NG').modal('hide');
            });

            function get_details_ng(data, key) {
                var key = localStorage.getItem('produksi_token');

                var detail_ng = $('#t_detail_NG').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ordering: false,
                    ajax: {
                        url: APP_URL + '/api/detail_ng',
                        type: "POST",
                        headers: {
                            "token_req": key
                        },
                        data: {
                            "id_hasil_produksi": data
                        },
                    },
                    columns: [{
                            data: 'ng_code',
                            name: 'ng_code'
                        },
                        {
                            data: 'ng_type',
                            name: 'ng_type'
                        },
                        {
                            data: 'ng_qty',
                            name: 'ng_qty'
                        },

                    ]
                });
            }

            $('#tb_hasil_produksi').on('click', '.btn-danger', function() {
                var data = workresult.row($(this).parents('tr')).data();
                $("#id_hasil_produksi").val(data.id_hasil_produksi);
                $("#lot_no").val(data.lot_no);
                var conf = confirm("Apakah Part No  " + data.part_no + "dengan No. " + data.lot_no +
                    " akan dihapus?");
                if (conf) {
                    $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/hapus/hasilproduksi",
                            headers: {
                                "token_req": key
                            },
                            data: {
                                "id_hasil_produksi": data.id_hasil_produksi,
                                'line_proses': data.line_proses
                            },
                            dataType: "json",
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert(resp.message);
                                window.location = window.location;
                            } else {
                                alert(resp.message);
                            }
                        })
                        .fail(function() {
                            $("#error").html(
                                "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );

                        });
                }
            });


            $("#btn-rekapoperator").click(function() {
                $('#modal-rekapoperator').modal('show');
            });

            $("#btn-ceklot").click(function() {
                //$('#modal-ceklot-OK').modal('show');
                get_ceklot();
            });

            $("#btn-reportoperator").click(function() {
                var kode_line = $("#kode_line").val();
                var shift = $("#shift").val();
                var tgl = $("#tgl_proses").val();

                if (kode_line == '30' || kode_line == '40') { //Shot Kensa + Naigaiken
                    window.location.href = APP_URL + "/laporan/lap_shotkensa/" + tgl + "/" + kode_line +
                        "/" + shift;
                } else if (kode_line == '60' || kode_line == '51') { //Sozaikensa + DDG 
                    //window.open(APP_URL + "/laporan/lap_kamu", '_self');
                    window.location.href = APP_URL + "/laporan/lap_sozai/" + tgl + "/" + kode_line + "/" +
                        shift;
                } else if (kode_line == '70') { //KAMU
                    //window.open(APP_URL + "/laporan/lap_kamu", '_self');
                    window.location.href = APP_URL + "/laporan/lap_kamu/" + tgl + "/" + kode_line + "/" +
                        shift;
                } else if (kode_line == '131') { //KAMU
                    window.location.href = APP_URL + "/laporan/lap_gsm/" + tgl + "/" + kode_line + "/" +
                        shift;
                } else if (kode_line == '90' || kode_line == '100' || kode_line == '110' || kode_line ==
                    '120' || kode_line == '200' || kode_line == '210' || kode_line ==
                    '220' || kode_line == '150' || kode_line == '160' || kode_line == '170' || kode_line ==
                    '290'
                ) { //KOKUIN || KAV || ODM || OBB || K-LP || C-LP || Atari kensa || MEKKI || NAISHI || DV-9 || F-6
                    window.location.href = APP_URL + "/laporan/lap_atari/" + tgl + "/" + kode_line + "/" +
                        shift;
                } else if (kode_line == '320' || kode_line == '400') { //Gaikan Kensa || Pengemasan
                    window.location.href = APP_URL + "/laporan/lap_gaikan/" + tgl + "/" + kode_line + "/" +
                        shift;
                } else {
                    window.location.href = APP_URL + "/undermaintenance";
                }
            });

            $('#modal-rekapoperator').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            })

            $("#btn-process").click(function() {
                var tgl1 = $("#tgl1").val();
                var tgl2 = $("#tgl2").val();
                var opr = $("#opr").val();
                get_detail_listrekap();
                $('#modal-listrekap').modal('show');
                $(this).find('form').trigger('reset');
            });

            // $("#keluar").click(function () {
            //     location.reload(true);
            // });

            function get_detail_listrekap() {
                var key = localStorage.getItem('produksi_token');
                var listrekap1 = $('#tb_listrekap').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ordering: false,
                    ajax: {
                        url: APP_URL + '/api/produksi/listrekap',
                        type: "POST",
                        headers: {
                            "token_req": key
                        },
                        data: function(d) {
                            d.tgl1 = $("#tgl1").val();
                            d.tgl2 = $("#tgl2").val();
                            d.opr = $("#opr").val();
                        }
                    },
                    columnDefs: [{

                            targets: [1],
                            data: 'total',
                        },
                        {
                            targets: [2],
                            data: 'totalng',
                        },
                    ],
                    columns: [{
                        data: 'operator',
                        name: 'operator'
                    }, ],
                });
            }

            function get_ceklot() {
                $('#loadingscreen1').show();
                var key = localStorage.getItem('produksi_token');
                //var $tgl = date('Y-m-d');
                $.ajax({
                        url: APP_URL + "/api/produksi/ceklot",
                        method: "POST",
                        //data: { "tgl": tgl },
                        dataType: "json",
                        headers: {
                            "token_req": key
                        },
                    })

                    .done(function(resp) {
                        var label = [];
                        var value = [];
                        var value2 = [];
                        var part = 0;
                        var lot = 0;

                        $('#loadingscreen1').hide();
                        if (resp.success) {
                            $('#modal-ceklot').modal('show');

                            $("#tb_ceklot tbody").empty();
                            $("#tb_ceklot tfoot").empty();

                            for (var i in resp.ceklot) {

                                var newrow = '<tr><td><name="part_no[]" value="/>' + resp.ceklot[i].part_no +
                                    ' </td><td><name="lot_no[]" value="/>' + resp.ceklot[i].lot_no +
                                    ' </td><td><name="status[]" value="/>' + "Not Completed" + ' </td></tr>';
                                $('#tb_ceklot tbody').append(newrow);
                            }
                        } else {
                            //alert("Tidak ada data .");
                            $('#modal-ceklot-OK').modal('show');
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                        );

                    });
            }

            $("#btn-shikakaricamu").click(function() {
                var kode_line = $("#kode_line").val();
                var shift = $("#shift").val();
                var tgl = $("#tgl_proses").val();
                get_detail_shikakaricamu();
                $('#modal-shikakaricamu').modal('show');
            });

            function get_detail_shikakaricamu() {
                var key = localStorage.getItem('produksi_token');
                var kode_line = $("#kode_line").val();
                var shikakaricamu = $('#tb_shikakaricamu').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ordering: false,
                    ajax: {
                        url: APP_URL + '/api/produksi/shikakaricamu',
                        type: "POST",
                        headers: {
                            "token_req": key
                        },
                        data: function(d) {
                            d.proses1 = 60;
                            d.proses2 = kode_line;
                        }
                    },
                    columnDefs: [{

                        //targets: [1],
                        //data: 'total',
                    }, ],
                    columns: [{
                            data: 'part_no',
                            name: 'part_no'
                        },
                        {
                            data: 'lot_no',
                            name: 'lot_no'
                        },
                        {
                            data: 'finish_qty',
                            name: 'finish_qty'
                        },
                        {
                            data: 'tgl_proses',
                            name: 'tgl_proses'
                        },
                    ],
                    "footerCallback": function(row, data, start, end, display) {
                        var api = this.api(),
                            data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };

                        Totalqty = api
                            .column(2, {
                                page: 'current'
                            })
                            .data()
                            .reduce(function(a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                        $(api.column(2).footer()).html(
                            Totalqty.toLocaleString("en-US")
                        );

                    }
                });
            }


        });
    </script>
@endsection
