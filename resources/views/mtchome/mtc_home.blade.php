@extends('mtchome.template')
@section('content')
<button class="btn btn-primary float-right" id="btn_reload"><i class="fa fa-sync"></i></button>
<div id="accordion2">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne3" class="collapsed btn btn-info"
        aria-expanded="false">
        Power
    </a>
    <div id="collapseOne3" class="panel-collapse in collapse" style="">
        <button type="button" class="btn btn-danger" id="btn_shutdown"><i class="fa fa-power-off"></i> Shutdwon</button>
        <button type="button" class="btn btn-success" id="btn_on"><i class="fa fa-power-off"></i> lampon</button>
        <button type="button" class="btn btn-warning" id="btn_off"><i class="fa fa-power-off"></i> lampoff</button>
    </div>
</div>
<div class="text-center">
    <h3>Total Jam Kerusakan : <b id="total_jam">0</b> Jam</h3>
</div>

<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="tot_request">0</h3>

                <p>Request Masuk</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <div class="small-box-footer">Total Request</div>

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="prosent">0</h3>

                <p>Terselesaikan</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <div class="small-box-footer">Progress</div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="tot_pending">0</h3>

                <p>Perbaikan Pending</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="tot_rusak">0</h3>

                <p>Request Open</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<div class="row">
    <div class="card col-lg-12">
        <div class="card-header ui-sortable-handle">
            <h3 class="card-title">
                <i class="fas fa-tools mr-1"></i>
                Request Perbaikan
            </h3>
            <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#open-req" data-toggle="tab">Open</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#complete-req" data-toggle="tab">Complete</a>
                    </li>
                </ul>
            </div>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="open-req">
                    <div class="col col-md-6">
                        <div class="form-row">

                            <label class="col-md-2">Status Request : </label>
                            <select name="status_req" id="status_req" class="form-control col-md-2">
                                <option value="all">All</option>
                                <option value="process">Process</option>
                                <option value="pending">Pending</option>
                                <option value="selesai">Selesai</option>
                                <option value="open">Open</option>
                            </select>
                            <button class="btn btn-primary" id="refresh_req"><i class="fa fa-sync"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tb_open">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tanggal</th>
                                    <th>Maintenance</th>
                                    <th>Dept</th>
                                    <th>User</th>
                                    <th>Klasifikasi</th>
                                    <th>No. Request</th>
                                    <th>Nama Mesin</th>
                                    <th>No. Mesin</th>
                                    <th>No. Induk Mesin</th>
                                    <th>Masalah</th>
                                    <th>Kondisi</th>
                                    <th>Lapor PPIC</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="chart tab-pane" id="complete-req">
                    <div class="row content-center">
                        <div class="col col-md-6">
                            <div class="row">
                                <div class="col col-md-2"></div>
                                <input type="date" class="form-control col-md-3" id="tgl1"
                                    value="{{date('Y-m').'-01'}}">
                                <label for="" class="text-center col-md-2">Sampai</label>
                                <input type="date" class="form-control col-md-3" id="tgl2" value="{{date('Y-m-d')}}">
                                <button class="btn btn-primary" id="btn_refresh"><i class="fa fa-sync"></i></button>
                            </div>
                        </div>


                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap" id="tb_complete">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tanggal</th>
                                    <th>Maintenance</th>
                                    <th>Dept</th>
                                    <th>Shift</th>
                                    <th>No. Request</th>
                                    <th>Nama Mesin</th>
                                    <th>No. Mesin</th>
                                    <th>No. Induk Mesin</th>
                                    <th>Masalah</th>
                                    <th>Kondisi</th>
                                    <th>Tindakan</th>
                                    <th>Klasifikasi</th>
                                    <th>Tgl Selesai</th>
                                    <th>Total Jam</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.card-body -->
    </div>
</div>
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-12 col-sm-6 col-md-3">
        <!-- Custom tabs (Charts with tabs)-->
        <a href="#" id="btn_stock">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Stock Gudang</span>
                    <span class="info-box-number"></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>


    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->

</div>
<div class="row">
    <div class="col-md-6">

        <!-- BAR CHART -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Jam Kerusakan <i id="periode"></i></h3>

            </div>
            <div class="card-body">
                <div>
                    <canvas id="chartjam"></canvas>
                </div>
            </div>
            <div class="card-footer">
                <label for="" id="totaljam2"></label>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div>
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Daftar Mesin Stop <i id="periode"></i></h3>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tb_mesinoff">
                    <thead>
                        <tr>
                            <th>Tanggal Rusak</th>
                            <th>Nomer Induk Mesin</th>
                            <th>Nama Mesin</th>
                            <th>No Mesin</th>
                            <th>Masalah</th>
                            <th>Total Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mesinoff as $mesin)
                        <tr>
                            <td>{{$mesin->tanggal_rusak}}</td>
                            <td>{{$mesin->no_induk_mesin}}</td>
                            <td>{{$mesin->nama_mesin}}</td>
                            <td>{{$mesin->no_urut_mesin}}</td>
                            <td>{{$mesin->masalah}}</td>
                            <td>{{ number_format($mesin->jam_rusak,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="row">
    <section class="col-lg-12 connectedSortable">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Perbaikan Terjadwal</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="tb_jadwal">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tanggal</th>
                                <th>Maintenance</th>
                                <th>Dept</th>
                                <th>No. Request</th>
                                <th>Nama Mesin</th>
                                <th>No. Mesin</th>
                                <th>No. Induk Mesin</th>
                                <th>Masalah</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>


    </section>
    <!-- right col -->
</div>
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="perbaikan-modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Proses Perbaikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">


                    <input type="hidden" id="id-req">
                    <div class="row">
                        <div class="col col-md-2"><label>No. :</label></div>
                        <div class="col col-md-3">
                            <label id="no-perbaikan"></label>
                        </div>
                        <div class="col col-md-2"><label>Departemen :</label></div>
                        <div class="col col-md-4">
                            <label id="dept"></label>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col col-md-2"><label>No. Mesin :</label></div>
                        <div class="col col-md-4">
                            <label id="no-mesin"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-2"><label>Nama Mesin :</label></div>
                        <div class="col col-md-8">
                            <label id="nama-mesin"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-2"><label>Masalah :</label></div>
                        <div class="col col-md-8">
                            <label id="masalah"></label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2"><label>Operator :</label></div>
                        <div class="form-group col-md-6">
                            <select name="" id="operator" class="select2 select2-hidden-accessible" multiple=""
                                data-placeholder="Pilih Operator" style="width: 100%;" data-select2-id="7" tabindex="-1"
                                aria-hidden="true">
                                @foreach($operator as $o)
                                <option value="{{$o->NIK}}">{{$o->NAMA}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2"><label>Klasifikasi :</label></div>
                        <div class="form-group col-md-9">

                            <select name="klasifikasi" id="klasifikasi" class="form-control">
                                <option value="">----Pilih klasifikasi-------</option>
                                <option value="A">A : Mesin/Alat masih bisa beroperasi dan hanya perbaikan ringan
                                </option>
                                <option value="B">B : Mesin/Alat masih bisa beroperasi dan harus dihentikan saat
                                    perbaikan
                                </option>
                                <option value="C">C : Mesin/Alat tidak bisa beroperasi</option>
                                <option value="D">D : Mesin/Alat Perbaikan sesuai Rencana atau Over Haul
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div id="accordion" class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="">Status : </label>
                                </div>
                                <div class="form-group col-md-3">
                                    <select name="" id="setatus" class="form-control">
                                        <option value="">---pilih status---</option>
                                        <option value="process">Process</option>
                                        <option value="selesai">Complete</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3" id="col_status">

                                </div>
                            </div>
                            <div id="collapseOne" class="panel-collapse in collapse" style="">
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Penyebab : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control" name="penyebab" id="penyebab"
                                            placeholder="Penyebab Kerusakan">
                                    </div>
                                </div>
                                <div class="form-row why">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Why 1 : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control why" name="why1" id="why1"
                                            placeholder="Why 1">
                                    </div>
                                </div>
                                <div class="form-row why">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Why 2 : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control why" name="why2" id="why2"
                                            placeholder="Why 2">
                                    </div>
                                </div>
                                <div class="form-row why">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Why 3 : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control why" name="why3" id="why3"
                                            placeholder="Why 3">
                                    </div>
                                </div>
                                <div class="form-row why">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Why 4 : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control why" name="why4" id="why4"
                                            placeholder="Why 4">
                                    </div>
                                </div>
                                <div class="form-row why">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Why 5 : </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control why" name="why5" id="why5"
                                            placeholder="Why 5">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="tindakan">Tindakan Perbaikan: </label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <textarea name="tindakan" id="tindakan" class="form-control" cols="30" rows="2"
                                            placeholder="Tindakan Perbaikan"></textarea>
                                    </div>
                                </div>
                                <div class="form-row why">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Tindakan Pencegahan: </label>
                                    </div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control why" name="pencegahan" id="pencegahan"
                                            placeholder="Tindakan Pencegahan">
                                    </div>
                                </div>
                                <div class="form-row" id="tgl_complete">
                                    <div class="form-group col-md-2">
                                        <label for="penyebab">Waktu Perbaikan : </label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control float-right" id="jamperbaikan">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">

                                        <label for="tindakan">Total Jam : </label>
                                    </div>
                                    <div class="form-group col-md-8 text-center">

                                        <label id="totaljam" style="font-size: 30px"></label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputpart">Part</label>
                                        <button type="button" class="btn-xs btn-success" id="btn_parts"><i
                                                class="fa fa-plus"></i>
                                            Sparepart</button>

                                        <table class="table table-bordered" id="tb_use">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px">Item Code</th>
                                                    <th>Nama</th>
                                                    <th style="width: 20px">Qty</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="collapse2" class="panel-collapse in collapse" style="">
                                <div class="form-row">
                                    <div class="form-group col-md-2"><label>Dijadwalkan :</label></div>
                                    <div class="form-group col-md-2">
                                        <input type="checkbox" class="form-control" id="jadwalchk" name="jadwalchk">
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="col col-md-2"><label>Jadwal :</label></div>
                                    <div class="form-group col-md-4">
                                        <label for="">Dari :</label>
                                        <input type="date" class="form-control" name="jadwal1" id="jadwal1">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Sampai :</label>
                                        <input type="date" class="form-control" name="jadwal2" id="jadwal2">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2"><label>Keterangan :</label></div>
                                    <div class="form-group col-md-8">
                                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                                            placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalitem"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Spareparts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive p-0">
                <div class="container">

                    <table id="tb_spareparts" class="table table-bordered table-striped dataTable">
                        <thead>

                            <th></th>
                            <th>Item_code</th>
                            <th>Item</th>
                            <th>Spesifikasi</th>

                        </thead>
                    </table>
                    <form action="">


                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="laincheck">
                            <label class="form-check-label" for="exampleCheck1">Sparepart Lain</label>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Lain-lain :</label>
                            <input type="text" name="lain" id="lain" class="form-control" placeholder="Parts lain"
                                disabled>

                        </div>


                        <div class="form-group col-md-3">
                            <label for="qty_parts">Qty:</label>
                            <input type="number" class="form-control" name="qty_parts" id="qty_parts" placeholder="Qty">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="button" class="btn btn-primary" id="pilih_item">Pilih Item</button>


            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modalstock"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">List Stock Gudang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive p-0">
                <div class="container">

                    <table id="tb_stock" class="table table-bordered table-striped dataTable">
                        <thead>
                            <th>Item_code</th>
                            <th>Item</th>
                            <th>Spesifikasi</th>
                            <th>Qty</th>
                            <th>Uom</th>
                            <th>Lokasi</th>
                        </thead>
                    </table>

                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal" id="part_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle">Keterangan</h5>
                <h5 id="no_req"></h5>
            </div>
            <div class="modal-body">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Analisa Masalah</h3>
                    </div>
                    <div class="card-body card-comments" id="isi_analisa">
                        <div class="card-comment">
                            <div class="comment-text">
                                <span class="username">
                                    Why 1

                                </span><!-- /.username -->
                                It is a long established fact that a reader will be distracted
                                by the readable content of a page when looking at its layout.
                            </div>
                            <!-- /.comment-text -->
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <table class="table table-bordered" id="tb_part">
                    <thead>
                        <tr>
                            <th>Item code</th>
                            <th>Nama Part</th>
                            <th>Qty</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btn_close">Close</button>

            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
@endsection
@section('script')
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript">
    cektoken();
    function cektoken(){
    var token = localStorage.getItem('mtc_token');
    if (!token) {
        window.location.href=APP_URL+'/mtc/splash';
    }
  }
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $(function(){
        $(".select2").select2({
            theme:'bootstrap4'
        });
    });
    var key = localStorage.getItem('mtc_token');
    var nama_operator;
    var p=[];
    var edit = false;
    var startPerbaikan;
    var endPerbaikan;
    var start = moment();
    var end = moment();
    var ctg = document.getElementById('chartjam').getContext('2d');
    var chartgr = new Chart(ctg, {
                            type: 'line',
                            data: {

                            },
                            options: {}
                        });
   
    $("#btn_shutdown").click(function(){
        var e = confirm("Apakah anda akan mematikan perangkat ini ?");
        if (e) {
            window.location.href = 'http://127.0.0.1:5000/shutdown';
        }
    });
    $("#setatus").prop('disabled', true);

    $("#btn_on").click(function(){
        
        $.ajax({
        url: 'http://127.0.0.1:5000/lampon',
        type: 'GET',
        dataType: 'jsonp',
        }).done(function(resp){
            alert(resp);
            console.log(resp);
        });
        
       
    });

    $("#btn_off").click(function(){
        $.ajax({
        url: 'http://127.0.0.1:5000/lampoff',
        type: 'GET',
        dataType: 'jsonp',
        }).done(function(resp){
            alert(resp);
            console.log(resp);
        });
    });
    $("#btn_stock").click(function(){
        $("#modalstock").modal("toggle");
    });
    var jamper = $('#jamperbaikan').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        startDate: start,
        endDate: end,
       // timePickerIncrement: 30,
      locale: {
        format: 'YYYY-MM-DD H:mm'
      }
     
    }, function(start,end) {
       
       startPerbaikan = start.format('YYYY-MM-DD H:mm:ss');
       endPerbaikan = end.format('YYYY-MM-DD H:mm:ss');
       var id =  $("#id-req").val();
        var klas = $("#klasifikasi").val();
       var d = {
            awal : startPerbaikan,
            akhir : endPerbaikan,
            id : id,
            klas : klas
        }
            action_data(APP_URL+"/api/mtc/hitungjam",d,key).done(function(resp){
               
                $("#totaljam").html(Number(resp[0].hasil).toFixed(2)+" Jam");
                
               
            });

       //console.log(startPerbaikan);
    });
    /*
    $("#jamperbaikan").on('apply.daterangepicker', function(ev, picker){
        console.log(picker.startDate.format('YYYY-MM-DD'));
        console.log(picker.endDate.format('YYYY-MM-DDThh:mm:ss'));
    });
    */
    get_data(key);
    var a = {
            dwg: 1,
        }  
    action_data(APP_URL+"/api/mtc/sasaranmutu",a,key).done(function(resp){
        if (resp.success) {
            var label = [];
            var tcast = [];
            var tgrind = [];
            var tmach = [];
            var vcast = [];
            var vgrind = [];
            var vmach = [];
            var tTotal = [];
            var vTotal = [];
           var mnth = ['0','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agus','Sept','Okt','Nov','Des'];
            var v = resp.data;
            for(var i in v){
                label.push(mnth[i]);
                tcast.push(v[i].tCast);
                tgrind.push(v[i].tGrind);
                tmach.push(v[i].tMach);
                vcast.push(v[i].hCast);
                vgrind.push(v[i].hGrind);
                vmach.push(v[i].hMach);
                tTotal.push(v[i].tTotal);
                vTotal.push(v[i].hTotal);
             }

             var u = {
                 target:tTotal,
                 hasil:vTotal,
                
             }
            
             chartjam( label, u, chartgr);
           
           }
    }).fail(function(){

    });
    var tb_req =   $('#tb_open').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/mtc/listreq',
                        type: "POST",
                        headers: { "token_req": key },
                        data: function(d){
                            d.stat_req = $("#status_req").val();
                        }
                        
                    },
        columnDefs:[
            {
                targets: [ 0 ],
                visible: false,
                searchable: false
            },
            {
                targets: [ 12 ],
                visible: false,
                searchable: false
            },
            {
                targets: [ 13 ],
                visible: false,
                searchable: false
            },
           
            {
              targets: [14],
              data: null,
              render: function(data, type, row, meta){
                  if (data.status == "open") {
                      
                    return "<button class='btn btn-success'><i class='fa fa-check'></i></button>";
                  
                  }else{
                    return "<button class='btn btn-warning'><i class='fa fa-edit'></i></button>";
                  }
                }
            }
        ],
       
        columns: [
            { data: 'id_perbaikan', name: 'id_perbaikan' },
            { data: 'tanggal_rusak', name: 'tanggal_rusak' },
            { data: 'operator', name: 'operator' },
            { data: 'departemen', name: 'departemen' },
            { data: 'user_name', name: 'user_name' },
            { data: 'klasifikasi', name: 'klasifikasi' },
            { data: 'no_perbaikan', name: 'no_perbaikan' },
            { data: 'nama_mesin', name: 'nama_mesin' },
            { data: 'no_urut_mesin', name: 'no_urut_mesin' },
            { data: 'no_induk_mesin', name: 'no_induk_mesin' },
            { data: 'masalah', name: 'masalah' },
            { data: 'kondisi', name: 'kondisi' },
            { data: 'lapor_ppic', name: 'lapor_ppic' },
            { data: 'status', name: 'status' },
        ],
        createdRow: function( row, data, dataIndex){
                if( data.status == "pending"){
                    $(row).css('background-color', '#ffff99');
                }else if(data.status == "selesai"){
                    $(row).css('background-color', '#66ff99');
                }else if(data.status == 'process'){
                    $(row).css('background-color', '#e0e0d1');
                }else if(data.status == 'scheduled'){
                    $(row).css('background-color', '#ffb3d9');
                }
                if(data.lapor_ppic == 'Y' && data.status != "selesai"){
                    $(row).css('background-color', '#ff0000');
                }

            }

    });
    var tb_selesai =   $('#tb_complete').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/mtc/listcompl',
                        type: "POST",
                        headers: { "token_req": key },
                        data: function(d){
                            d.tgl_awal = $("#tgl1").val();
                            d.tgl_akhir = $("#tgl2").val();
                        }
                        
                    },
        columnDefs:[
            {
                targets: [ 0 ],
                visible: false,
                searchable: false
            },
            
            {
                targets: [15],
                data: null,
                render: function(data, type, row, meta){
                        if (data.indicator > 0) {
                            
                        return "<button class='btn btn-primary'><i class='fas fa-question'></i></button>";
                        }
                        return "-"
                    
                    }
            }
        ],
       
        columns: [
            { data: 'id_perbaikan', name: 'id_perbaikan' },
            { data: 'tanggal_rusak', name: 'tanggal_rusak' },
            { data: 'operator', name: 'operator' },
            { data: 'departemen', name: 'departemen' },
            { data: 'shift', name: 'shift' },
            { data: 'no_perbaikan', name: 'no_perbaikan' },
            { data: 'nama_mesin', name: 'nama_mesin' },
            { data: 'no_urut_mesin', name: 'no_urut_mesin' },
            { data: 'no_induk_mesin', name: 'no_induk_mesin' },
            { data: 'masalah', name: 'masalah' },
            { data: 'kondisi', name: 'kondisi' },
            { data: 'tindakan', name: 'tindakan' },
            { data: 'klasifikasi', name: 'klasifikasi' },
            { data: 'tanggal_selesai', name: 'tanggal_selesai' },
            { data: 'total_jam_kerusakan', name: 'total_jam_kerusakan',render: $.fn.dataTable.render.number(',', '.', 2) },
        ]
    });

    var list_parts =  $('#tb_spareparts').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ordering: false,
                            ajax: {
                                            url: APP_URL+'/api/spareparts',
                                            type: "POST",
                                            headers: { "token_req": key },
                                        },
                             columnDefs : [{
                                            orderable : false,
                                            data : null,
    				                        defaultContent : '',
                                            className : 'select-checkbox',
                                            targets :   0,
					
					                        }],
					        select: {
                                        style :    'os',
                                        selector : 'td:first-child'
                                        },
                            columns: [
                                { data: null, name: 'check' },
                                { data: 'item_code', name: 'item_code' },
                                { data: 'item', name: 'item' },
                                { data: 'spesifikasi', name: 'spesifikasi' }
                               
                            ]
                        });

    $("#btn_refresh").click(function(){
        alarm_act('off');
        tb_selesai.ajax.reload();
    });

    var tb_stock =  $('#tb_stock').DataTable({
                            processing: true,
                            serverSide: true,
                            searching: true,
                            ordering: false,
                            ajax: {
                                            url: APP_URL+'/api/mtc/stockgudang',
                                            type: "POST",
                                            headers: { "token_req": key },
                                        },
                             columnDefs : [],
					       
                            columns: [
                               
                                {data: 'item_code', name: 'item_code' },
                                {data: 'item', name: 'item' },
                                {data: 'spesifikasi', name: 'spesifikasi' },
                                {data: 'end_stock', name: 'end_stock', render: $.fn.dataTable.render.number(',', '.', 0)},
                                {data: 'uom', name: 'uom'},
                                {data: 'rak_no', name: 'rak_no'},
                               
                            ]
                        });

    var tb_jadwal =   $('#tb_jadwal').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/mtc/getjadwal',
                        type: "POST",
                        headers: { "token_req": key },
                    },
        columnDefs:[
            {
                targets: [ 0 ],
                visible: false,
                searchable: false
            },{
                targets: [ 1 ],
                render: function(data, type, row, meta){
                 return moment(data.tanggal_rencana_selesai).format('YYYY-MM-DD');
                }
            }
        ],
       
        columns: [
            { data: 'id_perbaikan', name: 'id_perbaikan' },
            { data: 'tanggal_rencana_selesai', name: 'tanggal_rencana_selesai'},
            { data: 'operator', name: 'operator' },
            { data: 'departemen', name: 'departemen' },
            { data: 'no_perbaikan', name: 'no_perbaikan' },
            { data: 'nama_mesin', name: 'nama_mesin' },
            { data: 'no_urut_mesin', name: 'no_urut_mesin' },
            { data: 'no_induk_mesin', name: 'no_induk_mesin' },
            { data: 'masalah', name: 'masalah' },
            { data: 'kondisi', name: 'kondisi' },
        ]
    });
    $("#btn_parts").click(function(){
        list_parts.ajax.reload();
        $("#modalitem").modal("show");
    });
    $("#refresh_req").click(function(){
        tb_req.ajax.reload();
    });
    $("#setatus").on('change', function(){
        
        if (this.value == "pending") {
            $("#collapseOne").collapse("hide");
            $("#collapse2").collapse("show");
        }else if(this.value == "process"){
            $("#tgl_complete").hide();
            $("#collapse2").collapse("hide");
            $("#collapseOne").collapse("show");
        }else{
            $("#tgl_complete").show();
            $("#collapse2").collapse("hide");
            $("#collapseOne").collapse("show");
            if ($("#klasifikasi").val() == "C") {
                $(".why").show();
            }else{
                $(".why").hide();
            }
        }
    });

    $("#klasifikasi").on("change", function(){
       $("#setatus").attr('disabled', false);
       if (this.value == "C" && $("#setatus").val()=="selesai") {
        $(".why").show();
       }else{
        $(".why").hide();
       }
    });
   
    Echo.channel('notif')
            .listen('EventMessage', (e) => refresh_adata(tb_req, tb_selesai, key));
    

    $('#perbaikan-modal').on('hidden.bs.modal', function () {
        $("#collapseOne").collapse("hide");
        $("#collapse2").collapse("hide");
        $("#tb_use tbody").empty();
        $("#col_status").html("");
        $('#klasifikasi').prop('selectedIndex',0);
        $("#totaljam").html("");
        $(this).find('form').trigger('reset');
    })
    $('#modalitem').on('hidden.bs.modal', function () {
        $("#lain").prop("disabled",true);
        $(this).find('form').trigger('reset');
    })
    $("#tb_open").on('click','.btn-success',function(){
        var data = tb_req.row( $(this).parents('tr') ).data();
        edit = false;
        $("#mtc-operator").html("");
        $('#setatus').prop('selectedIndex',0);
        $("#setatus").attr("disabled",false);
        var kelas = $("#klasifikasi");
        var op = $("#operator");
        p=[];
       
        if (data.klasifikasi == '' || data.klasifikasi == null) {
            kelas.attr('disabled', false);
            $('#klasifikasi').prop('selectedIndex',0);
            $("#setatus").attr('disabled',true);
        }else{
            //$('#klasifikasi option[value="'+data.klasifikasi+'"]').attr('selected','selected');
            $('#klasifikasi').val(data.klasifikasi);
            kelas.attr('disabled', true);
        }
        var y = {
                id_req : data.id_perbaikan,
                setatus : "pending"
            }
            action_data(APP_URL+"/api/mtc/editcomplete",y,key).done(function(resp){
                if(resp.success){
                    op.val(resp.operator).trigger('change');
                }
            });

        $("#no-perbaikan").html(data.no_perbaikan);
        $("#id-req").val(data.id_perbaikan);
        $("#dept").html(data.departemen);
        $("#nama-mesin").html(data.nama_mesin);
        $("#masalah").html(data.masalah);
        //$("#mtc-operator").html(data.operator);
        $("#no-mesin").html(data.no_induk_mesin);

        $("#perbaikan-modal").modal("show");
        
    });

    $("#tb_open").on('click','.btn-warning',function(){
        var data = tb_req.row( $(this).parents('tr') ).data();
        edit = true;
        $("#mtc-operator").html("");
        var kelas = $("#klasifikasi");
        var op = $("#operator");
       
        
       
        if (data.klasifikasi == '' || data.klasifikasi == null) {
            kelas.attr('disabled', false);
            $('#klasifikasi').prop('selectedIndex',0);
        }else{
            //$('#klasifikasi option[value='+data.klasifikasi+']').attr('selected','selected');
            $('#klasifikasi').val(data.klasifikasi);
            kelas.attr('disabled', true);
            $("#setatus").attr('disabled',false);

           
        }
        if (data.klasifikasi == 'C') {
                $(".why").show();
            }else{
                $(".why").hide();
            }

        if (data.status == "pending" || data.status == "scheduled") {
            
            var y = {
                id_req : data.id_perbaikan,
                setatus : "pending"
            }
            action_data(APP_URL+"/api/mtc/editcomplete",y,key).done(function(resp){
                if (resp.success) {
                    var tgl1 = moment(resp.pend.tanggal_rencana_mulai).format('YYYY-MM-DD');
                    var tgl2 = moment(resp.pend.tanggal_rencana_selesai).format('YYYY-MM-DD');
                    var tglp = moment(resp.pend.tanggal_rencana_mulai).format('YYYY-MM-DDTH:mm:ss');
                    $("#keterangan").val(resp.pend.keterangan);
                    $("#jadwal1").val(tgl1);
                    $("#jadwal2").val(tgl2);
                    $("#tanggal_mulai").val(tglp);
                    $("#operator").val(resp.operator).trigger('change');

                    if (resp.perbaikan.status == 'scheduled') {
                        $("#jadwalchk").prop('checked', true);
                    }else{
                        $("#jadwalchk").prop('checked', false);
                    }
                   
                }
            });
          
        }else if(data.status == "process"){
           
            var t = {
            id_req : data.id_perbaikan,
            setatus : "selesai"
        };
            action_data(APP_URL+"/api/mtc/editcomplete",t,key).done(function(resp){
                if (resp.success) {
                    $("#penyebab").val(resp.perbaikan.penyebab);
                    $("#tindakan").val(resp.perbaikan.tindakan);
                    $("#operator").val(resp.operator).trigger('change');
                    if (resp.analis != null) {
                        $("#why1").val(resp.analis.why1);
                        $("#why2").val(resp.analis.why2);
                        $("#why3").val(resp.analis.why3);
                        $("#why4").val(resp.analis.why4);
                        $("#why5").val(resp.analis.why5);
                        $("#pencegahan").val(resp.analis.pencegahan);
                    }
                   
                    for (var i in resp.parts) {
                    var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="'+resp.parts[i].item_code+'" />'+resp.parts[i].item_code+'</td><td><input type ="hidden" name="part_name[]" value="'+resp.parts[i].nama_part+'" />'+resp.parts[i].nama_part+'</td><td><input type ="hidden" name="part_qty[]" value="'+resp.parts[i].qty+'" />'+resp.parts[i].qty+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#tb_use tbody').append(newrow); 

                    }

                }else{
                    alert(resp.message);
                }
            });
           
        }else{
           
           // $("#tgl_complete").html('<div class="form-group col-md-2"><label for="penyebab">Mulai : </label></div><div class="form-group col-md-4"><input type="datetime-local" class="form-control" name="tanggal_mulai" id="tanggal_mulai"></div><div class="form-group col-md-2"><label for="tindakan">Selesai : </label></div><div class="form-group col-md-4"><input type="datetime-local" class="form-control" name="tanggal_selesai" id="tanggal_selesai"></div>');
           $("#tgl_complete").show();
            var t = {
            id_req : data.id_perbaikan,
            setatus : "selesai"
            };
            action_data(APP_URL+"/api/mtc/editcomplete",t,key).done(function(resp){
                if (resp.success) {
                   
                    var tgl1 = moment(resp.perbaikan.tanggal_mulai).format('YYYY-MM-DD H:mm:ss');
                    var tgl2 = moment(resp.perbaikan.tanggal_selesai).format('YYYY-MM-DD H:mm:ss');
                   startPerbaikan = tgl1;
                   endPerbaikan = tgl2;
                    $("#penyebab").val(resp.perbaikan.penyebab);
                    $("#tindakan").val(resp.perbaikan.tindakan);
                    $("#operator").val(resp.operator).trigger('change');
                    if (resp.analis != null) {
                        $("#why1").val(resp.analis.why1);
                        $("#why2").val(resp.analis.why2);
                        $("#why3").val(resp.analis.why3);
                        $("#why4").val(resp.analis.why4);
                        $("#why5").val(resp.analis.why5);
                        $("#pencegahan").val(resp.analis.pencegahan);
                    }
                   
                    $("#totaljam").html(Number(resp.perbaikan.total_jam_kerusakan).toFixed(2)+" Jam");
                    //$( "#jamperbaikan" ).datepicker("setDate",tgl1+'-'+tgl2);
                    $('#jamperbaikan').data('daterangepicker').setStartDate(startPerbaikan);
                    $('#jamperbaikan').data('daterangepicker').setEndDate(endPerbaikan);
                    for (var i in resp.parts) {
                    var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="'+resp.parts[i].item_code+'" />'+resp.parts[i].item_code+'</td><td><input type ="hidden" name="part_name[]" value="'+resp.parts[i].nama_part+'" />'+resp.parts[i].nama_part+'</td><td><input type ="hidden" name="part_qty[]" value="'+resp.parts[i].qty+'" />'+resp.parts[i].qty+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    $('#tb_use tbody').append(newrow); 

                    }

                }else{
                    alert(resp.message);
                }
            });
          
        }
        var es = data.status;
       

        if (es == 'scheduled' || es == 'pending') {
            es = 'pending';
        }
       
        $("#setatus").val(es).trigger('change');
        $("#no-perbaikan").html(data.no_perbaikan);
        $("#id-req").val(data.id_perbaikan);
        $("#dept").html(data.departemen);
        $("#nama-mesin").html(data.nama_mesin);
        $("#masalah").html(data.masalah);
        //$("#mtc-operator").html(data.operator);
        $("#no-mesin").html(data.no_induk_mesin);
        $("#col_status").html("<button type='button' class='btn btn-danger' id='cancel_perbaikan'>Cancel Perbaikan</button>");
       
        $("#perbaikan-modal").modal("toggle");

    });


    $('#pilih_item').click(function() {
            var data = list_parts.row({ selected: true }).data();
            var qty = Number($('#qty_parts').val());
            var lain = $("#lain").val();
            if ($("#laincheck").prop('checked')) {
                if (lain == '' || lain == null) {
                    alert('Pilih data belum diisi !');
                }else{
                var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="-" />-</td><td><input type ="hidden" name="part_name[]" value="'+lain+'" />'+lain+'</td><td><input type ="hidden" name="part_qty[]" value="'+qty+'" />'+qty+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    
                        $('#tb_use tbody').append(newrow); 
                        data = null;
                        $("#laincheck").prop("checked",false);
                        $("#lain").prop("disabled",true);
                        $("#lain").val('');
                        $('#qty_parts').val(''); 
                        $('#modalitem').modal('toggle');
                        $("#perbaikan-modal").modal("handleUpdate");
            }
            }else{

            if (!data) {
					alert('Pilih Item !');
				}else{
					if (qty <= 0|| qty == null) {
						alert('Qty belum diisi !');
					}else{
                        var spek = data.spesifikasi;
                        if (data.spesifikasi == '' || data.spesifikasi == null) {
                            spek = "";
                        }
                        var newrow = '<tr><td><input type ="hidden" name="part_code[]" value="'+data.item_code+'" />'+data.item_code+'</td><td><input type ="hidden" name="part_name[]" value="'+data.item+' '+spek+'" />'+data.item+' '+data.spesifikasi+'</td><td><input type ="hidden" name="part_qty[]" value="'+qty+'" />'+qty+'</td><td><button type="button" class="btnSelect btn btn-xs btn-danger"><i class="fa fa-trash"></i></button></td></tr>';
                    
                        $('#tb_use tbody').append(newrow);  
                        data = null;
                        $("#laincheck").prop("checked",false);
                        $("#lain").prop("disabled",true);
                        $("#lain").val('');
                        $('#qty_parts').val(''); 
                        $('#modalitem').modal('toggle');
                        $("#perbaikan-modal").modal("handleUpdate");
                      
					}
				}
            }
        });

    $("#laincheck").click(function(){
        if (this.checked) {
            $("#lain").prop("disabled",false);
        }else{
            $("#lain").prop("disabled",true);
        }
    });
    $('#tb_use').on('click','.btnSelect', function(){
          var currentRow=$(this).closest("tr"); 
          currentRow.remove();
         
        });

    $("#col_status").on('click','#cancel_perbaikan', function(){
        var c = confirm("Apakah anda akan membatalkan perbaikan ini ?");
        var i = $("#id-req").val();
        if (c) {
            var d = {
                id_req : i,
            };
            action_data(APP_URL+"/api/mtc/postbatal",d,key).done(function(resp){
                if (resp.success) {
                    location.reload();
                }
            }).fail(function(){

            });
        }
    });

    $("#btn-save").click(function(){
        var op = $("#operator").val();
        var kel = $("#klasifikasi").val();
        //var tgl1 = $("#tanggal_mulai").val();
        //var tgl2 = $("#tanggal_selesai").val();
        var tgl1 = startPerbaikan;
        var tgl2 = endPerbaikan;
        var setat = $("#setatus").val();
       
            if (op == '' || op == null || kel == '' || kel == null) {
               
            alert("Operator atau klasifikasi belum dipilih !");
            
            }else{
                if(setat == '' || setat == null){
                    alert("Data belum lengkap !");
                   
                }else if (setat == "selesai") {
                    if (checkEmpty()) {
                    alert("Data belum lengkap !");
                   
                    }else{
                        var codes = [];
                        var names = [];
                        var qtys = [];
                        codes = $('input[name="part_code[]"]').map(function() {
                                    return this.value;
                                    }).get();
                        names = $('input[name="part_name[]"]').map(function() {
                                        return this.value;
                                        }).get();
                        qtys = $('input[name="part_qty[]"]').map(function() {
                                        return this.value;
                                        }).get();    
                    
                        var d = {
                            id_req : $("#id-req").val(),
                            part_code : codes,
                            part_name : names,
                            part_qty : qtys,
                            operator : op,
                            klasifikasi : kel,
                            penyebab : $("#penyebab").val(),
                            tindakan : $("#tindakan").val(),
                            why1 : $("#why1").val(),
                            why2 : $("#why2").val(),
                            why3 : $("#why3").val(),
                            why4 : $("#why4").val(),
                            why5 : $("#why5").val(),
                            pencegahan : $("#pencegahan").val(),
                            tgl_mulai :startPerbaikan,
                            tgl_selesai : endPerbaikan,
                            setatus : setat,
                        };
                        if (edit) {
                            action_data(APP_URL+"/api/mtc/posteditc",d,key).done(function(resp){
                                            if (resp.success) {
                                                //refresh_adata(tb_req,tb_selesai,key);
                                                //$("#perbaikan-modal").modal("toggle");
                                                location.reload();
                                            }else{
                                                alert(resp.message);
                                            }
                                            }).fail(function(){
                                            });
                                           
                        }else{
                            action_data(APP_URL+"/api/mtc/postcomplete",d,key).done(function(resp){
                                            if (resp.success) {
                                                //refresh_adata(tb_req,tb_selesai,key);
                                                //$("#perbaikan-modal").modal("toggle");
                                                location.reload();
                                            }else{
                                                alert(resp.message);
                                            }
                                            }).fail(function(){
                                            });
                                           
                        }
                                                            
                    }
            }else if(setat == "process"){
                var codes = [];
                var names = [];
                var qtys = [];

                codes = $('input[name="part_code[]"]').map(function() {
                            return this.value;
                            }).get();
                names = $('input[name="part_name[]"]').map(function() {
                                return this.value;
                                }).get();
                qtys = $('input[name="part_qty[]"]').map(function() {
                                return this.value;
                                }).get();    
                var d = {
                    id_req : $("#id-req").val(),
                    part_code : codes,
                    part_name : names,
                    part_qty : qtys,
                    operator : op,
                    klasifikasi : kel,
                    penyebab : $("#penyebab").val(),
                    tindakan : $("#tindakan").val(),
                    why1 : $("#why1").val(),
                    why2 : $("#why2").val(),
                    why3 : $("#why3").val(),
                    why4 : $("#why4").val(),
                    why5 : $("#why5").val(),
                    pencegahan : $("#pencegahan").val(),
                    setatus : setat,
                };
                if (edit) {
                    action_data(APP_URL+"/api/mtc/posteditr",d,key).done(function(resp){
                                    if (resp.success) {
                                      
                                        location.reload();
                                    }else{
                                        alert(resp.message);
                                    }
                                    }).fail(function(){
                                    });
                                    
                }else{
                    action_data(APP_URL+"/api/mtc/posteditr",d,key).done(function(resp){
                                    if (resp.success) {
                                       
                                        location.reload();
                                    }else{
                                        alert(resp.message);
                                    }
                                    }).fail(function(){
                                    });
                                    
                }
            }else{
                var jdw1 = $("#jadwal1").val();
                var jdw2 = $("#jadwal2").val();
                var schd = false;

                if (jdw1 == '' || jdw1 == null || jdw2 == '' || jdw2 == null || new Date(jdw1) > new Date(jdw2)) {
                    alert("Tanggal belum diisi !");
                   
                }else{
                    if ($("#jadwalchk").prop('checked')) {
                        schd = true;
                    }
                    var d = {
                            id_req : $("#id-req").val(),
                            operator : op,
                            klasifikasi : kel,
                            jadwal1 : $("#jadwal1").val(),
                            jadwal2 : $("#jadwal2").val(),
                            keterangan : $("#keterangan").val(),
                            setatus : setat,
                            schedule: schd,
                            };
                    if (edit) {
                        if (new Date(jdw1) > new Date(jdw2)) {
                            alert("Setting tanggal salah !");
                           
                        }else{
                            action_data(APP_URL+"/api/mtc/posteditp",d,key).done(function(resp){
                                if (resp.success) {
                                   
                                    location.reload();
                                }else{
                                    alert(resp.message);
                                }
                            }).fail(function(){

                            });
                           
                        }
                    }else{
                       
                    action_data(APP_URL+"/api/mtc/postpending",d,key).done(function(resp){
                                            if (resp.success) {
                                            location.reload();
                                            }else{
                                                alert(resp.message);
                                            }
                                            }).fail(function(){
                                            });
                                            
                    }
                   
                }
            }
            }
            
        
    });

    $("#tb_complete").on('click','.btn-primary', function(){
        var data = tb_selesai.row($(this).parents('tr')).data();
            $("#no_req").html(data.no_perbaikan);
            $('#tb_part tbody').empty();  
            $("#isi_analisa").empty();
            //getpart(data.id_perbaikan, key);
            var d= {
                id_req:data.id_perbaikan,
            };
            action_data(APP_URL+"/api/mtc/getparts",d,key).done(function(resp){
            for(var x in resp.analisa){
               
                var analis =  ' <div class="card-comment"><div class="comment-text"><span class="username">'+resp.analisa[x].indicatorname+'</span>'+resp.analisa[x].indicatorvalue+'</div></div>';
                $("#isi_analisa").append(analis);
            }
            for(var i in resp.parts){
                var newrow = '<tr><td>'+resp.parts[i].item_code+'</td><td>'+resp.parts[i].nama_part+'</td><td>'+resp.parts[i].qty+'</td></tr>';
           
                $('#tb_part tbody').append(newrow);  
            }
            $("#part_modal").modal("toggle");
            }).fail(function(){

            });
    });
   
});

function refresh_adata(tb1,tb2,key){
    tb1.ajax.reload();
    tb2.ajax.reload();
    get_data(key);
}

function get_data(key){
    $.ajax({
                url: APP_URL + '/api/mtc/getdata',
                type: 'POST',
                dataType: 'json',
                headers: { "token_req": key },
            })
                .done(function (resp) {
                    if (resp.success) {
                       $("#total_jam").html(resp.jam_rusak);
                       $("#tot_request").html(resp.tot_req);
                       $("#prosent").html(resp.procent +" %");
                       $("#tot_pending").html(resp.tot_pend);
                       $("#tot_rusak").html(resp.tot_rusak);
                    }
                    else
                        $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
}
function action_data(url, datas, key){
  return $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        headers: { "token_req": key },
        data: datas,
    });
}

function chartjam( lab, val, chart){

        
chart.data = {
            labels: lab,
            datasets: [
                {
                    label: 'Sasaran',
                    fill: false,
                    borderColor: 'rgb(0, 102, 255)',
                    pointBorderWidth: 3,
                    lineTension: 0.2,
                    data: val.target,
                    type: 'line'
            },
            {
                    label: 'Hasil',
                    fill: false,
                    borderColor: 'rgb(255, 102, 26)',
                    pointBorderWidth: 3,
                    lineTension: 0.2,
                    data: val.hasil,
                    type: 'line'
            },
            
           
                
            ]
           
};
chart.options = {
    tooltips: {
  callbacks: {
    title: function (tooltipItem, data) {
        //console.log(data['datasets'][tooltipItem[0]['datasetIndex']]['label']);
       
      return data['datasets'][tooltipItem[0]['datasetIndex']]['label'];
    },
    label: function (tooltipItem, data) {
       
      return tooltipItem.yLabel + ' Jam';
    }

  },
  backgroundColor: '#FFF',
  titleFontSize: 16,
  titleFontColor: '#0066ff',
  bodyFontColor: '#000',
  bodyFontSize: 14,
  displayColors: false
},
/*
    scales: {
                    yAxes: [
                        {
                            ticks: {
                                min: 0,
                                max: 100,// Your absolute max value
                                callback: function (value) {
                                return value + 'Jam'; // convert it to percentage
                                },
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Jam',
                            },
                            },
                    ],
                    },
                    */
};
chart.update();

}

function checkEmpty(){
    var op = $("#operator").html();
    var kel = $("#klasifikasi").val();
    
    var peny = $("#penyebab").val();
    var tind = $("#tindakan").val();

    if(op == '' || op == null){
        return true;
    }
    if(kel == '' || kel == null) {
        return true;
    }
    if(peny == '' || peny == null) {
        return true;
    }
    if(tind == '' || tind == null) {
        return true;
    }
    return false;
}
    
</script>
@endsection