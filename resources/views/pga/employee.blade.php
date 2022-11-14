@extends('layout.main')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h1
                            style="font-size:50px; font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                            {{$karyawan}}</h1>

                        <p>Total Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @if (Session::get('dept') == 'PGA' || Session::get('dept') == 'Admin')
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="fa fa-upload">
                        <a href="{{url('/pga/absensi_upload')}}"> Upload
                            Data Absensi </a>|| <a class="fas fa-list-ol"><a href="{{url('/pga/listabsensi')}}"> List
                                Absensi </a>|| <a class="fas fa-list-ul">
                                <a href="{{url('/pga/listpkwt')}}"> List
                                    PKWT </a>
                    </li>
                </ol>
            </div>
            @endif

        </div>
    </div><!-- /.container-fluid -->
    <div class="row">
        <div class="col-md-3 col-sm-4 col-8">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-bookmark"></i></span>

                <div class="info-box-content">
                    <div class="inner">
                        @foreach ($statusk as $t)
                        <label> {{$t->status_karyawan}}</label>
                        <label>:</label>
                        <label> {{$t->total}}</label><br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-8">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="far fa-bookmark"></i></span>

                <div class="info-box-content">
                    <div class="inner">
                        @foreach ($jenisk as $t)
                        <label>{{$t->jenis_kelamin}}</label>
                        <label>:</label>
                        <label> {{$t->total}}</label><br>

                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">
                        <div class="card card-warning">
                            <div class="card-header">
                                <div class="row">

                                    <div class="col-12">
                                        <h3 class="card-title">List Section</h3>
                                    </div>

                                </div>
                            </div>
                            <div class="card-tools">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="t_karyawan">
                                <thead>
                                    <tr>
                                        <th>Departemen</th>
                                        <th>Section</th>
                                        <th>Total</th>
                                        <th>Ket</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <div class="col-md-4">

                <div class="card">
                    <div class="card-header">
                        <div class="card card-warning">
                            <div class="card-header">
                                <div class="row">

                                    <div class="col-12">
                                        <h3 class="card-title">Position</h3>
                                    </div>

                                </div>
                            </div>
                            <div class="card-tools">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap" id="t_karyawan_1">
                                <thead>
                                    <tr>
                                        <th>Jabatan</th>
                                        <!-- <th>Section</th> -->
                                        <th>Total</th>
                                        <th>Ket</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- --- Modal List Section --- -->
<div class="modal fade bd-example-modal-lg" id="detail-modal-list" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detaillist">Detail List Karyawan</h5>
            </div>
            <div class="modal-body">

                <table class="table table-responsive" id="t_karyawan_3">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Section</th>
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

<!-- --- Modal Position --- -->
<div class="modal fade bd-example-modal-lg" id="detail-modal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLongTitle">Detail Karyawan</h5>
            </div>
            <div class="modal-body">

                <table class="table table-responsive" id="t_karyawan_2">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Section</th>
                        </tr>
                    </thead>
                </table>

            </div>
            <div class="modal-footer">
                <div class="col col-md-3">
                    <button type="button" class="btn btn-secondary" id="btn-close">Close</button>
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
        var dept_section = $('#dept_section').val();
        var karyawan = $('#t_karyawan').DataTable({
            processing: true,
            serverSide: false,
            searching: true,
            ordering: true,
            ajax: {
                url: APP_URL + '/api/countkaryawan',
                type: "POST",
                headers: { "token_req": key },
                data: { "dept_section": dept_section },
            },
            columnDefs: [{

                targets: [2],
                data: 'total',
            },
            {
                targets: [3],
                data: null,
                defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-flat'>Detail</button>"

            }
            ],

            columns: [
                { data: 'nama_departemen', name: 'nama_departemen' },
                { data: 'dept_section', name: 'dept_section' },

            ],
        });

        var key = localStorage.getItem('npr_token');
        var dept_section = $('#dept_section').val();
        var nama_jabatan = $('#nama_jabatan').val();
        var karyawan_1 = $('#t_karyawan_1').DataTable({
            processing: true,
            serverSide: false,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/countkaryawan_1',
                type: "POST",
                headers: { "token_req": key },
                data: { "dept_section": dept_section, "nama_jabatan": nama_jabatan },
            },
            columnDefs: [{

                targets: [1],
                data: 'total',
            },
            {
                targets: [2],
                data: null,
                defaultContent: "<button type='button' class='btn btn-block btn-outline-primary btn-flat'>Detail</button>"

            }
            ],

            columns: [
                { data: 'nama_jabatan', name: 'nama_jabatan' },
            ],
        });
        /*
                $('#t_karyawan_1').on('click', '.btn-flat', function () {
                    get_details();
                    $('#ModalLongTitle').html(nama_jabatan);
                    $('#nama_jabatan').html(nama_jabatan);
                    $('#detail-modal').modal('show');
                });
        */



        $('#t_karyawan_1').on('click', '.btn-flat', function () {
            var data = karyawan_1.row($(this).parents('tr')).data();
            get_details(data, key);
            $("#ModalLongTitle").val(data.nama_jabatan);
            $('#detail-modal').modal('show');
        });

        $('#t_karyawan').on('click', '.btn-flat', function () {
            var data = karyawan.row($(this).parents('tr')).data();
            get_details_list(data, key);
            $("#detaillist").val(data.dept_section);
            $('#detail-modal-list').modal('show');
        });

        $("#btn-close").click(function () {
            $('#detail-modal').modal('hide');
        });

        $("#btn-close-list").click(function () {
            $('#detail-modal-list').modal('hide');
        });




    });

    function get_details(data, key) {
        var key = localStorage.getItem('npr_token');
        var karyawan_2 = $('#t_karyawan_2').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/detail_karyawan',
                type: "POST",
                headers: { "token_req": key },
                data: { "nama_jabatan": data },


            },
            columns: [

                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'nama_jabatan', name: 'nama_jabatan' },
                { data: 'dept_section', name: 'dept_section' },

            ]


        });
    }

    function get_details_list(data, key) {
        var key = localStorage.getItem('npr_token');
        var karyawan_3 = $('#t_karyawan_3').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            searching: true,
            ordering: false,
            ajax: {
                url: APP_URL + '/api/detail_karyawan_list',
                type: "POST",
                headers: { "token_req": key },
                data: { "dept_section": data },


            },
            columns: [

                { data: 'nik', name: 'nik' },
                { data: 'nama', name: 'nama' },
                { data: 'nama_jabatan', name: 'nama_jabatan' },
                { data: 'dept_section', name: 'dept_section' },

            ]


        });
    }


</script>

@endsection