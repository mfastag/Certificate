
var filter={};
$(function() {
    setupAjaxToken();


   $("#dateFrom").val(moment().subtract(1, 'weeks').format('YYYY-MM-DD'));
   $("#dateFrom").val('2022-06-01');
   $("#dateTo").val(moment().format('YYYY-MM-DD'));

   refresh(0);

   $('#dateFrom').change(x=>{refresh(1);});
   $('#dateTo').change(x=>{refresh(1);});
   $('#chemical').change(x=>{refresh(1);});
   $('#plant').change(x=>{refresh(1);});
   
});

function refresh(filter=0) {
   //if(filter) 
   filter=buildFilter();
   getData('/inventory/getList?'+$.param( filter ),doTotalUsage);
}

function buildFilter() {
    filter.dateFrom = $('#dateFrom').val();
    filter.dateTo = $('#dateTo').val();
    filter.chemical = $('#chemical').val();
    filter.plant = $('#plant').val();
    return filter;
}

function buildForm(chems) {
    $f=$("#logForm");

    let split = Object.keys(chems).length /2;

    let left='';
    let right='';
    let cnt=0;


    let sh =  '<div class="m-2 form-group row">';
    sh += '<div class="col-sm"><label for="frmPlant" class="">Plant</label> <select name="frmPlant" id="frmPlant"></select> </div>'; 
    sh += "</div>";

    Object.keys(chems).forEach(c=>{
          let s = '<div class="m-2 form-group row">';
          s+=`<div class="m-0 col-8" ><label for='chem_${chems[c]}' class="m-0 col-form-label col-form-label-sm">${c}</label></div>`;
          s+=`<div class="m-0 col-2"><input type='number' class="m-0 form-control form-control-sm" name='chem_recvd_${chems[c]}' placeholder='0.0'></div>`;
          s+=`<div class="m-0 col-2"><input type='number' class="m-0 form-control form-control-sm" name='chem_curr_${chems[c]}' placeholder='0.0'></div>`;
        s+='</div>';
        if(cnt++<split) {
            left+=s;
        } else {
            right+=s;
        }
    });

    let hdr=`<div class="m-2 row font-weight-bold border-bottom"><div class="m-0 col-8 " >Chemical</div>`;
        hdr+=`<div class="m-0 col-2">Recvd</div>`;
        hdr+=`<div class="m-0 col-2">Curr</div></div>`;



    $f.html(`${sh}<div class='row'><div class='col-6' style="border-right: 1px solid #ccc;">${hdr}${left}</div><div class='col-6'>${hdr}${right}</div></div>`);
}

function saveLog() {
    let form = $('#logForm').serializeArray();
    let data = {};
    form.forEach(f=>{
        data[f.name]=f.value;
    });

    $.post('/inventory/saveLog',data,function(data){
        console.log('data',data);
        refresh(1);
    }).fail(function(data){
        console.log('data',data);
    });
}

function doTotalUsage(d) {

    let plants={};
    let chems={};

    d.forEach(x=>{
        plants[x.tblCip_Plants_id]=x["PlantName"];
        chems[x["chemical_name"]]=x.id;
    });
   
    buildForm(chems);

    chems=(Object.keys(chems)).sort();
    plantKeys=(Object.keys(plants)).sort();

    $('#chemical').find('option').remove();
    $('#chemical').append($('<option>', { value: "", text: 'All' }));
    chems.forEach(x=>{
        $('#chemical').append($('<option>', { value: x, text: x }));
    });
    $('#chemical option[value="'+filter.chemical+'"]').attr("selected", "selected");



    $('#plant').find('option').remove();
    $('#frmPlant').find('option').remove();
    $('#plant').append($('<option>', { value: "", text: 'All' }));
    plantKeys.forEach(x=>{
        $('#plant').append($('<option>', { value: plants[x], text: plants[x] }));
        $('#frmPlant').append($('<option>', { value: x, text: plants[x] }));
    });
    $('#plant option[value="'+filter.plant+'"]').attr("selected", "selected");

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
    

