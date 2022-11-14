@extends('layout.main')
@section('content')

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

<div class="card">
    <div class="card-header">
        <form action="{{url('/iso/entryss')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card card-secondary">
                <div class="card-header">
                    <div class="col-12">
                        <h3 class="card-title">SUMBANG SARAN (SS) IMPROVEMENT</h3>
                    </div>
                </div>
                <div class="card-tools">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="no_ss">No SS</label>
                                    <input type="text" value="" class="form-control" name="no_ss_1" id="no_ss_1"
                                        disabled>
                                    <input type="hidden" value="" class="form-control" name="no_ss" id="no_ss">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="tgl_ditemukan">Tanggal Penyerahan</label>
                                    <input type="date" class="form-control" name="tgl_penyerahan" id="tgl_penyerahan"
                                        placeholder="Tanggal ditemukan" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nik">NIK</label>
                                    <select name="nik" id="nik"
                                        class="form-control select2 @error('nik') is-invalid @enderror"
                                        style="width: 100%;" required>
                                        <option>NIK</option>
                                        @foreach($nomerinduk as $i)
                                        <option value="{{$i->nama}}">{{$i->nik }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="nama">Nama Operator</label>
                                    <input type="hidden" name="nonik" id="nonik">
                                    <input type="text" class="form-control @error('nama')is-invalid @enderror"
                                        name="nama" id="nama" placeholder="Nama Operator" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="tema_ss">Tema SS</label>
                                    <input type="text" class="form-control" name="tema_ss" id="tema_ss"
                                        placeholder="Tema Ide Improvement" required>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="kategory">Kategory</label>
                                    <select name="kategori" id="kategori" class="form-control" required>
                                        <option selected>Choose...</option>
                                        <option value="Quality">Quality</option>
                                        <option value="Cost">Cost</option>
                                        <option value="Delivery">Delivery</option>
                                        <option value="k3">Peningkatan K3</option>
                                        <option value="Morale">Morale</option>
                                        <option value="Environment">Environment</option>
                                        <option value="2S3T">5S / 2S3T</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="masalah">Masalah yang ada</label>
                                    <textarea class="form-control" name="masalah" id="masalah" cols="30" rows="4"
                                        placeholder="Penjelasan Kondisi Sekarang dan Masalah yang ada."
                                        required></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ide_ss">Ide SS</label>
                                    <textarea class="form-control" name="ide_ss" id="ide_ss" cols="30" rows="4"
                                        placeholder="Penjelasan Singkat Ide Improvement" required></textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tujuan_ss">Tujuan SS</label>
                                    <textarea class="form-control" name="tujuan_ss" id="tujuan_ss" cols="30" rows="4"
                                        placeholder="Penjelasan Kemungkinan keuntungan yang didapat setelah Improvement."
                                        required></textarea>
                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label for="foto_before">Foto Before</label>
                                    <input type="file" class="form-control" id="foto_before" name="foto_before">
                                </div>
                                <!--<div class="form-group col-md-4">
                                    <label for="foto_after">Foto After</label>
                                    <input type="file" class="form-control" id="foto_after" name="foto_after">
                                </div>-->
                                <div class="form-group col-md-8">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="2"
                                        placeholder="Jika Ada."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <td><a href="{{url('/iso/sslist')}}" class="btn btn-secondary btn-flat">List SS</a></td>
            <input type="submit" value="simpan" class="btn btn-success btn-flat float-right">
        </form>
    </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script>
    $(function () {

        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });

    $(document).ready(function () {
        var key = localStorage.getItem('npr_token');
        var dept = "{{Session::get('dept')}}";

        $("#nik").change(function () {
            var noinduk = $(this).children("option:selected").html();
            var namaoperator = $(this).children("option:selected").val();
            //    var dept = $(this).children("option:selected").val();
            var per = $("#periode").val();
            $("#nonik").val(noinduk);
            $("#nama").val(namaoperator);
            //    $("#departemen").val(dept);

        });

        $("#tgl_penyerahan").change(function () {
            //alert('test');
            var tgl = new Date(this.value);
            var tahun = tgl.getFullYear();
            var bulan = ("0" + (tgl.getMonth() + 1)).slice(-2);
            var tanggal = ("0" + tgl.getDate()).slice(-2);
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/nomer_ss",
                headers: { "token_req": key },
                data: { "tgl": tahun + '-' + bulan + '-' + tanggal },
                dataType: "json",


                success: function (response) {
                    var nomer = response[0].no_ss;
                    $("#no_ss").val(nomer);
                    $("#no_ss_1").val(nomer);

                }
            });
        });
    });

</script>
@endsection