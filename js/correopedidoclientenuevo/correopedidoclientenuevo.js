$('body').on('click','.salircorreo',function(){
    
    $("#_alertConfirmarAdminUsuario .text-modal-body").html('Esta seguro que desea salir del modulo de correo pedido minimo cliente nuevo?');
    $("#_alertConfirmarAdminUsuario").modal('show');
});


jQuery(document).ready(function() {

    $('#DatosCorreo').DataTable({
        "pagingType": "full_numbers",
        "bProcessing": true,
        "sAjaxSource": "index.php?r=CorreoPedidosClientenuevo/AjaxCargarInformacionCorreo",
        "aoColumns": [
            {mData: 'Nombres'},
            {mData: 'Apellidos'},
            {mData: 'CorreoElectronico'},
            {mData: 'EstadoCorreo'},
            //{mData: 'NombreCuentaProveedor'},
            {mData: 'NombreAgencia'},
            {mData: 'Boton'},
            {mData: 'BotonEditar'}
             
        ],
        "aLengthMenu": [
            [10,25, 50, 100, -1],
            [10,25, 50, 100, "All"]
        ],
        "iDisplayLength": -1
    });

   /*$('#DatosPedidoMaximo').DataTable({
        "pagingType": "full_numbers",
        "bProcessing": true,
        "sAjaxSource": "index.php?r=CorreoPedidosClientenuevo/AjaxCargarPedidoMaximo",
        "aoColumns": [
            {mData: 'Valor'},
            {mData: 'FechaRegistro'},
            {mData: 'BotonEditar'}
             
        ],
        "aLengthMenu": [
            [10,25, 50, 100, -1],
            [10,25, 50, 100, "All"]
        ],
        "iDisplayLength": -1
    });*/

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
   
   
   $.ajax({
        data: {
            'Nombre': Nombre,
            'Apellido':Apellido,
            'correo':correo,
            'agencia':agencia,
            
        },
        url: 'index.php?r=CorreoPedidosClientenuevo/AjaxGuardarCorreo',
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


$('body').on('click', '.eliminarcorreo', function() {
    
    var  id = $(this).attr('data-id');
    
    $.ajax({
        data: {
            'id': id                         
        },
        url: 'index.php?r=CorreoPedidosClientenuevo/AjaxEliminarCorreo',
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

$('body').on('click', '.editarcorreo', function(){

    var id = $(this).attr('data-id');
    $.ajax({
        data:{
            'id': id
        },
        url: 'index.php?r=CorreoPedidosClientenuevo/AjaxEditarCorreAlert',
        type: 'post',
        beforeSend: function(){

        },
        success: function(response){
            $("#editarInfo").html(response);
            $("#Modaleditar").modal('show');

        }
    });

});


$('body').on('click', '.editarpedidomaximo', function(){

    //var id = $(this).attr('data-id');
    $.ajax({
       /* data:{
            'id': id
        },*/
        url: 'index.php?r=CorreoPedidosClientenuevo/AjaxEditarValorAlert',
        type: 'post',
        beforeSend: function(){

        },

        success: function(response){
            $("#editarInfo").html(response);
            $("#Modaleditar").modal('show');

        }
    });

});

$('body').on('click', '#btnGuardarEdicionCorreo', function(){
    
   var Nombre = $('#nombreEditado').val();
   var Apellido = $('#apellidoEditado').val();
   var correo = $('#correoEditado').val();
   var agencia = $('#SelectAgenciaEditado').val();
   var estado = $('#SelectEstadoEditado').val();
   var id = $(this).attr('data-id');

   
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

    if(agencia === ""){
       
       $('#ErroEstado').html('seleccione una Estado');
       $('#ErroEstado').show();
       $('#ErroEstado').hide();
       return false;
   }
   
   
   $.ajax({
        data: {
            'Nombre': Nombre,
            'Apellido':Apellido,
            'correo':correo,
            'agencia':agencia,
            'estado':estado,
            'id':id,
            
        },
        url: 'index.php?r=CorreoPedidosClientenuevo/AjaxGuardarCorreoEditado',
        type: 'post',
        beforeSend: function() {
          
            $("#_alertCarg").modal('show');

        },
        success: function(response) {

            $("#_alertCarg").modal('hide');
            $("#_alertaSueccesCorreoVentaDirecta #sucess").html('Informacion editada correctamente');
            $("#_alertaSueccesCorreoVentaDirecta").modal('show');
            


            window.setTimeout(function() {

                location.reload();

            }, 2000);

        }
    });
    
});

$('body').on('click', '#btnGuardarEdicionValor', function(){
    
   var valor = $('#valorMinimo').val();
   var id = $(this).attr('data-id');
   
   if(valor === ""){
       
       $('#ErrorNombre').html(' No a digitado un valor minimo para el pedido de clinete nuevo');
       $('#ErrorNombre').show();
       return false;
   }
   
   $.ajax({
        data: {
            'valor': valor,
            'id':id,
        },
        url: 'index.php?r=CorreoPedidosClientenuevo/AjaxGuardarValorEditado',
        type: 'post',
        beforeSend: function() {
          
            $("#_alertCarg").modal('show');

        },
        success: function(response) {


            $("#_alertCarg").modal('hide');
            $("#_alertaSueccesCorreoVentaDirecta #sucess").html('Informacion editada correctamente');
            $("#_alertaSueccesCorreoVentaDirecta").modal('show');
            
            window.setTimeout(function() {

                location.reload();

            }, 2000);

        }
    });
    
});