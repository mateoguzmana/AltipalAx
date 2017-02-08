$(document).ready(function () {
    jQuery('.fechapaginaweb').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function (i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });
    $("#SelectAgencia").chosen();
    $("#SelectZonaVentas").chosen();

});


$(".onchaZonaVentas").change(function () {
    var agencia = $("#SelectAgencia").val();
    $.ajax({
        data: {
            'agencia': agencia
        },
        url: 'index.php?r=site/AjaxZonaVentasAgencia',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $("#zonaventas").html('');
            $("#zonaventas").html(response);
            $("#selectchosezonaventas2").chosen();
        }
    });
});


$("#GuardarPermisos").click(function () {
    var agencia = $("#SelectAgencia").val();
    var CodZonaVentas = $("#selectchosezonaventas2").val();
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var Observacion = $("#observacion").val();
    if (agencia == "" && CodZonaVentas == "" && fechaini == "" && fechafin == "" && Observacion == "") {

        $("#ErroAgencia").html('Seleccione una agencia');
        $("#ErroAgencia").css("color", "red");
        $("#ErroAgencia").show();

        $("#ErrozonaVentas").html('Seleccione una zona ventas');
        $("#ErrozonaVentas").css("color", "red");
        $("#ErrozonaVentas").show();

        $("#ErroFechaini").html('Seleccione la fecha inicial');
        $("#ErroFechaini").css("color", "red");
        $("#ErroFechaini").show();

        $("#ErroFechaFin").html('Seleccione la fecha final');
        $("#ErroFechaFin").css("color", "red");
        $("#ErroFechaFin").show();

        $("#ErroObser").html('ingrese  una observación');
        $("#ErroObser").css("color", "red");
        $("#ErroObser").show();
        return false;
    }
    if (fechaini > fechafin) {
        $('#_alerta .text-modal-body').html('La fecha inicial no puede ser mayor que la fecha final');
        $('#_alerta').modal('show');
        return;
    }
    if (agencia == "") {
        $("#ErroAgencia").html('Seleccione una agencia');
        $("#ErroAgencia").css("color", "red");
        $("#ErroAgencia").show();
        return false;
    }
    if (CodZonaVentas == "") {
        $("#ErrozonaVentas").html('Seleccione una zona ventas');
        $("#ErrozonaVentas").css("color", "red");
        $("#ErrozonaVentas").show();
        $("#ErroAgencia").hide();
        return false;
    }
    if (fechaini == "") {
        $("#ErroFechaini").html('Seleccione la fecha inicial');
        $("#ErroFechaini").css("color", "red");
        $("#ErroFechaini").show();
        $("#ErrozonaVentas").hide();
        return false;
    }
    if (fechafin == "") {
        $("#ErroFechaFin").html('Seleccione la fecha final');
        $("#ErroFechaFin").css("color", "red");
        $("#ErroFechaFin").show();
        $("#ErroFechaini").hide();
        return false;
    }
    if (Observacion == "") {
        $("#ErroObser").html('ingrese  una observación');
        $("#ErroObser").css("color", "red");
        $("#ErroObser").show();
        $("#ErroFechaFin").hide();
        return false;
    }
    $.ajax({
        data: {
            'agencia': agencia,
            'CodZonaVentas': CodZonaVentas,
            'fechaini': fechaini,
            'fechafin': fechafin,
            'Observacion': Observacion
        },
        url: 'index.php?r=site/AjaxGuardarConfiguracion',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $('#SelectAgencia').val('').trigger('chosen:updated');
            $('#selectchosezonaventas2').val('').trigger('chosen:updated');
            $("#fechaini").val('');
            $("#fechafin").val('');
            $("#observacion").val('');
            $("#ErroObser").hide();
            $("#_alertaSuccesPermisosPaginaWeb #sucess").html('Configuración Guardada Correctamente');
            $("#_alertaSuccesPermisosPaginaWeb").modal('show');
        }
    });
});


$(".cargarFecha").change(function () {
    var zona = $('#selectchosezonaventas2').val();
    $.ajax({
        data: {
            'zona': zona
        },
        url: 'index.php?r=site/AjaxCargarFecha',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            var Fechas = jQuery.parseJSON(response);
            var FechaInicial = Fechas.FechaInicial;
            var FechaFinal = Fechas.FechaFinal;
            $("#fechaini").val(FechaInicial);
            $("#fechafin").val(FechaFinal);
        }
    });
});