<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PT. NPR Manufacturing Indonesia</title>

    <!-- Core CSS - Include with every page -->
    <link href="{{asset ('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/assets/plugins/fontawesome-free/css/all.min.css')}}">







</head>

<body>
    <div class="container">

        <div class="text-center">
            <img src="{{asset ('/assets/img/NPMI_Logo.png')}}" style="heigh:200px;width:200px"
                class="center-block img-circle">

        </div>


        <h2 align="center">PT. NPR Manufacturing Indonesia</h2>




        <h3 class="panel-title" align="center" style="padding-top:10px;padding-bottom:10px;"><b>Login</b></h3>

        <div class="row">
            <div class="col col-md-4"></div>
            <div class="col col-md-4">
                <div id="error"></div>
                @if(Session::has('alert'))
                <div class="alert alert-danger">
                    <div>{{Session::get('alert')}}</div>
                </div>
                @endif
                <form role="form" id="login-form" method="post">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control @error('username') is-invalid @enderror" placeholder="User"
                                name="username" type="text" id="nama" value="{{ old('username') }}" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                name="password" type="password" id="pass" value="{{ old('password') }}" required>
                        </div>


                        <button type="submit" class="btn btn-lg btn-success btn-block" id="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </button>
                        <button type="button" class="btn btn-lg btn-warning btn-block" id="btn-guest" name="btn-guest"
                            disabled>
                            <i class="fa fa-user"></i> Guest
                        </button>
                        <div id="error">
                            <!--error message-->
                        </div>
                    </fieldset>
                </form>


            </div>
            <div class="col col-md-4"></div>
        </div>

    </div>


    <!-- Core Scripts - Include with every page -->
    <script src="{{asset ('/assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{asset ('/assets/plugins/bootstrap/js/tether.min.js') }}"></script>
    <script src="{{asset ('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/'))!!}
    </script>






</body>

</html>

<script type="text/javascript">
    $(document).ready(function () {

        $("#login-form").submit(function (event) {
            event.preventDefault();
            var data = $(this).serialize();
            var btn = $("#btn-login");
            btn.html('Sign In');
            btn.attr('disabled', true);
            $.ajax({
                url: APP_URL + '/postlogin',
                type: 'POST',
                dataType: 'json',
                data: data,
            })
                .done(function (resp) {
                    if (resp.success) {
                        localStorage.setItem('npr_token', resp.token);
                        localStorage.setItem('npr_name', resp.user.user_name);
                        localStorage.setItem('npr_id_user', resp.user.id);
                        // console.log(resp);
                        window.location.href = "{{ route('home')}}";
                    }
                    else
                        $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
                })
                .fail(function () {
                    $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                    //toastr['warning']('Tidak dapat terhubung ke server !!!');
                })
                .always(function () {
                    btn.html('Login');
                    btn.attr('disabled', false);
                });

            return false;
        });
    });

</script>