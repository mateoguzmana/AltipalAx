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

$('.CargarMapa').click(function (){
    
     
    var fechaini = $("#fechaini").val();
    var fechafin = $("#fechafin").val();
    var agencia = $("#selectchosenagencia").val();
    var grupo = $("#selectchosegrupventas2").val();
    var zona = $("#selectchosezonaventas2").val();
    
    if(fechaini == "" && fechafin == ""){
       
        $("#_alerta .text-modal-body").html("la fecha inicial y la fecha final no pueden estar vacios");
        $("#_alerta").modal('show');
        return false;
        
    }
     
    if(agencia == ""){
        
        $("#_alerta .text-modal-body").html("Por favor seleccione una agencia");
        $("#_alerta").modal('show');
        return false;
    } 
     
    if(fechafin < fechaini){
        
        $("#_alerta .text-modal-body").html("la fecha final no puede ser menor que la fecha inicial");
        $("#_alerta").modal('show');
        return false;
    }
    
       $.ajax({
        data: {
            'fechaini':fechaini,
            'fechafin':fechafin,
            'agencia':agencia,
            'grupo':grupo,
            'zonaVentas':zona
            

        },
        url: 'index.php?r=reportes/Reportes/AjaxCargarMapa',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {
            
           
          $("#Mapa").html(response);
             
        }
    });
     
     
});


