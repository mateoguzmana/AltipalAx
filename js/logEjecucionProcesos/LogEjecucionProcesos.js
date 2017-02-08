function LogDetails(id) {
    $.ajax({
        data: {
            'id': id
        },
        type: 'post',
        url: 'index.php?r=LogEjecucionProcesos/AjaxQueryLogProcessExcecutionDetail',
        success: function (response) {
            var ProcessDet = JSON.parse(response);
            var table = '<div class="table-responsive"><table class="table table-bordered" width="100%"><thead><tr style="background-color: #8DB4E2;">';
            table += '<th>Orden Ejecuci&#243;n</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Detalle</th></tr></thead>';
            var cont = 1;
            table += '<tbody>';
            $.each(ProcessDet, function (index, value) {
                var estado = "";
                if (value['Estado'] == 1) {
                    estado = "Ejecutado";
                } else {
                    estado = "No Ejecutado";
                }
                table += '<tr><td>' + value['Orden'] + '</td><td>' + value['NombreClase'] + '</td><td>' + value['Fecha'] + '</td><td>' + value['Hora'] + '</td><td>' + estado + '</td><td><a onclick="LogDetailsParameters(' + value['Id'] + ')" class="btn btn-default"><span class="glyphicon glyphicon-list"></span></a></td></tr>';
                cont++
            });
            table += '</tbody></table></div>';
            $('#_modalGeneric .modal-title').html('Detalle Ejecuci&#243;n');
            $('#_modalGeneric .modal-body').html(table);
            $('#_modalGeneric').modal('show');
            $('#_modalGeneric').css('overflow', 'auto');
        }
    });
}

function LogDetailsParameters(id) {
    $.ajax({
        data: {
            'id': id
        },
        type: 'post',
        url: 'index.php?r=LogEjecucionProcesos/AjaxQueryLogProcessExcecutionDetailParameters',
        success: function (response) {
            var ProcessDet = JSON.parse(response);
            var table = '<div class="table-responsive"><table class="table table-bordered" width="100%"><thead><tr style="background-color: #8DB4E2;">';
            table += '<th>#</th><th>Agencia</th><th>Sitio / Zona de Ventas / Grupo de ventas</th></tr></thead>';
            var cont = 1;
            table += '<tbody>';
            $.each(ProcessDet, function (index, value) {
                var parametro = value['Parametro'] == null ? "No aplica" : value['Parametro'];
                table += '<tr><td>' + cont + '</td><td>' + value['Nombre'] + '</td><td>' + parametro + '</td></tr>';
                cont++
            });
            table += '</tbody></table></div>';
            $('#_modalGeneric2 .modal-title').html('Detalle Controlador');
            $('#_modalGeneric2 .modal-body').html(table);
            $('#_modalGeneric2').modal('show');
            $('#_modalGeneric2').css('overflow', 'auto');
        }
    });
}

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
        url: 'index.php?r=LogEjecucionProcesos/AjaxQueryLogExcecutionProcess',
        success: function (response) {
            var ProcessDet = JSON.parse(response);
            var cont = 1;
            var tbody = '';
            if (Object.keys(ProcessDet).length > 0) {
                $.each(ProcessDet, function (index, value) {
                    var Tipo = ""
                    var Detail = "";
                    if (value['NombreClase'] == null) {
                        Tipo = "Servicio(s) con parametros";
                        Detail = '<a onclick="LogDetails(' + value['Id'] + ')" class="btn btn-default"><span class="glyphicon glyphicon-list"></span></a>';
                    } else if (value['IdControlador'] == 0) {
                        Tipo = "Proceso Completo";
                    } else {
                        Tipo = "Servicio Completo: " + value['NombreClase'];
                    }
                    tbody += '<tr><td>' + cont + '</td><td>' + value['Cedula'] + '</td><td>' + value['Nombre'] + '</td><td>' + value['FechaInicio'] + '</td><td>' + value['HoraInicio'] + '</td><td>' + Tipo + '</td><td>' + Detail + '</td></tr>';
                    cont++;
                });
            }
            $('#ListSummary').html(tbody);
        }
    });
}