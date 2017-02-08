jQuery('#tblinformationsitioalamcen').dataTable({
       "sPaginationType": "full_numbers",
 
 });
 
  $('#retornarMenu').click(function (){
       
        $('#_alertInformationMenuSegumiento .text-modal-body').html('Esta seguro que desea salir del modulo de sitios almacen ?');
        $('#_alertInformationMenuSegumiento').modal('show');
        return false;
 
 });
 
