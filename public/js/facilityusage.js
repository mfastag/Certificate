
var filter={};
$(function() {
   $("#dateFrom").val(moment().subtract(2, 'weeks').format('YYYY-MM-DD'));
   //$("#dateFrom").val('2022-06-01');
   $("#dateTo").val(moment().format('YYYY-MM-DD'));

   refresh(0);

   $('#dateFrom').change(x=>{refresh(1);});
   $('#dateTo').change(x=>{refresh(1);});
   $('#system').change(x=>{refresh(1);});
   $('#line').change(x=>{refresh(1);});
   $('#plant').change(x=>{refresh(1);});
   $('#object').change(x=>{refresh(1);});
   $('#measure').change(x=>{refresh(1);});
});

function refresh(filter=0) {
   //if(filter) 
   filter=buildFilter();
   getData('/api/facility/totalUsage?'+$.param( filter ),doTotalUsage);
   getData('/api/facility/totalUsageChart?'+$.param( filter ),doChart);
}




function buildFilter() {
    filter.dateFrom = $('#dateFrom').val();
    filter.dateTo = $('#dateTo').val();
    filter.system = $('#system').val();
    filter.plant = $('#plant').val();
    filter.line = $('#line').val();
    filter.object = $('#object').val();
    filter.exception = $('#exception').val();
    filter.measure = $('#measure').val();
    filter.api_token= API_TOKEN;
    return filter;
}



function doTotalUsage(d) {
console.log(d);
    let systems={};
    let lines={};
    let obj={};
    let measures={};
    let plants={};

    d.forEach(x=>{
        systems[x["CIP System"]]=1;
        lines[x["CIP Line"]]=1;
        obj[x["Object"]]=1;
        measures[x["FieldName"]]=x.cost;
        plants[x["Plant"]]=1;
    });
   
    systems=(Object.keys(systems)).sort();
    lines=(Object.keys(lines)).sort();
    obj=(Object.keys(obj)).sort();
    measures=(Object.keys(measures)).sort();
    plants=(Object.keys(plants)).sort();


    $('#plant').find('option').remove();
    $('#plant').append($('<option>', { value: "", text: 'All' }));
    plants.forEach(x=>{
        $('#plant').append($('<option>', { value: x, text: x }));
    });
    $('#plant option[value="'+filter.plant+'"]').attr("selected", "selected");

    $('#system').find('option').remove();
    $('#system').append($('<option>', { value: "", text: 'All' }));
    systems.forEach(x=>{
        $('#system').append($('<option>', { value: x, text: x }));
    });
    $('#system option[value="'+filter.system+'"]').attr("selected", "selected");

    $('#line').find('option').remove();
    $('#line').append($('<option>', { value: "", text: 'All' }));
    lines.forEach(x=>{
        $('#line').append($('<option>', { value: x, text: x }));
    });
    $('#line option[value="'+filter.line+'"]').attr("selected", "selected");

    $('#object').find('option').remove();
    $('#object').append($('<option>', { value: "", text: 'All' }));
    obj.forEach(x=>{
        $('#object').append($('<option>', { value: x, text: x }));
    });
    $('#object option[value="'+filter.object+'"]').attr("selected", "selected");

    $('#measure').find('option').remove();
    $('#measure').append($('<option>', { value: "", text: 'All' }));
    measures.forEach(x=>{
        $('#measure').append($('<option>', { value: x, text: x }));
    });
    $('#measure option[value="'+filter.measure+'"]').attr("selected", "selected");

    //console.log(d);
    
    $('#dtable').bootstrapTable({data:d});
    $('#dtable').bootstrapTable('load',d);
    
   // $('#system').append( $('<option></option>').val('').html('All') )
   // $.each(d.distinct, function(val, text) {
   //         $('#system').append( $('<option></option>').val(text).html(text) )
   // });


}


function doChart(d) {
    let measures = [];
    let dates=[];

    console.log(d);

    d.data.forEach(x=>{
        measures[x.FieldName]=1;
        dates[x["StartDateTime"]]=1;
    } );

    measures=Object.keys(measures);
    dates=Object.keys(dates);
  
    let traces=[];
    measures.forEach(x=>{
        cdata = d.data.filter(y=>y.FieldName==x);
        let trace = {
            x: dates,
            y: cdata.map(y=>y.cost),
            type: 'scatter',
            name: x
        };
        traces.push(trace);
    } );
    

    var layout = {
      responsive: false,
      showlegend: true,
      autosize:true,
      
      height: 310,
        margin: {
            l: 40,
            r: 60,
            b: 30,
            t: 10,
            pad: 0
        },
  
    };  
    
    Plotly.newPlot('chrt', traces, layout);
}
    
