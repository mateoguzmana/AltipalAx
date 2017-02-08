jQuery('#tblClientesRutaNoVentas').dataTable({
       "sPaginationType": "full_numbers",
       "aoColumns": [
            { "sType": 'numeric' }
        ]
 });
 
 
 function ok() {

    window.location.href = "index.php?r=FuerzaVentas/MenuFuerzaVentas";
}


$("#retornarMenu").click(function() {
     
    $('#_alertConfirmationMenuGestionNoVenta .text-modal-body').html('Esta seguro que desea salir del modulo de gestion no ventas ?');
    $('#_alertConfirmationMenuGestionNoVenta').modal('show');

});
 
 $('#_alertInformationGestionNoVenta .text-modal-body').html('En este módulo se encuentran los clientes que no poseen un pedido o una no venta');
 $('#_alertInformationGestionNoVenta').modal('show');
