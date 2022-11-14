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
        <form action="{{url('/hse/f_hhky')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="card card-secondary">
                <div class="card-header">
                    <div class="col-12">
                        <h3 class="card-title">HH / KY</h3>
                    </div>
                </div>
                <div class="card-tools">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="no_ss">No HH/KY</label>
                    <input type="text" value="" class="form-control" name="no_laporan_1" id="no_laporan_1" disabled>
                    <input type="hidden" value="" class="form-control" name="no_laporan" id="no_laporan">
                </div>
                <div class="form-group col-md-3">
                    <label for="tgl_kejadian">Tanggal Kejadian</label>
                    <input type="date" class="form-control" name="tgl_kejadian" id="tgl_kejadian"
                        placeholder="Tanggal Kejadian" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="jenis_laporan">Jenis Laporan</label>
                    <select name="jenis_laporan" id="jenis_laporan" class="form-control" required>
                        <option value="">Choose...</option>
                        @foreach($jenis as $j)
                        <option value="{{$j->p_hhky}}">{{$j->p_hhky }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-1">
                    <label for="nik">NIK</label>
                    <select name="nik" id="nik" class="form-control select2 @error('nik') is-invalid @enderror"
                        style="width: 100%;" required>
                        <option value="">NIK</option>
                        @foreach($nomerinduk as $i)
                        <option value="{{$i->nama}}">{{$i->nik }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="nama">Nama Operator</label>
                    <input type="hidden" name="nonik" id="nonik" value="" required>
                    <input type="text" class="form-control @error('nama')is-invalid @enderror" name="nama" id="nama"
                        value="" placeholder="Nama Operator" required disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="tempat_kejadian">Tempat Kejadian</label>
                    <input type="text" class="form-control" name="tempat_kejadian" id="tempat_kejadian"
                        placeholder="Tempat Kejadian" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="pada_saat">Pada Saat</label>
                    <textarea class="form-control" name="pada_saat" id="pada_saat" cols="30" rows="4"
                        placeholder="Pada saat mengapa dan bagaimana." required></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="menjadi">Menjadi</label>
                    <textarea class="form-control" name="menjadi" id="menjadi" cols="30" rows="4"
                        placeholder="Menjadi bagaimana atau hampir bagaimana." required></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="solusi_perbaikan">Solusi Perbaikan</label>
                    <textarea class="form-control" name="solusi_perbaikan" id="solusi_perbaikan" cols="30" rows="4"
                        placeholder="Solusi Perbaikan (Ide)."></textarea>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="penyebab">Penyebab</label>
                    <select name="penyebab" id="penyebab" class="form-control" required>
                        <option value="">Choose...</option>
                        <option value="1">Tidak terlihat jelas (tidak terdengar)
                        </option>
                        <option value="2">Tidak disadari</option>
                        <option value="3">Terlupa</option>
                        <option value="4">Tidak Tahu</option>
                        <option value="5">Tidak berfikir panjang</option>
                        <option value="6">Dipikir tidak masalah</option>
                        <option value="7">Terburu-buru</option>
                        <option value="8">Bingung</option>
                        <option value="9">Lelah</option>
                        <option value="10">Bosan karena pekerjaan berulang</option>
                        <option value="11">Menggerakkan tangan tanpa sadar</option>
                        <option value="12">Susah mengerjakannya</option>
                        <option value="13">Tidak ada keseimbangan badan</option>
                        <option value="14">Prosedur diperpendek</option>
                        <option value="15">Lain-lain</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="foto_kondisi">Foto Kondisi</label>
                    <input type="file" class="form-control" id="foto_kondisi" name="foto_kondisi">
                </div>
                <div class="form-group col-md-5">
                    <label for="keterangan">Keterangan</label>
                    <input type="text" class="form-control" name="keterangan" id="keterangan" placeholder="Jika Ada">
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <label for="severity">S / Keparahan</label>
                    <label>:</label>
                    <label id="severity-out"></label><br>
                    <input type="hidden" id="severity_1" name="severity_1" required>
                    <input id="severity" name="severity" type="range" min="0" value="0" max="3" step="1"
                        class="form-range" onchange="sum();">
                </div>
                <div class="col-md-2">
                    <label for="frekwensi"> F / Keseringan</label>
                    <label>:</label>
                    <label id="frekwensi-out"> </label><br>
                    <input type="hidden" id="frekwensi_1" name="frekwensi_1" required>
                    <input id="frekwensi" name="frekwensi" type="range" min="0" value="0" max="3" step="1"
                        class="form-range" onchange="sum();">
                </div>
                <div class="col-md-2">
                    <label for="possibility"> P / Kemungkinan</label>
                    <label>:</label>
                    <label id="possibility-out"></label><br>
                    <input type="hidden" name="possibility_1" id="possibility_1" required>
                    <input id="possibility" name="possibility" type="range" min="0" value="0" max="3" step="1"
                        class="form-range" onchange="sum();">
                </div>
                <div class="col-md-1">
                    <label for="poin"> Poin</label>
                    <label>:</label>
                    <input type="hidden" id="poin_1" name="poin_1" value="3" required>
                    <input type="text" id="poin" name="poin" class="form-control"
                        style="color:red; font-size:x-large; text-align: center;" disabled required>
                </div>
                <div class="col-md-1">
                    <label for="rank"> Rank</label>
                    <label>:</label>
                    <input type="hidden" id="rank_1" name="rank_1" value="I" required>
                    <input type="text" name="rank" id="rank" class="form-control"
                        style="color: blue; font-size:x-large; text-align: center;" disabled required>
                </div>

            </div>
            <hr>
            <input type="submit" value="simpan" class="btn btn-success btn-flat">
            <!--<td><a href="{{url('/hse/hklist')}}" class="btn btn-secondary btn-flat">List HH/KY</a></td>-->
        </form>
    </div>
</div>

@endsection

@section('script')
<!-- Select2 -->
<script src="{{asset('/assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>

<script src="{{asset('/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<script src="{{asset('/assets/plugins/bootstrap-slider/bootstrap-slider.min.js')}}"></script>
<script>


    var values_severity = [1, 2, 6, 12];
    var values_frekwensi = [1, 2, 4, 5];
    var values_possibility = [1, 2, 4, 8];

    var severity = document.getElementById('severity'),
        severity_out = document.getElementById('severity-out');
    var frekwensi = document.getElementById('frekwensi'),
        frekwensi_out = document.getElementById('frekwensi-out');
    var possibility = document.getElementById('possibility'),
        possibility_out = document.getElementById('possibility-out');
    severity.oninput = function () {
        severity_out.innerHTML = values_severity[this.value];
        $("#severity_1").val(values_severity[this.value]);
    };
    severity.oninput();

    frekwensi.oninput = function () {
        frekwensi_out.innerHTML = values_frekwensi[this.value];
        $("#frekwensi_1").val(values_frekwensi[this.value]);
    };
    frekwensi.oninput();

    possibility.oninput = function () {
        possibility_out.innerHTML = values_possibility[this.value];
        $("#possibility_1").val(values_possibility[this.value]);
    };
    possibility.oninput();

    function sum() {
        var severity_1 = document.getElementById('severity_1').value;
        var frekwensi_1 = document.getElementById('frekwensi_1').value;
        var possibility_1 = document.getElementById('possibility_1').value;
        var result = parseInt(severity_1) + parseInt(frekwensi_1) + parseInt(possibility_1);
        if (!isNaN(result)) {
            document.getElementById('poin').value = result;
            document.getElementById('poin_1').value = result;
        }

        if (result >= 19 && result <= 25) {
            document.getElementById('rank').value = "V";
            document.getElementById('rank_1').value = "V";
        } else if (result >= 15 && result <= 18) {
            document.getElementById('rank').value = "IV";
            document.getElementById('rank_1').value = "IV";
        } else if (result >= 8 && result <= 14) {
            document.getElementById('rank').value = "III";
            document.getElementById('rank_1').value = "III";
        } else if (result >= 4 && result <= 7) {
            document.getElementById('rank').value = "II";
            document.getElementById('rank_1').value = "II";
        } else {
            document.getElementById('rank').value = "I";
            document.getElementById('rank_1').value = "I";
        }
    }


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

        $("#tgl_kejadian").change(function () {
            //alert('test');
            var tgl = new Date(this.value);
            var tahun = tgl.getFullYear();
            var bulan = ("0" + (tgl.getMonth() + 1)).slice(-2);
            var tanggal = ("0" + tgl.getDate()).slice(-2);
            $.ajax({
                type: "POST",
                url: APP_URL + "/api/nomer_hh",
                headers: { "token_req": key },
                data: { "tgl": tahun + '-' + bulan + '-' + tanggal },
                dataType: "json",

                success: function (response) {
                    var nomer = response[0].no_hk;
                    $("#no_laporan").val(nomer);
                    $("#no_laporan_1").val(nomer);
                }
            });
        });
    });

</script>
@endsection