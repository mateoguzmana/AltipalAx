jQuery(document).ready(function () {

    jQuery('#validationWizardTrnasFerencia').bootstrapWizard({
        tabClass: 'nav nav-pills nav-justified nav-disabled-click',
        onTabClick: function (tab, navigation, index) {
            return false;
        },
        onNext: function (tab, navigation, index) {
            var $valid = jQuery('#formTranferenciaAutoventa').valid();
            if (!$valid) {

                $validator.focusInvalid();
                return false;
            }
        }
    });


    if (typeof history.pushState === "function") {
        history.pushState("jibberish", null, null);
        window.onpopstate = function () {
            history.pushState('newjibberish', null, null);
            // Handle the back (or forward) buttons here
            // Will NOT handle refresh, use onbeforeunload for this.
        };
    }
    else {
        var ignoreHashChange = true;
        window.onhashchange = function () {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
            }
            else {
                ignoreHashChange = false;
            }
        };
    }

    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {
            $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');
            $('#_alertaRecargarPagina').modal('show');
            return false;
        }
    });


});


$('body').on('click', '.ok', function () {

    location.reload();
});


$('#tblPortafolio').dataTable({
    "bPaginate": true
    ,
});


function addPoducto(id) {


    var codvarinate = id;
    var asesor = $("#codasesor").val();
    var zona = $("#zona").val();


    $.ajax({
        data: {
            'codvarinate': codvarinate,
            'asesor': asesor,
            'zona': zona
        },
        url: 'index.php?r=TransferenciaAutoventa/AjaxAddTransaccionAutoventa',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {


            $('#articuloPedido  .modal-body').html(response);
            $('#articuloPedido').modal('show');
            Unidaddisponible();
            $("#btn-adicionar-pro").click(function () {



                var selectlote = $("#selectlote").val();
                var cantidad = $("#txtCantidad").val();
                var variante = $("#variante").val();
                var nombrearticulo = $("#nombrearticulo").val();
                var codarticulo = $("#codarticulo").val();
                var asesor = $("#codasesor").val();
                var codzona = $("#zona").val();
                var codzonatransferencia = $("#codzonatransferencia").val();
                var dis = $("#dis").val();
                var unidadmedida = $("#unidadmedida").val();
                var codunidad = $("#codunidad").val();
                var nombreasesor = $("#nombreasesor").val();
                var precioventa = $("#precioventa").val();
                var TotalTranferencia = $("#TotalTranferencia").val();



                var MsgErrorCe = document.getElementById('MsgError');
                var MsgErrorDis = document.getElementById('MsgErrorDis')

                if ($("#selectlote").val() == 0) {
                    MsgErrorCe.innerHTML = "<font color='red'>Por favor seleccione un lote</font>";
                    return;
                }

                if (cantidad == "") {
                    MsgErrorDis.innerHTML = "<font color='red'>Por favor digite la cantidad</font>";
                    return;
                }


                if (parseInt(cantidad) > parseInt(dis)) {

                    $('#alertaCantidad .text-modal-body').html('La cantidad a transferir no puede ser superior a la cantidad disponible del lote seleccionado');
                    $('#alertaCantidad').modal('show');
                    $('#txtCantidad').val('');
                    return;
                }

                if (parseInt(cantidad) <= 0) {

                    $('#alertaCantidad .text-modal-body').html('La cantidad a transferir no puede ser valor negativo o 0');
                    $('#alertaCantidad').modal('show');
                    $('#txtCantidad').val('');
                    return;
                }


                $.ajax({
                    data: {
                        'selectlote': selectlote,
                        'cantidad': cantidad,
                        'variante': variante,
                        'nombrearticulo': nombrearticulo,
                        'codarticulo': codarticulo,
                        'asesor': asesor,
                        'codzona': codzona,
                        'codzonatransferencia': codzonatransferencia,
                        'codunidad': codunidad,
                        'unidadmedida': unidadmedida,
                        'nombreasesor': nombreasesor,
                        'dis': dis,
                        'precioventa': precioventa,
                        'TotalTranferencia': TotalTranferencia


                    },
                    url: 'index.php?r=TransferenciaAutoventa/AjaxAgregarItemTransferenciaAutoventa',
                    type: 'post',
                    beforeSend: function () {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function (response) {


                        $('#datos').html(response);
                        $('#bt').html(' <button class="btn btn-primary enviarPedido" style=" position: absolute;   right: 22px; height: 33px; width: 80px;">Enviar</button>');
                        init();
                        actualizaPortafolioAgregar();
                        $('#articuloPedido').modal('hide');
                        // $('#portafolio').modal('hide');



                        $(".cont").click(function () {


                            var variante = $(this).attr('data-variante');
                            var lote = $(this).attr('data-lote');


                            $.ajax({
                                data: {
                                    'variante': variante,
                                    'lote': lote
                                },
                                url: 'index.php?r=TransferenciaAutoventa/AjaxConsultarTransferenciaAutoventa',
                                type: 'post',
                                beforeSend: function () {
                                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                },
                                success: function (response) {


                                    $('#articuloPedido  .modal-body').html(response);
                                    $('#articuloPedido').modal('show');


                                    $("#btn-actualizar").click(function () {


                                        var codvariante = $("#codvariante").val();
                                        var lote = $("#lote").val();
                                        var cantidad = $("#txtCantidad").val();


                                        if (parseInt(cantidad) > parseInt(dis)) {

                                            $('#alertaCantidad .text-modal-body').html('"La cantidad a transferir no puede ser superior a la cantidad disponible del lote');
                                            $('#alertaCantidad').modal('show');
                                            $('#txtCantidad').val('');
                                            return false;
                                        }

                                        if (parseInt(cantidad) <= 0) {

                                            $('#alertaCantidad .text-modal-body').html('La cantidad a transferir no puede ser valor negativo o igual a 0');
                                            $('#alertaCantidad').modal('show');
                                            $('#txtCantidad').val('');
                                            return;
                                        }


                                        if (cantidad == "") {

                                            $('#alertaCantidad .text-modal-body').html('La cantidad a transferir no puede ser vacia');
                                            $('#alertaCantidad').modal('show');
                                            $('#txtCantidad').val('');
                                            return;
                                        }



                                        $.ajax({
                                            data: {
                                                'codvariante': codvariante,
                                                'lote': lote,
                                                'cantidad': cantidad
                                            },
                                            url: 'index.php?r=TransferenciaAutoventa/AjaxActualizarTransferenciaAutoventa',
                                            type: 'post',
                                            beforeSend: function () {
                                                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                            },
                                            success: function (response) {

                                                $('#datos').html(response);
                                                init();
                                                initActualzar();
                                                actualizaPortafolioAgregar();
                                                $('#articuloPedido').modal('hide');

                                            }
                                        });



                                    });

                                }
                            });



                        });




                    }
                });


            });


        }
    });



}





/////en esta funcion se vuelven a inicializar todas las respectivas funciones de la vista

function init() {


    $('.deleteItem').click(function () {

        if (confirm("¿Realmente desea eliminar este producto de la transferencia autoventa?")) {

            var variante = $(this).attr('data-variante');
            var lote = $(this).attr('data-lote');



            $.ajax({
                data: {
                    'variante': variante,
                    'lote': lote
                },
                url: 'index.php?r=TransferenciaAutoventa/AjaxEliminarTransferenciaAutoventa',
                type: 'post',
                beforeSend: function () {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function (response) {


                    $('#tableDetail').html(response);
                    $('#alertaElimindado').modal('show');
                    init();
                    actualizaPortafolioAgregar();
                    initActualzar();

                }
            });
        } else {

            return false;
        }

    });


}


function initActualzar() {


    $(".cont").click(function () {


        var variante = $(this).attr('data-variante');
        var lote = $(this).attr('data-lote');

        $.ajax({
            data: {
                'variante': variante,
                'lote': lote
            },
            url: 'index.php?r=TransferenciaAutoventa/AjaxConsultarTransferenciaAutoventa',
            type: 'post',
            beforeSend: function () {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function (response) {

                $('#articuloPedido  .modal-body').html(response);
                $('#articuloPedido').modal('show');


                $("#btn-actualizar").click(function () {


                    var codvariante = $("#codvariante").val();
                    var lote = $("#lote").val();
                    var cantidad = $("#txtCantidad").val();
                    var dis = $("#dis").val();



                    if (parseInt(cantidad) > parseInt(dis)) {

                        $('#alertaCantidad .text-modal-body').html('La cantidad a transferir no puede ser superior a la cantidad disponible del lote');
                        $('#alertaCantidad').modal('show');
                        $('#txtCantidad').val('');
                        return false;
                    }

                    if (parseInt(cantidad) < 0) {

                        $('#alertaCantidad .text-modal-body').html('La cantidad a transferir no puede ser valor negativo');
                        $('#alertaCantidad').modal('show');
                        $('#txtCantidad').val('');
                        return;
                    }



                    $.ajax({
                        data: {
                            'codvariante': codvariante,
                            'lote': lote,
                            'cantidad': cantidad
                        },
                        url: 'index.php?r=TransferenciaAutoventa/AjaxActualizarTransferenciaAutoventa',
                        type: 'post',
                        beforeSend: function () {
                            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                        },
                        success: function (response) {

                            $('#datos').html(response);
                            init();
                            initActualzar();
                            $('#articuloPedido').modal('hide');

                        }
                    });



                });

            }
        });



    });


}


function actualizaPortafolioAgregar() {

    $.ajax({
        url: 'index.php?r=TransferenciaAutoventa/AjaxActualizaPortafolioAgregar',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {

            var obj = jQuery.parseJSON(response);

            var table = $('#tblPortafolio').dataTable();
            var filtro = $('#tblPortafolio_filter input').val();
            table.fnFilterClear();


            $('.adicionar-producto-detalle-transaccion').each(function () {
                var variante = $(this).attr('data-codigo-variante');

                if ($(this).attr('data-nuevo') == 0) {
                    $('#imagen-producto-' + variante).attr('src', 'images/pro.png');

                } else {
                    $('#imagen-producto-' + variante).attr('src', 'images/pronuevo.png');
                }

            });
            $.each(obj, function (idx, obj) {
                $('#imagen-producto-' + obj).attr('src', 'images/aceptar.png');
            });

            table.fnFilter(filtro);

        }
    });

}




function Unidaddisponible() {

    var lote = $("#selectlote").val();
    var asesor = $("#codasesor").val();
    var variante = $("#variante").val();


    $.ajax({
        data: {
            'lote': lote,
            'variante': variante


        },
        url: 'index.php?r=TransferenciaAutoventa/AjaxLotesDisponibles',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {


            if (response == '1') {
                $('#alertaErrorLote #mensaje-error-lote').html('Este producto para este lote ya ha sido adicionado a la transferencia, si desea puede modificarlo o eliminarlo');
                $('#alertaErrorLote').modal('show');
                $('#selectlote').find('option:first').attr('selected', 'selected').parent('select');
                return;
            } else {

                $.ajax({
                    data: {
                        'lote': lote,
                        'asesor': asesor,
                        'variante': variante


                    },
                    url: 'index.php?r=TransferenciaAutoventa/AjaxCantidadDisponible',
                    type: 'post',
                    beforeSend: function () {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function (response) {

                        $('#disponibles').html(response);

                        document.getElementById("MsgError").innerHTML = "";

                    }
                });

            }

        }
    });


}


function FilterInput(event) {

    document.getElementById("MsgErrorDis").innerHTML = "";
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




$("#formTranferenciaAutoventa").submit(function () {


    var CupoLimiteAutoventa = $("#CupoLimiteAutoventa").val();
    var TotalTranferencia = $("#TotalTranferencia").val();
    var ZonaATransferir = $("#codzonatransferencia").val();
    var CupoDisponible = $("#CupoDisponible").val();




    if (CupoLimiteAutoventa != '0') {

        if (CupoDisponible != '0') {

            if (parseFloat(TotalTranferencia) > parseFloat(CupoDisponible)) {

                $('#alertaErrorValidar #mensaje-error-transaccion').html("El valor de la transferencia supera el cupo limite a la zona que va a transferir. la tranferencia debe ser menor a: " + CupoDisponible);
                $('#alertaErrorValidar').modal('show');
                return false;
            } else {

                if (parseFloat(CupoDisponible) == parseFloat(CupoLimiteAutoventa) || parseFloat(TotalTranferencia) > parseFloat(CupoLimiteAutoventa)) {

                    $('#alertaErrorValidar #mensaje-error-transaccion').html("No se puede hacer transferencia a la zona " + ZonaATransferir + " , ya que cuenta con el cupo completo");
                    $('#alertaErrorValidar').modal('show');
                    return false;
                }

            }

        } else {

            if (parseFloat(CupoDisponible) == parseFloat(CupoLimiteAutoventa) || parseFloat(TotalTranferencia) > parseFloat(CupoLimiteAutoventa)) {

                $('#alertaErrorValidar #mensaje-error-transaccion').html("No se puede hacer transferencia a la zona " + ZonaATransferir + " , ya que no  cuenta con el cupo disponible");
                $('#alertaErrorValidar').modal('show');
                return false;
            }

        }
    } else if (CupoLimiteAutoventa == '0') {

        $('#alertaErrorValidar #mensaje-error-transaccion').html("La " + ZonaATransferir + " no cuenta con cupo disponible");
        $('#alertaErrorValidar').modal('show');
        return false;
    }


    var cantidadProductos = $('#cantidad').val();

    if (cantidadProductos <= 0) {

        $('#alertaErrorValidar #mensaje-error-transaccion').html("No se han adicionado productos a la transferencia no es posible realizar el envio");
        $('#alertaErrorValidar').modal('show');
        return false;

    } else {


        $('#alertaConfirmationTransferenciaAutoventa .text-modal-body').html("Ésta seguro de terminar la transferencia autoventa en este momento");
        $('#alertaConfirmationTransferenciaAutoventa').modal('show');
        return false;

    }



});

var num = $("#sucess").attr('data-num');

$('#_alertSucessTransferenciaAutoventa #sucess').html("Transferencia realizada correctamente <br/> # de transferencia:  " + num);
$('#_alertSucessTransferenciaAutoventa').modal('show');

//$('#_alertinformation').modal('show');


function salir() {


    $('#_alertConfirmationMenuTransAuto .text-modal-body').html('Esta seguro que desea salir del modulo de  transferencia autoventa?');
    $('#_alertConfirmationMenuTransAuto').modal('show');


}

function ok() {

    window.location.href = "index.php?r=FuerzaVentas/MenuFuerzaVentas";
}


$('.retornarmenu').click(function () {

    window.location.href = "index.php?r=FuerzaVentas/MenuFuerzaVentas";

});


$("#btnEnviarFormTransAutoventa").click(function () {

    document.getElementById("formTranferenciaAutoventa").submit();
});


$("#codzonatransferencia").change(function () {

    var zona = $("#codzonatransferencia").val();


    $.ajax({
        data: {
            'zona': zona


        },
        url: 'index.php?r=TransferenciaAutoventa/AjaxGenrarUbiacion',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {

            $('#codubicacion').html(response);


            //esta jax me actualiza el cupo de la zona de ventas que yo le vaya hacer la transferencia

            $.ajax({
                data: {
                    'zona': zona


                },
                url: 'index.php?r=TransferenciaAutoventa/AjaxGenrarCupo',
                type: 'post',
                beforeSend: function () {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function (response) {

                    var valorZona = jQuery.parseJSON(response);

                    var CupoLimiteAutoventa = valorZona.CupoLimite;
                    var TotalPedidos = valorZona.TotalPedidos;

                    $('#CupoLimiteAutoventa').val(CupoLimiteAutoventa);
                    $('#TotalPedidos').val(TotalPedidos);


                }
            });



        }
    });

});