function Search() {
    var fechaini = $('#fechaini').val();
    var fechafin = $('#fechafin').val();
    if (fechaini > fechafin) {
        $('#_alerta .text-modal-body').html("La fecha inicial no puede ser mayor a la fecha final!");
        $('#_alerta').modal('show');
        return;
    }
    $.ajax({
        data: {
            'fechaini': fechaini,
            'fechafin': fechafin
        },
        type: 'post',
        url: 'index.php?r=LogPermisosPaginaWeb/AjaxQueryLogPermissions',
        success: function (response) {
            var Permissions = JSON.parse(response);
            var cont = 1;
            var tbody = '';
            if (Object.keys(Permissions).length > 0) {
                $.each(Permissions, function (index, value) {
                    tbody += '<tr><td>' + cont + '</td><td>' + value['Cedula'] + '</td><td>' + value['Nombre'] + '</td><td>' + value['Fecha'] + '</td><td>' + value['Agencia'] + '</td><td>' + value['CodZonaVentas'] + '</td><td>' + value['FechaInicial'] + '</td><td>' + value['FechaFinal'] + '</td><td>' + value['Observacion'] + '</td></tr>';
                    cont++;
                });
            }
            $('#ListSummary').html(tbody);
        }
    });
}