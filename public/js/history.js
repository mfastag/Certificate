
var filter={};
$(function() {
   $("#dateFrom").val(moment().subtract(2, 'weeks').format('YYYY-MM-DD'));
   $("#dateTo").val(moment().format('YYYY-MM-DD'));

   refresh(0);

   $('#dateFrom').change(x=>{refresh(1);});
   $('#dateTo').change(x=>{refresh(1);});
   $('#system').change(x=>{refresh(1);});
   $('#line').change(x=>{refresh(1);});
   $('#plant').change(x=>{refresh(1);});
   $('#object').change(x=>{refresh(1);});
});

function refresh(filter=0) {
   filter=buildFilter();
   getData('/api/whistory?'+$.param( filter ),doHistoryTable);
}


function historyDetailFormatter(value, row, index) {
    return `${value} <a style="margin-left:10px" href="#" class="historyDetail" data-cipid="${row['ID']}" onclick="detailClick(this)"><i class="fas fa-lg fa-info-circle"></i></a>`;
 }

 function detailClick(e) {
    openCipDetail($(e).data('cipid'));
  }

function buildFilter() {
    filter.dateFrom = $('#dateFrom').val();
    filter.dateTo = $('#dateTo').val();
    filter.system = $('#system').val();
    filter.plant = $('#plant').val();
    filter.line = $('#line').val();
    filter.object = $('#object').val();
    filter.exception = $('#exception').val();
    filter.api_token= API_TOKEN;
    return filter;
}


function cellExceptionStyle(value, row, index) {
    if (value=='TRUE') {
        return {
          classes: 'bg-red'
        }
    }
    return {};
  }



function doHistoryTable(d) {

    let systems={};
    let lines={};
    let obj={};
    let plants={};

    let totchem=0;
    let totfacility=0;
    let tottotal=0;

    d.forEach(x=>{
        totchem+= parseFloat(x["Total Chemical Cost"]);
        totfacility+=parseFloat(x["facility_cost"]);
        tottotal+=parseFloat(x["total_cost"]);
        systems[x["CIP System"]]=1;
        lines[x["CIP Line"]]=1;
        obj[x["Object"]]=1;
        plants[x["Plant"]]=1;
    });

    
    $('#totchem').html('$'+totchem.toLocaleString()  );
    $('#totfacility').html('$'+totfacility.toLocaleString());
    $('#tottot').html('$'+tottotal.toLocaleString());


    systems=(Object.keys(systems)).sort();
    lines=(Object.keys(lines)).sort();
    obj=(Object.keys(obj)).sort();
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

    $('#dtable').bootstrapTable('load',d);
    
//    $('#dtable').bootstrapTable({data:d});
//    $('#dtable').bootstrapTable('load',d);
    
   // $('#system').append( $('<option></option>').val('').html('All') )
   // $.each(d.distinct, function(val, text) {
   //         $('#system').append( $('<option></option>').val(text).html(text) )
   // });


}


