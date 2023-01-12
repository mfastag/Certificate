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
                >
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
      // dynamically create the table columns from the returns data.

      // if we get rows back...
      if(d.length > 0) {
        // get the column names from the first row
        let cols = Object.keys(d[0]);
        
        // build a list of columns and their attributes for the display table
        let colList=[];
        cols.forEach(col=>{
          // make basic column definition
          let c = {field:col, title:col, visible: true, sortable: true,align: 'left'};

          // hide id column
          if(col=='id') c.visible = false;

          // if fields is numeric, right align it
          if(!isNaN(d[0][col])) c.align = 'right';


          // hide any column that starts with DispVal_
          if(col.startsWith('DispVal_')) {
            c.visible = false;
          }
          
          // if the column has a corresponding DispVal_ use that as the data field for the column
          if(cols.includes('DispVal_'+col)) c.field = 'DispVal_'+col;

          colList.push(c);
        });

        $('#_cipDetailTable').bootstrapTable('destroy').bootstrapTable({
          columns: colList,
          data: d
        });
      }
      

    
      $('#_cipDetailModal').modal('show');     
    });
}
</script>