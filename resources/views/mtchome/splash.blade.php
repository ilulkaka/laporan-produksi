@extends('mtchome.template')
@section('content')
<div class="row text-center">


    <img src="{{asset ('/assets/img/NPMI_Logo.png')}}" class="img-circle"
        style="heigh:600px;width:600px;margin-top:200px">

</div>
@endsection
@section('script')
<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/'))!!}
    $(document).ready(function(){
    
        $.ajax({
                url: APP_URL + '/api/tokenmtc',
                type: 'POST',
                data:{idname:'mtcnpmi'},
                dataType: 'json',
            })
                .done(function (resp) {
                    if (resp.success) {
                        //console.log(resp.token);
                        localStorage.setItem('mtc_token', resp.token);
                       
                        window.location.href = "{{ route('mtc')}}";
                    }
                    else
                        $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    //toastr['warning']('Tidak dapat terhubung ke server !!!');
                })
               
});
</script>
@endsection