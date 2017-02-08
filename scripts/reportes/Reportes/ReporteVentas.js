$('body').on('click','.saliractividad',function(){
    
    $("#_alertConfirmarSemana .text-modal-body").html('Esta seguro que desea salir del modulo de actividades ?');
    $("#_alertConfirmarSemana").modal('show');
});


$('.onchagegrupos').change(function (){
    
  var agencia = $("#selectchosenagencia").val();
   
       $.ajax({
        data: {
            'agencia': agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGruposVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
            $('#selectchosezonaventas2').val('').trigger('chosen:updated');
            $('#selectchosegrupventas2').val('').trigger('chosen:updated');
            $('#selectchosencanal').val('').trigger('chosen:updated');
            
            
            $("#grupoventa").html('');             
            $("#grupoventa").html(response); 
            $("#selectchosegrupventas2").chosen();
            
           
        }
    });
    
});

$('.onchangezonaventas').change(function (){
    
    
    var grupoventa = $("#selectchosegrupventas2").val();
    var agencia = $("#selectchosenagencia").val();
    
    
     $.ajax({
        data: {
            'grupoventa': grupoventa,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarZonasVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
            $("#zonasventas").html('');             
            $("#zonasventas").html(response); 
            $("#selectchosezonaventas2").chosen();
        }
    });
     
    
     
});


$('.onchangereportzonaventas').change(function (){
    
    $("#cargando").css("display", "inline");
    
    var zona = $("#selectchosezonaventas2").val();
    var fecha = $("#datepicker").val();
      
       $.ajax({
        data: {
            'zona': zona,
            'fecha':fecha
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasZonasVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
          
          //$("#containerZonaventas").html(response);   
          
          $("#graf").html(response);
          $("#cargando").css("display", "none");
             
        }
    });
     
     
});


$('.GenrarRepotFecha').change(function (){
    
    $("#cargando").css("display", "inline");
     
    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
     
      
       $.ajax({
        data: {
            'fecha':fecha,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasFecha',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
          $("#cargando").css("display", "none");
             
        }
    });
     
     
});

$('.GenrarRepoteGrupVenta').change(function (){
    
    $("#cargando").css("display", "inline");
     
    var fecha = $("#datepicker").val();
    var grupo = $("#selectchosegrupventas2").val();
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'grupo':grupo,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasGrupoVenta',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
          $("#cargando").css("display", "none");
             
        }
    });
     
     
});


$('.GenrarRepoteAgencia').change(function (){
    
     $("#cargando").css("display", "inline");
    
    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasAgencia',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
          $("#cargando").css("display", "none");
             
        }
    });
    
    
    
});


$('.onchangeproveedores').change(function (){
    
    
    var zonaventas = $("#selectchosezonaventas2").val();
    var agencia = $("#selectchosenagencia").val();
    
    
     $.ajax({
        data: {
            'zonaventas': zonaventas,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarProveedor',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
            $("#proveedor").html('');             
            $("#proveedor").html(response); 
           
            $("#selectchoseproveedor2").chosen();
        }
    });
     
    
     
});



$('.GenrarRepoteProveedor').change(function (){
    
     $("#cargando").css("display", "inline");
    
    var fecha = $("#datepicker").val();
    var proveedor = $("#selectchoseproveedor2").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'proveedor':proveedor
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasProveedor',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
          $("#cargando").css("display", "none");
             
        }
    });
    
    
    
});



$('.GenrarRepoteCanal').change(function (){
    
     $("#cargando").css("display", "inline");
    
    var fecha = $("#datepicker").val();
    var canal = $("#selectchosencanal").val();
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'canal':canal,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaVentasCanal',
        type: 'post',
        beforeSend: function() {
           //$("#_alertCargando").modal('show');
        },
        success: function(response) {
            
           //$("#_alertCargando").modal('hide');  
          $("#graf").html(response);
          $("#cargando").css("display", "none");
             
        }
    });
    
    
    
});

