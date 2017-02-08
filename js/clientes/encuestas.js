/*jQuery('#tblEncuestas').DataTable({
 "sPaginationType": "full_numbers",
 "aaSorting": []
 
 });*/


jQuery('.fechaEncuesta').datepicker({
    dateFormat: 'yy-mm-dd',
    beforeShow: function(i) {
        if ($(i).attr('readonly')) {
            return false;
        }
    }
});

$('body').on('click', '.siguientepregunta', function() {

    /*AQUI VALIDO SI EL TIPO DE ES 6 QUE ES RESPUESTA CON FOTO 
     * ESTE TIPO SE COGE DE LAS VISTA DE UN CAMPO HIDDEN QUE SE LLAMA TIPO
     * Y SUBO EL ARCHIVO AL SERVIDO POR AJAX EN LA CARPETA IMAGENES ENCUESTA
     */
    if ($("#tipo").val() != "") {

        if ($("#tipo").val() == '6') {

            var foto = $("#respuesta").val();

            var elem = foto.split("\\");
            for (var i = 0; i < elem.length; i++) {
                foto = elem[i];
            }

            var datos = new FormData();
            datos.append("respuesta", $("#respuesta")[0].files[0]);

            $.ajax({
                data: datos,
                url: 'index.php?r=clientes/AjaxGuardandoFotoEncuestaRespuesta',
                type: 'post',
                contentType: false,
                processData: false,
                multiple: true,
                success: function(response) {

                }
            });

        }

    }


    /*AQUI SUBO LA FOTOS DONDE LA PREGUNTAS TENGAN HABILITADO EL REQUIERE FOTO EN 1 O 2
     */
    var foto = $("#foto").val();

    if (typeof (foto) === "undefined") {

        foto = '0';
    }


    if (foto != "0") {


        var elem = foto.split("\\");
        for (var i = 0; i < elem.length; i++) {
            foto = elem[i];
        }

        var datos = new FormData();
        datos.append("foto", $("#foto")[0].files[0]);

        $.ajax({
            data: datos,
            url: 'index.php?r=clientes/AjaxGuardandoFotoEncuesta',
            type: 'post',
            contentType: false,
            processData: false,
            multiple: true,
            success: function(response) {

            }
        });

    }



    if ($("#idMultipleRespuesta").length > 0) {

        var checkNoRespuesta = 0;

        $(".chckRespuesta").each(function() {
            if ($(this).is(":checked")) {
                checkNoRespuesta++;
            }

        });

        if (checkNoRespuesta == 0) {

            $('#_alerta .text-modal-body').html('Por favor seleccione almenos una respuesra');
            $('#_alerta').modal('show');
            return false;
        }
    }


    if ($("#RequiereFoto").val() == '1') {

        if ($("#foto").val() == "") {

            $("#_alerta .text-modal-body").html('Por favor seleccione una foto');
            $("#_alerta").modal('show');
            return false;

        }
    }

    if ($("#TextoRespuesta").html() != "") {


        if ($.trim($("#respuesta").val()) == "") {

            $("#_alerta .text-modal-body").html('El campo respuesta no puede ser vacio');
            $("#_alerta").modal('show');
            return false;
        }

        if ($("#respuesta").val() == "") {
            $("#_alerta .text-modal-body").html('El campo respuesta no puede ser vacio');
            $("#_alerta").modal('show');
            return false;
        }

    }



    var idValorRespuesta = "";
    if ($("#respuesta").val() != "") {
        idValorRespuesta = $("#respuesta").val();
    } else {
        idValorRespuesta = '0';
    }


    var idRespuesta = $(this).attr('data-idRespuesta');

    if (idRespuesta == "undefined") {

        idRespuesta = '0';
    }

    var idPregunta = $(this).attr('data-idPregunta');
    var idSiguientePregunta = $(this).attr('data-idSiguientePregunta');
    var CuentaCliente = $("#CuentaCliente").val();
    var ZonaVentas = $("#ZonaVentas").val();



    $.ajax({
        data: {
            "pregunta": idPregunta,
            "respuesta": idRespuesta,
            "siguientePregunta": idSiguientePregunta,
            "valorrespuesta": idValorRespuesta,
            "CuentaCliente": CuentaCliente,
            "ZonaVentas": ZonaVentas,
            "foto": foto
        },
        url: 'index.php?r=clientes/AjaxSetEncuestaPreguntas',
        type: 'post',
        success: function(response) {

            if (response == 0) {
                $("#SiguinetePregunta").html('<input type="button" value="Guardar" class="btn btn-primary GuardarEncuesta">');
            } else {
                $("#NuevaPregunta").html(response);

                /*
                 * INICIALIZO EL CALENADRIO SI EL TIPO ES 5
                 */
                jQuery('.fechaEncuesta').datepicker({
                    dateFormat: 'yy-mm-dd',
                    beforeShow: function(i) {
                        if ($(i).attr('readonly')) {
                            return false;
                        }
                    }
                });
            }

        }
    });


});

$('body').on('click', '.idMultipleUnicaRespuesta', function() {

    var idSiguientePregunta = $(this).attr('data-idsiguinetepregunta');
    var idRespuesta = $(this).attr('data-idrespuesta');
    var idPregunta = $("#Idpregunta").val();
    var tipotexto = $(this).attr('data-tipotexto');


    $("#SiguinetePregunta").html('<input type="button" value="Siguiente"  class="btn btn-primary siguientepregunta" data-idSiguientePregunta="' + idSiguientePregunta + '" data-idPregunta="' + idPregunta + '" data-idRespuesta="' + idRespuesta + '">');

    if (tipotexto == 1) {

        $("#TextoRespuesta").html('<input id="respuesta" type="text" class="form-control"/>');

    } else if (tipotexto == 0) {

        $("#TextoRespuesta").html('');
    }

});



$('body').on('change', '.idSeleccionable', function() {

    var idSiguientePregunta = $('option:selected', $(this)).attr('data-idsiguinetepregunta');
    var idRespuesta = $('option:selected', $(this)).attr('data-idrespuesta');
    var idPregunta = $("#Idpregunta").val();
    var tipotexto = $('option:selected', $(this)).attr('data-tipotexto');


    $("#SiguinetePregunta").html('<input type="button" value="Siguiente"  class="btn btn-primary siguientepregunta" data-idSiguientePregunta="' + idSiguientePregunta + '" data-idPregunta="' + idPregunta + '" data-idRespuesta="' + idRespuesta + '">');

    if (tipotexto == 1) {

        $("#TextoRespuesta").html('<input id="respuesta" type="text" class="form-control"/>');

    } else if (tipotexto == 0) {

        $("#TextoRespuesta").html('');
    }

});

$('body').on('click', '.GuardarEncuesta', function() {

    $.ajax({
        url: 'index.php?r=clientes/AjaxGuardarEncuesta',
        type: 'post',
        success: function(response) {

            $("#_alertSuccesEncuestas .text-modal-body").html('Encuesta guardada satisfactoriamente');
            $("#_alertSuccesEncuestas").modal('show');

        }
    });


});


$('body').on('keypress', '.IngresoRepuesta', function() {


    if ($.trim($("#respuesta").val()) != "")
    {
        var idPregunta = $("#Idpregunta").val();
        var idRespuesta = $(this).attr('data-idrespuesta');

        var idSiguientePregunta = $(this).attr('data-idsiguinetepregunta');

        $("#SiguinetePregunta").html('<input type="button" value="Siguiente" class="btn btn-primary siguientepregunta" data-idSiguientePregunta="' + idSiguientePregunta + '" data-idPregunta="' + idPregunta + '" data-idRespuesta="' + idRespuesta + '">');
    } else {

        $("#SiguinetePregunta").html('');

    }
});


$('body').on('blur', '.IngresoRepuestaBlur', function() {

    var idPregunta = $("#Idpregunta").val();
    var idRespuesta = $(this).attr('data-idrespuesta');
    var idSiguientePregunta = $(this).attr('data-idsiguinetepregunta');

    $("#SiguinetePregunta").html('<input type="button" value="Siguiente" class="btn btn-primary siguientepregunta" data-idSiguientePregunta="' + idSiguientePregunta + '" data-idPregunta="' + idPregunta + '" data-idRespuesta="' + idRespuesta + '">');

});


$('body').on('click', '.idMultipleRespuesta', function() {


    var idRespuesta = $(this).attr('data-idRespuesta');
    var idPregunta = $("#Idpregunta").val();
    var idSiguientePregunta = $(this).attr('data-idsiguinetepregunta');
    var CuentaCliente = $("#CuentaCliente").val();
    var ZonaVentas = $("#ZonaVentas").val();
    var idValorRespuesta = '0';



    $.ajax({
        data: {
            "pregunta": idPregunta,
            "respuesta": idRespuesta,
            "siguientePregunta": idSiguientePregunta,
            "valorrespuesta": idValorRespuesta,
            "CuentaCliente": CuentaCliente,
            "ZonaVentas": ZonaVentas
        },
        url: 'index.php?r=clientes/AjaxSetEncuestaPreguntas',
        type: 'post',
        success: function(response) {

            $("#SiguinetePregunta").html('<input type="button" value="Siguiente" class="btn btn-primary siguientepregunta" data-idSiguientePregunta="' + idSiguientePregunta + '">');

        }
    });


});


function FilterInput(event) {

    var chCode = ('charCode' in event) ? event.charCode : event.keyCode;

    if (chCode == 8 || chCode == 0)
    {
        return chCode;
    } else {
        if (chCode > 47 & chCode < 58)
        {
            return chCode;
        } else {
            return false;
        }
    }

}