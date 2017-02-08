


<div class="pageheader">
    <h2><i class="fa fa-truck"></i> Pedidos Preventa<span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">            
                <a class="minimize maximize" href="#">+</a>
            </div>
            <h4 class="panel-title">Asesores comerciales</h4>

        </div>
        <div class="panel-body" style="min-height: 450px;">


            <div class="widget widget-blue">
                

                <div class="widget-content">
                    
                    <div class="mb30"></div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            
                        <div class="panel panel-primary panel-alt widget-newsletter">
                        
                          <div class="panel-body">
                              
                            <form class="form-inline" method="post" action="">                            
                                <div class="form-group">                       
                                    <input type="text" style="width: 258px;" placeholder="Codigo Asesor" id="codigoAsesor" class="form-control" name="codigoAsesor" />
                                </div>
                                <div class="form-group">                         
                                  <input type="text" style="width: 280px;" placeholder="Nombre Asesor" id="nombreAsesor" class="form-control" name="nombreAsesor">
                                </div>                        
                                <!--<button class="btn btn-primary" type="submit"><i class="fa fa-truck"></i> Seleccionar Ruta </button>-->                      
                              </form>  
                              
                          </div><!-- panel-body -->
                        </div>    
                            
                            
                       </div>
                        
                    </div>
                    
                    <div class="mb30"></div>
                    
                    <div class="row">
                        
                        <?php   if($rutas==TRUE){ ?>
                        
                        <div class="col-sm-8 col-sm-offset-2">
                        <table class="table table-hover table-rutero">
                            <thead>
                            <tr>
                                <th colspan="6" >Tabla de rutas: </th>
                            </tr>
                            <tr>
                                <th class="text-center">Lunes</th>
                                <th class="text-center">Martes</th>
                                <th class="text-center">Miercoles</th>
                                <th class="text-center">Jueves</th>
                                <th class="text-center">Viernes</th>
                                <th class="text-center">Sabado</th>
                                <th class="text-center">Domingo</th>
                            </tr>
                            </thead>
                            <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R1']  ?> </td>
                                        <?php
                                    }
                                    ?> 
                                        <td class="text-center">--</td>
                            </tr>
                             <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R2']  ?> </td>
                                        <?php
                                    }
                                    ?>  
                                        <td class="text-center">--</td>
                            </tr>
                             <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R3']  ?> </td>
                                        <?php
                                    }
                                    ?> 
                                        <td class="text-center">--</td>
                            </tr>
                             <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R4']  ?> </td>
                                        <?php
                                    }
                                    ?>   
                                        <td class="text-center">--</td>
                            </tr>
                        </table>   
                         
                        <?php } ?>                        
                       
                        </div>
                    </div>
                    

                </div>
            </div>



        </div>
    </div>      



</div>


<script>
  $(function() {
      
     $(".table-rutero td").click(function(){
        
        var ruta=$(this).text();        
        $(this).css('background-color', '#0C4F93');
        
        //alert(ruta);
        
     });
      
      
    var codigos = [
       <?php 
        foreach ($asesoresComerciales as $codigoAsesor){
            echo '"'.$codigoAsesor['CodAsesor'].'",';
        }
       ?>
    ];
    $( "#codigoAsesor" ).autocomplete({
      source: codigos,
      select: function( event, ui ) {
            var codigo=ui.item.value;            
            completarCampos(codigo, '');
          }
    });
    
     var nombres = [
       <?php 
        foreach ($asesoresComerciales as $nombreAsesor){
            echo '"'.$nombreAsesor['Nombre'].'",';
        }
       ?>
    ];
     $( "#nombreAsesor" ).autocomplete({
      source: nombres,
      select: function( event, ui ) {
            var nombre=ui.item.value;
            completarCampos('',nombre);
          }
    });
    
    
     function completarCampos(codigo, nombre){
        
          $.ajax({
            data: {
                "codigoAsesor":codigo ,
                "nombreAsesor": nombre,
            },
            url: 'index.php?r=PedidoPreventa/AjaxCompletarFormAsesor',
            type: 'post',
            beforeSend: function() {
                $load = '<img id="imagenGif" src="images/loaders/loader9.gif"> Completando campos...';
                $("#loading2").html($load);
            },
            success: function(response) {
               
                var obj = $.parseJSON(response);              
               
               if(obj.codigoAsesor){                 
                    $( "#codigoAsesor" ).val(obj.codigoAsesor);
                }
                
                if(obj.nombreAsesor){                   
                    $( "#nombreAsesor" ).val(obj.nombreAsesor);
                }
            }


        });
         
     }
    
  });
  </script>
  
  <style>
    
    .table-rutero td:hover{
        background-color: #FFF !important;
        cursor: pointer;
    }
    
    .ui-menu{
        background-color: #FFF;
        border: 1px solid #ccc;
    }
    
    .ui-menu .ui-menu-item a:focus{
       color: #C7254E;
        border-radius: 0px;
        border: 1px solid #454545;
    }
</style>