jQuery(document).ready(function() {


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

    $("#selectchosen").chosen();

});




$("#sitiosyalmacenes").click(function(){
    
  var sitio = $("#select-sitioalmacen  option:selected").attr('data-sitio');
  var almacen = $("#select-sitioalmacen  option:selected").attr('data-almacen');
   
    
    window.location.href = "index.php?r=seguimientos/InformesZonaVentas/SaldosPreventa&sitio=" + sitio + "&almacen=" + almacen;
    
    
});


$("#sitiosyalmacenesAutoventa").click(function(){
    
  var sitio = $("#select-sitioalmacenAutoventa  option:selected").attr('data-sitio');
  var almacen = $("#select-sitioalmacenAutoventa  option:selected").attr('data-almacen');
   
    
    window.location.href = "index.php?r=seguimientos/InformesZonaVentas/SaldosAutoventa&sitio=" + sitio + "&almacen=" + almacen;
    
    
});


$('.saldoinventaropreventa').click(function (){
    
    //var zonaventas  = $("#selectchosen").val();
    
    var zonaventas = $(this).attr('data-zona');
      

    if (zonaventas == "") {

        $('#_alertZonaVentas .text-modal-body').html('Por favor seleccione una zona de ventas!');
        $('#_alertZonaVentas').modal('show');
        return false;

    }else{
        
         $.ajax({
        data: {
            'zonaventas': zonaventas
            

        },
        url: 'index.php?r=seguimientos/InformesZonaVentas/AjaxCargarSitisoAlmacen',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            
          
             $('#sitiosyalamcenes').html(response);
            $('#sitiosAlmacenes').modal('show');



        }
    });
        
    }
    
});

 
$('.saldoinventaroautoventa').click(function (){
    
    var zonaventas  = $(this).attr('data-zona-auto');

    if (zonaventas == "") {

        $('#_alertZonaVentas .text-modal-body').html('Por favor seleccione una zona de ventas!');
        $('#_alertZonaVentas').modal('show');
        return false;

    }else{
        
         $.ajax({
        data: {
            'zonaventas': zonaventas
            

        },
        url: 'index.php?r=seguimientos/InformesZonaVentas/AjaxCargarSitisoAlmacenAutoventa',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

            
          
             $('#sitiosyalamcenesAutoventa').html(response);
            $('#sitiosAlmacenesAutoventa').modal('show');



        }
    });
        
    }
    
});


 $("#formZonaventas").submit(function() {

 
       var select = $("#selectchosen").val();
       
       
        if (select == "") {
                    
            $('#_alertZonaVentas .text-modal-body').html("Por favor seleccione una zona de ventas !");
            $('#_alertZonaVentas').modal('show');
            return false;

        } else {

            document.getElementById("formZonaventas").submit();
        
        }  


    });
    
    
    
 $("#retornarSelect").click(function(){
     
     $('#_alertInfomatioSalirMenu .text-modal-body').html('Esta seguro que desea salir del menu ?');
     $('#_alertInfomatioSalirMenu').modal('show');
      return false;
     
 });  
 
 
 $('.btnsalirmenu').click(function (){
     
      
        $.ajax({
        data: {
            
        },
        url: 'index.php?r=seguimientos/InformesZonaVentas/AjaxBorrarSession',
        type: 'post',
        beforeSend: function() {

        },
        success: function(response) {

             location.reload();

        }
    }); 
     
     
 });
    
