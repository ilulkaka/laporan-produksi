@extends('layout.main')
@section('content')

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

@if(Session::has('alert-success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{Session::get('alert-success')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@elseif(Session::has('alert-danger'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{Session::get('alert-danger')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-success card-outline">
            <div class="card-body box-profile">
                <div class="row">

                    <div class="col-12">
                        <h3 class="card-title">Estimasi</h3>
                    </div>
                </div>
                <br>
                <!--
                <div class="row">
                    <div class="row text-center">
                        <label for="" class="col-md-2 text-center">Nouki</label>
                        <input type="date" class="form-control col-md-4" id="nouki" value="{{date('Y-m').'-01'}}">
                        <label for="" class="col-md-2 text-center">Ship To</label>
                        <select name="ship_to" id="ship_to"
                            class="form-control col-md-4 select2 @error('ship_to') is-invalid @enderror" required>
                            <option value="">Ship To ...</option>
                            @foreach($ship_to as $s)
                            <option value="{{$s->ship_to}}">{{$s->ship_to }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                -->
                <div class="col-12 center">
                    <div class="col-sm-12">
                        <button class="btn btn-flat" id="btn_upload"><i class="fa fa-upload" style="color: blue;"> <u>
                                    Upload Data
                                </u></i></button>
                        <br>
                        <button class="btn btn-flat" id="btn_reload" style="color: blue;"><i class="fa fa-sync"> <u>
                                    Calculat
                                </u></i></button>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-5" style="text-align: center;">

        <div class="row">
            <div class="col-12 col-sm-6 col-md-10">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ring"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Qty</span>
                        <span class="info-box-number" id="totalqty1">
                            <label for="" id="totalqty" style="font-size: x-large;">0</label>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!--<div class="col-12 col-sm-6 col-md-5">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Housou</span>
                        <span class="info-box-number" id="totalhousou">0</span>
                    </div>
                </div>
            </div>-->
            <!-- /.col -->
        </div>
        <div class="row">
            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-5">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-pallet"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pallet <i style="font-size: small;">@ 18 box</i> </span>
                        <span class="info-box-number" id="totalpallet" style="font-size: x-large;">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-5">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-box-open"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Box</span>
                        <span class="info-box-number" id="totalsisabox" style="font-size: x-large;">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

    </div>
    <!-- /.col -->

    <div class="col-md-4">
        <div class="row">
            <br>
            <p></p>
            <span style="font-size: xx-large;"><i class="fas fa-box" style="font-size: 30px;"></i> <i
                    class="fas fa-arrow-right" style="font-size: 20px;"></i> <i class="fas fa-truck"
                    style="font-size: 50px;"></i> <i class="fas fa-arrow-right" style="font-size: 20px;"></i> <i
                    class="fab fa-docker" style="font-size: 70px;"></i> <i class="fas fa-arrow-right"
                    style="font-size: 20px;"></i> <i class="fas fa-warehouse" style="font-size: 70px;"></i></span>
            <div class="info-box-content">

            </div>

        </div>
    </div>
</div>

<div id="loadingscreen" class="eloading">
    <div id="text" class="spiner"><i class="fas fa-2x fa-sync fa-spin"></i></div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Upload Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/ppic/importexcelperhitunganbox')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">File :</label>
                    <input type="file" class="form-control" name="import_file" id="import_file" required>

                    <!-- /.card-body -->

                    <br>
                    <br>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary btn-flat">Upload</button>
                        <span class="float-right">
                            <a href="{{url('/PDF/Template Upload Perhitungan Box.xlsx')}}" class="link-black text-sm"
                                target="_blank">
                                <i class="fa fa-download"></i> Template Excel
                            </a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<!--<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>-->
<!--<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>-->
<!--<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>-->
<script>

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');

        $("#btn_reload").click(function () {
            /*var nouki = $("#nouki").val();
            var ship_to = $("#ship_to").val();

            if (ship_to == null || ship_to == '') {
                alert('Ship To Cant be empty .');
            } else {
                */
            loadingon();
            //document.getElementById("loadingscreen1").style.display = "block";
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/ppic/calculation_box",
                headers: {
                    "token_req": key
                },
                //data: {
                //    "nouki": nouki, "ship_to": ship_to
                //},
                dataType: "json",
            })

                .done(function (resp) {
                    //document.getElementById("loadingscreen1").style.display = "none";
                    if (resp.success) {
                        $("#totalqty").html(resp.totqty);
                        $("#totalhousou").html(resp.tothousou);
                        $("#totalpallet").html(resp.totpallet);
                        $("#totalsisabox").html(resp.sisabox);
                        loadingoff();
                    } else {
                        alert(resp.message);
                        //console.log(resp);
                        location.reload();
                    }
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");

                });
            //}
        });

        $("#btn_upload").click(function () {
            $("#modal-upload").modal('show');
        });

    });

</script>
@endsection