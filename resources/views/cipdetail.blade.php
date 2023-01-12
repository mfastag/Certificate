@extends('main2')

@section('style')
<style>
.card {
    height:750px;
}
</style>
@endsection

@section('content')

<button type="button" class="btn btn-primary" onclick="openCipDetail(cipId)">
  Launch demo modal
</button>

@include("partials._cipdetailbox")






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
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><a href='/chemical'>30 Day Chemical Cost w/ Exceptions</a>
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
                            30 Day Exception Time</div>
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
    <div class="col-xl-12 col-lg-12 ">

        <div class="card shadow mb-1" id='detailCard'>
            
        
            
            <div class="card-header py-1">
                <h6 class="m-0 font-weight-bold text-primary">CIP Detail</h6>
{{--
                <div class="dropdown">
                    <a href='#' class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                        Dropdown Menu
                    </a>
                    <div id='dtarget' class="dropdown-menu">
                        <h6 class="dropdown-header">Dropdown Title</h6>  
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Second Title</h6>  
                        <a class="dropdown-item" href="#">One more thing...</a>
                    </div>
                </div>  --}}            
            </div>


            <!-- Card Body -->
            <div class="card-body text-xs">
                 
            </div>

        </div>   






        </div>
</div>


@endsection


@section('javascript')


<script>
var react=0;
$(function() {
  refresh();
});




function buildFilter() {
    let filter = {a:1};
    //filter.dateFrom = $('#dateFrom').val();
    //filter.dateTo = $('#dateTo').val();
    //filter.system = $('#system').val();
    //filter.line = $('#line').val();
    //filter.object = $('#object').val();
    //filter.exception = $('#exception').val();

    return filter;
}





    </script>

@endsection
