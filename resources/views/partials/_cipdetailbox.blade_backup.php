<!-- Modal -->



<div class="modal fade text-xs font-black" id="_cipDetailModal" tabindex="-1" role="dialog" aria-labelledby="cipDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" style='max-width:100%' role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cipDetailModalLabel">CIP Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table
                style='width:100%' 
                class='table table-bordered table-hover table-sm table-striped font-black'
                id='_cipDetailTable'
                data-toggle='table'
                data-virtual-scroll="true"
                data-show-columns="true"
                data-pagination-h-align="left"
                data-pagination-detail-h-align="right"
                data-search='false'
                data-show-export="true"
                data-export-types="['excel','csv','txt']"
                data-sort-name="Step_Position"
                data-sort-order="asc"
                data-cardView='false'>
                <thead>
                <th data-sortable="true" data-field="Step_Position">Step Pos.</th>
                </thead>         
                <tbody>
                </tbody>        
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
function openCipDetail(cipId) {
    getData(`/cip/detail?id=${cipId}`,function(d) {

      if(d.length > 0) {
        //$head = $('#_cipDetailTable thead tr');
        //$head.empty();
        
        
        let cols = Object.keys(d[0]);
        let colList=[];
        cols.forEach(col=>{
          c = {field:col,title:col,visible: true};

          if(col.startsWith('C_')) c.visible = false;

          colList.push(c);
          
          //console.log(bcols);
          // {
          //  $('#_cipDetailTable').bootstrapTable('hideColumn', $col);
          //}
        });

        console.log("colList",colList);
        console.log("data",d);

        $('#_cipDetailTable').bootstrapTable( {showColumns: true, columns: colList, data: d} );
        

//          $('#_cipDetailTable').bootstrapTable( {data: d} );
        
        //$('#_cipDetailTable').bootstrapTable('load',d);
      }
      
      [
    {
        "field": "id",
        "title": "id"
    },
    {
        "field": "Step_name",
        "title": "Step_name"
    },
    {
        "field": "Std_Mins",
        "title": "Std_Mins"
    },
    {
        "field": "inserted",
        "title": "inserted"
    },
    {
        "field": "Step_Position",
        "title": "Step_Position"
    },
    {
        "field": "Time",
        "title": "Time"
    },
    {
        "field": "Temperature",
        "title": "Temperature"
    },
    {
        "field": "Flow Rate",
        "title": "Flow Rate"
    },
    {
        "field": "Chemical Reading",
        "title": "Chemical Reading"
    },
    {
        "field": "Temperature Delay Time",
        "title": "Temperature Delay Time"
    },
    {
        "field": "Chemical Delay Time",
        "title": "Chemical Delay Time"
    },
    {
        "field": "Chemical Add Time",
        "title": "Chemical Add Time"
    },
    {
        "field": "Chemical Add Max. Time",
        "title": "Chemical Add Max. Time"
    },
    {
        "field": "Flow Confirmation",
        "title": "Flow Confirmation"
    },
    {
        "field": "Message",
        "title": "Message"
    },
    {
        "field": "C_Time",
        "title": "C_Time"
    }
]
      //

      //

    
      $('#_cipDetailModal').modal('show');     
    });
}
</script>