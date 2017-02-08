
var precionaBotonDescuentos = 'false';
var discountLinea = "";
var discountMultilinea = "";

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

    $('body').on('click','.ok',function(){
        
       location.reload(); 
    });

    if (typeof history.pushState === "function") {
        history.pushState("jibberish", null, null);
        window.onpopstate = function() {
            history.pushState('newjibberish', null, null);
            // Handle the back (or forward) buttons here
            // Will NOT handle refresh, use onbeforeunload for this.
        };
    }else {
        var ignoreHashChange = true;
        window.onhashchange = function() {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
            }else {
                ignoreHashChange = false;
            }
        };
    }

    jQuery('#tabsCrearPedidoPreventa').bootstrapWizard({
        tabClass: 'nav nav-pills nav-justified nav-disabled-click',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onNext: function(tab, navigation, index) {
            var $valid = jQuery('#frmPedidoPreventa').valid();
            if (!$valid) {

                $validator.focusInvalid();
                return false;
            }
        }
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

    jQuery('#dtpFechaEntrega').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 'today',
        beforeShow: function(i) {
            if ($(i).attr('readonly')) {
                return false;
            }
        }
    });

    $("#plazo").keypress(function(tecla) {
        if (tecla.charCode < 48 || tecla.charCode > 57)
            return false;
    });

    var formasPago = $('#plazo').html();

    $('#formaPagoPreventa').change(function() {

        if ($(this).val() == '') {
            $('#plazo').attr('disabled', 'disabled');
        }

        if ($(this).val() == 'contado') {

            $('#plazo').html('<option value="022" >0 Días</option>');
            $('#plazo').removeAttr('disabled');

            // $('#plazo').val('0');
            // $('#plazo').attr('max', '0');
            // $('#plazo').attr('min', '0');
            // $('#plazo').attr('readonly', 'readonly');

            //var f = new Date();
            //var mes = '';

            //if ((f.getMonth() + 1) < 10) {
            mes = '0' + (f.getMonth() + 1);
            //}

            //var fechaActual = ((f.getFullYear() + "-" + mes + "-" + f.getDate()));
            //$('#dtpFechaEntrega').val(fechaActual);
            //$("#dtpFechaEntrega").attr('readonly', 'readonly');
            //var cadena = '<option>No</option>';
            //$('#actividadEspecial').html(cadena);

        }
        if ($(this).val() == 'credito') {

            $('#plazo').html(formasPago);
            $('#plazo').removeAttr('disabled');

            //var diasPago = $("option:selected", this).attr("data-dias-pago");
            //alert(diasPago);

            //$('#plazo').val(diasPago);
            //$('#plazo').attr('max', diasPago);
            //$('#plazo').attr('min', '1');
            //$('#plazo').removeAttr('readonly');
            // $('#dtpFechaEntrega').removeAttr('readonly');

            /*var cadena = '<option value="">Seleccione la Actividad Especial</option>';
             cadena += '<option value="No">No</option>';
             cadena += '<option value="Si">Si</option>';
             $('#actividadEspecial').html(cadena);*/

            jQuery('#tabsCrearPedidoPreventa').bootstrapWizard({
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
        }
    });

    $('#tblPortafolioPreventa').DataTable({
        "bDestroy": true,
        "sPaginationType": "full_numbers",
    });

    //

    $('#tblPortafolioVentaDirecta').DataTable({
        "bDestroy": true,
        "sPaginationType": "full_numbers",
    });


    $('#tblPortafolioConsignacion').DataTable({
        "bDestroy": true,
        "sPaginationType": "full_numbers",
    });


    /*$('.btnAdicionarProductoDetalleAct').click(function(){
     alert("");
     });*/

    $('.btnAdicionarSinPrecio').click(function() {
        $('#alertaArticuloSinAcuerdo').modal('show');
    });


    $('.btnAdicionarSinSaldo').click(function() {
        $('#alertaArticuloSinSaldo').modal('show');
    });


    $('body').on('click', '.btnAdicionarKitVirtual', function() {

        if(precionaBotonDescuentos == 'false'){

            var txtCodigoVariante = $(this).attr('data-CodigoVariante');
            var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
            var txtNombreArticulo = $(this).attr('data-NombreArticulo');
            var txtCodigoCaracteristica1 = $(this).attr('data-CodigoCaracteristica1');
            var txtCodigoCaracteristica2 = $(this).attr('data-CodigoCaracteristica2');
            var txtCodigoTipo = $(this).attr('data-CodigoTipo');
            var txtCliente = $(this).attr('data-cliente');
            var txtNombreUnidadMedidaPrecioVenta = $(this).attr('data-ACCodigoUnidadMedida');
            $.ajax({
                data: {
                    "txtCodigoVariante": txtCodigoVariante,
                    "txtCodigoArticulo": txtCodigoArticulo,
                    "txtNombreArticulo": txtNombreArticulo,
                    "txtCodigoCaracteristica1": txtCodigoCaracteristica1,
                    "txtCodigoCaracteristica2": txtCodigoCaracteristica2,
                    "txtCodigoTipo": txtCodigoTipo,
                    "txtCliente": txtCliente,
                    "txtNombreUnidadMedidaPrecioVenta": txtNombreUnidadMedidaPrecioVenta
                },
                url: 'index.php?r=Preventa/AjaxGetKitVirtual',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {
                    $('#contMdlKitVirtual').html(response);
                    $('#mdlKitVirtual').modal('show');
                    //iniBtnAdicionarProductoDetalleAct(false);
                }
            });
        }

    });

    function iniBtnAdicionarKitVirtual() {

        $('.btnAdicionarKitVirtual').click(function() {

            if(precionaBotonDescuentos == 'false'){
                var txtCodigoVariante = $(this).attr('data-CodigoVariante');
                var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
                var txtNombreArticulo = $(this).attr('data-NombreArticulo');
                var txtCodigoCaracteristica1 = $(this).attr('data-CodigoCaracteristica1');
                var txtCodigoCaracteristica2 = $(this).attr('data-CodigoCaracteristica2');
                var txtCodigoTipo = $(this).attr('data-CodigoTipo');
                var txtCliente = $(this).attr('data-cliente');
                var txtNombreUnidadMedidaPrecioVenta = $(this).attr('data-ACCodigoUnidadMedida');

                $.ajax({
                    data: {
                        "txtCodigoVariante": txtCodigoVariante,
                        "txtCodigoArticulo": txtCodigoArticulo,
                        "txtNombreArticulo": txtNombreArticulo,
                        "txtCodigoCaracteristica1": txtCodigoCaracteristica1,
                        "txtCodigoCaracteristica2": txtCodigoCaracteristica2,
                        "txtCodigoTipo": txtCodigoTipo,
                        "txtCliente": txtCliente,
                        "txtNombreUnidadMedidaPrecioVenta": txtNombreUnidadMedidaPrecioVenta
                    },
                    url: 'index.php?r=Preventa/AjaxGetKitVirtual',
                    type: 'post',
                    beforeSend: function() {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function(response) {
                        $('#contMdlKitVirtual').html(response);
                        $('#mdlKitVirtual').modal('show');
                        //iniBtnAdicionarProductoDetalleAct(false);
                    }
                });
            }
        });

    }

    $("body").on('click', '.btnAdicionarKitDinamico', function() {
    //$('.btnAdicionarKitDinamico').click(function() {

        if(precionaBotonDescuentos == 'false'){

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
                url: 'index.php?r=Preventa/AjaxGetKitComponente',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {
                    $('#contMdlKitDinamico').html(response);
                    $('#mdlKitDinamico').modal('show');

                    //iniBtnAdicionarProductoDetalleAct(true);

                }
            });
        }

    });


    function iniBtnAdicionarKitDinamico() {

        $('.btnAdicionarKitDinamico').click(function() {
            if(precionaBotonDescuentos == 'false'){

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
                    url: 'index.php?r=Preventa/AjaxGetKitComponente',
                    type: 'post',
                    beforeSend: function() {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function(response) {
                        $('#contMdlKitDinamico').html(response);
                        $('#mdlKitDinamico').modal('show');

                        //iniBtnAdicionarProductoDetalleAct(true);

                    }
                });
            }

        });



    }


    $("body").on('click','#btnDescuentos', function(){
        precionaBotonDescuentos = 'true'
        var txtCodigoVariante = $(this).attr('data-CodigoVariante');
        var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
        var txtCliente = $('#txtCuentaCliente').val();
        var txtZonaVentas = $('#txtZonaVentas').val();
        var txtCodigoGrupoDescuentoLinea = $(this).attr('data-CodigoGrupoDescuentoLinea');
        var txtCodigoGrupoDescuentoMultiLinea = $(this).attr('data-CodigoGrupoDescuentoMultiLinea');
        var txtNombreArticulo = $(this).attr('data-NombreArticulo');
        //debugger;

        $.ajax({
            data:{
                'txtCodigoVariante': txtCodigoVariante,
                'txtArticulo': txtCodigoArticulo,
                'txtClienteDetalle': txtCliente,
                'txtZonaVentas': txtZonaVentas,
                'txtCodigoGrupoDescuentoLinea': txtCodigoGrupoDescuentoLinea,
                'txtCodigoGrupoDescuentoMultiLinea': txtCodigoGrupoDescuentoMultiLinea,
                'txtNombreArticulo': txtNombreArticulo

            },
            url: 'index.php?r=Preventa/AjaxConsultarDescuentos',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },

            success: function(response){
                $('#tableEscalaDescuentos').html(response);
                $('#detalleEscalaDescuentos').modal('show');
                precionaBotonDescuentos = 'false'
            }

        });
    //alert("preciono el boton de descuetnos");

    });




    $("body").on('click', '.btnAdicionarProductoDetalleAct', function() {

        if(precionaBotonDescuentos == 'false'){
        //$('.btnAdicionarProductoDetalleAct').click(function() {

            var txtCodigoVariante = $(this).attr('data-CodigoVariante');
            var txtCodigoArticulo = $(this).attr('data-CodigoArticulo');
            var txtZonaVentas = $('#txtZonaVentas').val();
            var txtCliente = $('#txtCuentaCliente').val();
            var txtCodigoAcuerdoPrecioVenta = $(this).attr('data-ACCodigoUnidadMedida');
            var txtNombreUnidadMedidaPrecioVenta = $(this).attr('data-ACNombreUnidadMedida');
            var txtKit = $(this).attr('data-kit');
            var txtTipoKit = $(this).attr('data-tipo-kit');
            var txtLote = $(this).attr('data-lote');
            var txtSaldo = $(this).attr('data-saldo');
            var tipoVenta = $('#select-tipo-venta-preventa').val();


            if (txtKit) {

                var valida = '';
                if (txtTipoKit == 'dinamico') {
                    valida = true;
                } else {
                    valida = false;
                }


                var conta = 0;
                var cant = new Array();
                $('.txtCantidadItem').each(function() {

                    cant[conta] = $(this).val();
                    conta++;
                });

                var cont = 1;
                var cont_3 = 0;
                if (txtTipoKit == "dinamico" && validarKitDinamico()) {
                    kitDinamico = [];
                    $(".itemKitDinamico").each(function() {

                        var kit = {
                            txtKitCodigoArticuloKit: $(this).attr('data-kit-CodigoArticuloKit'),
                            txtKitCodigoListaMateriales: $(this).attr('data-kit-CodigoListaMateriales'),
                            txtKitCodigoArticuloComponente: $(this).attr('data-kit-CodigoArticuloComponente'),
                            txtKitNombre: $(this).attr('data-kit-Nombre'),
                            txtKitCodigoUnidadMedida: $(this).attr('data-kit-CodigoUnidadMedida'),
                            txtKitCodigoTipo: $(this).attr('data-kit-CodigoTipo'),
                            txtKitFijo: $(this).attr('data-kit-Fijo'),
                            txtKitOpcional: $(this).attr('data-kit-Opcional'),
                            txtKitPrecioVentaBaseVariante: $(this).attr('data-kit-TotalPrecioVentaBaseVariante'),
                            txtKitCodigoVarianteComponente: $(this).attr('data-kit-CodigoVarianteComponente'),
                            txtKitNombreUnidadMedida: $(this).attr('data-kit-NombreUnidadMedida'),
                            txtkitiva: $(this).attr('data-kit-iva'),
                            txtkitipoconsumo:  $(this).attr('data-kit-ipoconsumo'),
                            cantidad: cant[cont_3],
                        }; 
                        
                        kitDinamico.push(kit);
                        
                        // var codigo = txtKitCodigoArticuloComponente + "-" + txtKitFijo + "-" + txtKitOpcional;
                        // var cantidad = $('#txtInputKit-' + codigo).val();

                        //if (cantidad != "") {

                        /*$.ajax({
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
                                "txtKitNombreUnidadMedida":txtKitNombreUnidadMedida,
                                "txtkitiva":txtkitiva,
                                "txtkitipoconsumo":txtkitipoconsumo,
                                "txtCantidad": cant[cont_3],
                            },
                            url: 'index.php?r=Preventa/AjaxGuardarKitDinamico',
                            type: 'post',
                            beforeSend: function() {
                                $(".imgDivKit").html('<img alt="" src="images/loaders/loader9.gif">');
                            },
                            success: function(response) {
                                $(".imgDivKit").html('');

                            }
                        });*/
                        //}

                        cont++;
                        cont_3++;
                    });
                    
                    $.ajax({
                        data: {
                            'kitDinamico': JSON.stringify(kitDinamico),
                        },
                        url: 'index.php?r=Preventa/AjaxGuardarKitDinamico',
                        type: 'post',
                        beforeSend: function() {
                            $(".imgDivKit").html('<img alt="" src="images/loaders/loader9.gif">');
                        },
                        success: function(response) {
                            $(".imgDivKit").html('');
                        }
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
                        var txtKitNombreUnidadMedida = $(this).attr('data-kit-NombreUnidadMedida');
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
                                "txtKitCodigoVarianteComponente": txtKitCodigoVarianteComponente,
                                "txtKitNombreUnidadMedida":txtKitNombreUnidadMedida


                            },
                            url: 'index.php?r=Preventa/AjaxGuardarKitDinamico',
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
                            "txtSaldo": txtSaldo,
                            "tipokit":txtTipoKit
                        },
                        url: 'index.php?r=Preventa/AjaxGetDetalleArticulo',
                        type: 'post',
                        beforeSend: function() {
                            $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                        },
                        success: function(response) {
                          //  debugger;
                            console.log(response);

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
                                   // iniCantidadAcuerdos();
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
                               // iniCantidadAcuerdos();
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
                        "txtZonaVentas": txtZonaVentas,
                        "txtCliente": txtCliente,
                        "txtCodigoAcuerdoPrecioVenta": txtCodigoAcuerdoPrecioVenta,
                        "txtNombreUnidadMedidaPrecioVenta": txtNombreUnidadMedidaPrecioVenta,
                        "tipoVenta": tipoVenta,
                        "txtLote": txtLote,
                        "txtSaldo": txtSaldo
                    },
                    url: 'index.php?r=Preventa/AjaxGetDetalleArticulo',
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
                        $('.txtCantidadPedida').prop('readonly', true);

                        window.setTimeout(function() {
                        $('.txtCantidadPedida').prop('readonly', false);

                        }, 100);

                        iniBtnAdicionalrProducto();
                        iniSelectResponsable();
                        iniValidarCantidad();
                       // iniCantidadAcuerdos();
                        cargarlote();




                        /*if ($("#actividadEspecial").val() == "si") {
                         $("#sltResposableDescuento").attr('disabled', 'disabled');
                         $('.txtDescuentoEspecial').attr('disabled', 'disabled');
                         $("#actividadEspecial").attr('disabled', 'disabled');
                         }*/





                    }
                });

            }
        }

    });

    function iniSelectResponsable() {

        $('#sltResposableDescuento').change(function() {

            var responsable = $(this).val();
            var descuentoEspecial = $('.txtDescuentoEspecial').val();

            if (descuentoEspecial == "" && responsable != "Ninguno") {

                $('#alertaErrorValidar').css("z-index", "15000");
                $('#alertaErrorValidar #mensaje-error').html('El Descuento especial no puede sero 0 o estar vacio.');
                $('#alertaErrorValidar').modal('show');
                $(this).val('Ninguno');

                return false;
            } else {
                var cadena = '';
                $('.contDescuentoEspecial').html('');
                if (responsable == "Compartidos") {
                    cadena += "<label>Dcto Proveedor</label><input type='text' value='' placeholder='Dcto Proveedor'  min='0' max='100' class='form-control txtDescuentoEspecialProveedor'/><br/>";
                    cadena += "<label>Dcto Altipal</label><input type='text' value='' placeholder='Dcto Altipal' min='0' max='100' class='form-control txtDescuentoEspecialAltipal'/><br/>";
                }

                $('.contDescuentoEspecial').append(cadena);

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
        else {
            return true;
        }//return true;
    }





    $('#tblPortafolioAutoventa').dataTable({
        "bDestroy": true,
        "bPaginate": false,
    });


    $('body').on('click','#btnMostrarPortafolio',function(){
        
     
        var cuentaproveedor = $('#Proveedores').val();
         
        var tipoVenta = $('#select-tipo-venta-preventa option:selected').val();


        if (tipoVenta == "Consignacion") {
            $('#portafolioConsignacion').modal('show');
        } else if (tipoVenta == "VentaDirecta") {

           
             $.ajax({
                data: {
                    "cuentaproveedor": cuentaproveedor
                },
                url: 'index.php?r=Preventa/AjaxCargarVentaDirecta',
                type: 'post',
                success: function(response) {

                  

                        $("#portafolioDirecta").html(response);
                        $('#portafolioVentaDirecta').modal('show');

                        $('#tblPortafolioVentaDirecta').dataTable({
                            "bDestroy": true,
                            "sPaginationType": "full_numbers",
                        });
                        
                    
                }
            });
           
        } else {
          
                        $('#portafolioPreventa').modal('show');
                     
           
        }
      
        
    });


    var tipoVentaSeleccionada;



    $('#select-tipo-venta-preventa').focus(function() {
        tipoVentaSeleccionada = $("#select-tipo-venta-preventa option:selected").val();
    });

    $('#select-tipo-venta-preventa').change(function() {


        var consignacion = $("#select-tipo-venta-preventa").val();
        var cedulaasesor = $("#txtCedulAasesor").val();
        var ventaDirecta = $("#select-tipo-venta-preventa").val();


        if (consignacion == 'Consignacion') {

            $.ajax({
                data: {
                    "cedulaasesor": cedulaasesor
                },
                url: 'index.php?r=Preventa/AjaxValidarConsignacion',
                type: 'post',
                success: function(response) {

                    if (response == 0) {

                        $("#_alerta .text-modal-body").html('Usted no puede hacer pedidos de tipo venta consignacón, no cuenta con saldo disponible');
                        $("#_alerta").modal('show');
                        $('#select-tipo-venta-preventa').val($('#select-tipo-venta-preventa').prop('defaultSelected'));
                        return false;
                    }
                }
            });

        }


        if (ventaDirecta == 'VentaDirecta') {


            var GrupoVentas = $(this).children('option:selected').attr('data-grupoVenta');
            var codezonaventas = $("#txtzonaventas").val();
            $.ajax({
                data: {
                    "GrupoVentas": GrupoVentas,
                    "CodeZonaVentas":codezonaventas
                },
                url: 'index.php?r=Preventa/AjaxProveedoresGrupoVentas',
                type: 'post',
                success: function(response) {

                    $('#proveedor').html('Proveedor');
                    $('#SelectProveedores').html(response);

                }
            });
        } else {

            $('#proveedor').html('');
            $('#SelectProveedores').html('');

        }


        var rowCount = $('#tableDetail tbody tr').length;

        if (rowCount > 0) {
            $('#_alertCambiarTipoVenta').modal('show');

            $('#btnCambiarTipoVentaSi').click(function() {
                $.ajax({
                    data: {
                        "saldoInventario": saldoInventario,
                    },
                    url: 'index.php?r=Preventa/AjaxResetPedido',
                    type: 'post',
                    success: function(response) {
                        $('#tableDetail').html(response);
                        calculaTotalesPedido();
                        actualizaPortafolioAgregar();
                        iniActualizarProductos();
                        $('#_alertCambiarTipoVenta').modal('hide');
                    }
                });
            });

            $('#btnCambiarTipoVentaNo').click(function() {
                $("#select-tipo-venta-preventa").val(tipoVentaSeleccionada);
                $('#_alertCambiarTipoVenta').modal('hide');
            });

        }


        var saldoInventario;
        if ($(this).val() == 'Consignacion') {
            saldoInventario = 'Autoventa';

        } else if (($(this).val() == 'VentaDirecta')) {
            saldoInventario = 'VentaDirecta';
        } else {
            saldoInventario = 'Preventa';
        }

        $.ajax({
            data: {
                "saldoInventario": saldoInventario,
            },
            url: 'index.php?r=Preventa/AjaxGetTipoSaldo',
            type: 'post',
            success: function(response) {

            }
        });
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

    $('.btnAdicionarProductoDetalle').click(function() {

        //alert("Validar kit 1");


        limpiarCampos();

        codigoVariante = $(this).attr('data-codigo-variante');
        cliente = $(this).attr('data-cliente');
        articulo = $(this).attr('data-articulo');
        grupoVentas = $(this).attr('data-grupo-ventas');
        zonaventas = $(this).attr('data-zona');
        sitio = $('#select-sitio').attr('data-codigo');
        codigoUnidadSaldo = $(this).attr('data-articulo');
        idSaldoInventario = $(this).attr('data-id-inventario');
        codigoUnidadSaldoInventario = $(this).attr('data-codigounidadmedida-saldo');
        var codigoTipo = $(this).attr('data-codigo-tipo');

        if (codigoUnidadSaldoInventario == "") {
            $("#_alerta").css("z-index", "15000");
            $('#_alerta .text-modal-body').html('El artículo <b>' + codigoVariante + '</b> no cuenta con un saldo.');
            $('#_alerta').modal('show');
            return false;
        }

        //alert(codigoVariante);
        //alert(cliente);
        //alert(zonaventas);

        $.ajax({
            data: {
                "codigoVariante": codigoVariante,
                "cliente": cliente,
                "zonaventas": zonaventas
            },
            url: 'index.php?r=Preventa/AjaxAcuerdoComercialVenta',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                //alert(response);

                if (response == 0) {
                    $('#alertaArticuloSinAcuerdo').modal('show');
                } else {

                    var acuerdo = jQuery.parseJSON(response);
                    //alert(acuerdo);
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
                        url: 'index.php?r=Preventa/AjaxACDL',
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


                            }

                            $.ajax({
                                data: {
                                    "grupoVentas": grupoVentas,
                                    "codigoVariante": codigoVariante,
                                    "articulo": articulo,
                                    "cliente": cliente,
                                    "CodigoUnidadMedida": CodigoUnidadMedida
                                },
                                url: 'index.php?r=Preventa/AjaxDetalleArticulo',
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
                                            url: 'index.php?r=Preventa/AjaxValidarItemPedido',
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
                                        $('#txtCuentaProveedor').val(detalleProducto.CuentaProveedor);
                                        $('#textDetImpoconsumo').val(detalleProducto.ValorIMPOCONSUMO);


                                        if (detalleProducto.CodigoTipoKit == "KV") {

                                            calcularSaldoKitVirtual(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida, cliente);


                                            $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                            $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));


                                        } else if (detalleProducto.CodigoTipoKit == "KD") {

                                            //alert('entre 2');

                                            calcularSaldoKitDinamico(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida);
                                            $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                            $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));
                                            return false;
                                        } else {

                                            $('#textDetValorProducto').val(PrecioVenta);
                                            $('#textDetValorProductoMostrar').val(parseFloat(PrecioVenta) + parseFloat(detalleProducto.ValorIMPOCONSUMO));

                                        }

                                        if ($('#textDetSaldo').val() == "") {
                                            $('#alertaErrorValidar #mensaje-error').html('No existe saldo disponible para algún componente del Kit.');
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

    });


    $('#select-especial').change(function() {

        if ($("#txtDescuentoEspecialPreventa").val() == "" || $("#txtDescuentoEspecialPreventa").val() == "0") {
            $('#select-especial').prop('selectedIndex', 0);
        }
    });


    function iniBtnAdicionalrProducto() {

        $('.btnAdicionarProducto').click(function() {

            var codigoVariante = $('.textDetCodigoProducto').val();
            var descripcion = $('.textDetNombreProducto').val();
            var textDetIva = $('.textDetIva').val();
            var textVariante = codigoVariante;
            var textDetSaldo = $('.textDetSaldo').val();
            var textDetValorProducto = $('.textDetValorProducto').val();
            var textDetImpoconsumo = $('.textDetImpoconsumo').val();
            var txtCantidadPedida = $('#txtCantidadPedida').val();
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

            var txtCodigoGrupoArticulosDescuentoMultilinea = $('.txtCodigoGrupoDescuentoMultiLinea').val();

            var txtIdAcuerdoLinea = $('.txtIdAcuerdoLinea').val();
            var txtIdAcuerdoMultilinea = $('.txtIdAcuerdoMultilinea').val();

            var txtClienteDetalle = $('.txtClienteDetalle').val();
            var txtCodigoGrupoClienteDescuentoMultilinea = $('.txtCodigoGrupoArticulosDescuentoMultilinea').val();



            //alert(txtCodigoGrupoArticulosDescuentoMultilinea);

            //var txtSaldoACDL = $('#txtSaldoACDL').val();
            //var txtCodigoUnidadMedidaACDL = $('#txtCodigoUnidadMedidaACDL').val(); 
            //var txtDescuentoEspecialProveedor = $('#txtDescuentoEspecialProveedor').val();
            //var txtDescuentoEspecialAltipal = $('#txtDescuentoEspecialAltipal').val();    
            //var txtSaldoACDLSinConversion = $('#txtSaldoACDLSinConversion').val();

            var txtIdSaldoInventario = $('.textDetSaldo').val();
            var txtlote = $('#txtLote').val();
            var txtValorConInpuesto = deleteFormat($('#textDetValorImpuestos').val());
            var txtValorSinImpuestos = deleteFormat($('#textDetValorProductoMostrar').val());

            //alert(txtDescuentoProveedor);
            // alert(txtDescuentoAltipal);      
            //return false;

            //debugger
            if (txtCantidadPedida == "" || parseInt(txtCantidadPedida) < 0) {
                $('#alertaErrorValidar').css("z-index", "15001");
                $('#alertaErrorValidar #mensaje-error').html('La cantidad pedida no es valida o esta vacia.');
                $('#alertaErrorValidar').modal('show');
                return;
            }


            if (txtDescuentoEspecial != "") {
                if (!$.isNumeric(txtDescuentoEspecial) || parseInt(txtDescuentoEspecial) > 100) {
                    $('#alertaErrorValidar #mensaje-error').html('El descuento del especial no es valido.');
                    $('#txtDescuentoEspecialPreventa').val('');
                    $('#txtDescuentoEspecialPreventa').focus();

                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar').modal('show');
                    return;
                }
            }


            if (parseInt(txtCantidadPedida) == 0) {
                $('#alertaErrorValidar').css("z-index", "15000");
                $('#alertaErrorValidar #mensaje-error').html('La cantidad no puede ser 0.');
                $('#alertaErrorValidar').modal('show');
                return;
            }

            if ($("#select-tipo-venta-preventa").val() != "VentaDirecta") {

                if (parseInt(textDetSaldo) != 0 && parseInt(txtCantidadPedida) > parseInt(textDetSaldo)) {
                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar #mensaje-error').html('La cantidad no puede superar el saldo disponible.');
                    $('#alertaErrorValidar').modal('show');
                    return;
                }
            }

            if ($('.txtDescuentoEspecialProveedor').length && $('.txtDescuentoEspecialAltipal').length) {

                if ($('.txtDescuentoEspecialProveedor').val() == "" || $('.txtDescuentoEspecialAltipal').val() == "") {
                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar #mensaje-error').html('El campo Altipal o Provedor deben ser obligatorios.');
                    $('#alertaErrorValidar').modal('show');
                    return;
                }

                if ((parseFloat($('.txtDescuentoEspecialProveedor').val()) + parseFloat($('.txtDescuentoEspecialAltipal').val())) != parseFloat(txtDescuentoEspecial)) {
                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar #mensaje-error').html('Los porcentajes Altipal y Proveedor no suman el valor digitado en el descuento especial.');
                    $('#alertaErrorValidar').modal('show');
                    return;
                }

            }


            if (txtCodigoTipo != "KD" && txtCodigoTipo != "KV") {

                if ($("#sltResposableDescuento").val() != "Ninguno") {

                    if ($('.txtDescuentoEspecial').val() == '0') {
                        $('#alertaErrorValidar').css("z-index", "15000");
                        $('#alertaErrorValidar #mensaje-error').html('El Descuento Especial no debe ser igual a 0');
                        $('#alertaErrorValidar').modal('show');
                        return;
                    }
                }
            }



            if ($('.txtDescuentoEspecial').val() != '0' && $("#sltResposableDescuento option:selected").val() == "Ninguno") {
                $('#alertaErrorValidar').css("z-index", "15000");
                $('#alertaErrorValidar #mensaje-error').html('No se ha seleccionado un responsable del descuento Altipal, Provedor, o compartido.');
                $('#alertaErrorValidar').modal('show');
                return;
            }



            if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoACDL) && parseFloat(txtSaldoACDL) != 0) {

                if (txtCodigoTipo != "KD" && txtCodigoTipo != "KV") {

                    $('#alertaACDLCantidad').css("z-index", "15000");
                    $('#alertaACDLCantidad #mensaje-error').html('El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, desea enviar la cantidad pendiente con el precio normal');
                    $('#alertaACDLCantidad').modal('show');
                    return;
                }else{

                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar #mensaje-error').html('El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, por favor ingrese un valor menor');
                    $('#alertaErrorValidar').modal('show');
                    return;
                }
            }


            if ($('#sltResposableDescuento').val() == 'Compartidos' && !$.isNumeric($('.txtDescuentoEspecialProveedor').val()) && $('#txtDescuentoEspecialAltipal').val() != "") {
                $('#alertaErrorValidar').css("z-index", "15000");
                $('#alertaErrorValidar #mensaje-error').html('"La cantidad del descuento especial del proveedor no es valida."');
                $('#alertaErrorValidar').modal('show');
                $('#txtDescuentoEspecialProveedor').val('');
                return;
            }

            if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoLimite) && parseFloat(txtSaldoLimite) != "") {

                if (txtCodigoTipo != "KD" && txtCodigoTipo != "KV") {

                    $('#alertaACDLCantidad').css("z-index", "15001");
                    $('#alertaACDLCantidad #mensaje-error').html('El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, desea enviar la cantidad pendiente con el precio normal');
                    $('#alertaACDLCantidad').modal('show');
                    return;
                }else{

                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar #mensaje-error').html('El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, por favor ingrese un valor menor');
                    $('#alertaErrorValidar').modal('show');
                    return;

                }
            }
          //  debugger;
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
                    "valorUnitario": txtValorSinImpuestos,
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
                    "txtClienteDetalle": txtClienteDetalle,
                    "txtCodigoGrupoClienteDescuentoMultilinea": txtCodigoGrupoClienteDescuentoMultilinea,
                    "txtValorConInpuesto":txtValorConInpuesto
                },
                url: 'index.php?r=Preventa/AjaxAgregarItemPedido',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {
                //    console.log(response);
                   // debugger
                    $('#tableDetail').html(response);
                    calculaTotalesPedido();
                    actualizaPortafolioAgregar();
                    iniActualizarProductos();

                    $('#mdlArticuloDetalle').modal('hide');
                    //$(txtCantidadPedida).val('');

                    $('#txtDescuentoProveedorPreventa').val('');
                    $('#txtDescuentoAltipal').val('');
                    $('#txtDescuentoEspecialPreventa').val('');
                    $('#select-especial').prop('selectedIndex', 0);

                    iniEliminarItemPortafolio();
                    //iniBtnAdicionarProductoDetalleAct(false);
                    iniBtnAdicionarKitDinamico();
                    iniBtnAdicionarKitVirtual();

                }
            });
        });
    }


    $('#btnAceptarSaldoLimite').click(function() {

        var codigoVariante = $('.textDetCodigoProducto').val();
        var descripcion = $('.textDetNombreProducto').val();
        var textDetIva = $('.textDetIva').val();
        var textVariante = codigoVariante;
        var textDetSaldo = $('.textDetSaldo').val();
        var textDetValorProducto = $('.textDetValorProducto').val();
        var textDetImpoconsumo = $('.textDetImpoconsumo').val();
        var txtCantidadPedida = $('#txtCantidadPedida').val();
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

        var txtCodigoGrupoArticulosDescuentoMultilinea = $('.txtCodigoGrupoDescuentoMultiLinea').val();

        var txtIdAcuerdoLinea = $('.txtIdAcuerdoLinea').val();
        var txtIdAcuerdoMultilinea = $('.txtIdAcuerdoMultilinea').val();

        var txtClienteDetalle = $('.txtClienteDetalle').val();
        var txtCodigoGrupoClienteDescuentoMultilinea = $('.txtCodigoGrupoArticulosDescuentoMultilinea').val();
        var txtCodigoGrupoArticulosDescuentoLinea = $('.txtCodigoGrupoArticulosDescuentoLinea').val();
        var txtCodigoGrupoDescuentoLinea = $('.txtCodigoGrupoDescuentoLinea').val();

        var txtIdSaldoInventario = $('.textDetSaldo').val();

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
                "aplicaImpoconsumo": true,
                "txtCodigoGrupoArticulosDescuentoMultilinea": txtCodigoGrupoArticulosDescuentoMultilinea,
                "txtIdAcuerdoLinea": txtIdAcuerdoLinea,
                "txtIdAcuerdoMultilinea": txtIdAcuerdoMultilinea,
                "txtClienteDetalle": txtClienteDetalle,
                "txtCodigoGrupoClienteDescuentoMultilinea": txtCodigoGrupoClienteDescuentoMultilinea,
                "txtCodigoGrupoArticulosDescuentoLinea": txtCodigoGrupoArticulosDescuentoLinea,
                "txtCodigoGrupoDescuentoLinea": txtCodigoGrupoDescuentoLinea,
            },
            url: 'index.php?r=Preventa/AjaxAgregarItemPedido',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                $('#alertaACDLCantidad').modal('hide');

                $('#tableDetail').html(response);
                calculaTotalesPedido();
                actualizaPortafolioAgregar();
                iniActualizarProductos();

                $('#mdlArticuloDetalle').modal('hide');
                //$('#txtCantidadPedida').val('');

                $('#txtDescuentoProveedorPreventa').val('');
                $('#txtDescuentoAltipal').val('');
                $('#txtDescuentoEspecialPreventa').val('');
                $('#select-especial').prop('selectedIndex', 0);

                iniEliminarItemPortafolio();
                //iniBtnAdicionarProductoDetalleAct(false);
                iniBtnAdicionarKitDinamico();
                iniBtnAdicionarKitVirtual();

            }
        });
    });

    //function iniCantidadAcuerdos() {

        $('body').on('keyup','.txtCantidadPedida', function() {

            var txtClienteDetalle = $('.txtClienteDetalle').val();
            var txtCodigoVariante = $('.textDetCodigoProducto').val();
            var txtUnidadMedida = $('.textDetCodigoUnidadMedida').val();
            var txtArticulo = $('.txtCodigoArticulo').val();
            var txtZonaVenta = $('.txtZonaVenta').val();
            var txtCodigoGrupoDescuentoLinea = $('.txtCodigoGrupoDescuentoLinea').val();
            var txtCodigoGrupoDescuentoMultiLinea = $('.txtCodigoGrupoDescuentoMultiLinea').val();
            var txtCodigoGrupoClienteDescuentoLinea = $('.txtCodigoGrupoArticulosDescuentoLinea').val();
            var txtCodigoGrupoClienteDescuentoMultilinea = $('.txtCodigoGrupoArticulosDescuentoMultilinea').val();
            var txtSaldoLimite = $('.txtSaldoLimite').val();  
            var valueTotalOrder = $(this).attr('data-valorConImpuestos');
           //var valueTotalOrder = $('.')

            var txtCantidad = $(this).val();
            var txtDescuentoProveedorPreventa = $('.txtDescuentoProveedor').val();

            //alert(txtDescuentoProveedorPreventa);
            //$('#descLineaValidado').trigger("keyup"); 

            if (txtCantidad != "" && txtCantidad != 0) {

                //alert(txtCantidad);
                
                //if(txtDescuentoProveedorPreventa==0 || txtDescuentoProveedorPreventa > 1){
                $.ajax({
                    data: {
                        'txtClienteDetalle': txtClienteDetalle,
                        'txtCodigoVariante': txtCodigoVariante,
                        'txtUnidadMedida': txtUnidadMedida,
                        'txtArticulo': txtArticulo,
                        'txtZonaVenta': txtZonaVenta,
                        'txtCodigoGrupoDescuentoLinea': txtCodigoGrupoDescuentoLinea,
                        'txtCantidad': txtCantidad,
                        'txtCodigoGrupoClienteDescuentoLinea': txtCodigoGrupoClienteDescuentoLinea,
                        'txtSaldoLimite': txtSaldoLimite
                    },
                    url: 'index.php?r=Preventa/AjaxValidarAcuerdoLinea',
                    type: 'post',
                    beforeSend: function() {
                        $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function(response) {
                        //alert(response);
                        var obj = jQuery.parseJSON(response);
                        discountLinea = obj.descuentoLinea;
                       //alert("descuento linea:  " + obj.descuentoLinea);
                        $('#descLineaValidado').val(obj.descuentoLinea);
                        $('.txtIdAcuerdoLinea').val(obj.acuerdoComercial);
                        
                       // $('#textDetValorImpuestos').val(valorConImpuestos);
                       calcularDescuentoMultilinea(txtClienteDetalle, txtCodigoVariante, txtUnidadMedida, txtArticulo, txtCodigoGrupoDescuentoMultiLinea, txtCantidad, txtCodigoGrupoClienteDescuentoMultilinea, valueTotalOrder);

                    }
                });
                //}
                
            } else {
                if ($('.txtSaldoLimite').val() == "") {
                    $('.txtDescuentoProveedor').val('0');
                }
                $('.txtDescuentoAltipal').val('0');
                $('.txtDescuentoProveedor').val('0');
                //$('#textDetValorImpuestos').val(valueTotalOrder);
                // $('.txtCodigoGrupoArticulosDescuentoMultilinea').val(''); 
                $('.txtIdAcuerdoMultilinea').val('');
                $('.txtIdAcuerdoLinea').val('');
                $("#textDetValorProductoMostrar").trigger("blur");

            }

        });

        function calcularDescuentoMultilinea(txtClienteDetalle, txtCodigoVariante, txtUnidadMedida, txtArticulo, txtCodigoGrupoDescuentoMultiLinea, txtCantidad, txtCodigoGrupoClienteDescuentoMultilinea, valueTotalOrder){

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
                url: 'index.php?r=Preventa/AjaxValidarAcuerdoMultiLinea',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {
                    //var valorConImpuestosMulti = $('#textDetValorImpuestos').val();

                    var obj = jQuery.parseJSON(response);
                    discountMultilinea = obj.descuentoMultiLinea;

                    $('#descMultiLineaValidado').val(obj.descuentoMultiLinea);
                   // alert("descuento MultiLinea:  " + obj.descuentoMultiLinea + " desde: "+ obj.DMLCantidadDesde2+ " hasta: " + obj.DMLCantidadHasta2);
                    //$('.txtCodigoGrupoArticulosDescuentoMultilinea').val(obj.CodigoGrupoArticulosDescuentoMultilinea);
                    $('.txtIdAcuerdoMultilinea').val(obj.acuerdoComercialMulti);
                   // $('#textDetValorImpuestos').val(valorConImpuestos);
                   $("#textDetValorProductoMostrar").trigger("blur");

                }
            });
        }


    //}


    $('#btnAdicionarProducto').click(function() {

        var codigoVariante = $('#textDetCodigoProducto').text();
        var descripcion = $('#textDetNombreProducto').text();
        var textDetIva = $('#textDetIva').val();
        var textDetSaldo = $('#textDetSaldo').val();
        var textVariante = $('#textCodigoVariante').val();
        var textDetValorProducto = $('#textDetValorProducto').val();
        var textDetImpoconsumo = $('#textDetImpoconsumo').val();
        var txtCantidadPedida = $('#txtCantidadPedida').val();
        var txtSaldoLimite = $('#txtSaldoLimite').val();
        var txtDescuentoProveedor = $('#txtDescuentoProveedorPreventa').val();
        var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
        var txtDescuentoEspecial = $('#txtDescuentoEspecialPreventa').val();
        var txtSaldoACDL = $('#txtSaldoACDL').val();
        var txtCodigoUnidadMedidaACDL = $('#txtCodigoUnidadMedidaACDL').val();
        var txtCantidadPedida = $('#txtCantidadPedida').val();
        var txtCantidadPedida = $('.txtCantidadPedida').val();
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
        var txtlote = $('#txtLote').val();
        var txtClienteDetalle = $('.txtClienteDetalle').val();


        if ($('#txtDescuentoEspecialPreventa').val() == "") {
            $('#txtDescuentoEspecialPreventa').val() == "0";
        }

        if (txtCantidadPedida == "" || parseInt(txtCantidadPedida) < 0) {

            $('#alertaErrorValidar #mensaje-error').html('La cantidad pedida no es valida o esta vacia.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

        if (txtDescuentoEspecial != "") {
            if (!$.isNumeric(txtDescuentoEspecial) || parseInt(txtDescuentoEspecial) > 100) {
                $('#alertaErrorValidar #mensaje-error').html('El descuento del especial no es valido.');
                $('#txtDescuentoEspecialPreventa').val('');
                $('#txtDescuentoEspecialPreventa').focus();
                $('#alertaErrorValidar').modal('show');
                return;
            }
        }

        if (parseInt(txtCantidadPedida) == 0) {
            $('#alertaErrorValidar #mensaje-error').html('La cantidad no puede ser 0.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

        if ($("#select-tipo-venta-preventa").val() != "VentaDirecta") {

            if (parseInt(txtCantidadPedida) > parseInt(textDetSaldo)) {
                $('#alertaErrorValidar #mensaje-error').html('la cantidad no puede superar el saldo disponible.');
                $('#alertaErrorValidar').modal('show');
                return;
            }

        }

        if ($('#txtDescuentoEspecialProveedor').length && $('#txtDescuentoEspecialAltipal').length) {

            if ($('#txtDescuentoEspecialProveedor').val() == "" || $('#txtDescuentoEspecialAltipal').val() == "") {
                $('#alertaErrorValidar #mensaje-error').html('La campo Altipal o Provedor deben ser obligatorios.');
                $('#alertaErrorValidar').modal('show');
                return;
            }

            if ((parseInt($('#txtDescuentoEspecialProveedor').val()) + parseInt($('#txtDescuentoEspecialAltipal').val())) != '100') {
                $('#alertaErrorValidar #mensaje-error').html('Los porcentaje Altipal y Proveedor no suman el 100%.');
                $('#alertaErrorValidar').modal('show');
                return;
            }

        }

        if (txtCodigoTipo != "KD" && txtCodigoTipo != "KV") {

            if ($("#sltResposableDescuento").val() != "Ninguno") {

                if ($('.txtDescuentoEspecial').val() == '0') {
                    $('#alertaErrorValidar').css("z-index", "15000");
                    $('#alertaErrorValidar #mensaje-error').html('El Descuento Especial no debe ser igual a 0');
                    $('#alertaErrorValidar').modal('show');
                    return;
                }
            }
        }




        if ($('#txtDescuentoEspecialPreventa').val() > 0 && $("#select-especial option:selected").val() == "Ninguno") {
            $('#alertaErrorValidar #mensaje-error').html('No se seleccionado un responsable del descuento Altipal, Provedor, o compartido.');
            $('#alertaErrorValidar').modal('show');
            return;
        }

        if (parseFloat(txtCantidadPedida) > parseFloat(txtSaldoACDL) && parseFloat(txtSaldoACDL) != 0) {

            if (txtCodigoTipo != "KD" && txtCodigoTipo != "KV") {

                $('#alertaACDLCantidad #mensaje-error').html('El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, desea enviar la cantidad pendiente con el precio normal');
                $('#alertaACDLCantidad').modal('show');
                return;
            }else{

                $('#alertaErrorValidar').css("z-index", "15000");
                $('#alertaErrorValidar #mensaje-error').html('El artículo no cuenta con saldo para la cantidad pedida de acuerdo al límite de ventas, por favor ingrese un valor menor');
                $('#alertaErrorValidar').modal('show');
                return;

            }
        }


        if ($('#select-especial').val() == 'Compartidos' && !$.isNumeric($('#txtDescuentoEspecialProveedor').val()) && $('#txtDescuentoEspecialProveedor').val() != "") {
            $('#alertaErrorValidar #mensaje-error').html('"La cantidad del descuento especial del proveedor no es valida."');
            $('#alertaErrorValidar').modal('show');
            $('#txtDescuentoEspecialProveedor').val('');
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
                "aplicaImpoconsumo": true,
                "txtlote": txtlote,
                "txtClienteDetalle": txtClienteDetalle

            },
            url: 'index.php?r=Preventa/AjaxAgregarItemPedido',
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
                //$(txtCantidadPedida).val('');
                $('#txtDescuentoProveedorPreventa').val('');
                $('#txtDescuentoAltipal').val('');
                $('#txtDescuentoEspecialPreventa').val('');
                $('#select-especial').prop('selectedIndex', 0);

                iniEliminarItemPortafolio();

            }
        });


    });

    $("#frmPedidoPreventa").submit(function() {


        var cantidadProductos = $('#cantidad-enviar').val();
        var txtTotalPedido = $('#txtTotalPedido').val();
        var txtTotalPedidoCupo = $('#txtTotalPedido').val();

        var txtSaldoCupo = $('#txtSaldoCupo').val();
        var formaPago = $('#formaPagoPreventa').val();
        var valorMinimo = $('#txtValorMinimo').val();
        var sitios = $("#sitios").val();
        var TotalPedidoAnterior = $("#TotalPedidoAnterior").val();
        var Operacion = "";
        //alert(formaPago);

        if (typeof cantidadProductos === "undefined") {
            cantidadProductos = 0;
        }

        if (parseFloat(TotalPedidoAnterior) > '0') {


            Operacion = parseFloat(txtTotalPedido) + parseFloat(TotalPedidoAnterior);

            txtTotalPedido = Operacion;
        }


        if (sitios == 1) {

            if ($("#pedidosenvaido").val() == 0) {

                if (parseFloat(valorMinimo) != "" || parseFloat(valorMinimo) != "0") {
                    if (parseFloat(txtTotalPedido) < parseFloat(valorMinimo)) {
                        $('#alertaErrorValidarSitio #mensaje-error').html("El monto mínimo del pedido no cumple para su despacho. Valor pedido mínimo: " + valorMinimo + "<br><br>" + "Desea hacer un nuevo pedido para otro sitio y cumplir con el valor total del pedido mínimo");
                        $('#alertaErrorValidarSitio').modal('show');
                        return false;
                    }
                }
            }

        } else {

            if ($("#pedidosenvaido").val() == 0) {

                if (parseFloat(valorMinimo) != "" || parseFloat(valorMinimo) != "0") {
                    if (parseFloat(txtTotalPedido) < parseFloat(valorMinimo)) {
                        $('#alertaErrorValidar #mensaje-error').html("El valor del pedido debe superar el valor minimo: " + valorMinimo);
                        $('#alertaErrorValidar').modal('show');
                        return false;
                    }
                }

            }


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
            $('.enviarPedido').attr('disabled', 'disabled');
            return true;
        }


    });

    $("#txtAreaObservaciones").keypress(function() {
        var limit = 50;
        var text = $(this).val();
        var chars = text.length;
        if (chars > limit) {
            var new_text = text.substr(0, limit);
            $(this).val(new_text);
        }
    });

    $('#retornarMenu').click(function() {
        var zona = $(this).attr('data-zona');
        var cliente = $(this).attr('data-cliente');

        $('#_alertConfirmationMenu .text-modal-body').html('Esta seguro de salir del modulo de pedidos? ');
        $('#_alertConfirmationMenu').modal('show');

    });




    //
    $('.txtCantidadPedida').keyup(function() {
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
                        $('#txtDescuentoProveedorPreventa').val('0');

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

                        $('#txtDescuentoProveedorPreventa').val(descuento);

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

    $('#btn-aceptar-ACDL').click(function() {


        var codigoVariante = $('#textDetCodigoProducto').text();
        var descripcion = $('#textDetNombreProducto').text();
        var textDetIva = $('#textDetIva').val();
        var textDetSaldo = $('#textDetSaldo').val();
        var textVariante = $('#textCodigoVariante').val();
        var textDetValorProducto = $('#textDetValorProducto').val();
        var textDetImpoconsumo = $('#textDetImpoconsumo').val();
        var txtCantidadPedida = $('#txtCantidadPedida').val();
        var txtSaldoLimite = $('#txtSaldoLimite').val();
        var txtDescuentoProveedor = $('#txtDescuentoProveedorPreventa').val();
        var txtDescuentoAltipal = $('#txtDescuentoAltipal').val();
        var txtDescuentoEspecial = $('#txtDescuentoEspecialPreventa').val();
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
                'codigoArticulo': txtCodigoArticulo,
                'codigoTipo': txtCodigoTipo,
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
                "cuentaProveedor": txtCuentaProveedor,
                "aplicaImpoconsumo": true

            },
            url: 'index.php?r=Preventa/AjaxAgregarItemPedido',
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
                //$('#txtCantidadPedida').val('');
                $('#txtDescuentoProveedorPreventa').val('');
                $('#txtDescuentoAltipal').val('');
                $('#txtDescuentoEspecial').val('');
                $('#select-especial').prop('selectedIndex', 0);

                iniEliminarItemPortafolio();

            }
        });

    });

    $('#btn-cancelar-ACDL').click(function() {
        $('#alertaACDLCantidad').modal('hide');
        $('#txtCantidadPedida').focus();
    });


    function actualizaPortafolioAgregar() {

        $.ajax({
            url: 'index.php?r=Preventa/AjaxActualizaPortafolioAgregar',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                $('.imagen-producto-' + response).attr('src', 'images/aceptar.png');

                /*var table = $('#tblPortafolioPreventa').dataTable();
                 var tableConsignacion = $('#tblPortafolioConsignacion').dataTable();
                 var tableVentaDirecta = $('#tblPortafolioVentaDirecta').dataTable();
                 
                 var filtro = $('#tblPortafolioPreventa_filter input').val();
                 var filtroConsignacion = $('#tblPortafolioConsignacion_filter input').val();
                 var filtroVentaDirecta = $('#tblPortafolioVentaDirecta_filter input').val();
                 
                 table.fnFilterClear();
                 tableConsignacion.fnFilterClear();
                 tableVentaDirecta.fnFilterClear();
                 
                 table.fnFilter(filtro);
                 tableConsignacion.fnFilter(filtroConsignacion);
                 tableVentaDirecta.fnFilter(filtroVentaDirecta);*/

            }
        });

    }

    function initVolveAponerProductosIniciales(variante) {

        $('.imagen-producto-' + variante).attr('src', 'images/pro.png');

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
                        url: 'index.php?r=Preventa/AjaxAcuerdoComercialVenta',
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
                                    url: 'index.php?r=Preventa/AjaxACDL',
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


                                        $.ajax({
                                            data: {
                                                "grupoVentas": grupoVentas,
                                                "codigoVariante": codigoVariante,
                                                "articulo": articulo,
                                                "cliente": cliente,
                                                "CodigoUnidadMedida": CodigoUnidadMedida
                                            },
                                            url: 'index.php?r=Preventa/AjaxDetalleArticulo',
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
                                                        url: 'index.php?r=Preventa/AjaxValidarItemPedido',
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

                                                       // alert('pablo');
                                                        calcularSaldoKitDinamico(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida, nombre);

                                                        $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                                        $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));
                                                        return false;
                                                    } else {

                                                        $('#textDetValorProducto').val(PrecioVenta);
                                                        $('#textDetValorProductoMostrar').val(parseFloat(PrecioVenta) + parseFloat(detalleProducto.ValorIMPOCONSUMO));

                                                    }

                                                    if ($('#textDetSaldo').val() == "") {
                                                        $('#alertaErrorValidar #mensaje-error').html('No existe saldo disponible para algún componente del Kit.');
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




    function iniAdicionarProducto() {
        $('.btnAdicionarProductoDetalle').click(function() {

            //alert("Validar kit 2");
            limpiarCampos();

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
                url: 'index.php?r=Preventa/AjaxAcuerdoComercialVenta',
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
                            url: 'index.php?r=Preventa/AjaxACDL',
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

                                $.ajax({
                                    data: {
                                        "grupoVentas": grupoVentas,
                                        "codigoVariante": codigoVariante,
                                        "articulo": articulo,
                                        "cliente": cliente,
                                        "CodigoUnidadMedida": CodigoUnidadMedida
                                    },
                                    url: 'index.php?r=Preventa/AjaxDetalleArticulo',
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
                                                url: 'index.php?r=Preventa/AjaxValidarItemPedido',
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
                                            $('#lblUnidadMedidaSaldo').html(detalleProducto.NombreUnidadMedidaSaldo);
                                            $('#textDetSaldo').val(detalleProducto.SaldoInventarioPreventa);
                                            $('#textDetIva').val(detalleProducto.PorcentajedeIVA);
                                            $('#textDetImpoconsumo').val(detalleProducto.ValorIMPOCONSUMO);


                                            if (detalleProducto.CodigoTipoKit == "KV") {

                                                calcularSaldoKitVirtual(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida, cliente);


                                                $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                                $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));


                                            } else if (detalleProducto.CodigoTipoKit == "KD") {

                                                alert('entre');
                                                calcularSaldoKitDinamico(detalleProducto.CodigoListaMateriales, detalleProducto.CodigoArticuloKit, CodigoUnidadMedida, nombre);

                                                $('#textDetValorProducto').val(detalleProducto.TotalPrecioVentaListaMateriales);
                                                $('#textDetValorProductoMostrar').val(parseFloat(detalleProducto.TotalPrecioVentaListaMateriales) + parseFloat(detalleProducto.ValorIMPOCONSUMO));
                                                return false;
                                            } else {

                                                $('#textDetValorProducto').val(PrecioVenta);
                                                $('#textDetValorProductoMostrar').val(parseFloat(PrecioVenta) + parseFloat(detalleProducto.ValorIMPOCONSUMO));

                                            }

                                            $('#articuloPedido').modal('show');
                                            iniValidarCantidad();
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });

        });
    }

    function calculaTotalesPedido() {
        $.ajax({
            data: {
                'saldoCupo': $('#txtSaldoCupo').val(),
            },
            url: 'index.php?r=Preventa/AjaxTotalesPedido',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {
                $('#totalesCalculados').html(response);


            }
        });
    }

    function limpiarCampos() {
        $('#txtDescuentoProveedorPreventa').val('');
        //$('#txtCantidadPedida').val('');
        $('#txtDescuentoEspecialPreventa').val('');
        $('#txtDescuentoAltipal').val('');
        $('#select-especial').prop('selectedIndex', 0);

        $('#txtSaldoLimite').val('');
        $('#txtSaldoACDL').val('');
        $('#txtSaldoACDLSinConversion').val('');
        $('#txtIdAcuerdo').val('');
        $('#txtCodigoUnidadMedidaACDL').val('');
        $('#txtPorcentajeDescuentoLinea1ACDL').val('');
        $('#txtPorcentajeDescuentoLinea2ACDL').val('');
        $('#txtDescuentoProveedorPreventa').val('');
        $('#txtCodigoArticulo').val('');
        $('#txtIdSaldoInventario').val('');
        $('#txtCodigoUnidadSaldoInventario').val('');

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

    function calcularSaldoKitDinamico(codigoListaMateriales, codigoArticuloKit, codigoUnidadMedida) {

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
                    //actualizaPortafolioAgregar();
                    initVolveAponerProductosIniciales(variante);
                    iniEliminarItemPortafolio();
                    iniActualizarProductos();
                    //iniBtnAdicionarProductoDetalleAct();

                }
            });
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
                url: 'index.php?r=Preventa/AjaxCargarSaldoLote',
                type: 'post',
                beforeSend: function() {
                    $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function(response) {

                    $('.textDetSaldo').val(response);

                }
            });


        });

    }

    function credito(aplicacontado) {

        var formpago = $("#formaPagoPreventa").val();

        if (aplicacontado == 'falso' && formpago == 'credito') {

            var option = '<option value="no">No</option><option value="si">Si</option>';

            var cupodisponible = $("#cupodisponiblehiden").val();
            $("#selactividadEspecial").html(option);
            $("#cupodisponible").val(cupodisponible);

        } else {

            var option = '<option value="no">No</option>';

            $("#selactividadEspecial").html(option);
            $("#cupodisponible").val('0');

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
        var formaPagoPreventa = $("#formaPagoPreventa").val();
        var plazo = $("#plazo").val();
        var tipoventa = $("#select-tipo-venta-preventa").val();
        var selactividadEspecial = $("#selactividadEspecial").val();
        var Observaciones = $("#txtAreaObservaciones").val();
        var SaldoCupo = $("#txtSaldoCupo").val();

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
                "formaPago": formaPagoPreventa,
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
            },
            url: 'index.php?r=Preventa/AjaxPedidoMinimo',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {

                window.location.href = "index.php?r=Clientes/menuClientes&cliente=" + cuentaCliente + "&zonaVentas=" + zona;

            }
        });
    });

    // Valida el valor sin impuestos ingresados es menor al calculado

    //function ValidarValorSinImpuesto(valorIva, valorIpoconsumo, itemPorACPrecioVenta) {
    $('body').on('blur','#textDetValorProductoMostrar', function() {
      
        var valorEspecial = $("#textDetValorProductoMostrar").val();
        itemPorACPrecioVenta = $("#textDetValorProductoMostrar").attr('data-valorSinImpuestos');
        valorIva = $("#textDetValorProductoMostrar").attr('data-valorIva');
        valorIpoconsumo = $("#textDetValorProductoMostrar").attr('data-valorIpoconsumo');


        valorEspecial =valorEspecial.replace('.', '');
        valorEspecial =valorEspecial.replace(',', '.');
        valorEspecial =valorEspecial.replace('$','');

        if (valorEspecial == "")
        {
            valorEspecial = 0;
        }
        
      //  debugger;
        if (parseFloat(valorEspecial) < parseFloat(itemPorACPrecioVenta) ){

          // alert("entrandoo"+valorEspecial);
            $(this).val(itemPorACPrecioVenta);
            mensajeError = "El valor sin impuestos no puede ser menor que el calculado";
            alertError(mensajeError);
            
            return false;

        } else {

            calcularValorimpuesos(valorEspecial, valorIva, valorIpoconsumo);

        }
    });

    $('body').on('keyup','#descLineaValidado', function() {

        var PorDescuentoL = discountLinea;
        var mensajeError = "";
        var txtCantidadPedida = $('.txtCantidadPedida').val();
        var PorDescuentoLVal =  $('#descLineaValidado').val();

        if (txtCantidadPedida != "" && txtCantidadPedida != 0) {

            if(PorDescuentoLVal != ""){

                if( parseFloat(PorDescuentoL) >= parseFloat(PorDescuentoLVal) ){

                    $("#textDetValorProductoMostrar").trigger("blur");

                   // $('#descLineaValidado').val(PorDescuentoL);
                    /*var valorDescuentoTotalLinea = parseFloat(valorConImpuestos) * (parseFloat(PorDescuentoLVal) /100);
                    var nuevoValorImpustos = parseFloat(valorConImpuestos) - parseFloat(valorDescuentoTotalLinea);
                    $('#textDetValorImpuestos').val(nuevoValorImpustos);  */ 

                }else{

                    mensajeError = "El valor del descuento linea no puede ser mayor al calculado";
                    alertError(mensajeError);
                    $('#descLineaValidado').val(PorDescuentoL);

                }
            }
        }else{

            mensajeError = "Por favor primero ingrese una cantidad";
            alertError(mensajeError);

        }
    });

    // cuando precionan una tecla en descuento linea
    $('body').on('keyup','#descMultiLineaValidado', function() { 

        var PorDescuentoML = discountMultilinea;
        var mensajeError = "";
        var txtCantidadPedida = $('.txtCantidadPedida').val();    
        var PorDescuentoMLVal = $('#descMultiLineaValidado').val();

        if (txtCantidadPedida != "" && txtCantidadPedida != 0) {

            if(PorDescuentoMLVal != ""){

                if(PorDescuentoML >= PorDescuentoMLVal){

                    $("#textDetValorProductoMostrar").trigger("blur");

                   // $('#DescVal').val(PorDescuentoML);
                    /*var valorDescuentoTotalMulti = parseFloat(valorConImpuestos) * parseFloat((parseFloat(PorDescuentoMLVal) /100));
                    var nuevoValorImpustos = parseFloat(valorConImpuestos) - parseFloat(valorDescuentoTotalMulti);
                    $('#textDetValorImpuestos').val(nuevoValorImpustos);   */

                }else{

                    mensajeError = "El valor del descuento MultiLinea no puede ser mayor al calculado";
                    alertError(mensajeError);
                    $('#descMultiLineaValidado').val(PorDescuentoML);

                }
            }

        }else{
            mensajeError = "Por favor primero ingrese una cantidad";
            alertError(mensajeError);
        }
    });

    function calcularValorimpuesos(valorEspecial, valorIva, valorIpoconsumo){

        var nuevoValorImpustos = 0;
        var totalValorConImpuesto = 0;
        var nuevoValorImpustosLinea = 0;
        var nuevoValorImpustosMultiLinea = 0;
        var mensajeError = "";
        var PorDescuentoML = discountMultilinea;
        var PorDescuentoL = discountLinea;

        var txtCantidadPedida = $('.txtCantidadPedida').val();
        var PorDescuentoMLVal = $('#descMultiLineaValidado').val();
        var PorDescuentoLVal =  $('#descLineaValidado').val();
        var tipoCodigoProducto = $('.txtCodigoTipo').val();

        //Calculamos el valor sumando los impuestos
        if(tipoCodigoProducto != "KV" && tipoCodigoProducto != "KD") {

            var valorIvaConvercion = parseFloat(valorEspecial) * (parseFloat(valorIva) / 100);
            var valorProducto = parseFloat(valorEspecial) + parseFloat(valorIvaConvercion);
            totalValorConImpuesto = parseFloat(valorProducto) + parseFloat(valorIpoconsumo);

        }else{

            totalValorConImpuesto = deleteFormat($('#textDetValorImpuestos').val());

        }

        if (txtCantidadPedida != "" && txtCantidadPedida != 0) {

            if(PorDescuentoLVal != ""){

                if( parseFloat(PorDescuentoL) >= parseFloat(PorDescuentoLVal) ){

                    nuevoValorImpustosLinea = parseFloat(totalValorConImpuesto) * (parseFloat(PorDescuentoLVal) /100);

                }else{

                    mensajeError = "El valor del descuento linea no puede ser mayor al calculado";
                    alertError(mensajeError);
                    $('#descLineaValidado').val(PorDescuentoL);
                    return false;

                }
            }

            if(PorDescuentoMLVal != ""){

                if(PorDescuentoML >= PorDescuentoMLVal){

                    nuevoValorImpustosMultiLinea = parseFloat(totalValorConImpuesto) * parseFloat((parseFloat(PorDescuentoMLVal) /100));

                }else{

                    mensajeError = "El valor del descuento MultiLinea no puede ser mayor al calculado";
                    alertError(mensajeError);
                    $('#descMultiLineaValidado').val(PorDescuentoML);
                    return false;
                }

            }                           
        }

        var valorimpuestoCalculado = parseFloat(totalValorConImpuesto)  - parseFloat(nuevoValorImpustosLinea)  - parseFloat(nuevoValorImpustosMultiLinea);
        $('#textDetValorImpuestos').val(number_format(valorimpuestoCalculado, 2, ",", "."));
        return true;

    }

    function alertError(mensajeError){

        $('#alertaErrorValidar').css("z-index", "15000");
        $('#alertaErrorValidar #mensaje-error').html(mensajeError);
        $('#alertaErrorValidar').modal('show');

    }

    function deleteFormat(numDelete){

        numDelete = numDelete.replace('.', '');
        numDelete = numDelete.replace(',', '.');
        numDelete = numDelete.replace('$','');
        return numDelete;
    }

});