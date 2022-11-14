@extends('layout.main')
@section('content')
    <div class="card">
        <div class="card-header">

            <div class="card card-success">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="card-title" style="font-size:x-large">Hasil Produksi</h3>
                            <span class="float-right">
                                <button class="btn btn-sm" id="btn-entryjamoperator">
                                    <!--<font color="white"><i class="far fa-clock mr-1"></i>
                                        <a href='#'><u style="font-size: large;">
                                                Approve Jam Operator</u></a>
                                    </font>-->
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

            </div>



            <div class="row">
                <div class="col col-md-2">
                    <input type="date" class="form-control" id="tgl_awal" value="{{ date('Y-m') . '-01' }}">
                </div>
                <label for="" class="col-md-1 text-center">Sampai</label>
                <input type="date" class="form-control col-md-2" id="tgl_akhir" value="{{ date('Y-m-d') }}">

                <div class="col col-md-1 text-right"><label> Line</label></div>

                <div class="col col-md-3">
                    <select name="selectline" id="selectline" class="form-control select2 " style="width: 100%;" required>
                        <option value="All">All</option>
                        @foreach ($proses as $p)
                            <option value="{{ $p->line_proses }}">{{ $p->nama_line }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" id="btn_reload1"><i class="fa fa-sync"></i></button>
            </div>
            <p>
                @if (Session('nik') != '000000')
                    <span class="float-left">
                        <button class="btn btn-sm" id="btn-tambahng"><i class="fas fa-plus-circle mr-1"></i>
                            Add</button>
                        <button class="btn btn-sm" id="btn-deleteng"><i class="fas fa-trash mr-1"></i>
                            Delete</button>
                    </span>
                @else
                @endif
                <hr>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="tb_detail_hasil_produksi">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Proses</th>
                            <th>Tgl Proses</th>
                            <th>Part No</th>
                            <th>Lot No</th>
                            <th>Shape</th>
                            <th>Haba</th>
                            <th>Incoming</th>
                            <th>Finish Qty</th>
                            <th>NG Qty</th>
                            <th>Prosentase</th>
                            <th>Operator</th>
                            <th>Shift</th>
                            <th>No Mesin</th>
                            <th>Cycle</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-success" id="btn-excel">Download Excel</button>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

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

    <!-- Modal Add NG-->
    <div class="modal fade" id="modal-tambahng" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Tambah Data NG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form_tambahng">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <div class="col col-md-4"><label>Kode NG</label></div>
                            <label>:</label>
                            <div class="col col-md-3">
                                <input type="text" class="form-control" name="t_code_ng" id="t_code_ng" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col col-md-4"><label>Type NG</label></div>
                            <label>:</label>
                            <div class="col col-md-7">
                                <input type="text" id="t_type_ng" name="t_type_ng" class="form-control" required>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                            <input type="submit" class="btn btn-primary" id="simpan_tambahng" name="simpan_tambahng"
                                value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete data NG-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="modal-deleteng"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List NG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive p-0">
                    <div class="container">

                        <table id="tb_listng" class="table table-bordered table-striped dataTable">
                            <thead>
                                <th>Select</th>
                                <th>Code NG</th>
                                <th>Type NG</th>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="pilih_item">Pilih Item</button>
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
    <script>
        $(function() {

            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });

        $(document).ready(function() {
            var key = localStorage.getItem('npr_token');

            var list_ng = $('#tb_listng').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/produksi/listng',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                },
                columnDefs: [{
                    orderable: false,
                    data: null,
                    defaultContent: '',
                    className: 'select-checkbox',
                    targets: 0,

                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                columns: [{
                        data: null,
                        name: 'check'
                    },
                    {
                        data: 'kode_ng',
                        name: 'kode_ng'
                    },
                    {
                        data: 'type_ng',
                        name: 'type_ng'
                    },

                ]
            });

            var detail_hasil = $('#tb_detail_hasil_produksi').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/api/inquery_report_detail',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                    data: function(d) {
                        d.tgl_awal = $("#tgl_awal").val();
                        d.tgl_akhir = $("#tgl_akhir").val();
                        d.selectline = $("#selectline").val();
                    }
                },
                columnDefs: [{

                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [16],
                        data: null,
                        defaultContent: "<button class='btn btn-danger btn-sm'><i class='far fa-trash-alt'></i></button>"
                    }
                ],

                columns: [{
                        data: 'id_hasil_produksi',
                        name: 'id_hasil_produksi'
                    },
                    {
                        data: 'line1',
                        name: 'line1'
                    },
                    {
                        data: 'tgl_proses',
                        name: 'tgl_proses'
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
                        data: 'shape',
                        name: 'shape'
                    },
                    {
                        data: 'ukuran_haba',
                        name: 'ukuran_haba'
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
                        name: 'ng_qty',
                        render: function(data, type, row, meta) {
                            if (data > 0) {
                                return "<u><a href='' class='detailng'>" + data + "</a></u>";
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'pro',
                        name: 'pro',
                        render: $.fn.dataTable.render.number(',', '.', 2, '', ' %')
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
                    {
                        data: 'remark',
                        name: 'remark'
                    },
                ]
            });

            $('#tb_detail_hasil_produksi').on('click', '.btn-danger', function() {
                var data = detail_hasil.row($(this).parents('tr')).data();
                var conf = confirm("Apakah Lot No. " + data.lot_no + " akan dihapus?");
                if (conf) {
                    $.ajax({
                            type: "POST",
                            url: APP_URL + "/api/hapus/lotno_hasilproduksi",
                            headers: {
                                "token_req": key
                            },
                            data: {
                                "id": data.id_hasil_produksi
                            },
                            dataType: "json",
                        })
                        .done(function(resp) {
                            if (resp.success) {
                                alert("Hapus Lot No berhasil");
                                location.reload();
                                //window.location.href = "{{ route('req_permintaan') }}";
                            } else
                                $("#error").html(
                                    "<div class='alert alert-danger'><div>Error</div></div>");
                        })
                        .fail(function() {
                            $("#error").html(
                                "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                                );

                        });
                }
            });

            $("#btn_reload1").click(function() {
                var date1 = $("#tgl_awal").val();
                var date2 = $("#tgl_akhir").val();
                detail_hasil.ajax.reload();
            });

            var detail_ng = $('#tb_ng').DataTable({

            });

            $('#tb_detail_hasil_produksi').on('click', '.detailng', function(e) {
                e.preventDefault();
                var data = detail_hasil.row($(this).parents('tr')).data();
                get_details_ng(data, key);
                $("#detaillist").val(data.id_hasil_produksi);
                $('#modal-NG').modal('show');
            });

            $("#btn-close-list").click(function() {
                $('#modal-NG').modal('hide');
            });

            function get_details_ng(data, key) {
                var detail_ng1 = $('#t_detail_NG').DataTable({
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
                    columns: [

                        {
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

            $("#btn-excel").click(function() {
                var tgl_awal = $('#tgl_awal').val();
                var tgl_akhir = $("#tgl_akhir").val();
                var selectline = $("#selectline").val();

                var c = confirm("Download Hasil Produksi periode " + tgl_awal + "  Sampai  " + tgl_akhir +
                    "  Line " + selectline);
                if (c) {
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/produksi/get_excel_hasilproduksi",
                        headers: {
                            "token_req": key
                        },
                        data: {
                            "tgl_awal": tgl_awal,
                            "tgl_akhir": tgl_akhir,
                            "selectline": selectline
                        },
                        dataType: "json",

                        success: function(response) {
                            var fpath = response.file;
                            window.open(fpath, '_blank');
                        }
                    });
                }
            });

            $("#btn-tambahng").click(function() {
                $('#modal-tambahng').modal('show');
            });

            $("#form_tambahng").submit(function(e) {
                e.preventDefault();
                var datas = $(this).serialize();
                //var key = localStorage.getItem('produksi_token');
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/produksi/tambahng",
                        headers: {
                            "token_req": key
                        },
                        data: datas,
                        dataType: "JSON",
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        } else {
                            alert(resp.message)
                        }
                    })
                    .fail(function() {
                        $("#error").html(
                            "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                            );
                    });
            });

            $("#btn-deleteng").click(function() {
                list_ng.ajax.reload();
                $('#modal-deleteng').modal('show');
            });

            $('#pilih_item').click(function() {
                var data = list_ng.row({
                    selected: true
                }).data();
                if (!data) {
                    alert('Item Belum dipilih !');
                } else {
                    var c = confirm("Hapus Data NG  " + data.kode_ng + "  " + data.type_ng + "?");
                    if (c) {
                        $.ajax({
                                type: "POST",
                                url: APP_URL + "/api/produksi/deleteng",
                                headers: {
                                    "token_req": key
                                },
                                data: data,
                                dataType: "JSON",
                            })
                            .done(function(resp) {
                                if (resp.success) {
                                    alert(resp.message);
                                    location.reload();
                                } else {
                                    alert(resp.message)
                                }
                            })
                            .fail(function() {
                                $("#error").html(
                                    "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                                    );
                            });
                    }
                }
            });

        });
    </script>
@endsection
