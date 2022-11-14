@extends('layout.main')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="card card-warning">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">Point SS</h3>
                        <a href="{{url('/PDF/037. FM ISO 037 17I (Lembar Evaluasi Pelaksanaan Improvement).pdf')}}"
                            target="_blank">
                            <i class="fas fa-file-pdf nav-icon float-right" style="color: blue;"> <u> Kriteria
                                    Poin</u></i>
                        </a>
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
            <table class="table table-hover text-nowrap" id="tb_ss_inquery">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>No SS</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Tema</th>
                        <th>Poin</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
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
                        <div class="col col-md-7">
                            <select name="status_ss" id="status_ss" class="form-control" required>
                                <option value="All">All</option>
                                <option value="ET1">ET1</option>
                                <option value="ET2">ET2</option>
                                <option value="Masuk">Masuk</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col col-md-3"><label>Document</label></div>
                        <label>:</label>
                        <div class="col col-md-7">
                            <select name="document_ss" id="document_ss" class="form-control" required>
                                <option value="Insentif">Insentif</option>
                                <option value="TandaTerimaInsentif">Tanda Terima Insentif</option>
                                <option value="SSSelesai">SS Selesai</option>
                                <option value="SSMasuk">SS Masuk</option>
                            </select>
                        </div>
                    </div>
                    <p>

                    </p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-export-pdf">Export PDF</button>
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
                <div class="row">
                    <div class="col col-md-2"><label>Poin</label></div>
                    <label>:</label>
                    <div class="col col-md-3">
                        <input type="number" class="form-control" id="edit-poin-1" min="0" required>
                    </div>

                    <div class="col col-md-2"><label>Reward</label></div>
                    <label>:</label>
                    <div class="col col-md-4">
                        <input type="number" class="form-control" id="reward" min="0" required>
                    </div>
                </div>
                <p></p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update-poin">Update Poin</button>
                </div>
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
            processing: true,
            serverSide: true,
            searching: false,

            ajax: {
                url: APP_URL + '/api/listdatassnilai',
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
                        return "<button class='btn btn-success btn-xs'>Detail</button> ";
                    } else if (data.status_ss == "ET2") {
                        return "<button class='btn btn-success btn-xs'>Detail</button>";
                    } else {
                        return "<button class='btn btn-success btn-xs'>Detail</button>";
                    }
                }
            }
            ],

            columns: [
                { data: 'id_ss', name: 'id_ss' },
                { data: 'no_ss', name: 'no_ss' },
                //{ data: 'tgl_penyerahan', name: 'tgl_penyerahan' },
                { data: 'nama', name: 'nama' },
                { data: 'nik', name: 'nik' },
                //{ data: 'bagian', name: 'bagian' },
                { data: 'tema_ss', name: 'tema_ss' },
                { data: 'poin', name: 'poin' },
            ],
            //{ data: 'kategori', name: 'kategori' },]
            fnRowCallback: function (nRow, data, iDisplayIndex, iDisplayIndexFull) {
                if (data.status_ss == "Selesai") {
                    $('td', nRow).css('color', 'Blue');
                }
            },
        });

        $("#btn_reload_status").click(function () {
            listss.ajax.reload();
        });

        $("#tb_ss_inquery").on('click', '.btn-success', function () {
            var data = listss.row($(this).parents('tr')).data();
            window.location.href = APP_URL + "/ssdetailpoint/" + data.id_ss;
        });

        $('#tb_ss_inquery').on('click', '.btn-primary', function () {
            var data = listss.row($(this).parents('tr')).data();
            $("#edit-idss-1").val(data.id_ss);
            $("#edit-noss-1").html(data.no_ss);
            $("#edit-nama-1").html(data.nama);
            $("#edit-nik-1").html(data.nik);
            $("#edit-tema-1").html(data.tema_ss);
            $("#edit-poin-1").html(data.poin_ss);
            $("#edit-reward-1").html(data.reward_ss);
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
            var poin = $("#edit-poin-1").val();
            var reward = $("#reward").val();
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/iso/editpoin",
                headers: {
                    "token_req": key
                },
                data: {
                    "id": idss,
                    "poin": poin,
                    "reward": reward,
                },
                dataType: "json",
            })
                .done(function (resp) {
                    if (resp.success) {
                        alert("Update Poin berhasil");
                        //window.location.href = "{{ route('req_permintaan_tch')}}";
                        location.reload();
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

    });


</script>
@endsection