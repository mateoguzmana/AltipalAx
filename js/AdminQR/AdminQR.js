$('body').on('change', '#Agencia', function () {
    var Agenciesselect = $('#Agencia').val();
    if (Agenciesselect != "") {
        $('#ListSummary').html('');
        $('#_alertaCargando .text-modal-body').html("Consultando grupos..");
        $('#_alertaCargando').modal('show');
        $.ajax({
            data: {
                Agencies: Agenciesselect
            },
            url: 'index.php?r=AdminQR/AjaxQuerySalesGroup',
            type: 'post',
            success: function (response) {
                var json = JSON.parse(response);
                if (json != "") {
                    var select = '<label class="col-sm-4 control-label">Seleccione una grupo de ventas</label><div class="col-sm-6"><select id="Sales" name="Sales" class="form-control chosen-select" data-placeholder="Seleccione una agencia"> <option value=""></option>';
                    var option = "";
                    $.each(json.SalesGroup, function (i, item) {
                        option += '<tr><td class="text-center">' + item["CodigoGrupoVentas"] + '</td><td class="text-center">' + item["NombreGrupoVentas"] + '</td><td class="text-center"><label><input type="checkbox" class="check" id="' + item["CodigoGrupoVentas"] + '"></label></td></tr>';
                    });
                    $('#ListSummary').append(option);
                    if (Object.keys(json.GroupStatus).length > 0) {
                        $.each(json.GroupStatus, function (i, item) {
                            if (item['Estado'] == 1) {
                                $('#ListSummary #' + item['CodGruposVentas']).prop('checked', true);
                            } /*else {
                             $('#ListSummary #' + item['CodGruposVentas']).prop('checked', false);
                             }*/
                        });
                    }
                }
                $('#_alertaCargando').modal('hide');
            }
        });
    }
});

$('body').on('change', '.check', function () {
    $('#_alertConfirmationGeneric .text-modal-body').html("Esta seguro que desea cambiar este estado?");
    $('#_alertConfirmationGeneric .btnConfirm').attr('id', 'btnConfirmExcecuteChangeStatus');
    $('#_alertConfirmationGeneric .btnCancel').attr('id', 'btnCancelExcecuteChangeStatus');
    var id = $(this).attr('id');
    var select = $(this).is(':checked') ? 1 : 0;
    $('#_alertConfirmationGeneric').data('id', id + '-' + select).modal('show');
});

$('body').on('click', '#btnConfirmExcecuteChangeStatus', function (e) {
    e.preventDefault();
    var group = $('#_alertConfirmationGeneric').data('id');
    var values = group.split('-');
    //var select = $('#ListSummary #' +group).prop('checked', true) ? 1 : 0;
    var Agenciesselect = $('#Agencia').val();
    $('#_alertaCargando .text-modal-body').html("Cambiando estado..");
    $('#_alertaCargando').modal('show');
    $.ajax({
        url: 'index.php?r=AdminQR/AjaxChangeStatusGroup',
        type: 'post',
        data: {
            SaleGroup: values[0],
            Agency: Agenciesselect,
            Select: values[1]
        },
        success: function (response) {
            $('#_alertaCargando').modal('hide');
            if (response == "OK") {
                $('#_alertaSucessGeneric .text-modal-body').html("Estado cambiado correctamente..!");
                $('#_alertaSucessGeneric').modal('show');
            } else {
                $('#_alerta .text-modal-body').html("Hubo un error cambiando el estado!");
                $('#_alerta').modal('show');
            }
        }
    });
});

$('body').on('click', '#btnCancelExcecuteChangeStatus', function (e) {
    e.preventDefault();
    var group = $('#_alertConfirmationGeneric').data('id');
    var values = group.split('-');
    if (values[1] == 1) {
        $('#ListSummary #' + values[0]).prop('checked', false);
    } else {
     $('#ListSummary #' + values[0]).prop('checked', true);
     }
});