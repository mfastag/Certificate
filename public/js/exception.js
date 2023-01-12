
var react=0;
$(function() {
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
   getData("/exception/ByType",  doChart1);
   getData("/exception/ByObject",  doChart2);
   getData("/exception/ByLine",  doChart3);
   getData("/exception/TopByObject",  doTopTable);
   //doChart2(filter);
   //doChart3(filter);
  //doExpTrend30Chart(filter);
   //doTotalsTrend30Chart(filter);
}

function doTopTable(d) {
    $('#dtable').bootstrapTable('load',d);
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


function doChart1(d) {
    let a=[];
    d.labels.forEach(x=>{a.push(x);});

    let v=[];
    d.values.forEach(x=>{v.push( x  );});

    var trace1 = {
        labels: a,
        values: v,
        type: 'pie',
        hole: 0.2,
        textinfo: "label+value",
        textposition: "outside",
        automargin: true
        //mode: 'markers',
    };
    var layout = {
      responsive: false,
      showlegend: false,
      height: 260,
      autosize:true,
        margin: {
            l: 20,
            r: 20,
            b: 20,
            t: 0,
            pad: 0
        },
      
    };  

    Plotly.newPlot('chart1_div', [trace1], layout);
 

    document.getElementById('chart1_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
    });
}


function doChart2(d) {
    let a=[];
    d.labels.forEach(x=>{a.push(x);});

    let v=[];
    d.values.forEach(x=>{v.push( x  );});

    var trace1 = {
        labels: a,
        values: v,
        type: 'pie',
        hole: 0.2,
        textinfo: "label+value",
        textposition: "outside",
        automargin: true
        //mode: 'markers',
    };
    var layout = {
      responsive: false,
      showlegend: false,
      height: 260,
      autosize:true,
        margin: {
            l: 20,
            r: 20,
            b: 20,
            t: 0,
            pad: 0
        },
      
    };  

    Plotly.newPlot('chart2_div', [trace1], layout);
 

    document.getElementById('chart1_div').on('plotly_click', function(data){
        console.log(data.points[0].x,data.points[0].y);
    });
}


function doChart3(d) {
    let a=[];
    d.labels.forEach(x=>{a.push(x);});

    let v=[];
    d.values.forEach(x=>{v.push( x  );});

    var trace1 = {
        labels: a,
        values: v,
        type: 'pie',
        hole: 0.2,
        textinfo: "label+value",
        textposition: "outside",
        automargin: true
        //mode: 'markers',
    };
    var layout = {
      responsive: false,
      showlegend: false,
      height: 260,
      autosize:true,
        margin: {
            l: 20,
            r: 20,
            b: 20,
            t: 0,
            pad: 0
        },
      
    };  

    Plotly.newPlot('chart3_div', [trace1], layout);
 

    document.getElementById('chart1_div').on('plotly_click', function(data){
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
