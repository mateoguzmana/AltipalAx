
jQuery(document).ready(function() {

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


    var baseRutaTransferencia = $('body').attr('data-ruta');
    limparFrmRegistrarCliente();

    jQuery('#table1').dataTable({
        "sPaginationType": "full_numbers",
    });

    /*jQuery('#tableDetail').dataTable({
     "sPaginationType": "full_numbers",            
     });*/

    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: 'Previo',
        nextText: 'Próximo',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
            'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        monthStatus: 'Ver otro mes', yearStatus: 'Ver otro año',
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
        dateFormat: 'dd/mm/yy', firstDay: 0,
        initStatus: 'Selecciona la fecha', isRTL: false
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

    jQuery('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });

    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });

    $(".txtAreaObservaciones").keypress(function() {
        var limit = 50;
        var text = $(this).val();
        var chars = text.length;
        if (chars > limit) {
            var new_text = text.substr(0, limit);
            $(this).val(new_text);
        }
    });

    jQuery("#basicForm").validate({
        highlight: function(element) {
            jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        success: function(element) {
            $("#sitiosAlmacen").modal("hide");
            $("#mdl-datos-cliente").modal("show");
            jQuery(element).closest('.form-group').removeClass('has-error');
        }
    });


    /* jQuery("#frmNoRecaudos").validate({
     highlight: function(element) {
     jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
     },
     success: function(element) {
     jQuery(element).closest('.form-group').removeClass('has-error');
     }
     });*/





    $('#frmNoRecaudos').submit(function(event) {
        if ($('#FechaNoRecaudo').val() > $('#FechaProximaVisita').val()) {

            $("#alertaFacturasPendientes").css("z-index", "15000");
            $('#alertaFacturasPendientes #mensaje-error').html('La fecha de la proxima visita debe ser mayor a la fecha actual');
            $('#alertaFacturasPendientes').modal('show');
            return false;
        }

    });




    jQuery('#validationWizardTransferencia').bootstrapWizard({
        tabClass: 'nav nav-pills nav-justified nav-disabled-click',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onNext: function(tab, navigation, index) {
            var $valid = jQuery('#formtransferenciaconsignacion').valid();
            if (!$valid) {

                $validator.focusInvalid();
                return false;
            }
        }
    });



    $('#select-tipo-venta').change(function() {
        var saldoInventario;
        if ($(this).val() == 'Consignacion') {
            saldoInventario = 'Autoventa';
        } else {
            saldoInventario = 'Preventa';
        }

        $.ajax({
            data: {
                "saldoInventario": saldoInventario,
            },
            url: 'index.php?r=TransferenciaConsignacion/AjaxGetTipoSaldoTransferencia',
            type: 'post',
            success: function(response) {

            }
        });

    });

    $('#adicionar-portafolio').click(function() {
        $('#portafolio').modal('show');
    });

    $('#adicionar-porducto').click(function() {
        $('#portafolioproducto').modal('show');
    });


    var codigoVariante;
    var cliente;
    var articulo;
    var grupoVentas;
    var zonaventas;
    var sitio;
    var codigoUnidadSaldo;
    var idSaldoInventario;
    var codigoUnidadSaldoInventario;
    var CodigoUnidadMedida;
    var NombreUnidadMedida;
    var PrecioVenta;

    $('.btnAdicionarProductoDetalleAct').click(function() {

        codigoVariante = $(this).attr('data-CodigoVariante');
        cliente = $(this).attr('data-cliente');
        articulo = $(this).attr('data-CodigoArticulo');
        grupoVentas = $(this).attr('data-CodigoGrupoVentas');
        zonaventas = $(this).attr('data-zona-ventas');
        sitio = $('#select-sitio').attr('data-codigo');
        codigoUnidadSaldo = $(this).attr('data-articulo');
        idSaldoInventario = $(this).attr('data-id-inventario');
        codigoUnidadSaldoInventario = $(this).attr('data-codigounidadmedida-saldo');
        CodigoUnidadMedida = $(this).attr('data-ACCodigoUnidadMedida');
        NombreUnidadMedida = $(this).attr('data-ACNombreUnidadMedida');
        PrecioVenta = $(this).attr('data-ACPrecioVenta');

        

                    $('#textDetCodigoUnidadMedida').val(CodigoUnidadMedida);

                    $.ajax({
                        data: {
                            "codigoVariante": codigoVariante,
                            "cliente": cliente,
                            "CodigoUnidadMedida": CodigoUnidadMedida,
                            "articulo": articulo,
                            "zonaventas": zonaventas
                        },
                        url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxACDLTransferencia',
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
                                $('#txtDescuentoProveedor').val('0');
                                $('#txtCodigoArticulo').val(articulo);
                                $('#txtIdSaldoInventario').val(idSaldoInventario);
                                $('#txtCodigoUnidadSaldoInventario').val(codigoUnidadSaldoInventario);

                            } else {

                                var datos = jQuery.parseJSON(response);
                                $('#txtSaldoLimite').val(datos.Saldo);
                                $('#txtSaldoACDL').val(datos.Saldo);
                                $('#txtSaldoACDLSinConversion').val(datos.SaldoSinConversion);
                                $('#txtIdAcuerdo').val(datos.IdAcuerdo);
                                $('#txtCodigoUnidadMedidaACDL').val(datos.CodigoUnidadMedida);
                                $('#txtPorcentajeDescuentoLinea1ACDL').val(datos.PorcentajeDescuentoLinea1);
                                $('#txtPorcentajeDescuentoLinea2ACDL').val(datos.PorcentajeDescuentoLinea2);
                                $('#txtDescuentoProveedor').val(parseFloat(datos.PorcentajeDescuentoLinea1) + parseFloat(datos.PorcentajeDescuentoLinea2));
                                $('#txtCodigoArticulo').val(articulo);
                                $('#txtIdSaldoInventario').val(idSaldoInventario);
                                $('#txtCodigoUnidadSaldoInventario').val(codigoUnidadSaldoInventario);

                            }

                            $.ajax({
                                data: {
                                    "grupoVentas": grupoVentas,
                                    "codigoVariante": codigoVariante,
                                    "articulo": articulo,
                                    "cliente": cliente,
                                    "CodigoUnidadMedida": CodigoUnidadMedida
                                },
                                url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxDetalleArticuloTransferencia',
                                type: 'post',
                                beforeSend: function() {
                                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                },
                                success: function(response) {

                                    var datos = jQuery.parseJSON(response);
                                    
                                    if (datos.SaldoInventarioPreventa <= 0) {
                                        $('#alertaArticuloSinSaldo').modal('show');
                                        return;
                                    } else {


                                        var nombreCompleto = datos.NombreArticulo + ' ';
                                        if (datos.CodigoCaracteristica1 != null) {
                                            nombreCompleto += datos.CodigoCaracteristica1 + ' ';
                                        }

                                        if (datos.CodigoCaracteristica2 != null) {
                                            nombreCompleto += datos.CodigoCaracteristica2 + ' ';
                                        }
                                        if (datos.CodigoTipo != null) {
                                            nombreCompleto += '(' + datos.CodigoTipo + ')';
                                        }


                                        $.ajax({
                                            data: {
                                                'variante': datos.CodigoVariante,
                                            },
                                            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxValidarItemTransferencia',
                                            type: 'post',
                                            beforeSend: function() {
                                                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                            },
                                            success: function(response) {

                                                $("#select-especial").val();
                                                $('#div-descuento-especial').html('');

                                                if (response) {
                                                    var obj = jQuery.parseJSON(response);
                                                    $('#txtCantidadPedidaTransaccion').val(obj.cantidad);
                                                    $('#txtDescuentoProveedor').val(obj.descuentoProveedor);
                                                    $('#txtDescuentoAltipal').val(obj.descuentoAltipal);
                                                    $('#txtDescuentoEspecial').val(obj.descuentoEspecial);

                                                    if (obj.descuentoEspecialSelect != null) {
                                                        $("#select-especial").val(obj.descuentoEspecialSelect);
                                                    }

                                                    var cadena = '';
                                                    $('#div-descuento-especial').html('');
                                                    if (obj.descuentoEspecialSelect == "Compartidos") {
                                                        cadena += "<input type='number' name='name' value='" + obj.descuentoEspecialProveedor + "' id='txtDescuentoEspecialProveedor' placeholder='Proveedor'  min='0' max='100' class='form-control'/><br/>";
                                                        cadena += "<input type='number' name='name' value='" + obj.descuentoEspecialAltipal + "' id='txtDescuentoEspecialAltipal' placeholder='Altipal' min='0' max='100' class='form-control'/><br/>";
                                                        $('#div-descuento-especial').append(cadena);
                                                    }



                                                }

                                            }
                                        });


                                        if (!datos.ValorIMPOCONSUMO) {

                                            datos.ValorIMPOCONSUMO = 0;

                                            $('#textDetImpoconsumo').val("0");

                                        }


                                        $('#textDetNombreProducto').html(nombreCompleto);
                                        $('#textDetCodigoProducto').html(datos.CodigoVariante);
                                        $('#textCodigoVariante').val(datos.CodigoVariante);
                                        $('#textDetUnidadMedida').val(NombreUnidadMedida);
                                        
                                        $('#textGrupoVentas').val(grupoVentas);
                                        
                                        $('#textDetSaldo').val(datos.SaldoInventarioPreventa);
                                        $('#textDetIva').val(datos.PorcentajedeIVA);
                                        $('#textDetImpoconsumo').val('$ ' + (datos.ValorIMPOCONSUMO));
                                        //$('#textDetImpoconsumo').val(datos.ValorIMPOCONSUMO);
                                        $('#textDetValorProductoMostrar').val('$  '  + (parseFloat(PrecioVenta) + parseFloat(datos.ValorIMPOCONSUMO) + parseFloat(datos.PorcentajedeIVA) ));
                                        //$('#textDetValorProductoMostrar').val(parseFloat(PrecioVenta) + parseFloat(datos.ValorIMPOCONSUMO));
                                        $('#textDetValorProducto').val(PrecioVenta);
                                        $('#txtCantidadPedidaTransaccion').val('');
                                        $('#txtDescuentoAltipal').val('');
                                        $('#txtDescuentoEspecial').val('');
                                        $('#select-especial').prop('selectedIndex', 0);
                                        $('#articuloPedido').modal('show');
                                    }


                                }
                            });

                        }
                    });

                //}

            //}
        });
        
    //});
    
    function iniActualizarDetalle(){
        
        
    
     $('.adicionar-producto-detalle-transaccion-actualizar').click(function() {
         
         
                     
        codigoVariante = $(this).attr('data-codigo-variante');
        cliente = $(this).attr('data-cliente');
        articulo = $(this).attr('data-articulo');
        grupoVentas = $(this).attr('data-grupo-ventas');
        zonaventas = $(this).attr('data-zona');
        //sitio = $('#select-sitio').attr('data-codigo');
        //codigoUnidadSaldo = $(this).attr('data-articulo');
        idSaldoInventario = $(this).attr('data-id-inventario');
        
       
       
                   $('#textDetCodigoUnidadMedida').val(CodigoUnidadMedida);

                    $.ajax({
                        data: {
                            "codigoVariante": codigoVariante,
                            "cliente": cliente,
                            "CodigoUnidadMedida": CodigoUnidadMedida,
                            "articulo": articulo,
                            "zonaventas": zonaventas
                        },
                        url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxACDLTransferencia',
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
                                $('#txtDescuentoProveedor').val('0');
                                $('#txtCodigoArticulo').val(articulo);
                                $('#txtIdSaldoInventario').val(idSaldoInventario);
                                $('#txtCodigoUnidadSaldoInventario').val(codigoUnidadSaldoInventario);

                            } else {

                                var datos = jQuery.parseJSON(response);
                                $('#txtSaldoLimite').val(datos.Saldo);
                                $('#txtSaldoACDL').val(datos.Saldo);
                                $('#txtSaldoACDLSinConversion').val(datos.SaldoSinConversion);
                                $('#txtIdAcuerdo').val(datos.IdAcuerdo);
                                $('#txtCodigoUnidadMedidaACDL').val(datos.CodigoUnidadMedida);
                                $('#txtPorcentajeDescuentoLinea1ACDL').val(datos.PorcentajeDescuentoLinea1);
                                $('#txtPorcentajeDescuentoLinea2ACDL').val(datos.PorcentajeDescuentoLinea2);
                                $('#txtDescuentoProveedor').val(parseFloat(datos.PorcentajeDescuentoLinea1) + parseFloat(datos.PorcentajeDescuentoLinea2));
                                $('#txtCodigoArticulo').val(articulo);
                                $('#txtIdSaldoInventario').val(idSaldoInventario);
                                $('#txtCodigoUnidadSaldoInventario').val(codigoUnidadSaldoInventario);

                            }

                            $.ajax({
                                data: {
                                    "grupoVentas": grupoVentas,
                                    "codigoVariante": codigoVariante,
                                    "articulo": articulo,
                                    "cliente": cliente,
                                    "CodigoUnidadMedida": CodigoUnidadMedida
                                },
                                url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxDetalleArticuloTransferencia',
                                type: 'post',
                                beforeSend: function() {
                                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                },
                                success: function(response) {



                                    var datos = jQuery.parseJSON(response);

                                    if (datos.SaldoInventarioPreventa <= 0) {
                                        $('#alertaArticuloSinSaldo').modal('show');
                                        return;
                                    } else {


                                        var nombreCompleto = datos.NombreArticulo + ' ';
                                        if (datos.CodigoCaracteristica1 != null) {
                                            nombreCompleto += datos.CodigoCaracteristica1 + ' ';
                                        }

                                        if (datos.CodigoCaracteristica2 != null) {
                                            nombreCompleto += datos.CodigoCaracteristica2 + ' ';
                                        }
                                        if (datos.CodigoTipo != null) {
                                            nombreCompleto += '(' + datos.CodigoTipo + ')';
                                        }


                                        $.ajax({
                                            data: {
                                                'variante': datos.CodigoVariante,
                                            },
                                            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxValidarItemTransferencia',
                                            type: 'post',
                                            beforeSend: function() {
                                                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                            },
                                            success: function(response) {

                                                $("#select-especial").val();
                                                $('#div-descuento-especial').html('');

                                                if (response) {
                                                    var obj = jQuery.parseJSON(response);
                                                    $('#txtCantidadPedidaTransaccion').val(obj.cantidad);
                                                    $('#txtDescuentoProveedor').val(obj.descuentoProveedor);
                                                    $('#txtDescuentoAltipal').val(obj.descuentoAltipal);
                                                    $('#txtDescuentoEspecial').val(obj.descuentoEspecial);

                                                    if (obj.descuentoEspecialSelect != null) {
                                                        $("#select-especial").val(obj.descuentoEspecialSelect);
                                                    }

                                                    var cadena = '';
                                                    $('#div-descuento-especial').html('');
                                                    if (obj.descuentoEspecialSelect == "Compartidos") {
                                                        cadena += "<input type='number' name='name' value='" + obj.descuentoEspecialProveedor + "' id='txtDescuentoEspecialProveedor' placeholder='Proveedor'  min='0' max='100' class='form-control'/><br/>";
                                                        cadena += "<input type='number' name='name' value='" + obj.descuentoEspecialAltipal + "' id='txtDescuentoEspecialAltipal' placeholder='Altipal' min='0' max='100' class='form-control'/><br/>";
                                                        $('#div-descuento-especial').append(cadena);
                                                    }



                                                }

                                            }
                                        });


                                        if (!datos.ValorIMPOCONSUMO) {

                                            datos.ValorIMPOCONSUMO = 0;

                                            $('#textDetImpoconsumo').val("0");

                                        }


                                        $('#textDetNombreProducto').html(nombreCompleto);
                                        $('#textDetCodigoProducto').html(datos.CodigoVariante);
                                        $('#textCodigoVariante').val(datos.CodigoVariante);
                                        $('#textGrupoVentas').val(grupoVentas);
                                        $('#textDetUnidadMedida').val(NombreUnidadMedida);
                                        $('#textDetSaldo').val(datos.SaldoInventarioPreventa);
                                        $('#textDetIva').val(datos.PorcentajedeIVA);
                                        $('#textDetImpoconsumo').val('$ ' + (datos.ValorIMPOCONSUMO));
                                        $('#textDetValorProductoMostrar').val('$ '  + (parseFloat(PrecioVenta) + parseFloat(datos.ValorIMPOCONSUMO) +  parseFloat(datos.PorcentajedeIVA)));
                                        $('#textDetValorProducto').val(PrecioVenta);
                                        $('#txtCantidadPedidaTransaccion').val('');
                                        $('#txtDescuentoAltipal').val('');
                                        $('#txtDescuentoEspecial').val('');
                                        $('#select-especial').prop('selectedIndex', 0);
                                        $('#articuloPedido').modal('show');
                                    }


                                }
                            });

                        }
                    });

            });
    
    }

    $('#txtCantidadPedidaTransaccion').keyup(function() {

        var cantidadPedida = $(this).val();
        var valorProducto = $('#textDetValorProducto').val();
        var saldoLimite = $('#txtSaldoLimite').val();
        var unidadMedida = $('#textDetCodigoUnidadMedida').val();

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
                url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxACDLCantidadesTransferencia',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {

                    if (response == 0) {
                        $('#txtDescuentoProveedor').val('0');

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

                        $('#txtDescuentoProveedor').val(descuento);

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
            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxACDMTransferencia',
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

    var tipodescuento;
    $('#select-especial').change(function() {

        tipodescuento = $('#select-especial option:selected').val();
        var cadena = '';

        if (tipodescuento == "Ninguno") {
            $('#div-descuento-especial').html('');
        }

        if (tipodescuento == "Proveedor") {
            $('#div-descuento-especial').html('');
        }
        if (tipodescuento == "Altipal") {
            $('#div-descuento-especial').html('');
        }
        if (tipodescuento == "Compartidos") {
            $('#div-descuento-especial').html('');
            cadena += "<input type='number' name='name' id='txtDescuentoEspecialProveedor' placeholder='Proveedor'  min='0' max='100' class='form-control'/><br/>";
            cadena += "<input type='number' name='name' id='txtDescuentoEspecialAltipal' placeholder='Altipal' min='0' max='100' class='form-control'/><br/>";
        }
        $('#div-descuento-especial').append(cadena);
    });

    $('#formaPago').change(function() {

        if ($(this).val() == 'contado') {

            $('#plazo').val('0');
            $('#plazo').attr('max', '0');
            $('#plazo').attr('min', '0');
            $('#plazo').attr('readonly', 'readonly');

            var f = new Date();
            var mes = '';

            if ((f.getMonth() + 1) < 10) {
                mes = '0' + (f.getMonth() + 1);
            }

            var fechaActual = ((f.getFullYear() + "-" + mes + "-" + f.getDate()));
            $('#datepicker').val(fechaActual);
            $("#datepicker").attr('readonly', 'readonly');
            var cadena = '<option>No</option>';
            $('#actividadEspecial').html(cadena);

        }
        if ($(this).val() == 'credito') {
            var diasPago = $("option:selected", this).attr("data-dias-pago");
            $('#plazo').val(diasPago);
            $('#plazo').attr('max', diasPago);
            $('#plazo').attr('min', '0');
            $('#plazo').removeAttr('readonly');
            $('#datepicker').removeAttr('readonly');

            var cadena = '<option>No</option>';
            cadena += '<option>Si</option>';
            $('#actividadEspecial').html(cadena);

            jQuery('#validationWizard').bootstrapWizard({
                tabClass: 'nav nav-pills nav-justified nav-disabled-click',
                onTabClick: function(tab, navigation, index) {
                    return false;
                },
                onNext: function(tab, navigation, index) {
                    var $valid = jQuery('#firstForm').valid();
                    if (!$valid) {

                        $validator.focusInvalid();
                        return false;
                    }
                }
            });
        }
    });


    var cadena = "";
    var cantidad = '0';




    $('#btn-aceptar-ACDL-Transaccion').click(function() {


        var codigoVariante = $('#textDetCodigoProducto').text();
        var descripcion = $('#textDetNombreProducto').text();
        var textDetIva = $('#textDetIva').val();
        var textDetSaldo = $('#textDetSaldo').val();
        var textVariante = $('#textCodigoVariante').val();
        var textDetValorProducto = $('#textDetValorProducto').val();
        var textDetImpoconsumo = $('#textDetImpoconsumo').val();
        var txtCantidadPedida = $('#txtCantidadPedidaTransaccion').val();
        var txtSaldoLimite = $('#txtSaldoLimite').val();
        var txtDescuentoProveedor = $('#txtDescuentoProveedor').val();
        var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
        var txtDescuentoEspecial = $('#txtDescuentoEspecial').val();
        var txtSaldoACDL = $('#txtSaldoACDL').val();
        var txtCodigoUnidadMedidaACDL = $('#txtCodigoUnidadMedidaACDL').val();
        var txtCantidadPedida = $('#txtCantidadPedidaTransaccion').val();
        var txtDescuentoEspecialSelect = $('#select-especial').val();
        var txtDescuentoEspecialProveedor = $('#txtDescuentoEspecialProveedor').val();
        var txtDescuentoEspecialAltipal = $('#txtDescuentoEspecialAltipal').val();
        var textDetUnidadMedida = $("#textDetUnidadMedida").val();


        $('#alertaACDLCantidad').modal('hide');

        $.ajax({
            data: {
                "nombreProducto": descripcion,
                "variante": textVariante,
                "valorUnitario": textDetValorProducto,
                "impoconsumo": textDetImpoconsumo,
                "cantidad": txtCantidadPedida,
                "saldo": textDetSaldo,
                "saldoLimite": txtSaldoLimite,
                "descuentoProveedor": txtDescuentoProveedor,
                "descuentoAltipal": txtDescuentoAltipal,
                "descuentoEspecial": txtDescuentoEspecial,
                "iva": textDetIva,
                "descuentoEspecialSelect": txtDescuentoEspecialSelect,
                "descuentoEspecialProveedor": txtDescuentoEspecialProveedor,
                "descuentoEspecialAltipal": txtDescuentoEspecialAltipal,
                "unidadMedida": textDetUnidadMedida,
                "aplicaImpoconsumo": true
            },
            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AgregarItemTransferencia',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                $('#tableDetail').html(response);
                calculaTotalesPedidoTransferencia();
                actualizaPortafolioAgregar();
                $('#articuloPedido').modal('hide');


                $('.delete-item-pedido').click(function() {
                    var variante = $(this).attr('data-variante');
                    $.ajax({
                        data: {
                            "variante": variante
                        },
                        url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxEliminarItemTransferencia',
                        type: 'post',
                        beforeSend: function() {
                            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                        },
                        success: function(response) {

                            $('#tableDetail').html(response);
                            calculaTotalesPedidoTransferencia();
                            actualizaPortafolioAgregar();
                            initdelete();


                            $('.delete-item-pedido').click(function() {
                                var variante = $(this).attr('data-variante');
                                $.ajax({
                                    data: {
                                        "variante": variante,
                                    },
                                    url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxEliminarItemTransferencia',
                                    type: 'post',
                                    beforeSend: function() {
                                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                    },
                                    success: function(response) {

                                        $('#tableDetail').html(response);
                                        calculaTotalesPedidoTransferencia();
                                        actualizaPortafolioAgregar();
                                        initdelete();


                                    }
                                });
                            });

                        }
                    });
                });

            }
        });

    });


    $('#btn-cancelar-ACDL-Transaccion').click(function() {
        $('#alertaACDLCantidad').modal('hide');
        $('#txtCantidadPedidaTransaccion').focus();
    });


    $("#formtransferenciaconsignacion").submit(function() {




        var cantidadProductos = $('#cantidad-enviar').val();
        var txtTotalPedido = $('#txtTotalPedido').val();
        var txtSaldoCupo = $('#txtSaldoCupo').val();
        var formaPago = $('#formaPago').val();

        if (cantidadProductos <= 0) {

            $('#alertaErrorValidar #mensaje-error').html("No se han adicionado productos  a la transaccion");
            $('#alertaErrorValidar').modal('show');
            return false;

        } else {


         $('#_alertConfirmationTransConsignacion #confirm').html('Está seguro de terminar la transferencia en este momento');
         $('#_alertConfirmationTransConsignacion').modal('show');
         return false;
            
        }  


    });

    function actualizaPortafolioAgregar() {

        $.ajax({
            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxActualizaPortafolioAgregarTransferencia',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                var obj = jQuery.parseJSON(response);
                
                 var table = $('#tblPortafolio').dataTable();
                 var filtro=$('#tblPortafolio_filter input').val();
                 table.fnFilterClear();

                $('.btnAdicionarProductoDetalleAct').each(function() {
                    var variante = $(this).attr('data-CodigoVariante');

                    if ($(this).attr('data-nuevo') == 0) {
                        $('.imagen-producto-' + variante).attr('src', 'images/pro.png');
                    } else {
                        $('.imagen-producto-' + variante).attr('src', 'images/pronuevo.png');
                    }

                });
                $.each(obj, function(idx, obj) {
                    $('.imagen-producto-' + obj).attr('src', 'images/aceptar.png');

                });

                table.fnFilter(filtro);
            }


        });

    }

    function calculaTotalesPedidoTransferencia() {
        $.ajax({
            data: {
                'saldoCupo': $('#txtSaldoCupo').val(),
            },
            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxTotalesTransferencias',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                $('#totalesCalculados').html(response);




            }
        });
    }

    function number_format(number, decimals, dec_point, thousands_sep) {
        var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }


    /*****************************************************************************************************************************/


    $(".btn-cargar-pedido").click(function() {
        $("#sitiosAlmacen").modal("show");
    });

    $("#btn-devoluciones").click(function() {
        $("#sitiosAlmacenDevoluciones").modal("show");
    });

    $(".btn-consignacion").click(function() {
        $("#sitiosAlmacenConsignacion").modal("show");
    });


    /*********************btn transaccion en consignacion funcion boton*********************************/


    $('.btn-adicionar-producto-consignacion').click(function() {
        
         
        var codigoVariante = $('#textDetCodigoProducto').text();
        var codigoCliente=$('#textCodigoCliente').val();
        var zonaVentas=$('#textZonaVentas').val();
        var grupoVentas=$('#textGrupoVentas').val();
        var descripcion = $('#textDetNombreProducto').text();
        var textDetIva = $('#textDetIva').val();
        var textDetSaldo = $('#textDetSaldo').val();
        var textVariante = $('#textCodigoVariante').val();
        var textDetValorProducto = $('#textDetValorProducto').val();
        var textDetImpoconsumo = $('#textDetImpoconsumo').val();
        var txtCantidadPedida = $('#txtCantidadPedidaTransaccion').val();
        var txtSaldoLimite = $('#txtSaldoLimite').val();
        var txtDescuentoProveedor = $('#txtDescuentoProveedor').val();
        var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
        var txtDescuentoEspecial = $('#txtDescuentoEspecial').val();
        var txtSaldoACDL = $('#txtSaldoACDL').val();
        var txtCodigoUnidadMedidaACDL = $('#txtCodigoUnidadMedidaACDL').val();
        var txtCantidadPedida = $('#txtCantidadPedidaTransaccion').val();
        var txtDescuentoEspecialSelect = $('#select-especial').val();
        var txtDescuentoEspecialProveedor = $('#txtDescuentoEspecialProveedor').val();
        var txtDescuentoEspecialAltipal = $('#txtDescuentoEspecialAltipal').val();
        var textDetCodigoUnidadMedida = $('#textDetCodigoUnidadMedida').val();
        var txtCodigoArticulo = $('#txtCodigoArticulo').val();
        var txtSaldoACDLSinConversion = $('#txtSaldoACDLSinConversion').val();
        var txtIdAcuerdo = $('#txtIdAcuerdo').val();
        var txtIdSaldoInventario = $('#txtIdSaldoInventario').val();
        var txtCodigoUnidadSaldoInventario = $('#txtCodigoUnidadSaldoInventario').val();
        var textDetUnidadMedida = $("#textDetUnidadMedida").val();
        
       

        if (txtCantidadPedida == "" || parseInt(txtCantidadPedida) < 0) {

            $('#alertaErrorValidar #mensaje-error').html('La cantidad digitada no es valida o esta vacia.');
            $('#alertaErrorValidar').modal('show');
            return;
        }
        
       


        if (parseInt(txtCantidadPedida) == 0) {
            $('#alertaErrorValidar #mensaje-error').html('La cantidad no puede ser 0.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

        if (parseInt(txtCantidadPedida) > parseInt(textDetSaldo)) {
            $('#alertaErrorValidar #mensaje-error').html('El saldo no es suficiente para la cantidad digitada.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

        if ($('#txtDescuentoEspecialProveedor').length && $('#txtDescuentoEspecialAltipal').length) {

            if ($('#txtDescuentoEspecialProveedor').val() == "" || $('#txtDescuentoEspecialAltipal').val() == "") {
                $('#alertaErrorValidar #mensaje-error').html('La campo Altipal o Provedor deben ser obligatorios.');
                $('#alertaErrorValidar').modal('show');
                return;
            }

            if ((parseInt($('#txtDescuentoEspecialProveedor').val()) + parseInt($('#txtDescuentoEspecialAltipal').val())) != '100') {
                $('#alertaErrorValidar #mensaje-error').html('El campo Altipal o Provedor registran un valor desproporcionado.');
                $('#alertaErrorValidar').modal('show');
                return;
            }

        }

        if ($('#txtDescuentoEspecial').val() != "" && $("#select-especial option:selected").val() == "Ninguno") {
            $('#alertaErrorValidar #mensaje-error').html('No se seleccionado una opcion Altipal, Provedor, o compartido.');
            $('#alertaErrorValidar').modal('show');
            return;
        }


        if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoACDL) && parseFloat(txtSaldoACDL) != 0) {

            $('#alertaACDLCantidad #mensaje-error').html('“El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, desea enviar la cantidad pendiente con el precio normal�?');
            $('#alertaACDLCantidad').modal('show');
            return;
        }

        $.ajax({
            data: {
                "nombreProducto": descripcion,
                "codigoCliente":codigoCliente,
                "zonaVentas":zonaVentas,
                "grupoVentas":grupoVentas,
                'codigoArticulo': txtCodigoArticulo,
                "idSaldoInventario": txtIdSaldoInventario,
                "codigoUnidadSaldoInventario": txtCodigoUnidadSaldoInventario,
                "variante": textVariante,
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
                "unidadMedida": textDetUnidadMedida,
                "aplicaImpoconsumo": true
            },
            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxAgregarItemTransferencia',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                
                $('#tableDetail').html(response);
                $('#bt').html('<button class="btn btn-primary enviarPedido" class="enviarPedido" style=" position: absolute;  right: 22px; height: 35px; width: 80px; z-index: 1">Enviar</button>')
                iniActualizarDetalle();
                calculaTotalesPedidoTransferencia();
                actualizaPortafolioAgregar();

                $('#articuloPedido').modal('hide');
                  
                 //$('#portafolio').modal('hide');
                
                
                $('.delete-item-pedido').click(function() {

                    if (confirm("Esta seguro de eliminar el producto de esta transaccion ?")) {
                        var variante = $(this).attr('data-variante');
                        $.ajax({
                            data: {
                                "variante": variante
                            },
                            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxEliminarItemTransferencia',
                            type: 'post',
                            beforeSend: function() {
                                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                            },
                            success: function(response) {

                                $('#tableDetail').html(response);                                
                                
                                $("#alertaEliminarCorrectamente").modal('show');
                                calculaTotalesPedidoTransferencia();
                                actualizaPortafolioAgregar();
                                iniActualizarDetalle();
                                init();
                                initdelete();

                            }
                        });
                    } else {

                        return;
                    }
                });


            }


        });

 
    });       
    
function initdelete(){
    
     
     $('.delete-item-pedido').click(function() {

                    if (confirm("Esta seguro de eliminar el producto de esta transaccion ?")) {
                        var variante = $(this).attr('data-variante');
                        $.ajax({
                            data: {
                                "variante": variante
                            },
                            url: baseRutaTransferencia + '/index.php?r=TransferenciaConsignacion/AjaxEliminarItemTransferencia',
                            type: 'post',
                            beforeSend: function() {
                                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                            },
                            success: function(response) {

                                $('#tableDetail').html(response);
                                 $("#alertaEliminarCorrectamente").modal('show');
                                calculaTotalesPedidoTransferencia();
                                actualizaPortafolioAgregar();
                                init();
                                initdelete();
                               

                            }
                        });
                    } else {

                        return;
                    }
                });
}

function init() {

    $('.cont').click(function() {

        var variante = $(this).attr('data-variante');
        
        alert('entre: ' + variante);
    
        $.ajax({
            data: {
                'variante': variante
            },
            url: 'index.php?r=TransferenciaConsignacion/AjaxconsultarTransferenciaConsignacion',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                
               
               $("#articuloPedido").html(response);
                 initprinceipal();
               $('#articuloPedido').modal('show');
             
               
               
            }
        });

    });


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

$('body').on('click','.ok',function(){
    
   location.reload(); 
});



$('#tblPortafolio').dataTable({
    "bPaginate": false,
})


$('#_alertaSucessTransConsignacion #sucess').html(" La transferencia en consignación se ha guardado satisfactoriamente !");
$('#_alertaSucessTransConsignacion').modal('show');


$('#retornarMenuTransConsignacion').click(function() {

    $('#_alertConfirmationMenu .text-modal-body').html('Esta seguro que desea salir del modulo de transferencia en consignación?');
    $('#_alertConfirmationMenu').modal('show');

});

 


$("#btnEnviarFormTransConsignacion").click(function() {

    document.getElementById("formtransferenciaconsignacion").submit();
});


$("#txtCantidadPedidaTransaccion").keyup(function() {
                                var str=$(this).val();
                                pos = str.indexOf(".");
                                if(pos> -1){
                                    $(this).val("");
                                    $(this).focus();
                                    return; 
                                }
                                if($(this).val()==0 || $(this).val()<1 || !$.isNumeric($(this).val()) ){
                                  $(this).val("");
                                  $(this).focus();
                                  return;
                                }

                                
                             });
                             
function initprinceipal(){
    
      $("#btn-actualizar-producto-consignacion").click(function() {
                                
                                var codigoVariante = $('#textDetCodigoProducto').text();
                                var txtCantidadPedida = $('#txtCantidadPedidaTransaccion').val();

                                $.ajax({
                                    data: {
                                        'codigoVariante': codigoVariante,
                                        'cantidad': txtCantidadPedida
                                    },
                                    url: 'index.php?r=TransferenciaConsignacion/AjaxActualizarTransferenciaConsignacion',
                                    type: 'post',
                                    beforeSend: function() {
                                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                    },
                                    success: function(response) {

                                        $('#tableDetail').html(response);
                                        init();
                                        $('#articuloPedido').modal('hide');

                                    }
                                });

                            });

    
    
}


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
        url: 'index.php?r=TransferenciaConsignacion/AjaxGetKitVirtual',
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
            url: 'index.php?r=TransferenciaConsignacion/AjaxGetKitVirtual',
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
        url: 'index.php?r=TransferenciaConsignacion/AjaxGetKitComponente',
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
            url: 'index.php?r=TransferenciaConsignacion/AjaxGetKitComponente',
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
                    var txtKitCodigoVarianteComponente = $(this).attr('data-kit-CodigoVarianteComponente');

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
                            "txtKitCodigoVarianteComponente": txtKitCodigoVarianteComponente,
                            "txtCantidad": cant[cont_3],
                        },
                        url: 'index.php?r=TransferenciaConsignacion/AjaxGuardarKitDinamico',
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
                    var txtKitCodigoVarianteComponente = $(this).attr('data-kit-CodigoVarianteComponente');
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
                            "txtKitPrecioVentaBaseVariante": txtKitPrecioVentaBaseVariante,
                            "txtKitCodigoVarianteComponente": txtKitCodigoVarianteComponente


                        },
                        url: 'index.php?r=TransferenciaConsignacion/AjaxGuardarKitDinamico',
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
                    url: 'index.php?r=TransferenciaConsignacion/AjaxGetDetalleArticulo',
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
                                iniSelectResponsable();
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
                            iniSelectResponsable();
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
                url: 'index.php?r=TransferenciaConsignacion/AjaxGetDetalleArticulo',
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

                            /*if ($("#actividadEspecial").val() == "si") {
                                $("#sltResposableDescuento").attr('disabled', 'disabled');
                                $('.txtDescuentoEspecial').attr('disabled', 'disabled');
                                $("#actividadEspecial").attr('disabled', 'disabled');
                            }*/

                            iniBtnAdicionalrProducto();
                            iniSelectResponsable();
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


                        /*if ($("#actividadEspecial").val() == "si") {
                            $("#sltResposableDescuento").attr('disabled', 'disabled');
                            $('.txtDescuentoEspecial').attr('disabled', 'disabled');
                            $("#actividadEspecial").attr('disabled', 'disabled');
                        }*/

                        iniBtnAdicionalrProducto();
                        iniSelectResponsable();
                        iniValidarCantidad();
                        iniCantidadAcuerdos();
                        cargarlote();
                    }


                }
            });

        }
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
            cadena += "La cantidad dígitada para el producto: " + caracteristica + " debe ser mayor o igual a la cantidad reglamentaria para el kit.<br/>";
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
        cadena += "La suma de las cantidades para los productos regulares es diferente a la cantidad máxima permitida para el kit<br/>";
        cadena += "Cantidad máxima: " + cantidadMaximaRegular + "<br/><br/>";
        continuar = false;
    }

    if (contObsequios != cantidadMaximaObsequios) {
        cadena += "La suma de las cantidades para los obsequios es diferente a la cantidad máxima permitida para el kit<br/>";
        cadena += "Cantidad máxima: " + cantidadMaximaObsequios + "<br/><br/>";
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


function calcularSaldoKitVirtual(codigoListaMateriales, codigoArticuloKit, codigoUnidadMedida, cuentaCliente) {

    $.ajax({
        data: {
            'codigoListaMateriales': codigoListaMateriales,
            'codigoArticuloKit': codigoArticuloKit,
            'cuentaCliente': cuentaCliente,
            'codigoUnidadMedida': codigoUnidadMedida
        },
        url: 'index.php?r=Preventa/AjaxCalcularSaldoKitVirtual',
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
        url: 'index.php?r=Preventa/AjaxCalcularSaldoKitDinamico',
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
                             