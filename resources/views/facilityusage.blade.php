@extends('main2')

@section('pageTitle','Facility Usage')

@section('style')
<style>
.card {
    height:350px;
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Date Filter</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><input class='text-xs' type='date' id='dateFrom'> to <input class='text-xs' type='date' id='dateTo'></div>
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">System</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='system'></select></div>
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
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Measure</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='measure'></select></div>
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


</div>


<div class="row">
    <div class="col-12 mb-2">
        <div class="card border-left-primary shadow">
            <div class="card-body text-xs">
                <div class="row no-gutters align-items-center">
                    <div class="col-12">
                        <table
                            style='width:100%' 
                            class='table table-bordered table-hover table-sm table-striped font-black'
                            id='dtable'
                            data-toggle='table'
                            data-pagination='false'
                            data-virtual-scroll="true"
                            data-height="310"
                            data-show-columns="false"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-page-size="50"
                            data-page-list="[10, 25, 50, 100, 200, All]"
                            data-search='true'
                            data-sort-name="StartDateTime"
                            data-sort-order="asc"
                            data-show-export="true"
                            data-export-types="['excel','csv','txt']"
                            
                            data-cardView='false'>
                            <thead>
                            <tr>
                                    <th data-sortable="true" data-formatter='tableDateFormatter' data-field="StartDateTime">Start Date/Time</th>
                                    <th data-sortable="true" data-field="CIP System">CIP System</th>
                                    <th data-sortable="true" data-field="CIP Line">CIP Line</th>
                                    <th data-sortable="true" data-field="Object">Equipment</th>
                                    <th data-sortable="true" data-field="FieldName">Measure</th>
                                    <th data-sortable="true" data-formatter='CurrencyFormatter' class='text-right' data-field="cost">Cost</th>
                                </tr>
                            </thead>         
                            <tbody>
                            </tbody>        
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        


<div class="row">
    <div class="col-12 mb-2">
        <div class="card border-left-primary shadow h-100">
            <div id='chrt' style="height: 320px;"></div>
        </div>
    </div>
</div>
        

@endsection


@section('javascript')

<script src="/js/facilityusage.min.js" ></script>
@endsection
