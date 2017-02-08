/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('#btnCargarGrupoVentas').click(function () {
    $.ajax({
        data: {
        },
        url: 'index.php?r=AdministarUsuarios/AjaxGetAgenciasGruposUsuario',
        type: 'post',
        success: function (response) {
            $('#mdlAgenciaGrupoVentas .modal-body').html(response);
            $('#mdlAgenciaGrupoVentas').modal('show');
            $('.selecciona').click(function () {
                var id = $(this).attr("id");
                $('.ckboxAgencia' + id).not(this).prop('checked', this.checked);
                if ($(this).is(':checked'))
                {
                    $(".ckboxAgencia" + id).attr('checked', true);
                } else {
                    $(".ckboxAgencia" + id).attr('checked', false);
                }
            });
        }
    });
});

$('#btnAsignarAgenciaGrupoVentas').click(function () {
    $.ajax({
        url: 'index.php?r=AdministarUsuarios/AjaxResetAgenciaGrupoUsuario',
        type: 'post',
        success: function (response) {
            $('#mdlAgenciaGrupoVentas').modal('hide');
            $('.chekcGuardar').each(function () {
                if ($(this).is(':checked')) {
                    var agencia = $(this).attr('data-agencia');
                    var grupoVentas = $(this).attr('data-grupo-ventas');
                    $.ajax({
                        data: {
                            'agencia': agencia,
                            'grupoVentas': grupoVentas
                        },
                        url: 'index.php?r=AdministarUsuarios/AjaxSetAgenciaGrupoUsuario',
                        type: 'post',
                        success: function (response) {
                            $('#mdlAgenciaGrupoVentas').modal('hide');
                        }
                    });
                }
            });
        }
    });
});

$('#btnAsignarAgenciaGrupoVentasModal').click(function () {
    var totalagencias = 0;
    var checkNoAgencia = 0;
    var arrayAgency = [];
    $('.chekcGuardar').each(function () {
        totalagencias++;
        if ($(this).is(":checked")) {
            checkNoAgencia++;
        }
    });
    if (checkNoAgencia == 0) {
        $('#_alertAsignarAgenciaUpdate .text-modal-body').html('Está seguro de no asignar ninguna agencia para este usuario');
        $('#_alertAsignarAgenciaUpdate').modal('show');
    }
    $.ajax({
        url: 'index.php?r=AdministarUsuarios/AjaxResetAgenciaGrupoUsuario',
        type: 'post',
        success: function (response) {
            $('.chekcGuardar').each(function () {
                if ($(this).is(':checked')) {
                    var agenciaCheck = $(this).attr('data-agencia');
                    var grupoVentasCheck = $(this).attr('data-grupo-ventas');
                    //debugger;
                    arrayAgency.push({agencia: agenciaCheck, grupoVentas: grupoVentasCheck});
                }
            });
            $.ajax({
                data: {
                    'arrayAgency': arrayAgency
                },
                url: 'index.php?r=AdministarUsuarios/AjaxSetAgenciaGrupoUsuario',
                type: 'post',
                success: function (response) {
                    console.log(response);
                    $('#mdlAgenciaGrupoVentas').modal('hide');
                }
            });
        }
    });
});

$('#bntcerrarmodal').click(function () {
    $('#mdlAgenciaGrupoVentas').modal('hide');

});

$('#btnAsignarCopceptosNotasCreditos').click(function () {
    $.ajax({
        url: 'index.php?r=AdministarUsuarios/AjaxResetConceptosNotasCredito',
        type: 'post',
        success: function (response) {
            $('#mdlConceptosNotasCredito').modal('hide');
            $('.chekcConceptosNotasCredito').each(function () {
                if ($(this).is(':checked')) {
                    var conceptosnotascreditos = $(this).attr('data-conceptosnotascredito');
                    $.ajax({
                        data: {
                            'conceptosnotascreditos': conceptosnotascreditos
                        },
                        url: 'index.php?r=AdministarUsuarios/AjaxSetConceptosNotasCreditos',
                        type: 'post',
                        success: function (response) {
                            $('#mdlConceptosNotasCredito').modal('hide');
                        }
                    });
                }
            });
        }
    });
});

$('#btnAsignarPerfilAprobacionDocumentos').click(function () {
    $.ajax({
        url: 'index.php?r=AdministarUsuarios/AjaxResetPerfilAprobacionDoc',
        type: 'post',
        success: function (response) {
            var idtipouser = $("#Administrador_IdTipoUsuario").val();
            var proveedores = $("#proveedores").val();
            var perfilaprobaciondoc = $("#perfilaprobaciondoc").val();
            var envio = $("#envio").val();
            if (idtipouser == 2) {
                if (proveedores == 0) {
                    $("#_alerta .text-modal-body").html('Por favor seleccione un provedor');
                    $("#_alerta").modal('show');
                    return false;
                } else if (perfilaprobaciondoc == 0) {
                    $("#_alerta .text-modal-body").html('Por favor seleccione un perfil de a probación');
                    $("#_alerta").modal('show');
                    return false;
                }
            }
            if (perfilaprobaciondoc == 0) {
                $("#_alerta .text-modal-body").html('Por favor seleccione un perfil de a probación');
                $("#_alerta").modal('show');
                return false;
            }
            $.ajax({
                data: {
                    'proveedores': proveedores,
                    'perfilaprobaciondoc': perfilaprobaciondoc,
                    'envio': envio
                },
                url: 'index.php?r=AdministarUsuarios/AjaxSetPerfilAprobacionDoc',
                type: 'post',
                success: function (response) {
                    $('#mdlInformacionPerfilAprobacion').modal('hide');
                }
            });
        }
    });
});

$('.saliradminUser').click(function () {
    $("#_alertConfirmarAdminUsuario .text-modal-body").html('Esta seguro que desea salir del modulo administrador usuarios ?');
    $("#_alertConfirmarAdminUsuario").modal('show');
});

$('.salirCreateUser').click(function () {
    $("#_alertConfirmarCreateAdminUsuario .text-modal-body").html('Esta seguro que desea salir del modulo crear usuarios ?');
    $("#_alertConfirmarCreateAdminUsuario").modal('show');
});

$('.salirEditUser').click(function () {
    $("#_alertConfirmarEditAdminUsuario .text-modal-body").html('Esta seguro que desea salir del modulo editar usuarios ?');
    $("#_alertConfirmarEditAdminUsuario").modal('show');
});

function ValidarConceptosByCampos() {
    var idperfil = $("#Administrador_IdPerfil").val();
    document.getElementById("ErrorPerfil").innerHTML = "";
    $.ajax({
        data: {
            "idperfil": idperfil
        },
        url: 'index.php?r=administarUsuarios/AjaxBuscarConfiguracionPrivilegio',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-departamento").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {
            if (response > 0) {
                document.getElementById("btnCargarConceptosNotasCredito").disabled = false;
                document.getElementById("btnCargarPerfilAprovacionDoc").disabled = false;
            } else {
                document.getElementById("btnCargarConceptosNotasCredito").disabled = true;
                document.getElementById("btnCargarPerfilAprovacionDoc").disabled = true;
            }
        }
    });
}

$('#btnCargarPerfilAprovacionDoc').click(function () {
    $.ajax({
        data: {
        },
        url: 'index.php?r=AdministarUsuarios/AjaxGetPerfilAprobacionDoc',
        type: 'post',
        success: function (response) {
            $('#mdlInformacionPerfilAprobacion .modal-body').html(response);
            $('#mdlInformacionPerfilAprobacion').modal('show');
            var idtipouser = $("#Administrador_IdTipoUsuario").val();
            if (idtipouser == 2) {
                document.getElementById("proveedores").disabled = false;
            } else {
                document.getElementById("proveedores").disabled = true;
            }
        }
    });
});

$('#btnCargarConceptosNotasCredito').click(function () {
    var TipoUsuario = $("#Administrador_IdTipoUsuario").val();
    $.ajax({
        data: {
            'TipoUsuario': TipoUsuario
        },
        url: 'index.php?r=AdministarUsuarios/AjaxGetConceptosNotasCredito',
        type: 'post',
        success: function (response) {
            $('#mdlConceptosNotasCredito .modal-body').html(response);
            $('#mdlConceptosNotasCredito').modal('show');
        }
    });
});

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

function validarEmail() {
    var email = document.getElementById("Administrador_Email").value.indexOf("@");
    var ErrorEmail = document.getElementById('ErrorEmail');
    var email2 = $("#Administrador_Email").val();
    if (email2 == "") {
        if (email2 == "") {
            ErrorEmail.innerHTML = "<font color='red'>Email no puede ser nulo.</font>";
            return false;
        }
    } else {
        if (email == -1) {
            ErrorEmail.innerHTML = "<font color='red'>Dirección de correo electrónico no válida</font>";
            return false;
        } else {
            document.getElementById("ErrorEmail").innerHTML = "";
        }
    }
}

function FilterInput(event) {
    var chCode = ('charCode' in event) ? event.charCode : event.keyCode;
    if (chCode == 8 || chCode == 0)
    {
        return chCode;
    } else {
        if (chCode > 47 & chCode < 58)
        {
            return chCode;
        } else {
            return false;
        }
    }
}

function BarraEspce(event) {
    var chCode = ('charCode' in event) ? event.charCode : event.keyCode;
    if (chCode == 32)
    {
        return false;
    }
}

$("#administrador-form").submit(function () {
    var totalagencias = 0;
    var checkNoAgencia = 0;
    var ErrorPerfil = document.getElementById('ErrorPerfil');
    var ErrorTipoUser = document.getElementById('ErrorTipoUser');
    var ErrorEmail = document.getElementById('ErrorEmail');
    var idperfil = $("#Administrador_IdPerfil").val();
    var idtipousuario = $("#Administrador_IdTipoUsuario").val();
    var agenciasasignadas = $("#totalagenciasasignadas").val();
    var perfilesasignacdos = $("#totalperfilesasignacos").val();
    var email = $("#Administrador_Email").val();
    var conceptosnotas = $("#totalconceptos").val();
    var perfilapro = $('#perfilaprobaciondoc').val();
    $('.chekcGuardar').each(function () {
        totalagencias++;
        if ($(this).is(":checked")) {
            checkNoAgencia++;
        }
    });
    var totalper = 0;
    var selectno = 0;
    $("#perfilaprobaciondoc option:selected").each(function () {
        totalper++;
        if ($(this).text()) {
            selectno++;
        }
    });
    var conceptosasignados = 0;
    var checkConceptos = 0;
    $('.chekcConceptosNotasCredito').each(function () {
        conceptosasignados++;
        if ($(this).is(":checked")) {
            checkConceptos++;
        }
    });
    if (idperfil == 0 && idtipousuario == 0 && email == "") {
        ErrorPerfil.innerHTML = "<font color='red'>Por favor seleccione un perfil</font>";
        ErrorTipoUser.innerHTML = "<font color='red'>Por favor seleccione un tipo usuario</font>";
        ErrorEmail.innerHTML = "<font color='red'>Email no puede ser nulo.</font>";
        return false;
    }
    if (idperfil == 0) {
        ErrorPerfil.innerHTML = "<font color='red'>Por favor seleccione un perfil</font>";
        return false;
    }
    if (idtipousuario == 0) {
        ErrorTipoUser.innerHTML = "<font color='red'>Por favor seleccione un tipo usuario</font>";
        return false;
    }
    if (email == "") {
        ErrorEmail.innerHTML = "<font color='red'>Email no puede ser nulo.</font>";
        return false;
    }
    if (conceptosnotas == 0) {
        if (checkConceptos == 0) {
            var bntnotas = document.getElementById("btnCargarConceptosNotasCredito").disabled;
            var btnperfil = document.getElementById("btnCargarPerfilAprovacionDoc").disabled;
            if (!bntnotas && !btnperfil) {
                $('#_alerta .text-modal-body').html('Por favor seleccione al menos un concepto nota credito');
                $('#_alerta').modal('show');
                return false;
            }
        }
    }
    if (agenciasasignadas == 0) {
        if (checkNoAgencia == 0) {
            $('#_alerta .text-modal-body').html('Por favor seleccione al menos una agencia');
            $('#_alerta').modal('show');
            return false;
        }
    }
    if (perfilesasignacdos == 0) {
        if (selectno == 0) {
            var bntnotas = document.getElementById("btnCargarConceptosNotasCredito").disabled;
            var btnperfil = document.getElementById("btnCargarPerfilAprovacionDoc").disabled;
            if (!bntnotas && !btnperfil) {
                $('#_alerta .text-modal-body').html('Por favor seleccione la información en perfil aprobación de documentos');
                $('#_alerta').modal('show');
                return false;
            }
        }
    }
});

function tipouser() {
    document.getElementById("ErrorTipoUser").innerHTML = "";
}