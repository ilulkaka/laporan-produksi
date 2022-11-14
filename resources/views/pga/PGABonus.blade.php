@extends('layout.main')
@section('content')


<div class="card card-warning card-tabs">
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                    role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Bonus Karyawan Umum</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                    role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Bonus Leader Up</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">

                <div class="row align-center">
                    <div class="row text-center">
                        <label for="" class="col-md-3 ">Periode</label>
                        <input type="month" class="form-control col-md-7" id="periode" value="{{date('Y-m')}}">
                        <button class="btn btn-primary" id="btn_reload"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
                <br>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_bonus">
                        <thead>
                            <tr>
                                <th>ID<p></p>
                                </th>
                                <th>NIK<p></p>
                                </th>
                                <th>Nama<p></p>
                                </th>
                                <th>Status<p></p>
                                </th>
                                <th>Departemen<p></p>
                                </th>
                                <th>1. Evaluasi <p>Hasil kinerja</p>
                                </th>
                                <th>2. Penilaian Sikap,<p>Kesadaran</p>
                                </th>
                                <th>T O T A L<p></p>
                                </th>
                                <th>Rata-Rata<p></p>
                                </th>
                                <th>Total Poin<p></p>
                                </th>
                                <th>Rank<p></p>
                                </th>
                                <th>Poin Penyesuaian<p></p>
                                </th>
                                <th>Keterangan<p></p>
                                </th>
                                <th>Action<p></p>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="btn-excel">Download Excel</button>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                aria-labelledby="custom-tabs-one-profile-tab">

                <div class="row align-center">
                    <div class="row text-center">
                        <label for="" class="col-md-3 ">Periode</label>
                        <input type="month" class="form-control col-md-7" id="periode_1" value="{{date('Y-m')}}">
                        <button class="btn btn-primary" id="btn_reload_1"><i class="fa fa-sync"></i></button>
                    </div>
                </div>
                <br>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_bonus_1">
                        <thead>
                            <tr>
                                <th>ID<p></p>
                                </th>
                                <th>NIK<p></p>
                                </th>
                                <th>Nama<p></p>
                                </th>
                                <th>Status<p></p>
                                </th>
                                <th>Departemen<p></p>
                                </th>
                                <th>1. Evaluasi <p>Hasil kinerja</p>
                                </th>
                                <th>2. Sikap,<p>Kesadaran</p>
                                </th>
                                <th>T O T A L<p></p>
                                </th>
                                <th>Rata-Rata<p></p>
                                </th>
                                <th>Total Poin <p>Production</p>
                                </th>
                                <th>Total Poin <p>Indirect</p>
                                </th>
                                <th>Rank<p>Production</p>
                                </th>
                                <th>Rank<p>Indirect</p>
                                </th>
                                <th>Poin Penyesuaian<p></p>
                                </th>
                                <th>Keterangan<p></p>
                                </th>
                                <th>Action<p></p>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success" id="btn-excel-1">Download Excel</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Karyawan Umum -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-bonus">
                <div class="row">
                    <div class="col col-md-4"><label>NIK</label></div>
                    <label>:</label>
                    <div class="col col-md-4">
                        <label id="nik"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>Nama</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-nama"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Departemen</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-departemen"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>POIN</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <input type="number" id="edit-poin">
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Keterangan</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <textarea class="form-control" name="edit-keterangan" id="edit-keterangan" cols="50" rows="4"
                            placeholder="Keterangan dari penambahan point atau dari pengurangan point"></textarea>
                    </div>
                </div>


                <div class="row">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-save">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Leader Up -->
<div class="modal fade" id="edit-modal-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Edit Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-bonus-1">
                <div class="row">
                    <div class="col col-md-4"><label>NIK</label></div>
                    <label>:</label>
                    <div class="col col-md-4">
                        <label id="nik-1"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-4"><label>Nama</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-nama-1"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Departemen</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-departemen-1"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>POIN</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <input type="number" id="edit-poin-1">
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-4"><label>Keterangan</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <textarea class="form-control" name="edit-keterangan-1" id="edit-keterangan-1" cols="50"
                            rows="4"
                            placeholder="Keterangan dari penambahan point atau dari pengurangan point"></textarea>
                    </div>
                </div>


                <div class="row">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-save-1">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var list_bonus = $('#tb_bonus').DataTable({
            processing: true,
            serverSide: true,
            searching: true,

            ajax: {
                url: APP_URL + '/api/rekapbonus',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode = $("#periode").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [7],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var hasil = (parseFloat(data.nilai1) + parseFloat(data.nilai4));
                    return hasil.toFixed(0);
                }
            },
            {
                targets: [8],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var hasil = ((parseFloat(data.nilai1) / 7) + (parseFloat(data.nilai4) / 4));
                    return hasil.toFixed(0);
                }
            },
            {
                targets: [9],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var hasil = (((parseFloat(data.nilai1) / 7) * (60 / 100) * 20) + ((parseFloat(data.nilai4) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai5)));
                    return hasil.toFixed(0);
                }
            },
            {
                targets: [10],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    if ((((parseFloat(data.nilai1) / 7) * (60 / 100) * 20) + ((parseFloat(data.nilai4) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai5))) >= 86) {
                        return "S";
                    } else if ((((parseFloat(data.nilai1) / 7) * (60 / 100) * 20) + ((parseFloat(data.nilai4) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai5))) >= 71) {
                        return "A";
                    } else if ((((parseFloat(data.nilai1) / 7) * (60 / 100) * 20) + ((parseFloat(data.nilai4) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai5))) >= 51) {
                        return "B";
                    } else if ((((parseFloat(data.nilai1) / 7) * (60 / 100) * 20) + ((parseFloat(data.nilai4) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai5))) >= 35) {
                        return "C";
                    } else {
                        return "D";
                    }
                }
            },
            {
                targets: [11],
                data: 'nilai5',
            },
            {
                targets: [12],
                data: 'keterangan',
            },
            {
                targets: [13],
                data: null,
                defaultContent: "<button class='btn btn-success'><i class='fa fa-edit'></i></button>"
            },
            ],
            columns: [
                { data: 'id_appraisal', name: 'id_appraisal' },
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'STATUS_KARYAWAN', name: 'STATUS_KARYAWAN' },
                { data: 'departemen', name: 'departemen' },
                { data: 'nilai1', name: 'nilai1' },
                { data: 'nilai4', name: 'nilai4' },
            ]
        });

        var key = localStorage.getItem('npr_token');
        var list_bonus_1 = $('#tb_bonus_1').DataTable({
            processing: true,
            serverSide: true,
            searching: true,

            ajax: {
                url: APP_URL + '/api/rekapbonus_1',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.periode_1 = $("#periode_1").val();
                }
            },
            columnDefs: [{

                targets: [0],
                visible: false,
                searchable: false
            },

            {
                targets: [7],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    return (parseFloat(data.nilai1) + parseFloat(data.nilai5));
                }
            },

            {
                targets: [8],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var hasil = ((parseFloat(data.nilai1) / 5) + (parseFloat(data.nilai5) / 4));
                    return hasil.toFixed(0);
                }
            },
            {
                targets: [9],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var hasil = (((parseFloat(data.nilai1) / 5) * (60 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai6)));
                    return hasil.toFixed(0);
                }
            },
            {
                targets: [10],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    //var f_dandori = parseFloat(data.dandori);
                    var hasil = (((parseFloat(data.nilai1) / 5) * (55 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (45 / 100) * 20) + (parseFloat(data.nilai6)));
                    return hasil.toFixed(0);
                }
            },
            {
                targets: [11],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    if (((parseFloat(data.nilai1) / 5) * (60 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai6)) >= 86) {
                        return "S";
                    } else if (((parseFloat(data.nilai1) / 5) * (60 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai6)) >= 71) {
                        return "A";
                    } else if (((parseFloat(data.nilai1) / 5) * (60 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai6)) >= 51) {
                        return "B";
                    } else if (((parseFloat(data.nilai1) / 5) * (60 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (40 / 100) * 20) + (parseFloat(data.nilai6)) >= 35) {
                        return "C";
                    } else {
                        return "D";
                    }
                }
            },
            {
                targets: [12],
                data: null,
                //defaultContent: "(select sum(dandori + kecepatan + ketelitian + improvement + sikap_kerja + penyelesaian_masalah + horenso) as total, nik from tb_appraisal group by nik, periode)"
                render: function (data, type, row, meta) {
                    if (((parseFloat(data.nilai1) / 5) * (55 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (45 / 100) * 20) + (parseFloat(data.nilai6)) >= 86) {
                        return "S";
                    } else if (((parseFloat(data.nilai1) / 5) * (55 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (45 / 100) * 20) + (parseFloat(data.nilai6)) >= 71) {
                        return "A";
                    } else if (((parseFloat(data.nilai1) / 5) * (55 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (45 / 100) * 20) + (parseFloat(data.nilai6)) >= 51) {
                        return "B";
                    } else if (((parseFloat(data.nilai1) / 5) * (55 / 100) * 20) + ((parseFloat(data.nilai5) / 4) * (45 / 100) * 20) + (parseFloat(data.nilai6)) >= 35) {
                        return "C";
                    } else {
                        return "D";
                    }
                }
            },
            {
                targets: [13],
                data: 'nilai6',
            },
            {
                targets: [14],
                data: 'keterangan',
            },
            {
                targets: [15],
                data: null,
                defaultContent: "<button class='btn btn-success'><i class='fa fa-edit'></i></button>"
            },
            ],
            columns: [
                { data: 'id_appraisal', name: 'id_appraisal' },
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'STATUS_KARYAWAN', name: 'STATUS_KARYAWAN' },
                { data: 'departemen', name: 'departemen' },
                { data: 'nilai1', name: 'nilai1' },
                { data: 'nilai5', name: 'nilai5' },
            ]
        });

        $("#btn_reload").click(function () {
            list_bonus.ajax.reload();
        });

        $("#btn_reload_1").click(function () {
            list_bonus_1.ajax.reload();
        });

        $("#btn-excel").click(function () {
            var periode = $('#periode').val();

            var c = confirm("Download Rekap Penilaian periode " + periode + "  .");
            if (c) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/pga/rekapbonus/get_excel",
                    headers: { "token_req": key },
                    data: { "periode": periode },
                    dataType: "json",

                    success: function (response) {
                        var fpath = response.file;
                        window.open(fpath, '_blank');
                    }
                });
            }
        });

        $('#tb_bonus').on('click', '.btn-success', function () {
            var data = list_bonus.row($(this).parents('tr')).data();
            $("#edit-bonus").val(data.id_appraisal);
            $("#nik").html(data.nik);
            $("#edit-nama").html(data.nama);
            $("#edit-departemen").html(data.departemen);
            $("#edit-poin").val(data.nilai5);
            $("#edit-keterangan").val(data.keterangan);
            $('#edit-modal').modal('show');
        });

        $("#btn-save").click(function () {
            var key = localStorage.getItem('npr_token');
            var poin_kebijakan = $("#edit-poin").val();
            var keterangan = $("#edit-keterangan").val();
            var id_bonus = $("#edit-bonus").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/edit_poin_bonus_umum",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": id_bonus,
                    "poin_kebijakan": poin_kebijakan,
                    "keterangan": keterangan,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Update Poin berhasil");
                        //window.location.href = "{{ route('list_PGABonus')}}";
                        $("#edit-modal").modal('toggle');
                        list_bonus.ajax.reload();
                    } else {
                        alert("Update Gagal, Penambahan Poin atau Pengurangan Poin melebihi batas ketentuan.");
                        //$("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $('#tb_bonus_1').on('click', '.btn-success', function () {
            var data = list_bonus_1.row($(this).parents('tr')).data();
            $("#edit-bonus-1").val(data.id_appraisal);
            $("#nik-1").html(data.nik);
            $("#edit-nama-1").html(data.nama);
            $("#edit-departemen-1").html(data.departemen);
            $("#edit-poin-1").val(data.nilai6);
            $("#edit-keterangan-1").val(data.keterangan);
            $('#edit-modal-1').modal('show');
        });

        $("#btn-save-1").click(function () {
            var key = localStorage.getItem('npr_token');
            var poin_kebijakan = $("#edit-poin-1").val();
            var keterangan = $("#edit-keterangan-1").val();
            var id_bonus = $("#edit-bonus-1").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/edit_poin_bonus_leaderup",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": id_bonus,
                    "poin_kebijakan": poin_kebijakan,
                    "keterangan": keterangan,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Update Poin berhasil");
                        //window.location.href = "{{ route('list_PGABonus')}}";
                        $("#edit-modal_1").modal('toggle');
                        list_bonus_1.ajax.reload();
                    } else {
                        alert("Update Gagal, Penambahan Poin atau Pengurangan Poin melebihi batas ketentuan.");
                        //$("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $("#btn-excel-1").click(function () {
            var periode = $('#periode_1').val();

            var c = confirm("Download Rekap Penilaian periode " + periode + "  .");
            if (c) {
                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/pga/rekapbonus/get_excel_leaderup",
                    headers: { "token_req": key },
                    data: { "periode": periode },
                    dataType: "json",

                    success: function (response) {
                        var fpath = response.file;
                        window.open(fpath, '_blank');
                    }
                });
            }
        });

    });



</script>

@endsection