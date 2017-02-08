/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function () {
    
    $(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116) {
           
          $('#_alertaRecargarPagina .text-modal-body').html('Esta seguro de recargar la pagina ya que todos los cambios se perderan');  
          $('#_alertaRecargarPagina').modal('show');
          return false;
        }
    });
    
});

$('body').on('click','.ok',function(){
    
   location.reload(); 
});


var sitioSeleccioando;
var proveedoresSeleccioandos;
var motivosSeleccioandos; 

 $(".txtAreaObservaciones").keypress(function() {
            var limit = 50;
            var text = $(this).val();
            var chars = text.length;
            if (chars > limit) {
                var new_text = text.substr(0, limit);
                $(this).val(new_text);
            }
  });  
  
 jQuery('#validationWizard').bootstrapWizard({
        tabClass: 'nav nav-pills nav-justified nav-disabled-click',
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onNext: function(tab, navigation, index) {
            var $valid = jQuery('#formDevoluciones').valid();
            if (!$valid) {

                $validator.focusInvalid();
                return false;
            }
        }
    });
    
$('#txtMotivo').change(function() {
    
     if(!$('#select-sitio-devolucion').val()){
            $('#_alerta .text-modal-body').html('No se ha seleccionado un sitio');
            $('#_alerta').modal('show');
            return false;
      }
      //
      
      if($('#txtProveedores').val()==""){
            $('#_alerta .text-modal-body').html('No se ha seleccionado un proveedor.');
            $('#_alerta').modal('show');
            return false;
      }   
      
     if($('#txtMotivo').val()==""){
            $('#_alerta .text-modal-body').html('No existen motivos de devolucion.');
            $('#_alerta').modal('show');
            return false;
      }  
      
    var CodigoMotivoDevolucion = $(this).val();
    var zonaVentas = $(this).attr('data-zona');
    var cuentaCliente = $(this).attr('data-cliente');
    var CuentaProveedor = $("option:selected", this).attr('data-proveedor');

    
    $.ajax({
        data: {
            "CodigoMotivoDevolucion": CodigoMotivoDevolucion,
            "cuentaProveedor": CuentaProveedor,
            "zonaVentas": zonaVentas,
            "cuentaCliente": cuentaCliente,
        },
        url: 'index.php?r=Devoluciones/AjaxGetPortafolioProveedor',
        type: 'post',
        success: function(response) {
            if (response != 0) {
                $('#contentPortafolioProveedores').html(response);

                inicializarDevoluciones();

                $('#tablePortafolioProveedores').on('page', function() {
                    inicializarDevoluciones();
                }).dataTable({
                     "bPaginate": false,
                    "bSort": false,
                });



            } else {

                $.ajax({
                    url: "index.php?r=Devoluciones/AjaxLimpiarPorafolioProveedor",
                    type: "post",
                    success: function(response) {
                        $("#contentPortafolioProveedores").html("");
                        $("#contentProductosAgregados").html("");
                        
                    }
                });
                
                var txtMotivo= $('#txtMotivo').find("option:selected").text()
                $('#_alerta .text-modal-body').html('No existen articulos relacionados a este proveedor para el motivo de devolución <b>"'+txtMotivo+'</b>"');
                $('#_alerta').modal('show');
            }
        }
    });

});
    
    
   $('#select-sitio-devolucion').focus(function(){
       sitioSeleccioando= $( "#select-sitio-devolucion option:selected" ).val();     
   }); 
   
    $('#txtProveedores').focus(function(){
       proveedoresSeleccioandos= $( "#txtProveedores option:selected" ).val();     
   }); 
    
   $("#select-sitio-devolucion").change(function(){         
       sitioCambiado= $( "#select-sitio-devolucion option:selected" ).val(); 
       var rowCount = $('#tablePortafolioProveedoresAg tr').length;  
       
       if(rowCount>0){
           $('#_alertConfirmationCambiarSitio').modal('show');       
              $('#btnCambiarSitioNo').click(function(){           
                $( "#select-sitio-devolucion" ).val(sitioSeleccioando);
                $('#_alertConfirmationCambiarSitio').modal('hide');   
              });
              
              $('#btnCambiarSitioSi').click(function(){           
                actualizaPortafolio();
                $('#_alertConfirmationCambiarSitio').modal('hide'); 
              });
              
       }else{
           actualizaPortafolio();
       }
    });
    
  
    
    function actualizaPortafolio(){
         
        var codigositio = $('#select-sitio-devolucion').val();        
        var nombreSitio = $('#select-sitio-devolucion option:selected').text();
        var desAlmacen = $("#select-sitio-devolucion option:selected").attr('data-almacen');
        var ubicacion = $("#select-sitio-devolucion option:selected").attr('data-ubicacion');
        var zona=$("#select-sitio-devolucion").attr('data-zona-ventas');
        var cliente=$("#select-sitio-devolucion").attr('data-cliente');
            
        
        $.ajax({
            data: {
                "codigositio": codigositio,                
                "nombreSitio": nombreSitio,             
                "desAlmacen": desAlmacen,
                "ubicacion":ubicacion

            },
            async: false, 
            url:  'index.php?r=Pedido/AjaxSetSitioTipoVenta',
            type: 'post',
            beforeSend: function() {
                $("#img-cargar-rutas").html('<img alt="" src="images/loaders/loader9.gif">');
            },
            success: function(response) {               
             
                if($("#txtProveedores").val()!="" && $("#txtProveedores").val()!=""){
                    
                        var CodigoMotivoDevolucion = $("#txtMotivo").val();
                        var zonaVentas = $("#txtMotivo").attr('data-zona');
                        var cuentaCliente = $("#txtMotivo").attr('data-cliente');
                        var CuentaProveedor = $("#txtProveedores").val() ;

                        $.ajax({
                            data: {
                                "CodigoMotivoDevolucion": CodigoMotivoDevolucion,
                                "cuentaProveedor": CuentaProveedor,
                                "zonaVentas": zonaVentas,
                                "cuentaCliente": cuentaCliente,
                            },
                            async: false, 
                            url: 'index.php?r=Devoluciones/AjaxGetPortafolioProveedor',
                            type: 'post',
                            success: function(response) {
                                if (response != 0) {
                                    $('#contentPortafolioProveedores').html(response);

                                    inicializarDevoluciones();

                                    $('#tablePortafolioProveedores').on('page', function() {
                                        inicializarDevoluciones();
                                    }).dataTable({
                                         "bPaginate": false,
                                        "bSort": false,
                                    });



                                } else {

                                    $.ajax({
                                        url: "index.php?r=Devoluciones/AjaxLimpiarPorafolioProveedor",
                                        type: "post",
                                         async: false, 
                                        success: function(response) {
                                            $("#contentPortafolioProveedores").html("");
                                            $("#contentProductosAgregados").html("");

                                        }
                                    });

                                    $('#_alerta .text-modal-body').html('El motivo no tiene producto en el portafolio');
                                    $('#_alerta').modal('show');
                                }
                            }
                        });                       
                }
               
            }
        });
         
    }
    
    function inicializarDevoluciones(){
         $('.btnItemDevolucion').click(function(){
             var variante=$(this).attr('data-variante');
             
             var CodigoArticulo=$('#CodA-'+variante).text();
             var Codigovariante=$('#CodArt-'+variante).text();
             var Descripcion=$('#Descripcion-'+variante).text();
             var UnidadMedida=$('#UniMed-'+variante).text();
             var Valor=$('#Valor-'+variante).text();
             var Iva=$('#Iva-'+variante).text();   
             var Cantidad=$('#Cantidad-'+variante).val(); 
             var ValorIva=$('#ValorIva-'+variante).val();
              
             $('#mdlDevoluciones #txtCodigoA').val(CodigoArticulo);
             $('#mdlDevoluciones #txtCodigoArticulo').val(Codigovariante);
             $('#mdlDevoluciones #txtDescripcion').val(Descripcion);
             $('#mdlDevoluciones #txtUnidadMedida').val(UnidadMedida);
             
              var valorPrecio = Valor;
              var valorPrecioIva = ValorIva;
              
             
             $('#mdlDevoluciones #txtValor').val(valorPrecio);   
             $('#mdlDevoluciones #txtPorcentajeIva').val(Iva);
             $('#mdlDevoluciones #txtValorIva').val(parseFloat(Math.round(valorPrecioIva * 100) / 100).toFixed(2));
             
             if(Cantidad>0){
                 $('#mdlDevoluciones #txtCantidad').val(Cantidad);
             }else{
                  $('#mdlDevoluciones #txtCantidad').val('');
                  $('#mdlDevoluciones #txtCantidad').focus();
             }
             
             $('#mdlDevoluciones').modal('show');
          });
    }    
    
    $('#adicionarProductoDevolucion').click(function(){
        
        $("#cargando").css("display", "inline");
         
        
        var Codigovariante=$('#mdlDevoluciones #txtCodigoArticulo').val();
        var Descripcion=$('#mdlDevoluciones #txtDescripcion').val();
        var UnidadMedida=$('#mdlDevoluciones #txtUnidadMedida').val();
        var Valor=$('#mdlDevoluciones #txtValor').val(); 
        var Cantidad=$("#mdlDevoluciones #txtCantidad").val();
        
         if(Cantidad==""){            
             $('#_alerta .text-modal-body').html('La cantidad digitada no puede ser vacia.');
             $('#_alerta').modal('show');
             $("#mdlDevoluciones #txtCantidad").val('');
             $("#mdlDevoluciones #txtCantidad").focus();
             
             return false;
        }
        
        if(Cantidad=="0"){            
             $('#_alerta .text-modal-body').html('La cantidad digitada no puede ser "0".');
             $('#_alerta').modal('show');
             $("#mdlDevoluciones #txtCantidad").val('');
             $("#mdlDevoluciones #txtCantidad").focus();
             
             return false;
        }
        
        if(!$.isNumeric(Cantidad)){
            
             $('#_alerta .text-modal-body').html('La cantidad digitada no es valida');
             $('#_alerta').modal('show');
             $("#mdlDevoluciones #txtCantidad").val('');
             $("#mdlDevoluciones #txtCantidad").focus();
             
             return false;
        }
        
        $.ajax({
            data: {
                "Codigovariante":Codigovariante,
                "Descripcion": Descripcion,
                "UnidadMedida": UnidadMedida,
                "Valor": Valor,
                "Cantidad":Cantidad
            },
            url: 'index.php?r=Devoluciones/AjaxSetProductosDevolucion',
            type: 'post',
            success: function(response) {
                
                $("#cargando").css("display", "none");
               $('#contentPortafolioProveedores').html(response); 
                    
                    inicializarDevoluciones();
                    
                    $('#tablePortafolioProveedores').on( 'page',   function () { 
                        inicializarDevoluciones();                    
                    } ).dataTable({ 
                         "bPaginate": false, 
                        "bSort": false,                        
                    });
                    
                  mostrarAgregados();                    
            }
        });
        
    });
    
    
    
   function mostrarAgregados(){
       
        $.ajax({         
            url: 'index.php?r=Devoluciones/AjaxSetProductosDevolucionAgregados',
            type: 'post',
            success: function(response) {                
                $('#contentProductosAgregados').html(response);
                 inicializarDevoluciones();   
                inicializarEliminar();
                 $('#mdlDevoluciones').modal('hide');
            }
        });
       
   }
   
   
   function inicializarEliminar(){
        var variante="";
        $('.delete-item-devoluciones').click(function(){            
            $('#_alertConfirmationEliminar').modal('show');            
            variante=$(this).attr('data-variante');             
        });  
        
        $('#btnEliminarItem').click(function(){            
            $.ajax({
                data:{
                  "CodigoVariante":variante  
                },
                url: 'index.php?r=Devoluciones/AjaxEliminarDevolucionAgregados',
                type: 'post',
                success: function(response) {                
                    $('#contentProductosAgregados').html(response);
                    $('#_alertConfirmationEliminar').modal('hide');   
                    inicializarEliminar();
                    inicializarPortafolio();                   
                }
            });
        });
        
   }
   
   
   
   function inicializarPortafolio(){
       
       $.ajax({               
                url: 'index.php?r=Devoluciones/AjaxGetProductosDevolucionAgregados',
                type: 'post',
                success: function(response) {                
                      $('#contentPortafolioProveedores').html(response); 
                    
                    inicializarDevoluciones();
                    
                    $('#tablePortafolioProveedores').on( 'page',   function () { 
                        inicializarDevoluciones();                    
                    } ).dataTable({ 
                         "bPaginate": false, 
                        "bSort": false,                        
                    });
                    
                    mostrarAgregados();
                }
            });
       
   }
   
 
 
  $('#btnConfirmarEnviar').click(function(){
           
      if(!$('#txtProveedores').val()){
            $('#_alerta .text-modal-body').html('No se ha seleccionado un proveedor');
            $('#_alerta').modal('show');
            return false;
      }
      
       if(!$('#txtMotivo').val()){
            $('#_alerta .text-modal-body').html('No se ha seleccionado un Motivo');
            $('#_alerta').modal('show');
            return false;
      }
      
      var rowCount = $('#tablePortafolioProveedoresAg tr').length;
      
           
      if(rowCount==0){
           $('#_alerta .text-modal-body').html('No se ha adicionado productos a la devolución');
           $('#_alerta').modal('show');
           return false;
      }
      
      $('#_alertEnviarDevolucion').modal('show');      
      
   
  });  
  
  $('#btnEnviarDevolucionSi').click(function(){
    $('#formDevoluciones').submit();  
  });
          
  $("#txtCantidad").keypress(function(tecla) {
    //if(tecla.charCode < 48 || tecla.charCode > 57) return false;
    
    var ev =(tecla.which)? tecla.which : tecla.keyCode; 

        if((tecla.keyCode != 9) && (tecla.keyCode != 8) && (tecla.keyCode != 127)) 
        { 
        return (ev < 48 || ev > 57) ? false:true; 
        }  
    
  });
  
  $('#retornarMenu').click(function(){
    var zona=$(this).attr('data-zona');
    var cliente=$(this).attr('data-cliente');    
    
    $('#_alertConfirmationMenu .text-modal-body').html('Desea salir del módulo de devoluciones.');
    $('#_alertConfirmationMenu').modal('show');
    
});



    

