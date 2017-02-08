jQuery(document).ready(function(){
    
    $('#Datoszona').dataTable({
                 "pagingType": "full_numbers",
                 "bProcessing": true,
                 "sAjaxSource": "index.php?r=ReporteZonaVentas/AjaxDatosZonasVentas",
                 "aoColumns": [
                        { mData: 'ZonaVentas' },
                        { mData: 'CodAsesor' },
                        { mData: 'jerarquiacomercial' },
                        { mData: 'Agencia' },
                        { mData: 'GrupoVentas' },
                        { mData: 'GrupoVentasZona' },
                        { mData: 'Clientes' },
                        { mData: 'Cartera' } ,
                        { mData: 'Portafolio' },
                        { mData: 'Preventa' },
                        { mData: 'Autoventa' },
                        { mData: 'Consignacion' } ,
                        { mData: 'Ventadirecta' },
                        { mData: 'Focalizado' }
                        
                        
                        
                ]
        });
    
    
    
});

$(".DetalleInformacion").click(function (){
    
    $("#_modalinformation").modal('show');
    
    
});


