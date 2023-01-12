@extends('main2')

@section('pageTitle','Days of Supply')

@section('style')
<style>
.card {
    height:600px;
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Chemical</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='chemical'></select></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row" id='chartDiv'>
</div>

@endsection


@section('javascript')

<script src="/js/dos.min.js" ></script>

@endsection
