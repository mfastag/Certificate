
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
      height: 190,
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
      height: 190,
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
      
      height: 260,
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
        console.log(data);
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

    var trace6 = {
        x: d.x,
        y: d.therm,
        name: 'Thermal',
        type: 'bar',
        automargin: true
        //mode: 'markers',
    };


    var layout = {
      responsive: false,
      showlegend: true,
      autosize:true,
      height: 260,
      config: {
        'displayModeBar': 0
      },
      barmode: 'stack',
        margin: {
            l: 40,
            r: 40,
            b: 50,
            t: 20,
            pad: 0
        },
  
    };  

    
    console.log('doTotalsTrend30Chart',d);

    $('#totcost').html('$'+d.totCost.toLocaleString());
    

    $('#duration').html((d.duration/60).toFixed(0)+' hours');
 

    Plotly.newPlot('chart3_div', [trace5,trace3,trace4,trace1,trace2,trace6], layout);
 
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

