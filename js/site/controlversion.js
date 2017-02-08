jQuery(document).ready(function () {
    $('#Datoszona').dataTable({
        "bPaginate": false,
        "bProcessing": true,
        "sAjaxSource": "index.php?r=site/AjaxActualizarVersion",
        "aoColumns": [
            {mData: 'CodZonaVentas'},
            {mData: 'Cedula'},
            {mData: 'Nombre'},
            {mData: 'Clave'},
            {mData: 'Version'},
            {mData: 'NuevaVersion'},
            {mData: 'Agencia'},
            {mData: 'Actualizar'}
        ]
    });
});

$('.ActualizarVersion').click(function () {
    var UsuariisaActualizar = 0;
    var checkNoActualizar = 0;
    $(".chckVersion").each(function () {
        UsuariisaActualizar++;
        if ($(this).is(":checked")) {
            checkNoActualizar++;
        }
    });
    if (checkNoActualizar == 0) {
        $('#_alerta .text-modal-body').html('Por favor seleccione los asesores a actualizar');
        $('#_alerta').modal('show');
        return false;
    }
    var arr_version = new Array();
    var z = 0;
    $(".chckVersion").each(function () {
        if ($(this).is(":checked")) {
            arr_version[z] = $(this).val();
        }
        z++;
    });
    z = 0;
    $.ajax({
        data: {
            'version': arr_version,
        },
        url: 'index.php?r=site/AjaxActulizarVersion',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $("#_alertaActualizacionVercion #sucess").html('Se Actualizo Correctamente la Version');
            $("#_alertaActualizacionVercion").modal('show');
            window.setTimeout(function () {
                location.reload();
            }, 2000);
        }
    });
});


$(".Versiones").click(function () {
    $.ajax({
        url: 'index.php?r=site/AjaxTablaVersiones',
        type: 'post',
        beforeSend: function () {
        },
        success: function (response) {
            $("#_modalinformationVersiones").modal('show');
            $("#TablaVersiones").html(response);
            $('#VersionesAnteriores').dataTable({
                "pagingType": "full_numbers",
                "bProcessing": true,
                "sAjaxSource": "index.php?r=site/AjaxVersionesAnteriores",
                "aoColumns": [
                    {mData: 'Fecha'},
                    {mData: 'Hora'},
                    {mData: 'Observacion'},
                    {mData: 'Version'},
                ]
            });
        }
    });
})

function marcarCheck(source)
{
    checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
    for (i = 0; i < checkboxes.length; i++) //recoremos todos los controles
    {
        if (checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
        {
            checkboxes[i].checked = source.checked; //si es un checkbox le damos el valor del checkbox que lo llamó (Marcar/Desmarcar Todos)
        }
    }
}