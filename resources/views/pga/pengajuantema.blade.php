@extends('layout.main')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" id="namasm" name="namasm">
                            <i class="fa fa-address-book"></i>
                            Standart Kompetensi & Skill Matrik
                        </h3>
                    </div>
                    <!-- /.card-header -->

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

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
    </div>
</section>

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

        $('#tb_lnsm').on('click', '.btn-flat', function () {
            var data = insm.row($(this).parents('tr')).data();
            $("#namasm").val(data.nik);
            //alert(data.id_tema_pelatihan);
            //window.location.href = APP_URL + "/pga/listskillmatrik/" + data.nik + "/" + data.nama;
            window.location.href = APP_URL + "/pga/listskillmatrik/" + data.nik + "/" + data.nama;
        });




    });




</script>

@endsection