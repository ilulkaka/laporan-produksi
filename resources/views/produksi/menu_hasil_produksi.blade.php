@extends('layout.main')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title m-0">PRODUCTION REPORT</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{url('/produksi/inquery_report')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="far fa-list-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Detail</span>
                                    <span class="info-box-number">Hasil Produksi</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{url('produksi/f_approve_jam_operator')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="far fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Approve</span>
                                    <span class="info-box-number">Jam Kerja Operator</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{url('produksi/grafik_hasil_produksi')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-bar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Grafik Performance</span>
                                    <span class="info-box-number">Hasil Operator Produksi</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{url('produksi/report')}}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fab fa-r-project"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-number">Detail</span>
                                    <span class="info-box-number">Prones System</span>
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

@section('script')
<script src="{{asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/assets/plugins/datatables-select/js/dataTables.select.min.js')}}"></script>
<script type="text/javascript">

    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        })
    });


    $(document).ready(function () {


    });

</script>
@endsection