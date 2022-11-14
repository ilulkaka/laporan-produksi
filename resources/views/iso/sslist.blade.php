@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">List SS</h3>
                    </div>
                </div>
                <div class="row align-center">

                </div>
            </div>
            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="row">
                <label for="" class="col-md-1 ">Status : </label>
                <select name="status_ss" id="status_ss" class="form-control col-md-2" value="Selesai">
                    <option value="All">All</option>
                    <option value="Masuk">Masuk</option>
                    <option value="ET1">ET1</option>
                    <option value="ET2">ET2</option>
                    <option value="Ditolak">Ditolak</option>
                    <option value="Tunda">Tunda</option>
                    <option value="Pengerjaan">Pengerjaan</option>
                    <option value="Selesai">Selesai</option>
                </select>
                <button class="btn btn-primary" id="btn_reload_status"><i class="fa fa-sync"></i></button>
            </div>
            <br>
            <table class="table table-hover text-nowrap" id="tb_ss_inquery">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>No SS</th>
                        <th>Status</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tema</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="card-footer">
            <button class="btn btn-secondary btn-flat" id="btn-print">Print PDF</button>
            <button type="button" class="btn btn-success btn-flat" id="btn-excel">Download Excel</button>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

<!-- Modal Insentif -->
<div class="modal fade" id="modal-insentif" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Insentif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="pdf" action="{{url ('insentifpdf')}}" target="_blank">
                    <div class="col col-md-12">
                        @csrf
                        <input type="date" class="col col-md-4" id="tgl_awal" name="tgl_awal"
                            value="{{date('Y-m').'-01'}}">
                        <label for="" class="col-md-2 text-center">Sampai</label>
                        <input type="date" class="col col-md-4" id="tgl_akhir" name="tgl_akhir"
                            value="{{date('Y-m-d')}}">
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col col-md-3"><label>Status</label></div>
                        <label>:</label>
                        <div class="col col-md-8">
                            <select name="status_ss" id="status_ss" class="form-control" required>
                                <option value="All">All</option>
                                <option value="ET1">ET1</option>
                                <option value="ET2">ET2</option>
                                <option value="Pengerjaan">Pengerjaan</option>
                                <option value="Masuk">Masuk</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col col-md-3"><label>Document</label></div>
                        <label>:</label>
                        <div class="col col-md-8">
                            <select name="document_ss" id="document_ss" class="form-control" required>
                                <option value="Insentif">Insentif</option>
                                <option value="TandaTerimaInsentif">Tanda Terima Insentif</option>
                                <option value="SSSelesai">SS Selesai</option>
                                <option value="SSMasuk">SS Masuk</option>
                                <option value="Pengerjaan">Pengerjaan</option>
                            </select>
                        </div>
                    </div>
                    <p>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" id="btn-export-pdf">Export PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Point -->
<div class="modal fade" id="edit-modal-poin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Point</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit-idss-1">
                <div class="row">
                    <div class="col col-md-2"><label>No. SS</label></div>
                    <label>:</label>
                    <div class="col col-md-2">
                        <label id="edit-noss-1"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col col-md-2"><label>Nama</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-nama-1"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-2"><label>NIK</label></div>
                    <label>:</label>
                    <div class="col col-md-6">
                        <label id="edit-nik-1"></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-2"><label>Tema</label></div>
                    <label>:</label>
                    <div class="col col-md-8">
                        <label id="edit-tema-1"></label>
                    </div>
                </div>
                <hr>

                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap" id="tb_approve_point">
                        <thead>
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Poin</th>
                                <th>Keterangan</th>
                                <th>Reward</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update-poin">Approve Poin & Reward</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Excel -->
<div class="modal fade" id="modal-excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="exportexcel">
                    <div class="col col-md-12">
                        @csrf
                        <div class="row">

                            <label for="" class="col-md-2">Tgl SS</label>
                            <input type="date" class="form-control col col-md-4" id="tgl_awal" name="tgl_awal"
                                value="{{date('Y-m').'-01'}}">
                            <label for="" class="col-md-1 text-center"> ~ </label>
                            <input type="date" class="form-control col col-md-4" id="tgl_akhir" name="tgl_akhir"
                                value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col col-md-3"><label>Status</label></div>
                        <label>:</label>
                        <div class="col col-md-8">
                            <select name="status_ss2" id="status_ss2" class="form-control" required>
                                <option value="All">All</option>
                                <option value="ET1">ET1</option>
                                <option value="ET2">ET2</option>
                                <option value="Pengerjaan">Pengerjaan</option>
                                <option value="Masuk">Masuk</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" id="btn-export-excel">Download
                            Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var listss = $('#tb_ss_inquery').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,

            ajax: {
                url: APP_URL + '/api/listdatass',
                type: "POST",
                headers: { "token_req": key },
                data: function (d) {
                    d.status_ss = $("#status_ss").val();
                }
            },

            columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false
            },
            {
                targets: [6],
                data: null,
                //defaultContent: "<button class='btn btn-success'>Complited</button>"
                render: function (data, type, row, meta) {
                    if (data.status_ss == "Ditolak") {
                        return "<button class='btn btn-danger btn-xs btn-flat disabled'>Ditolak</button>";
                    } else if (data.status_ss == "Selesai") {
                        return "<button class='btn btn-outline-danger btn-xs'>Finish</button> ";
                    } else if (data.status_ss == "ET2") {
                        return "<button class='btn btn-primary btn-xs'>Approve</button> <button class='btn btn-success btn-xs'>Detail</button>";
                    } else {
                        return "<button class='btn btn-success btn-xs'>Detail</button>";
                    }
                }
            }
            ],

            columns: [
                { data: 'id_ss', name: 'id_ss' },
                { data: 'no_ss', name: 'no_ss' },
                { data: 'status_ss', name: 'status_ss' },
                //{ data: 'tgl_penyerahan', name: 'tgl_penyerahan' },
                { data: 'nama', name: 'nama' },
                { data: 'nik', name: 'nik' },
                //{ data: 'bagian', name: 'bagian' },
                { data: 'tema_ss', name: 'tema_ss' },],
            //{ data: 'kategori', name: 'kategori' },]
            fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                if (data.status_ss == "Selesai") {
                    $('td', nRow).css('color', 'Blue');
                }
            },
        });

        listss.ajax.reload();

        $("#btn_reload_status").click(function () {
            listss.ajax.reload();
        });

        $("#tb_ss_inquery").on('click', '.btn-success', function () {
            var data = listss.row($(this).parents('tr')).data();
            window.location.href = APP_URL + "/ssdetail/" + data.id_ss;
        });

        $("#tb_ss_inquery").on('click', '.btn-outline-danger', function () {
            var data = listss.row($(this).parents('tr')).data();
            window.location.href = APP_URL + "/ssdetail/" + data.id_ss;
        });

        /*   $('#tb_ss_inquery').on('click', '.btn-secondary', function () {
               var data = listss.row($(this).parents('tr')).data();
               $("#edit-idss").val(data.id_ss);
               $("#edit-noss").html(data.no_ss);
               $("#edit-nama").html(data.nama);
               $("#edit-nik").html(data.nik);
               $("#edit-tema").val(data.tema_ss);
               $("#edit-masalah").html(data.masalah);
               $("#edit-ide").html(data.ide_ss);
               $("#edit-tujuan").html(data.tujuan_ss);
               $('#edit-status option[value=' + data.status + ']').attr('selected', 'selected');
               $("#edit-keterangan").html(data.keterangan);
               $('#edit-modal-ss').modal('show');
           }); */

        $('#tb_ss_inquery').on('click', '.btn-primary', function () {
            var data1 = listss.row($(this).parents('tr')).data();
            $("#edit-idss-1").val(data1.id_ss);
            $("#edit-noss-1").html(data1.no_ss);
            $("#edit-nama-1").html(data1.nama);
            $("#edit-nik-1").html(data1.nik);
            $("#edit-tema-1").html(data1.tema_ss);
            $("#edit-poin-1").html(data1.poin_ss);
            $("#edit-reward-1").html(data1.reward_ss);


            var id_ss = $("#edit-idss-1").val();
            //alert(id_ss);
            $.ajax({
                url: APP_URL + "/api/approve_point_ss",
                method: "POST",
                data: { "id_ss": id_ss },
                dataType: "json",
                headers: { "token_req": key },
                success: function (data) {
                    var nik = [];
                    var penilai = [];
                    var ket = [];
                    var poin = 0;
                    var tot = 0;
                    var tot2 = 0;
                    var r = 0;
                    var rr = 0;

                    $("#tb_approve_point tbody").empty();
                    $("#tb_approve_point tfoot").empty();


                    for (var i in data.Datas) {
                        nik = (data.Datas[i].nik);
                        penilai = (data.Datas[i].penilai);
                        poin = (data.Datas[i].poin);
                        ket = (data.Datas[i].keterangan);

                        tot = tot + Number(poin);
                        var newrow = '<tr><td>' + nik + '</td><td>' + penilai + '</td><td><name="i_acp_qty[]" value="/>' + poin + '</td><td>' + ket + '</td><td></td></tr>';
                        $('#tb_approve_point tbody').append(newrow);
                    }

                    for (var i in data.cou) {
                        rt = (data.cou[i].cou);
                    }

                    for (var i in data.rew) {
                        r = (data.rew.reward);
                    }

                    var r1 = Number(r);
                    var p = tot / Number(rt);

                    $("#tb_approve_point tfoot").append('<tr><th>Total :</th><th>' + rt + '</th><th>' + tot.toLocaleString("en-US") + '</th><th>' + p.toLocaleString("en-US") + '</th><th>' + parseInt(r1).toLocaleString() + '</th></tr>')
                }

            });

            $('#edit-modal-poin').modal('show');

        });

        $("#btn-save").click(function () {
            var idss = $("#edit-idss").val();
            var tema = $("#edit-tema").val();
            var masalah = $("#edit-masalah").val();
            var ide = $("#edit-ide").val();
            var tujuan = $("#edit-tujuan").val();
            var status = $("#edit-status").val();
            var keterangan = $("#edit-keterangan").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/iso/editss",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idss,
                    "tema": tema,
                    "masalah": masalah,
                    "ide": ide,
                    "tujuan": tujuan,
                    "status": status,
                    "keterangan": keterangan,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Update request berhasil");
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        location.reload();
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $("#btn-update-poin").click(function () {
            var idss = $("#edit-idss-1").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/iso/editpoin",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idss,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Update Poin berhasil");
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        $("#edit-modal-poin").modal('toggle');
                        listss.ajax.reload();
                        //location.reload();
                    } else
                        alert(resp.message);

                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
        });

        $("#btn-print").click(function () {
            $('#modal-insentif').modal('show');
        });

        $("#btn-excel").click(function () {
            $('#modal-excel').modal('show');
        });

        /*  $("#btn-print-pdf").click(function () {
              var tgl_awal = $('#tgl_awal').val();
              var tgl_akhir = $('#tgl_akhir').val();
              var status_ss = $('#status_ss').val();
              var part_no = $('#part_no').val();
  
              $.ajax({
                  type: "POST",
                  url: APP_URL + "/iso/insentifpdf",
                  headers: { "token_req": key },
                  data: { "tgl_awal": tgl_awal, "tgl_akhir": tgl_akhir, "status_ss": status_ss },
                  dataType: "json",
  
              })
                  .done(function (resp) {
                      if (resp.success) {
                          var fpath = resp.file;
                          window.open(fpath, '_blank');
                          $('#modal-insentif').modal('hide');
                      } else
                          alert(resp.message);
                  })
  
          });*/


        $("#exportexcel").submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: APP_URL + "/api/iso/get_isoexcel",
                headers: { "token_req": key },
                data: data,
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        $("#modal-excel").modal('toggle');
                        var fpath = resp.file;
                        window.open(fpath, '_blank');
                        alert(resp.message);
                    } else
                        alert(resp.message);
                })

        });

    });


</script>
@endsection