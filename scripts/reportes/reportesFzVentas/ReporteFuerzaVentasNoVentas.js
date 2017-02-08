 $(document).ready(function(){

     jQuery('.fechareport').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });
  
    
 });
 
 

