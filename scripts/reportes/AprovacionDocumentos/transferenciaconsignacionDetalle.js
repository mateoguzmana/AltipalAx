$('#retornarMenu').click(function() {    
    window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';  

});



$('.btnDetalleTransferenciaConsignacion').click(function() {

    var idTransferenciaConsignacion = $(this).attr('data-id-transferencia');
    var agencia = $(this).attr('data-agencia');

    $.ajax({
        data: {
            'idTransferenciaConsignacion': idTransferenciaConsignacion,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetalladoTransConsignacion',
        type: 'post',
        beforeSend: function() {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $("#imgCargando1").html('');
            $('#mdlDetalleTransferenciaConsignacion .modal-body').html(response);
            $('#mdlDetalleTransferenciaConsignacion').modal('show');


        }
    });
});

$('#btnGuardarTransferenciaConsignacion').click(function() {
    
   var id = $("#transferencia").val();
   var agencia = $("#Agencia").val();
   var  grupoventas = $("#Gupo").val();
   var zona = $("#zona").val();
   var asesor = $("#asesor").val();
   var cliente = $("#cliente").val();
      
    var totalseleccionados = 0;
    var checkNoSeleccionado = 0;

    $(".chckAprovacion").each(function() {
        totalseleccionados++;
        if ($(this).is(":checked")) {
            checkNoSeleccionado++;
        }

    });

    if (checkNoSeleccionado == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione al menos un opción');
        $('#_alerta').modal('show');
        return false;
    }

    if (checkNoSeleccionado > 1) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una sola opción Aprobar o Rechazar');
        $('#_alerta').modal('show');
        return false;

    }
    
    var arr_chequiados = new Array();
    var z = 0;
    
    $(".chckAprovacion").each(function() {
        if ($(this).is(":checked")) {
            arr_chequiados[z] = $(this).val();
        }
        z++;
    });
    z = 0;
    
     $.ajax({
        data: {
            'estado': arr_chequiados,
            'id':id,
            'agencia':agencia,
            'zona':zona,
            'asesor':asesor,
            'cliente':cliente

        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxGuardaAprovacionTransferenciaConsignacion',
        type: 'post',
        beforeSend: function() {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
             
         location.href = "index.php?r=reportes/AprovacionDocumentos/AjaxDetalleTransferenciaConsignacion&agencia="+agencia+"&grupoVentas="+grupoventas+"";
              
        }
    }); 
    

});

$('#retornarMenu').click(function() {    
    window.location.href='index.php?r=reportes/AprovacionDocumentos/AprobarTransConsignacion';  

});



