

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

    var baseRuta = $('body').attr('data-ruta');
    limparFrmRegistrarCliente();

    jQuery('#table1').dataTable({
        "sPaginationType": "full_numbers",
    });


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


    jQuery('#datepickerVistaLink').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });


    jQuery('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 'today',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });

    jQuery('#fechaini').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });

    jQuery('#fechafin').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });


    jQuery('#fechainiDahsboard').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });

    jQuery('#fechafinDahsboard').datepicker({
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

        if($("#txtFechaActual").val() == $('#FechaProximaVisita').val()){
            $("#alertaFacturasPendientes").css("z-index", "15000");
            $('#alertaFacturasPendientes #mensaje-error').html('La Fecha próxima visita no puede ser igual a la fecha actual');
            $('#alertaFacturasPendientes').modal('show');
            return false;
        }

        if ($('#FechaProximaVisita').val() == "") {
            $("#alertaFacturasPendientes").css("z-index", "15000");
            $('#alertaFacturasPendientes #mensaje-error').html('No se ha seleccionado una fecha de visita');
            $('#alertaFacturasPendientes').modal('show');
            return false;
        }

        if ($('#sltMotivoDevolucion').val() == "") {
            $("#alertaFacturasPendientes").css("z-index", "15000");
            $('#alertaFacturasPendientes #mensaje-error').html('No se ha seleccionado un motivo de no visita');
            $('#alertaFacturasPendientes').modal('show');
            return false;
        }

        if ($('#txtObservacionNoRecaudo').val() == "") {
            $("#alertaFacturasPendientes").css("z-index", "15000");
            $('#alertaFacturasPendientes #mensaje-error').html('No se ha digitado una observación.');
            $('#alertaFacturasPendientes').modal('show');
            return false;
        }

        if ($('#FechaNoRecaudo').val() > $('#FechaProximaVisita').val()) {
            $("#alertaFacturasPendientes").css("z-index", "15000");
            $('#alertaFacturasPendientes #mensaje-error').html('La fecha de la proxima visita debe ser mayor a la fecha actual');
            $('#alertaFacturasPendientes').modal('show');
            return false;
        }

    });


    $('#consignaciones').click(function() {


        var cliente = $(this).attr("data-clie");
        var zona = $(this).attr("data-zona");
        var desAlmacen = $("#select-sitioConsignacion option:selected").attr('data-almacen');
        var codigositio = $("#select-sitioConsignacion").val();
        var nombresitio = $("#select-sitioConsignacion option:selected").text();


        $.ajax({
            data: {
                "codigositio": codigositio,
                "desAlmacen": desAlmacen,
                "nombreSitio": nombresitio
            },
            url: baseRuta + '/index.php?r=TransferenciaConsignacion/AjaxSetSitioTipoVenta',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                ///

                window.location.href = "index.php?r=TransferenciaConsignacion/CrearTransferencia&cliente=" + cliente + "&zonaVentas=" + zona;
            }
        });



    });






    /*var $validator = jQuery("#firstForm").validate({

     highlight: function(element) {            
     jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
     $('label.error').css('display','none');
     },
     success: function(element) { 
     $('label.error').css('display','none');
     jQuery(element).closest('.form-group').removeClass('has-error');    

     }
     });*/

    //Modulo Pedido
    jQuery('#validationWizard').bootstrapWizard({
        tabClass: 'nav nav-pills nav-justified nav-disabled-click',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onNext: function(tab, navigation, index) {
            var $valid = jQuery('#formPedidos').valid();
            if (!$valid) {

                $validator.focusInvalid();
                return false;
            }
        }
    });

    /* $('#select-sitio').change(function(){

     var zonaVentas=$(this).attr('data-zona-ventas');
     var cliente=$(this).attr('data-cliente');
     var sitio=$(this).val();          

     $.ajax({
     data: {
     "zonaVentas": zonaVentas,
     "cliente": cliente,
     "sitio":sitio
     },
     url: baseRuta+'/index.php?r=Pedido/AjaxGetTipoventa',
     type: 'post',
     beforeSend : function (){
     $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">'); 
     },
     success: function(response) {                  	
     $('#select-sitio-venta').html(response);                   
     }
     });	

     });*/

    //Pedido
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
            url: 'index.php?r=Pedido/AjaxGetTipoSaldo',
            type: 'post',
            success: function(response) {

            }
        });
    });

    //Mostar portafolio
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

    $('.adicionar-producto-detalle').click(function() {


        $('#txtCantidadPedida1').val('');
        $('#txtDescuentoProveedor1').val('');
        $('#txtDescuentoAltipal').val('');
        $('#txtDescuentoEspecial').val('');
        $('#select-especial').prop('selectedIndex', 0);

        codigoVariante = $(this).attr('data-codigo-variante');
        cliente = $(this).attr('data-cliente');
        articulo = $(this).attr('data-articulo');
        grupoVentas = $(this).attr('data-grupo-ventas');
        zonaventas = $(this).attr('data-zona');
        sitio = $('#select-sitio').attr('data-codigo');
        codigoUnidadSaldo = $(this).attr('data-articulo');
        idSaldoInventario = $(this).attr('data-id-inventario');
        codigoUnidadSaldoInventario = $(this).attr('data-codigounidadmedida-saldo');

        $.ajax({
            data: {
                "codigoVariante": codigoVariante,
                "cliente": cliente,
                "zonaventas": zonaventas
            },
            url: baseRuta + '/index.php?r=Pedido/AjaxAcuerdoComercialVenta',
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
                        url: baseRuta + '/index.php?r=Pedido/AjaxACDL',
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
                                $('#txtDescuentoProveedor1').val(parseFloat(datos.PorcentajeDescuentoLinea1) + parseFloat(datos.PorcentajeDescuentoLinea2));
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
                                url: baseRuta + '/index.php?r=Pedido/AjaxDetalleArticulo',
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
                                            url: baseRuta + '/index.php?r=Pedido/AjaxValidarItemPedido',
                                            type: 'post',
                                            beforeSend: function() {
                                                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                                            },
                                            success: function(itemProdutoAgregado) {

                                                $("#select-especial").val();
                                                $('#div-descuento-especial').html('');

                                                if (itemProdutoAgregado != "") {
                                                    //alert('Item agregado');
                                                    var itemAgregado = jQuery.parseJSON(itemProdutoAgregado);
                                                    var CantidadPedida1 = itemAgregado.cantidad;
                                                    var DescuentoProveedor1 = itemAgregado.descuentoProveedor;

                                                    //alert(CantidadPedida1);

                                                    $('#txtCantidadPedida1').val(CantidadPedida1);
                                                    $('#txtDescuentoProveedor').val(DescuentoProveedor1);
                                                    $('#txtDescuentoAltipal').val(itemAgregado.descuentoAltipal);
                                                    $('#txtDescuentoEspecial').val(itemAgregado.descuentoEspecial);

                                                    if (obj.descuentoEspecialSelect != null) {
                                                        $("#select-especial").val(itemAgregado.descuentoEspecialSelect);
                                                    }

                                                    var cadena = '';
                                                    $('#div-descuento-especial').html('');
                                                    if (obj.descuentoEspecialSelect == "Compartidos") {
                                                        cadena += "<input type='number' name='name' value='" + itemAgregado.descuentoEspecialProveedor + "' id='txtDescuentoEspecialProveedor' placeholder='Proveedor'  min='0' max='100' class='form-control'/><br/>";
                                                        cadena += "<input type='number' name='name' value='" + itemAgregado.descuentoEspecialAltipal + "' id='txtDescuentoEspecialAltipal' placeholder='Altipal' min='0' max='100' class='form-control'/><br/>";
                                                        $('#div-descuento-especial').append(cadena);
                                                    }

                                                    return false;
                                                }



                                            }
                                        });

                                        $('#textDetNombreProducto').html(nombreCompleto);
                                        $('#textDetCodigoProducto').html(datos.CodigoVariante);
                                        $('#textCodigoVariante').val(datos.CodigoVariante);
                                        $('#textDetUnidadMedida').val(NombreUnidadMedida);
                                        $('#textDetSaldo').val(datos.SaldoInventarioPreventa);
                                        $('#textDetIva').val(datos.PorcentajedeIVA);
                                        $('#textDetImpoconsumo').val(datos.ValorIMPOCONSUMO);
                                        $('#textDetValorProductoMostrar').val(parseFloat(PrecioVenta) + parseFloat(datos.ValorIMPOCONSUMO));
                                        $('#textDetValorProducto').val(PrecioVenta);


                                        $('#articuloPedido').modal('show');
                                    }


                                }
                            });

                        }
                    });

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

    /*
     $('#btn-adicionar-producto').click(function() {



     var codigoVariante = $('#textDetCodigoProducto').text();
     var descripcion = $('#textDetNombreProducto').text();
     var textDetIva = $('#textDetIva').val();
     var textDetSaldo = $('#textDetSaldo').val();
     var textVariante = $('#textCodigoVariante').val();
     var textDetValorProducto = $('#textDetValorProducto').val();
     var textDetImpoconsumo = $('#textDetImpoconsumo').val();
     var txtCantidadPedida = $('#txtCantidadPedida').val();
     var txtSaldoLimite = $('#txtSaldoLimite').val();
     var txtDescuentoProveedor = $('#txtDescuentoProveedor').val();
     var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
     var txtDescuentoEspecial = $('#txtDescuentoEspecial').val();
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




     if (txtCantidadPedida == "" || parseInt(txtCantidadPedida) < 0) {

     $('#alertaErrorValidar #mensaje-error').html('La cantidad digitada no es valida o esta vacia.');
     $('#alertaErrorValidar').modal('show');
     return;
     }

     if (txtDescuentoEspecial != "") {
     if (!$.isNumeric(txtDescuentoEspecial) || parseInt(txtDescuentoEspecial) > 100) {
     $('#alertaErrorValidar #mensaje-error').html('El descuento del proveedor no es valido.');
     $('#txtDescuentoEspecial').val('');
     $('#txtDescuentoEspecial').focus();
     $('#alertaErrorValidar').modal('show');
     return;
     }
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


     if ($('#txtDescuentoEspecial').val() == 0) {
     $('#txtDescuentoEspecialPreventa').val('');
     $('#alertaErrorValidar #mensaje-error').html('El Descuento Especial no debe ser igual a 0.');
     $('#alertaErrorValidar').modal('show');
     return;
     }

     if ($('#txtDescuentoEspecial').val() != "" && $("#select-especial option:selected").val() == "Ninguno") {
     $('#alertaErrorValidar #mensaje-error').html('No se seleccionado una opcion Altipal, Provedor, o compartido.');
     $('#alertaErrorValidar').modal('show');
     return;
     }


     if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoACDL) && parseFloat(txtSaldoACDL) != 0) {

     $('#alertaACDLCantidad #mensaje-error').html('“El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, desea enviar la cantidad pendiente con el precio normal”');
     $('#alertaACDLCantidad').modal('show');
     return;
     }

     // return false;

     $.ajax({
     data: {
     "nombreProducto": descripcion,
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
     "aplicaImpoconsumo": true
     },
     url: baseRuta + '/index.php?r=Pedido/agregarItemPedido',
     type: 'post',
     beforeSend: function() {
     $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
     },
     success: function(response) {

     $('#tableDetail').html(response);
     calculaTotalesPedido();
     actualizaPortafolioAgregar();

     $('#articuloPedido').modal('hide');
     $('#txtCantidadPedida').val('');
     $('#txtDescuentoProveedor').val('');
     $('#txtDescuentoAltipal').val('');
     $('#txtDescuentoEspecial').val('');
     $('#select-especial').prop('selectedIndex', 0);

     $('.delete-item-pedido').click(function() {
     var variante = $(this).attr('data-variante');
     $.ajax({
     data: {
     "variante": variante,
     },
     url: baseRuta + '/index.php?r=Pedido/eliminarItemPedido',
     type: 'post',
     beforeSend: function() {
     $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
     },
     success: function(response) {

     $('#tableDetail').html(response);
     calculaTotalesPedido();
     actualizaPortafolioAgregar();



     $('.delete-item-pedido').click(function() {
     var variante = $(this).attr('data-variante');
     $.ajax({
     data: {
     "variante": variante,
     },
     url: baseRuta + '/index.php?r=Pedido/eliminarItemPedido',
     type: 'post',
     beforeSend: function() {
     $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
     },
     success: function(response) {

     $('#tableDetail').html(response);
     calculaTotalesPedido();
     actualizaPortafolioAgregar();


     }
     });
     });

     }
     });
     });

     }
     });





     });
     */




    $("#formPedidos").submit(function() {

        var cantidadProductos = $('#cantidad-enviar').val();
        var txtTotalPedido = $('#txtTotalPedido').val();
        var txtSaldoCupo = $('#txtSaldoCupo').val();
        var formaPago = $('#formaPago').val();

        if (cantidadProductos <= 0) {

            $('#alertaErrorValidar #mensaje-error').html("No se han adicionado productos al pedido -----");
            $('#alertaErrorValidar').modal('show');
            return false;

        } else if (formaPago == "credito" && parseFloat(txtTotalPedido) > parseFloat(txtSaldoCupo)) {


            $('#alertaErrorValidar #mensaje-error').html("El valor del pedido supera el cupo credito</br> del cliente.");
            $('#alertaErrorValidar').modal('show');
            return false;

        } else {
            return true;
        }


    });


    function actualizaPortafolioAgregar() {

        $.ajax({
            url: baseRuta + '/index.php?r=Pedido/AjaxActualizaPortafolioAgregar',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                var obj = jQuery.parseJSON(response);


                $('.adicionar-producto-detalle').each(function() {
                    var variante = $(this).attr('data-codigo-variante');

                    if ($(this).attr('data-nuevo') == 0) {
                        $('#imagen-producto-' + variante).attr('src', 'images/pro.png');
                    } else {
                        $('#imagen-producto-' + variante).attr('src', 'images/pronuevo.png');
                    }

                });
                $.each(obj, function(idx, obj) {
                    $('#imagen-producto-' + obj).attr('src', 'images/aceptar.png');

                });
            }
        });

    }

    function calculaTotalesPedido() {
        $.ajax({
            data: {
                'saldoCupo': $('#txtSaldoCupo').val(),
            },
            url: baseRuta + '/index.php?r=Pedido/TotalesPedido',
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


    $('#btnRecibosCaja').click(function() {
        $('#alertaCarteraPendiente').modal('hide');
        $('#alertaFrmRecibosCaja').modal('show');
    });


    $('#recaudarFacturaNo').click(function() {
        $('#alertaFrmRecibosCaja').modal('hide');
        $('#alertaFrmRecibosCajaNo').modal('show');
    });


    $('#recaudarFacturaSi').click(function() {
        var zona = $(this).attr('data-zonaVenta');
        var cluentaCliente = $(this).attr('data-cuentaCliente');

        window.location.href = "index.php?r=Recibos/index&cliente=" + cluentaCliente + "&zonaVentas=" + zona;
    });

    $('#btnCancelarNoRecaudo').click(function() {
        location.reload();
    })

    $('#recaudarFacturaSi').click(function() {
        $('#alertaFrmRecibosCaja').modal('hide');
        $('#alertaFrmRecibosFacturas').modal('show');
    });





    /********************************************************************************************************************************/


    $("#segmentoCliente").change(function() {

        var Codigo = $(this).val();
        $.ajax({
            data: {
                "Codigo": Codigo
            },
            beforeSend: function() {
                $("#img-cargar-segmentos").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            url: baseRuta + '/index.php?r=ClientesNuevos/Sementos',
            type: 'post',
            success: function(response) {
                $("#img-cargar-segmentos").html('');
                $("#subsementoCliente").html(response);
            }
        });
    });

    $("#tipoIdentificacion").change(function() {
        if ($(this).val() == '001') {
            $('#groupNombreRazonSocial').css('display', 'block');
            $('#groupEstablecimiento').css('display', 'block');

            $('#groupPrimerNombre').css('display', 'none');
            $('#groupSegundoNombre').css('display', 'none');
            $('#groupPrimerApellido').css('display', 'none');
            $('#groupSegundoApellido').css('display', 'none');
        } else {
            $('#groupNombreRazonSocial').css('display', 'none');
            $('#groupEstablecimiento').css('display', 'none');

            $('#groupPrimerNombre').css('display', 'block');
            $('#groupSegundoNombre').css('display', 'block');
            $('#groupPrimerApellido').css('display', 'block');
            $('#groupSegundoApellido').css('display', 'block');
        }
    });

    $("#frecuenciaVisita").change(function() {

        var frecuencia = $("#frecuenciaVisita").val();

        $.ajax({
            data: {
                "frecuencia": frecuencia
            },
            beforeSend: function() {
                if (frecuencia == 'k') {
                    $("#img-cargar-rutas").html('');
                } else {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                }
            },
            url: baseRuta + '/index.php?r=ClientesNuevos/CalculaRuta',
            type: 'post',
            success: function(response) {

                var visita = jQuery.parseJSON(response);


                $.each(visita, function(i, item) {

                    $(".rs-numero-visita").html(item.NumeroVisita);
                    $("#numeroVisita").val(item.NumeroVisita);
                    $(".rs-r1").html(item.R1);
                    $(".rs-r2").html(item.R2);
                    $(".rs-r3").html(item.R3);
                    $(".rs-r4").html(item.R4);
                    $("#img-cargar-rutas").html('');


                });

            }
        });


    });

    jQuery('#timepicker').timepicker({defaultTIme: false});



    /***************************** Formulario 1********************************************/

    $('#redirectClienteNuevo').click(function() {
        window.location.href = 'index.php?r=Clientes/ClientesRutas';
    });


    $('#cargar-formulario-segmentos-nit').click(function() {

        if (!validarFrmRegistrarClienteNit()) {
            return;
        } else {
            $('#frm-registrar').css('display', 'none');
            if($('#status_cliente').val() == 1){
                $('#frm-segmentos').css('display', 'block');
            }else{
                $('#frm-enrutar').css('display', 'block');

            }
        }
    });
  
    $('#cargar-formulario-segmentos').click(function() {

        if (!validarFrmRegistrarCliente()) {
            return;
        } else {
            $('#frm-registrar').css('display', 'none');
            if($('#status_cliente').val() == 1){
                $('#frm-segmentos').css('display', 'block');
            }else{
                $('#frm-enrutar').css('display', 'block');
            }
        }
    });


    $('#cargar-formulario-registrar').click(function() {
        $('#frm-registrar').css('display', 'block');
        $('#frm-segmentos').css('display', 'none');
    });


    $('#cargarPregunta').click(function() {
        var idPregunta = $('#pregunta-titulo').attr('data-pregunta');

        var cont = 0;
        $('#pregunta-respuesta .item-respuestas').each(function() {
            if ($(this).is(':checked')) {
                var idRespuesta = $(this).val();
                var idSiguientePregunta = $(this).attr('data-siguiente-pregunta');


                $.ajax({
                    data: {
                        "pregunta": idPregunta,
                        "respuesta": idRespuesta,
                        "siguientePregunta": idSiguientePregunta
                    },
                    beforeSend: function() {
                        $("#resultadoAjaxPregunta").html('Cargando... <img alt="" src="images/loaders/loader9.gif">');
                    },
                    url: baseRuta + '/index.php?r=ClientesNuevos/cargarPreguntaNueva',
                    type: 'post',
                    success: function(response) {
                        $("#resultadoAjaxPregunta").html('');
                        $('#resultadoAjaxSegmento').html('');
                        if (response == 0) {
                            $.ajax({
                                url: baseRuta + '/index.php?r=ClientesNuevos/GetEncuesta',
                                success: function(response) {
                                    $('#cargarPregunta').remove();
                                    //$('#resultadoAjaxSegmento').html(response);
                                    $('#cargarPregunta').fadeOut(100).remove().fadeIn(300);
                                    $('#resultadoAjaxSegmento').fadeOut(100).html(response).fadeIn(800);


                                    $("#cargar-formulario-enrutar").click(function() {

                                        $('#frm-segmentos').css('display', 'none');
                                        $('#frm-enrutar').css('display', 'block');
                                        $('#frm-segmentos-2').css('display', 'none');
                                        $('#frm-enrutar-2').css('display', 'block');



                                    });
                                    $('#cargar-formulario-registrar').click(function() {

                                        $('#frm-registrar').css('display', 'block');
                                        $('#frm-segmentos').css('display', 'none');
                                        $('#frm-registrar-2').css('display', 'block');
                                        $('#frm-segmentos-2').css('display', 'none');
                                    });
                                }
                            });
                        } else {

                            $("#contenido-pregunta").fadeOut(100).html(response).fadeIn(800);
                        }
                    }
                });
                cont++;
            }

        });
        if (cont == 0) {
            //alert('Debe seleccionar una respuesta');
            $('#alertaPreguntaNoSeleccionada').modal('show');
        }
    });


    $(".cargar-formulario-enrutar").click(function() {
        alert('Work');
    });

    $("#cargar-formulario-enrutar").click(function() {

        if (!validarFrmSegmentos()) {
            return;
        } else {
            $('#frm-segmentos').css('display', 'none');
            $('#frm-enrutar').css('display', 'block');
        }
    });

    $("#cargar-formulario-segmentos-back").click(function() {
        $('#frm-enrutar').css('display', 'none');
        $('#frm-segmentos').css('display', 'block');

    });

    $("#crearClienteNuevo").click(function() {

        if (!validarFrmEnrutar()) {
            return;
        } else {
            //alert('Guardar Formulario');
            $("#frm-cliente-nuevo").submit();
        }
    });
    /*******************************Formulario 2*******************************************/

    $('#cargar-formulario-segmentos-2').click(function() {

        $('#frm-registrar-2').css('display', 'none');
        $('#frm-segmentos-2').css('display', 'block');

    });

    $('#cargar-formulario-registrar-2').click(function() {
        $('#frm-registrar-2').css('display', 'block');
        $('#frm-segmentos-2').css('display', 'none');
    });

    $("#cargar-formulario-enrutar-2").click(function() {

        $('#frm-segmentos-2').css('display', 'none');
        $('#frm-enrutar-2').css('display', 'block');

    });

    $("#cargar-formulario-segmentos-back-2").click(function() {
        $('#frm-enrutar-2').css('display', 'none');
        $('#frm-segmentos-2').css('display', 'block');

    });

    $("#crearClienteNuevo-2").click(function() {

        if (!validarFrmEnrutar()) {
            return;
        } else {
            alert('El cliente nuevo no se puede crear');
        }
    });

    /***************************** Formulario 3********************************************/
    $('#cargar-formulario-segmentos-3').click(function() {

        $('#frm-registrar-3').css('display', 'none');
        $('#frm-segmentos-3').css('display', 'block');

    });

    $('#cargar-formulario-registrar-3').click(function() {
        $('#frm-registrar-3').css('display', 'block');
        $('#frm-segmentos-3').css('display', 'none');
    });

    $("#cargar-formulario-enrutar-3").click(function() {

        $('#frm-segmentos-3').css('display', 'none');
        $('#frm-enrutar-3').css('display', 'block');

    });

    $("#cargar-formulario-segmentos-back-3").click(function() {
        $('#frm-enrutar-3').css('display', 'none');
        $('#frm-segmentos-3').css('display', 'block');

    });

    $("#crearClienteNuevo-3").click(function() {

        if (!validarFrmEnrutar()) {
            return;
        } else {
            $("#frm-cliente-nuevo").submit();
        }
    });
    /**************************Formulario 4************************************************/

    $('#cargar-formulario-segmentos-4').click(function() {

        if (!validarFrmUpdateCliente()) {
            return;
        } else {
            $('#frm-registrar-4').css('display', 'none');
            $('#frm-segmentos-4').css('display', 'block');
        }

    });

    $('#cargar-formulario-registrar-4').click(function() {
        $('#frm-registrar-4').css('display', 'block');
        $('#frm-segmentos-4').css('display', 'none');
    });

    $("#cargar-formulario-enrutar-4").click(function() {
        if (!validarFrmSegmentos()) {
            return;
        } else {
            $('#frm-segmentos-4').css('display', 'none');
            $('#frm-enrutar-4').css('display', 'block');
        }
    });

    $("#cargar-formulario-segmentos-back-4").click(function() {
        $('#frm-enrutar-4').css('display', 'none');
        $('#frm-segmentos-4').css('display', 'block');

    });

    $("#crearClienteNuevo-4").click(function() {

        if (!validarFrmEnrutar()) {
            return;
        } else {
            $("#frm-cliente-nuevo").submit();
        }
    });

    /****************************************************************************/

    $("#enrutar-cliente-activo-zona").click(function() {
        $("#alertaEnrutar").modal('show');
    });

    $("#cerrarAlertaEnrutar").click(function() {

        $("#alertaEnrutar").modal('hide');
        $("#alertaEnrutarNuevo").modal("show");
    });

    $("#cargar-formulario-rutero-activo-true").click(function() {

        $('#frm-registrar-activo-true').css('display', 'none');
        $('#frm-enrutar-activo-true').css('display', 'block');

    });

    $("#cargar-formulario-registrar-activo-true").click(function() {

        $('#frm-registrar-activo-true').css('display', 'block');
        $('#frm-enrutar-activo-true').css('display', 'none');

    });


    /*********************btn transaccion en consignacion funcion boton*********************************/


    /*$('#btn-adicionar-producto-consignacion').click(function() {

     var codigoVariante = $('#textDetCodigoProducto').text();
     var descripcion = $('#textDetNombreProducto').text();
     var textDetIva = $('#textDetIva').val();
     var textDetSaldo = $('#textDetSaldo').val();
     var textVariante = $('#textCodigoVariante').val();
     var textDetValorProducto = $('#textDetValorProducto').val();
     var textDetImpoconsumo = $('#textDetImpoconsumo').val();
     var txtCantidadPedida = $('#txtCantidadPedida').val();
     var txtSaldoLimite = $('#txtSaldoLimite').val();
     var txtDescuentoProveedor = $('#txtDescuentoProveedor').val();
     var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
     var txtDescuentoEspecial = $('#txtDescuentoEspecial').val();
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

     $('#alertaACDLCantidad #mensaje-error').html('“El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, desea enviar la cantidad pendiente con el precio normal”');
     $('#alertaACDLCantidad').modal('show');
     return;
     }

     $.ajax({
     data: {
     "nombreProducto": descripcion,
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
     "aplicaImpoconsumo": true
     },
     url: baseRuta + '/index.php?r=TransferenciaConsignacion/agregarItemPedido',
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
     "variante": variante,
     },
     url: baseRuta + '/index.php?r=TransferenciaConsignacion/eliminarItemPedido',
     type: 'post',
     beforeSend: function() {
     $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
     },
     success: function(response) {

     $('#tableDetail').html(response);
     calculaTotalesPedidoTransferencia();
     actualizaPortafolioAgregar();



     $('.delete-item-pedido').click(function() {
     var variante = $(this).attr('data-variante');
     $.ajax({
     data: {
     "variante": variante,
     },
     url: baseRuta + '/index.php?r=TransferenciaConsignacion/eliminarItemPedido',
     type: 'post',
     beforeSend: function() {
     $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
     },
     success: function(response) {

     $('#tableDetail').html(response);
     calculaTotalesPedidoTransferencia();
     actualizaPortafolioAgregar();


     }
     });
     });

     }
     });
     });

     }
     });





     });*/


});



/////validaciones de el formulario nit

function validarFrmRegistrarClienteNit() {

    limpiarErrorFrmRegistrarClienteNit();

    if ($("#establecimientoNit").val() == "") {
        $("#errorEstablecimiento").html('Este campo es obligatorio.');
        $("#errorEstablecimiento").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#tipoIdentifica").val() == "") {
        $("#errorTipoIdentificacion").html('Este campo es obligatorio.');
        $("#errorTipoIdentificacion").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#nit").val() == "") {
        $("#errorNitCedula").html('Este campo es obligatorio.');
        $("#errorNitCedula").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#codigoCiiuNit").val() == "") {
        $("#errorcodigoCiiuNit").html('Este campo es obligatorio.');
        $("#errorcodigoCiiuNit").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#nombreRazonSocial").val() == "") {
        $("#errorNombreRazonSocial").html('Este campo es obligatorio.');
        $("#errorNombreRazonSocial").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#establecimiento").val() == "") {
        $("#errorEstablecimiento").html('Este campo es obligatorio.');
        $("#errorEstablecimiento").css('display', 'block');
        $(this).focus();
        return false;

    }

    if ($("#Ciudades").val() == '0') {
        $("#errorCiudades").html('Este campo es obligatorio.');
        $("#errorCiudades").css('display', 'block');
        $(this).focus();
        return false;
    }


    if ($(".Barrios98").val() == "" && $("#OtroBarrioNit").val() == "") {
        $("#errorBarrios").html('Ingrese un barrio o seleccione un barrio.');
        $("#errorBarrios").css('display', 'block');
        $(this).focus();
        return false;
    }

    var cont = 0;
    var cont2 = 0;
    if ($("#vianit").val() == 0) {

        cont = cont + 1;
        cont2 = cont2 + 1;
    }

    if ($("#direcnit").val() == "") {

        cont = cont + 1;

    }

    if ($("#numeronit").val() == "") {

        cont = cont + 1;
    }


    if (cont >= 2) {

        if ($("#tipoviacomplementonit").val() == 0 || $("#direccioncomplementarianit").val() == "") {

            $("#errorTipocomplemento").html('Estos campos son obligatorios.');
            $("#errorTipocomplemento").css('display', 'block');
            $(this).focus();
            return false;

        }

    } else if (cont2 == 1) {

        if ($("#tipoviacomplementonit").val() == 0 || $("#direccioncomplementarianit").val() == "") {

            $("#errorTipocomplemento").html('Estos campos son obligatorios.');
            $("#errorTipocomplemento").css('display', 'block');
            $(this).focus();
            return false;

        }
    }


    if ($("#direccionnit").val() == "") {
        $("#errorDireccion").html('Este campo es obligatorio.');
        $("#errorDireccion").css('display', 'block');
        $(this).focus();
        return false;
    }

    return true;

}


//////validaciones de el formulario 

function validarFrmRegistrarCliente() {

    limpiarErrorFrmRegistrarCliente();


    if ($("#tipoIdentificacionCedula").val() == "") {
        $("#errorTipoIdentificacion").html('Este campo es obligatorio.');
        $("#errorTipoIdentificacion").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#Cedula").val() == "") {
        $("#errorNitCedula").html('Este campo es obligatorio.');
        $("#errorNitCedula").css('display', 'block');
        $(this).focus();
        return false;
    }


    if ($("#primerNombre").val() == "") {
        // alert($("#primerNombre").css('display'));
        $("#errorPrimerNombre").html('Este campo es obligatorio.');
        $("#errorPrimerNombre").css('display', 'block');
        $(this).focus();
        return false;
    }


    if ($("#primerApellido").val() == "") {
        $("#errorPrimerApellido").html('Este campo es obligatorio.');
        $("#errorPrimerApellido").css('display', 'block');
        $(this).focus();
        return false;
    }



    if ($("#codigoCiiuPersona").val() == "") {
        $("#errorCodigoCiiuPersona").html('Este campo es obligatorio.');
        $("#errorCodigoCiiuPersona").css('display', 'block');
        $(this).focus();
        return false;
    }



    if ($("#establecimientoPersona").val() == "") {
        $("#errorEstablecimientoPersona").html('Este campo es obligatorio.');
        $("#errorEstablecimientoPersona").css('display', 'block');
        $(this).focus();
        return false;

    }

    if ($("#Ciudades").val() == '0') {
        $("#errorCiudades").html('Este campo es obligatorio.');
        $("#errorCiudades").css('display', 'block');
        $(this).focus();
        return false;
    }


    if ($(".Barrios98").val() == "" && $("#OtroBarrioPersona").val() == "") {
        $("#errorBarrios").html('Ingrese un barrio o seleccione un barrio.');
        $("#errorBarrios").css('display', 'block');
        $(this).focus();
        return false;
    }

    var cont = 0;
    var cont2 = 0;
    if ($("#via").val() == 0) {

        cont = cont + 1;
        cont2 = cont2 + 1;
    }

    if ($("#direc").val() == "") {

        cont = cont + 1;

    }

    if ($("#numero").val() == "") {

        cont = cont + 1;
    }


    if (cont >= 2) {

        if ($("#tipoviacomplemento").val() == 0 || $("#direccioncomplementaria").val() == "") {

            $("#errorTipocomplemento").html('Estos campos son obligatorios.');
            $("#errorTipocomplemento").css('display', 'block');
            $(this).focus();
            return false;

        }

    } else if (cont2 == 1) {

        if ($("#tipoviacomplemento").val() == 0 || $("#direccioncomplementaria").val() == "") {

            $("#errorTipocomplemento").html('Estos campos son obligatorios.');
            $("#errorTipocomplemento").css('display', 'block');
            $(this).focus();
            return false;

        }
    }

    if ($("#direccion").val() == "") {
        $("#errorDireccion").html('Este campo es obligatorio.');
        $("#errorDireccion").css('display', 'block');
        $(this).focus();
        return false;
    }

    return true;

}


function validarFrmSegmentos() {


    limpiarErrorFrmSegmentosClientes();

    if ($("#tipoRegistroCliente").val() == "") {
        $("#errorTipoRegistroCliente").html('Este campo es obligatorio.');
        $("#errorTipoRegistroCliente").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#segmentoCliente").val() == "") {
        $("#errorSegmentoCliente").html('Este campo es obligatorio.');
        $("#errorSegmentoCliente").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#subsementoCliente").val() == "") {
        $("#errorSubsementoCliente").html('Este campo es obligatorio.');
        $("#errorSubsementoCliente").css('display', 'block');
        $(this).focus();
        return false;
    }

    return true;

}

function validarFrmEnrutar() {


    if ($("#frecuenciaVisita").val() == "k") {

        $("#mensaje-error").html('No ha seleccionado una frecuencia de visita');
        $("#alertaFrecuenciaNoSeleccionada").modal('show');
        return false;
    }

    if ($("#datepicker-inline").val() == "") {

        $("#mensaje-error").html('Seleccione el dia de visita');
        $("#alertaFrecuenciaNoSeleccionada").modal('show');
        return false;
    }

    if ($("#timepicker").val() == "") {
        $("#mensaje-error").html('No ha selecionado una hora de visita');
        $("#alertaFrecuenciaNoSeleccionada").modal('show');
        return false;
    }


    return true;
}


function validarFrmUpdateCliente() {

    limpiarErrorFrmUpdateCliente();

    if ($("#NitCedula").val() == "") {
        $("#errorNitCedula").html('Este campo es obligatorio.');
        $("#errorNitCedula").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#codigoCliente").val() == "") {
        $("#errorCodigoCliente").html('Este campo es obligatorio.');
        $("#errorCodigoCliente").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#CodigoCiuu").val() == "") {
        $("#errorCodigoCiuu").html('Este campo es obligatorio.');
        $("#errorCodigoCiuu").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#codigoZonaVenta").val() == "") {
        $("#errorCodigoZonaVenta").html('Este campo es obligatorio.');
        $("#errorCodigoZonaVenta").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#nombreAsesor").val() == "") {
        $("#errorNombreAsesor").html('Este campo es obligatorio.');
        $("#errorNombreAsesor").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#Departamentos").val() == "") {
        $("#errorDepartamento").html('Este campo es obligatorio.');
        $("#errorDepartamento").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#Ciudades").val() == "") {
        $("#errorCiudad").html('Este campo es obligatorio.');
        $("#errorCiudad").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#Barrios").val() == "") {
        $("#errorBarrio").html('Este campo es obligatorio.');
        $("#errorBarrio").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#Direccion").val() == "") {
        $("#errorDireccion").html('Este campo es obligatorio.');
        $("#errorDireccion").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#Telefono").val() == "") {
        $("#errorTelefono").html('Este campo es obligatorio.');
        $("#errorTelefono").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#TelefonoMovil").val() == "") {
        $("#errorTelefonoMovil").html('Este campo es obligatorio.');
        $("#errorTelefonoMovil").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#CorreoElectronico").val() == "") {
        $("#errorCorreoElectronico").html('Este campo es obligatorio.');
        $("#errorCorreoElectronico").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#grupoVentas").val() == "") {
        $("#errorGrupoVentas").html('Este campo es obligatorio.');
        $("#errorGrupoVentas").css('display', 'block');
        $(this).focus();
        return false;
    }

    if ($("#nombreGrupoVentas").val() == "") {
        $("#errorNombreGrupoVentas").html('Este campo es obligatorio.');
        $("#errorNombreGrupoVentas").css('display', 'block');
        $(this).focus();
        return false;
    }

    return true;


}


function limpiarErrorFrmUpdateCliente() {

    $("#errorNitCedula").css('display', 'none');
    $("#errorCodigoCliente").css('display', 'none');
    $("#errorCodigoCiuu").css('display', 'none');
    $("#errorCodigoZonaVenta").css('display', 'none');
    $("#errorNombreAsesor").css('display', 'none');
    $("#errorDepartamento").css('display', 'none');
    $("#errorCiudad").css('display', 'none');
    $("#errorBarrio").css('display', 'none');
    $("#errorDireccion").css('display', 'none');
    $("#errorTelefono").css('display', 'none');
    $("#errorTelefonoMovil").css('display', 'none');
    $("#errorCorreoElectronico").css('display', 'none');
    $("#errorGrupoVentas").css('display', 'none');
    $("#errorNombreGrupoVentas").css('display', 'none');


}


//////limpiar formulario nit

function limpiarErrorFrmRegistrarClienteNit() {

    $("#errorcodigoCiiuNit").css('display', 'none');
    $("#errorNombreRazonSocial").css('display', 'none');
    $("#errorEstablecimiento").css('display', 'none');
    $("#errorCiudades").css('display', 'none');
    $("#errorBarrios").css('display', 'none');
    $("#errorDireccion").css('display', 'none');
    $("#errorTelefono").css('display', 'none');
    $("#errorTelefonoMovil").css('display', 'none');
    $("#errorCorreo").css('display', 'none');

}

//////limpiar formulario persona

function limpiarErrorFrmRegistrarCliente() {

    $("#errorPrimerNombre").css('display', 'none');
    $("#errorSegundoNombre").css('display', 'none');
    $("#errorPrimerApellido").css('display', 'none');
    $("#errorSegundoApellido").css('display', 'none');
    $("#errorCodigoCiiuPersona").css('display', 'none');
    $("#errorEstablecimientoPersona").css('display', 'none');
    $("#errorCiudades").css('display', 'none');
    $("#errorBarrios").css('display', 'none');
    $("#errorDireccion").css('display', 'none');
    $("#errorTelefono").css('display', 'none');
    $("#errorTelefonoMovil").css('display', 'none');
    $("#errorCorreo").css('display', 'none');
    $("#errorTipocomplemento").css('display', 'none');

}

function limpiarErrorFrmSegmentosClientes() {
    $("#errorTipoRegistroCliente").css('display', 'none');
    $("#errorSegmentoCliente").css('display', 'none');
    $("#errorSubsementoCliente").css('display', 'none');
}

function limparFrmRegistrarCliente() {
    $("#tipoIdentificacion").val('');
    $("#nitCedula").val('');
    $("#codigoCiiu").val('');
    $("#nombreRazonSocial").val('');
    $("#establecimiento").val('');
    //$("#Departamentos").val('');	
    //$("#Ciudades").val('');	
    //$("#Barrios").val();
    $("#direccion").val('');
    $("#telefono").val('');
    $("#telefonoMovil").val('');
    $("#correo").val('');

}



