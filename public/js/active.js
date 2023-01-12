$(function() {
    getData('/activeColors',colorCB);    

    $('#system').change(x=>{refresh();});
    $('#line').change(x=>{refresh();});
    $('#object').change(x=>{refresh();});
    $('#plant').change(x=>{refresh();});

    params = getURLParameters();
    console.log('params',params);

    if(params["plant"]) $('#plant').append($('<option>', { value: params.plant, text: params.plant }));
    if(params["equipment"]) $('#object').append($('<option>', { value: params.equipment, text: params.equipment }));
    if(params["line"]) $('#line').append($('<option>', { value: params.line, text: params.line }));

    $('#line').val(params.line);
    $('#object').val(params.equipment);
    $('#plant').val(params.plant);


    refresh(1);

});

function colorCB(d) {
    d.forEach(x=>{
        let htm=`<div class="col-sm mb-2"><div class="no-gutters align-items-center font-weight-bold text-dark card shadow h-100 py-1" style="color:black !important; background-color: ${x.StatusColor}">${x.ColorReason}</div></div>`
        $('#colors').append(htm);
    });
}

function refresh(auto=false) {
    filter=buildFilter();
    let d = getData('/activeData?'+$.param(filter),activeCB);    
    if(auto)setTimeout(function(){refresh(1);},30000);
}

function titleClick(e) {
    openCipDetail($(e).data('cipid'));
}

function buildFilter() {
let filter = {a:1   };
filter.line = $('#line').val();
filter.object = $('#object').val();
filter.plant = $('#plant').val();
lnk = $.param( {line: filter.line ,plant: filter.plant, equipment: filter.object});
$('#permlink').attr("href", '/active?'+lnk );

return filter;
}

function activeCB(d) {
    let show=[];
    let equipList=[];
    let plants=[];
    let lines=[];
    d.forEach(i=> {
        id=i.PLC_Master_id
        show.push(parseInt(id));
        equipList[i.PLC_Name]=1;
        plants[i.PlantName]=1;
        lines[i.Cip_Line]=1;

        $(`#card${id}`).show();
        $(`#pretitle${id}`).html(`${i.PlantName} - ${i.Cip_Line} - ${i.PLC_Name}`);
//            $(`#card${id} .title`).html(`${i.PLC_Name} - ${i.GelType}`);
        $(`#title${id}`).html(`${i.GelType}`);
        $(`#formula${id}`).html(`${i.Formula_Batch_ID}`);
        $(`#titlebar${id}`).css('background-color',i.StatusColor);
        $(`#stepname${id}`).html(`Step: ${i.stepOrder} of ${i.maxSteps} - ${i.StepName}`);
        $(`#steptime${id}`).html(`${i.ProcessDate}`);

        $(`#titlebar${id}`).attr('data-cipid',`${i.tblSiteWideData_id}`);


        let pct = ((i.stepOrder/i.maxSteps)*100).toFixed(0);
        $(`#progress${id}`).css('width',`${pct}%`).attr('aria-valuenow',pct).html(`${pct}%`);

        let stepdet='';
        if(i.DurationMin>0) {
            i.DurationMin=parseInt(i.DurationMin);
            stepdet+=`Duration: ${i.DurationMin} minutes<br>`;
        }
        if(i.SetPoint>0) {
            i.SetPoint=parseFloat(i.SetPoint).toFixed(2);
            stepdet+=`Setpoint: ${i.SetPoint}<br>`;
        }
        if(i.Acknowledge>0) {
            stepdet+=`Acknowledge Required<br>`;
        }
        $(`#stepdet${id}`).html(stepdet);
    });
    
    // hide unused cards
    for(let i=0;i<40;i++) {
        if(!show.includes(i)) {
            $(`#card${i}`).hide();
        }
    }

    equipList=(Object.keys(equipList)).sort();
    plants=(Object.keys(plants)).sort();
    lines=(Object.keys(lines)).sort();

    $('#object').find('option').remove();
    $('#object').append($('<option>', { value: "", text: 'All' }));
    equipList.forEach(x=>{
        $('#object').append($('<option>', { value: x, text: x }));
    });
    $('#object option[value="'+filter.object+'"]').attr("selected", "selected");

    $('#plant').find('option').remove();
    $('#plant').append($('<option>', { value: "", text: 'All' }));
    plants.forEach(x=>{
        $('#plant').append($('<option>', { value: x, text: x }));
    });
    $('#plant option[value="'+filter.plant+'"]').attr("selected", "selected");


    $('#line').find('option').remove();
    $('#line').append($('<option>', { value: "", text: 'All' }));
    lines.forEach(x=>{
        $('#line').append($('<option>', { value: x, text: x }));
    });
    $('#line option[value="'+filter.line+'"]').attr("selected", "selected");
}
