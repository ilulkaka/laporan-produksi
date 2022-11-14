@extends('layout.main')
@section('content')

<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{asset('/assets/img/userweb.png')}}"
                alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">{{Session::get('name')}}</h3>

        <p class="text-muted text-center">{{Session::get('dept')}}</p>

        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>NIK</b> <a class="float-right">{{Session::get('nik')}}</a>
            </li>
            <li class="list-group-item">
                <b>Level</b> <a class="float-right">{{Session::get('level_user')}}</a>
            </li>
            <li class="list-group-item">
                <b></b> <a class="float-right"></a>
            </li>
        </ul>

        <a href="#" class="btn btn-primary btn-block" id="btn-pass"><b>Ganti Password</b></a>
    </div>
    <!-- /.card-body -->
</div>


<!-- Modal ganti password-->
<div class="modal fade" id="gntpass-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-gantipassword" method="POST">
                    @csrf

                    <input type="hidden" id="id-user" name="id-user">
                    <div class="row">
                        <div class="col col-md-4"><label>User Name</label></div>
                        <label>:</label>
                        <div class="col col-md-6">

                            <label id="edit-user">{{Session::get('name')}}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4"><label>Password Lama</label></div>
                        <label>:</label>
                        <div class="col col-md-6">
                            <input type="password" id="edit-passlama" name="edit-passlama">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4"><label>Password Baru</label></div>
                        <label>:</label>
                        <div class="col col-md-6">

                            <input type="password" id="edit-passbaru">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-4"><label>Password Baru</label></div>
                        <label>:</label>
                        <div class="col col-md-6">

                            <input type="password" id="edit-passbaru1">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <input type="submit" class="btn btn-primary" id="btn-save" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        $("#btn-pass").click(function () {
            $("#gntpass-modal").modal("show");
        });

        $("#form-gantipassword").submit(function (e) {
            e.preventDefault();
            var key = localStorage.getItem('npr_token');
            var passlama = $("#edit-passlama").val();
            var passbaru = $("#edit-passbaru").val();
            var passbaru1 = $("#edit-passbaru1").val();

            if (passbaru == passbaru1) {

                $.ajax({
                    type: "POST",
                    url: APP_URL + "/api/gantipassword",
                    headers: { "token_req": key },
                    data: { "edit-passlama": passlama, "edit-passbaru": passbaru, "edit-passbaru1": passbaru1 },
                    dataType: "json",
                })
                    .done(function (resp) {
                        if (resp.success) {
                            alert("Ganti Password Berhasil.")
                            window.location.href = "{{ route('userprofil')}}";
                        } else
                            alert(resp.message);
                    })
                    .fail(function () {
                        $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                    });
            } else {
                alert("Password baru tidak sama.");
            }
        });
    });


</script>
@endsection