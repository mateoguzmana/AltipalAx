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
    
    
    var zona = $("#selectchosezonaventas2").val();
    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
      
       $.ajax({
        data: {
            'zona': zona,
            'fecha':fecha,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaClientesXZonasVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
          
          //$("#containerZonaventas").html(response);   
          
          $("#graf").html(response);
             
        }
    });
     
     
});

$('.GenrarRepoteGrupVenta').change(function (){
    
     
    var fecha = $("#datepicker").val();
    var grupo = $("#selectchosegrupventas2").val();
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'grupo':grupo,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaClientesXGruposVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
             
        }
    });
     
     
});



$('.GenrarRepoteFecha').change(function (){
    
     
    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
     
      
       $.ajax({
        data: {
            'fecha':fecha,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaClientesXFecha',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
             
        }
    });
     
     
});


$('.GenrarRepoteCanal').change(function (){
    
       
    var fecha = $("#datepicker").val();
    var canal = $("#selectchosencanal").val();
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'canal':canal,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaClientesXCanal',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
             
        }
    });
     
     
});


$('.GenrarRepoteAgencia').change(function (){
    
    var fecha = $("#datepicker").val();
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'fecha':fecha,
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaClienteXAgencia',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
             
        }
    });
    
    
    
});