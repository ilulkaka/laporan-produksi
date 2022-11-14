@extends('layout.main')
@section('content')

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">Produksi</h3>
    </div>
    <div class="card-body">
        <li class="nav-item">
            <a href="{{url('/PDF/Petunjuk Pembuatan laporan Masalah.pdf')}}" target="_blank">
                <i class="fas fa-file-pdf nav-icon"> Petunjuk Pembuatan Form Masalah</i>
            </a>
        </li>


        <li class="nav-item">
            <a href="{{url('/PDF/Petunjuk Pembuatan Permintaan Jigu.pdf')}}" target="_blank">
                <i class="fas fa-file-pdf nav-icon"> Petunjuk Pembuatan Form Permintaan Jigu / Part</i>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{url('/PDF/Petunjuk pembuatan Request Perbaikan MTC.pdf')}}" target="_blank">
                <i class="fas fa-file-pdf nav-icon"> Petunjuk Pembuatan Form Request Maintenance</i>
            </a>

        </li>

    </div>
    <!-- /.card-body -->
</div>

<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">PPIC</h3>
    </div>
    <div class="card-body">
        <li class="nav-item">
            <a href="{{url('/PDF/Pengiriman Denpyou ke Zoukei.pdf')}}" target="_blank">
                <i class="fas fa-file-pdf nav-icon"> Petunjuk Pengiriman Denpyou ke Zoukei</i>
            </a>
        </li>
    </div>
    <!-- /.card-body -->
</div>


@endsection