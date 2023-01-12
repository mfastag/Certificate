@extends('main')

@section('title','Charts')

@section('content')

<style>
    #filter_div {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        grid-template-rows: 1fr; 
        grid-gap: 10px;
        
    }

    #charts_div {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: 1fr 1fr ; 
        grid-gap: 8px;
        
    }

    #charts_div > div {
        min-height: 40vh; 
    }

.chartbox {
    margin: 0px;
    border: 2px solid black;
    border-radius: 5px;
    padding:0px;
    
}    
</style>


<div id="dashboard_div">
    <div id="filter_div">
        <div id="filter_div1">From: <input type='date' id='dateFrom'> To: <input type='date' id='dateTo'></div>
        <div id="filter_div2">Exception: <select id='exception'><option value=''>All</options><option value='TRUE'>TRUE</options><option value='FALSE'>FALSE</options></select></div>
        <div id="filter_div2">System: <select id='system'></select></div>
        <div id="filter_div3">Line: <select id='line'></select></div>
        <div id="filter_div4">Object: <select id='object'></select></div>
    </div>

    <div id="charts_div">
        <div id="chart1_div" class='chartbox'></div>
        <div id="chart5_div" class='chartbox'></div>
        <div id="chart3_div" class='chartbox'></div>
        <div id="chart4_div" class='chartbox'></div>
        <div id="chart2_div" class='chartbox'></div>
        <div id="chart6_div" class='chartbox'></div>
    </div>      
</div>

   

@endsection





@section('javascript')

<script>
var react=0;
$(function() {
   // let y=getData("/data1");
   // console.log(y);
   doChart1({});
   doChart2({});
   doChart3({});
   doChart4({});

   $('#dateFrom').change(x=>{refresh();});
   $('#dateTo').change(x=>{refresh();});
   $('#system').change(x=>{refresh();});
   $('#line').change(x=>{refresh();});
   $('#object').change(x=>{refresh();});
   $('#exception').change(x=>{refresh();});
});

function refresh(filter=0) {
   if(!filter) filter=buildFilter();
   react=0;
   doChart1(filter);
   doChart2(filter);
   doChart3(filter);
   doChart4(filter);
}

function getData(url) {
    return $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        async: false
    }).responseJSON;
}

function buildFilter() {
    let filter = {};
    filter.dateFrom = $('#dateFrom').val();
    filter.dateTo = $('#dateTo').val();
    filter.system = $('#system').val();
    filter.line = $('#line').val();
    filter.object = $('#object').val();
    filter.exception = $('#exception').val();

    return filter;
}

function doChart1(filter) {
    let d = getData('/chart1_data?'+$.param( filter ));

    $('#dateFrom').val(d.min);
    $('#dateTo').val(d.max);

    var trace1 = {
        x: d.x,
        y: d.y,
        type: 'bar',
        line: {shape: 'spline'},
        
        //mode: 'markers',
    };
    var layout = {
      title: 'Exceptions Triggered',
      margin: {l: 30,r: 30},
      responsive: false
    };  
    
    if(react) {
        console.log("React");
        Plotly.react('chart1_div', [trace1], layout);
    } else {
        Plotly.newPlot('chart1_div', [trace1], layout);
    }

    document.getElementById('chart1_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
        let filter = buildFilter();
        filter.dateFrom = data.points[0].x;
        filter.dateTo = data.points[0].x;
        refresh(filter);
    });
}


function doChart2(filter) {
    let d = getData('/chart2_data?'+$.param( filter ));

    $('#system').find('option').remove();
    $('#system').append( $('<option></option>').val('').html('All') )
    $.each(d.distinct, function(val, text) {
            $('#system').append( $('<option></option>').val(text).html(text) )
    });
    
    $('#system option[value="'+filter.system+'"]').attr("selected", "selected");

    var trace1 = {
        x: d.x,
        y: d.y,
        type: 'bar',
        //mode: 'markers',
    };
    var layout = {
      title: 'Exceptions Triggered by System',
      margin: {l: 30,r: 30},
      responsive: false
    };  
    
    
    if(react) {
        Plotly.react('chart2_div', [trace1], layout);
    } else {
        Plotly.newPlot('chart2_div', [trace1], layout);
    }

}

function doChart3(filter) {
    let d = getData('/chart3_data?'+$.param( filter ));

    $('#line').find('option').remove();
    $('#line').append( $('<option></option>').val('').html('All') )

    $.each(d.distinct, function(val, text) {
            $('#line').append( $('<option></option>').val(text).html(text) )
    });
    $('#line option[value="'+filter.line+'"]').attr("selected", "selected");

    var trace1 = {
        x: d.x,
        y: d.y,
        type: 'bar',
        //mode: 'markers',
    };
    var layout = {
      title: 'Exceptions Triggered by Line',
      scrollZoom: true,
      margin: {l: 30,r: 30},
      responsive: false
    };  
    
    if(react) {
        Plotly.react('chart3_div', [trace1], layout);
    } else {
        Plotly.newPlot('chart3_div', [trace1], layout);
    }
}


function doChart4(filter) {
    let d = getData('/chart4_data?'+$.param( filter ));

    $('#object').find('option').remove();
    $('#object').append( $('<option></option>').val('').html('All') )

    $.each(d.distinct, function(val, text) {
            $('#object').append( $('<option></option>').val(text).html(text) )
    });
    $('#object option[value="'+filter.object+'"]').attr("selected", "selected");

    var trace1 = {
        x: d.x,
        y: d.y,
        type: 'bar',
        //mode: 'markers',
    };
    var layout = {
      title: 'Exceptions Triggered by Object',
      scrollZoom: true,
      margin: {l: 30,r: 30},
      responsive: false
    };  
    
    Plotly.newPlot('chart4_div', [trace1], layout);
}

    </script>

@endsection

