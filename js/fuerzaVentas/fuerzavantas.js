function alerta() {
    $('#_alerta .text-modal-body').html('Su nivel de acceso no le permite ingresar a este módulo, por favor comuniquese con el área de administración de ventas');
    $('#_alerta').modal('show');
}

function transferenciaspedientes() {
    $('#_alerta .text-modal-body').html('Usted tiene transferencias pendientes por recibir');
    $('#_alerta').modal('show');
}

$(".informacionactivity").click(function () {
    $('#_alertainformacionActivity').modal('show');

});


function terminarruta(zona) {
    $.ajax({
        data: {
            'zona': zona
        },
        url: 'index.php?r=FuerzaVentas/AjaxTerminarRuta',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $('#msg').html(response);
            $('#_alertaValidacionRuta').modal();
        }
    });
}


function guardarterminarruta(zona) {
    var asesor = $('#asesor').val();
    $.ajax({
        data: {
            'zona': zona,
            'asesor': asesor
        },
        url: 'index.php?r=FuerzaVentas/AjaxGuardarTerminarRuta',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $('#terminarutamodal').modal('hide');
            $('#_alertSucessTerminacionRuta #sucess').html('Ruta terminada satisfactoriamente !');
            $('#_alertSucessTerminacionRuta').modal('show');
        }
    });
}

function recargar() {
    window.location.reload();
}


$('#sltZonaVentas').change(function () {
    var zonaSeleccionada = $(this).val();
    var asesorSeleccionado = $("option:selected", this).attr("data-asesor");
    var agencia = $("option:selected", this).attr("data-agencia");
    $('#hdnCodigoAsesor').val(asesorSeleccionado);
    $('#hdnAgencia').val(agencia);
    $('#sltCodigoAsesor').val(zonaSeleccionada);
    $('#sltNombreAsesor').val(zonaSeleccionada);
    $('#sltCodigoAsesor').val(zonaSeleccionada).trigger('chosen:updated');
    $('#sltNombreAsesor').val(zonaSeleccionada).trigger('chosen:updated');
});

$('#sltCodigoAsesor').change(function () {
    var zonaSeleccionada = $(this).val();
    var asesorSeleccionado = $("option:selected", this).attr("data-asesor");
    var agencia = $("option:selected", this).attr("data-agencia");
    $('#hdnAgencia').val(agencia);
    $('#hdnCodigoAsesor').val(asesorSeleccionado);
    $('#sltZonaVentas').val(zonaSeleccionada);
    $('#sltNombreAsesor').val(zonaSeleccionada);
    $('#sltZonaVentas').val(zonaSeleccionada).trigger('chosen:updated');
    $('#sltNombreAsesor').val(zonaSeleccionada).trigger('chosen:updated');
});

$('#sltNombreAsesor').change(function () {
    var zonaSeleccionada = $(this).val();
    var asesorSeleccionado = $("option:selected", this).attr("data-asesor");
    var agencia = $("option:selected", this).attr("data-agencia");
    $('#hdnAgencia').val(agencia);
    $('#hdnCodigoAsesor').val(asesorSeleccionado);
    $('#sltCodigoAsesor').val(zonaSeleccionada);
    $('#sltZonaVentas').val(zonaSeleccionada);
    $('#sltCodigoAsesor').val(zonaSeleccionada).trigger('chosen:updated');
    $('#sltZonaVentas').val(zonaSeleccionada).trigger('chosen:updated');
});

jQuery("#frmZonaVentas").validate({
    errorLabelContainer: jQuery("#basicForm2 div.error")
});

jQuery("#sltZonaVentas").chosen({'width': '100%', 'white-space': 'nowrap'});
jQuery("#sltCodigoAsesor").chosen({'width': '100%', 'white-space': 'nowrap'});
jQuery("#sltNombreAsesor").chosen({'width': '100%', 'white-space': 'nowrap'});