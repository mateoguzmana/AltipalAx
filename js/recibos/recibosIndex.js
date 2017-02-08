jQuery(document).ready(function() {

    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {

            $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');
            $('#_alertaRecargarPagina').modal('show');
            return false;
        }
    });

    $('#txtProvisional').keyup(function () {

        var txtProvisional = $(this).val();
        var txtZonaVentas = $('#txtZonaVentas').val();
        var txtCodAsesor = $('#txtCodAsesor').val();

        $.ajax({
            data: {
                "txtProvisional": txtProvisional,
                "txtZonaVentas": txtZonaVentas,
                "txtCodAsesor": txtCodAsesor
            },
            url: 'index.php?r=Recibos/AjaxValidarProvisional',
            type: 'post',
            success: function (response) {

                if (response == 1) {
                    $('#_alerta .text-modal-body').html('El provisional digitado ya se encuentra registrado.');
                    $('#_alerta').modal('show');
                    $('#txtProvisional').val('');
                    return false;
                }
            }
        });
    });

    $('.itemFacturasRecaudos').click(function () {

        var txtProvisional = $('#txtProvisional').val();

        if (txtProvisional == "") {
            $('#txtProvisional').focus();
            $('#_alerta .modal-title').html('Alerta Recibos');
            $('#_alerta .text-modal-body').html('El campo de provisional no puede estar vacio');
            $('#_alerta').modal('show');
            return false;
        }

        var txtFactura = $(this).attr('data-factura');
        var txtValorNeto = $(this).attr('data-valor-neto');
        var txtZonaVenta = $(this).attr('data-zona-venta');

        if ($('#abono-' + txtFactura).val() != "") {
            $('#_alerta .text-modal-body').html('Ya se ingreso un Abono para la factura <b>' + txtFactura + '</b>');
            $('#_alerta').modal('show');
            return false;
        } else {
            validarFacturasAbonos(txtFactura, txtValorNeto, txtZonaVenta);
        }
    });

    function validarFacturasAbonos(txtFactura, txtValorNeto, txtZonaVenta) {

        var buscador = 0;
        var facturas;
        var abonoSeleccionado;

        $('.abonos-item').each(function () {

            var valorAbono = $(this).val().replace(/,/g, '');;

            if (valorAbono != "") {
                facturas = $(this).attr('data-factura');
                abonoSeleccionado = valorAbono;
                $.ajax({
                    data: {
                        "facturas": facturas,
                        "valorAbono": valorAbono
                    },
                    async: false,
                    url: 'index.php?r=Recibos/AjaxValidarFacturasAbonos',
                    type: 'post',
                    success: function (response) {
                        if (response == "false") {
                            buscador++;
                            return false;
                        }
                    }
                });
            }
        });
        if (buscador == 0) {

            $('#_alertaInput .modal-title').html('Mensaje Recaudos');
            $('#_alertaInput .labelAlertaInput').html('Por favor Ingrese el valor del abono que aplicará a la factura <b>#' + txtFactura + "</b>");
            $('#_alertaInput #inputAlertaInput').val(txtValorNeto);
            $('#_alertaInput .labelAlertaInputFactura').val(txtFactura);
            $('#_alertaInput .labelAlertaInputSaldoFactura').val(txtValorNeto);
            $('#_alertaInput .labelAlertaInputZonaVentasFactura').val(txtZonaVenta);
            $('#_alertaInput').modal('show');
            $('#txtFacturaSeleccionada').val(txtFactura);
            return false;

        } else {

            $('#_alerta .text-modal-body').html('El Valor de los recaudos para la factura <b>' + facturas + '</b> no se han completado');
            $('#_alerta').modal('show');
            return false;
        }
    }

    function calcularNuevosValoresEfectivo(txtFacturaSeleccionada) {
        var abonoSel = abonoSeleccionado.replace(/,/g, '');
        $.ajax({
            data: {
                'txtFacturaSeleccionada': txtFacturaSeleccionada,
                'abonoSeleccionado': abonoSel,
            },
            url: 'index.php?r=Recibos/AjaxGetTotal',
            type: 'post',
            success: function (response) {

                $('#txtFacturaEc').val(response);
                $('#txtValorEc').val(response);
                $('#txtValorCheque').val(response);
                $('#txtValorDCc').val(response);
            }
        });
    }

    $('#btnAlertaInputOk').on('click', function (event) {

        var abonoFactura = $('#_alertaInput #inputAlertaInput').val().replace(/,/g, '');
        var valornetoFactura = $('#_alertaInput .labelAlertaInputSaldoFactura').val().replace(/,/g, '');
        var txtFactura = $('#_alertaInput .labelAlertaInputFactura').val();
        var txtZonaVenta = $('#_alertaInput .labelAlertaInputZonaVentasFactura').val();

        $('#txtSaldoFacturaSeleccionada').val(abonoFactura);

        if (abonoFactura == 0 || abonoFactura < 0) {

            $("#_alerta").css("z-index", "15000");
            $('#_alerta .text-modal-body').html('El valor del abono no puede ser menor o igual a 0');
            $('#_alerta').modal('show');
            return false;
        }

        if (parseFloat(abonoFactura) < parseFloat(valornetoFactura)) {
            $('#_alertaInput').modal('hide');
            $('#_alertaSelect .modal-title').html('Mensaje Recaudos');
            $('#_alertaSelect .labelAlertaSelect').html('Por favor seleccione un motivo por el cual no se recaudará el valor total de la factura');
            $('#_alertaSelect .labelAlertaSelectFactura').val(txtFactura);
            $('#_alertaSelect .labelAlertaSelectAboFactura').val(abonoFactura)
            $('#_alertaSelect .labelAlertaSelectSaldoFactura').val(valornetoFactura);
            $('#_alertaSelect .labelAlertaSelectZonaVentasFactura').val(txtZonaVenta);
            $('#_alertaSelect').modal('show');
            $('#_alertaInput').modal('hide');
            return false;
        }

        if (parseFloat(abonoFactura) > parseFloat(valornetoFactura)) {
            $("#_alerta").css("z-index", "15000");
            $('#_alerta .text-modal-body').html('El valor del abono no puede ser mayor al saldo de la factura.');
            $('#_alerta').modal('show');
            return false;
        } else {

            var valorNetoFactura = $('#valorNetoFactura-' + txtFactura).val();
            var txtValorProntoPagoAplicar = $('#txtValorProntoPagoAplicar-' + txtFactura).val();

            if (txtValorProntoPagoAplicar != "" && parseFloat(txtValorProntoPagoAplicar) > 0) {
                var valorAplicarFactura = (parseFloat(valorNetoFactura) - parseFloat(txtValorProntoPagoAplicar));
                $('#descuentoPPTxt-' + txtFactura).html('$' + number_format(valorAplicarFactura), '0', '.', ',');
                $('#txtDescuentoPPValor-' + txtFactura).val(txtValorProntoPagoAplicar);
                $('#txtDescuentoPPFactura-' + txtFactura).val(valorAplicarFactura);
            }

            $('#_alertaInput').modal('hide');

            $('#txtFactura-' + txtFactura).val(txtFactura);

            $('#txtSaldo-' + txtFactura).val(parseFloat(abonoFactura));
            $('#txtZonaVentasFactura-' + txtFactura).val(txtZonaVenta);
            var nuevoAbono = '$' + number_format(parseFloat(abonoFactura), '0', '.', ',');

            $('#abonoTxt-' + txtFactura).text(nuevoAbono);
            $('#abono-' + txtFactura).val(abonoFactura);

            $('#img-' + txtFactura).attr('src', 'images/abonoNew.png');
            var btnEliminar = '<img src="images/cancelGeneral.png" style="width: 25px;" class="cursorpointer eliminarFactura" data-factura="' + txtFactura + '"/>';
            $('#eliminarAbono-' + txtFactura).html(btnEliminar);
            $('#txtFacturaSeleccionada').val(txtFactura);
            $('.facturaRecibo').val(txtFactura.trim());
            getTotalSaldos(abonoFactura);
            actualizaSaldos(txtFactura, abonoFactura, 'NEW');
        }
    });

    $('#btnAlertaSelectOk').click(function() {
        var abonoFactura = $('#_alertaSelect .labelAlertaSelectAboFactura').val().replace(/,/g, '');
        var valornetoFactura = $('#_alertaSelect .labelAlertaSelectSaldoFactura').val().replace(/,/g, '');
        var txtFactura = $('#_alertaSelect .labelAlertaSelectFactura').val();
        var txtZonaVenta = $('#_alertaSelect .labelAlertaSelectZonaVentasFactura').val();
        var motivo = $('_alertaSelect #inputSelect').val();

        $('#txtMotivoSaldo-' + txtFactura).val(parseFloat(motivo));

        var valorNetoFactura = $('#valorNetoFactura-' + txtFactura).val();
        var txtValorProntoPagoAplicar = $('#txtValorProntoPagoAplicar-' + txtFactura).val();

        if (txtValorProntoPagoAplicar != "" && parseFloat(txtValorProntoPagoAplicar) > 0) {
            var valorAplicarFactura = (parseFloat(valorNetoFactura) - parseFloat(txtValorProntoPagoAplicar));
            $('#descuentoPPTxt-' + txtFactura).html('$' + number_format(valorAplicarFactura), '0', '.', ',');
            $('#txtDescuentoPPValor-' + txtFactura).val(txtValorProntoPagoAplicar);
            $('#txtDescuentoPPFactura-' + txtFactura).val(valorAplicarFactura);
        }

        $('#_alertaSelect').modal('hide');

        $('#txtFactura-' + txtFactura).val(txtFactura);

        $('#txtSaldo-' + txtFactura).val(parseFloat(abonoFactura));
        $('#txtZonaVentasFactura-' + txtFactura).val(txtZonaVenta);
        var nuevoAbono = '$' + number_format(parseFloat(abonoFactura), '0', '.', ',');

        $('#abonoTxt-' + txtFactura).text(nuevoAbono);
        $('#abono-' + txtFactura).val(abonoFactura);

        $('#img-' + txtFactura).attr('src', 'images/abonoNew.png');
        var btnEliminar = '<img src="images/cancelGeneral.png" style="width: 25px;" class="cursorpointer eliminarFactura" data-factura="' + txtFactura + '"/>';
        $('#eliminarAbono-' + txtFactura).html(btnEliminar);
        $('#txtFacturaSeleccionada').val(txtFactura);
        $('.facturaRecibo').val(txtFactura.trim());
        getTotalSaldos(abonoFactura);
        actualizaSaldos(txtFactura, abonoFactura, 'NEW');
    });

    function getTotalSaldos(abonoFactura) {

        totalAbonos = 0;
        cantidadAbonos = 0;
        $('.abonos-item').each(function () {

            if ($(this).val() != "") {

                totalAbonos = parseFloat(totalAbonos) + parseFloat($(this).val().replace(/,/g, ''));
                cantidadAbonos++;
            }
        });

        var nuevoTotalAbonos = '$' + number_format(totalAbonos, '0', '.', ',');

        $('#valorFacturas').val(totalAbonos);
        $('#valorTxtFacturas').text(nuevoTotalAbonos);
        $('#totalFacturas').text(cantidadAbonos);
        $('#txtFacturaEc').val(abonoFactura);
        $('#txtValorEc').val(abonoFactura);
        $('#txtValorCheque').val(abonoFactura);
        $('#txtValorDCc').val(abonoFactura);
    }

    function actualizaSaldos(txtFactura, abonoFactura, Identificador) {

        var saldoFactura = $('#saldoFactura-' + txtFactura).val().replace(/,/g, '').replace('$','');
        var valorNetoFactura = $('#valorNetoFactura-' + txtFactura).val().replace(/,/g, '');
        var txtValorProntoPagoAplicar = $('#txtValorProntoPagoAplicar-' + txtFactura).val().replace(/,/g, '');
        var nuevoSaldo = 0;
        if(Identificador == 'NEW'){
            nuevoSaldo = saldoFactura - abonoFactura;

            if (nuevoSaldo < 0) {
                nuevoSaldo = 0;
            }
                    
            if (parseInt(abonoFactura) < parseInt(saldoFactura)) {

                if (txtValorProntoPagoAplicar != "") {
                    nuevoSaldo =  valorNetoFactura - abonoFactura;
                    nuevoSaldo = '$' + number_format(nuevoSaldo, '0', '.', ',');
                    $('#saldoTxtFactura-' + txtFactura).text(nuevoSaldo);
                    $('#saldoFactura-' + txtFactura).val(nuevoSaldo);
                }
            } else {
                nuevoSaldo = '$' + number_format(nuevoSaldo, '0', '.', ',');
                $('#saldoTxtFactura-' + txtFactura).text(nuevoSaldo);
                $('#saldoFactura-' + txtFactura).val(nuevoSaldo);
            }
        }else{
            nuevoSaldo = parseInt(saldoFactura) + parseInt(abonoFactura);
            nuevoSaldo = '$' + number_format(nuevoSaldo, '0', '.', ',');
            $('#saldoTxtFactura-' + txtFactura).text(nuevoSaldo);
            $('#saldoFactura-' + txtFactura).val(nuevoSaldo);
        }
    }

// VACIAMOS EL TD QUE CONTIENE LA IMAGEN CON EL EVENTO ONCLIK PARA ELIMINAR LA FACTURA.  
    $('body').on('click', '.eliminarFactura', function() {
        var facturaAbono = $(this).attr('data-factura');
        var abonoFactura = $('#abono-' + facturaAbono).val()     
        $('#eliminarAbono-'+facturaAbono).html('');
        deleteBillAll(facturaAbono);
        $('#img-' + facturaAbono).attr('src', 'images/monedafactura.png');
        actualizaSaldos(facturaAbono, abonoFactura, 'DELETE');
        $("#abonoTxt-" + facturaAbono).html('0');//
        $('#abono-' + facturaAbono).val('');
        $('.facturaRecibo').val('');
    });

    $("#btnOptionFormasPago").on('click', function (event) {
        $("#_formaspagos").modal('show');
    });

    $("#btnTotalFormasPago").on('click', function (event){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxTotalFormasPago',
            type: 'post',
            success: function(response){
                $('#infoFormasPago').html(response);
                $('#_TotalFormasPago').modal('show');
            }
        });
    });

    $('body').on('click', "#btnFormasPagoEfectivo", function (event){
        $("#_modalEfectivo").modal('show');
    });

    $('body').on('click',"#bntFormaPagoConsigEfectivo", function (event){
        $("#_modalConsignacionEfectivo").modal('show');
    });

    $('body').on('click',"#btnFormaPagoCheque", function (event){
        $("#_modalCheque").modal('show');
    });

    $('body').on('click',"#btnFormaPagoConsigCheque", function (event){
        $("#_modalChequeConsignacion").modal('show');
    });

    $('body').on('keyup',"#txtValorEfectivo", function (event){
        var valorEfectivoConvert = $('#txtValorEfectivo').val();
        valorEfectivoConvert = valorEfectivoConvert.replace(/,/g, '');
        $('#txtValorEfectivo').val(number_format(parseFloat(valorEfectivoConvert), '0', '.', ','));
    });

    $('body').on('keyup',"#txtValorChequeSaldo", function (event){
        var valorEfectivoConvert = $('#txtValorChequeSaldo').val();
        valorEfectivoConvert = valorEfectivoConvert.replace(/,/g, '');
        $('#txtValorChequeSaldo').val(number_format(parseFloat(valorEfectivoConvert), '0', '.', ','));
    });

    $('body').on('keyup',"#txtValorEcSaldo", function (event){
        var valorEfectivoConvert = $('#txtValorEcSaldo').val();
        valorEfectivoConvert = valorEfectivoConvert.replace(/,/g, '');
        $('#txtValorEcSaldo').val(number_format(parseFloat(valorEfectivoConvert), '0', '.', ','));
    });

        $('body').on('keyup',"#txtValorDCcSaldo", function (event){
        var valorEfectivoConvert = $('#txtValorDCcSaldo').val();
        valorEfectivoConvert = valorEfectivoConvert.replace(/,/g, '');
        $('#txtValorDCcSaldo').val(number_format(parseFloat(valorEfectivoConvert), '0', '.', ','));
    });

    $('#retornarMenu').click(function() {
        $('#_alertConfirmationMenuRecibos .text-modal-body').html(' Recuerde que al salir se eliminaran los datos ingresados. Realmente desea salir?');
        $("#_alertConfirmationMenuRecibos").modal('show');
    });

    // Funcion encargada de eliminar la informacion de las formas de pago y la factura al dar click en eliminar factura
    function deleteBillAll(numberDeletedBill){
        
        $.ajax({
            data: {
                'numberDeletedBill': numberDeletedBill.trim()
            },
            url: 'index.php?r=Recibos/AjaxDeleteBillAll',
            type: 'post',
            success: function(response){
                console.log(response);
                loadTableEfectFacturas();
                loadTableEfectConsigFacturas();
                loadTableChequeFacturas();
                loadTableConsigChequeFacturas();
                SaldoTotalFormasPagoNew();
                calcularNuevoFacturaSaldo(numberDeletedBill.trim());
            }
        });
    }

    function loadTableEfect(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxSetEfectivoDetalleTabla',
            type: 'post',
            success: function(response) {
                $("#datosEfectivoRecibos").html(response);
                InformacionEfectivo();
            }
        });
    }

    function loadTableConsigEfect(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxSetConsignacionEfectivoDetalleTabla',
            type: 'post',
            success: function(response) {
                $("#datosConsignacionEfectivoRecibos").html(response);
                InformacionConsignacionEfectivo();
            }
        });
    }

    function loadTableCheque(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxSetChequeDetalleTabla',
            type: 'post',
            success: function(response) {
                $("#datosChequesRecibos").html(response);
                Informacioncheque();
            }
        });
    }

    function loadTableConsigCheque(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxSetConsignacionChequeDetalleTabla',
            type: 'post',
            success: function(response) {

                $("#datosChequeConsignacionRecibos").html(response);
                InforamcionChqueConsignacion();
            }
        });
    }
    //Tablas formasPagoFActuras
    function loadTableEfectFacturas(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxTablaEfectivo',
            type: 'post',
            success: function(response) {
                $("#tblEfectivo").html(response);
                InformacionEfectivo();
            }
        });
    }

    function loadTableEfectConsigFacturas(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxTablaEfectivoConsignacion',
            type: 'post',
            success: function(response) {
                $("#tblConsignacionEfectivo").html(response);
                InformacionConsignacionEfectivo();
            }
        });
    }

    function loadTableChequeFacturas(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxTablaCheque',
            type: 'post',
            success: function(response) {
                $("#tblcheque").html(response);
                Informacioncheque();
            }
        });
    }

    function loadTableConsigChequeFacturas(){
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxTablaChequeConsignacion',
            type: 'post',
            success: function(response) {
                $("#tblConsignacionCheque").html(response);
                InforamcionChqueConsignacion();
            }
        });
    }


    $("#btnAgregarEfectivoDetalle").click(function() {

        var txtValorEfectivo = $('#txtValorEfectivo').val();
        if (txtValorEfectivo == "") {

            $("#_alerta").css("z-index", "270000");
            $('#_alerta .text-modal-body').html("El campo valor efectivo no puede ser vacio");
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "txtValorEfectivo": txtValorEfectivo
            },
            url: 'index.php?r=Recibos/AjaxSetEfectivoDetallle',
            type: 'post',
            success: function(response) {

                if (response != "") {
                    $("#TotalEfectivo").html(response);
                    $("#txtValorEfectivo").val('');
                    loadTableEfect();
                    SaldoTotalFormasPagoNew();
                }
            }
        });
    });

    $('#btnAgregarConEfecDetalle').click(function() {
        var txtFormaPag = $("#formas_pago").val();
        var txtNumeroEc = $('#txtNumeroEc').val();
        var txtBancoEc = $('#txtBancoEc').val();
        var txtBanco = $('#txtBanco').val();
        var txtCuenta = $('#txtCuenta').val();
        var txtFechaEc = $('#txtFechaEc').val();
        var txtValorEcSaldo = $('#txtValorEcSaldo').val();
        var txtCodBancoEc = $('#txtCodBancoEc').val();

        if (txtNumeroEc == "") {
            $("#_alerta").css("z-index", "270000");
            $('#_alerta .text-modal-body').html('El campo Número no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (!$.isNumeric(txtNumeroEc)) {
            $("#_alerta").css("z-index", "280000");
            $('#_alerta .text-modal-body').html('El campo Número debe ser númerico');
            $('#_alerta').modal('show');
            $('#txtNumeroEc').val('');
            return false;
        }
        if (txtBancoEc == "") {
            $("#_alerta").css("z-index", "290000");
            $('#_alerta .text-modal-body').html('El campo Banco no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }


        if ($('#txtBanco').val() == "") {
            $("#_alerta").css("z-index", "300000");
            $('#_alerta .text-modal-body').html('El Banco  no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtCuenta == "") {
            $('#_alerta .text-modal-body').html('El campo Cuenta no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtFechaEc == "") {
            $("#_alerta").css("z-index", "310000");
            $('#_alerta .text-modal-body').html('El campo Fecha no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtValorEcSaldo == "") {
            $("#_alerta").css("z-index", "320000");
            $('#_alerta .text-modal-body').html('El campo Valor no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtCodBancoEc == "") {
            $("#_alerta").css("z-index", "340000");
            $('#_alerta .text-modal-body').html('El campo Cod Banco puede estar vacio');
            $('#_alerta').modal('show');
            return false;

        }
        var txtxValorEfcSal = txtValorEcSaldo.replace(/,/g, '');
        $.ajax({
            data: {
                "txtFormaPag" : txtFormaPag,
                "txtNumeroEc": txtNumeroEc,
                "txtBancoEc": txtBancoEc,
                "txtBanco": txtBanco,
                "txtCuenta": txtCuenta,
                "txtFechaEc": txtFechaEc,
                "txtValorEcSaldo": txtxValorEfcSal,
                "txtCodBancoEc": txtCodBancoEc
            },
            url: 'index.php?r=Recibos/AjaxSetConsignacionEfectivoDetalle',
            type: 'post',
            success: function(response) {
                if (response == 1) {
                    $("#_alerta").css("z-index", "270000");
                    $('#_alerta .text-modal-body').html("El numero de consignacion  ya existe");
                    $('#_alerta').modal('show');
                    return false;
                } else {
                    $("#numeroconsignacion").html(response);
                    $('#txtNumeroEc').val('');
                    $('#txtBancoEc').val('');
                    $('#txtBanco').val('');
                    $('#txtCuenta').val('');
                    $('#txtFechaEc').val('');
                    $('#txtValorEcSaldo').val('');
                    $('#txtCodBancoEc').val('');
                    loadTableConsigEfect();
                    SaldoTotalFormasPagoNew();
                }
            }
        });
    })

    $("#btnAgregarChequeDetalle").click(function() {

        var txtNumeroCheque = $('#txtNumeroCheque').val();
        var txtBancoCheque = $('#txtBancoCheque').val();
        var textoBancoCheque = $('#MsgBanco').html();
        var txtCuentaCheque = $('#txtCuentaCheque').val();
        var txtFechaCheque = $('#txtFechaCheque').val();
        var txtValorChequeSaldo = $('#txtValorChequeSaldo').val();
        var txtvalorFacturas = $('#valorFacturas').val();
        var txtBanco = $('#txtBancoChe').val();
        var txtGirado = $('#txtGirado').val();
        var txtOtro = $('#txtOtro').val();

        if (txtNumeroCheque == "") {
            $("#_alerta").css("z-index", "170000");
            $('#_alerta .text-modal-body').html('El campo Número no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (!$.isNumeric(txtNumeroCheque)) {
            $("#_alerta").css("z-index", "180000");
            $('#_alerta .text-modal-body').html('El campo Número debe ser númerico');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtBanco == "") {
            $("#_alerta").css("z-index", "180000");
            $('#_alerta .text-modal-body').html('Por favor seleccione un banco');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtBancoCheque == "") {
            $("#_alerta").css("z-index", "190000");
            $('#_alerta .text-modal-body').html('El campo Banco no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if ($('#txtCodBancoCheque').val() == "") {
            $("#_alerta").css("z-index", "210000");
            $('#_alerta .text-modal-body').html('El campo Código del banco no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtGirado == "") {
            $("#_alerta").css("z-index", "22000");
            $('#_alerta .text-modal-body').html('El campo Girado a no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (textoBancoCheque == "") {
            $("#_alerta").css("z-index", "30000");
            $('#_alerta .text-modal-body').html('Por favor verifique el banco');
            $('#_alerta').modal('show');
            return false;
        }
        var girado = $("#txtGirado").val();
        if (girado == 2) {
            if (txtOtro == "") {
                $("#_alerta").css("z-index", "230000");
                $('#_alerta .text-modal-body').html('El campo Otro no puede ser vacio');
                $('#_alerta').modal('show');
                return false;
            }
        }
        if (txtFechaCheque == "") {
            $("#_alerta").css("z-index", "240000");
            $('#_alerta .text-modal-body').html('El campo Fecha no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtValorChequeSaldo == "") {
            $("#_alerta").css("z-index", "250000");
            $('#_alerta .text-modal-body').html('El campo Valor no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        var txtValorCh = txtValorChequeSaldo.replace(/,/g, '');
        $.ajax({
            data: {
                "txtNumeroCheque": txtNumeroCheque,
                "txtBancoCheque": txtBancoCheque,
                "textoBancoCheque": textoBancoCheque,
                "txtCuentaCheque": txtCuentaCheque,
                "txtFechaCheque": txtFechaCheque,
                "txtValorChequeSaldo": txtValorCh,
                "txtvalorFacturas": txtvalorFacturas,
                "txtGirado": txtGirado,
                "txtOtro": txtOtro
            },
            url: 'index.php?r=Recibos/AjaxSetChequeDetalle',
            type: 'post',
            success: function(response) {

                if (response == 2) {

                    $("#_alerta").css("z-index", "3870000");
                    $('#_alerta .text-modal-body').html("El código del banco digitado es incorrecto");
                    $('#_alerta').modal('show');
                    $('#txtBancoCheque').val('');
                    return false;
                }

                if (response == 1) {
                    $("#_alerta").css("z-index", "270000");
                    $('#_alerta .text-modal-body').html("El número de cheque para este banco ya existe");
                    $('#_alerta').modal('show');
                    return false;
                } else {

                    $("#numeros").html(response);
                    $('#txtNumeroCheque').val('');
                    $('#txtBancoCheque').val('');
                    $('#MsgBanco').html('');
                    $('#txtCuentaCheque').val('');
                    $('#txtFechaCheque').val('');
                    $('#txtValorChequeSaldo').val('');
                    $('#txtOtro').val('');
                    $('#valorFacturas').val('');
                    $('#txtBancoChe').val('');
                    $('#txtGirado').val('');
                    loadTableCheque();
                    SaldoTotalFormasPagoNew();  
                }
            }
        });
    });

    $('#btnAgregarChequeConsignadoDetalle').click(function() {

        var txtNumeroECc = $('#txtNumeroECc').val();
        var txtBancoECc = $('#txtBancoECc').val();
        var txtCuentaECc = $('#txtCuentaECc').val();
        var txtFechaECc = $('#txtFechaECc').val();
        var txtNombreBancoECc = $("#txtNombreBancoECc").val();
        var txtCodBancoECc = $("#txtCodBancoECc").val();
        var txtFacturaChc = $("#txtFacturaChc").val();
        var txtNumeroDCc = $('#txtNumeroDCc').val();
        var txtCodBancoDCc = $('#txtCodBancoDCc').val();
        var MsgBancoCc = $('#MsgBancoCc').html();
        var txtCuentaDCc = $('#txtCuentaDCc').val();
        var txtFechaDCc = $('#txtFechaDCc').val();
        var txtValorDCcSaldo = $('#txtValorDCcSaldo').val();

        if (txtNumeroECc == "") {
            $("#_alerta").css("z-index", "350000");
            $('#_alerta .text-modal-body').html('El campo Número en los Datos Consignación no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (!$.isNumeric(txtNumeroECc)) {
            $("#_alerta").css("z-index", "360000");
            $('#_alerta .text-modal-body').html('El campo Número en los Datos Consignación debe ser númerico');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtBancoECc == "") {
            $("#_alerta").css("z-index", "370000");
            $('#_alerta .text-modal-body').html('El campo Banco en los Datos Consignación no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }

        if ($('#txtCodBancoECc').val() == "") {
            $("#_alerta").css("z-index", "380000");
            $('#_alerta .text-modal-body').html('El campo Código del banco en los Datos Consignación no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }

        if (!$.isNumeric($('#txtCodBancoECc').val())) {
            $("#_alerta").css("z-index", "390000");
            $('#_alerta .text-modal-body').html('El campo Código del banco en los Datos Consignación debe ser númerico');
            $('#_alerta').modal('show');
            return false;
        }

        if ($('#txtNombreBancoECc').val() == "") {
            $("#_alerta").css("z-index", "400000");
            $('#_alerta .text-modal-body').html('El campo banco en los Datos Consignación se encuentra vacio, intente en el botón "Verificar Código"');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtCodBancoECc == "") {
            $("#_alerta").css("z-index", "600000");
            $('#_alerta .text-modal-body').html('El campo cod banco en los Datos Consignación se encuentra vacio');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtCuentaECc == "") {
            $("#_alerta").css("z-index", "410000");
            $('#_alerta .text-modal-body').html('El campo Cuenta en los Datos Cheque no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtFechaECc == "") {
            $("#_alerta").css("z-index", "420000");
            $('#_alerta .text-modal-body').html('El campo Fecha en los Datos Cheque no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtNumeroDCc == "") {
            $("#_alerta").css("z-index", "430000");
            $('#_alerta .text-modal-body').html('El campo Número en los Datos Cheque no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (!$.isNumeric(txtNumeroDCc)) {
            $("#_alerta").css("z-index", "440000");
            $('#_alerta .text-modal-body').html('El campo Número en los Datos Cheque debe ser númerico');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtCuentaDCc == "") {
            $("#_alerta").css("z-index", "460000");
            $('#_alerta .text-modal-body').html('El campo Cuenta en los Datos Cheque no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtFechaDCc == "") {
            $("#_alerta").css("z-index", "470000");
            $('#_alerta .text-modal-body').html('El campo Fecha en los Datos Cheque no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtValorDCcSaldo == "") {
            $("#_alerta").css("z-index", "480000");
            $('#_alerta .text-modal-body').html('El campo Valor en los Datos Cheque no puede ser vacio');
            $('#_alerta').modal('show');
            return false;
        }
        if (txtCodBancoDCc == "") {
            $("#_alerta").css("z-index", "490000");
            $('#_alerta .text-modal-body').html('El campo cod banco en los Datos Cheque no puede estar vacio');
            $('#_alerta').modal('show');
            return false;
        }

        var txtValorDChcSal = txtValorDCcSaldo.replace(/,/g, '');

        $.ajax({
            data: {
                "txtNumeroECc": txtNumeroECc,
                "txtBancoECc": txtBancoECc,
                "txtNombreBancoECc": txtNombreBancoECc,
                "txtCuentaECc": txtCuentaECc,
                "txtCodBancoECc": txtCodBancoECc,
                "txtFechaECc": txtFechaECc,
                "txtNumeroDCc": txtNumeroDCc,
                "txtCodBancoDCc": txtCodBancoDCc,
                "MsgBancoCc": MsgBancoCc,
                "txtCuentaDCc": txtCuentaDCc,
                "txtValorDCcSaldo": txtValorDChcSal,
                "txtFechaDCc": txtFechaDCc,
                //"txtFacturaChc": txtFacturaChc

            },
            url: 'index.php?r=Recibos/AjaxSetConsignacionChequeDetalle',
            type: 'post',
            success: function(response) {

                if (response == 1) {

                    $("#_alerta").css("z-index", "7000000");
                    $('#_alerta .text-modal-body').html('El número de cheque para este banco y esta consignación ya existe');
                    $('#_alerta').modal('show');
                    return false;
                } else {
                    $("#txtNumeroECcNo").html(response);
                    $('#txtNumeroDCc').val('');
                    $('#txtCodBancoDCc').val('');
                    $('#MsgBancoCc').html('');
                    $('#txtCuentaDCc').val('');
                    $('#txtFechaDCc').val('');
                    $('#txtValorDCcSaldo').val('');
                    loadTableConsigCheque();
                    SaldoTotalFormasPagoNew();
                }
            }
        });
    });

    //Onchange de los campos de banco
    $(".txtPagoCheque").change(function(){
        var txtcodbanco = $("#txtBancoCheque").val();
        var txtBanco = $('#txtBancoChe').val();
            $('#MsgBanco').html("");
        if (txtBanco == "") {
            $("#_alerta").css("z-index", "510000");
            $('#_alerta .text-modal-body').html('Debe seleccionar un Banco primero');
            $('#_alerta').modal('show');
            $("#txtBancoCheque").val("");
            $('#txtBancoChe').val("");
            return false;
        }

        if (txtcodbanco == "") {
            $("#_alerta").css("z-index", "520000");
            $('#_alerta .text-modal-body').html('Debe digitar un Codigo de Banco');
            $('#_alerta').modal('show');
            $("#txtBancoCheque").val("");
            $('#txtBancoChe').val("");
            return false;
        }

        $.ajax({
            data: {
                'txtCodBanco': txtcodbanco,
                'txtBanco': txtBanco

            },
            url: 'index.php?r=Recibos/AjaxValidarCodBanco',
            type: 'post',
            success: function(response) {
                if (response <= 0) {

                    $("#_alerta").css("z-index", "15000");
                    $('#_alerta .text-modal-body').html('Debe de ingresar un código válido para poder continuar. Intente nuevamente');
                    $('#_alerta').modal('show');
                    $('#txtBancoCheque').val('');
                    return false;
                }

                if (response != "") {
                    var bancos = jQuery.parseJSON(response);
                    var nombreBanco = bancos.nombreBanco;
                    var IdentificadorBanco = bancos.IdentificadorBanco;
                    $('#MsgBanco').html(IdentificadorBanco + " - " + nombreBanco);
                    $("#MsgBanco").show();
                }
            }
        });
    });


    $("#txtCodBancoEc").change(function(){
      if ($('#txtBancoEc').val() == "") {
            $("#_alerta").css("z-index", "510000");
            $('#_alerta .text-modal-body').html('Debe seleccionar un Banco primero');
            $('#_alerta').modal('show');
            $('#txtCodBancoEc').val("");
            return false;
        }

        if ($('#txtCodBancoEc').val() == "") {
            $("#_alerta").css("z-index", "520000");
            $('#_alerta .text-modal-body').html('Debe digitar un Codigo de Banco');
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "txtCodBanco": $('#txtCodBancoEc').val(),
                "txtBanco": $('#txtBancoEc').val(),
            },
            url: 'index.php?r=Recibos/AjaxValidarCodBanco',
            type: 'post',
            success: function(response) {
                $('#txtBanco').val('');
                if (response == 0) {
                    $("#_alerta").css("z-index", "600000");
                    $('#_alerta .text-modal-body').html('El código ingresado no coincide con el banco seleccionado. Intente nuevamente');
                    $('#_alerta').modal('show');
                    return false;
                }

                if (response != "") {
                    var bancos = jQuery.parseJSON(response);
                    var nombreBanco = bancos.nombreBanco;
                    var IdentificadorBanco = bancos.IdentificadorBanco;
                    $("#txtCuenta").removeAttr("disabled");
                    $('#txtBanco').val(IdentificadorBanco + " - " + nombreBanco);
                }
            }
        });
    });

    $("#txtCodBancoECc").change(function(){
        if ($('#txtBancoECc').val() == "") {
            $("#_alerta").css("z-index", "510000");
            $('#_alerta .text-modal-body').html('Debe seleccionar un Banco primero');
            $('#_alerta').modal('show');
            $('#txtCodBancoECc').val("");
            return false;
        }

        if ($('#txtCodBancoECc').val() == "") {
            $("#_alerta").css("z-index", "520000");
            $('#_alerta .text-modal-body').html('Debe digitar un Codigo de Banco');
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "txtCodBanco": $('#txtCodBancoECc').val(),
                "txtBanco": $('#txtBancoECc').val(),
            },
            url: 'index.php?r=Recibos/AjaxValidarCodBanco',
            type: 'post',
            success: function(response) {
                $('#txtNombreBancoECc').val('');

                if (response == 0) {
                    $("#_alerta").css("z-index", "800000");
                    $('#_alerta .text-modal-body').html('El codigo Ingresado no concuerda con el banco. Intentelo Nuevamente');
                    $('#_alerta').modal('show');
                    return false;
                }

                if (response != "") {
                    var bancos = jQuery.parseJSON(response);
                    var nombreBanco = bancos.nombreBanco;
                    var IdentificadorBanco = bancos.IdentificadorBanco;

                    $("#txtCuentaECc").removeAttr("disabled");
                    $('#txtNombreBancoECc').val(IdentificadorBanco + " - " + nombreBanco);
                }
            }
        });
   });

    $("#txtCodBancoDCc").change(function(){
        if ($('#txtCodBancoDCc').val() == "") {
            $("#_alerta").css("z-index", "540000");
            $('#_alerta .text-modal-body').html('Debe digitar un Codigo de Banco');
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "codbanco": $('#txtCodBancoDCc').val()
            },
            url: 'index.php?r=Recibos/AjaxValidarBanco',
            type: 'post',
            success: function(response) {

                if (response <= 0) {

                    $("#_alerta").css("z-index", "15000");
                    $('#_alerta .text-modal-body').html('Debe de ingresar un código válido para poder continuar. Intente nuevamente');
                    $('#_alerta').modal('show');
                    return false;
                } else {

                    $("#MsgBancoCc").html(response);
                    $("#MsgBancoCc").show();
                }
            }
        });
    });

    $('#TotalEfectivo').change(function(){
        InformacionEfectivo();
    });

    $('#numeroconsignacion').change(function(){
        InformacionConsignacionEfectivo();
    });

    $('#numeros').change(function(){
        Informacioncheque();
    });

    $('#txtNumeroECcNo').change(function(){
        InforamcionChqueConsignacion();
    });

    $('#txtNumeroDCcNo').change(function(){
        InformacionDetailChCosnig(); 
    });

    function InformacionEfectivo() {
        var valorefectivo = $("#TotalEfectivo").val();
        $.ajax({
            data: {
                "valorefectivo": valorefectivo
            },
            url: 'index.php?r=Recibos/AjaxCargarDatosDelArrayEfectivo',
            type: 'post',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                if(obj != null){
                    $('#SaldoEfectivo').val(obj.SaldoEfectivo);
                    $('#txtSalEfHid').val(valorefectivo);
                }
            }
        });
    }

    function Informacioncheque() {
        var numeros = $("#numeros").val();
        $.ajax({
            data: {
                "numeros": numeros
            },
            url: 'index.php?r=Recibos/AjaxCargarDatosDelArray',
            type: 'post',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                if(obj != null){
                    $('#txtBancoChequeNo').val(obj.txtBancoCheque);
                    $('#MsgBancoNo').html(obj.textoBancoCheque);
                    $('#txtCuentaChequeNo').val(obj.txtCuentaCheque);
                    $('#txtFechaChequeNo').val(obj.txtFechaCheque);

                    var Nombre;
                    var valor;
                    if (obj.txtGirado == 1) {

                        Nombre = 'Altipal';
                        valor = '1'
                    } else if (obj.txtGirado == 2) {

                        Nombre = 'Otro';
                        valor = '2';
                    }
                    $('#txtGiradoNo').html("<option value=" + valor + ">" + Nombre + "</option>");
                    $('#txtOtroNo').val(obj.txtOtro);
                    $('#txtvalorch').val(obj.txtValorTotalChequeSaldo);
                    $('#txtSaldoCheque').val(obj.txtValorChequeSaldo)
                }
            }
        });
    }

    function InformacionConsignacionEfectivo() {
        var numeroconsignacion = $("#numeroconsignacion").val();
        $.ajax({
            data: {
                "numeroconsignacion": numeroconsignacion,
            },
            url: 'index.php?r=Recibos/AjaxCargarDatosDelArrayConsignacion',
            type: 'post',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                if(obj != null){
                    $('#txtformaPago').val(obj.txtFormaPag);
                    $('#Bancos').html("<option>" + obj.txtBancoEc + "</option>");
                    $('#txtCodBancoEcNo').val(obj.txtCodBancoEc);
                    $('#txtBancoNo').val(obj.txtBanco);
                    $('#txtCuentaNo').html("<option>" + obj.txtCuenta + "</option>");
                    $('#txtFechaEcNo').val(obj.txtFechaEc);
                    $('#txtValorEcConsignacion').val(obj.txtValorTotalEcSaldo);
                    $('#txtValorEcSaldoConsignacion').val(obj.txtValorEcSaldo);
                }
            }
        });
    }

    function InforamcionChqueConsignacion() {
        var numerosChCosignacion = $("#txtNumeroECcNo").val();

        $.ajax({
            data: {
                "numerosChCosignacion": numerosChCosignacion,
            },
            url: 'index.php?r=Recibos/AjaxCargarDatosDelArrayCheConsignacion',
            type: 'post',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                if(obj != null){
                    $('#txtBancosNo').html("<option>" + obj.txtBancoECc + "</option>");
                    $('#txtCodBancoECcNo').val(obj.txtCodBancoECc);
                    $('#txtNombreBancoECcNo').val(obj.txtNombreBancoECc);
                    $('#txtCuentasNo').html("<option>" + obj.txtCuentaECc + "</option>");
                    $('#txtFechaECcNo').val(obj.txtFechaECc);

                    var cont = 0;
                    var cadena = "";
                    $.each(obj.detalle, function(i, objdetalle) {
                        cadena += '<option value="' + objdetalle.txtNumeroDCc + '-' + objdetalle.txtCodBancoDCc + '">' + objdetalle.txtNumeroDCc + '</option>';
                        if (cont == 0) {
                            $('#Msg').html(objdetalle.MsgBancoCc);
                            $('#txtCuentaDCcNo').val(objdetalle.txtCuentaDCc);
                            $('#txtFechaDCcNo').val(objdetalle.txtFechaDCc);
                            $('#txtValorDCcTotalCheque').val(objdetalle.txtValorTotalDCcSaldo);
                            $('#txtValorDCcSaldoCheque').val(objdetalle.txtValorDCcSaldo);
                            $('#txtBancoDCcNo').val(objdetalle.txtCodBancoDCc);
                        }
                        cont++;
                    });
                    $('#txtNumeroDCcNo').html(cadena);
                }
            }
        });
    }

    function InformacionDetailChCosnig() {
        var numeroDetalle = $('#txtNumeroDCcNo').val();
        $.ajax({
            data: {
                "numeroDetalle": numeroDetalle,
            },
            url: 'index.php?r=Recibos/AjaxCargarDatosDelArrayDetailCheConsignacion',
            type: 'post',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                if(obj != null){
                    $('#Msg').html(obj.MsgBancoCc);
                    $('#txtCuentaDCcNo').val(obj.txtCuentaDCc);
                    $('#txtFechaDCcNo').val(obj.txtFechaDCc);
                    $('#txtValorDCcTotalCheque').val(obj.txtValorTotalDCcSaldo);
                    $('#txtValorDCcSaldoCheque').val(obj.txtValorDCcSaldo);
                    $('#txtBancoDCcNo').val(obj.txtCodBancoDCc);
                }
            }
        });
    }

    $('#btnAgregarEfectivo').click(function() {

        var facturaRecibo = $('.facturaRecibo').val();
        var valorEfectivo = $('#txtFacturaEc').val();
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtSaldoFacturaSeleccionada = $('#txtSaldoFacturaSeleccionada').val();
        var txtSaldoEfectivo = $("#SaldoEfectivo").val();
        var txtTotalEfectivo = $("#TotalEfectivo").val();
        var txtnumEfectivo = 'Efectivo';
        var formaPagoFact = '005';

        if (valorEfectivo == "") {
            $('#_alerta .text-modal-body').html('No se ingresado un valor para la factura ' + facturaRecibo);
            $('#_alerta').modal('show');
            return false;
        }

        if (valorEfectivo == 0) {
            $('#_alerta .text-modal-body').html('El valor en efectivo no puede sero 0.');
            $('#_alerta').modal('show');
            return false;
        }

        var valorEf = valorEfectivo.replace(/,/g, '');
        var txtSaldoFacSel = txtSaldoFacturaSeleccionada.replace(/,/g, '');
        var txtSaldoEfec = txtSaldoEfectivo.replace(/,/g, '');
        var txtTotalEFec = txtTotalEfectivo.replace(/,/g, '');

        if (parseFloat(valorEf) > parseFloat(txtSaldoEfec)) {
            $('#_alerta .text-modal-body').html('El valor en efectivo no puede superar el saldo.');
            $('#_alerta').modal('show');
            return false;
        }
        $.ajax({
            data: {
                "facturaRecibo": facturaRecibo,
                "valorEfectivo": valorEf,
                "txtFacturaSeleccionada": txtFacturaSeleccionada,
                "txtSaldoFacturaSeleccionada": txtSaldoFacSel,
                "txtSaldoEfec": txtSaldoEfec,
                "txtTotalEFec": txtTotalEFec,
            },
            url: 'index.php?r=Recibos/AjaxSetEfectivo',
            type: 'post',
            success: function(response) {
                if (response == 0) {
                    $('#_alerta .text-modal-body').html('Ya se ingreso un valor en efectivo para la factura <b>' + facturaRecibo + '</b>');
                    $('#_alerta').modal('show');
                    return false;
                } else if (response == 1) {
                    $('#_alerta .text-modal-body').html('El Valor de los recaudos excede el valor de los saldos de la factura:<b>' + facturaRecibo + '</b>');
                    $('#_alerta').modal('show');
                    return false;
                } else {
                    $('#tblEfectivo').html(response);
                    InformacionEfectivo();
                    calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                    SaldoTotalFormasPagoNew();
                }
            }
        });
    });

    $('#btnAgregarConEfec').click(function() {
        var txtformaPago = $('#txtformaPago').val();
        var facturaRecibo = $('.facturaRecibo').val();
        var txtNumeroEc = $('#numeroconsignacion').val();
        var txtBancoEc = $('#Bancos').val();
        var textoBancoEc = $('#Bancos option:selected').text();
        var txtCuenta = $('#txtCuentaNo').val();
        var textoCuenta = $('#txtCuentaNo option:selected').text();
        var txtFechaEc = $('#txtFechaEcNo').val();
        var txtValorEc = $('#txtValorEc').val();
        
        var txtvalorFacturas = $('#valorFacturas').val();
        var txtFacturaEc = $('#txtFacturaEc').val();
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtSaldoFacturaSeleccionada = $('#txtSaldoFacturaSeleccionada').val();


        var txtSaldoFacSel = txtSaldoFacturaSeleccionada.replace(/,/g, '');

        var txtValorEcConsignacion = $('#txtValorEcConsignacion').val();
        var txtValorEcSaldoConsignacion = $('#txtValorEcSaldoConsignacion').val();

        var txtValEc = txtValorEc.replace(/,/g, '');
        var txtValorSaldoEfc = txtValorEcSaldoConsignacion.replace(/,/g, '');
        var txtTotalValorEcCons = txtValorEcConsignacion.replace(/,/g, '');

        var formaPagoFact = '004';

        if (facturaRecibo == "") {

            $("#_alerta").css("z-index", "1030000");
            $('#_alerta .text-modal-body').html('por favor seleccione una factura');
            $('#_alerta').modal('show');
            return false;

        }

        if (parseInt(txtValEc) > parseInt(txtValorSaldoEfc)) {

            $("#_alerta").css("z-index", "1030000");
            $('#_alerta .text-modal-body').html('El valor a recaudar no puede superar el valor del saldo de la consignacion');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtFacturaEc == 0) {

            $("#_alerta").css("z-index", "1040000");
            $('#_alerta .text-modal-body').html('No hay resgistros de recaudos pedientes para la facturas. Verifique la informacion es posible que ya se halla recaudado.');
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "txtformaPago" : txtformaPago,
                "facturaRecibo": facturaRecibo,
                "txtFacturaSeleccionada": txtFacturaSeleccionada,
                "txtSaldoFacturaSeleccionada": txtSaldoFacSel,
                "txtNumeroEc": txtNumeroEc,
                "txtBancoEc": txtBancoEc,
                "textoBancoEc": textoBancoEc,
                "txtCuenta": txtCuenta,
                "textoCuenta": textoCuenta,
                "txtFechaEc": txtFechaEc,
                "txtValorEc": txtValEc,
                "txtFacturaEc": txtFacturaEc,
                "txtvalorFacturas": txtvalorFacturas,
                "txtValorEcConsignacion": txtTotalValorEcCons
            },
            url: 'index.php?r=Recibos/AjaxSetConsignacionEfectivo',
            type: 'post',
            success: function(response) {

                if (response == 0) {
                    $("#_alerta").css("z-index", "920000");
                    $('#_alerta .text-modal-body').html('El Numero de la consignación ya existe');
                    $('#_alerta').modal('show');
                    return false;
                }

                if (response == 1) {
                    $("#_alerta").css("z-index", "930000");
                    $('#_alerta .text-modal-body').html('El Valor de los recaudos para la factura <b>' + facturaRecibo + '</b> excede el valor del abono.');
                    $('#_alerta').modal('show');
                    return false;
                }
                $('#tblConsignacionEfectivo').html(response);     
                InformacionConsignacionEfectivo();
                calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                SaldoTotalFormasPagoNew();
            }
        });
    });

    $('#btnAgregarCheque').click(function() {

        var facturaRecibo = $('.facturaRecibo').val();
        var txtNumeroCheque = $('#numeros').val();
        var txtBancoCheque = $('#txtBancoChequeNo').val();
        var textoBancoCheque = $('#MsgBancoNo').html();
        var txtCuentaCheque = $('#txtCuentaChequeNo').val();
        var txtFechaCheque = $('#txtFechaChequeNo').val();
        var txtGirado = $('#txtGiradoNo').val();
        var txtOtro = $('#txtOtroNo').val();

        var txtvalorch = $('#txtvalorch').val();
        var txtSaldoChequeNO = $('#txtSaldoCheque').val();

        var txtValorCheque = $('#txtValorCheque').val();
        var txtvalorFacturas = $('#valorFacturas').val();
        var txtFacturaEc = $('#txtFacturaEc').val();
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtSaldoFacturaSeleccionada = $('#txtSaldoFacturaSeleccionada').val();

        var txtValCheque = txtValorCheque.replace(/,/g, '');
        var txtSaldoChe = txtSaldoChequeNO.replace(/,/g, '');
        var txtTotalValChe = txtvalorch.replace(/,/g, '');
        var formaPagoFact = '002';
        var txtSaldoFacSel = txtSaldoFacturaSeleccionada.replace(/,/g, '');

        if (facturaRecibo == "") {

            $("#_alerta").css("z-index", "1500000");
            $('#_alerta .text-modal-body').html('por favor seleccione una factura');
            $('#_alerta').modal('show');
            return false;
        }

        if (parseInt(txtValCheque) > parseInt(txtSaldoChe)) {

            $("#_alerta").css("z-index", "1500000");
            $('#_alerta .text-modal-body').html('El valor a recaudar no puede superar el valor del saldo del cheque');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtValorCheque == 0) {

            $("#_alerta").css("z-index", "1020000");
            $('#_alerta .text-modal-body').html('No hay registros de recaudos pendientes para la factura. Verifique la informacion, es posible que ya se encuentre recaudada.');
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "facturaRecibo": facturaRecibo,
                "txtFacturaSeleccionada": txtFacturaSeleccionada,
                "txtSaldoFacturaSeleccionada": txtSaldoFacSel,
                "txtNumeroCheque": txtNumeroCheque,
                "txtBancoCheque": txtBancoCheque,
                "textoBancoCheque": textoBancoCheque,
                "txtCuentaCheque": txtCuentaCheque,
                //"textoCuentaCheque": textoCuentaCheque,
                "txtFechaCheque": txtFechaCheque,
                "txtValorCheque": txtValCheque,
                "txtFacturaEc": txtFacturaEc,
                "txtvalorFacturas": txtvalorFacturas,
                "txtGirado": txtGirado,
                "txtOtro": txtOtro,
                "txtvalorch": txtTotalValChe
            },
            url: 'index.php?r=Recibos/AjaxSetCheque',
            type: 'post',
            success: function(response) {

                if (response == 0) {
                    $("#_alerta").css("z-index", "930000");
                    $('#_alerta .text-modal-body').html('El número de cheque ingresado ya se encuentra registrado para el provisional y para esta factura');
                    $('#_alerta').modal('show');
                    return false;
                }

                if (response == 1) {
                    $("#_alerta").css("z-index", "940000");
                    $('#_alerta .text-modal-body').html('El Valor de los recaudos excede el valor de los saldos de la factura');
                    $('#_alerta').modal('show');
                    return false;
                }

                $('#tblcheque').html(response);
                Informacioncheque();
                calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                SaldoTotalFormasPagoNew();
            }
        });
    });

    $('#btnAgregarChequeConsignado').click(function() {

        var facturaRecibo = $('.facturaRecibo').val();
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtSaldoFacturaSeleccionada = $('#txtSaldoFacturaSeleccionada').val();
        var txtSaldoFacSel = txtSaldoFacturaSeleccionada.replace(",", "");
        var txtNumeroECc = $('#txtNumeroECcNo').val();
        var txtBancoECc = $('#txtBancosNo').val();
        var textoBancoECc = $('#txtBancosNo option:selected').text();
        var txtCuentaECc = $('#txtCuentasNo').val();
        var textoCuentaECc = $('#txtCuentasNo option:selected').text();
        var txtFechaECc = $('#txtFechaECcNo').val();
        var txtCodBancoECc = $('#txtCodBancoECcNo').val();
        var txtNumeroDCc = $('#txtNumeroDCcNo').val();
        var txtBancoDCc = $('#txtBancoDCcNo').val();
        var textoBancoDCc = $('#Msg').html();
        var txtCuentaDCc = $('#txtCuentaDCcNo').val();
        var textoCuentaDCc = $('#txtCuentaDCcNo').val();
        var txtFechaDCc = $('#txtFechaDCcNo').val();
        var txtValorDCc = $('#txtValorDCc').val();
        var txtValorDCcSaldoCheque = $('#txtValorDCcSaldoCheque').val();
        var txtValorDCcTotalCheque = $('#txtValorDCcTotalCheque').val();
        var txtvalorFacturas = $('#valorFacturas').val();
        var txtFacturaEc = $('#txtFacturaEc').val();
        var txtValDcc = txtValorDCc.replace(/,/g, '');
        var txtValSaldoChc = txtValorDCcSaldoCheque.replace(/,/g, '');
        var txtTotalDccChc = txtValorDCcTotalCheque.replace(/,/g, '');
        var formaPagoFact = '001';

        if (facturaRecibo == "") {

            $('#_alerta').css("z-index", "900000");
            $('#_alerta .text-modal-body').html('por favor seleccione una factura');
            $('#_alerta').modal('show');
            return false;
        }

        if (parseInt(txtValDcc) > parseInt(txtValSaldoChc)) {
            $('#_alerta').css("z-index", "900000");
            $('#_alerta .text-modal-body').html('El valor a recaudar no puede superar el saldo del cheque');
            $('#_alerta').modal('show');
            return false;
        }

        if (txtValorDCc == 0) {

            $('#_alerta').css("z-index", "1090000");
            $('#_alerta .text-modal-body').html('No hay resgistros de recaudos pedientes para la facturas. Verifique la informacion es posible que ya se halla recaudado');
            $('#_alerta').modal('show');
            return false;
        }

        $.ajax({
            data: {
                "facturaRecibo": facturaRecibo,
                "txtFacturaSeleccionada": txtFacturaSeleccionada,
                "txtSaldoFacturaSeleccionada": txtSaldoFacSel,
                "txtNumeroECc": txtNumeroECc,
                "txtBancoECc": txtBancoECc,
                "txtCodBancoECc": txtCodBancoECc,
                "textoBancoECc": textoBancoECc,
                "txtCuentaECc": txtCuentaECc,
                "textoCuentaECc": textoCuentaECc,
                "txtFechaECc": txtFechaECc,
                "txtNumeroDCc": txtNumeroDCc,
                "txtBancoDCc": txtBancoDCc,
                "textoBancoDCc": textoBancoDCc,
                "txtCuentaDCc": txtCuentaDCc,
                "textoCuentaDCc": textoCuentaDCc,
                "txtFechaDCc": txtFechaDCc,
                "txtValorDCc": txtValDcc,
                "txtFacturaEc": txtFacturaEc,
                "txtvalorFacturas": txtvalorFacturas,
                "txtValorDCcSaldoCheque": txtValorDCcSaldoCheque,
                "txtValorDCcTotalCheque": txtTotalDccChc,
            },
            url: 'index.php?r=Recibos/AjaxSetConsignacionCheque',
            type: 'post',
            success: function(response) {

                if (response == 0) {
                    $("#_alerta").css("z-index", "910000");
                    $('#_alerta .text-modal-body').html('El Numero de la consignación ya existe');
                    $('#_alerta').modal('show');
                    return false;
                }

                if (response == 1) {
                    $("#_alerta").css("z-index", "920000");
                    $('#_alerta .text-modal-body').html('El Valor de los recaudos excede el valor de los saldos de la factura');
                    $('#_alerta').modal('show');
                    return false;
                }

                $('#tblConsignacionCheque').html(response);
                InforamcionChqueConsignacion();
                calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                SaldoTotalFormasPagoNew();
            }
        });
    });

    //eliminar la lista de formas de pago
    $('body').on('click', '#eliminarEfectivoDetalle', function() {

        var efectivoValor = $(this).attr('data-txtValorEfectivo')

        $("#_ModalEliminarEfec").css("z-index", "9000000");
        $('#_ModalEliminarEfec .text-modal-body').html('Desea eliminar el registro en efectivo');
        $("#_ModalEliminarEfec .modal-footer").html("<button data-txtEfectivoAlert=\"" + efectivoValor + "\"id='idEfectivoAlert' class='btn btn-primary'>Si</button><button class='btn btn-primary' data-dismiss='modal'>No</button>");
        $('#_ModalEliminarEfec').modal('show');
    });


    $('body').on('click', '#idEfectivoAlert', function(){
        var efectivo = $(this).attr('data-txtEfectivoAlert');

        $.ajax({
            data: {
                'txtValorEfectivo': efectivo
            },
            url: 'index.php?r=Recibos/AjaxDeleteEfecModal',
            type: 'post',
            success: function(response) {

                if (response == 1) {

                    $("#_alerta").css("z-index", "8000000");
                    $('#_alerta .text-modal-body').html('Para poder eliminar el efectivo es necesario eliminar los registros relacionados con las facturas recaudadas');
                    $('#_alerta').modal('show');
                    $('#_ModalEliminarEfec').modal('hide');
                    return false;

                } else {

                    $("#TotalEfectivo").html(response);
                    loadTableEfect();
                    $("#SaldoEfectivo").val('');
                    $('#txtSalEfHid').val('');
                    SaldoTotalFormasPagoNew();
                    $('#_ModalEliminarEfec').modal('hide');
                }
            }
        });
    });

    $('body').on('click', '#eliminarConsigEfectivoDetalle', function() {

        var numero = $(this).attr('data-txtNumeroEfectivoConsignacion');
        var codbanco = $(this).attr('data-txtCodBancoEfectivoConsig');

        $("#_ModalEliminarConsigEfectivo").css("z-index", "9000000");
        $('#_ModalEliminarConsigEfectivo .text-modal-body').html('Desea eliminar el registro de consignación  # ' + numero + ' ');
        $('#_ModalEliminarConsigEfectivo .modal-footer').html('<button data-alertNumeroEfectivoConsignacion=' + numero + ' data-alertCodBancoEfectivoConsig=' + codbanco + ' class="btn btn-primary" id="idalertConsigEfect">Si</button> <button class="btn btn-primary" data-dismiss="modal">No</button>');
        $('#_ModalEliminarConsigEfectivo').modal('show');

    });

    $('body').on('click', '#idalertConsigEfect', function() {

        var numero = $(this).attr('data-alertNumeroEfectivoConsignacion');
        var codbanco = $(this).attr('data-alertCodBancoEfectivoConsig');

        $.ajax({
            data: {
                "numero": numero,
                "codbanco": codbanco
            },
            url: 'index.php?r=Recibos/AjaxDeleteConsigEfectivoModal',
            type: 'post',
            success: function(response) {
                if (response == 1) {

                    $("#_alerta").css("z-index", "8000000");
                    $('#_alerta .text-modal-body').html('Para poder eliminar la consignación es necesario eliminar los registros relacionados con las facturas recaudadas');
                    $('#_alerta').modal('show');
                    $('#_ModalEliminarConsigEfectivo').modal('hide');
                    return false;
                }

                loadTableConsigEfect();
                $("#Bancos").val('');
                $("#txtCodBancoEcNo").val('');
                $("#txtBancoNo").val('');
                $("#txtCuentaNo").val('');
                $("#txtFechaEcNo").val('');
                $("#txtValorEcConsignacion").val('');
                $("#txtValorEcSaldoConsignacion").val('');
                SaldoTotalFormasPagoNew();
                $('#_ModalEliminarConsigEfectivo').modal('hide');
                $('#numeroconsignacion option').each(function() {
                    if ($(this).val() == numero + "-" + codbanco)
                    {
                        $(this).remove();
                    }
                });
                $('#tipocosignacion option').each(function() {
                    if ($(this).val() == numero + "-" + codbanco)
                    {
                        $(this).remove();
                    }
                });
            }
        });
    });

    $('body').on('click', '#eliminarCheque', function() {

        var numero = $(this).attr('data-txtNumeroCheque');
        var codbanco = $(this).attr('data-txtCodBancoCheque');

        $("#_ModalEliminarCh").css("z-index", "9000000");
        $('#_ModalEliminarCh .text-modal-body').html('Desea eliminar el registro del cheque # ' + numero + ' ');
        $('#_ModalEliminarCh .modal-footer').html('<button data-alertNumeroCheque=' + numero + ' data-alertCodBancoCheque=' + codbanco + ' class="btn btn-primary" id = "idAlertCheque">Si</button><button class="btn btn-primary" data-dismiss="modal">No</button>');
        $('#_ModalEliminarCh').modal('show');
    });

    $('body').on('click','#idAlertCheque', function(){

        var numero = $(this).attr('data-alertNumeroCheque');
        var codbanco = $(this).attr('data-alertCodBancoCheque');

        $.ajax({
            data: {
                "numero": numero,
                "codbanco": codbanco
            },
            url: 'index.php?r=Recibos/AjaxDeleteChModal',
            type: 'post',
            success: function(response) {

                if (response == 1) {

                    $("#_alerta").css("z-index", "8000000");
                    $('#_alerta .text-modal-body').html('Para poder eliminar el cheque es necesario eliminar los registros relacionados con las facturas recaudadas');
                    $('#_alerta').modal('show');
                    $('#_ModalEliminarCh').modal('hide');
                    return false;

                }

                $("#numeros").html(response);
                loadTableCheque();
                $("#datosChequesRecibos").html(response);
                $('#txtBancoChequeNo').val('');
                $('#MsgBancoNo').html('');
                $('#txtCuentaChequeNo').val('');
                $('#txtFechaChequeNo').val('');
                $('#txtOtroNo').val('');
                $('#txtvalorch').val('');
                $('#txtSaldoCheque').val('');
                $('#txtGiradoNo').val('');
                SaldoTotalFormasPagoNew();
                $('#_ModalEliminarCh').modal('hide');
            }
        });
    });

    $('body').on('click', '#eliminarConsigChequeDetalle', function() {

        var numero = $(this).attr('data-txtNumeroDCCheque');
        var codbanco = $(this).attr('data-txtCodBancoDCCheque');
        var consignacion = $(this).attr('data-txtNumeroECCheque');

        $("#_ModalEliminarChequeConsignacion").css("z-index", "9000000");
        $('#_ModalEliminarChequeConsignacion .text-modal-body').html('Desea eliminar el registro del cheque consignación # ' + numero + ' ');
        $('#_ModalEliminarChequeConsignacion .modal-footer').html('<button data-alertNumeroDCCheque=' + numero + ' data-alertCodBancoDCCheque=' + codbanco + ' data-txtNumeroECCheque=' + consignacion + ' class="btn btn-primary" id="idAlertConsigChequesDetalle">Si</button><button class="btn btn-primary" data-dismiss="modal">No</button>');
        $('#_ModalEliminarChequeConsignacion').modal('show');    
    });

    $('body').on('click','#idAlertConsigChequesDetalle', function(){

        var numero = $(this).attr('data-alertNumeroDCCheque');
        var codbanco = $(this).attr('data-alertCodBancoDCCheque');
        var consignacion = $(this).attr('data-txtNumeroECCheque');

        $.ajax({
            data: {
                "numero": numero,
                "codbanco": codbanco,
                "consignacion": consignacion
            },
            url: 'index.php?r=Recibos/AjaxDeleteChequeConsigModal',
            type: 'post',
            success: function(response) {

                if (response == 1) {

                    $("#_alerta").css("z-index", "8000000");
                    $('#_alerta .text-modal-body').html('Para poder eliminar el cheque consignación es necesario eliminar los registros relacionados con las facturas recaudadas');
                    $('#_alerta').modal('show');
                    $('#_ModalEliminarChequeConsignacion').modal('hide');
                    return false;
                }

                loadTableConsigCheque();
                SaldoTotalFormasPagoNew();
                $('#_ModalEliminarChequeConsignacion').modal('hide');
                $('#txtNumeroDCcNo option').each(function() {
                    if ($(this).val() == numero + "-" + codbanco + "-" + consignacion)
                    {
                        $(this).remove();
                    }
                });
            }
        });
    });

    $('body').on('click','#eliminarConsigCheque', function() {

        var numeroconsignacion = $(this).attr('data-txtNumeroEcc');
        var codbancoconsignacion = $(this).attr('data-txtCodBancoEcc');
        $("#_ModalEliminarConsignacion").css("z-index", "9000000");
        $('#_ModalEliminarConsignacion .text-modal-body').html('Deseae eliminar el resgistro de la consignación # ' + numeroconsignacion + ' ');
        $('#_ModalEliminarConsignacion .modal-footer').html('<button data-alertNumeroEcc=' + numeroconsignacion + ' data-alertCodBancoEcc=' + codbancoconsignacion + ' class="btn btn-primary" id="idAlertConsigCheques">Si</button><button class="btn btn-primary" data-dismiss="modal">No</button>');
        $('#_ModalEliminarConsignacion').modal('show');

    });

    $('body').on('click','#idAlertConsigCheques', function() { 
        var codbancoconsignacion = $(this).attr('data-alertCodBancoEcc');
        var numeroconsignacion = $(this).attr('data-alertNumeroEcc');
        
        $.ajax({
            data: {
                "numeroconsignacion": numeroconsignacion,
                "codbancoconsignacion": codbancoconsignacion
            },
            url: 'index.php?r=Recibos/AjaxDeleteConsignacion',
            type: 'post',
            success: function(response) {
                if (response == 1) {

                    $("#_alerta").css("z-index", "8000000");
                    $('#_alerta .text-modal-body').html('Para poder eliminar la consignación es necesario eliminar los registros relacionados con las facturas recaudadas');
                    $('#_alerta').modal('show');
                    $('#_ModalEliminarConsignacion').modal('hide');
                    return false;
                }

              //  $("#datosChequeConsignacionRecibos").html(response);
                loadTableConsigCheque();
                $('#txtBancosNo').val('');
                $('#txtCodBancoECcNo').val('');
                $('#txtNombreBancoECcNo').val('');
                $('#txtCuentasNo').val('');
                $('#txtFechaECcNo').val('');
                $('#txtNumeroDCcNo').val('');
                $('#txtBancoDCcNo').val('');
                $('#txtCuentaDCcNo').val('');
                $('#txtFechaDCcNo').val('');
                $('#txtValorDCcTotalCheque').val('');
                $('#txtValorDCcSaldoCheque').val('');
                $('#Msg').html('');
                SaldoTotalFormasPagoNew();
                $('#_ModalEliminarConsignacion').modal('hide');
                var numeroconsignacionCodbanco = numeroconsignacion + '-' + codbancoconsignacion;
                $('#txtNumeroECcNo option').each(function() {
                    if ($(this).val() == numeroconsignacionCodbanco)
                    {
                        $(this).remove();
                    }
                });
            }
        });
    });

    //Eliminar facturas con formas de pago agregadas
    $('body').on('click','.eliminarEfectivoItem', function() {

        var facturaRecibo = $(this).attr('data-factura');
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var valorEf = $(this).attr('data-valor');
        var txtSaldoEfectivo = $("#txtSaldoEfectivo").val();
        var txtValotTotal = $(this).attr('data-valortotal');

        if ($.trim(facturaRecibo) != $.trim(txtFacturaSeleccionada)) {

            $('#_alerta .text-modal-body').html('Solo podrá modificar los abonos realizados a la factura actual');
            $('#_alerta').modal('show');
            return false;

        } else {
            $.ajax({
                data: {
                    "facturaRecibo": facturaRecibo,
                    "txtValotTotal": txtValotTotal,
                    "valorEf": valorEf
                },
                url: 'index.php?r=Recibos/AjaxDeleteValorEfectivo',
                type: 'post',
                success: function(response) {
                    $('#tblEfectivo').html(response);
                    InformacionEfectivo();
                    calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                    SaldoTotalFormasPagoNew();
                }
            });
        }
    });

    $('body').on('click','.eliminarItemConsEfec', function() {
        var txtNumeroEc = $(this).attr('data-numero');
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtfactura = $(this).attr('data-factura');

        if ($.trim(txtfactura) != $.trim(txtFacturaSeleccionada)) {

            $('#_alerta .text-modal-body').html('Solo podrá modificar los abonos realizados a la factura actual');
            $('#_alerta').modal('show');
            return false;

        } else {

            $.ajax({
                data: {
                    "txtNumeroEc": txtNumeroEc,
                    "txtFacturaSeleccionada": txtFacturaSeleccionada
                },
                url: 'index.php?r=Recibos/AjaxDeleteConsignacionEfectivo',
                type: 'post',
                success: function(response) {
                    $('#tblConsignacionEfectivo').html(response);
                    InformacionConsignacionEfectivo();
                    calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                    SaldoTotalFormasPagoNew();
                }
            });
        }
    });

    $('body').on('click','.eliminarCheque', function() {
        var txtNumeroCheque = $(this).attr('data-numero');
        var txtfactura = $(this).attr('data-factura');
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();

        if ($.trim(txtfactura) != $.trim(txtFacturaSeleccionada)) {

            $('#_alerta .text-modal-body').html('Solo podrá modificar los abonos realizados a la factura actual');
            $('#_alerta').modal('show');
            return false;

        } else {

            $.ajax({
                data: {
                    "txtNumeroCheque": txtNumeroCheque,
                    "txtFacturaSeleccionada": txtFacturaSeleccionada
                },
                url: 'index.php?r=Recibos/AjaxDeleteCheque',
                type: 'post',
                success: function(response) {
                    $('#tblcheque').html(response);
                    Informacioncheque();
                    calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                    SaldoTotalFormasPagoNew();
                }
            });
        }
    });

    $('body').on('click','.eliminarItemConsCheque', function() {
        var txtNumeroECc = $(this).attr('data-numero');
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtfactura = $(this).attr('data-factura');
        var valor = $(this).attr('data-val');
        var numero = $(this).attr('data-num');
        var StringChque = "";
       /* $(".chequeAliminar").each(function() {

            valor = $(this).attr('data-val');
            numero = $(this).attr('data-num');
            StringChque = StringChque + "{'txtValorDcc':" + valor + ", 'txtNumero':'" + numero + "'},";

        });*/

        //var newChque = StringChque.substring(0, StringChque.length - 1);
        var newChque = "{'txtValorDcc':" + valor + ", 'txtNumero':'" + numero + "'}";
        StringChque = "[" + newChque + "]";
        var jsonVeriante = eval(StringChque);

        if ($.trim(txtfactura) != $.trim(txtFacturaSeleccionada)) {

            $('#_alerta .text-modal-body').html('Solo podrá modificar los abonos realizados a la factura actual');
            $('#_alerta').modal('show');
            return false;

        } else {

            $.ajax({
                data: {
                    "txtNumeroECc": txtNumeroECc,
                    "txtfactura": txtfactura,
                    "JsonString": jsonVeriante
                },
                url: 'index.php?r=Recibos/AjaxDeleteChequeItem',
                type: 'post',
                success: function(response) {
                    $('#tblConsignacionCheque').html(response);
                    InforamcionChqueConsignacion();
                    calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                    SaldoTotalFormasPagoNew();
                }
            });
        }
    });

    $('body').on('click','.eliminarSubItemConsCheque', function() {
        var txtNumeroECc = $(this).attr('data-numero');
        var txtNumeroDCc = $(this).attr('data-subnumero');
        var txtFacturaSeleccionada = $('#txtFacturaSeleccionada').val();
        var txtValorDcc = $(this).attr('data-valorDcc');

        var txtfactura = $(this).attr('data-factura');

        if ($.trim(txtfactura) != $.trim(txtFacturaSeleccionada)) {

            $('#_alerta .text-modal-body').html('Solo podrá modificar los abonos realizados a la factura actual');
            $('#_alerta').modal('show');
            return false;

        } else {

            $.ajax({
                data: {
                    "txtNumeroECc": txtNumeroECc,
                    "txtNumeroDCc": txtNumeroDCc,
                    "txtValorDcc": txtValorDcc
                },
                url: 'index.php?r=Recibos/AjaxDeleteChequeSubItem',
                type: 'post',
                success: function(response) {
                    $('#tblConsignacionCheque').html(response);
                    InformacionDetailChCosnig();
                    calcularNuevoFacturaSaldo(txtFacturaSeleccionada);
                    SaldoTotalFormasPagoNew();
                }
            });
        }
    });

    $('#btnGuardarRecibo').click(function() {

        $('#btnGuardarRecibo').attr('disabled', true);
        var txtvalorFacturas = $('#valorFacturas').val();


        if (txtvalorFacturas == "" || txtvalorFacturas == '0') {
            $('#_alerta .text-modal-body').html('No hay datos para guardar');
            $('#_alerta').modal('show');
            return false;
        }

        var conValorDebe = 0;
        $('.abonos-item').each(function() {
            var factura = $(this).attr('data-factura');
            var valorAbonoFactura = ($(this).val()).replace(/,/g, '');
            if (valorAbonoFactura != "") {

                $.ajax({
                    data: {
                        "abonoSeleccionado": valorAbonoFactura,
                        "txtFacturaSeleccionada": factura,
                    },
                    url: 'index.php?r=Recibos/AjaxGetTotal',
                    type: 'post',
                    async: false,
                    success: function(response) {
                        if (response != 0) {
                            $('#_alerta .text-modal-body').html('El Valor de los recaudos para la factura <b>' + factura + '</b> no se han completado, falta por recaudar: ' + response);
                            $('#_alerta').modal('show');
                            conValorDebe = +parseFloat(response);
                            return false;
                        }
                    }
                });
            }
        });
        var total = parseInt($("#txtSaldoFormasPago").text());
        if (conValorDebe === 0 && total  == 0) {
            $('#frmGuardarRecibo').submit();
        }else{
            $('#_alertaSaldoAFavor .text-modal-body').html('Aun no se ha completado el uso de formas de pago registradas, desea continuar con el envio de recaudo');
            $('#_alertaSaldoAFavor').modal('show');
            return false;
        }
         $('#btnGuardarRecibo').attr('disabled', true);
    });

    $('body').on('click','.okSaldoFavor',function(){
       $('#frmGuardarRecibo').submit();
    });

    function calcularNuevoFacturaSaldo(txtFacturaSeleccionada) {
        txtFacturaSeleccionada = txtFacturaSeleccionada.trim();
        var abonoSeleccionado = $('#abono-'+txtFacturaSeleccionada).val();
        var abonoSel = abonoSeleccionado.replace(/,/g, '');
        $.ajax({
            data: {
                'txtFacturaSeleccionada': txtFacturaSeleccionada,
                'abonoSeleccionado': abonoSel,
            },
            url: 'index.php?r=Recibos/AjaxGetTotal',
            type: 'post',
            success: function(response) {

                $('#txtFacturaEc').val(response);
                $('#txtValorEc').val(response);
                $('#txtValorCheque').val(response);
                $('#txtValorDCc').val(response);
            }
        });
    }

    function SaldoTotalFormasPagoNew() {
        $.ajax({
            data: {
            },
            url: 'index.php?r=Recibos/AjaxSumarFormasPago',
            type: 'post',
            success: function(response) {
                var obj = jQuery.parseJSON(response);
                $('#txtSaldoFormasPago').html(obj.saldoFormasPagoFormat);
                $('.txtSaldoFormasPago').val(obj.saldoFormasPago);
                $('#txtTotalFormasPago').html(obj.totalDigitadoFormateado);
            }
        });
    }

    //Funciones de utilidad
    function number_format(number, decimals, dec_point, thousands_sep) {
        var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
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

    jQuery('#txtFechaCheque').datepicker({
        dateFormat: 'yy-mm-dd',
        showOn: "button",
        buttonImage: "images/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
    });

    jQuery('#txtFechaEc').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 'today',
        showOn: "button",
        buttonImage: "images/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
    });

    jQuery('#txtFechaECc').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 'today',
        showOn: "button",
        buttonImage: "images/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
    });

    jQuery('#txtFechaDCc').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 'today',
        showOn: "button",
        buttonImage: "images/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
    });

});


