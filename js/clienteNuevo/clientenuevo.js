jQuery(document).ready(function () {

    getLocation();

    var origen = $("#origenCC").val();


    if (origen == "CIFIN" || origen == "") {

        $("#alertacuentavacia").modal('show');

    }

    var ClienteNuevo = $('#ClienteNuevoCedula').val();


    if (ClienteNuevo == 1) {

        var iddentificacion = $('option:selected', $(this)).attr('data-identificacion');
        var cuentacliente = $('option:selected', $(this)).attr('data-cuentacliente');

        $.ajax({
            data: {
                "iddentificacion": iddentificacion,
                "cuentacliente": cuentacliente
            },
            url: 'index.php?r=ClientesNuevos/AjaxDatosClientes',
            type: 'post',
            beforeSend: function () {
                $("#img-cargar-otrobarrio").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function (response) {

                var DatosCliente = jQuery.parseJSON(response);

                $('#primerNombre').val(DatosCliente.PrimerNombre);
                $('#segundoNombre').val(DatosCliente.SegundoNombre);
                $('#primerApellido').val(DatosCliente.PrimerApellido);
                $('#segundoApellido').val(DatosCliente.SegundoApellido);
                $('#codigoCiiuLabel').html(DatosCliente.CodigoCIIU);
                $('#CodigoCiuu').val(DatosCliente.CodigoCIIU);
                $('#nombreCiuu').html(DatosCliente.NombreCiuu);
                $('#EestablecimientoCliExitenteNit').val(DatosCliente.Establecimiento);
                $('#CodCiudadLabel').html(DatosCliente.CodigoCiudad);
                $('#NombreCiudadLabel').html(DatosCliente.Ciudad);
                $('#CodDapartamentoLabel').html(DatosCliente.CodigoDepartamento);
                $('#NombreDepartamentoLabel').html(DatosCliente.NombreDepartamento);
                $('#CodBarrioLabel').html(DatosCliente.Barrio);
                $('#NombreBarrioLabel').html(DatosCliente.NombreBarrio);
                $('#CodBarrio').val(DatosCliente.Barrio);

                $('#direc').val(DatosCliente.Calle);
                $('#tel').val(DatosCliente.Telefono);
                $('#telMovil').val(DatosCliente.TelefonoMovil);
                $('#email').val(DatosCliente.CorreoElectronico);
                $('#Cedula').val(iddentificacion);

                $('#CuentaCliente').val(cuentacliente);
                $('#CuantaClienteZona').html(cuentacliente);
                $('#RazonSocialZona').html(DatosCliente.RazonSocial);
                $('#EstablecimientoZona').html(DatosCliente.Establecimiento);
                $('#Identificacion').val(iddentificacion);

                var Estado = DatosCliente.Estado;

                if (Estado == 1) {

                    $('#EstadoZona').html('Activo');

                } else {

                    $('#EstadoZona').html('Inactivo');
                }

                $('#DireccionZona').html(DatosCliente.Calle);
                $('#BarrioZona').html(DatosCliente.NombreBarrio);


            }
        });

    } else if (ClienteNuevo == 2) {

        
        var iddentificacion = $('option:selected', $(this)).attr('data-identificacion');
        var cuentacliente = $('option:selected', $(this)).attr('data-cuentacliente');

        $.ajax({
            data: {
                "iddentificacion": iddentificacion,
                "cuentacliente": cuentacliente
            },
            url: 'index.php?r=ClientesNuevos/AjaxDatosClientes',
            type: 'post',
            beforeSend: function () {
                $("#img-cargar-otrobarrio").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function (response) {

                var DatosCliente = jQuery.parseJSON(response);

                $('#nombreRazonSocialCliExitenteNit').val(DatosCliente.RazonSocial)
                $('#codigoCiiuLabel').html(DatosCliente.CodigoCIIU);
                $('#CodigoCiuu').val(DatosCliente.CodigoCIIU);
                $('#nombreCiuu').html(DatosCliente.NombreCiuu);
                $('#EestablecimientoCliExitenteNit').val(DatosCliente.Establecimiento);
                $('#CodCiudadLabel').html(DatosCliente.CodigoCiudad);
                $('#NombreCiudadLabel').html(DatosCliente.Ciudad);
                $('#CodDapartamentoLabel').html(DatosCliente.CodigoDepartamento);
                $('#NombreDepartamentoLabel').html(DatosCliente.NombreDepartamento);
                $('#CodBarrioLabel').html(DatosCliente.Barrio);
                $('#NombreBarrioLabel').html(DatosCliente.NombreBarrio);
                $('#CodBarrio').val(DatosCliente.Barrio);
                $('#direccion1').val(DatosCliente.Calle);
                $('#telefono1').val(DatosCliente.Telefono);
                $('#telefonoMovil1').val(DatosCliente.TelefonoMovil);
                $('#email1').val(DatosCliente.CorreoElectronico);
                $('#nit').val(iddentificacion);

                $('#CuentaCliente').val(cuentacliente);
                $('#CuantaClienteZona').html(cuentacliente);
                $('#RazonSocialZona').html(DatosCliente.RazonSocial);
                $('#EstablecimientoZona').html(DatosCliente.Establecimiento);
                $('#Identificacion').val(iddentificacion);

                var Estado = DatosCliente.Estado;

                if (Estado == 1) {

                    $('#EstadoZona').html('Activo');

                } else {

                    $('#EstadoZona').html('Inactivo');
                }

                $('#DireccionZona').html(DatosCliente.Calle);
                $('#BarrioZona').html(DatosCliente.NombreBarrio);

            }
        });
    }


});


$('#zonasventas').click(function () {

    $('#alertazonasatienden').modal('show');


});

$('body').on('click', '#zonasventasvariosnit', function () {

//$('#zonasventasvariosnit').click(function(){

    var cuentacliente = $('#CuentaCliente').val();


    $.ajax({
        data: {
            "cuentacliente": cuentacliente
        },
        url: 'index.php?r=ClientesNuevos/AjaxZonaClientes',
        type: 'post',
        beforeSend: function () {
            $("#img").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {
            $('#DatosZonas').html(response);
            $('#Alertazonasventasvariosnit').modal('show');
            $("#img").html('');

        }
    });

});



$('body').on('click', '#zonasventasvarioCedula', function () {
//$('#zonasventasvariosnit').click(function(){

    var cuentacliente = $('#CuentaCliente').val();


    $.ajax({
        data: {
            "cuentacliente": cuentacliente
        },
        url: 'index.php?r=ClientesNuevos/AjaxZonaClientesCedula',
        type: 'post',
        beforeSend: function () {
            $("#img").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {
             //alert(response);

            $('#DatosZonasCedulas').html(response);
            $('#alertazonasatiendenCedula').modal('show');
            $("#img").html('');

        }
    });

});



$('#msgvalidarclienterutanit').click(function () {


    $("#alerta  .text-modal-body").html('El cliente es atendido por un asesor del mismo grupo de ventas');
    $("#alerta").modal('show');

});


$('#msgvalidarclienterutacedula').click(function () {


    $("#alerta  .text-modal-body").html('El cliente es atendido por un asesor del mismo grupo de ventas');
    $("#alerta").modal('show');

});


$('#crearclientenit').click(function () {

    $("#alertcrearclientenit  .text-modal-body").html('Recuerde que esta opción solo se debe utilizar para crear un nuevo establecimiento con una dirección diferente a los mostrados anteriormente. Desea continuar con la creación del establecimiento ?');
    $("#alertcrearclientenit").modal('show');

});


$('#crearclientecedula').click(function () {

    $("#alertcrearclientecedula  .text-modal-body").html('Recuerde que esta opción solo se debe utilizar para crear un nuevo establecimiento con una dirección diferente a los mostrados anteriormente. Desea continuar con la creación del establecimiento ?');
    $("#alertcrearclientecedula").modal('show');

});

$('#aceptarnit').click(function () {

    var CuentaCliente = $('#CuentaCliente').val();
    var Identificacion = $('#Identificacion').val();
    if (Identificacion != "" && CuentaCliente != "") {
        window.location.href = 'index.php?r=ClientesNuevos/FormularioClienteExisteVerificado&identificador=1&CuentaCliente="' + CuentaCliente + '"&Identificacion="' + Identificacion + '"';
    } else {

        window.location.href = 'index.php?r=ClientesNuevos/FormularioClienteExisteVerificado&identificador=1';
    }

});

$('#aceptarcedula').click(function () {

    window.location.href = 'index.php?r=ClientesNuevos/FormularioClienteExisteVerificado&identificador=2';

});


$("#Ciudades").change(function () {

    var codciudad = $(this).children('option:selected').attr('data-ciudad');
    var coddepartamento = $(this).children('option:selected').attr('data-depatamento');

    $.ajax({
        data: {
            "codciudad": codciudad,
            "coddepartamento": coddepartamento

        },
        url: 'index.php?r=ClientesNuevos/AjaxDepartamento',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-departamento").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {

            $("#Departamentos").html(response);
            $("#img-cargar-departamento").html('');
            jQuery(".chosen-select").chosen();


            $.ajax({
                data: {
                    "departamento": coddepartamento,
                    "ciudad": codciudad


                },
                url: 'index.php?r=ClientesNuevos/AjaxBarrios',
                type: 'post',
                beforeSend: function () {
                    $("#img-cargar-ciudades").html('<img alt="" src="images/loaders/loader9.gif">');
                },
                success: function (response) {

                    $("#Barrios").html(response);
                    $("#img-cargar-ciudades").html('');
                    jQuery(".chosen-select").chosen();

                    $('#BarriosSelect').change(function () {

                        var Bar = $("#BarriosSelect").val();

                        if (Bar == 0) {

                            $.ajax({
                                data: {
                                    "ciudad": codciudad,
                                    "departamento": coddepartamento


                                },
                                url: 'index.php?r=ClientesNuevos/AjaxOtroBarrioBarrios',
                                type: 'post',
                                beforeSend: function () {
                                    $("#img-cargar-otrobarrio").html('<img alt="" src="images/loaders/loader9.gif">');
                                },
                                success: function (response) {

                                    $("#OtroBarrio").html(response);
                                    $("#img-cargar-otrobarrio").html('');

                                }
                            });

                            //$("#OtBarrio").css("display", "inline");

                        } else {

                            $("#OtroBarrio").empty();

                        }

                    });



                }
            });

        }
    });
});



$("#agregardireccion").click(function () {


    var via = $("#via").val();
    var direc = $("#direc").val();
    var numero = $("#numero").val();
    var tipoviacomplemento = $("#tipoviacomplemento").val();
    var direccioncomplementaria = $("#direccioncomplementaria").val();

    if (via == 0) {

        via = '';
    }

    if (tipoviacomplemento == 0) {

        tipoviacomplemento = '';
    }

    $("#direccion").val(via + " " + direc + " " + numero + " " + tipoviacomplemento + " " + direccioncomplementaria);

});

$("#agregardireccionit").click(function () {


    var via = $("#vianit").val();
    var direc = $("#direcnit").val();
    var numero = $("#numeronit").val();
    var tipoviacomplemento = $("#tipoviacomplementonit").val();
    var direccioncomplementaria = $("#direccioncomplementarianit").val();

    if (via == 0) {

        via = '';
    }

    if (tipoviacomplemento == 0) {

        tipoviacomplemento = '';
    }

    $("#direccionnit").val(via + " " + direc + " " + numero + " " + tipoviacomplemento + " " + direccioncomplementaria);


});



$("#retornarMenu").click(function () {

    $("#_alertConfirmationMenu  .text-modal-body").html('Está seguro que desea salir del módulo de clientes nuevos ?');
    $("#_alertConfirmationMenu").modal('show');


});

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


$(".mayusculas").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        // I have tried setting those
        e.keyCode = newKey;
        e.charCode = newKey;
    }

    $("#primerNombre").val(($("#primerNombre").val()).toUpperCase());
    $("#segundoNombre").val(($("#segundoNombre").val()).toUpperCase());
    $("#primerApellido").val(($("#primerApellido").val()).toUpperCase());
    $("#segundoApellido").val(($("#segundoApellido").val()).toUpperCase());

    $("#direc").val(($("#direc").val()).toUpperCase());
    $("#numero").val(($("#numero").val()).toUpperCase());
    $("#direccioncomplementaria").val(($("#direccioncomplementaria").val()).toUpperCase());


    $("#direcnit").val(($("#direcnit").val()).toUpperCase());
    $("#numeronit").val(($("#numeronit").val()).toUpperCase());

    $("#direccioncomplementarianit").val(($("#direccioncomplementarianit").val()).toUpperCase());



});


function getLocation() {

    if (navigator.geolocation) {
        //setTimeout(function(){ location.reload() }, 15000);

        navigator.geolocation.getCurrentPosition(
                function (pos)
                {
                    var lat = pos.coords.latitude;
                    var lng = pos.coords.longitude;


                    $("#latitud").val(lat);
                    $("#longitud").val(lng);


                }
        );

    } else {

        getLocation();
        setTimeout(getLocation(), 50);
    }

}


$('body').on('change', '.selectIdCliente', function () {

    var iddentificacion = $('option:selected', $(this)).attr('data-identificacion');
    var cuentacliente = $('option:selected', $(this)).attr('data-cuentacliente');



    $.ajax({
        data: {
            "iddentificacion": iddentificacion,
            "cuentacliente": cuentacliente
        },
        url: 'index.php?r=ClientesNuevos/AjaxDatosClientes',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-otrobarrio").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {

            var DatosCliente = jQuery.parseJSON(response);

            $('#nombreRazonSocialCliExitenteNit').val(DatosCliente.RazonSocial)
            $('#codigoCiiuLabel').html(DatosCliente.CodigoCIIU);
            $('#CodigoCiuu').val(DatosCliente.CodigoCIIU);
            $('#nombreCiuu').html(DatosCliente.NombreCiuu);
            $('#EestablecimientoCliExitenteNit').val(DatosCliente.Establecimiento);
            $('#CodCiudadLabel').html(DatosCliente.CodigoCiudad);
            $('#NombreCiudadLabel').html(DatosCliente.Ciudad);
            $('#CodDapartamentoLabel').html(DatosCliente.CodigoDepartamento);
            $('#NombreDepartamentoLabel').html(DatosCliente.NombreDepartamento);
            $('#CodBarrioLabel').html(DatosCliente.Barrio);
            $('#NombreBarrioLabel').html(DatosCliente.NombreBarrio);
            $('#CodBarrio').val(DatosCliente.Barrio);
            $('#direccion1').val(DatosCliente.Calle);
            $('#telefono1').val(DatosCliente.Telefono);
            $('#telefonoMovil1').val(DatosCliente.TelefonoMovil);
            $('#email1').val(DatosCliente.CorreoElectronico);
            $('#nit').val(iddentificacion);

            $('#CuentaCliente').val(cuentacliente);
            $('#CuantaClienteZona').html(cuentacliente);
            $('#RazonSocialZona').html(DatosCliente.RazonSocial);
            $('#EstablecimientoZona').html(DatosCliente.Establecimiento);
            $('#Identificacion').val(iddentificacion);

            var Estado = DatosCliente.Estado;

            if (Estado == 1) {

                $('#EstadoZona').html('Activo');

            } else {

                $('#EstadoZona').html('Inactivo');
            }

            $('#DireccionZona').html(DatosCliente.Calle);
            $('#BarrioZona').html(DatosCliente.NombreBarrio);





            /*DatosCliente.CodigoTipoDocumento;
             DatosCliente.TipoDocumento;
             DatosCliente.CodigoCIIU;
             DatosCliente.RazonSocial;
             DatosCliente.DigitoVerificacion;
             DatosCliente.TipoNegocio;
             DatosCliente.FacturaEntregaEspera;
             DatosCliente.Ciudad;
             DatosCliente.Barrio;
             DatosCliente.Calle;
             DatosCliente.Telefono;
             DatosCliente.TelefonoMovil;
             DatosCliente.CorreoElectronico;
             DatosCliente.Origen;
             
             DatosCliente.NombreCiuu;
             DatosCliente.CodigoCiudad;
             DatosCliente.CodigoDepartamento;
             DatosCliente.NombreDepartamento;
             DatosCliente.NombreBarrio;*/


        }
    });




});





$('body').on('change', '.selectIdClienteCedula', function () {

    var iddentificacion = $('option:selected', $(this)).attr('data-identificacion');
    var cuentacliente = $('option:selected', $(this)).attr('data-cuentacliente');



    $.ajax({
        data: {
            "iddentificacion": iddentificacion,
            "cuentacliente": cuentacliente
        },
        url: 'index.php?r=ClientesNuevos/AjaxDatosClientes',
        type: 'post',
        beforeSend: function () {
            $("#img-cargar-otrobarrio").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function (response) {

            var DatosCliente = jQuery.parseJSON(response);

            $('#primerNombre').val(DatosCliente.PrimerNombre);
            $('#segundoNombre').val(DatosCliente.SegundoNombre);
            $('#primerApellido').val(DatosCliente.PrimerApellido);
            $('#segundoApellido').val(DatosCliente.SegundoApellido);
            $('#codigoCiiuLabel').html(DatosCliente.CodigoCIIU);
            $('#CodigoCiuu').val(DatosCliente.CodigoCIIU);
            $('#nombreCiuu').html(DatosCliente.NombreCiuu);
            $('#EestablecimientoCliExitenteNit').val(DatosCliente.Establecimiento);
            $('#CodCiudadLabel').html(DatosCliente.CodigoCiudad);
            $('#NombreCiudadLabel').html(DatosCliente.Ciudad);
            $('#CodDapartamentoLabel').html(DatosCliente.CodigoDepartamento);
            $('#NombreDepartamentoLabel').html(DatosCliente.NombreDepartamento);
            $('#CodBarrioLabel').html(DatosCliente.Barrio);
            $('#NombreBarrioLabel').html(DatosCliente.NombreBarrio);
            $('#CodBarrio').val(DatosCliente.Barrio);

            $('#direc').val(DatosCliente.Calle);
            $('#tel').val(DatosCliente.Telefono);
            $('#telMovil').val(DatosCliente.TelefonoMovil);
            $('#email').val(DatosCliente.CorreoElectronico);
            $('#Cedula').val(iddentificacion);

            $('#CuentaCliente').val(cuentacliente);
            $('#CuantaClienteZona').html(cuentacliente);
            $('#RazonSocialZona').html(DatosCliente.RazonSocial);
            $('#EstablecimientoZona').html(DatosCliente.Establecimiento);
            $('#Identificacion').val(iddentificacion);

            var Estado = DatosCliente.Estado;

            if (Estado == 1) {

                $('#EstadoZona').html('Activo');

            } else {

                $('#EstadoZona').html('Inactivo');
            }

            $('#DireccionZona').html(DatosCliente.Calle);
            $('#BarrioZona').html(DatosCliente.NombreBarrio);


        }
    });




});

