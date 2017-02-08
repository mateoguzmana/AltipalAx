jQuery('#tblinformationsaldopreventa').dataTable({
       "sPaginationType": "full_numbers",
 
 });
 
 
  $('#retornarMenu').click(function (){
       
        $('#_alertInformationMenuSegumiento .text-modal-body').html('Esta seguro que desea salir del modulo de preventa ?');
        $('#_alertInformationMenuSegumiento').modal('show');
        return false;
 
 });
 

