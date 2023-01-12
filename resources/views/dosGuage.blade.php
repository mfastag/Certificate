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
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300">&nbsp;</i>
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


<script>
var filter={};
$(function() {
   setupAjaxToken();
   refresh(0);

   $('#plant').change(x=>{refresh(1);});
});

function refresh(filter=0) {
   //if(filter) 
   filter=buildFilter();
   getData('/inventory/getDosG?'+$.param( filter ),doDosChart);
}


function buildFilter() {
    filter.plant = $('#plant').val();
    return filter;
}


function doDosChart(d) {
    chartDiv = $('#chartDiv');
    chartDiv.empty();
    let plants={};
    d.forEach(x=>{
        let s=`<div style="border:0px solid red" class="col-2 mb-2"><div class="card shadow h-100"><div id="chrt${x.id}_${x.tblCip_Plants_id}"></div> </div></div>`;

        chartDiv.append(s);

        plants[x.tblCip_Plants_id]=x.PlantName;

        let trace = {
            type: "indicator",
            mode: "gauge+number",
            value: x.DaysOfInventory,
            name: x.chemical_name,
            title: { 
                text: `${x.PlantName} - ${x.chemical_name}` ,
                font: { size: 12 }
            },
            gauge: {
                axis: { range: [-100, 100] },
                bar: { color: x.color },
            }
         };
        var layout = { width: 240, height: 180, margin: { t: 0, b: 0, l:45, r:45 } };
        Plotly.newPlot(`chrt${x.id}_${x.tblCip_Plants_id}`, [trace], layout);
    });


    plantKeys=(Object.keys(plants)).sort();

    $('#plant').find('option').remove();
    $('#plant').append($('<option>', { value: "", text: 'All' }));
    plantKeys.forEach(x=>{
        console.log(x,plants[x]);
        $('#plant').append($('<option>', { value: plants[x], text: plants[x] }));
    });
    $('#plant option[value="'+filter.plant+'"]').attr("selected", "selected");    


}


    



    </script>

@endsection
