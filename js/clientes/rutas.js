/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#frmRutas').submit(function(){
    
    
    var rutaSeleccionada=$('#input-ruta').val();   
    
    if( typeof rutaSeleccionada==="undefined" || rutaSeleccionada==""){
         $('#_alerta .text-modal-body').html('No se ha seleccionado una ruta.');
         $('#_alerta').modal('show');
        return false; 
    }else{        
        return true;
    }  
   
    
});