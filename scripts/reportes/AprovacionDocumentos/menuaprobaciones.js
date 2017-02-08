 function ConceptosAsignados(){
    
    $("#_alerta .text-modal-body").html('Usted no tiene asociados conceptos de notas creditos');
    $("#_alerta").modal('show');
    return;
}


$('.salir').click(function (){
   
    window.location.href='index.php?r=reportes/Reportes/Menu';
    
});
    
     
 

 