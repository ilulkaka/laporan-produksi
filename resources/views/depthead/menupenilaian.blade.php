@extends('layout.main')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Penilaian Kinerja</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{url('/pga/penilaian')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Penilaian Kinerja</span>
                                    <span class="info-box-number">Karyawan Umum</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        @if(strtoupper(Session::get('level'))=='ADMIN' || strtoupper(Session::get('level'))=='MANAGER'

                        || strtoupper(Session::get('level'))=='ASSISTEN MANAGER' ||
                        strtoupper(Session::get('level'))=='SUPERVISOR')
                        <a href="{{url('/pga/penilaianpimpinan')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger elevation-1"><i
                                        class="fas fa-thumbs-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Penilaian Kinerja</span>
                                    <span class="info-box-number">Leader Up</span>
                                </div>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
                <div class="clearfix hidden-md-up"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">Penilaian Bonus</h5>
            </div>
            <div class="card-body">

                <div class="row">
                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-md-6">
                        <a href="{{url('/pga/bonus')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-success elevation-1"><i
                                        class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Bonus</span>
                                    <span class="info-box-number">Karyawan Umum</span>
                                </div>
                            </div>
                        </a>

                    </div>
                    <!-- /.col -->
                    <div class="col-md-6">
                        @if(strtoupper(Session::get('level'))=='ADMIN' || strtoupper(Session::get('level'))=='MANAGER'
                        ||

                        strtoupper(Session::get('level'))=='ASSISTEN MANAGER' ||

                        strtoupper(Session::get('level'))=='SUPERVISOR')
                        <a href="{{url('/pga/bonuspimpinan')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning elevation-1"><i
                                        class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Bonus</span>
                                    <span class="info-box-number">Leader Up</span>
                                </div>
                            </div>
                        </a>
                        @endif
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-success card-outline">
            <div class="card-head">

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{url('/pga/listpenilaian')}}">

                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">List Penilaian</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{url('/pga/list_penilaian_pkwt')}}">

                            <div class="info-box">
                                <span class="info-box-icon bg-secondary"><i class="fas fa-receipt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">List Penilaian</span>
                                    <span class="info-box-number">PKWT</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>
            </div>
        </div>
    </div>
</div>








@endsection