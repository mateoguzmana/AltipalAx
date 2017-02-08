$("#dia").change(function(){
    
    var dia = $("#dia").val();
    
       $.ajax({
        data: {
            'dia': dia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarVentasCanaldia',
        type: 'post',
        beforeSend: function() {
             $("#_alertaCargando .text-modal-body").html("Cargando....");
             $("#_alertaCargando").modal('show');
        },
        success: function(response) {
            
            $('#PedidosCanalDia').html(response);
            $("#_alertaCargando").modal('hide');
           
        }
    });
    
});
