$('#retornarMenu').click(function () {
    window.location.href = 'index.php?r=reportes/AprovacionDocumentos/AprobarNotasCredito';
});

function CargarDinamica(id) {
    var CodDinamica = $("#DinamicasNotas" + id + "").val();
    var Agencia = $("#agencia").val();
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
            var ValorLabel = new Intl.NumberFormat().format(ValorDinamica);
            var SaldoLabel = new Intl.NumberFormat().format(SaldoDinamica);
            $("#ValorDina" + id + "").html('Valor Dinamica: $ ' + ValorLabel);
            $("#SaldoDina" + id + "").html(' Saldo Dinamica: $ ' + SaldoLabel);
            $("#ValorDinamica" + id + "").val(ValorDinamica);
            $("#SaldoDinamica" + id + "").val(SaldoDinamica);
            $("#CodDinamica" + id + "").val(CodDinamica);
        }
    });
}

$('.btnautorizar').click(function () {
    var id = $(this).attr('data-nota');
    var valor = $(this).attr('data-valor');
    if ($("#DinamicasNotas" + id + "").val() == '0') {
        $('#_alertaNota .text-modal-body').html('Por favor seleccione una dinámica');
        $('#_alertaNota').modal('show');
        return false;
    }
    var ValorDinamica = $("#SaldoDinamica" + id + "").val();
    if (parseInt(valor) > parseInt(ValorDinamica)) {
        $('#_alertaNota .text-modal-body').html('El valor de la nota credito supera el valor de la dinámica');
        $('#_alertaNota').modal('show');
        return false;
    }
    var ValorNuevoDinamica = parseInt(ValorDinamica) - parseInt(valor);
    var agencia = $("#agencia").val();
    var cli = $(this).attr('data-cli');
    var factura = $(this).attr('data-factura');
    var zona = $(this).attr('data-zona');
    var asesor = $(this).attr('data-asesor');
    var CodDinamica = $("#CodDinamica" + id + "").val();
    var remitente = $("#remitente").val();
    $.ajax({
        data: {
            'id': id,
            'agencia': agencia,
            'valor': valor,
            'cli': cli,
            'factura': factura,
            'remitente': remitente,
            'zona': zona,
            'asesor': asesor,
            'valordinamica': ValorNuevoDinamica,
            'coddinamica': CodDinamica
        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxAutorizarNotaCredito',
        type: 'post',
        beforeSend: function () {
        },
        success: function () {
            $("#_alertaGurdado .text-modal-body").html('La Nota Crédito fue Autorizada Correctamente');
            $("#_alertaGurdado").modal('show');
        }
    });
});

$('.btnrechazar').click(function () {
    var id = $(this).attr('data-notaRechazar');
    var comnentario = $("#comentario" + id).val();
    var agencia = $("#agencia").val();
    var valor = $(this).attr('data-valor');
    var cli = $(this).attr('data-cli');
    var factura = $(this).attr('data-factura');
    var zona = $(this).attr('data-zona');
    var remitente = $("#remitente").val();
    var asesor = $(this).attr('data-asesor');
    if (comnentario == "") {
        $("#_alertaNota .text-modal-body").html('Para poder rechazar la nota crédito es necesario ingresar el comentario');
        $("#_alertaNota").modal('show');
    } else {
        $.ajax({
            data: {
                'id': id,
                'comnentario': comnentario,
                'agencia': agencia,
                'valor': valor,
                'cli': cli,
                'factura': factura,
                'remitente': remitente,
                'zona': zona,
                'asesor': asesor
            },
            url: 'index.php?r=reportes/AprovacionDocumentos/AjaxRechazarNotaCredito',
            type: 'post',
            beforeSend: function () {
            },
            success: function (response) {
                $("#_alertaGurdado .text-modal-body").html('La Nota Credito fue Rechazada Correctamente');
                $("#_alertaGurdado").modal('show');
            }
        });
    }
});

function refrehs() {
    location.reload();
}

function Fotos(id, agencia) {
    $.ajax({
        data: {
            'id': id,
            'agencia': agencia
        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetalleFotos',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            if (response == "") {
                $('#_alertaNotamsg .text-modal-body').html('No hay fotos para la nota credito seleccionada');
                $('#_alertaNotamsg').modal('show');
                return;
            } else {
                $('#DetalleFotos').modal('show');
                $("#tabladetallefoto").html(response);
            }
        }
    });
}

function Detalle(numfactu) {
    $.ajax({
        data: {
            'numfactu': numfactu
        },
        url: 'index.php?r=reportes/AprovacionDocumentos/AjaxDetalleFactura',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $("#_alertInformacionFacDetail  #tabladetalle").html(response);
            $("#_alertInformacionFacDetail").modal('show');
        }
    });
}