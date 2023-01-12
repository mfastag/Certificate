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
   $('#chemical').change(x=>{refresh(1);});
});

function refresh(filter=0) {
   //if(filter) 
   filter=buildFilter();
   getData('/api/chemical/totalUsage?'+$.param( filter ),doTotalUsage);
   getData('/api/chemical/totalUsageChart?'+$.param( filter ),doChart);
}




function buildFilter() {
    filter.dateFrom = $('#dateFrom').val();
    filter.dateTo = $('#dateTo').val();
    filter.system = $('#system').val();
    filter.plant = $('#plant').val();
    filter.line = $('#line').val();
    filter.object = $('#object').val();
    filter.exception = $('#exception').val();
    filter.chemical = $('#chemical').val();
    filter.api_token= API_TOKEN;
    return filter;
}



function doTotalUsage(d) {

    let systems={};
    let lines={};
    let obj={};
    let chems={};
    let plants={};

    d.forEach(x=>{
        systems[x["CIP System"]]=1;
        lines[x["CIP Line"]]=1;
        obj[x["Object"]]=1;
        chems[x["ChemicalName"]]=x.usage;
        plants[x["Plant"]]=1;
    });
   
    systems=(Object.keys(systems)).sort();
    lines=(Object.keys(lines)).sort();
    obj=(Object.keys(obj)).sort();
    chems=(Object.keys(chems)).sort();
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

    $('#chemical').find('option').remove();
    $('#chemical').append($('<option>', { value: "", text: 'All' }));
    chems.forEach(x=>{
        $('#chemical').append($('<option>', { value: x, text: x }));
    });
    $('#chemical option[value="'+filter.chemical+'"]').attr("selected", "selected");

    //console.log(d);
    
    $('#dtable').bootstrapTable({data:d});
    $('#dtable').bootstrapTable('load',d);
    
   // $('#system').append( $('<option></option>').val('').html('All') )
   // $.each(d.distinct, function(val, text) {
   //         $('#system').append( $('<option></option>').val(text).html(text) )
   // });


}


function doChart(d) {
    let chemicals = [];
    let dates=[];
    d.data.forEach(x=>{
        chemicals[x.ChemicalName]=1;
        dates[x["StartDateTime"]]=1;
    } );

    chemicals=Object.keys(chemicals);
    dates=Object.keys(dates);
  
    let traces=[];
    chemicals.forEach(x=>{
        cdata = d.data.filter(y=>y.ChemicalName==x);
        let trace = {
            x: dates,
            y: cdata.map(y=>y.usage),
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