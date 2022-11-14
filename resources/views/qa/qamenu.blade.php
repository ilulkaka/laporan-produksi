@extends('layout.main')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Request Jigu</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{url('/qa/qajigu')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i
                                        class="fas fa-drum-steelpan"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Request</span>
                                    <span class="info-box-number">From Genba</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{url('qa/inquery-permintaan')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i
                                        class="fas fa-drum-steelpan"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Part</span>
                                    <span class="info-box-number">Repair Tech</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="clearfix hidden-md-up"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Daichou</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-md-6">
                        <a href="{{url('/qa/v_listdaichou')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas "></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jigu</span>
                                    <span class="info-box-number">Location</span>
                                </div>
                            </div>
                        </a>

                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        <a href="{{url('/undermaintenance')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas "></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">-</span>
                                    <span class="info-box-number">-</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
    </div>

</div>





@endsection