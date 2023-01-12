@extends('main2')

@section('pageTitle','Dashboard')

@section('style')
<style>
.card {
    height:350px;
}
</style>
@endsection


@section('content')

<div class="row">

<!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-2 ">
        <div class="card border-left-primary shadow  h-100 py-1">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">30 Day Total Cost</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id='totcost'>0.00</span></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tasks Card Example -->
    <div class="col-xl-3 col-md-6 mb-2 ">
        <div class="card border-left-info shadow py-2 h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href='/chemical'>30 Day Chemical Cost w/ Deviations</a>
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><span id='chemcostexp'>0.00</span></div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-2 ">
        <div class="card border-left-warning shadow  h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            30 Day Total Time</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id='duration'>0</span></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2 ">
        <div class="card border-left-warning shadow  h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            30 Day Deviation Time</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><span id='durationexp'>186 hours</span></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comments fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>






<div class="row  ">
    <div class="col-xl-8 col-lg-7  ">

        <!-- Area Chart -->
        <div class="card shadow mb-2">
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary"><a href='/chemical'>Chemical Cost and Count 30 Days</a></h6>
            </div>
            <div class="card-body">
                <div class="chart-area" >
                    <div id="chart2_div" style='max-height: 90%; height:90%;'>&nbsp;</div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="card shadow mb-2">
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary">Cost Summary</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <div id="chart3_div" style='max-height: 90%; height:90%;'>&nbsp;</div>
                </div>
            </div>
        </div>

    </div>

        <!-- Donut Chart -->
    <div class="col-xl-4 col-lg-5 ">
        <div class="card shadow mb-2">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary"><a href='/exception'>Deviations By Type</a></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-1">
                    <div id="chart1_div" style='max-height: 90%; height:90%;'>&nbsp;</div>
                </div>

            </div>
        </div>



        <div class="card shadow mb-2">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary"><a href='/exception'>Deviations Cost By Type</a></h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-1">
                    <div id="chart5_div" style='max-height: 90%; height:90%;'>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('javascript')


<script src="/js/dash.min.js" ></script>

@endsection
