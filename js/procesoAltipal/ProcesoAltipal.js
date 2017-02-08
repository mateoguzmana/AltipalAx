$(document).ready(function () {
    LoadRunningProcess();    
    
 });
var SelectAgencyName = "";
var selectAgency = "";
var jsonAgency = [];
var json = [];
var ExcecutionProcess = [];
var Cont = 0;

$('body').on('change', '#Methods', function () {
    json = [];
    var MethodId = $('#Methods').val();
    $('.DynamicSelectParam').html('');
    if (MethodId != "") {
        $('#_alertaCargando .text-modal-body').html("Consultando agencias..");
        $('#_alertaCargando').modal('show');
        $.ajax({
            url: 'index.php?r=ProcesoAltipal/AjaxQuerySelectAgency',
            type: 'post',
            data: {
                Method: MethodId,
            },
            success: function (response) {
                if (response != "") {
                    if (Object.keys(jsonAgency).length == 0) {
                        jsonAgency = JSON.parse(response);
                    }
                    if ($('.DynamicSelectAgency div').children().length == 0) {
                        if (selectAgency == "") {
                            SelectAgencyName = jsonAgency.SelectName.replace(new RegExp(" ", 'g'), "");
                            selectAgency = '<strong><label class="col-sm-4 control-label" style="font-size:16px">Seleccione la(s) ' + jsonAgency.SelectName + '(s) que quiere ejecutar: </label>' +
                                    '</strong><div class="col-sm-8"><select class="selectpicker" id="' + SelectAgencyName + '" multiple data-live-search="true" data-actions-box="true" data-width="30%" data-selected-text-format="count">';
                            var option = "";
                            $.each(jsonAgency.Select, function (i, item) {
                                option += '<option value="' + item.CodAgencia + '">' + item.CodAgencia + ' - ' + item.Nombre + '</option>';
                            });
                            selectAgency += option + '</select>';
                        }
                        $('.DynamicSelectAgency').html(selectAgency);
                        $('#' + SelectAgencyName).selectpicker();

                    } else {
                        $('#Agencia').selectpicker('deselectAll');
                    }
                } else {
                    jsonAgency = [];
                    $('.DynamicSelectAgency').empty();
                }
                $('#_alertaCargando').modal('hide');
            }
        });
    }
});

$('body').on('change', '#Agencia', function () {
    var MethodsId = "";
    var Methodsselect = $('#Methods').val();
    if ((Methodsselect != null) && (Methodsselect != "")) {
        $('.DynamicSelectParam').html('');
        MethodsId += "'" + Methodsselect + "',";
        /*$.each(Methodsselect, function (index, value) {
         MethodsId += "'" + value + "',";
         });*/
    }
    var Agencies = "";
    var Agenciesselect = $('#Agencia').val();
    if ((Agenciesselect != null) && (Agenciesselect != "")) {
        $.each(Agenciesselect, function (index, value) {
            Agencies += "'" + value + "',";
        });
    }
    if ((Agencies != "") && (MethodsId != "")) {
        Agencies = Agencies.slice(0, -1);
        MethodsId = MethodsId.slice(0, -1);
        $('#_alertaCargando .text-modal-body').html("Consultando parametros..");
        $('#_alertaCargando').modal('show');
        $.ajax({
            url: 'index.php?r=ProcesoAltipal/AjaxQuerySelectOptions',
            type: 'post',
            data: {
                Methods: MethodsId,
                Agencies: Agencies
            },
            success: function (response) {
                json = [];
                if (response != "") {
                    //console.log(response);
                    json = JSON.parse(response);
                    var nameid = json.SelectName.replace(new RegExp(" ", 'g'), "");
                    var select = '<strong><label class="col-sm-4 control-label" style="font-size:16px">Seleccione el/la(s)/lo(s) ' + json.SelectName + '(s) que quiere actualizar: </label>' +
                            '</strong><div class="col-sm-8"><select class="selectpicker" id="' + nameid + '" multiple data-live-search="true" data-actions-box="true" data-width="30%" data-selected-text-format="count">';
                    var option = "";
                    $.each(json.Select, function (i, item) {
                        option += '<option value="' + item.Param + '">' + item.Param + ' - ' + item.Name + ' - ' + item.CodAgencia + '</option>';
                    });
                    select += option + '</select>';
                    $('.DynamicSelectParam').html(select);
                    $('#' + nameid).selectpicker();
                }
                $('#_alertaCargando').modal('hide');
            }
        });
    }
});

$('body').on('change', '#check', function () {
    if ($('#check').is(':checked'))
    {
        if ($("#Methods").val() != "") {
            $('#_alertConfirmationGeneric .text-modal-body').html("Esta seguro que desea ejecutar este proceso completo?");
            $('#_alertConfirmationGeneric .btnConfirm').attr('id', 'btnConfirmExcecuteProcessComplete');
            $('#_alertConfirmationGeneric').modal('show');
        } else {
            $('#_alerta .text-modal-body').html("No ha seleccionado ningun proceso!");
            $('#_alerta').modal('show');
        }
        $('#check').prop('checked', false);
    }
});

$('body').on('click', '#btnConfirmExcecuteProcessComplete', function (e) {
    e.preventDefault();
    $('#_alertaCargando .text-modal-body').html("Ejecutando servicio..");
    $('#_alertaCargando').modal('show');
    var Method = $("#Methods").val();
    $.ajax({
        url: 'index.php?r=ProcesoAltipal/AjaxChangeStatusProcessToRun',
        type: 'post',
        data: {
            Process: Method
        },
        success: function (response) {
            console.log(response);
            $('#_alertaCargando').modal('hide');
            if (response == "OK") {
                $('#_alertaSucessGeneric .text-modal-body').html("Servicio ejecutando..!");
                $('#_alertaSucessGeneric').modal('show');
            } else if (response == "NO") {
                $('#_alerta .text-modal-body').html("El proceso se esta ejecutando en este momento!");
                $('#_alerta').modal('show');
            } else {
                $('#_alerta .text-modal-body').html("Hubo un error ejecutando el servicio!");
                $('#_alerta').modal('show');
            }
        }
    });

});

$('body').on('click', '#btnExecuteProcess', function (e) {
    e.preventDefault();
    if (Object.keys(ExcecutionProcess).length > 0) {
        $('#_alertConfirmationGeneric .text-modal-body').html("Esta seguro que desea agregar este/estos servicio(s) al proceso?");
        $('#_alertConfirmationGeneric .btnConfirm').attr('id', 'btnConfirmExcecuteProcess');
        $('#_alertConfirmationGeneric').modal('show');
    } else {
        $('#_alerta .text-modal-body').html("No ha seleccionado ningun servicio a ejecutar!");
        $('#_alerta').modal('show');
    }
});

$('body').on('click', '#btnWatchProcess', function (e) {
    e.preventDefault();
    $('#_alertaCargando .text-modal-body').html("Consultando servicio en ejecucion..!");
    $('#_alertaCargando').modal('show');
    $.ajax({
        url: 'index.php?r=ProcesoAltipal/AjaxQueryProcessExecution',
        type: 'post',
        data: {
        },
        success: function (response) {
            $('#_alertaCargando').modal('hide');
            //alert(JSON.stringify(response));
            var ProcessJson = JSON.parse(response);
            if (ProcessJson['Cont'] == 0) {
                if (ProcessJson['Status'] == 0) {
                    $('#_alerta .text-modal-body').html("El servicio que se esta ejecutando es: <b>" + ProcessJson['Name'] + "</b>.<br> Tiempo transcurrido: <b>" + ProcessJson['Time'] + "</b>");
                    $('#_alerta').modal('show');
                }
                else if (ProcessJson['Status'] == null) {
                    $('#_alertaSucessGeneric .text-modal-body').html("No se esta ejecutando ningun servicio en este momento!");
                    $('#_alertaSucessGeneric').modal('show');
                }
            }
            else {
                $('#_alerta .text-modal-body').html("El ultimo proceso no termino correctamente!!; Por favor comuniquese con Activity!!!");
                //$('#_alerta .text-modal-body').html("El ultimo proceso no termino correctamente!!; El servicio que se ejecuto fue: <b>" + ProcessJson['Name'] + "</b> Desde la fecha: <b>" + ProcessJson['Date'] + "</b> y Hora: <b>" + ProcessJson['Time'] + "</b>");
                $('#_alerta').modal('show');
            }
        }
    });
});

$('body').on('click', '#btnConfirmExcecuteProcess', function () {
    $('#_alertConfirmationGeneric').modal('hide');
    $('#_alertaCargando .text-modal-body').html("Guardando servicio(s) a ejecutar..");
    $('#_alertaCargando').modal('show');
    $.ajax({
        url: 'index.php?r=ProcesoAltipal/AjaxInsertControlUpdateProcess',
        type: 'post',
        data: {
            JsonArr: JSON.stringify(ExcecutionProcess)
        },
        success: function (response) {
            $('#_alertaCargando').modal('hide');
            if (response == "OK") {
                $("#ListSummary").html('');
                ExcecutionProcess = [];
                $('#_alertaSucessGeneric .text-modal-body').html("Servicio(s) guardado(s) exitosamente!");
                $('#_alertaSucessGeneric').modal('show');
            } else if (response == "NO") {
                $('#_alerta .text-modal-body').html("El proceso se esta ejecutando en este momento!");
                $('#_alerta').modal('show');
            } else {
                $('#_alerta .text-modal-body').html("Hubo un error guardando los servicios!");
                $('#_alerta').modal('show');
            }
        }
    });
});

$('body').on('click', '#btnExecuteCompleteProcess', function () {
    $('#_alertConfirmationGeneric .text-modal-body').html("Esta seguro que desea ejecutar todos los servicios del proceso?");
    $('#_alertConfirmationGeneric .btnConfirm').attr('id', 'btnConfirmExcecuteAllProcessComplete');
    $('#_alertConfirmationGeneric').modal('show');
});

$('body').on('click', '#btnConfirmExcecuteAllProcessComplete', function () {
    $('#_alertConfirmationGeneric').modal('hide');
    $('#_alertaCargando .text-modal-body').html("Ejecutando todos los servicios..");
    $('#_alertaCargando').modal('show');
    $.ajax({
        url: 'index.php?r=ProcesoAltipal/AjaxExcecuteAllProcessComplete',
        type: 'post',
        data: {
        },
        success: function (response) {
            $('#_alertaCargando').modal('hide');
            if (response == "OK") {
                $('#_alertaSucessGeneric .text-modal-body').html("Servicioa ejecutando exitosamente!");
                $('#_alertaSucessGeneric').modal('show');
            } else if (response == "NO") {
                $('#_alerta .text-modal-body').html("El proceso se esta ejecutando en este momento!");
                $('#_alerta').modal('show');
            } else {
                $('#_alerta .text-modal-body').html("Hubo un error guardando los servicios!");
                $('#_alerta').modal('show');
            }
        }
    });
});

$('body').on('click', '.DeleteElement', function (e) {
    e.preventDefault();
    $('#_alertConfirmationGeneric .text-modal-body').html("Esta seguro que desea eliminar este servicio de la lista?");
    $('#_alertConfirmationGeneric .btnConfirm').attr('id', 'btnConfirmDelete');
    var id = $(this).attr('id');
    $('#_alertConfirmationGeneric').data('id', id).modal('show');
})

$('body').on('click', '#btnConfirmDelete', function () {
    var valdel = $('#_alertConfirmationGeneric').data('id');
    $('#_alertConfirmationGeneric').modal('hide');
    $('#_alertaCargando .text-modal-body').html("Eliminando servicio..");
    $('#_alertaCargando').modal('show');
    $('#' + valdel).closest('tr').remove();
    var flag = false;
    $.each(ExcecutionProcess, function (index, value) {
        if (value.Id == valdel) {
            ExcecutionProcess.splice(index, 1);
            $('#_alertaCargando').modal('hide');
            $('#_alertaSucessGeneric .text-modal-body').html("Servicio eliminado exitosamente!");
            $('#_alertaSucessGeneric').modal('show');
            flag = true;
            return;
        }
    });
    if (!flag) {
        $('#_alertaCargando').modal('hide');
        $('#_alerta .text-modal-body').html("Ocurrio un problema eliminando el servicio, porfavor recargue la pagina!");
        $('#_alerta').modal('show');
    }
});


$('#btnAddControllerToList').click(function () {
    if ($("#Methods").val() != "") {
        var Agencies = "";
        var Agenciesselect = "";
        if (Object.keys(jsonAgency).length > 0) {
            Agenciesselect = $('#Agencia').val();
            if ((Agenciesselect != null) && (Agenciesselect != "")) {
                $.each(Agenciesselect, function (index, value) {
                    Agencies += value + ", ";
                });
                Agencies = Agencies.slice(0, -2);
            } else {
                $('#_alerta .text-modal-body').html("Debe seleccionar al menos una agencia para agregar un nuevo servicio a la lista!");
                $('#_alerta').modal('show');
                return;
            }
        }
        var Parameters = "";
        var Params = "";
        //var nameid = "";
        if (Object.keys(json).length > 0) {
            var nameid = json.SelectName.replace(new RegExp(" ", 'g'), "");
            if (($('#' + nameid).val() != null) && (($('#' + nameid).val() != ""))) {
                Parameters = $('#' + nameid).val();
                $.each(Parameters, function (index, value) {
                    Params += value + ", ";
                });
                Params = Params.slice(0, -2);
            } else {
                $('#_alerta .text-modal-body').html("Debe seleccionar al menos un parametro para agregar un nuevo servicio a la lista!");
                $('#_alerta').modal('show');
                return false;
            }
        }
        $('#_alertaCargando .text-modal-body').html("Agregando servicio..");
        $('#_alertaCargando').modal('show');
        var object = {
            Controller: $("#Methods").val(),
            Agencies: Agenciesselect,
            Params: Parameters,
            Id: Cont
        };
        ExcecutionProcess.push(object);
        $("#ListSummary").append('<tr><td><img src="/altipalAx/images/layers.png" alt="Proceso" width="25" height="25"></td><td>' + $("#Methods option:selected").html() + '</td><td>' + Agencies + '</td><td>' + Params + '</td><td><button type="button" id="' + Cont + '" class="btn btn-default DeleteElement"><span class="glyphicon glyphicon-remove"></span></button></td></tr>');
        $('#Methods').selectpicker('deselectAll');
        $('#Agencia').selectpicker('deselectAll');
        $('#_alertaCargando').modal('hide');
        Cont++;
    }
});

function LoadRunningProcess(){    
    /*$('#_alertaCargando .text-modal-body').html("Consultando servicio en ejecucion..!");
    $('#_alertaCargando').modal('show');*/
    $.ajax({
        url: 'index.php?r=ProcesoAltipal/AjaxQueryProcessExecution',
        type: 'post',
        data: {
        },
        success: function (response) {
            //$('#_alertaCargando').modal('hide');
            //alert(JSON.stringify(response));
            var ProcessJson = JSON.parse(response);
            if (ProcessJson['Cont'] == 0) {
                if (ProcessJson['Status'] == 0) {
                    window.open("index.php?r=ProcesoAltipal/Menu", '_self');
                    /*$('#_alerta .text-modal-body').html("El servicio que se esta ejecutando es: <b>" + ProcessJson['Name'] + "</b> Desde la fecha: <b>" + ProcessJson['Date'] + "</b> y Hora: <b>" + ProcessJson['Time'] + "</b>");
                    $('#_alerta').modal('show');*/
                }
                else if (ProcessJson['Status'] == null) {
                    /*$('#_alertaSucessGeneric .text-modal-body').html("No se esta ejecutando ningun servicio en este momento!");
                    $('#_alertaSucessGeneric').modal('show');*/
                }
            }
            else {
                $('#_alerta .text-modal-body').html("El ultimo proceso no termino correctamente!!; Por favor comuniquese con Activity!!!");
                //$('#_alerta .text-modal-body').html("El ultimo proceso no termino correctamente!!; El servicio que se ejecuto fue: <b>" + ProcessJson['Name'] + "</b> Desde la fecha: <b>" + ProcessJson['Date'] + "</b> y Hora: <b>" + ProcessJson['Time'] + "</b>");
                $('#_alerta').modal('show');
            }
        }
    });
    setTimeout("LoadRunningProcess()",45000);
}