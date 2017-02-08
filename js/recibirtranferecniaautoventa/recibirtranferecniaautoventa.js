jQuery(document).ready(function () {
    $('#DatosTranferenciaAutoventa').dataTable({
        "pagingType": "full_numbers",
        "bProcessing": true,
        "sAjaxSource": "index.php?r=RecibirTransferencia/AjaxCargarTranferencias",
        "aoColumns": [
            {mData: 'ZonaVentas'},
            {mData: 'FechaTransferenciaAutoventa'},
            {mData: 'HoraEnviado'},
            {mData: 'Cantidad'},
            {mData: 'Aceptar'}
        ]
    });
});

$(document).on('click', '.Aceptar', function () {
    var Id = $(this).attr('data-idtransferencia');
    var zona = $(this).attr('data-zona');
    $.ajax({
        data: {
            'Id': Id,
            'zona': zona
        },
        url: 'index.php?r=RecibirTransferencia/AjaxAceptarTransferencia',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            location.reload();
        }
    });
});