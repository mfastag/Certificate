@extends('main2')

@section('content')
<style>
.card {
    height:350px;
}
</style>

<div class="row">

<!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-2 ">
        <div class="card border-left-primary shadow  h-100 py-1">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
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
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">30 Day Chemical Cost w/ Exceptions
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
                    <div class="col mr-2">
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
                    <div class="col mr-2">
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
        <div class="col-xl-8 col-lg-7  ">

            <!-- Area Chart -->
            <div class="card shadow mb-2">
                <div class="card-header py-1">
                    <h6 class="m-0 font-weight-bold text-primary">Chemical Cost and Count 30 Days</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" >
                        <div id="chart2_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                    <hr>
                   <!--chart footer-->
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="card shadow mb-2">
                <div class="card-header py-1">
                    <h6 class="m-0 font-weight-bold text-primary">Cost Summary</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <div id="chart3_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                    <hr>
                   <!--chart footer-->
                   </div>
            </div>

        </div>

        <!-- Donut Chart -->
        <div class="col-xl-4 col-lg-5 ">
            <div class="card shadow mb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-1">
                    <h6 class="m-0 font-weight-bold text-primary">Exceptions By Type</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-1">
                        <div id="chart1_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                    <hr>
                   <!--chart footer-->
                   </div>
            </div>



            <div class="card shadow mb-2">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Exceptions Cost By Type</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <div id="chart5_div" style='max-height: 90%; height:90%;'></div>
                    </div>
                    <hr>
                   <!--chart footer-->
                   </div>
            </div>


        </div>
    </div>

    </div>
</div>


@endsection


@section('javascript')


<script>
var react=0;
$(function() {
   // let y=getData("/data1");
   // console.log(y);
   refresh();


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
   doExpPieChart(filter);
   doExpTrend30Chart(filter);
   doTotalsTrend30Chart(filter);
}


function buildFilter() {
    let filter = {a:1   };
    //filter.dateFrom = $('#dateFrom').val();
    //filter.dateTo = $('#dateTo').val();
    //filter.system = $('#system').val();
    //filter.line = $('#line').val();
    //filter.object = $('#object').val();
    //filter.exception = $('#exception').val();

    return filter;
}

function doExpPieChart(filter) {
    let d = getData('/expDashPie?'+$.param( filter ));

    let a=[];
    d.labels.forEach(x=>{a.push(x);});

    var trace1 = {
        labels: a,
        values: d.values,
        type: 'pie',
        hole: 0.5,
        textinfo: "label+percent",
        textposition: "outside",
        automargin: true
        //mode: 'markers',
    };
    var layout = {
      responsive: false,
      showlegend: false,
      height: 200,
      autosize:true,
        margin: {
            l: 20,
            r: 20,
            b: 20,
            t: 0,
            pad: 0
        },
      
    };  

    $('#chemcostexp').html('$'+d.chemCost.toLocaleString());

    console.log('doExpPieChart',d);

    Plotly.newPlot('chart1_div', [trace1], layout);
 
    doExpPieChartByCost(d);

    document.getElementById('chart1_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
    });
}

function doExpPieChartByCost(d) {
    let a=[];
    d.labels.forEach(x=>{a.push(x);});

    let v=[];
    d.costValues.forEach(x=>{v.push( x  );});

    var trace1 = {
        labels: a,
        values: v,
        type: 'pie',
        hole: 0.5,
        textinfo: "label+value",
        textposition: "outside",
        automargin: true
        //mode: 'markers',
    };
    var layout = {
      responsive: false,
      showlegend: false,
      height: 200,
      autosize:true,
        margin: {
            l: 20,
            r: 20,
            b: 20,
            t: 0,
            pad: 0
        },
      
    };  


    console.log('doExpPieChartByCost',d);

    Plotly.newPlot('chart5_div', [trace1], layout);
 

    document.getElementById('chart1_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
    });
}



function doExpTrend30Chart(filter) {

    let d = getData('/expDashTrend?');

    var trace1 = {
        x: d.x,
        y: d.y,
        type: 'scatter',
        automargin: true,
        //mode: 'markers',
    };

    

    var trace3 = {
        x: d.x,
        y: d.count,
        type: 'bar',
        zeroline: false,
        automargin: true,
        yaxis: 'y2',
        //yaxis: {
           
        //},
        
        marker: {
            color: 'rgba(148, 103, 189, 0.3)'
        }
        //mode: 'markers',
    };

    var layout = {
      responsive: false,
      showlegend: false,
      autosize:true,
      
      height: 275,
        margin: {
            l: 40,
            r: 60,
            b: 50,
            t: 20,
            pad: 0
        },
        yaxis2: {
            title: 'CIP Count',
            titlefont: {color: 'rgb(148, 103, 189)'},
            tickfont: {color: 'rgb(148, 103, 189)'},
            overlaying: 'y',
            side: 'right',
            showgrid: false,
            },
  
    };  
    
    Plotly.newPlot('chart2_div', [trace1,trace3], layout);
 
    
    $('#chemcost').html('$'+d.total.toLocaleString());

    document.getElementById('chart2_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
    });
}



function doTotalsTrend30Chart(filter) {
    let d = getData('/totalsDashTrend?'+$.param( filter ));

    var trace1 = {
        x: d.x,
        y: d.elec,
        type: 'bar',
        name: 'Electricity',
        automargin: true
        
        //mode: 'markers',
    };


    var trace2 = {
        x: d.x,
        y: d.time,
        type: 'bar',
        name: 'Time',
        automargin: true
        //mode: 'markers',
    };

    var trace3 = {
        x: d.x,
        y: d.material,
        type: 'bar',
        name: 'Material',
        automargin: true
        //mode: 'markers',
    };

    var trace4 = {
        x: d.x,
        y: d.water,
        type: 'bar',
        name: 'Water',
        automargin: true
        //mode: 'markers',
    };

    var trace5 = {
        x: d.x,
        y: d.chem,
        name: 'Chemicals',
        type: 'bar',
        automargin: true
        //mode: 'markers',
    };


    var layout = {
      responsive: false,
      showlegend: true,
      autosize:true,
      height: 275,
      barmode: 'stack',
        margin: {
            l: 20,
            r: 20,
            b: 50,
            t: 20,
            pad: 0
        },
  
    };  

    
    console.log('doTotalsTrend30Chart',d);

    $('#totcost').html('$'+d.totCost.toLocaleString());
    

    $('#duration').html((d.duration/60).toFixed(0)+' hours');
 

    Plotly.newPlot('chart3_div', [trace5,trace3,trace4,trace1,trace2], layout);
 
    document.getElementById('chart3_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
    });
}



var toHHMMSS = (secs) => {
    var sec_num = parseInt(secs, 10)
    var hours   = Math.floor(sec_num / 3600)
    var minutes = Math.floor(sec_num / 60) % 60
    var seconds = sec_num % 60

    return [hours,minutes,seconds]
        .map(v => v < 10 ? "0" + v : v)
        .filter((v,i) => v !== "00" || i > 0)
        .join(":")
}

function secondsToDhms(seconds) {
seconds = Number(seconds);
var d = Math.floor(seconds / (3600*24));
var h = Math.floor(seconds % (3600*24) / 3600);
var m = Math.floor(seconds % 3600 / 60);
var s = Math.floor(seconds % 60);
s=0;

var dDisplay = d > 0 ? d + (d == 1 ? " day, " : " days, ") : "";
var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes ") : "";
var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
return dDisplay + hDisplay + mDisplay + sDisplay;
}


    </script>

@endsection
