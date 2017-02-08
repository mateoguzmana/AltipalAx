/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$("#Departamentos").change(function() {

    var Codigo = $(this).val();
    var zonaVentas = $(this).attr('data-zona-ventas');
    var rutaSeleccionada = $(this).attr('data-ruta');

    $.ajax({
        data: {
            "Codigo": Codigo,
            "zonaVentas": zonaVentas,
            "rutaSeleccionada": rutaSeleccionada
        },
        url: 'index.php?r=ClientesNuevos/Ciudades',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-departamento").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            $("#Ciudades").html(response);
            $("#Barrios").html('<option>Barrios</option>');
            $("#img-cargar-departamento").html('');

        }
    });
});



$("#Ciudades").change(function() {

    var Codigo = $(this).val();
    var zonaVentas = $(this).attr('data-zona-ventas');
    var rutaSeleccionada = $(this).attr('data-ruta');

    $.ajax({
        data: {
            "Codigo": Codigo,
            "zonaVentas": zonaVentas,
            "rutaSeleccionada": rutaSeleccionada
        },
        beforeSend: function() {
            $("#img-cargar-ciudades").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        url: 'index.php?r=ClientesNuevos/Barrios',
        type: 'post',
        success: function(response) {
            $("#img-cargar-ciudades").html('');
            $("#Barrios").html(response);
            //jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});
        }
    });
});


$('#retornarMenu').click(function() {

    var zona = $(this).attr('data-zona');
    var cliente = $(this).attr('data-cliente');

    $('#_alertConfirmationMenu .text-modal-body').html('Esta seguro que desea salir del registro de clientes nuevos <b>' + $('#txtNombreCliente').text() + '</b>');
    $('#_alertConfirmationMenu').modal('show');

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

function validarEmail() {
    
    var email = document.getElementById("email").value.indexOf("@");
    var ErrorEmail = document.getElementById('ErrorEmail');


    if (email == -1) {
        ErrorEmail.innerHTML = "<font color='red'>Dirección de correo electrónico no válida</font>";
        return false;
    } else {

        document.getElementById("ErrorEmail").innerHTML = "";
    }
}


//jQuery(".chosen-select").chosen({'width':'100%','white-space':'nowrap'});

