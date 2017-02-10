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

$('.salirReporestResumenDia').click(function() {

    $('#_alertSalirReportesResumenDia .text-modal-body').html('Esta seguro que desea salir del modulo de resumen dia ?');
    $('#_alertSalirReportesResumenDia').modal('show');

});


function GenerarConsigVeendedorZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarConsigVeendedorZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function GenerarNotascreditoZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarNotasCreditoZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");
        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function FotosZona(id) {


    $.ajax({
        data: {
            'id': id


        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleFotosZona',
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


function GenerarRecibosZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarRecibosZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}



function Efectivo(id, agencia) {


    $.ajax({
        data: {
            'id': id,
            'agencia': agencia


        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleEfectivoZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesReciboEfectivo').modal('show');
            $("#tabladetallerecibosEfectivo").html(response);


        }
    });

}

function EfectivoConsig(id, agencia, tipoConsignacion) {

    $.ajax({
        data: {
            'id': id,
            'agencia': agencia,
            'tipoConsignacion': tipoConsignacion

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleEfectivoConsignacionZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesRecibosEfectivConsig').modal('show');
            $("#tabladetallerecibosEfectivoConsig").html(response);


        }
    });

}

function Cheque(id, agencia) {

    $.ajax({
        data: {
            'id': id,
            'agencia': agencia


        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleChequeZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesRecibosCheque').modal('show');
            $("#tabladetallereciboscheque").html(response);


        }
    });
}

function ChequeConsig(id, agencia) {

    $.ajax({
        data: {
            'id': id,
            'agencia': agencia


        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleChequeConsignacionZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetallesRecibosChequeConsignacion').modal('show');
            $("#tabladetallereciboschequeconsignacion").html(response);


        }
    });

}



function GenerarDevolucionesZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }


    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetalleDevolucionesZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function GenerarPedidosZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();


    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetallePedidoZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");
        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function kits(id) {



    $.ajax({
        data: {
            'id': id


        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleKitsZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetalleKitsPedidos').modal('show');
            $("#tabladetalle").html(response);


        }
    });

}



function GenerarFacturasZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetalleFacturasZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function kitsFacturas(id) {



    $.ajax({
        data: {
            'id': id


        },
        url: 'index.php?r=reportes/ResumenDia/AjaxDetalleKitsFacturasZona',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#_FvDetalleKitsFacturas').modal('show');
            $("#tabladetalle").html(response);


        }
    });

}




function GenerarTransferenciaconsignacionZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetalleTransConsignacionZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}



function GenerarNoventasZona() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetalleNoVentasZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function GenerarClientesnuevos() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();


    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetalleClientesNuevosZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}


function GenerarTransferenciaAutoventa() {

    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    if (fechaini > fechafin) {

        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;

    }

    var ZonaVentas = $("#ZonaVentas").val();


    $.ajax({
        data: {
            'zona': ZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin

        },
        url: 'index.php?r=reportes/ResumenDia/AjaxGenerarDetalleTransAutoventaZona',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar").html('<img alt="" src="images/loaders/loader9.gif">');
            $("#cargando").css("display", "inline");

        },
        success: function(response) {

            $("#reporteszona").html(response);
            $("#cargando").css("display", "none");

        }
    });

}



function formaspagos() {

    $('#_formaPago').modal('show');
    
    var codzona = $("#ZonaVentas").val();
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    $.ajax({
        data: {
            'codzona': codzona,
            'fechaini': fechaini,
            'fechafin': fechafin
        },
        url: 'index.php?r=reportes/ResumenDia/AjaxFormasPagos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#tablaformaspago').html(response);

        }
    });

}
   