@extends('layout.main')
@section('content')


<div class="card card-outline-primary card-tabs">
    <div class="row">
        <div class="col-12" style="text-align: left; padding-left: 20px; padding-top: 5px;">
            <h5>
                <i class="fa fa-address-book"></i>
                <b><u> Standart Kompetensi & Skill Matrik </u></b>
            </h5>
        </div>
    </div>
    <div class="card-header p-0 pt-1">
        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                    role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Internal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile"
                    role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Eksternal</a>
            </li>

        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                aria-labelledby="custom-tabs-one-home-tab">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_lnsm">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tgl Masuk</th>
                                        <th>Departemen</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>
                </div>
                <!-- /.card-body -->
            </div>

            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                aria-labelledby="custom-tabs-one-profile-tab">

                <div class="card-body table-responsive p-0">
                    <blockquote class="quote-secondary">
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="tb_lnsm_eksternal" width="1000px">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tgl Masuk</th>
                                        <th style="width: 70px;">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </blockquote>
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

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });


    $(document).ready(function () {

        var key = localStorage.getItem('npr_token');
        var insm = $('#tb_lnsm').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/pga/inquerynamaskillmatrik',
                type: "POST",
                headers: { "token_req": key },
            },
            columnDefs: [
                {
                    targets: [4],
                    data: null,
                    defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-sm btn-flat'>Detail</button>"

                },
            ],

            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'tanggal_masuk', name: 'tanggal_masuk' },
                { data: 'dept_pelatihan', name: 'dept_pelatihan' },

            ],
        });

        var insm_eksternal = $('#tb_lnsm_eksternal').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/pga/inquery_ln_eksternal',
                type: "POST",
                headers: { "token_req": key },
            },
            columnDefs: [
                {
                    targets: [3],
                    data: null,
                    defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-sm btn-flat'>Detail</button>"

                },
            ],

            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'tanggal_masuk', name: 'tanggal_masuk' },
            ],
        });

        $('#tb_lnsm').on('click', '.btn-flat', function () {
            var data = insm.row($(this).parents('tr')).data();
            $("#namasm").val(data.nik);
            //alert(data.id_tema_pelatihan);
            //window.location.href = APP_URL + "/pga/listskillmatrik/" + data.nik + "/" + data.nama;
            window.location.href = APP_URL + "/pga/listskillmatrik/" + data.nik + "/" + data.nama;
        });

        $('#tb_lnsm_eksternal').on('click', '.btn-flat', function () {
            var data = insm_eksternal.row($(this).parents('tr')).data();
            $("#namasm_1").val(data.nik);
            //alert(data.nik);
            //window.location.href = APP_URL + "/pga/listskillmatrik/" + data.nik + "/" + data.nama;
            window.location.href = APP_URL + "/pga/listskilleksternal/" + data.nik + "/" + data.nama;
        });




    });




</script>

@endsection