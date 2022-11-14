<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PT. NPR Manufacturing Indonesia</title>

    <!-- Core CSS - Include with every page -->
    <link href="{{asset('/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('/assets/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">




</head>

<body>
    <div class="card-warning">

        <img src="assets/images/npmi.jpg" style="heigh:200px;width:200px" class="center-block img-circle">

        <h2 align="center">PT. NPR Manufacturing Indonesia</h2>
        <div class="container">



            <div class="row">
                <div class="col-md-4 col-md-offset-4">

                    <div class="login-panel panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title" align="center">Login</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" id="login-form" method="post">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="User" name="username" type="text"
                                            id="nama" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password"
                                            type="password" id="pass" value="">
                                    </div>

                                    <!-- Change this to a button or input when using this as a form -->
                                    <!-- <a href="index.html" class="btn btn-lg btn-success btn-block">Login</a>-->
                                    <button type="submit" class="btn btn-lg btn-success btn-block" name="btn-login"
                                        id="btn-login">
                                        <span class="glyphicon glyphicon-log-in"></span> &nbsp; Login
                                    </button>
                                    <button type="button" class="btn btn-lg btn-warning btn-block" id="btn-guest"
                                        name="btn-guest">
                                        <i class="fa fa-user"></i> Guest
                                    </button>
                                    <div id="error">
                                        <!--error message-->
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-md-offset-4">

                </div>
            </div>
        </div>


        <!-- Core Scripts - Include with every page -->
        <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>


        <!-- SB Admin Scripts - Include with every page -->
        <script src="<?php echo base_url(); ?>assets/js/sb-admin.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/login.js"></script>
    </div>
</body>

</html>