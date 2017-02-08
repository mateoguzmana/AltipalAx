/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery('#tblEncuestas').DataTable({
    "sPaginationType": "full_numbers",
   
});



$('.msgtransconsig').click(function() {

    $('#_alerta .text-modal-body').html('Su nivel de acceso no le permite ingresar a este módulo, por favor comuniquese con el área de administración de ventas');
    $('#_alerta').modal('show');
    return;

});

$('.alerta').click(function() {
    $('#_alerta .text-modal-body').html('Este cliente ya posee un registro de no venta');
    $('#_alerta').modal('show');
    return;
});

$('.msge').click(function() {

    $('#_alerta .text-modal-body').html('Su nivel de acceso no le permite ingresar a este módulo, por favor comuniquese con el área de administración de ventas');
    $('#_alerta').modal('show');
    return;

});

$('.msgnotienefacturas').click(function (){
    
  $('#_alerta .text-modal-body').html('No cuenta con cartera disponible');
  $('#_alerta').modal('show');
  return;  
    
});

$("#btnCargarPedidoPreventa").click(function() {
    var cantidadSitios = $(this).attr('data-sitios');
      
    var codigositio = $(this).attr('data-codigo-sitio');
    var desPreventa = $(this).attr('data-Preventa');
    var desAutoventa = $(this).attr('data-Autoventa');
    var desConsignacion = $(this).attr('data-consignacion');
    var desVentaDirecta = $(this).attr('data-venta-directa');
    var ubicacion = $(this).attr('data-ubicacion');
    var desAlmacen = $(this).attr('data-almacen');
    var nombreSitio = $(this).attr('data-nombre-sitio');

    //alert(cantidadSitios);
    
    if (cantidadSitios == 1) {

        $.ajax({
            data: {
                "codigositio": codigositio,
                "desPreventa": desPreventa,
                "desAutoventa": desAutoventa,
                "desConsignacion": desConsignacion,
                "desVentaDirecta": desVentaDirecta,
                "desAlmacen": desAlmacen,
                "ubicacion": ubicacion,
                "nombreSitio": nombreSitio,
                

            },
            url: 'index.php?r=Pedido/AjaxSetSitioTipoVenta',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                $('#select-sitio-venta').html(response);
                $("#mdl-datos-cliente").modal("show");

            }
        });

    } else {

        $('#select-sitio').val('');
        $("#sitiosAlmacen").modal("show");

    }
});

$("#btnCargarPedidoAutoventa").click(function() {

    var cantidadSitios = $(this).attr('data-sitios');
    var codigositio = $(this).attr('data-codigo-sitio');
    var desPreventa = $(this).attr('data-Preventa');
    var desAutoventa = $(this).attr('data-Autoventa');
    var desConsignacion = $(this).attr('data-consignacion');
    var desVentaDirecta = $(this).attr('data-venta-directa');
    var ubicacion = $(this).attr('data-ubicacion');
    var desAlmacen = $(this).attr('data-almacen');
    var nombreSitio = $(this).attr('data-nombre-sitio');


    if (cantidadSitios == 1) {

        $.ajax({
            data: {
                "codigositio": codigositio,
                "desPreventa": desPreventa,
                "desAutoventa": desAutoventa,
                "desConsignacion": desConsignacion,
                "desVentaDirecta": desVentaDirecta,
                "desAlmacen": desAlmacen,
                "ubicacion": ubicacion,
                "nombreSitio": nombreSitio

            },
            url: 'index.php?r=Pedido/AjaxSetSitioTipoVenta',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                $('#select-sitio-venta').html(response);
                $("#mdl-datos-cliente-autoventa").modal("show");

            }
        });

    } else {

        $('#select-sitio').val('');
        $("#sitiosAlmacenAutoventa").modal("show");

    }


});

$("#btnDevoluciones").click(function() {
    var zona = $('#txtZonaVenta').val();
    var cliente = $('#txtCliente').val();
    window.location.href = "index.php?r=Devoluciones/index&cliente=" + cliente + "&zonaVentas=" + zona;
});

$('#noRecibos').click(function() {
    $('#_alerta .text-modal-body').html('La zona de Ventas ' + $(this).attr('data-zona') + ' no cuenta con los permisos para realizar recibos de caja. ');
    $('#_alerta').modal('show');
});

$('#btnDevolucionesInactivas').click(function() {
    $('#_alerta .text-modal-body').html('La zona de Ventas ' + $(this).attr('data-zona') + ' no cuenta con los permisos para realizar devoluciones.');
    $('#_alerta').modal('show');
});

$('#retornarMenu').click(function() {
    var zona = $(this).attr('data-zona');
    var cliente = $(this).attr('data-cliente');

    $('#_alertConfirmationMenu .text-modal-body').html('Esta seguro que desea salir del menú del cliente <b>' + $('#txtNombreCliente').text() + '</b>');
    $('#_alertConfirmationMenu').modal('show');
});

$(".btn-consignacion").click(function() {

    var cantidadSitios = $(this).attr('data-sitios');
    var codigositio = $(this).attr('data-codigo-sitio');
    var desPreventa = $(this).attr('data-Preventa');
    var desAutoventa = $(this).attr('data-Autoventa');
    var desConsignacion = $(this).attr('data-consignacion');
    var desVentaDirecta = $(this).attr('data-venta-directa');
    var ubicacion = $(this).attr('data-ubicacion');
    var desAlmacen = $(this).attr('data-almacen');
    var nombreSitio = $(this).attr('data-nombre-sitio');
    var cliente = $(this).attr("data-clie");
    var zona = $(this).attr("data-zona");  

    if (cantidadSitios == 1) {

        $.ajax({
            data: {
                "codigositio": codigositio,
                "desPreventa": desPreventa,
                "desAutoventa": desAutoventa,
                "desConsignacion": desConsignacion,
                "desVentaDirecta": desVentaDirecta,
                "desAlmacen": desAlmacen,
                "ubicacion": ubicacion,
                "nombreSitio": nombreSitio,
            },
            url: 'index.php?r=Clientes/AjaxSetSitioTipoConsignacion',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                 
           window.location.href = "index.php?r=TransferenciaConsignacion/CrearTransferencia&cliente=" + cliente + "&zonaVentas=" + zona;      
           
            }
        });

    } else {

        $('#select-sitioConsignacion').val('');
        $("#sitiosAlmacenConsignacion").modal("show");

    }

});

$("#sitiosAutoventa").submit(function(event) {


    var codigositio = $('#select-sitio-autoventa').val();
    if(codigositio==""){ 
        $('#_alerta .text-modal-body').html('No se ha seleccionado un sitio.');
        $('#_alerta').modal('show');
        return false;
    }
    var tipoVenta = $('#select-sitio-venta-autoventa').val();
    var nombreSitio = $('#select-sitio-autoventa option:selected').text();
    var nombreTipoVenta = $('#select-sitio-venta-autoventa').val();


    var desPreventa = $("#select-sitio-autoventa option:selected").attr('data-Preventa');
    var desAutoventa = $("#select-sitio-autoventa option:selected").attr('data-Autoventa');
    var desConsignacion = $("#select-sitio-autoventa option:selected").attr('data-Consignacion');
    var desVentaDirecta = $("#select-sitio-autoventa option:selected").attr('data-VentaDirecta');
    var desAlmacen = $("#select-sitio-autoventa option:selected").attr('data-almacen');
    var ubicacion = $("#select-sitio-autoventa option:selected").attr('data-ubicacion');


    $.ajax({
        data: {
            "codigositio": codigositio,
            "tipoVenta": tipoVenta,
            "nombreSitio": nombreSitio,
            "nombreTipoVenta": nombreTipoVenta,
            "desPreventa": desPreventa,
            "desAutoventa": desAutoventa,
            "desConsignacion": desConsignacion,
            "desVentaDirecta": desVentaDirecta,
            "desAlmacen": desAlmacen,
            "ubicacion": ubicacion

        },
        url: 'index.php?r=Pedido/AjaxSetSitioTipoVenta',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $('#select-sitio-venta').html(response);

            $("#sitiosAlmacenAutoventa").modal("hide");
            $("#mdl-datos-cliente-autoventa").modal("show");

        }
    });




    event.preventDefault();
});

$("#sitiosPreventa").submit(function(event) {


    var codigositio = $('#select-sitio').val();
    
    if(codigositio==""){  
        
        $('#_alerta .text-modal-body').html('No se ha seleccionado un sitio.');
        $('#_alerta').modal('show');
        return false;
    }
    
    var tipoVenta = $('#select-sitio-venta').val();
    var nombreSitio = $('#select-sitio option:selected').text();
    var nombreTipoVenta = $('#select-sitio-venta').val();


    var desPreventa = $("#select-sitio option:selected").attr('data-Preventa');
    var desAutoventa = $("#select-sitio option:selected").attr('data-Autoventa');
    var desConsignacion = $("#select-sitio option:selected").attr('data-Consignacion');
    var desVentaDirecta = $("#select-sitio option:selected").attr('data-VentaDirecta');
    var desAlmacen = $("#select-sitio option:selected").attr('data-almacen');
    var ubicacion = $("#select-sitio option:selected").attr('data-ubicacion');


    $.ajax({
        data: {
            "codigositio": codigositio,
            "tipoVenta": tipoVenta,
            "nombreSitio": nombreSitio,
            "nombreTipoVenta": nombreTipoVenta,
            "desPreventa": desPreventa,
            "desAutoventa": desAutoventa,
            "desConsignacion": desConsignacion,
            "desVentaDirecta": desVentaDirecta,
            "desAlmacen": desAlmacen,
            "ubicacion": ubicacion

        },
        url: 'index.php?r=Pedido/AjaxSetSitioTipoVenta',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $('#select-sitio-venta').html(response);

            $("#sitiosAlmacen").modal("hide");
            $("#mdl-datos-cliente").modal("show");

        }
    });

    event.preventDefault();
});

$("#noPreventaActivo").click(function(){
     $('#_alerta .text-modal-body').html('La zona de ventas no tiene sitios asignados para realizar un pedido de preventa.');
     $('#_alerta').modal('show');
});

$("#noAutoventaActivo").click(function(){
     $('#_alerta .text-modal-body').html('La zona de ventas no tiene sitios asignados para realizar un pedido de Factura.');
     $('#_alerta').modal('show');
});     


$('#btn-asesores-comerciales').click(function(){
    $('#asesoresComerciales').modal('show');
}); 


$('#btn-asesores-comerciales-autoventa').click(function(){
    $('#asesoresComerciales').modal('show');
}); 
       

$('.factutas-pendientes').click(function(){
     $('#alertaFacturasPendientes #mensaje-error').html('El cliente presenta cartera vencida, debe recaudar antes de continuar. Recuerde que para la forma de pago cheque posfechado no liberará cupo  hasta hacer efectivo el pago');
     $('#alertaFacturasPendientes').modal('show');
});


$('#btnEnviarCopiaRecibo').click(function(){
    
    $('#_alertaSucessRecibos').modal('hide');
    $('#_alertaInputCorreo').modal('show');
    
    /*
   */
    
});


$('#btnConfirmarEnviarEmail').click(function(){    
    var zonaVentas=$(this).attr('data-zona-ventas');
    var cuentaCliente=$(this).attr('data-cuenta-cliente');
    var provisional=$(this).attr('data-provisional');
    var emailCliente=$('#inputAlertaInput').val();
    var agencia=$(this).attr('data-agencia');
    
    if(IsEmail(emailCliente)==true){       
       $.ajax({
            data: {           
                'zonaVentas':zonaVentas,
                'cuentaCliente':cuentaCliente,
                'provisional':provisional,
                'emailCliente':emailCliente,
                'agencia':agencia
            },
            url: 'index.php?r=service/WebMobile/EnviarCopiaRecibo',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {           
                if(response=="OK"){                   
                   $('#_alertaInputCorreo').modal('hide');
                   $('#_alertaEnvioEmail #txtEmailCliente').html('<b>'+emailCliente+'</b>');
                   $('#_alertaEnvioEmail').modal('show');                   
                }
            }
        });        
    }else{
        $("#_alerta").css("z-index", "15000");
        $('#_alerta .text-modal-body').html('La dirección de correo electrónico no es valida');
        $('#_alerta').modal('show');
        return false;
    }    
});

$('#btnCerrarSucessCorreo').click( function(){
    location.reload();
});

$('#btnCerrarInputCorreo').click( function(){
    location.reload();
});


$('#_alertaEnvioEmail').on('hidden.bs.modal', function () {
   location.reload();
});

$('#btnmsgImprimirRecibo').click(function (){
    
    
     $('#_alertaSucess').modal('show');
    
});



function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}


$('#btnImprimirPdf').click(function(){
    
    var zonaVentas=$(this).attr('data-zona-ventas');
    var cuentaCliente=$(this).attr('data-cuenta-cliente');
    var provisional=$(this).attr('data-provisional');    
    window.open('index.php?r=Recibos/ReciboCaja&zonaVentas='+zonaVentas+'&cuentaCliente='+cuentaCliente+'&provisional='+provisional,'_blank');
    
});

$('.msgnofacturas').click(function (){
    
    $('#_alerta .text-modal-body').html('El cliente no cuenta con facturas con saldo para realizar una nota crédito');
    $('#_alerta').modal('show');
    return;
   
});

$('.cargando').click(function(){
  
   $("#cargando").css("display", "inline");
    
});

$('.cargandoAutoventa').click(function(){
  
  $("#cargandoAutoventa").css("display", "inline");
    
});

$('#btnModalClose').click(function(){
    var CuentaCliente = $('#txtCuentaCliente').val();
    var idUser = $('#txtIDUser').val();
    var zona = $('#txtZonaventas').val();
       $.ajax({
           data:{"user":idUser},
            url: 'index.php?r=Clientes/AjaxValidatePay',
            type: 'post',
            success: function(response) {           
                    //debugger;
                    if (response == "true") {
                     $("#cargando").css("display", "inline");
                    window.location.href= "index.php?r=Preventa/CrearPedido&cliente=" + CuentaCliente + "&zonaVentas=" +zona;
                }
                else
                {
                 $('#_alerta .text-modal-body').html('El cliente no puede realizar un pedido dado que hay facturas que fueron pagadas con un cheque posfechado.');
                 $('#_alerta').modal('show');
                 return;
                }
            },          
            error: function(response)
            {
                 $('#_alerta .text-modal-body').html('Ha ocurrido un error a la hora de validar las facturas vencidas');
                 $('#_alerta').modal('show');
                 return;
            }
       }); 
});

 