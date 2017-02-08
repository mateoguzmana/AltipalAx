 $(document).ready(function(){
     
	     $('#tableDetailProfundidad').dataTable();
	 /*$("#tableDetailProfundidad").dataTable(); 
	 alert("adssd");*/
 	$('body').on('click','#btnBuscarCliente',function(){
         var filterBuscarCliente = $("#txtBuscarCliente").val();
         var zonaVentas = $(this).attr('data-zonaventas');
         var identificadorBusqueda = "";
         var textBoton = "";
         if(filterBuscarCliente != ""){
            identificadorBusqueda = "find"
            textBoton = "Cargar Todo / Buscar"
         }else{
            identificadorBusqueda = "all"
            textBoton = "Buscar"
         }
         $.ajax({
            data: {
                "filterBuscarCliente": filterBuscarCliente,
                "zonaVentas": zonaVentas,
                "identificadorBusqueda": identificadorBusqueda
            },
            url: 'index.php?r=Rutero/AjaxGetFilterClientes',
            type: 'post',
            beforeSend: function(){
                $("#img-cargar-clientes").html('<img alt="" src="images/loaders/loader9.gif">');
                $('#btnBuscarCliente').attr("disabled", true);
            },
            success: function(response){
                $('#divContenpendientesporfacturar').html(response);
                $("#txtBuscarCliente").val("");
                $('#btnBuscarCliente').html(textBoton);
                $("#img-cargar-clientes").html("");
                $('#btnBuscarCliente').attr("disabled", false);
            }
        });
    });
});


 
 
$(".verTablaDimension").click(function (){
    
    $("#tablaDimensiones").modal('show');
    
});


$(".verTablaProfundidad").click(function (){
    
    $("#tablaProfundidad").modal('show');
    
    
});


$(".verTablaProveedor").click(function (){
    
    $("#tablaProveedores").modal('show');
    
    
});



