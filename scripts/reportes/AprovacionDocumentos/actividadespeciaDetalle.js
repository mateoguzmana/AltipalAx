
$('.btnDetallePedidoActividadEspecial').click(function() {

    var idPedido = $(this).attr('data-id-pedido');
    var agencia = $(this).attr('data-agencia');
    
     

    $.ajax({
        data: {
            'idPedido': idPedido,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetalladoPedidoActividadEspecial',
        type: 'post',
        beforeSend: function() {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $("#imgCargando1").html('');
            $('#mdlDetallePedidoActividadEsepcial .modal-body').html(response);
            $('#mdlDetallePedidoActividadEsepcial').modal('show');


        }
    });
});


$('#btnGuardarPedidosActividaEspecial').click(function() {

    var id = $("#pedido").val();
    var agencia = $("#Agencia").val();
    var grupoventas = $("#Gupo").val();
    var diasplazo = $("#diasplazo").val();
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

        $('#_alerta .text-modal-body').html('Por favor seleccione al menos una opción');
        $('#_alerta').modal('show');
        return false;
    }

    if (checkNoSeleccionado > 1) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una sola opción, Aprobar o Rechazar');
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


    if (arr_chequiados[z] == 1) {
        if (diasplazo == 0) {

            $('#_alerta .text-modal-body').html('por favor seleccione alguno de los días plazo');
            $('#_alerta').modal('show');
            return false;
        }
    } 
    

    $.ajax({
        data: {
            'estado': arr_chequiados,
            'id': id,
            'agencia': agencia,
            'diasplazo': diasplazo,
            'zona': zona,
            'asesor': asesor,
            'cliente': cliente

        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxGuardaAprovacionPedidosActividadEspecial',
        type: 'post',
        beforeSend: function() {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function() {


            /*$('#_alertaSucess  .modal-body').html('Pedido con actividad especial fue aprovado correctamente');
             $('_alertaSucess').modal('show');*/
            location.href = "index.php?r=reportes/AprovacionDocumentos/AjaxAprovarActividadEspecial&agencia=" + agencia + "&grupoVentas=" + grupoventas + "";

        }
    });

});


$('.reload').click(function() {

    location.reload();
});


$('#retornarMenu').click(function() {
    window.location.href = 'index.php?r=reportes/AprovacionDocumentos/AprobarActividadEspecial';

});