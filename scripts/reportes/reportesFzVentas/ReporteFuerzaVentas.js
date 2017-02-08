$(document).ready(function() {

    jQuery('.fechareport').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });


});


function terminarruta(){
    
    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
     if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    } 


    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasTerminarRuta',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
			

            $("#reportes").html(response);

            $('#tblPedidos').dataTable();

        }
    });
    
    
}



function  pedidos() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
     if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    } 

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasPedidos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblPedidos').dataTable();

        }
    });
}

function facturas() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    } 

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasFacturas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblFactura').dataTable();

        }
    });

}


function devoluciones() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;
        
     }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    } 

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasDevoluciones',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tbldevoluciones').dataTable();

        }
    });


}

function recibos() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;
        
    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    } 

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasRecibos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblRecibos').dataTable();

        }
    });



}


function clientesnuevos() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;
   }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    }

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasClientesNuevos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblclientesnuevos').dataTable();

        }
    });


}


function  noventas() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    }

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasNoVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblNoVentas').dataTable();

        }
    });
}


function  Notascredito() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
      
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    }

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasNotasCredito',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblNotasCredito').dataTable();
        }
    });
}


function  transferenciaconsignacion() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    }

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentastransferenciaConsignacion',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblTransferencia').dataTable();

        }
    });
}



function  consignacionvendedor() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    }

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasConsignacionVeendedor',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblConsigVendedor').dataTable();

        }
    });
}

function  transferenciaautoventa() {

    var ini = $("#fechaini").val();
    var fin = $("#fechafin").val();
    var agencia = $("#agencia").val();
    
    if (ini > fin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }else if(agencia == ''){
        
        $('#_alerta .text-modal-body').html('Por favor seleccione una agencia');
        $('#_alerta').modal('show');
        return;
        
    }

    $.ajax({
        data: {
            'ini': ini,
            'fin': fin,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxFzVentasTransferenciaAutoventa',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#reportes").html(response);

            $('#tblTransferenciaAutoventa').dataTable();

        }
    });
}


function GenerarPedidos() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();
     
    var arr_zonapedido = new Array();
    var z = 0;

    var totalpedido = 0;
    var checkNoPedido = 0;

    $(".chckZonaPedido").each(function() {
        totalpedido++;
        if ($(this).is(":checked")) {
            checkNoPedido++;
        }

    });

    if (checkNoPedido == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaPedido").each(function() {
        if ($(this).is(":checked")) {
            arr_zonapedido[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonapedido,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetallePedido',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandopedido").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });
}

function GenerarPedidos() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();
     
    var arr_zonapedido = new Array();
    var z = 0;

    var totalpedido = 0;
    var checkNoPedido = 0;

    $(".chckZonaPedido").each(function() {
        totalpedido++;
        if ($(this).is(":checked")) {
            checkNoPedido++;
        }

    });

    if (checkNoPedido == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaPedido").each(function() {
        if ($(this).is(":checked")) {
            arr_zonapedido[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonapedido,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetallePedido',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandopedido").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });
}






function GenerarTerminarRuta(){
    
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();
     
    var arr_zonaruta = new Array();
    var z = 0;

    var totalruta = 0;
    var checkNoRuta = 0;

    $(".chckZonaRuta").each(function() {
        totalruta++;
        if ($(this).is(":checked")) {
            checkNoRuta++;
        }

    });

    if (checkNoRuta == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaRuta").each(function() {
        if ($(this).is(":checked")) {
            arr_zonaruta[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonaruta,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleTerminarRuta',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandoterminarruta").css("display", "inline");

        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });
    
    
}




function GenerarFacturas() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();



    var arr_zonafactura = new Array();
    var z = 0;

    var totalfactura = 0;
    var checkNoFactura = 0;

    $(".chckZonaFactura").each(function() {
        totalfactura++;
        if ($(this).is(":checked")) {
            checkNoFactura++;
        }

    });

    if (checkNoFactura == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaFactura").each(function() {
        if ($(this).is(":checked")) {
            arr_zonafactura[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonafactura,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleFacturas',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandofacturas").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}



function GenerarDevoluciones() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();



    var arr_zonadevoluciones = new Array();
    var z = 0;

    var totaldevoluciones = 0;
    var checkNoDevoluciones = 0;

    $(".chckZonaDevoluciones").each(function() {
        totaldevoluciones++;
        if ($(this).is(":checked")) {
            checkNoDevoluciones++;
        }

    });

    if (checkNoDevoluciones == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaDevoluciones").each(function() {
        if ($(this).is(":checked")) {
            arr_zonadevoluciones[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonadevoluciones,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleDevoluciones',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandodevoluciones").css("display", "inline"); 
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });


}


function GenerarRecibos() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();



    var arr_zonarecibos = new Array();
    var z = 0;

    var totalrecibos = 0;
    var checkNoRecibos = 0;

    $(".chckZonaRecibos").each(function() {
        totalrecibos++;
        if ($(this).is(":checked")) {
            checkNoRecibos++;
        }

    });

    if (checkNoRecibos == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaRecibos").each(function() {
        if ($(this).is(":checked")) {
            arr_zonarecibos[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonarecibos,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleRecibos',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandorecibos").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}


function GenerarNoVentas() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();



    var arr_zona = new Array();
    var z = 0;

    var total = 0;
    var checkNo = 0;

    $(".chckZona").each(function() {
        total++;
        if ($(this).is(":checked")) {
            checkNo++;
        }

    });

    if (checkNo == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZona").each(function() {
        if ($(this).is(":checked")) {
            arr_zona[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zona,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleNoVentas',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandonoventas").css("display", "inline"); 
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}



function GenerarNotasCredito() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();

    var arr_zonanota = new Array();
    var z = 0;

    var total = 0;
    var checkNoNota = 0;

    $(".chckZonaNota").each(function() {
        total++;
        if ($(this).is(":checked")) {
            checkNoNota++;
        }

    });

    if (checkNoNota == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaNota").each(function() {
        if ($(this).is(":checked")) {
            arr_zonanota[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonanota,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleNotasCredito',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandonotas").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}


function GenerarConsigVeendedor() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
     var agencia = $("#agencia").val();

    var arr_zonaVenddor = new Array();
    var z = 0;

    var total = 0;
    var checkNoVendedor = 0;

    $(".chckZonaVeendedor").each(function() {
        total++;
        if ($(this).is(":checked")) {
            checkNoVendedor++;
        }

    });

    if (checkNoVendedor == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaVeendedor").each(function() {
        if ($(this).is(":checked")) {
            arr_zonaVenddor[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonaVenddor,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleConsigVeendedor',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandoconve").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}

function GenerarTransConsignacion() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();

    var arr_zonaTransConsignacion = new Array();
    var z = 0;

    var total = 0;
    var checkNoTransConsignacion = 0;

    $(".chckZonaTransConsignacion").each(function() {
        total++;
        if ($(this).is(":checked")) {
            checkNoTransConsignacion++;
        }

    });

    if (checkNoTransConsignacion == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaTransConsignacion").each(function() {
        if ($(this).is(":checked")) {
            arr_zonaTransConsignacion[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonaTransConsignacion,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleTransConsignacion',
        type: 'post',
        beforeSend: function() {
         $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
         $("#cargandoconsignvendedor").css("display", "inline");    

        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}

function GenerarTransAutoventa() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();

    var arr_zonaTransAutoventa = new Array();
    var z = 0;

    var total = 0;
    var checkNoTransAutoventa = 0;

    $(".chckZonaTransAutoventa").each(function() {
        total++;
        if ($(this).is(":checked")) {
            checkNoTransAutoventa++;
        }

    });

    if (checkNoTransAutoventa == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaTransAutoventa").each(function() {
        if ($(this).is(":checked")) {
            arr_zonaTransAutoventa[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonaTransAutoventa,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleTransAutoventa',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandotransautoventa").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}

function GenerarClientesNuevos() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#agencia").val();



    var arr_zonaclientesnuevos = new Array();
    var z = 0;

    var totalclientesnuevos = 0;
    var checkNoClientesNuevos = 0;

    $(".chckZonaClientesNuevos").each(function() {
        totalclientesnuevos++;
        if ($(this).is(":checked")) {
            checkNoClientesNuevos++;
        }

    });

    if (checkNoClientesNuevos == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione una zona');
        $('#_alerta').modal('show');
        return false;
    }



    $(".chckZonaClientesNuevos").each(function() {
        if ($(this).is(":checked")) {
            arr_zonaclientesnuevos[z] = $(this).val();
        }
        z++;
    });
    z = 0;



    $.ajax({
        data: {
            'zona': arr_zonaclientesnuevos,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxGenerarDetalleClientesNuevos',
        type: 'post',
        beforeSend: function() {
           $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
           $("#cargandocliente").css("display", "inline");
        },
        success: function(response) {

            $("#reportes").html(response);

        }
    });

}

function marcarCheck(source)
{
    checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
    for (i = 0; i < checkboxes.length; i++) //recoremos todos los controles
    {
        if (checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
        {
            checkboxes[i].checked = source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
        }
    }
}



$('.salirReporestFuerzaVentas').click(function() {

    $('#_alertSalirReportesFuerzaVentas .text-modal-body').html('Esta seguro que desea salir del modulo de reportes fuerza ventas ?');
    $('#_alertSalirReportesFuerzaVentas').modal('show');

});


function Fotos(id,agencia) {

 
    $.ajax({
        data: {
            'id': id,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleFotos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
         
            if (response == "") {

                $('#_FvNotasCredito #msgnotascredito').html('No hay fotos para la nota credito seleccionada ');
                $('#_FvNotasCredito').modal('show');
                return;

            } else {

                $('#_FvDetalleFotos').modal('show');
                $("#tabladetallefoto").html(response);
            }




        }
    });



}



function kits(id,agencia) {

   
    $.ajax({
        data: {
            'id': id,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleKits',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetalleKitsPedidos').modal('show');
            $("#tabladetalle").html(response);


        }
    });

}


function kitsZona(id) {



    $.ajax({
        data: {
            'id': id


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleKits',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetalleKitsPedidos').modal('show');
            $("#tabladetalle").html(response);


        }
    });

}





function kitsFacturas(id,agencia) {



    $.ajax({
        data: {
            'id': id,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleKitsFacturas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetalleKitsFacturas').modal('show');
            $("#tabladetalle").html(response);


        }
    });

}


function kitsFacturasZona(id) {



    $.ajax({
        data: {
            'id': id


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleKitsFacturasZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetalleKitsFacturas').modal('show');
            $("#tabladetalle").html(response);


        }
    });

}



function Efectivo(id,agencia){
     

    $.ajax({
        data: {
            'id': id,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleEfectivo',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesReciboEfectivo').modal('show');
            $("#tabladetallerecibosEfectivo").html(response);


        }
    });
}

function EfectivoConsig(id,agencia, tipoConsignacion) {

    //console.log(tipoConsignacion);
    $.ajax({
        data: {
            'id': id,
            'agencia':agencia,
            'tipoConsignacion': tipoConsignacion


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleEfectivoConsignacion',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesRecibosEfectivConsig').modal('show');
            $("#tabladetallerecibosEfectivoConsig").html(response);


        }
    });

}

function Cheque(id,agencia) {

    $.ajax({
        data: {
            'id': id,
            'agencia':agencia


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleCheque',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesRecibosCheque').modal('show');
            $("#tabladetallereciboscheque").html(response);


        }
    });
}

function ChequeConsig(id,agencia) {

    $.ajax({
        data: {
            'id': id,
            'agencia':agencia
            


        },
        url: 'index.php?r=reportes/Reportes/AjaxDetalleChequeConsignacion',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesRecibosChequeConsignacion').modal('show');
            $("#tabladetallereciboschequeconsignacion").html(response);


        }
    });

}
 