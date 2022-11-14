@extends('layout.main')
@section('content')

<div class="row">
    <div class="col-md-3">

    </div>
    <form id="frm_target" class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <div class="row">
                    @csrf
                    <h3>Target Lembur</h3>
                </div>
                <div class="row">


                    <p>

                        Periode
                    </p>

                    <div class="col-md-6">
                        <input type="month" class="form-control" id="periode" name="periode" value="{{date('Y-m')}}">
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="tb_target">
                    <thead>
                        <tr>
                            <th>Secton</th>
                            <th>Periode</th>
                            <th>Target</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <input type="submit" value="Simpan" class="btn btn-success float-right" id="simpan_target">
            </div>
        </div>
    </form>
    <div class="col-md-3">

    </div>
</div>





@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
    var key = localStorage.getItem('npr_token');

    var peri = $("#periode").val();

    load_table(peri, key);

    $("#periode").change(function(){
        var now = $('#periode').val();
        load_table(now, key);
    });

    $("#frm_target").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
                url: APP_URL+'/manager/postargetlembur',
                type: 'POST',
                dataType: 'json',
                data: data,
                })
                .done(function(resp) {
                    if (resp.success) {
                       
                        alert(resp.message);
                        window.location.href = APP_URL+'/manager/targetlembur';
                    }
                    else
                   alert(resp.message);
                })
                .fail(function() {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                   
                })
                .always(function() {
                  
                });
    });

});

function load_table(periode, key){
    $.ajax({
            url: APP_URL + "/api/manager/getargetlembur",
            method: "POST",
            data: { "periode": periode },
            dataType: "json",
            headers: { "token_req": key },
            success: function (data) {
                var label = [];
                var value = [];
                var value2 = [];
                var jm = 0;
                var tot = 0;

                $("#tb_target tbody").empty();
                $("#tb_target tfoot").empty();

                for (var i in data) {
                   jm = data[i].target_jam;
                    tot = tot + Number(data[i].target_jam);
                    var newrow = '<tr><td><input type ="hidden" name="section_cd[]" value="'+data[i].KODE_DEPARTEMEN+'" />' + data[i].DEPT_SECTION + '</td><td><input type ="hidden" name="section_name[]" value="'+data[i].DEPT_SECTION+'" />' + periode + '</td><td><input type="number" class="form-control" name="target[]"  value="'+ Number(jm) +'"></td></tr>';

                    $('#tb_target tbody').append(newrow);
                }
                $("#tb_target tfoot").append('<tr><th colspan="2">Total :</th><th>' + tot + '</th></tr>') 
            }

        });
}
</script>
@endsection