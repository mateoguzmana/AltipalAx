jQuery(document).ready(function() {

    getLocation();
    
    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {
           
          $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');  
          $('#_alertaRecargarPagina').modal('show');
          return false;
        }
    });

});


$('body').on('click','.ok',function(){
    
   location.reload(); 
});



$('.btnAbrirModalCorreo').click(function() {

    $('#_alertCorreoAutoventa').modal('show');
    $('#_alertSecessPedidoAutoventa').modal('hide');

});


$('#btnConfirmarEnviarEmailAutoventa').click(function() {


    var zonaVentas = $(this).attr('data-zona-ventas');
    var cuentaCliente = $(this).attr('data-cuenta-cliente');
    var agencia = $(this).attr('data-agencia');
    var factura = $(this).attr('data-factura');
    var emailCliente = $('#inputCorreoAutoventa').val();


    var filter = /^(([^<>()[]\.,;:s@"]+(.[^<>()[]\.,;:s@"]+)*)|(".+"))@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}])|(([a-zA-Z-0-9]+.)+[a-zA-Z]{2,}))$/;


    if (!filter.test(emailCliente)) {
        $.ajax({
            data: {
                'zonaVentas': zonaVentas,
                'cuentaCliente': cuentaCliente,
                'agencia': agencia,
                'factura': factura,
                'emailCliente': emailCliente

            },
            url: 'index.php?r=service/WebMobile/EnviarFactura',
            type: 'post',
            beforeSend: function() {
                $("#enviandoAutoventa").css("display", "inline");
            },
            success: function(response) {
                if (response == "OK") {
                    $('#_alertCorreoAutoventa').modal('hide');
                    $('#_alertaEnvioEmailAutoventa #txtEmailCliente').html('<b>' + emailCliente + '</b>');
                    $('#_alertaEnvioEmailAutoventa').modal('show');
                }
            }
        });
    } else {
        $("#_alerta").css("z-index", "15000");
        $('#_alerta .text-modal-body').html('La direcciÃ³n de correo electrÃ³nico no es valida');
        $('#_alerta').modal('show');
        return false;
    }


});




if (typeof history.pushState === "function") {
    history.pushState("jibberish", null, null);
    window.onpopstate = function() {
        history.pushState('newjibberish', null, null);
        // Handle the back (or forward) buttons here
        // Will NOT handle refresh, use onbeforeunload for this.
    };
}
else {
    var ignoreHashChange = true;
    window.onhashchange = function() {
        if (!ignoreHashChange) {
            ignoreHashChange = true;
            window.location.hash = Math.random();
        }
        else {
            ignoreHashChange = false;
        }
    };
}

$('#retornarMenu').click(function() {
    var zona = $(this).attr('data-zona');
    var cliente = $(this).attr('data-cliente');
    var resValidation;
    $('#_alertConfirmationMenu .text-modal-body').html('Esta seguro de salir del modulo de pedidos?');
    $('#_alertConfirmationMenu').modal('show');

});

jQuery('#tabsCrearPedidoAutoventa').bootstrapWizard({
    tabClass: 'nav nav-pills nav-justified nav-disabled-click',
    onTabClick: function(tab, navigation, index) {
        return false;
    },
    onNext: function(tab, navigation, index) {
        var $valid = jQuery('#frmPedidoAutoventa').valid();
        if (!$valid) {

            $validator.focusInvalid();
            return false;
        }
    }
});



$.datepicker.regional['es'] = {
    closeText: 'Cerrar',
    prevText: 'Previo',
    nextText: 'PrÃ³ximo',
    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
        'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    monthStatus: 'Ver otro mes', yearStatus: 'Ver otro aÃ±o',
    dayNames: ['Domingo', 'Lunes', 'Martes', 'MiÃ©rcoles', 'Jueves', 'Viernes', 'SÃ¡bado'],
    dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'SÃ¡b'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
    dateFormat: 'dd/mm/yy', firstDay: 0,
    initStatus: 'Selecciona la fecha', isRTL: false
};

$.datepicker.setDefaults($.datepicker.regional['es']);

jQuery('#dtpFechaEntrega').datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 'today',
    beforeShow: function(i) {
        if ($(i).attr('readonly')) {
            return false;
        }
    }
});


$('.btnAdicionarSinSaldo').click(function() {
    $('#alertaArticuloSinSaldo').modal('show');
});



$("#plazo").keypress(function(tecla) {
    if (tecla.charCode < 48 || tecla.charCode > 57)
        return false;
});


$('#select-especial').change(function() {

    if ($("#txtDescuentoEspecialAutoventa").val() == "" || $("#txtDescuentoEspecialAutoventa").val() == "0") {
        $('#select-especial').prop('selectedIndex', 0);
    }
});

$("#plazo").keypress(function(tecla) {
    if (tecla.charCode < 48 || tecla.charCode > 57)
        return false;
});

var formasPago = $('#plazo').html();

$('#formaPagoAutoventa').change(function() {

    if ($(this).val() == '') {
        $('#plazo').attr('disabled', 'disabled');
    }

    if ($(this).val() == 'contado') {
        $('#plazo').html('<option value="022" >0 DÃ­as</option>');
        $('#plazo').removeAttr('disabled');

   
    }
    if ($(this).val() == 'credito') {

        $('#plazo').html(formasPago);
        $('#plazo').removeAttr('disabled');

        jQuery('#tabsCrearPedidoAutoventa').bootstrapWizard({
            tabClass: 'nav nav-pills nav-justified nav-disabled-click',
            onTabClick: function(tab, navigation, index) {
                return false;
            },
            onNext: function(tab, navigation, index) {
                var $valid = jQuery('#frmPedidoAutoventa').valid();
                if (!$valid) {

                    $validator.focusInvalid();
                    return false;
                }
            }
        });
    }
});

////////////////////////////////////////////////////CODIGO NUEVO//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////CODIGO NUEVO//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////CODIGO NUEVO//////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////CODIGO NUEVO//////////////////////////////////////////////////////////////////////////////

$('.btnAdicionarProductoDetalleAct').click(function() {



    var txtCodigoVariante = $(this).attr('data-CodigoVariante');
    var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
    //var txtZonaVentas =$(this).attr('data-zona-ventas');
    var txtZonaVentas = $('#txtZonaVentas').val();
    var txtCliente = $('#txtCuentaCliente').val();

    var txtCodigoAcuerdoPrecioVenta = $(this).attr('data-ACCodigoUnidadMedida');
    var txtNombreUnidadMedidaPrecioVenta = $(this).attr('data-ACNombreUnidadMedida');
    var txtLote = $(this).attr('data-lote');
    var txtSaldo = $(this).attr('data-saldo');
    var tipoVenta = $('#select-tipo-venta-autoventa').val();

    $.ajax({
        data: {
            "txtCodigoVariante": txtCodigoVariante,
            "txtCodigoArticulo": txtCodigoArticulo,
            "txtZonaVentas": txtZonaVentas,
            "txtCliente": txtCliente,
            "txtCodigoAcuerdoPrecioVenta": txtCodigoAcuerdoPrecioVenta,
            "txtNombreUnidadMedidaPrecioVenta": txtNombreUnidadMedidaPrecioVenta,
            "tipoVenta": tipoVenta,
            "txtLote": txtLote,
            "txtSaldo": txtSaldo
        },
        url: 'index.php?r=Autoventa/AjaxGetDetalleArticulo',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            $("#contMdlArticuloDetalle").css("z-index", "15000");
            $('#mdlKitDinamico').modal('hide');
            $('#mdlKitVirtual').modal('hide');
            $('#contMdlArticuloDetalle').html(response);
            $('#mdlArticuloDetalle').modal('show');

            iniBtnAdicionalrProducto();
            iniValidarCantidad();
            iniCantidadAcuerdos();
            cargarlote();

        }
    });
});


function iniCantidadAcuerdos() {


    $('.txtCantidadPedida').keyup(function() {


        var txtClienteDetalle = $('.txtClienteDetalle').val();
        var txtCodigoVariante = $('.textDetCodigoProducto').val();
        var txtUnidadMedida = $('.textDetCodigoUnidadMedida').val();
        var txtArticulo = $('.txtCodigoArticulo').val();
        var txtZonaVenta = $('.txtZonaVenta').val();
        var txtCodigoGrupoDescuentoLinea = $('.txtCodigoGrupoDescuentoLinea').val();
        var txtCodigoGrupoDescuentoMultiLinea = $('.txtCodigoGrupoDescuentoMultiLinea').val();
        var txtCodigoGrupoClienteDescuentoLinea = $('.txtCodigoGrupoArticulosDescuentoLinea').val();
        var txtCodigoGrupoClienteDescuentoMultilinea = $('.txtCodigoGrupoArticulosDescuentoMultilinea').val();

        var txtCantidad = $(this).val();


        if (txtCantidad != "" && txtCantidad != 0) {

            $.ajax({
                data: {
                    'txtClienteDetalle': txtClienteDetalle,
                    'txtCodigoVariante': txtCodigoVariante,
                    'txtUnidadMedida': txtUnidadMedida,
                    'txtArticulo': txtArticulo,
                    'txtZonaVenta': txtZonaVenta,
                    'txtCodigoGrupoDescuentoLinea': txtCodigoGrupoDescuentoLinea,
                    'txtCantidad': txtCantidad,
                    'txtCodigoGrupoClienteDescuentoLinea': txtCodigoGrupoClienteDescuentoLinea
                },
                url: 'index.php?r=Autoventa/AjaxValidarAcuerdoLinea',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {


                    var obj = jQuery.parseJSON(response);

                    $('.txtDescuentoProveedor').val(obj.descuentoLinea);
                    $('.txtIdAcuerdoLinea').val(obj.acuerdoComercial);


                }
            });


            $.ajax({
                data: {
                    'txtClienteDetalle': txtClienteDetalle,
                    'txtCodigoVariante': txtCodigoVariante,
                    'txtUnidadMedida': txtUnidadMedida,
                    'txtArticulo': txtArticulo,
                    'txtCodigoGrupoDescuentoMultiLinea': txtCodigoGrupoDescuentoMultiLinea,
                    'txtCantidad': txtCantidad,
                    'txtCodigoGrupoClienteDescuentoMultilinea': txtCodigoGrupoClienteDescuentoMultilinea
                },
                url: 'index.php?r=Autoventa/AjaxValidarAcuerdoMultiLinea',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {

                    var obj = jQuery.parseJSON(response);
                    $('.txtDescuentoAltipal').val(obj.descuentoMultiLinea);
                    $('.txtIdAcuerdoMultilinea').val(obj.acuerdoComercialMulti);

                }
            });

        } else {
            if ($('.txtSaldoLimite').val() == "") {
                $('.txtDescuentoProveedor').val('0');
            }
            $('.txtDescuentoAltipal').val('0');
            $('.txtIdAcuerdoMultilinea').val('');
            $('.txtIdAcuerdoLinea').val('');

        }

    });


}


function iniValidarCantidad() {
    $('.txtCantidadPedida').keypress(function(tecla) {
        var ev = (tecla.which) ? tecla.which : tecla.keyCode;

        if ((tecla.keyCode != 9) && (tecla.keyCode != 8) && (tecla.keyCode != 127))
        {
            return (ev < 48 || ev > 57) ? false : true;
        }
    });

}


function iniBtnAdicionalrProducto() {

    $('.btnAdicionarProducto').click(function() {

        var codigoVariante = $('.textDetCodigoProducto').val();
        var descripcion = $('.textDetNombreProducto').val();
        var textDetIva = $('.textDetIva').val();
        var textVariante = codigoVariante;
        var textDetSaldo = $('.textDetSaldo').val();
        var textDetValorProducto = $('.textDetValorProducto').val();
        var textDetImpoconsumo = $('.textDetImpoconsumo').val();
        var txtCantidadPedida = $('.txtCantidadPedida').val();
        var textDetCodigoUnidadMedida = $('.textDetCodigoUnidadMedida').val();
        var textDetNombreUnidadMedida = $('.textDetNombreUnidadMedida').val();

        var txtCodigoArticulo = $('.txtCodigoArticulo').val();
        var txtIdAcuerdo = $('.txtIdAcuerdo').val();
        var txtCodigoUnidadSaldoInventario = $('.txtCodigoUnidadSaldoInventario').val();
        var txtCodigoTipo = $('.txtCodigoTipo').val();
        var txtCuentaProveedor = $('.txtCuentaProveedor').val();
        var txtSaldoLimite = $('.txtSaldoLimite').val();

        var txtDescuentoEspecialSelect = $('#sltResposableDescuento').val();
        var txtDescuentoEspecial = $('.txtDescuentoEspecial').val();
        var txtDescuentoEspecialProveedor = $('.txtDescuentoEspecialProveedor').val();
        var txtDescuentoEspecialAltipal = $('.txtDescuentoEspecialAltipal').val();


        var txtDescuentoProveedor = $('.txtDescuentoProveedor').val();
        var txtDescuentoAltipal = $('.txtDescuentoAltipal').val();

        var txtCodigoGrupoArticulosDescuentoMultilinea = $('.txtCodigoGrupoArticulosDescuentoMultilinea').val();

        var txtIdSaldoAutoventa = $('.txtIdSaldoAutoventa').val();
        var txtIdAcuerdoLinea = $('.txtIdAcuerdoLinea').val();
        var txtIdAcuerdoMultilinea = $('.txtIdAcuerdoMultilinea').val();



        var txtIdSaldoInventario = $('.textDetSaldo').val();
        var txtlote = $('#txtLote').val();


        if (txtlote == 0) {
            $('#alertaErrorValidar').css("z-index", "15001");
            $('#alertaErrorValidar #mensaje-error').html('Por favor seleccione un lote.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

       
        if (txtCantidadPedida === "" || parseInt(txtCantidadPedida) <= '0') {
            $('#alertaErrorValidar').css("z-index", "15002");
            $('#alertaErrorValidar #mensaje-error').html('La cantidad pedida no es valida o esta vacia.');
            $('#alertaErrorValidar').modal('show');
            return;
        }


        if (parseInt(txtCantidadPedida) == 0) {
             alert("..."+txtCantidadPedida);
            $('#alertaErrorValidar').css("z-index", "15000");
            $('#alertaErrorValidar #mensaje-error').html('La cantidad no puede ser 0.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

        if (parseInt(textDetSaldo) != 0 && parseInt(txtCantidadPedida) > parseInt(textDetSaldo)) {
            $('#alertaErrorValidar').css("z-index", "15000");
            $('#alertaErrorValidar #mensaje-error').html('La cantidad no puede superar el saldo disponible.');
            $('#alertaErrorValidar').modal('show');
            return;
        }


        if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoACDL) && parseFloat(txtSaldoACDL) != 0) {
            $('#alertaACDLCantidad').css("z-index", "15000");
            $('#alertaACDLCantidad #mensaje-error').html('â€œEl artÃ­culo no cuenta con saldo para la cantidad pedida de acuerdo al lÃ­mite de ventas, desea enviar la cantidad pendiente con el precio normalâ€?');
            $('#alertaACDLCantidad').modal('show');
            return;
        }



        if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoLimite) && parseFloat(txtSaldoLimite) != "") {
            $('#alertaACDLCantidad').css("z-index", "15001");
            $('#alertaACDLCantidad #mensaje-error').html('â€œEl artÃ­culo no cuenta con saldo para la cantidad pedida de acuerdo al lÃ­mite de ventas, desea enviar la cantidad pendiente con el precio normalâ€?');
            $('#alertaACDLCantidad').modal('show');
            return;
        }



        $.ajax({
            data: {
                "nombreProducto": descripcion,
                'codigoArticulo': txtCodigoArticulo,
                'codigoTipo': txtCodigoTipo,
                "idSaldoInventario": txtIdSaldoInventario,
                "codigoUnidadSaldoInventario": txtCodigoUnidadSaldoInventario,
                "variante": textVariante,
                "codigoUnidadMedida": textDetCodigoUnidadMedida,
                "nombreUnidadMedida": textDetNombreUnidadMedida,
                "valorUnitario": textDetValorProducto,
                "impoconsumo": textDetImpoconsumo,
                "cantidad": txtCantidadPedida,
                "saldo": textDetSaldo,
                "saldoLimite": txtSaldoLimite,
                //"codigoUnidadMedidaACDL": txtCodigoUnidadMedidaACDL,
                //"saldoACDLSinConversion": txtSaldoACDLSinConversion,
                "idAcuerdo": txtIdAcuerdo,
                "descuentoProveedor": txtDescuentoProveedor,
                "descuentoAltipal": txtDescuentoAltipal,
                "descuentoEspecial": txtDescuentoEspecial,
                "iva": textDetIva,
                "descuentoEspecialSelect": txtDescuentoEspecialSelect,
                "descuentoEspecialProveedor": txtDescuentoEspecialProveedor,
                "descuentoEspecialAltipal": txtDescuentoEspecialAltipal,
                "cuentaProveedor": txtCuentaProveedor,
                "txtCodigoGrupoArticulosDescuentoMultilinea": txtCodigoGrupoArticulosDescuentoMultilinea,
                "txtIdAcuerdoLinea": txtIdAcuerdoLinea,
                "txtIdAcuerdoMultilinea": txtIdAcuerdoMultilinea,
                "aplicaImpoconsumo": true,
                "txtlote": txtlote,
                "IdSaldoAutoventa": txtIdSaldoAutoventa
            },
            url: 'index.php?r=Autoventa/AjaxAgregarItemPedido',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                $('#tableDetail').html(response);
                calculaTotalesPedido();
                actualizaPortafolioAgregar();
                iniActualizarProductos();

                $('#mdlArticuloDetalle').modal('hide');
                $('#txtCantidadPedida').val('');

                $('#txtDescuentoProveedorPreventa').val('');
                $('#txtDescuentoAltipal').val('');
                $('#txtDescuentoEspecialPreventa').val('');
                $('#select-especial').prop('selectedIndex', 0);

                iniEliminarItemPortafolio();
                iniBtnAdicionarProductoDetalleAct(false);
                iniBtnAdicionarKitDinamico();
                iniBtnAdicionarKitVirtual();

            }
        });

    });

}


function iniEliminarItemPortafolio() {

    $('.delete-item-pedido').click(function() {
        var variante = $(this).attr('data-variante');
        $.ajax({
            data: {
                "variante": variante,
            },
            url: 'index.php?r=Preventa/AjaxEliminarItemPedido',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                $('#tableDetail').html(response);

                calculaTotalesPedido();
                actualizaPortafolioAgregar();
                iniEliminarItemPortafolio();
                iniActualizarProductos();
                iniBtnAdicionarProductoDetalleAct();

            }
        });
    });
}



function iniBtnAdicionarProductoDetalleAct(valida) {


    $('.btnAdicionarProductoDetalleAct').click(function() {


        var txtCodigoVariante = $(this).attr('data-CodigoVariante');
        var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
        var txtZonaVentas = $('#txtZonaVentas').val();
        var txtCliente = $('#txtCuentaCliente').val();
        var txtCodigoAcuerdoPrecioVenta = $(this).attr('data-ACCodigoUnidadMedida');
        var txtNombreUnidadMedidaPrecioVenta = $(this).attr('data-ACNombreUnidadMedida');
        var txtKit = $(this).attr('data-kit');
        var txtTipoKit = $(this).attr('data-tipo-kit');
        var tipoVenta = $('#select-tipo-venta-preventa').val();
        var txtLote = $(this).attr('data-lote');
        var txtSaldo = $(this).attr('data-saldo');



        if (txtKit) {

            var conta = 0;
            var cant = new Array();
            $('.txtCantidadItem').each(function() {

                cant[conta] = $(this).val();
                conta++;
            });

            var cont = 1;
            var cont_3 = 0;
            if (txtTipoKit == "dinamico" && validarKitDinamico()) {
                $(".itemKitDinamico").each(function() {

                    var txtKitCodigoArticuloKit = $(this).attr('data-kit-CodigoArticuloKit');
                    var txtKitCodigoListaMateriales = $(this).attr('data-kit-CodigoListaMateriales');
                    var txtKitCodigoArticuloComponente = $(this).attr('data-kit-CodigoArticuloComponente');
                    var txtKitNombre = $(this).attr('data-kit-Nombre');
                    var txtKitCodigoUnidadMedida = $(this).attr('data-kit-CodigoUnidadMedida');
                    var txtKitCodigoTipo = $(this).attr('data-kit-CodigoTipo');
                    var txtKitFijo = $(this).attr('data-kit-Fijo');
                    var txtKitOpcional = $(this).attr('data-kit-Opcional');
                    var txtKitPrecioVentaBaseVariante = $(this).attr('data-kit-TotalPrecioVentaBaseVariante');

                    // var codigo = txtKitCodigoArticuloComponente + "-" + txtKitFijo + "-" + txtKitOpcional;
                    // var cantidad = $('#txtInputKit-' + codigo).val();


                    //if (cantidad != "") {

                    $.ajax({
                        data: {
                            "kd": 1,
                            "txtCodigoArticuloKit": txtKitCodigoArticuloKit,
                            "txtCodigoLista": txtKitCodigoListaMateriales,
                            "txtCodigoArticulo": txtKitCodigoArticuloComponente,
                            "txtNombreKit": txtKitNombre,
                            "txtUnidadKit": txtKitCodigoUnidadMedida,
                            "txtTipo": txtKitCodigoTipo,
                            "txtCantidadItemFijo": txtKitFijo,
                            "txtCantidadItemOpcional": txtKitOpcional,
                            "txtKitPrecioVentaBaseVariante": txtKitPrecioVentaBaseVariante,
                            "txtCantidad": cant[cont_3],
                        },
                        url: 'index.php?r=Autoventa/AjaxGuardarKitDinamico',
                        type: 'post',
                        beforeSend: function() {
                            $(".imgDivKit").html('<img alt="" src="images/loaders/loader9.gif">');
                        },
                        success: function(response) {
                            $(".imgDivKit").html('');
                        }
                    });
                    //}

                    cont++;
                    cont_3++;
                });
            }


            if (txtTipoKit == "virtual") {

                $(".itemKitVirtual").each(function() {

                    var txtKitCodigoArticuloKit = $(this).attr('data-kit-CodigoArticuloKit');
                    var txtKitCodigoListaMateriales = $(this).attr('data-kit-CodigoListaMateriales');
                    var txtKitCodigoArticuloComponente = $(this).attr('data-kit-CodigoArticuloComponente');
                    var txtKitNombre = $(this).attr('data-kit-Nombre');
                    var txtKitCodigoUnidadMedida = $(this).attr('data-kit-CodigoUnidadMedida');
                    var txtKitCodigoTipo = $(this).attr('data-kit-CodigoTipo');
                    var txtKitFijo = $(this).attr('data-kit-Fijo');
                    var txtKitOpcional = $(this).attr('data-kit-Opcional');
                    var txtKitPrecioVentaBaseVariante = $(this).attr('data-kit-TotalPrecioVentaBaseVariante');
                    var txtKitCantidad = $(this).attr('data-kit-cantidad');
                    var cantidad = "";

                    $.ajax({
                        data: {
                            "kd": 2,
                            "txtCodigoArticuloKit": txtKitCodigoArticuloKit,
                            "txtCodigoLista": txtKitCodigoListaMateriales,
                            "txtCodigoArticulo": txtKitCodigoArticuloComponente,
                            "txtNombreKit": txtKitNombre,
                            "txtUnidadKit": txtKitCodigoUnidadMedida,
                            "txtTipo": txtKitCodigoTipo,
                            "txtCantidadItemFijo": cantidad,
                            "txtCantidadItemOpcional": cantidad,
                            "txtMinimoKitFijo": txtKitFijo,
                            "txtMinimoKitOpcional": txtKitOpcional,
                            "txtCantidad": txtKitCantidad,
                            "txtKitPrecioVentaBaseVariante": txtKitPrecioVentaBaseVariante

                        },
                        url: 'index.php?r=Autoventa/AjaxGuardarKitDinamico',
                        type: 'post',
                        beforeSend: function() {
                            $(".imgDivKit").html('<img alt="" src="images/loaders/loader9.gif">');
                        },
                        success: function(response) {
                            $(".imgDivKit").html('');
                        }
                    });

                    cont++;
                });
            }

            //console.log(cont); 
            //console.log( parseInt($('.itemKit').length) );

            if (cont >= parseInt($('.itemKit').length)) {


                $.ajax({
                    data: {
                        "kd": 1,
                        "txtCodigoVariante": txtCodigoVariante,
                        "txtCodigoArticulo": txtCodigoArticulo,
                        "txtCliente": txtCliente,
                        "txtCodigoAcuerdoPrecioVenta": txtCodigoAcuerdoPrecioVenta,
                        "txtNombreUnidadMedidaPrecioVenta": txtNombreUnidadMedidaPrecioVenta,
                        "txtZonaVentas": txtZonaVentas,
                        "tipoVenta": tipoVenta,
                        "txtLote": txtLote,
                        "txtSaldo": txtSaldo
                    },
                    url: 'index.php?r=Autoventa/AjaxGetDetalleArticulo',
                    type: 'post',
                    beforeSend: function() {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function(response) {

                        if (valida) {
                            if (validarKitDinamico()) {

                                $("#contMdlArticuloDetalle").css("z-index", "15000");
                                $('#mdlKitDinamico').modal('hide');
                                $('#mdlKitVirtual').modal('hide');
                                $('#contMdlArticuloDetalle').html(response);
                                $('#mdlArticuloDetalle').modal('show');

                                iniBtnAdicionalrProducto();
                                iniValidarCantidad();
                                iniCantidadAcuerdos();
                                cargarlote();

                            }
                        } else {
                            $("#contMdlArticuloDetalle").css("z-index", "15000");
                            $('#mdlKitDinamico').modal('hide');
                            $('#mdlKitVirtual').modal('hide');
                            $('#contMdlArticuloDetalle').html(response);
                            $('#mdlArticuloDetalle').modal('show');

                            iniBtnAdicionalrProducto();
                            iniValidarCantidad();
                            iniCantidadAcuerdos();
                            cargarlote();
                        }


                    }
                });

            }

        } else {


            $.ajax({
                data: {
                    "txtCodigoVariante": txtCodigoVariante,
                    "txtCodigoArticulo": txtCodigoArticulo,
                    "txtCliente": txtCliente,
                    "txtCodigoAcuerdoPrecioVenta": txtCodigoAcuerdoPrecioVenta,
                    "txtNombreUnidadMedidaPrecioVenta": txtNombreUnidadMedidaPrecioVenta,
                    "txtZonaVentas": txtZonaVentas,
                    "tipoVenta": tipoVenta,
                    "txtLote": txtLote,
                    "txtSaldo": txtSaldo
                },
                url: 'index.php?r=Autoventa/AjaxGetDetalleArticulo',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {

                    if (valida) {
                        if (validarKitDinamico()) {

                            $("#contMdlArticuloDetalle").css("z-index", "15000");
                            $('#mdlKitDinamico').modal('hide');
                            $('#mdlKitVirtual').modal('hide');
                            $('#contMdlArticuloDetalle').html(response);
                            $('#mdlArticuloDetalle').modal('show');

                            iniBtnAdicionalrProducto();
                            iniValidarCantidad();
                            iniCantidadAcuerdos();
                            cargarlote();

                        }
                    } else {
                        $("#contMdlArticuloDetalle").css("z-index", "15000");
                        $('#mdlKitDinamico').modal('hide');
                        $('#mdlKitVirtual').modal('hide');
                        $('#contMdlArticuloDetalle').html(response);
                        $('#mdlArticuloDetalle').modal('show');

                        iniBtnAdicionalrProducto();
                        iniValidarCantidad();
                        iniCantidadAcuerdos();
                        cargarlote();
                    }


                }
            });

        }
    });
}




/////KIT VIRTUAL///////

$('.btnAdicionarKitVirtual').click(function() {


    var txtCodigoVariante = $(this).attr('data-CodigoVariante');
    var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
    var txtNombreArticulo = $(this).attr('data-NombreArticulo');
    var txtCodigoCaracteristica1 = $(this).attr('data-CodigoCaracteristica1');
    var txtCodigoCaracteristica2 = $(this).attr('data-CodigoCaracteristica2');
    var txtCodigoTipo = $(this).attr('data-CodigoTipo');
    var txtCliente = $(this).attr('data-cliente');

    $.ajax({
        data: {
            "txtCodigoVariante": txtCodigoVariante,
            "txtCodigoArticulo": txtCodigoArticulo,
            "txtNombreArticulo": txtNombreArticulo,
            "txtCodigoCaracteristica1": txtCodigoCaracteristica1,
            "txtCodigoCaracteristica2": txtCodigoCaracteristica2,
            "txtCodigoTipo": txtCodigoTipo,
            "txtCliente": txtCliente
        },
        url: 'index.php?r=Autoventa/AjaxGetKitVirtual',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $('#contMdlKitVirtual').html(response);
            $('#mdlKitVirtual').modal('show');
            iniBtnAdicionarProductoDetalleAct(false);
        }
    });

});


function iniBtnAdicionarKitVirtual() {

    $('.btnAdicionarKitVirtual').click(function() {


        var txtCodigoVariante = $(this).attr('data-CodigoVariante');
        var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
        var txtNombreArticulo = $(this).attr('data-NombreArticulo');
        var txtCodigoCaracteristica1 = $(this).attr('data-CodigoCaracteristica1');
        var txtCodigoCaracteristica2 = $(this).attr('data-CodigoCaracteristica2');
        var txtCodigoTipo = $(this).attr('data-CodigoTipo');
        var txtCliente = $(this).attr('data-cliente');

        $.ajax({
            data: {
                "txtCodigoVariante": txtCodigoVariante,
                "txtCodigoArticulo": txtCodigoArticulo,
                "txtNombreArticulo": txtNombreArticulo,
                "txtCodigoCaracteristica1": txtCodigoCaracteristica1,
                "txtCodigoCaracteristica2": txtCodigoCaracteristica2,
                "txtCodigoTipo": txtCodigoTipo,
                "txtCliente": txtCliente
            },
            url: 'index.php?r=Autoventa/AjaxGetKitVirtual',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                $('#contMdlKitVirtual').html(response);
                $('#mdlKitVirtual').modal('show');
                iniBtnAdicionarProductoDetalleAct(false);
            }
        });

    });

}



///////////KIT DINAMICO////
$('.btnAdicionarKitDinamico').click(function() {

    var txtCodigoVariante = $(this).attr('data-CodigoVariante');
    var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
    var txtNombreArticulo = $(this).attr('data-NombreArticulo');
    var txtCodigoCaracteristica1 = $(this).attr('data-CodigoCaracteristica1');
    var txtCodigoCaracteristica2 = $(this).attr('data-CodigoCaracteristica2');
    var txtCodigoTipo = $(this).attr('data-CodigoTipo');
    var txtCliente = $(this).attr('data-cliente');

    $.ajax({
        data: {
            "txtCodigoVariante": txtCodigoVariante,
            "txtCodigoArticulo": txtCodigoArticulo,
            "txtNombreArticulo": txtNombreArticulo,
            "txtCodigoCaracteristica1": txtCodigoCaracteristica1,
            "txtCodigoCaracteristica2": txtCodigoCaracteristica2,
            "txtCodigoTipo": txtCodigoTipo,
            "txtCliente": txtCliente
        },
        url: 'index.php?r=Autoventa/AjaxGetKitComponente',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $('#contMdlKitDinamico').html(response);
            $('#mdlKitDinamico').modal('show');

            iniBtnAdicionarProductoDetalleAct(true);

        }
    });

});


function iniBtnAdicionarKitDinamico() {


    $('.btnAdicionarKitDinamico').click(function() {

        var txtCodigoVariante = $(this).attr('data-CodigoVariante');
        var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
        var txtNombreArticulo = $(this).attr('data-NombreArticulo');
        var txtCodigoCaracteristica1 = $(this).attr('data-CodigoCaracteristica1');
        var txtCodigoCaracteristica2 = $(this).attr('data-CodigoCaracteristica2');
        var txtCodigoTipo = $(this).attr('data-CodigoTipo');
        var txtCliente = $(this).attr('data-cliente');

        $.ajax({
            data: {
                "txtCodigoVariante": txtCodigoVariante,
                "txtCodigoArticulo": txtCodigoArticulo,
                "txtNombreArticulo": txtNombreArticulo,
                "txtCodigoCaracteristica1": txtCodigoCaracteristica1,
                "txtCodigoCaracteristica2": txtCodigoCaracteristica2,
                "txtCodigoTipo": txtCodigoTipo,
                "txtCliente": txtCliente
            },
            url: 'index.php?r=Autoventa/AjaxGetKitComponente',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                $('#contMdlKitDinamico').html(response);
                $('#mdlKitDinamico').modal('show');

                iniBtnAdicionarProductoDetalleAct(true);

            }
        });

    });


}


function validarKitDinamico() {

    var continuar = true;
    var cadena = "";

    var contRegulares = 0;
    var contObsequios = 0;

    var cantidadMaximaRegular;
    var cantidadMaximaObsequios;

    $('.txtCantidadItem').each(function() {

        var obligatorio = $(this).attr('data-obligatorio');
        var cantidadMinima = $(this).attr('data-can-minima');
        var caracteristica = $(this).attr('data-caracteristica');
        cantidadMaximaRegular = $(this).attr('data-cantidad-max-regulares');
        cantidadMaximaObsequios = $(this).attr('data-cantidad-max-obsequio');

        var dataRegular = $(this).attr('data-regulares');
        var dataObsequios = $(this).attr('data-obsequios');

        var cantidadItem = $(this).val();

        if (cantidadItem == "") {
            cantidadItem = 0;
            cantidadItem = parseInt(cantidadItem);
        }

        if (obligatorio == "1" && cantidadItem < cantidadMinima) {
            cadena += "La cantidad dÃ­gitada para el producto: " + caracteristica + " debe ser mayor o igual a la cantidad reglamentaria para el kit.<br/>";
            cadena += "Cantidad reglamentaria: " + cantidadMinima + "<br/><br/>";
            continuar = false;
        }



        if (dataRegular == "1") {
            contRegulares += parseInt(cantidadItem);
        } else if (dataObsequios == "1") {
            contObsequios += parseInt(cantidadItem);
        }

    });




    if (contRegulares != cantidadMaximaRegular) {
        cadena += "La suma de las cantidades para los productos regulares es diferente a la cantidad mÃ¡xima permitida para el kit<br/>";
        cadena += "Cantidad mÃ¡xima: " + cantidadMaximaRegular + "<br/><br/>";
        continuar = false;
    }

    if (contObsequios != cantidadMaximaObsequios) {
        cadena += "La suma de las cantidades para los obsequios es diferente a la cantidad mÃ¡xima permitida para el kit<br/>";
        cadena += "Cantidad mÃ¡xima: " + cantidadMaximaObsequios + "<br/><br/>";
        continuar = false;
    }

    if (!continuar) {
        $('#_alertaKitinamico .text-modal-body').html(cadena);
        $('#_alertaKitinamico').css("z-index", "15000");
        $('#_alertaKitinamico').modal('show');

        return false;
    }
    else
        return true;
    //return true;
}


function calculaTotalesPedido() {
    $.ajax({
        data: {
            'saldoCupo': $('#txtSaldoCupo').val(),
        },
        url: 'index.php?r=Autoventa/AjaxTotalesPedido',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $('#totalesCalculados').html(response);


        }
    });
}

function actualizaPortafolioAgregar() {

    $.ajax({
        url: 'index.php?r=Autoventa/AjaxActualizaPortafolioAgregar',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            var obj = jQuery.parseJSON(response);

            var table = $('#tblPortafolio').dataTable();


            var filtro = $('#tblPortafolio_filter input').val();

            table.fnFilterClear();


            $('.btnAdicionarProductoDetalleAct').each(function() {
                var variante = $(this).attr('data-codigovariante');

                if ($(this).attr('data-nuevo') == 0) {
                    if ($(this).attr('data-block') != "1") {
                        $('.imagen-producto-' + variante).attr('src', 'images/pro.png');
                    } else {
                        $('.imagen-producto-' + variante).attr('src', 'images/pro_inactive.png');
                    }
                } else {
                    $('.imagen-producto-' + variante).attr('src', 'images/pronuevo.png');
                }
                $('.imagen-producto-' + variante).attr('src', 'images/pro.png');

            });
            $.each(obj, function(idx, obj) {
                $('.imagen-producto-' + obj).attr('src', 'images/aceptar.png');

            });

            table.fnFilter(filtro);


        }
    });

}


function iniActualizarProductos() {

    $('.actulizarPortafolio').click(function() {
        var variante = $(this).attr('data-variante');


        $(".btnAdicionarProductoDetalle").each(function(index) {
            var variantePortafolio = $(this).attr('data-codigo-variante');
            if (variantePortafolio == variante) {

                var codigoVariante = $(this).attr('data-codigo-variante');
                var cliente = $(this).attr('data-cliente');
                var articulo = $(this).attr('data-articulo');
                var grupoVentas = $(this).attr('data-grupo-ventas');
                var zonaventas = $(this).attr('data-zona');
                var sitio = $('#select-sitio').attr('data-codigo');
                var codigoUnidadSaldo = $(this).attr('data-articulo');
                var idSaldoInventario = $(this).attr('data-id-inventario');
                var codigoUnidadSaldoInventario = $(this).attr('data-codigounidadmedida-saldo');
                var codigoTipo = $(this).attr('data-codigo-tipo');
                var nombre = $(this).attr('data-nombre');


                $.ajax({
                    data: {
                        "codigoVariante": codigoVariante,
                        "cliente": cliente,
                        "zonaventas": zonaventas
                    },
                    url: 'index.php?r=Autoventa/AjaxAcuerdoComercialVenta',
                    type: 'post',
                    beforeSend: function() {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function(response) {

                        if (response == 0) {
                            $('#alertaArticuloSinAcuerdo').modal('show');
                        } else {

                            var acuerdo = jQuery.parseJSON(response);
                            var CodigoUnidadMedida = acuerdo.CodigoUnidadMedida;
                            var NombreUnidadMedida = acuerdo.NombreUnidadMedida;
                            var PrecioVenta = acuerdo.PrecioVenta;

                            $('#textDetCodigoUnidadMedida').val(CodigoUnidadMedida);

                            $.ajax({
                                data: {
                                    "codigoVariante": codigoVariante,
                                    "cliente": cliente,
                                    "CodigoUnidadMedida": CodigoUnidadMedida,
                                    "articulo": articulo,
                                    "zonaventas": zonaventas
                                },
                                url: 'index.php?r=Autoventa/AjaxACDL',
                                type: 'post',
                                beforeSend: function() {
                                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                },
                                success: function(response) {

                                    if (response == 0) {

                                        $('#txtSaldoLimite').val('');
                                        $('#txtSaldoACDL').val('0');
                                        $('#txtSaldoACDLSinConversion').val('');
                                        $('#txtIdAcuerdo').val('');
                                        $('#txtCodigoUnidadMedidaACDL').val('0');
                                        $('#txtPorcentajeDescuentoLinea1ACDL').val('0');
                                        $('#txtPorcentajeDescuentoLinea2ACDL').val('0');
                                        $('#txtDescuentoProveedorPreventa').val('0');
                                        $('#txtCodigoArticulo').val(articulo);
                                        $('#txtIdSaldoInventario').val(idSaldoInventario);
                                        $('#txtCodigoUnidadSaldoInventario').val(codigoUnidadSaldoInventario);
                                        $('#lblUnidadMedidaSaldoLimite').html('');
                                    } else {

                                        var acdl = jQuery.parseJSON(response);
                                        $('#txtSaldoLimite').val(acdl.Saldo);
                                        $('#txtSaldoACDL').val(acdl.Saldo);
                                        $('#txtSaldoACDLSinConversion').val(acdl.SaldoSinConversion);
                                        $('#txtIdAcuerdo').val(acdl.IdAcuerdo);
                                        $('#txtCodigoUnidadMedidaACDL').val(acdl.CodigoUnidadMedida);
                                        $('#txtPorcentajeDescuentoLinea1ACDL').val(acdl.PorcentajeDescuentoLinea1);
                                        $('#txtPorcentajeDescuentoLinea2ACDL').val(acdl.PorcentajeDescuentoLinea2);
                                        $('#txtDescuentoProveedorPreventa').val(parseFloat(acdl.PorcentajeDescuentoLinea1) + parseFloat(acdl.PorcentajeDescuentoLinea2));
                                        $('#txtCodigoArticulo').val(articulo);
                                        $('#txtIdSaldoInventario').val(idSaldoInventario);
                                        $('#txtCodigoUnidadSaldoInventario').val(codigoUnidadSaldoInventario);
                                        $('#lblUnidadMedidaSaldoLimite').html(acdl.NombreUnidadMedidaSaldoLimite);

                                    }

                                    alert(grupoVentas);

                                    $.ajax({
                                        data: {
                                            "grupoVentas": grupoVentas,
                                            "codigoVariante": codigoVariante,
                                            "articulo": articulo,
                                            "cliente": cliente,
                                            "CodigoUnidadMedida": CodigoUnidadMedida
                                        },
                                        url: 'index.php?r=Autoventa/AjaxDetalleArticulo',
                                        type: 'post',
                                        beforeSend: function() {
                                            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                        },
                                        success: function(response) {

                                            var detalleProducto = jQuery.parseJSON(response);

                                            if (detalleProducto.SaldoInventarioPreventa <= 0 && detalleProducto.CodigoTipoKit != "KV" && detalleProducto.CodigoTipoKit != "KD") {
                                                $('#alertaArticuloSinSaldo').modal('show');
                                                return;
                                            } else {

                                                var nombreCompleto = detalleProducto.NombreArticulo + ' ';
                                                if (detalleProducto.CodigoCaracteristica1 != null) {
                                                    nombreCompleto += detalleProducto.CodigoCaracteristica1 + ' ';
                                                }

                                                if (detalleProducto.CodigoCaracteristica2 != null) {
                                                    nombreCompleto += detalleProducto.CodigoCaracteristica2 + ' ';
                                                }
                                                if (detalleProducto.CodigoTipo != null) {
                                                    nombreCompleto += '(' + detalleProducto.CodigoTipo + ')';
                                                }

                                                $.ajax({
                                                    data: {
                                                        'variante': detalleProducto.CodigoVariante,
                                                    },
                                                    url: 'index.php?r=Autoventa/AjaxValidarItemPedido',
                                                    type: 'post',
                                                    beforeSend: function() {
                                                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                                    },
                                                    success: function(itemProdutoAgregado) {

                                                        $("#select-especial").val();
                                                        $('#div-descuento-especial').html('');

                                                        if (itemProdutoAgregado != "") {

                                                            var itemAgregado = jQuery.parseJSON(itemProdutoAgregado);

                                                            var CantidadPedida1 = itemAgregado.cantidad;
                                                            var DescuentoProveedor1 = itemAgregado.descuentoProveedor;

                                                            $('#txtCantidadPedida').val(CantidadPedida1);
                                                            $('#txtDescuentoProveedorPreventa').val(DescuentoProveedor1);

                                                            $('#txtDescuentoAltipal').val(itemAgregado.descuentoAltipal);
                                                            $('#txtDescuentoEspecialPreventa').val(itemAgregado.descuentoEspecial);

                                                            if (itemAgregado.descuentoEspecialSelect != null) {
                                                                $("#select-especial").val(itemAgregado.descuentoEspecialSelect);
                                                            }

                                                            var cadena = '';
                                                            $('#div-descuento-especial').html('');
                                                            if (itemAgregado.descuentoEspecialSelect == "Compartidos") {
                                                                cadena += "<input type='text' name='name' value='" + itemAgregado.descuentoEspecialProveedor + "' id='txtDescuentoEspecialProveedor' placeholder='Proveedor'  min='0' max='100' class='form-control'/><br/>";
                                                                cadena += "<input type='text' name='name' value='" + itemAgregado.descuentoEspecialAltipal + "' id='txtDescuentoEspecialAltipal' placeholder='Altipal' min='0' max='100' class='form-control'/><br/>";
                                                                $('#div-descuento-especial').append(cadena);
                                                            }

                                                        }
                                                    }
                                                });

                                                $('#textDetNombreProducto').html(nombreCompleto);
                                                $('#textDetCodigoProducto').html(detalleProducto.CodigoVariante);
                                                $('#textCodigoVariante').val(detalleProducto.CodigoVariante);
                                                $('#txtCodigoTipo').val(codigoTipo);
                                                $('#textDetUnidadMedida').val(NombreUnidadMedida);
                                                $('#textDetSaldo').val(detalleProducto.SaldoInventarioPreventa);
                                                $('#lblUnidadMedidaSaldo').html(detalleProducto.NombreUnidadMedidaSaldo);
                                                $('#textDetIva').val(detalleProducto.PorcentajedeIVA);
                                                $('#textDetImpoconsumo').val(detalleProducto.ValorIMPOCONSUMO);


                                                if (detalleProducto.CodigoTipoKit == "KV") {

                                                    calcularSaldoKitVirtual(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida);


                                                    $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                                    $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));


                                                } else if (detalleProducto.CodigoTipoKit == "KD") {

                                                    calcularSaldoKitDinamico(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida, nombre);

                                                    $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                                    $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));
                                                    return false;
                                                } else {

                                                    $('#textDetValorProducto').val(PrecioVenta);
                                                    $('#textDetValorProductoMostrar').val(parseFloat(PrecioVenta) + parseFloat(detalleProducto.ValorIMPOCONSUMO));

                                                }

                                                if ($('#textDetSaldo').val() == "") {
                                                    $('#alertaErrorValidar #mensaje-error').html('No existe saldo disponible para algÃºn componente del Kit.');
                                                    $('#alertaErrorValidar').modal('show');
                                                    return false;
                                                } else {
                                                    $('#articuloPedido').modal('show');
                                                    iniValidarCantidad();
                                                }
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    }
                });

            }
        });



    });
}


function calcularSaldoKitVirtual(codigoListaMateriales, codigoArticuloKit, codigoUnidadMedida, cuentaCliente) {

    $.ajax({
        data: {
            'codigoListaMateriales': codigoListaMateriales,
            'codigoArticuloKit': codigoArticuloKit,
            'cuentaCliente': cuentaCliente,
            'codigoUnidadMedida': codigoUnidadMedida
        },
        url: 'index.php?r=Autoventa/AjaxCalcularSaldoKitVirtual',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            var saldoKit = jQuery.parseJSON(response);
            $('#textDetSaldo').val(saldoKit.saldo);

        }
    });

}


function calcularSaldoKitDinamico(codigoListaMateriales, codigoArticuloKit, codigoUnidadMedida, nombre) {

    $.ajax({
        data: {
            'codigoListaMateriales': codigoListaMateriales,
            'codigoArticuloKit': codigoArticuloKit,
            'codigoUnidadMedida': codigoUnidadMedida
        },
        url: 'index.php?r=Autoventa/AjaxCalcularSaldoKitDinamico',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            var arraykit = jQuery.parseJSON(response);

            $('#textDetSaldo').val(arraykit.saldo);
            var detalleComponentes = arraykit.detalle;
            var mdlBodyContent = "";
            var conCheck = 0;

            jQuery.ajax({
                url: "index.php?r=Preventa/AjaxComponentesKitDinamico",
                type: 'post',
                async: false,
                contentType: "application/json",
                data: response,
                success: function(data, textStatus, jqXHR) {
                    $("#tltComponentesArticulo").html(codigoArticuloKit);

                    $("#ctdComponentesArticulo").html(data);
                    $('#mdlComponentesArticulo').modal('show');
                    $('#btnCargarDetalleArticulo').click(function() {


                        if (iniValidarKit()) {

                            var contKit = 0;
                            $('.kitDetalleFijo').each(function() {

                                var txtCodigoArticuloKit = $(this).attr('data-codigo-articulo-kit');
                                var txtUnidadKit = $(this).attr('data-unidad');
                                var txtTipo = $(this).attr('data-tipo');
                                var txtCodigoLista = $(this).attr('data-codigo-lista');
                                var txtCodigoArticulo = $(this).attr('data-codigo-articulo');
                                var txtCantidadItemFijo = $('#txtKitFijo-' + contKit).val();
                                var txtCantidadItemOpcional = $('#txtKitOpcional-' + contKit).val();
                                var txtMinimoKitFijo = $('#txtKitFijo-' + contKit).attr('data-minimo');
                                var txtMinimoKitOpcional = $('#txtKitOpcional-' + contKit).attr('data-minimo');
                                var txtNombreKit = $(this).attr('data-nombre');

                                $.ajax({
                                    data: {
                                        "txtCodigoArticuloKit": txtCodigoArticuloKit,
                                        "txtUnidadKit": txtUnidadKit,
                                        "txtTipo": txtTipo,
                                        "txtCodigoLista": txtCodigoLista,
                                        "txtCodigoArticulo": txtCodigoArticulo,
                                        "txtCantidadItemFijo": txtCantidadItemFijo,
                                        "txtCantidadItemOpcional": txtCantidadItemOpcional,
                                        "txtMinimoKitFijo": txtMinimoKitFijo,
                                        "txtMinimoKitOpcional": txtMinimoKitOpcional,
                                        "txtNombreKit": txtNombreKit
                                    },
                                    url: 'index.php?r=Preventa/AjaxGuardarKitDinamico',
                                    type: 'post',
                                    async: false,
                                    success: function(response) {


                                    }
                                });
                                contKit++;
                            });

                            $('#mdlComponentesArticulo').modal('hide');
                            $('#articuloPedido').modal('show');
                            iniValidarCantidad();
                            return false;
                        }

                        return false;
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                },
            });
        }
    });

}


function iniValidarKit() {

    var cantidadFijo = 0;
    var cantidadOpcional = 0;
    var totalKitFijo = parseInt($('#totalKitFijo').text());
    var totalKitOpcional = parseInt($('#totalKitOpcional').text());
    var continuar = true;

    $('.kitDetalleFijo').keypress(function(tecla) {
        var ev = (tecla.which) ? tecla.which : tecla.keyCode;
        if ((tecla.keyCode != 9) && (tecla.keyCode != 8) && (tecla.keyCode != 127))
        {
            return (ev < 48 || ev > 57) ? false : true;
        }

    });

    $('.totalKitOpcional').keypress(function(tecla) {
        var ev = (tecla.which) ? tecla.which : tecla.keyCode;
        if ((tecla.keyCode != 9) && (tecla.keyCode != 8) && (tecla.keyCode != 127))
        {
            return (ev < 48 || ev > 57) ? false : true;
        }

    });

    var validar = false;

    $('.kitDetalleFijo').each(function() {

        if ($(this).val() != "") {
            cantidadFijo = cantidadFijo + parseInt($(this).val());
        }
    });

    $('.kitDetalleOpcional').each(function() {
        if ($(this).val() != "") {
            cantidadOpcional = cantidadOpcional + parseInt($(this).val());
        }
    });

    /*$('.kitDetalleFijo').each(function(){   
     if($(this).attr('data-obligatorio')=="1"){                
     if( $(this).val()=="" ){  
     
     alert();
     
     $("#_alerta").css("z-index", "15000");
     $('#_alerta .text-modal-body').html('Falta un campo Obligatorio...');
     $('#_alerta').modal('show');
     
     validar=true;                
     return false; 
     
     }
     }
     });*/



    $('.kitDetalleFijo').each(function() {
        if (($(this).val() == "" && $(this).attr('data-obligatorio') == "1") || (parseInt($(this).val()) < 1 && $(this).attr('data-obligatorio') == "1")) {
            var nombreProdutoKit = $(this).attr('data-nombre');

            $("#_alerta").css("z-index", "15000");
            $('#_alerta .text-modal-body').html('El producto <b>' + nombreProdutoKit + '</b> es obligario ingresar una cantidad en el kit</b>');
            $('#_alerta').modal('show');
            validar = true;
            continuar = false;
            return false;
        }
    });

    if (!continuar) {
        return false;
    }

    $('.kitDetalleOpcional').each(function() {
        if (($(this).val() == "" && $(this).attr('data-obligatorio') == "1") || (parseInt($(this).val()) < 1 && $(this).attr('data-obligatorio') == "1")) {
            var nombreProdutoKit = $(this).attr('data-nombre');
            $("#_alerta").css("z-index", "15000");
            $('#_alerta .text-modal-body').html('El producto <b>' + nombreProdutoKit + '</b> es obligario ingresar una cantidad en el kit</b>');
            $('#_alerta').modal('show');
            validar = true;
            continuar = false;
            return false;
        }
    });

    if (!continuar) {
        return false;
    }

    if (totalKitFijo != cantidadFijo) {
        $("#_alerta").css("z-index", "15000");
        $('#_alerta .text-modal-body').html('La cantidad de productos Fijos No cumple con el Total del Kit: <b>' + cantidadFijo + '</b> de <b>' + totalKitFijo + '</b>');
        $('#_alerta').modal('show');
        validar = true;
        continuar = false;
        return false;
    }

    if (!continuar) {
        return false;
    }

    if (totalKitOpcional != cantidadOpcional) {
        $("#_alerta").css("z-index", "15000");
        $('#_alerta .text-modal-body').html('La cantidad de productos Opcionales No cumple con el Total del Kit: <b>' + cantidadOpcional + '</b> de <b>' + totalKitOpcional + '</b>');
        $('#_alerta').modal('show');
        validar = true;
        continuar = false;
        return false;
    }
    if (!continuar) {
        return false;
    }

    $('.kitDetalleFijo').each(function() {
        if ($(this).val() != "") {
            var valorMinimo = $(this).attr('data-minimo');
            var nombreProdutoKit = $(this).attr('data-nombre');
            if (parseInt($(this).val()) < valorMinimo) {
                $("#_alerta").css("z-index", "15000");
                $('#_alerta .text-modal-body').html('La cantidad Fija para <b>' + nombreProdutoKit + '</b> no cumple con la cantidad minima de <b>' + valorMinimo + '</b>');
                $('#_alerta').modal('show');
                validar = true;
                continuar = false;
                return false;
            }
        }
    });

    if (!continuar) {
        return false;
    }

    $('.kitDetalleOpcional').each(function() {
        if ($(this).val() != "") {
            var valorMinimo = $(this).attr('data-minimo');
            var nombreProdutoKit = $(this).attr('data-nombre');
            if (parseInt($(this).val()) < valorMinimo) {
                $("#_alerta").css("z-index", "15000");
                $('#_alerta .text-modal-body').html('La cantidad Opcional para <b>' + nombreProdutoKit + '</b> no cumple con la cantidad minima de <b>' + valorMinimo + '</b>');
                $('#_alerta').modal('show');
                validar = true;
                continuar = false;
                return false;
            }
        }
    });

    if (!continuar) {
        return false;
    }

    if (!validar) {
        return true;
    }

}


///////cargar lote////

function cargarlote() {

    $("#txtLote").change(function() {

        var lote = $("#txtLote").val();
        var ubicacion = $(".txtubicacion").val();
        var variante = $(".textDetCodigoProducto").val();

        $.ajax({
            data: {
                "lote": lote,
                "ubicacion": ubicacion,
                "variante": variante
            },
            url: 'index.php?r=Autoventa/AjaxCargarSaldoLote',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                $('.saldo').empty();
                $('.saldo').html('<input type="text" name="name" readonly="readonly" class="form-control textDetSaldo"  value=' + response + '>');
            }
        });


    });

}












////////////////////////////////////////////////CODIGO VIEJO DE AUTOVENTA //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////CODIGO VIEJO DE AUTOVENTA //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////CODIGO VIEJO DE AUTOVENTA //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////CODIGO VIEJO DE AUTOVENTA //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////CODIGO VIEJO DE AUTOVENTA //////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////CODIGO VIEJO DE AUTOVENTA //////////////////////////////////////////////////////////////////////////
var codigoVariante;
var cliente;
var articulo;
var grupoVentas;
var zonaventas;
var sitio;
var codigoUnidadSaldo;
var idSaldoInventario;
var codigoUnidadSaldoInventario;
var codigoTipo;




$("#factura").blur(function() {

    var factura = $('#factura').val();
    //alert("entro al BLUR" + factura);

    $.ajax({
        data: {
            'factura': factura
        },
        url: 'index.php?r=Autoventa/AjaxValidarFactura',
        type: 'post',
        async: false, 
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            if (response > 0 && factura != "") {

                $('#_alerta .text-modal-body').html('El numero de factura digitado ya se encuentra registrado, o se encuentra fuera del rango');
                $('#_alerta').modal('show');
              // alert("El numero de factura digitado ya se encuentra registrado, o se encuentra fuera del rango: " + factura);
                $('#factura').val('');

                return false;
            }

        }
    });
});


function validarResolucionEscrita() {
    var factura = $('#factura').val();
    //alert("entro al BLUR" + factura);
    dfd = $.Deferred();

    $.ajax({
        data: {
            'factura': factura
        },
        url: 'index.php?r=Autoventa/AjaxValidarFactura',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            if (response > 0 && factura != "") {

                dfd.resolve(false);
                /*$('#_alerta .text-modal-body').html('El numero de factura digitado ya se encuentra registrado, o se encuentra fuera del rango');
                $('#_alerta').modal('show');
              // alert("El numero de factura digitado ya se encuentra registrado, o se encuentra fuera del rango: " + factura);
                $('#factura').val('');*/
            }else{
                dfd.resolve(true);
            }
        }
    });
    return dfd.promise();
}


$('#btn-aceptar-ACDL').click(function() {


    var codigoVariante = $('#textDetCodigoProducto').text();
    var descripcion = $('#textDetNombreProducto').text();
    var textDetIva = $('#textDetIva').val();
    var textDetSaldo = $('#textDetSaldo').val();
    var txtLoteArticulo = $('#txtLoteArticulo ').find("option:selected").text();
    var textVariante = $('#textCodigoVariante').val();
    var textDetValorProducto = $('#textDetValorProducto').val();
    var textDetImpoconsumo = $('#textDetImpoconsumo').val();
    var txtCantidadPedida = $('#txtCantidadPedida').val();
    var txtSaldoLimite = $('#txtSaldoLimite').val();
    var txtDescuentoProveedor = $('#txtDescuentoProveedor').val();
    var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
    var txtDescuentoEspecial = $('#txtDescuentoEspecialAutoventa').val();
    var txtSaldoACDL = $('#txtSaldoACDL').val();
    var txtCodigoUnidadMedidaACDL = $('#txtCodigoUnidadMedidaACDL').val();
    var txtCantidadPedida = $('#txtCantidadPedida').val();
    var txtDescuentoEspecialSelect = $('#select-especial').val();
    var txtDescuentoEspecialProveedor = $('#txtDescuentoEspecialProveedor').val();
    var txtDescuentoEspecialAltipal = $('#txtDescuentoEspecialAltipal').val();
    var textDetCodigoUnidadMedida = $('#textDetCodigoUnidadMedida').val();
    var txtCodigoArticulo = $('#txtCodigoArticulo').val();
    var txtSaldoACDLSinConversion = $('#txtSaldoACDLSinConversion').val();
    var txtIdAcuerdo = $('#txtIdAcuerdo').val();
    var txtIdSaldoInventario = $('#txtIdSaldoInventario').val();
    var txtCodigoUnidadSaldoInventario = $('#txtCodigoUnidadSaldoInventario').val();
    var txtCodigoTipo = $('#txtCodigoTipo').val();
    var txtCuentaProveedor = $('#txtCuentaProveedor').val();


    $('#alertaACDLCantidad').modal('hide');

    $.ajax({
        data: {
            "nombreProducto": descripcion,
            'codigoTipo': txtCodigoTipo,
            'codigoArticulo': txtCodigoArticulo,
            "idSaldoInventario": txtIdSaldoInventario,
            "codigoUnidadSaldoInventario": txtCodigoUnidadSaldoInventario,
            "variante": textVariante,
            "txtLoteArticulo": txtLoteArticulo,
            "codigoUnidadMedida": textDetCodigoUnidadMedida,
            "valorUnitario": textDetValorProducto,
            "impoconsumo": textDetImpoconsumo,
            "cantidad": txtCantidadPedida,
            "saldo": textDetSaldo,
            "saldoLimite": txtSaldoLimite,
            "codigoUnidadMedidaACDL": txtCodigoUnidadMedidaACDL,
            "saldoACDLSinConversion": txtSaldoACDLSinConversion,
            "idAcuerdo": txtIdAcuerdo,
            "descuentoProveedor": txtDescuentoProveedor,
            "descuentoAltipal": txtDescuentoAltipal,
            "descuentoEspecial": txtDescuentoEspecial,
            "iva": textDetIva,
            "descuentoEspecialSelect": txtDescuentoEspecialSelect,
            "descuentoEspecialProveedor": txtDescuentoEspecialProveedor,
            "descuentoEspecialAltipal": txtDescuentoEspecialAltipal,
            "cuentaProveedor": txtCuentaProveedor,
            "aplicaImpoconsumo": true

        },
        url: 'index.php?r=Autoventa/AjaxAgregarItemPedido',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            $('#tableDetail').html(response);
            calculaTotalesPedido();
            actualizaPortafolioAgregar();
            iniActualizarProductos();

            $('#articuloPedido').modal('hide');

            $('.delete-item-pedido').click(function() {
                var variante = $(this).attr('data-variante');
                $.ajax({
                    data: {
                        "variante": variante,
                    },
                    url: 'index.php?r=Autoventa/AjaxEliminarItemPedido',
                    type: 'post',
                    beforeSend: function() {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function(response) {

                        $('#tableDetail').html(response);
                        cambiarIconos();
                        calculaTotalesPedido();
                        actualizaPortafolioAgregar();
                        iniActualizarProductos();


                        $('.delete-item-pedido').click(function() {
                            var variante = $(this).attr('data-variante');
                            $.ajax({
                                data: {
                                    "variante": variante,
                                },
                                url: 'index.php?r=Autoventa/AjaxEliminarItemPedido',
                                type: 'post',
                                beforeSend: function() {
                                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                },
                                success: function(response) {

                                    $('#tableDetail').html(response);
                                    cambiarIconos();
                                    calculaTotalesPedido();
                                    actualizaPortafolioAgregar();
                                    iniActualizarProductos();

                                }
                            });
                        });

                    }
                });
            });

        }
    });

});

$('#btn-cancelar-ACDL').click(function() {
    $('#alertaACDLCantidad').modal('hide');
    $('#txtCantidadPedida').focus();
});

$("#frmPedidoAutoventa").submit(function() {

    var cantidadProductos = $('#cantidad-enviar').val();
    var txtTotalPedido = $('#txtTotalPedido').val();
    var txtTotalPedidoCupo = $('#txtTotalPedido').val();
    
    var txtSaldoCupo = $('#txtSaldoCupo').val();
    var formaPago = $('#formaPagoAutoventa').val();
    var valorMinimo = $('#txtValorMinimo').val();
    var sitios = $("#sitios").val();
    var TotalPedidoAnterior = $("#TotalPedidoAnterior").val();
     var Operacion = "";
    
    
    if (parseFloat(TotalPedidoAnterior) > '0') {


        Operacion = parseFloat(txtTotalPedido) + parseFloat(TotalPedidoAnterior);

        txtTotalPedido = Operacion;
    }


    if (sitios == 2) {

        if ($("#pedidosenviado").val() == 0) {

            if (parseFloat(valorMinimo) != "" || parseFloat(valorMinimo) != "0") {
                if (parseFloat(txtTotalPedido) < parseFloat(valorMinimo)) {
                    $('#alertaErrorValidarSitio #mensaje-error').html("El monto mÃ­nimo del pedido no cumple para su despacho. Valor pedido mÃ­nimo: " + valorMinimo + "<br><br>" + "Desea hacer un nuevo pedido para otro sitio y cumplir con el valor total del pedido mÃ­nimo");
                    $('#alertaErrorValidarSitio').modal('show');
                    return false;
                }
            }
        }

    }else{
        
         if ($("#pedidosenviado").val() == 0) {

            if (parseFloat(valorMinimo) != "" || parseFloat(valorMinimo) != "0") {
                if (parseFloat(txtTotalPedido) < parseFloat(valorMinimo)) {
                    $('#alertaErrorValidar #mensaje-error').html("El valor del pedido debe superar el valor minimo: " + valorMinimo);
                    $('#alertaErrorValidar').modal('show');
                    return false;
                }
            }

        }
        
    }

    if (typeof cantidadProductos === "undefined") {
        cantidadProductos = 0;
    }

   
    if (cantidadProductos <= 0) {

        $('#alertaErrorValidar #mensaje-error').html("No se han adicionado productos al pedido");
        $('#alertaErrorValidar').modal('show');
        return false;

    } else if (formaPago == "credito" && parseFloat(txtTotalPedidoCupo) > parseFloat(txtSaldoCupo)) {


        $('#alertaErrorValidar #mensaje-error').html("El valor del pedido supera el cupo credito del cliente. Si desea enviar el pedido la forma de Pago debe ser Contado.");
        $('#alertaErrorValidar').modal('show');
        return false;

    } else {
        return true;
    }


});


$('#txtCantidadPedida').keyup(function() {

    var cantidadPedida = $(this).val();
    var valorProducto = $('#textDetValorProducto').val();
    var saldoLimite = $('#txtSaldoLimite').val();
    var unidadMedida = $('#textDetCodigoUnidadMedida').val();
    var codigoVariante = $('#textDetCodigoProducto').text();
    var articulo = $('#txtCodigoArticulo').val();


    if (saldoLimite == 0) {

        $.ajax({
            data: {
                "cantidadPedida": cantidadPedida,
                "codigoVariante": codigoVariante,
                "articulo": articulo,
                "unidadMedida": unidadMedida,
                "cliente": cliente,
                "grupoVentas": grupoVentas,
                "zonaventas": zonaventas,
                "sitio": sitio
            },
            url: 'index.php?r=Pedido/AjaxACDLCantidades',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                if (response == 0) {
                    $('#txtDescuentoProveedorAutoventa').val('0');

                } else {

                    var datos = jQuery.parseJSON(response);

                    var descuento1 = 0;
                    var descuento2 = 0;

                    if (datos.PorcentajeDescuentoLinea1) {
                        descuento1 = datos.PorcentajeDescuentoLinea1;
                    }
                    if (datos.PorcentajeDescuentoLinea2) {
                        descuento2 = datos.PorcentajeDescuentoLinea2;
                    }
                    var descuento = parseFloat(descuento1) + parseFloat(descuento2);

                    $('#txtDescuentoProveedorAutoventa').val(descuento);

                }

            }
        });

    }

    $.ajax({
        data: {
            "cantidadPedida": cantidadPedida,
            "codigoVariante": codigoVariante,
            "unidadMedida": unidadMedida,
            "articulo": articulo,
            "cliente": cliente,
            "grupoVentas": grupoVentas,
            "zonaventas": zonaventas,
            "sitio": sitio
        },
        url: 'index.php?r=Pedido/AjaxACDM',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            if (response == 0) {
                $('#txtDescuentoAltipal').val('0');

            } else {

                var datos = jQuery.parseJSON(response);
                var descuento1 = 0;
                var descuento2 = 0;

                if (datos.PorcentajeDescuentoMultilinea1) {
                    descuento1 = datos.PorcentajeDescuentoMultilinea1;
                }
                if (datos.PorcentajeDescuentoMultilinea2) {
                    descuento2 = datos.PorcentajeDescuentoMultilinea2;
                }
                var descuento = parseFloat(descuento1) + parseFloat(descuento2);
                $('#txtDescuentoAltipal').val(descuento);

            }

        }
    });


});


function cambiarIconos() {

    var table = $('#tablePortafolioProveedores').dataTable();
    var filtro = $('#tablePortafolioProveedores_filter input').val();
    table.fnFilterClear();

    $('.adicionar-producto-detalle-autoventa').each(function() {
        var variante = $(this).attr('data-codigo-variante');

        if ($(this).attr('data-nuevo') == 0) {
            $('.imagen-producto-' + variante).attr('src', 'images/pro.png');
        } else {
            $('.imagen-producto-' + variante).attr('src', 'images/pronuevo.png');
        }

    });

    table.fnFilter(filtro);
}

function limpiarCampos() {



    $('#textDetSaldo').val('');
    $('#textCodigoVariante').val('');
    $('#textDetValorProducto').val('');
    $('#textDetImpoconsumo').val('');
    $('#txtCantidadPedida').val('');
    $('#txtSaldoLimite').val('');
    $('#txtDescuentoProveedor').val('');
    $('#txtDescuentoAltipal').val('');
    $('#txtDescuentoEspecialAutoventa').val('');
    $('#txtSaldoACDL').val('');
    $('#txtCodigoUnidadMedidaACDL').val('');
    $('#txtCantidadPedida').val('');
    $('#select-especial').val('');
    $('#txtDescuentoEspecialProveedor').val('');
    $('#txtDescuentoEspecialAltipal').val('');
    $('#textDetCodigoUnidadMedida').val('');
    $('#txtCodigoArticulo').val('');
    $('#txtSaldoACDLSinConversion').val('');
    $('#txtIdAcuerdo').val('');
    $('#txtIdSaldoInventario').val('');
    $('#txtCodigoUnidadSaldoInventario').val('');






}


$('#tblPortafolio').DataTable({
    "bDestroy": true,
    "sPaginationType": "full_numbers", 
});



function getLocation() {

    if (navigator.geolocation) {
        //setTimeout(function(){ location.reload() }, 15000);

        navigator.geolocation.getCurrentPosition(
                function(pos)
                {
                    var lat = pos.coords.latitude;
                    var lng = pos.coords.longitude;


                    $("#latitud").val(lat);
                    $("#longitud").val(lng);


                }
        );

    } else {

        getLocation();
        setTimeout(getLocation(), 50);
    }

}

$("#RdOtropedido").click(function() {

    ////PARAMETROS DEL ENCABEZADO 

    var zona = $("#zonaVentas").val();
    var hora = $("#horaDigitada").val();
    var cuentaCliente = $("#cuentaCliente").val();
    var codGrupoImpuesto = $("#codGrupoImpuesto").val();
    var codZonaLogistica = $("#codZonaLogistica").val();
    var txtCedulAasesor = $("#txtCedulAasesor").val();
    var latitud = $("#latitud").val();
    var longitud = $("#longitud").val();
    var sitio = $("#sitioActual").val();
    var almacen = $("#almacen").val();
    var fechaentrega = $("#fechaentrega").val();
    var formaPagoAutoventa = $("#formaPagoAutoventa").val();
    var plazo = $("#plazo").val();
    var tipoventa = $("#select-tipo-venta-autoventa").val();
    var selactividadEspecial = $("#selactividadEspecial").val();
    var Observaciones = $("#txtAreaObservaciones").val();
    var SaldoCupo = $("#txtSaldoCupo").val();
    var factura = $("#factura").val();

    ///PARAMETROS DE LOS TOTALES

    var precioneto = $("#txtPrecioNeto").val();
    var descuentopro = $("#txtDescuentoProveedor").val();
    var descuentoalti = $("#txtDescuentoAltipal").val();
    var descuentoespecial = $("#txtDescuentoEspecial").val();
    var valortotaldescuento = $("#txtValorTotalDescuento").val();
    var impoconsumo = $("#txtImpoconsumo").val();
    var baseiva = $("#txtBaseIva").val();
    var iva = $("#txtIva").val();
    var totalpedido = $("#txtTotalPedido").val();
    alert(plazo);



    $.ajax({
        data: {
            "zona": zona,
            "hora": hora,
            "cuentaCliente": cuentaCliente,
            "codGrupoImpuesto": codGrupoImpuesto,
            "codZonaLogistica": codZonaLogistica,
            "codAasesor": txtCedulAasesor,
            "latitud": latitud,
            "longitud": longitud,
            "codigositio": sitio,
            "codigoAlmacen": almacen,
            "fechaentrega": fechaentrega,
            "formaPago": formaPagoAutoventa,
            "plazo": plazo,
            "tipoVenta": tipoventa,
            "selactividadEspecial": selactividadEspecial,
            "Observaciones": Observaciones,
            "SaldoCupo": SaldoCupo,
            "precioneto": precioneto,
            "descuentopro": descuentopro,
            "descuentoalti": descuentoalti,
            "descuentoespecial": descuentoespecial,
            "valortotaldescuento": valortotaldescuento,
            "impoconsumo": impoconsumo,
            "baseiva": baseiva,
            "iva": iva,
            "totalpedido": totalpedido,
            "factura":factura
        },
        url: 'index.php?r=Autoventa/AjaxPedidoMinimo',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {

            window.location.href = "index.php?r=Clientes/menuClientes&cliente=" + cuentaCliente + "&zonaVentas=" + zona;

        }
    });


});


function credito(aplicacontado) {

    var formpago = $("#formaPagoAutoventa").val();

    if (aplicacontado == 'falso' && formpago == 'credito') {
 
        var cupodisponible = $("#cupodisponiblehiden").val();
        $("#cupodisponible").val(cupodisponible);

    } else {

        $("#cupodisponible").val('0');

    }

}






 