/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    $("#img").hide();
    
 jQuery('#tblClientesRuta').dataTable({
       "sPaginationType": "full_numbers",
       "aaSorting": []
       /*"aoColumns": [
           { "sType": 'numeric' },         
        ],      
        "aaSorting": [[1, 'asc']],*/
        
 });
 
 jQuery('#tblClientesExtraRuta').dataTable({
       "sPaginationType": "full_numbers",
       "aaSorting": []
        
 });
 
  $('#retornarMenu').click(function(){        
            var zona=$(this).attr('data-zona');
            var cliente=$(this).attr('data-cliente');    

            $('#_alertConfirmationMenuRutas .text-modal-body').html('Desea salir del listado de la ruta de Clientes?');
            $('#_alertConfirmationMenuRutas').modal('show');
     });
    
});

  /*$('#btnconsultarcliente').click(function (){
    
    var tipodoc = $('#tipoIdentificacion').val();
    var Identificacion = $('#identificacionCliente').val();
    
    alert(tipodoc);
    alert(Identificacion);
    
    
     $.ajax({
        data: {
            "tipodoc": tipodoc,
            "Identificacion": Identificacion
            
        },
        url: 'index.php?r=Clientes/AjaxValidarClienteNuevo',
        type: 'post',
        beforeSend: function() {
            $("#img-cargar-departamento").html('<img alt="" src="images/loaders/loader9.gif">');
        },
        success: function(response) {
            
            window.location.href = 'index.php?r=Clientes/AjaxFormularios&respuesta='+response+'';
            

        }
    });
    
    
    
    
});*/

/*

$('#frmConsultarCliente').submit(function(){
    
    var rutaSeleccionada=$('#rutaSeleccionada').val();
    var tipoIdentificacion = $("#tipoIdentificacion").val();
    var Identificacion = $("#identificacionCliente").val();
    
   /* alert(tipoIdentificacion);
    alert(Identificacion);
    $("#img").show();
    
     $.ajax({
            data: {               
                "rutaSeleccionada":rutaSeleccionada,
                "tipoIdentificacion":tipoIdentificacion,
                "Identificacion":Identificacion
            },
            async: false,
            url: 'About',
            type: 'post',
            success: function(response) {
                
            }
        });
    return true;
});

*/

 jQuery("#frmConsultarCliente").validate({
    highlight: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
      jQuery(element).closest('.form-group').removeClass('has-error');
    }
  });





$(".ValidarCaracteres").click(function (){
    
   var  tipoidentificacion = $("#tipoIdentificacion").val()
   var identificacionCliente = $("#identificacionCliente").val();
   
   if(tipoidentificacion == '001'){
       
      var numerocaracteres =  identificacionCliente.length;
     
     if(numerocaracteres < 9){
         
        $('#_alerta .text-modal-body').html('Deben ser exactamente 9 digitos');
        $('#_alerta').modal('show'); 
        return false;
         
     }else{
         
       $("#frmConsultarCliente").submit();  
         
     }
      
       
   }
    
});
