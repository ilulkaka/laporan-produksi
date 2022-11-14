@extends('layout.main')
@section('content')

<head>
    <title>Cara Kode - Belajar CSS Dasar</title>
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
    </style>
</head>

<div class="card">
    <div class="card-header">

        <form action="{{url('/technical/input')}}" method="post" id="formbarcode">
            {{csrf_field()}}
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="form-group col-md-1">
                            <label for="notag">Tag no</label>
                            <input type="text" class="form-control" name="notag" id="notag" required>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="warna_tag">Warna Tag</label>
                            <select name="warna_tag" id="warna_tag" class="form-control">
                                <option value=""></option>
                                <option value="Putih">Putih</option>
                                <option value="Biru">Biru</option>
                                <option value="Kuning">Kuning</option>
                                <option value="Pink">Pink</option>
                                <option value="Hijau">Hijau</option>
                                <option value="Orange">Orange</option>
                                <option value="Merah">Merah</option>
                                <option value="Ungu">Ungu</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="nouki">Nouki</label>
                            <input type="month" class="form-control" name="nouki" id="nouki" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="finish">Customer</label>
                            <select name="customer" id="customer" class="form-control">
                                <option value=""></option>
                                <option value="NPR">NPR</option>
                                <option value="SINGAPORE">Singapore</option>
                                <option value="THAILAND">Thailand</option>
                                <option value="ISUZU">Isuzu</option>
                                <option value="HINO">Hino</option>
                                <option value="TRD">TRD</option>
                                <option value="KUBOTA">Kubota</option>
                                <option value="NTRI">NTRI</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="start">Start</label>
                            <input type="date" class="form-control" name="start" id="start" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="msk_kamu">Tgl Kamu</label>
                            <input type="date" class="form-control" name="msk_kamu" id="msk_kamu" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="finish">Finish</label>
                            <input type="date" class="form-control" name="finish" id="finish" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="barcodeno">Barcode No</label>
                    <input type="text" class="form-control" name="barcodeno" id="barcodeno">
                </div>
                <div class="form-group col-md-1">
                    <label for="barcodeno">_________</label>
                    <input type="submit" value="simpan" class="btn btn-success">
                </div>
                <div class="form-group col-md-8">
                    <p class="kanan">
                        <label for="totmas">Total Masalah</label>
                    </p>
                    <p class="kanan">
                        <label for="totmas" id="totalmasalah" style="color: red;">
                            {{$mas}}
                        </label>
                    </p>
                </div>
            </div>
        </form>
        <p>

        </p>

        <!-- List Inquery Work Result-->
        <div class="card card-warning card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                            href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                            aria-selected="true">List Work Result</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                            href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                            aria-selected="false">Item Bermasalah</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                        aria-labelledby="custom-tabs-one-home-tab">

                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_workresult">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>User Name</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Barcode No</th>
                                        <th>Part No</th>
                                        <th>Jby</th>
                                        <th>Lot No</th>
                                        <th>Qty</th>
                                        <th>No Tag</th>
                                        <th>Nouki</th>
                                        <th>Start</th>
                                        <th>Tgl Kamu</th>
                                        <th>Finish</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-one-profile-tab">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_workresult_1">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>User Name</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Barcode No</th>
                                        <th>Part No</th>
                                        <th>Jby</th>
                                        <th>Lot No</th>
                                        <th>Qty</th>
                                        <th>No Tag</th>
                                        <th>Nouki</th>
                                        <th>Start</th>
                                        <th>Tgl Kamu</th>
                                        <th>Finish</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>




        <div id="loadingscreen" class="eloading">
            <div id="text" class="spiner"><i class="fas fa-2x fa-sync fa-spin"></i></div>
        </div>

        @endsection

        @section('script')
        <!-- Select2 -->
        <script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
        <script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                //document.getElementById("loadingscreen").style.display = "block";
                loadingon();
                var key = localStorage.getItem('npr_token');
                var barcode_list = null;
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/workresult/getbarcode",
                    headers: {
                        "token_req": key,
                    },

                    dataType: "json",
                })
                    .done(function (resp) {
                        // document.getElementById("loadingscreen").style.display = "none";
                        loadingoff();
                        if (resp.success) {
                            barcode_list = resp.data;

                        } else
                            alert(resp.message);
                        $("#barcodeno").val('');
                        //$("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    });


                var workresult = $('#tb_workresult').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ordering: false,
                    ajax: {
                        url: APP_URL + '/api/listworkresult',
                        type: "POST",
                        headers: {
                            "token_req": key
                        },
                    },
                    columnDefs: [{

                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [15],
                        data: null,
                        defaultContent: "<button class='btn btn-danger'><i class='fa fa-trash'></i></button>"

                    }
                    ],

                    columns: [
                        { data: 'id_workresult', name: 'id_workresult' },
                        { data: 'user_name', name: 'user_name' },
                        { data: 'tgl_keluar', name: 'tgl_keluar' },
                        { data: 'barcode_no', name: 'barcode_no' },
                        { data: 'part_no', name: 'part_no' },
                        { data: 'jby', name: 'jby' },
                        { data: 'lot_no', name: 'lot_no' },
                        { data: 'qty', name: 'qty' },
                        { data: 'no_tag', name: 'no_tag' },
                        { data: 'nouki', name: 'nouki' },
                        { data: 'start', name: 'start' },
                        { data: 'msk_kamu', name: 'msk_kamu' },
                        { data: 'finish', name: 'finish' },
                        { data: 'customer', name: 'customer' },
                        { data: 'masalah', name: 'masalah' },
                    ],
                    fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                        if (data.masalah == "NG") {
                            $('td', nRow).css('background-color', '#ff9966');
                            $('td', nRow).css('color', 'White');
                        }
                    },
                });

                var workresult_1 = $('#tb_workresult_1').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ordering: false,
                    ajax: {
                        url: APP_URL + '/api/listworkresultmasalah',
                        type: "POST",
                        headers: {
                            "token_req": key
                        },
                    },
                    columnDefs: [{

                        targets: [0],
                        visible: false,
                        searchable: false
                    }
                    ],

                    columns: [
                        { data: 'id_workresult', name: 'id_workresult' },
                        { data: 'user_name', name: 'user_name' },
                        { data: 'tgl_keluar', name: 'tgl_keluar' },
                        { data: 'barcode_no', name: 'barcode_no' },
                        { data: 'part_no', name: 'part_no' },
                        { data: 'jby', name: 'jby' },
                        { data: 'lot_no', name: 'lot_no' },
                        { data: 'qty', name: 'qty' },
                        { data: 'no_tag', name: 'no_tag' },
                        { data: 'nouki', name: 'nouki' },
                        { data: 'start', name: 'start' },
                        { data: 'msk_kamu', name: 'msk_kamu' },
                        { data: 'finish', name: 'finish' },
                        { data: 'customer', name: 'customer' },
                        { data: 'masalah', name: 'masalah' },
                    ],
                    fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                        if (data.masalah == "NG") {
                            $('td', nRow).css('background-color', '#ff9966');
                            $('td', nRow).css('color', 'White');
                        }
                    },
                });

                $("#formbarcode").submit(function (e) {
                    e.preventDefault();
                    //alert($("#barcodeno").val());
                    //$("#barcodeno").val("");
                    var barcode_no = $("#barcodeno").val();
                    var dempyou = cariBC(barcode_no, barcode_list);
                    if (!dempyou) {
                        alert("Barcode salah!");
                    } else {

                        var partno = dempyou.i_item_cd;
                        var lotno = dempyou.i_seiban;
                        var jby = dempyou.i_proc_ptn;
                        var qty = dempyou.i_po_qty;
                        var tag_no = $("#notag").val();
                        var nouki = $("#nouki").val();
                        var start = $("#start").val();
                        var msk_kamu = $("#msk_kamu").val();
                        var finish = $("#finish").val();
                        var cust = $("#customer").val();
                        var warna_tag = $("#warna_tag").val();

                        $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/update_workresult",
                            headers: {
                                "token_req": key,
                            },
                            data: {
                                "barcode_no": barcode_no,
                                "tag_no": tag_no,
                                "nouki": nouki,
                                "start": start,
                                "msk_kamu": msk_kamu,
                                "finish": finish,
                                "partno": partno,
                                "lotno": lotno,
                                "jby": jby,
                                "qty": qty,
                                "customer": cust,
                                "warna_tag": warna_tag,
                            },
                            dataType: "json",
                        })
                            .done(function (resp) {
                                if (resp.success) {
                                    alert("Update data berhasil");
                                    $("#barcodeno").val('');
                                    workresult.ajax.reload();
                                    $("#totalmasalah").html(resp.totalmasalah);

                                } else
                                    alert(resp.message);
                                $("#barcodeno").val('');
                                //$("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                            })
                            .fail(function () {
                                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                            });
                    }
                });


                $("#tb_workresult").on('click', '.btn-danger', function () {
                    var data = workresult.row($(this).parents('tr')).data();
                    var conf = confirm("Apakah Lot No. " + data.lot_no + " akan dihapus?");
                    if (conf) {
                        $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/hapus/workresult",
                            headers: {
                                "token_req": key
                            },
                            data: {
                                "id": data.id_workresult
                            },
                            dataType: "json",
                        })
                            .done(function (resp) {
                                if (resp.success) {
                                    alert("Hapus request berhasil");
                                    //window.location.href = "{{ route('req_workresult')}}";
                                    workresult.ajax.reload();
                                    $("#totalmasalah").html(resp.totalmasalah);
                                } else
                                    $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                            })
                            .fail(function () {
                                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                            });
                    }

                });
            });

            function cariBC(bcno, mylist) {
                var count = 0;
                var ind = 0;
                for (var i = 0; i < mylist.length; i++) {
                    if (mylist[i].i_po_detail_no == bcno) {
                        count = 1;
                        ind = i;
                        //return mylist[i];
                        //alert(mylist[i].i_item_cd+", "+barcode_list[i].i_seiban+", "+barcode_list[i].i_po_qty);
                    }

                }

                if (count > 0) {

                    return mylist[ind];
                } else {
                    return false;
                }
            }

        </script>
        @endsection