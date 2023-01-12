@extends('main2')

@section('pageTitle','Active CIPs')

@section('style')
<style>
.card {
    height:250px;
}
</style>
@endsection

@section('content')


<div class="row">
    <div class="col-sm mb-2">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-1">
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Plant</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='plant'></select></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm mb-2">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-1">
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Equipment</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='object'></select></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm mb-2">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-1">
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Line</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='line'></select></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>



<div class="row" id='colors'></div>


<div class="row">

    @for ($i = 0; $i < 4*20; $i++)
    <div class="col-xl-3 col-lg-2" style='display:none'  id='card{{$i}}' >
        <div class="card shadow mb-2" >
            <div class="card-header py-1" id='titlebar{{$i}}' data-cipid='0' onclick='titleClick(this)' >
                <a href='#' class='fas fa-info-circle fa-lg float-right text-decoration-none mt-3'>&nbsp;</a>
                <div class="m-0 font-weight-bold text-secondary title" id='pretitle{{$i}}'>&nbsp;</div>
                <h5 class="m-0 font-weight-bold text-primary title" id='title{{$i}}' style='color:black !important' >&nbsp;</h5>
                <div id='formula{{$i}}'>&nbsp;</div>
            </div>
            <div class="card-body" >
                <div class="progress mt-0">
                  <div id='progress{{$i}}' class="progress-bar progress-bar-striped" role="progressbar" style="width: 20%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">&nbsp;</div>
                </div>
                
                <div class='font-weight-bold' id='stepname{{$i}}'>&nbsp;</div>
                <div id='stepdet{{$i}}'>&nbsp;</div>
                <div style='font-size:0.8em' id='steptime{{$i}}'>&nbsp;</div>
                <!--chart footer-->
            </div>
        </div>
    </div>
    @endfor
</div>

@include("partials._cipdetailbox")

<a href='#' id='permlink'>Link to this Page</a>

@endsection


@section('javascript')


<script src="/js/active.min.js" ></script>

@endsection
