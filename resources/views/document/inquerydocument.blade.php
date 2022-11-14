@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col col-md-2">
            <button type="button" class="btn btn-outline" id="btn_add_document" name="btn_add_document"><u style="color: blue">
                    Add
                    Document</u></button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-header">
                <div class="row">

                    <div class="col-12">
                        <h1 class="card-title float-right"><b style="color: brown; font-size:30px">My Document</b> </h1>
                        <div class="row">
                            <label for="" class="col-md-1 ">Status : </label>
                            <select name="ad_doc_status" id="ad_doc_status" class="form-control rounded-0 col-md-2"
                                value="Running">
                                <option value="Running">Running</option>
                                <option value="Expired">Expired</option>
                                <option value="All">All</option>
                            </select>
                            <button class="btn btn-primary rounded-0" id="btn_reload_status"><i
                                    class="fa fa-sync"></i></button>
                        </div>
                        <input type="hidden" id="tgl_now" name="tgl_now" value="{{ date('Y-m-d') }}">
                        <input type="hidden" id="ad_id_manag" name="ad_id_manag">
                    </div>
                </div>
            </div>
            <div class="card-tools">
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap" id="tb_list_document">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Doc. Type</th>
                            <th>Doc. Number</th>
                            <th>Doc. Name</th>
                            <th>Location</th>
                            <th>Doc. Created</th>
                            <th>Effective Date</th>
                            <th>Expired Date</th>
                            <th>Doc. Status</th>
                            <th>Attachment</th>
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

    <!-- Modal Add Document (AD) -->
    <div class="modal fade" id="modal_add_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b>Add Document</b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ad">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-caret-down"> Category</i></strong>
                                <select name="ad_category" id="ad_category" class="form-control rounded-0" required>
                                    <option value="">Please Choose...</option>
                                    <option value="Document">Document</option>
                                    <option value="Person">Person</option>
                                    <option value="Machine">Machine</option>
                                </select>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-quote-left"> Type</i></strong>
                                <input type="text" id="ad_type" name="ad_type" class="form-control rounded-0">
                            </div>
                        </div>
                        <p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> Document Number</i></strong>
                                <input type="text" id="ad_document_number" name="ad_document_number"
                                    class="form-control rounded-0">
                                <p>
                                </p>
                                <strong padding-top="20%"><i class="fas fa-file-signature"> Document Name</i>
                                </strong>
                                <input type="text" id="ad_document_name" name="ad_document_name"
                                    class="form-control rounded-0 col-md-12">
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-location-arrow"> Document Location</i></strong>
                                <input type="text" id="ad_document_location" name="ad_document_location"
                                    class="form-control rounded-0">
                            </div>
                        </div>
                        </p>
                        <hr style="color: blue; background-color:blue">
                        <div class="row">
                            <div class="col col-md-3">
                                <label>Document Created</label>
                                <input type="date" id="ad_document_created" name="ad_document_created"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label>Effective Date</label>
                                <input type="date" id="ad_effective_date" name="ad_effective_date"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label>Expired Date</label>
                                <input type="date" id="ad_expired_date" name="ad_expired_date"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label style="color: red">Notif Date</label>
                                <input type="date" id="ad_notif_date" name="ad_notif_date"
                                    class="form-control rounded-0" style="color: red; border-color:red">
                            </div>
                        </div>
                        <hr style="color: blue; background-color:blue">
                        <div class="row">
                            <div class="col col-md-12">
                                <label><i class="fas fa-certificate"> Upload Document</i></label>
                                <input type="file" class="form-control" name="filename[]" id="filename[]" multiple>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-bookmark"> Remark</i></strong>
                                <textarea name="ad_remark" id="ad_remark" cols="120" rows="2" class="form-control rounded-0"></textarea>
                            </div>
                        </div>
                        <p>

                        </p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ad">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Document (ED) -->
    <div class="modal fade" id="modal_edit_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b>Edit Document</b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ed">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-caret-down"> Category</i></strong>
                                <input type="hidden" id="ed_id" name="ed_id">
                                <select name="ed_category" id="ed_category" class="form-control rounded-0" required>
                                    <option value="">Please Choose...</option>
                                    <option value="Document">Document</option>
                                    <option value="Person">Person</option>
                                    <option value="Machine">Machine</option>
                                </select>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-quote-left"> Type</i></strong>
                                <input type="text" id="ed_type" name="ed_type" class="form-control rounded-0">
                            </div>
                        </div>
                        <p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> Document Number</i></strong>
                                <input type="text" id="ed_document_number" name="ed_document_number"
                                    class="form-control rounded-0">
                                <p>
                                </p>
                                <strong padding-top="20%"><i class="fas fa-file-signature"> Document Name</i>
                                </strong>
                                <input type="text" id="ed_document_name" name="ed_document_name"
                                    class="form-control rounded-0 col-md-12">
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-location-arrow"> Document Location</i></strong>
                                <input type="text" id="ed_document_location" name="ed_document_location"
                                    class="form-control rounded-0">
                            </div>
                        </div>
                        </p>
                        <hr style="color: blue; background-color:blue">
                        <div class="row">
                            <div class="col col-md-3">
                                <label>Document Created</label>
                                <input type="date" id="ed_document_created" name="ed_document_created"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label>Effective Date</label>
                                <input type="date" id="ed_effective_date" name="ed_effective_date"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label>Expired Date</label>
                                <input type="date" id="ed_expired_date" name="ed_expired_date"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label style="color: red">Notif Date</label>
                                <input type="date" id="ed_notif_date" name="ed_notif_date"
                                    class="form-control rounded-0" style="color: red; border-color:red">
                            </div>
                        </div>
                        <hr style="color: blue; background-color:blue">
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-bookmark"> Remark</i></strong>
                                <textarea name="ed_remark" id="ed_remark" cols="120" rows="2" class="form-control rounded-0"></textarea>
                            </div>
                        </div>
                        <p>

                        </p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ed">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal Update Document (UD) -->
        <div class="modal fade" id="modal_upd_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b>Update Document</b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_ud">
                        @csrf
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-caret-down"> Category</i></strong>
                                <input type="hidden" id="ud_id" name="ud_id">
                                <select name="ud_category" id="ud_category" class="form-control rounded-0" required>
                                    <option value="">Please Choose...</option>
                                    <option value="Document">Document</option>
                                    <option value="Person">Person</option>
                                    <option value="Machine">Machine</option>
                                </select>
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-quote-left"> Type</i></strong>
                                <input type="text" id="ud_type1" name="ud_type1" class="form-control rounded-0" disabled>
                                <input type="hidden" id="ud_type" name="ud_type" class="form-control rounded-0">
                            </div>
                        </div>
                        <p>
                        <div class="row">
                            <div class="col col-md-6">
                                <strong><i class="fas fa-file-prescription"> Document Number</i></strong>
                                    <input type="text" id="ud_document_number" name="ud_document_number"
                                    class="form-control rounded-0">
                                <p>
                                </p>
                                <strong padding-top="20%"><i class="fas fa-file-signature"> Document Name</i>
                                </strong>
                                <input type="text" id="ud_document_name1" name="ud_document_name1"
                                class="form-control rounded-0 col-md-12" disabled>
                                <input type="hidden" id="ud_document_name" name="ud_document_name"
                                    class="form-control rounded-0 col-md-12">
                            </div>
                            <div class="col col-md-6">
                                <strong><i class="fas fa-location-arrow"> Document Location</i></strong>
                                <input type="text" id="ud_document_location1" name="ud_document_location1"
                                    class="form-control rounded-0" disabled>
                                    <input type="hidden" id="ud_document_location" name="ud_document_location"
                                    class="form-control rounded-0">
                            </div>
                        </div>
                        </p>
                        <hr style="color: blue; background-color:blue">
                        <div class="row">
                            <div class="col col-md-3">
                                <label>Document Created</label>
                                <input type="date" id="ud_document_created" name="ud_document_created"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label>Effective Date</label>
                                <input type="date" id="ud_effective_date" name="ud_effective_date"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label>Expired Date</label>
                                <input type="date" id="ud_expired_date" name="ud_expired_date"
                                    class="form-control rounded-0">
                            </div>
                            <div class="col col-md-3">
                                <label style="color: red">Notif Date</label>
                                <input type="date" id="ud_notif_date" name="ud_notif_date"
                                    class="form-control rounded-0" style="color: red; border-color:red">
                            </div>
                        </div>
                        <hr style="color: blue; background-color:blue">
                        <div class="row">
                            <div class="col col-md-12">
                                <label><i class="fas fa-certificate"> Upload Document</i></label>
                                <input type="file" class="form-control" name="filename[]" id="filename[]" multiple>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col col-md-12">
                                <strong><i class="fas fa-bookmark"> Remark</i></strong>
                                <textarea name="ud_remark" id="ud_remark" cols="120" rows="2" class="form-control rounded-0"></textarea>
                            </div>
                        </div>
                        <p>

                        </p>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-flat" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_save_ud">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Attachment (AA) -->
    <div class="modal fade" id="modal_add_attachment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b>Add Attachment</b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_aa">
                        @csrf
                        <div class="row">
                            <div class="col col-md-12">
                                <label><i class="fas fa-certificate"> Upload Document</i></label>
                                <input type="hidden" id='aa_id' name="aa_id">
                                <input type="file" class="form-control" name="filename[]" id="filename[]" multiple required>
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-flat" id="btn_aa_save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal view attachment VA -->
    <div class="modal fade" id="modal_view_attachment" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Attachment</h3>
                        <button type="button" class="close btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered" id="tb_lampiran">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                            <tfoot>

                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Deactivate Document (DD) -->
    <div class="modal fade" id="modal_deactivate_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="exampleModalLongTitle"><b>Deactivated</b> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_dd">
                        @csrf
                        <div class="row">
                            <div class="col col-md-12">
                                <label><i class="fas fa-certificate"> Select save and the document will be inactive . </i></label>
                                <input type="hidden" id='dd_id' name="dd_id">
                            </div>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger btn-flat" id="btn_dd_save">Save</button>
                        </div>
                    </form>
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
                                    value="{{ date('Y-m') . '-01' }}">
                                <label for="" class="col-md-1 text-center"> ~ </label>
                                <input type="date" class="form-control col col-md-4" id="tgl_akhir" name="tgl_akhir"
                                    value="{{ date('Y-m-d') }}">
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
    <script src="{{ asset('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-select/js/dataTables.select.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var key = localStorage.getItem('npr_token');
            var tgl_now = $("#tgl_now").val();

            var listdocument = $('#tb_list_document').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,

                ajax: {
                    url: APP_URL + '/api/doc/list_document',
                    type: "POST",
                    headers: {
                        "token_req": key
                    },
                    data: function(d) {
                        d.doc_status = $("#ad_doc_status").val();
                        d.id_manag = $("#ad_id_manag").val();
                    }
                },

                columnDefs: [{
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                    {
                        targets: [9],
                        data: null,
                        //defaultContent: "<button class='btn btn-success'>Complited</button>"
                        render: function(data, type, row, meta) {
                            //return data.count_manag;
                            return "<button class='btn btn-block btn-outline btn-flat btn-xs'><a href = '#' style='font-size:14px' >" +
                                data.count_manag + " File </a></button>";
                        }
                    },
                    {
                        targets: [10],
                        data: null,
                        render: function(data, type, row, meta) {
                            if (tgl_now >= data.notif_date && data.doc_status == 'Running') {
                                return "<a href = '#' style='font-size:14px' class = 'updDoc '> Update Document </a>";
                            } else if (tgl_now >= data.notif_date && data.doc_status == 'Expired') {
                                return "";
                            } else {
                                return "<a href = '#' style='font-size:14px' class = 'editDoc'> Edit </a> || <a href = '#' style='font-size:14px' class ='addFile' > Add File </a>";
                            }
                        }
                    }
                ],

                columns: [{
                        data: 'id_manag_document',
                        name: 'id_manag_document'
                    },
                    {
                        data: 'doc_type',
                        name: 'doc_type'
                    },
                    {
                        data: 'doc_number',
                        name: 'doc_number'
                    },
                    //{ data: 'tgl_penyerahan', name: 'tgl_penyerahan' },
                    {
                        data: 'doc_name',
                        name: 'doc_name'
                    },
                    {
                        data: 'doc_location',
                        name: 'doc_location'
                    },
                    //{ data: 'bagian', name: 'bagian' },
                    {
                        data: 'created_date',
                        name: 'created_date'
                    },
                    {
                        data: 'effective_date',
                        name: 'effective_date'
                    },
                    {
                        data: 'expired_date',
                        name: 'expired_date'
                    },
                    {
                        data: 'doc_status',
                        name: 'doc_status'
                    },
                ],
                fnRowCallback: function(nRow, data, iDisplayIndex, iDisplayIndexFull) {
                    if (tgl_now >= data.notif_date && data.doc_status == 'Running') {
                        $('td', nRow).css('background-color', '#ff9966');
                        $('td', nRow).css('color', 'White');
                    }
                },
            });

            $("#btn_reload_status").click(function() {
                listdocument.ajax.reload();
            });

            $("#btn_add_document").click(function() {
                $('#modal_add_document').modal('show');
            });

            $('#tb_list_document').on('click', '.btn-flat', function() {
                var datas = listdocument.row($(this).parents('tr')).data();
                var id_manag_document = datas.id_manag_document;
                //alert(id_manag_document);
                if (datas.count_manag <= 0) {
                    alert ("File Not Found .");
                } else {
                    $('#modal_view_attachment').modal('show');
                    load_table(id_manag_document, key);
                }
            });

            $('#tb_list_document').on('click', '.addFile', function() {
                var datas = listdocument.row($(this).parents('tr')).data();
                var id_manag_document = datas.id_manag_document;
                load_aa();
                $("#aa_id").val(id_manag_document);
                $('#modal_add_attachment').modal('show');
            });

            $('#tb_list_document').on('click', '.updDoc', function() {
                var datas = listdocument.row($(this).parents('tr')).data();
                var id_manag_document = datas.doc_type;
                var conf = confirm('do you want to extend the document or deactivate ?');
                if (conf){
                    $("#ud_id").val(datas.id_manag_document);
                    $("#ud_category").val(datas.category);
                    $("#ud_type").val(datas.doc_type);
                    $("#ud_type1").val(datas.doc_type);
                    //$("#ud_document_number").val(datas.doc_number);
                    $("#ud_document_location").val(datas.doc_location);
                    $("#ud_document_location1").val(datas.doc_location);
                    $("#ud_document_name").val(datas.doc_name);
                    $("#ud_document_name1").val(datas.doc_name);
                    //$("#ud_document_created").val(datas.created_date);
                    //$("#ud_effective_date").val(datas.effective_date);
                    //$("#ud_expired_date").val(datas.expired_date);
                    //$("#ud_notif_date").val(datas.notif_date);
                    $("#ud_remark").val(datas.remark);
                    $('#modal_upd_document').modal('show');
                } else {
                    $("#dd_id").val(datas.id_manag_document);
                    $('#modal_deactivate_document').modal('show');
                }
            });

            $('#tb_list_document').on('click', '.editDoc', function() {
                var datas = listdocument.row($(this).parents('tr')).data();
                var id_manag_document = datas.doc_type;
                $("#ed_id").val(datas.id_manag_document);
                $("#ed_category").val(datas.category);
                $("#ed_type").val(datas.doc_type);
                $("#ed_document_number").val(datas.doc_number);
                $("#ed_document_location").val(datas.doc_location);
                $("#ed_document_name").val(datas.doc_name);
                $("#ed_document_created").val(datas.created_date);
                $("#ed_effective_date").val(datas.effective_date);
                $("#ed_expired_date").val(datas.expired_date);
                $("#ed_notif_date").val(datas.notif_date);
                $("#ed_remark").val(datas.remark);
                $('#modal_edit_document').modal('show');
            });

            $("#form_ad").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                var datas = new FormData(this);
                //alert(data);
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/doc/add_document",
                        headers: {
                            "token_req": key
                        },
                        data: datas,
                        processData: false,
                        contentType: false,
                        //dataType: "json",
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#form_ud").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                var datas = new FormData(this);
                //alert(data);
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/doc/upd_document",
                        headers: {
                            "token_req": key
                        },
                        data: datas,
                        processData: false,
                        contentType: false,
                        //dataType: "json",
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            location.reload();
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#form_aa").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                var datas = new FormData(this);
                $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/doc/add_attachment",
                        headers: {
                            "token_req": key
                        },
                        data: datas,
                        processData: false,
                        contentType: false,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $('#modal_add_attachment').modal('toggle');
                            listdocument.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#form_ed").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                //alert(data);
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/doc/edit_document",
                        headers: {
                            "token_req": key
                        },
                        data: data,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $('#modal_edit_document').modal('toggle');
                            listdocument.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#form_dd").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                //alert(data);
                    $.ajax({
                        type: "POST",
                        url: APP_URL + "/api/doc/deactivate_document",
                        headers: {
                            "token_req": key
                        },
                        data: data,
                    })
                    .done(function(resp) {
                        if (resp.success) {
                            alert(resp.message);
                            $('#modal_deactivate_document').modal('toggle');
                            listdocument.ajax.reload(null, false);
                        } else {
                            alert(resp.message);
                        }
                    })
            });

            $("#tb_lampiran").on("click", ".filename", function(e) {
            e.preventDefault();
            var id_lampiran_dokumen = this.id;
            window.open(APP_URL + "/document/" + id_lampiran_dokumen, '_blank');
            });

        $('#tb_lampiran').on('click', '.btnSelect', function(e) {
            e.preventDefault();
            var id_lampiran_dokumen = this.id;
            var conf = confirm('do you want to delete this file ?');
                if (conf){
                    $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/doc/del_attachment",
                    headers: {
                        "token_req": key
                    },
                    data: {'id_lampiran_dokumen':id_lampiran_dokumen},
                    })
                    .done(function(resp) {
                    if (resp.success) {
                        alert(resp.message);
                        location.reload();
                    } else {
                    alert(resp.message);
                    }
                })
            }
        });

        });

        function load_table(id_manag_document, key) {
            $.ajax({
                url: APP_URL + '/api/doc/lampiran_open',
                method: "POST",
                data: {
                    'id_manag_document': id_manag_document
                },
                dataType: "json",
                headers: {
                    "token_req": key
                },
                success: function(data) {
                    var label = [];

                    $("#tb_lampiran tbody").empty();
                    $("#tb_lampiran tfoot").empty();


                    for (var i in data.hasil) {
                        idlampiran = (data.hasil[i].id_lampiran_dokumen);
                        filename = (data.hasil[i].filename);

                        var newrow = '<tr><td><a href="#" id="' + filename + '" class="filename">' +
                            filename +
                            '</td><td><button type="button" id="' + idlampiran +'" class="btnSelect btn btn-xs btn-danger btn-flat">Delete</button></td></tr>';
                        $('#tb_lampiran tbody').append(newrow);
                    }
                }

            });
        }

        function load_aa (){
            $("#form_aa").trigger("reset");
        }
    </script>
@endsection
