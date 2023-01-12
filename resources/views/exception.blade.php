@extends('main2')

@section('pageTitle','Deviations')

@section('style')
<style>
.card {
    height:360px;
}
</style>
@endsection

@section('content')


<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Count something</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Count something else</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Earnings (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">One more count</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300">&nbsp;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>



<div class="row  ">
<div class="col-xl-4 col-lg-7  ">
             <div class="card shadow mb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-1">
                    <h6 class="m-0 font-weight-bold text-primary">Deviations By Type</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-1">
                        <div id="chart1_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                 
                   <!--chart footer-->
                   </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-7  ">
             <div class="card shadow mb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-1">
                    <h6 class="m-0 font-weight-bold text-primary">Deviations By Equipment</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-1">
                        <div id="chart2_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                    
                   <!--chart footer-->
                   </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-7  ">
             <div class="card shadow mb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-1">
                    <h6 class="m-0 font-weight-bold text-primary">Deviations By Line</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-1">
                        <div id="chart3_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                    
                   <!--chart footer-->
                   </div>
            </div>
        </div>
</div>


<div class="row">
    <div class="col-xl-12 col-lg-12  ">
        <div class="card shadow mb-1">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-1">
                <h6 class="m-0 font-weight-bold text-primary">Top Devieations</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body  text-xs">
                <table
                    style='width:100%' 
                    class='table table-bordered table-hover table-sm table-striped font-black'
                    id='dtable'
                    data-toggle='table'
                    data-virtual-scroll="true"
                    data-height="300"
                    data-show-columns="false"
                    data-pagination-h-align="left"
                    data-pagination-detail-h-align="right"
                    data-search='true'
                    data-show-export="true"
                    data-export-types="['excel','csv','txt']"
                    data-sort-name="TotalIssues"
                    data-sort-order="desc"
                    data-cardView='false'>
                    <thead>
                    <tr>
                            <th data-sortable="true" data-field="CipLine">CIP Line</th>
                            <th data-sortable="true" data-field="equipment">Equipment</th>
                            <th data-sortable="true" class='text-right' data-field="Cips">Washes</th>
                            <th data-sortable="true" class='text-right' data-field="Cat1Issues">Time</th>
                            <th data-sortable="true" class='text-right' data-field="Cat2Issues">Temp</th>
                            <th data-sortable="true" class='text-right' data-field="Cat3Issues">Flow</th>
                            <th data-sortable="true" class='text-right' data-field="Cat4Issues">Conc</th>
                            <th data-sortable="true" class='text-right' data-field="TotalIssues">Deviation Count</th>
                            <th data-sortable="true" class='text-right' data-field="PercentGood">% Compliance</th>
                        </tr>
                    </thead>         
                    <tbody>
                    </tbody>        
                </table> 
            </div>
        </div>    
    </div>    
</div>


@endsection


@section('javascript')


<script src="/js/exception.min.js" ></script>

@endsection
