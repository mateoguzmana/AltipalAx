$('body').on('click','.salircorreo',function(){
    
    $("#_alertConfirmarAdminUsuario .text-modal-body").html('Esta seguro que desea salir del modulo de correo venta directa ?');
    $("#_alertConfirmarAdminUsuario").modal('show');
});


jQuery(document).ready(function() {

    $('#DatosCorreo').DataTable({
        "pagingType": "full_numbers",
        "bProcessing": true,
        "sAjaxSource": "index.php?r=Correoventadirecta/AjaxCargarInformacionCorreo",
        "aoColumns": [
            {mData: 'Nombres'},
            {mData: 'Apellidos'},
            {mData: 'CorreoElectronico'},
           // {mData: 'CodigoCuentaProveedor'},
           // {mData: 'NombreCuentaProveedor'},
            {mData: 'NombreAgencia'},
            {mData: 'Boton'}
             
        ],
        "aLengthMenu": [
            [10,25, 50, 100, -1],
            [10,25, 50, 100, "All"]
        ],
        "iDisplayLength": -1
    });

   $('#DatosProveedores').DataTable({
        "pagingType": "full_numbers",
        "bProcessing": true,
        "sAjaxSource": "index.php?r=Correoventadirecta/AjaxCargarProveedores",
        "aoColumns": [
            {mData: 'CuentaProveedor'},
            {mData: 'NombreProveedor'},
            {mData: 'NombreAgencia'},
            {mData: 'Boton'}
             
        ],
        "aLengthMenu": [
            [10,25, 50, 100, -1],
            [10,25, 50, 100, "All"]
        ],
        "iDisplayLength": -1
    });

     $("#SelectAgencia").chosen();


});


function marcarCheck(source)
{
    checkboxes = document.getElementsByTagName('input'); //obtenemos todos los controles del tipo Input
    for (i = 0; i < checkboxes.length; i++) //recoremos todos los controles
    {
        if (checkboxes[i].type == "checkbox") //solo si es un checkbox entramos
        {
            checkboxes[i].checked = source.checked; //si es un checkbox le damos el valor del checkbox que lo llamÃ³ (Marcar/Desmarcar Todos)
        }
    }
}


$('#btnGuardarCorreo').click(function (){
    
   var Nombre = $('#nombre').val();
   var Apellido = $('#apellido').val();
   var correo = $('#correo').val();
   var agencia = $('#SelectAgencia').val();
   
   if(Nombre === ""){
       
       $('#ErrorNombre').html(' el campo nombre no puede ser vacio');
       $('#ErrorNombre').show();
       return false;
   }
   
    if(Apellido === ""){
       
       $('#ErrorApell').html('el campo apellido no puede ser vacio');
       $('#ErrorApell').show();
       $('#ErrorNombre').hide();
       return false;
   }
   
    if(correo === ""){
       
       $('#ErrorCorreo').html('el campo correo no puede ser vacio');
       $('#ErrorCorreo').show();
       $('#ErrorApell').hide();
       return false;
   }
   
    if(agencia === ""){
       
       $('#ErroAgencia').html('seleccione una agencia');
       $('#ErroAgencia').show();
       $('#ErrorCorreo').hide();
       return false;
   }
   
   
   
    var UsuariisaActualizar = 0;
    var checkNoActualizar = 0;

   /* $(".chckProveedores").each(function() {
        UsuariisaActualizar++;
        if ($(this).is(":checked")) {
            checkNoActualizar++;
        }

    });

    if (checkNoActualizar == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione al menos un proveedor');
        $('#_alerta').modal('show');
        return false;
    }


    var arr_proveedores = new Array();
    var z = 0;

    /*$(".chckProveedores").each(function() {
        if ($(this).is(":checked")) {
            arr_proveedores[z] = $(this).val();
        }
        z++;
    });
    z = 0;*/
   
   
   $.ajax({
        data: {
            'Nombre': Nombre,
            'Apellido':Apellido,
            'correo':correo,
            'agencia':agencia,
            //'proveedores':arr_proveedores
            
        },
        url: 'index.php?r=Correoventadirecta/AjaxGuardarCorreo',
        type: 'post',
        beforeSend: function() {
          
            $("#_alertCarg").modal('show');

        },
        success: function(response) {


            $("#_alertCarg").modal('hide');
            $("#_alertaSueccesCorreoVentaDirecta #sucess").html('Correo Creado Correctamente');
            $("#_alertaSueccesCorreoVentaDirecta").modal('show');
            


            window.setTimeout(function() {

                location.reload();

            }, 2000);

        }
    });
    
});



$('#btnGuardarProveedor').click(function (){
    
   var codProveedor = $('#SelectProveedor').val();
   var codAgencia = $('#SelectAgenciaProveedor').val();
   
   if(codProveedor === ""){
       
       $('#ErrorNombre').html(' Seleccione un proveedor');
       $('#ErrorNombre').show();
       return false;
   }
   
    if(codAgencia === ""){
       
       $('#ErrorApell').html('Seleccione una agencia');
       $('#ErrorApell').show();
       $('#ErrorNombre').hide();
       return false;
   }
   
   
    //var UsuariisaActualizar = 0;
    //var checkNoActualizar = 0;

   /* $(".chckProveedores").each(function() {
        UsuariisaActualizar++;
        if ($(this).is(":checked")) {
            checkNoActualizar++;
        }

    });

    if (checkNoActualizar == 0) {

        $('#_alerta .text-modal-body').html('Por favor seleccione al menos un proveedor');
        $('#_alerta').modal('show');
        return false;
    }


    var arr_proveedores = new Array();
    var z = 0;

    /*$(".chckProveedores").each(function() {
        if ($(this).is(":checked")) {
            arr_proveedores[z] = $(this).val();
        }
        z++;
    });
    z = 0;*/
   
   
   $.ajax({
        data: {
            'codAgencia': codAgencia,
            'codProveedor':codProveedor,
            //'proveedores':arr_proveedores
            
        },
        url: 'index.php?r=Correoventadirecta/AjaxGuardarProveedor',
        type: 'post',
        beforeSend: function() {
          
            $("#_alertCarg").modal('show');

        },
        success: function(response) {


            $("#_alertCarg").modal('hide');
            $("#_alertaSueccesCorreoVentaDirecta #sucess").html('Proveedor Creado Correctamente');
            $("#_alertaSueccesCorreoVentaDirecta").modal('show');
            
            window.setTimeout(function() {

                location.reload();

            }, 2000);

        }
    });
    
});


$('body').on('click', '.eliminarcorreo', function() {
    
    var  id = $(this).attr('data-id');
    
    $.ajax({
        data: {
            'id': id                         
        },
        url: 'index.php?r=Correoventadirecta/AjaxEliminarCorreo',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {


            $("#_alertaSueccesCorreoVentaDirecta #sucess").html('Correo eliminado Correctamente');
            $("#_alertaSueccesCorreoVentaDirecta").modal('show');


            window.setTimeout(function() {

                location.reload();

            }, 2000);

        }
    });
    
});

$('body').on('click', '.eliminarproveedor', function() {
    
    var  id = $(this).attr('data-id');
    
    $.ajax({
        data: {
            'id': id                         
        },
        url: 'index.php?r=Correoventadirecta/AjaxEliminarProveedor',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            $("#_alertaSueccesCorreoVentaDirecta #sucess").html('Correo eliminado Correctamente');
            $("#_alertaSueccesCorreoVentaDirecta").modal('show');

            window.setTimeout(function() {

                location.reload();

            }, 2000);

        }
    });
    
});