$(document).ready(function() {

    var ElementoExistenteAgecnia = $("#selectAgen").length

    if (ElementoExistenteAgecnia == 0) {

        $.ajax({
            data: {
                

            },
            url: 'index.php?r=reportes/Reportes/AjaxCargarGruposVentasSolo',
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

    }

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
            
            $("#zonasventas").html(response);            
            $("#selectchosezonaventas2").chosen();
           
        }
    });
     
    
     
});



$('.GenrarRepoteAgencia').change(function (){
    
   
    var agencia = $("#selectchosenagencia").val();
    
    
       $.ajax({
        data: {
            'agencia':agencia
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaAgenciaZonaVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
       $("#graf").html(response);
             
        }
    });
    
    
    
});

$('.GenrarRepoteCanal').change(function (){
    
    
    if($('#selectchosegrupventas2').val() == "" || $("#selectchosezonaventas2").val() == ""){
        
        return false;
    }
    
    
      var canal = $("#selectchosencanal").val();
      var agencia = $("#selectchosenagencia").val();
      var zona = $("#selectchosezonaventas2").val();
    
    
       $.ajax({
        data: {
            'canal':canal,
            'agencia':agencia,
            'zona':zona
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaZonaVentaXCanal',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
          $("#selectchosentipo").chosen();
             
        }
    });
     
     
});




$('.onchangereportzonaventas').change(function (){
    
    
    var zona = $("#selectchosezonaventas2").val();
    var agencia = $("#selectchosenagencia").val();
   
      
       $.ajax({
        data: {
            'zona': zona,
            'agencia':agencia

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaZonaVentasXZonasVentas',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
           //$("#containerZonaventas").html(response);   
          
          $("#graf").html(response);
          $("#selectchosentipo").chosen();
         
             
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
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaZonaVentasXFecha',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#graf").html(response);
          $("#selectchosengrupos").chosen();
          $("#selectchosenmarcas").chosen();
             
        }
    });
     
     
});

$('body').on('change','.GenrarRepoteTipo',function (){
    
     $("#cargando").css("display", "inline");
   
    var agencia = $("#selectchosenagencia").val();
    var zona = $('#selectchosezonaventas2').val();
    var tipo = $('#selectchosentipo').val();
  

      $.ajax({
        data: {
            'zona':zona,
            'agencia':agencia,
            'tipo':tipo
        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaProfundidadTipo',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
          $("#cargando").css("display", "none"); 
          $("#gr").html(response);
          $("#selectchosentipo").chosen();
          $("#selectchosencanal").chosen();
          $("#selectchosenagencia").chosen();
          $("#selectchosegrupventas").chosen();
          $("#selectchosezonaventas").chosen();
        }
    });     
});


$('body').on('change','.cargarRGMGlobal',function (){
    
    $("#cargando").css("display", "inline");
    
    var tipo = $('#selectchosentipo').val(); 
      
      $.ajax({
        data: {
            'tipo':tipo

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarGraficaProfundidadTipoGlobal',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
          $("#cargando").css("display", "none");   
          $("#gr").html(response);
          $("#selectchosentipo").chosen();
          $("#selectchosencanal").chosen();
          $("#selectchosenagencia").chosen();
          $("#selectchosegrupventas").chosen();
          $("#selectchosezonaventas2").chosen();             
        }
    });
     
     
});

