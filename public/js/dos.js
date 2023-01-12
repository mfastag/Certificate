
var filter={};
$(function() {
   setupAjaxToken();
   refresh(0);

   $('#plant').change(x=>{refresh(1);});
   $('#chemical').change(x=>{refresh(1);});
});

function refresh(filter=0) {
   filter=buildFilter();
   getData('/inventory/getDosG?'+$.param( filter ),doDosChart);
}


function buildFilter() {
    filter.plant = $('#plant').val();
    filter.chemical = $('#chemical').val();
    return filter;
}


function doDosChart(d) {
   chartDiv = $('#chartDiv');
    chartDiv.empty();
    let plants={};
    let chems={};
    d.forEach(x=>{
        let s=`<div style="border:0px solid red" class="col-auto mb-2" ><div class="card shadow h-100" style='max-width: 180px !important;width: 160px'><div id="chrt${x.id}_${x.tblCip_Plants_id}"></div> <span class='text-small text-center'>${x.PlantName}<br>${x.DaysOfInventory} Days</span></div></div>`;

        chartDiv.append(s);

        plants[x.tblCip_Plants_id]=x.PlantName;

        $(`nme${x.id}_${x.tblCip_Plants_id}`).html(x.PlantName);

        chems[x.chemical_name]=1;

        const red = '#CC0000';
        const yellow = '#F5F500';
        const green = '#32B232';
        
        barColor=green; 

        x.TodayQty=parseFloat(x.TodayQty);
        x.WarningQty=parseFloat(x.WarningQty);
        x.RedQty=parseFloat(x.RedQty);

        if(x.TodayQty<=x.WarningQty) barColor=yellow;
        if(x.TodayQty<=x.RedQty) barColor=red;

        let traces = [
        {
           type: "bar",
           name: '',
           y: [x.LogQty],
           x: [x.chemical_name],
           marker: {
                color: '#909090',
           },
        },
        {
           type: "bar",
           name: 'TodayQty',
           //text: `${x.DaysOfInventory} DOS`,
           showlegend: false, 
           y: [x.TodayQty],
           x: [x.chemical_name],
           marker: {
                color:  barColor,
                opacity: 1
           },
        }
        ];
        var layout = { 
            title: {
                text: x.chemical_name, 
                font: {
                    size: 14,
                    color: '#000000'
                }
            },
            xaxis: {
                showticklabels: false
            },
            showlegend: false, 
            barmode: 'overlay', 
            width: 160, 
            height: 200, 
            margin: { t: 40, b: 40, l:45, r:45 } 
        };
        Plotly.newPlot(`chrt${x.id}_${x.tblCip_Plants_id}`, traces, layout);
    });

    plantKeys=(Object.keys(plants)).sort();
    chems=(Object.keys(chems)).sort();

    $('#plant').find('option').remove();
    $('#plant').append($('<option>', { value: "", text: 'All' }));
    plantKeys.forEach(x=>{
        $('#plant').append($('<option>', { value: plants[x], text: plants[x] }));
    });
    $('#plant option[value="'+filter.plant+'"]').attr("selected", "selected");    

    $('#chemical').find('option').remove();
    $('#chemical').append($('<option>', { value: "", text: 'All' }));
    chems.forEach(x=>{
        $('#chemical').append($('<option>', { value: x, text: x }));
    });
    $('#chemical option[value="'+filter.chemical+'"]').attr("selected", "selected");    


}

