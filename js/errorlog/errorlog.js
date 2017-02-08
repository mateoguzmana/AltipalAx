$(document).ready(function() {
$('#tbllogerror').dataTable();
    jQuery('.fechareport').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });


});

$('.btnbuscar').click(function(){
ini = $("#fechaini").val();
fin = $("#fechafin").val();

 $.ajax({
        data: {
            'ini': ini,
            'fin': fin


        },
        url: 'index.php?r=erroresactualizacion/AjaxVerlog',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#tablaerrores").html(response);

            $('#tbllogerror').dataTable();

        }
    });
	
});
	
	

	
