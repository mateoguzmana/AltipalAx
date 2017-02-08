/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    if ($("#ProductoGestionado").val() != '2') {
        if ($("#PedidoExistente").val() != '1') {
            if ($("#IdPedidoLink").val() != "") {
                var agencia = $("#CodAgenciaLink").val();
                var grupoVentas = $("#GrupoVentasLink").val();
                var idPedido = $("#IdPedidoLink").val();
                $.ajax({
                    data: {
                        'agencia': agencia,
                        'grupoVentas': grupoVentas,
                        'idPedido': idPedido
                    },
                    url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetallePedido',
                    type: 'post',
                    beforeSend: function () {
                        $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
                    },
                    success: function (response) {
                        $("#imgCargando1").html('');
                        $('#mdlDetallePedido .modal-body').html(response);
                        $('#mdlDetallePedido').modal('show');
                        InicializarCheck();
                    }
                });
            }
        }
    }
});

$('.btnDetallePedido').click(function () {
    var agencia = $(this).attr('data-agencia');
    var grupoVentas = $(this).attr('data-grupo-ventas');
    var idPedido = $(this).attr('data-id-pedido');
    $.ajax({
        data: {
            'agencia': agencia,
            'grupoVentas': grupoVentas,
            'idPedido': idPedido
        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetallePedido',
        type: 'post',
        beforeSend: function () {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {
            $("#imgCargando1").html('');
            $('#mdlDetallePedido .modal-body').html(response);
            $('#mdlDetallePedido').modal('show');
            InicializarCheck();
        }
    });
});

function InicializarCheck() {
    $('#checkboxAll').click(function () {
        if ($(this).is(":checked")) {
            $('.itemCheck').each(function () {
                $(this).prop("checked", true);
            });
            $('.sltItem').each(function () {
                $(this).val('');
            });
        } else {
            $('.itemCheck').each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    $('.sltItemDinamica').change(function () {
        var idDescPedido = $(this).attr('data-idDescripcionPedido');
        $("#Dinamicas" + idDescPedido + "").prop('selectedIndex', 0);
        $("#ValorDina" + idDescPedido + "").html('');
        $("#SaldoDina" + idDescPedido + "").html('');
        $("#ValorDinamica" + idDescPedido + "").val('');
        $("#SaldoDinamica" + idDescPedido + "").val('');
        $("#CodDinamica" + idDescPedido + "").val('');
    });
    $('.LimpiarMotivos').change(function () {
        var desPedido = $(this).attr('data-idDescripPedido');
        $("#motivoIdDesPedido_" + desPedido + "").prop('selectedIndex', 0);
    });
    $('.sltItem').change(function () {
        var variante = $(this).attr('data-variante');
        $('#checkbox_' + variante).prop("checked", false);
    });
    $('.itemCheck').click(function () {
        var desPedido = $(this).attr('data-id-des-pedido');
        $('#motivoIdDesPedido_' + desPedido).val('');
    });
}

function CargarDinamica(id, Agencia, ValorDescuento) {
    var CodDinamica = $("#Dinamicas" + id + "").val();
    //alert(ValorDescuento);
    $.ajax({
        data: {
            'agencia': Agencia,
            'coddinamica': CodDinamica,
        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDinamica',
        type: 'post',
        beforeSend: function () {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {
            var valores = jQuery.parseJSON(response);
            var ValorDinamica = valores.ValorDinamica;
            var SaldoDinamica = valores.SaldoDinamica;
            $('#tableItems tbody tr').each(function () {
                var idDescPedidoItem = $(this).attr('data-idDescripPedidoth');
                var ValorDescuentoItem = $(this).attr('data-valorDescuentoth');
                var CodDinamicaItem = $("#CodDinamica" + idDescPedidoItem + "").val();
                //alert(idDescPedidoItem); 
                if (CodDinamica == CodDinamicaItem) {
                    SaldoDinamica = parseInt(SaldoDinamica) - parseInt(ValorDescuentoItem);
                }
            });
            SaldoDinamica = parseInt(SaldoDinamica) - parseInt(ValorDescuento)
            if (parseInt(SaldoDinamica) < 0) {
                $('#_alertaDescuento .text-modal-body').html('A exedido el saldo de la dinamica <b>' + CodDinamica + '</b>');
                $('#_alertaDescuento').modal('show');
                $("#Dinamicas" + id + "").val(0);
            } else {
                var ValorLabel = new Intl.NumberFormat().format(ValorDinamica);
                var SaldoLabel = new Intl.NumberFormat().format(SaldoDinamica);
                $("#ValorDina" + id + "").html('Valor Dinamica: $ ' + ValorLabel);
                $("#SaldoDina" + id + "").html(' Saldo Dinamica: $ ' + SaldoLabel);
                $("#ValorDinamica" + id + "").val(ValorDinamica);
                $("#SaldoDinamica" + id + "").val(SaldoDinamica);
                $("#CodDinamica" + id + "").val(CodDinamica);
            }
        }
    });
}

function CargarSaldoDinamica(idDinamica, Agencia) {
    var CodDinamica = idDinamica;
    var resp = [];
    // window.alert("entro al cargar saldo dinmicas");
    $.ajax({
        data: {
            'agencia': Agencia,
            'coddinamica': CodDinamica,
        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDinamica',
        type: 'post',
        async: false,
        beforeSend: function () {
            $("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {
            var valores = jQuery.parseJSON(response);
            var ValorDinamica = valores.ValorDinamica;
            var SaldoDinamica = valores.SaldoDinamica;
            resp.push(SaldoDinamica);
        }
    });
    return resp[0];
}

$('body').on('click', '#btnGuardarPedido', function () {
//$('#btnGuardarPedido').click(function() {
    var validar = true;
    $('.itemCheck').each(function () {
        if (!$(this).is(":checked")) {
            var nombreArticulo = $(this).attr('data-nombre');
            var idDescPedido = $(this).attr('data-id-des-pedido');
            if (!$('#motivoIdDesPedido_' + idDescPedido).val() || $('#motivoIdDesPedido_' + idDescPedido).val() == "") {
                $('#_alertaDescuento .text-modal-body').html('El articulo <b>' + nombreArticulo + '</b> no tiene seleccionado un motivo de rechazo');
                $('#_alertaDescuento').modal('show');
                validar = false;
                return false;
            }
        } else {
            var idDescPedido = $(this).attr('data-id-des-pedido');
            var ValorDinamica = $("#ValorDinamica" + idDescPedido + "").val();
            var ValorDescuento = $(this).attr('data-valorDescuento');
            var nombreArticulo = $(this).attr('data-nombre');
            var valorTotalDescuento = "0";
            valorTotalDescuento += parseInt(ValorDescuento);
            if ($("#Dinamicas" + idDescPedido + "").val() == '0') {
                $('#_alertaDescuento .text-modal-body').html('Por favor seleccione una dinámica');
                $('#_alertaDescuento').modal('show');
                validar = false;
                return false;
            }
            if (parseInt(ValorDescuento) > parseInt(ValorDinamica)) {
                $('#_alertaDescuento .text-modal-body').html('El descuento del producto <b>' + nombreArticulo + '</b> es mayor al valor de la dinamica');
                $('#_alertaDescuento').modal('show');
                validar = false;
                return false;
            }
            if (parseInt(valorTotalDescuento) > parseInt(ValorDescuento)) {
                $('#_alertaDescuento .text-modal-body').html('El descuento del producto <b>' + nombreArticulo + '</b> es mayor al valor de la dinamica');
                $('#_alertaDescuento').modal('show');
                validar = false;
                return false;
            }
        }
    });
    if (validar) {
        //  window.alert("entro al carga la validacion");
        //$('#_alertaGuardando').modal('show');
        // var ValorDinamica = $("#SaldoDinamica"+idDescPedido+"").val();         
        $('.itemCheck').each(function () {
            var idDescPedido = $(this).attr('data-id-des-pedido');
            var ValorDescuento = $(this).attr('data-valorDescuento');
            var CodDinamica = $("#CodDinamica" + idDescPedido + "").val();
            var idPedido = $(this).attr('data-id-pedido');
            var idDescripcionPedido = $(this).attr('data-id-des-pedido');
            var descuentoAltipal = $(this).attr('data-desc-altipal');
            var descuentoProveedor = $(this).attr('data-desc-proveedor');
            var cedulaUsuario = $(this).attr('data-cedula-usuario');
            var nombreusuario = $(this).attr('data-nombre-usuario');
            var agencia = $(this).attr('data-agencia');
            var actividadespecial = $("#actividadespecial").val();
            var grupoVentas = $("#GrupoVentasLink").val();
            // window.alert("entro este.. es el codigo agencia: " +CodDinamica+ " este es la agencia: " +  agencia + " este es el valor del descuento: " + ValorDescuento);    
            var ValorDinamica = CargarSaldoDinamica(CodDinamica, agencia);
            // window.alert("este es el valor de la dinamica: " +ValorDinamica);
            var NuevoValorDinamica = parseInt(ValorDinamica) - parseInt(ValorDescuento);
            var valor = parseInt(NuevoValorDinamica);
            //   window.alert("este es el valor de la dinamica: " + valor);
            if (!$(this).is(":checked")) {
                var motivo = $('#motivoIdDesPedido_' + idDescripcionPedido).val();
            }
            $.ajax({
                data: {
                    'idPedido': idPedido,
                    'idDescripcionPedido': idDescripcionPedido,
                    'descuentoAltipal': descuentoAltipal,
                    'descuentoProveedor': descuentoProveedor,
                    'cedulaUsuario': cedulaUsuario,
                    'nombreusuario': nombreusuario,
                    'agencia': agencia,
                    'motivo': motivo,
                    'actividadespecial': actividadespecial,
                    'ValorDinamica': valor,
                    'CodDinamica': CodDinamica
                },
                async: false,
                url: 'index.php?r=reportes/AprovacionDocumentos/AjaxGuardarPedido',
                type: 'post',
                beforeSend: function () {
                    //$("#imgCargando1").html('<img alt="" src="images/loaders/loader9.gif">');
                    //$("#_alertaGuardando").modal('show'); 
                },
                success: function (response) {
                    //$('#_alertaCargando').modal('hide');
                    //$('#_alertaGuardando').modal('hide');
                    $("#IdPedidoLink").val('');
                    window.location.href = "index.php?r=reportes/AprovacionDocumentos/AjaxDetalleDescuentos&agencia=" + agencia + "&grupoVentas=" + grupoVentas + "";
                }
            });
        });
    }
});

$('#retornarMenu').click(function () {
    window.location.href = 'index.php?r=reportes/AprovacionDocumentos/Descuentos';
});