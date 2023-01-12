@extends('main2')

@section('pageTitle','Inventory')

@section('style')
<style>
.card {
    height:700px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

</style>
@endsection

@section('content')

<div class="row">

    <div class="col-sm mb-2">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                        <button data-target='#logModal' data-toggle="modal" class="px-4 font-weight-bold btn btn-success"><i class='fas fa-plus'>&nbsp;</i> Add </button>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="text-xs font-weight-bold text-primary text-uppercase ">Chemical</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><select class='text-xs' id='chemical'></select></div>
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
                            data-height="650"
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
                                <th data-sortable="true" data-field="chemical_name">Chemical Name</th>    
                                <th data-sortable="true" data-field="Plant">Plant</th>
                                <th data-sortable="true" data-formatter='tableDateFormatter' data-field="LogDate">Date</th>
                                <th data-sortable="true" class='text-right' data-field="RcvdSinceLast">Recevied</th>
                                <th data-sortable="true" class='text-right' data-field="LogQty">Logged Qty</th>
                                <th data-sortable="true" class='text-right' data-field="TodayQty">Today Qty</th>
                                <th data-sortable="true" class='text-right' data-field="InventoryChangeSinceLast">Inv Change</th>
                                <th data-sortable="true" class='text-right' data-formatter='RoundFormatter2' data-field="AvgPerDaySinceLast">Avg Since Last</th>
                                <th data-sortable="true" class='text-right' data-field="NumDaysSinceLastLog">Days Since Last</th>
                                <th data-sortable="true" class='text-right' data-formatter='RoundFormatter2' data-field="AvgPerDay">Avg Use</th>
                                <th data-sortable="true" class='text-right' data-field="DaysOfInventory">Days Of Inv.</th>
                                <th data-sortable="true" data-formatter='tableDateFormatter' data-field="place_order">Place Order By</th>
                                <th data-sortable="true" data-field="changed_by">Changed By</th>
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
        

<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="logModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style='min-width: 60%'>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logModalLabel">New Log Entry</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='logForm'>@csrf
             <input type='hidden' name='logid' value='0'>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" data-target='logModal' data-dismiss="modal" class="btn btn-success" onclick='saveLog()'>Save</button>
      </div>
    </div>
  </div>
</div>

@endsection


@section('javascript')


<script src="/js/inventory.min.js" ></script>

@endsection
