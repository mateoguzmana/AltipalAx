
$(function() {

    if (typeof history.pushState === "function") {
        history.pushState("jibberish", null, null);
        window.onpopstate = function() {
            history.pushState('newjibberish', null, null);
            // Handle the back (or forward) buttons here
            // Will NOT handle refresh, use onbeforeunload for this.
        };
    }
    else {
        var ignoreHashChange = true;
        window.onhashchange = function() {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
            }
            else {
                ignoreHashChange = false;
            }
        };
    }
    
    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {
           
          $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');  
          $('#_alertaRecargarPagina').modal('show');
          return false;
        }
    });
    

});


$('body').on('click','.ok',function(){
    
   location.reload(); 
});


 
   jQuery('#fechaini').datepicker({
    dateFormat: 'yy-mm-dd',
    beforeShow: function(i) {
        if ($(i).attr('readonly')) {
            return false;
        }
     }
    }); 
    
    jQuery('#fechafin').datepicker({
    dateFormat: 'yy-mm-dd',
    beforeShow: function(i) {
        if ($(i).attr('readonly')) {
            return false;
        }
     }
    }); 
    


jQuery('#datepicker').datepicker({
    dateFormat: 'yy-mm-dd',
    maxDate: 'today',
    beforeShow: function(i) {
        if ($(i).attr('readonly')) {
            return false;
        }
    }
});

jQuery('#txtFechaCheque').datepicker({
    dateFormat: 'yy-mm-dd',
    showOn: "button",
    buttonImage: "images/calendar.png",
    buttonImageOnly: true,
    buttonText: "Select date",
});
 


$("#btnEnviarFormConsignacionVendedor").click(function() {

    var codzona = $("#codzona").val();
    var codasesor = $("#codasesor").val();
    var numconsignacion = $("#numconsignacion").val();
    var banco = $("#txtBanco").val();
    var cuenta = $("#txtCuenta").val();
    var fecha = $("#datepicker").val();
    var valorefctivo = $("#valorefectivo").val();
    var valorcheque = $("#valorecheque").val();
    valche = valorcheque.replace(/,/g, '');
    valefec = valorefctivo.replace(/,/g, '');


    var oficina = $("#oficina").val();
    var ciudad = $("#ciudad").val();
    var IdentificadorBanco = $("#codbanco").val();
    var codagencia = $("#codagencia").val();


    $.ajax({
        data: {
            'codzona': codzona,
            'codasesor': codasesor,
            'numconsignacion': numconsignacion,
            'banco': banco,
            'cuenta': cuenta,
            'valorefctivo': valefec,
            'valorcheque': valche,
            'oficina': oficina,
            'ciudad': ciudad,
            'fecha': fecha,
            'IdentificadorBanco': IdentificadorBanco,
            'codagencia': codagencia

        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxCreate',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $('#_alertConsignacionVendedor').modal('hide');
            $('#mensaje').modal('show');



        }
    });


});


function format(input) {


    var num = input.value.replace(/\,/g, '');
    if (!isNaN(num)) {
        num = num.toString().split('').reverse().join('').replace(/(?=\d*\,?)(\d{3})/g, '$1,');
        num = num.split('').reverse().join('').replace(/^[\,]/, '');
        input.value = num;
    }

}



function guardarConsignacion() {



    var numconsignacion = $("#numconsignacion").val();
    var banco = $("#txtBanco").val();
    var cuenta = $("#txtCuenta").val();
    var fecha = $("#datepicker").val();
    var valorefctivo = $("#valorefectivo").val();
    var valorcheque = $("#valorecheque").val();

    var oficina = $("#oficina").val();
    var ciudad = $("#ciudad").val();
    var IdentificadorBanco = $("#codbanco").val();

    var Errorng = document.getElementById('Errorng');
    var ErrorBn = document.getElementById('ErrorBn');
    var ErrorCod = document.getElementById('ErrorCod');
    //var ErrorNB = document.getElementById('ErrorNB');
    var ErrorCB = document.getElementById('ErrorCB');
    var ErrorFCH = document.getElementById('ErrorFCH');
    var ErrorEF = document.getElementById('ErrorEF');
    var ErrorCH = document.getElementById('ErrorCH');
    var ErrorOFI = document.getElementById('ErrorOFI');
    var ErrorCIU = document.getElementById('ErrorCIU');


    if (numconsignacion == "" && banco == "" && IdentificadorBanco == "" && cuenta == "" && cuenta == "" && oficina == "" && ciudad == "") {

        Errorng.innerHTML = "<font color='red'>Por favor digite el numero de consignacion</font>";
        ErrorBn.innerHTML = "<font color='red'>Por favor seleccione un banco</font>";
        ErrorCod.innerHTML = "<font color='red'>Por favor digite el codigo del banco</font>";
        ErrorCB.innerHTML = "<font color='red'>Por favor seleccione una cuenta bancaria</font>";
        ErrorOFI.innerHTML = "<font color='red'>Por favor ingrese el nombre de la oficina</font>";
        ErrorCIU.innerHTML = "<font color='red'>Por favor ingrese el nombre de la ciudad</font>"

    }

    if (numconsignacion == "") {
        Errorng.innerHTML = "<font color='red'>Por favor digite el numero de consignacion</font>";
        return;
    }

    else if (banco == "") {

        ErrorBn.innerHTML = "<font color='red'>Por favor seleccione un banco</font>";
        document.getElementById("Errorng").innerHTML = "";
        return;



    }
    else if (IdentificadorBanco == "") {


        ErrorCod.innerHTML = "<font color='red'>Por favor digite el codigo del banco</font>";
        document.getElementById("ErrorBn").innerHTML = "";
        return;

    }

    else if (cuenta == "") {

        ErrorCB.innerHTML = "<font color='red'>Por favor seleccione una cuenta bancaria</font>";
        document.getElementById("ErrorCod").innerHTML = "";
        return;

    }

    else if (fecha == "") {


        ErrorFCH.innerHTML = "<font color='red'>Por favor seleccione una fecha</font>";
        document.getElementById("ErrorCB").innerHTML = "";
        return;

    }


    else if (valorefctivo == "") {


        ErrorEF.innerHTML = "<font color='red'>Por favor digite el valor efectivo</font>";
        document.getElementById("ErrorCB").innerHTML = "";
        document.getElementById("ErrorFCH").innerHTML = "";
        return;


    }
    else if (valorcheque == "") {


        ErrorCH.innerHTML = "<font color='red'>Por favor digite el valor cheque</font>";
        document.getElementById("ErrorEF").innerHTML = "";
        return;
    }
    else if (oficina == "" && ciudad == "") {

        ErrorOFI.innerHTML = "<font color='red'>Por favor ingrese el nombre de la oficina</font>";
        document.getElementById("ErrorCH").innerHTML = "";
        ErrorCIU.innerHTML = "<font color='red'>Por favor ingrese el nombre de la ciudad</font>"
        return;

    }


    else if (oficina == "") {

        ErrorOFI.innerHTML = "<font color='red'>Por favor ingrese el nombre de la oficina</font>";
        document.getElementById("ErrorCH").innerHTML = "";
        return;

    }

    else if (ciudad == "") {


        ErrorCIU.innerHTML = "<font color='red'>Por favor ingrese el nombre de la ciudad</font>";
        document.getElementById("ErrorOFI").innerHTML = "";
        return;

    }

    if (valorefctivo == 0 && valorcheque == 0) {

        $('#_alerta .text-modal-body').html('Se debe ingresar un valor en efectivo o un valor en cheques, ambos no pueden registrarse en 0 ');
        $('#_alerta').modal('show');
        return;
    }

    $('#_alertConsignacionVendedor #confirm').html('Esta seguro de enviar la información');
    $('#_alertConsignacionVendedor').modal('show');
    return;


}


function Consignaciones() {

    var codzona = $("#codzona").val();

    $.ajax({
        data: {
            'codzona': codzona,
        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxConsignaciones',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            if (response === "") {


                $('#_alerta .text-modal-body').html('No hay consignaciones registradas para esta zona de ventas');
                $('#_alerta').modal('show');
                return;

            } else {
                $('#myModal  .modal-body').html(response);
                $('#myModal').modal('show');

            }
        }
    });

}


function ConsignacionesEliminar() {

    var codzona = $("#codzona").val();

    $.ajax({
        data: {
            'codzona': codzona,
        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxConsignaciones',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $('#myModal  .modal-body').html(response);
            $('#myModal').modal('show');
            $('#dangerError').modal('show');

            $('.oko').click(function() {

                if (response === "") {

                    $('#danger').modal('hide');
                    $('#_alerta .text-modal-body').html('No hay consignaciones registradas para esta zona de ventas');
                    $('#_alerta').modal('show');
                    $('#myModal').modal('hide');

                    return;

                }

            });




        }
    });

}



function eliminarconsignacion(id) {

    var idconsignacion = id;

    if (confirm("Esta seguro de eliminar la consignación ?")) {

        $.ajax({
            data: {
                'idconsignacion': idconsignacion,
            },
            url: 'index.php?r=ConsignacionesVendedor/AjaxEliminar',
            type: 'post',
            beforeSend: function() {

            },
            success: function(response) {

                $('#danger').modal('show');
                ConsignacionesEliminar();



            }
        });

    } else {

        return;
    }

}


function recargar() {

    location.reload();

}


function FilterInput(event) {

    var chCode = ('charCode' in event) ? event.charCode : event.keyCode;

    document.getElementById("Errorng").innerHTML = "";
    document.getElementById("ErrorEF").innerHTML = "";
    document.getElementById("ErrorCH").innerHTML = "";
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


$("#codbanco").blur(function() {

    var codbanco = $("#txtBanco").val();
    var IdentificadorBanco = $("#codbanco").val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var cod = xmlhttp.responseText;
            var codbanc = xmlhttp.responseText;
            if (cod === 'si' && codbanc === 'si') {

                $('#_alertConVende .text-modal-body').html('El código del banco no corresponde al banco seleccionado');
                $('#_alertConVende').modal('show');
                $("#codbanco").val('');
                document.getElementById("txtCuenta").disabled = true;
                // document.getElementById("codbanco").focus();
            } else {


                $("#nombrebanco").val(IdentificadorBanco + "-" + codbanco);
                document.getElementById("txtCuenta").disabled = false;

            }
        }
    }
    xmlhttp.open("GET", "index.php?r=ConsignacionesVendedor/AjaxValidarCod&IdentificadorBanco=" + IdentificadorBanco + "&codbanco=" + codbanco, true);
    xmlhttp.send();
});


function foco() {
    $('#_alertConVende').modal('hide');

}

function salir() {


    $('#_alertConfirmationConsignacion .text-modal-body').html('Esta seguro que desea salir del modulo de consignación vendedor?');
    $('#_alertConfirmationConsignacion').modal('show');


}

function ok() {

    window.location.href = "index.php?r=FuerzaVentas/MenuFuerzaVentas";
}


function val() {

    document.getElementById("ErrorOFI").innerHTML = "";

}

function  val1() {

    document.getElementById("ErrorCIU").innerHTML = "";
}

function limpiar() {


    $("#codbanco").val('');
    $("#nombrebanco").val('');
    $('#txtCuenta').find('option:first').attr('selected', 'selected').parent('select');
    $("#verificarcod").prop("disabled", false);

}

function numeros(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " 0123456789";
    especiales = [8, 37, 39, 46];

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}

$(".GenrarFormasPago").click(function() {

    var codzona = $("#codzona").val();
    var codagencia = $("#codagencia").val();
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();

    $.ajax({
        data: {
            'codzona': codzona,
            'codagencia': codagencia,
            'fechaini': fechaini,
            'fechafin': fechafin
        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxFormasPagos',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


          $('#tablaformaspago').html(response);

        }
    });

});

function formaspagos() {

    $('#_formaPago').modal('show');

}

// funcion para traer los cheques del dia ingresados
function ChequesaldiaConsignaciones() {

    var codzona = $("#codzona").val();
    var codagencia = $("#codagencia").val();

    $.ajax({
        data: {
            'codzona': codzona,
            'codagencia': codagencia,

        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxChequesaldiaConsignaciones',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            if (response === "") {


                $('#_alerta .text-modal-body').html('No hay cheques al dia registradas para esta zona de ventas');
                $('#_alerta').modal('show');
                return;

            } else {

                $(".contentModal").html(response);
                $('#alertChequealDiaConsignacionVendedor').modal('show');

            }
        }
    });

}

function chequenuevoConsigvendedor() {

    $("#_modalChqueConsignacionVendedor").modal('show');

}

$('body').on('change', '.agregarChequeConsignacion', function() {

    var txtNumeroCheque = $(this).attr('data-numero');
    var txtBancoCheque = $(this).attr('data-CodigoBanco');
    var txtCuentaCheque = $(this).attr('data-Cuenta');
    var txtFechaCheque = $(this).attr('data-Fecha');
    var txtGirado = $(this).attr('data-Girado');
    var txtOtro = $(this).attr('data-Otro');

    //// valor y saldo del cheque 
    var txtValCheque = $(this).attr('data-Valor');

    //alert(txtNumeroCheque + " "+ txtBancoCheque + " "+ txtValCheque);


    if( $(this).is(':checked') ) {
        // Hacer algo si el checkbox ha sido seleccionado
        setChequeConsig(txtNumeroCheque, txtBancoCheque, txtCuentaCheque, txtFechaCheque, txtGirado, txtOtro, txtValCheque);
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        deleteChequeConsig(txtNumeroCheque, txtBancoCheque);
    }
});

function setChequeConsig(txtNumeroCheque, txtBancoCheque, txtCuentaCheque, txtFechaCheque, txtGirado, txtOtro, txtValCheque) {

    $.ajax({
        data: {
            "txtNumeroCheque": txtNumeroCheque,
            "txtBancoCheque": txtBancoCheque,
            "txtCuentaCheque": txtCuentaCheque,
            "txtFechaCheque": txtFechaCheque,
            "txtValorCheque": txtValCheque,
            "txtGirado": txtGirado,
            "txtOtro": txtOtro,
        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxSetChequeConsig',
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

        }
    });
}


function deleteChequeConsig(numero, codbanco) {

    $.ajax({
        data: {
            "numero": numero,
            "codbanco": codbanco

        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxDeleteChequeConsig',
        type: 'post',
        success: function(response) {

            if (response == 1) {

                $("#_alerta").css("z-index", "8000000");
                $('#_alerta .text-modal-body').html('Para poder eliminar el cheque es necesario eliminar los registros relacionados con las facturas recaudadas');
                $('#_alerta').modal('show');
                $('#_ModalEliminarCh').modal('hide');
                return false;

            }
        }
    });

}

$('#btnAgregarChequeConsignacionVendedor').click(function() {

    $.ajax({
        url: 'index.php?r=ConsignacionesVendedor/AjaxSumasChequesConsig',
        type: 'post',
        success: function(response) {
            var res = response;
            $('#valorecheque').val(res);
            $('#alertChequealDiaConsignacionVendedor').modal('hide');

        }
    });


});

$('body').on('click', '.btnAgregarNuevoch', function() {

    var txtNumeroCheque = $('#txtNumeroCheque').val();
    var txtBancoCheque = $('#txtBancoCheque').val();
    var textoBancoCheque = $('#MsgBanco').html();
    var txtCuentaCheque = $('#txtCuentaCheque').val();
    var txtFechaCheque = $('#txtFechaCheque').val();
    var txtGirado = $('#txtGirado').val();
    var txtOtro = $('#txtOtro').val();


    var txtValorCheque = $('#txtValorCheque').val();

    var txtValCheque = txtValorCheque.replace(/,/g, '');


    if (txtValorCheque == 0) {

        $("#_alerta").css("z-index", "1020000");
        $('#_alerta .text-modal-body').html('No hay registros de recaudos pendientes para la factura. Verifique la informacion, es posible que ya se encuentre recaudada.');
        $('#_alerta').modal('show');
        return false;
    }

    $.ajax({
        data: {
            "txtNumeroCheque": txtNumeroCheque,
            "txtBancoCheque": txtBancoCheque,
            "textoBancoCheque": textoBancoCheque,
            "txtCuentaCheque": txtCuentaCheque,
            "txtFechaCheque": txtFechaCheque,
            "txtValorCheque": txtValCheque,
            "txtGirado": txtGirado,
            "txtOtro": txtOtro,
        },
        url: 'index.php?r=ConsignacionesVendedor/AjaxSetChequeNuevoConsig',
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

            $('#_modalChqueConsignacionVendedor').modal('hide');

        }
    });
});

$('body').on('blur', '.txtLenghtCodBanco', function() {

    
    var txtBanco = $("#txtBancoChe").val();
    var txtcodbanco = $("#txtBancoCheque").val();

    if (txtBanco == "") {
        $("#_alerta").css("z-index", "510000");
        $('#_alerta .text-modal-body').html('Debe seleccionar un Banco primero');
        $('#_alerta').modal('show');
        return false;
    }

    if (txtcodbanco == "") {
        $("#_alerta").css("z-index", "520000");
        $('#_alerta .text-modal-body').html('Debe digitar un Codigo de Banco');
        $('#_alerta').modal('show');
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

            /*$("#MsgBanco").html(response);
             $("#MsgBanco").show();*/

        }
    });
});

