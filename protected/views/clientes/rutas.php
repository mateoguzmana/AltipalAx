


<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Rutas <span></span></h2>      
</div>
 

<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-heading">           
            <h4 class="panel-title">Seleccione la Ruta a descargar</h4>
        </div>
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">    
                <div class="widget-content">                    
                    <form class="form-inline" method="post" action="index.php?r=Clientes/ClientesRutas" id="frmRutas">                            
                    <div class="mb30"></div>      
                    <div class="row" <?php  if($codigoAsesor && $zonaVentas) { echo 'style="display:none;"';}?>>
                        <div class="col-sm-8 col-sm-offset-2">                            
                        <div class="panel panel-primary panel-alt widget-newsletter">                        
                          <div class="panel-body">    
                                <div class="form-group">                       
                                    <input type="text" style="width: 140px;" value="<?php if($codigoAsesor){ echo $codigoAsesor;} ?>"  placeholder="Codigo Asesor" id="codigoAsesor" class="form-control" name="codigoAsesor" />
                                </div>
                                <div class="form-group">                         
                                  <input type="text" style="width: 250px;" placeholder="Nombre Asesor" id="nombreAsesor" class="form-control" name="nombreAsesor"/>
                                </div>                              
                                <div class="form-group">   
                                  <select name="zonaVentas" id="select-zona-ventas" style="width: 200px;" class="form-control">
                                      <option>Selecionar zona de ventas</option>
                                       <?php if($zonaVentas){                                         
                                         ?>  
                                         <option value="<?php echo $zonaVentas;?>" selected=""> <?php echo $zonaVentas;?> </option>
                                        <?php 
                                        } 
                                       ?>
                                  </select>                                      
                                </div>
                          </div>
                        </div>      
                       </div>
                    </div>
                    <style>
                        
                    </style>
                    <div class="mb30"></div>    
                    <div class="row">                        
                        <?php   if($rutas==TRUE){ ?>                        
                        <div class="col-sm-12" style="border: 1px solid #eee"> 
                        <table class="table table-hover table-rutero">
                            <thead>
                            <tr>
                                <th colspan="1" style="text-align: right"><div style="font-weight: 100; letter-spacing: 1px; ">RUTA</div> </th>
                                <th colspan="6" style="text-align: left"><input type="text" class="form-control" placeholder="Seleccione una Ruta"  style="width: 150px" readonly="readonly" id="input-ruta" name="numeroRuta" /></th>
                            </tr>
                            <tr>
                                <th class="text-center">Lunes</th>
                                <th class="text-center">Martes</th>
                                <th class="text-center">Miercoles</th>
                                <th class="text-center">Jueves</th>
                                <th class="text-center">Viernes</th>
                                <th class="text-center">Sabado</th>                                
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
                            </tr>
                             <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R2']  ?> </td>
                                        <?php
                                    }
                                    ?>                                          
                            </tr>
                             <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R3']  ?> </td>
                                        <?php
                                    }
                                    ?>                                        
                            </tr>
                             <tr>
                                <?php
                                    foreach ($frecuenciaVisita as $itemVisita) {
                                        ?>
                                        <td class="text-center"> <?php echo $itemVisita['R4']  ?> </td>
                                        <?php
                                    }
                                    ?>                                         
                            </tr>
                        </table>   
                         
                        <?php } ?>  
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <input class="btn btn-primary Exportar btn-sm" type="submit" value="Cargar clientes"  style="margin-top: 10px;background-color: #24D29B;border: solid 2px; #24D29B; border-radius: 5px;">
                        </div>
                    </div>  
                     </form>                      
                </div>
            </div>
        </div>
    </div>  
</div>

<?php $this->renderPartial('//mensajes/_alerta');?>
<?php $this->renderPartial('//mensajes/_alertConfirmationMenuFuerzasVentas');?>


<script>
  $(function() {
         
      
     if (typeof history.pushState === "function") {
    history.pushState("jibberish", null, null);
    window.onpopstate = function() {
        history.pushState('newjibberish', null, null);
        // Handle the back (or forward) buttons here
        // Will NOT handle refresh, use onbeforeunload for this.
        };
    }
    else {
        var ignoreHashChange = true;
        window.onhashchange = function() {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
            }
            else {
                ignoreHashChange = false;
            }
        };
    } 
      
     $('#retornarMenu').click(function(){        
            var zona=$(this).attr('data-zona');
            var cliente=$(this).attr('data-cliente');    

            $('#_alertConfirmationMenu .text-modal-body').html('Desea salir de la selección rutas?');
            $('#_alertConfirmationMenu').modal('show');
     });   
      
     $(".table-rutero td").click(function(){        
          var ruta=$(this).text();        
         $("#input-ruta").val(ruta);           
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
            url: 'index.php?r=Pedido/AjaxCompletarFormAsesor',
            type: 'post',
            beforeSend: function() {
                $load = '<img id="imagenGif" src="images/loaders/loader9.gif"> Completando campos...';
                $("#loading2").html($load);
            },
            success: function(response) {
               
                //var obj = $.parseJSON(response);
                response=$.parseJSON(response);
                var codigoAsesor='';
                var nombreAsesor='';
                
                
                var cadena='<option>Selecionar zona de ventas</option>';
                $.each(response, function(i, item) {                     
                      cadena+='<option value="'+response[i].CodZonaVentas+'">'+response[i].CodZonaVentas+'</option>';                     
                      if(response[i].CodAsesor){
                        codigoAsesor=response[i].CodAsesor;
                      }                      
                      if(response[i].Nombre){
                        nombreAsesor=response[i].Nombre;
                      }
                      
                });
                
               $('#select-zona-ventas').html(cadena);
               
               if(codigoAsesor!=""){                 
                    $( "#codigoAsesor" ).val(codigoAsesor);
                }
                
                if(nombreAsesor!=""){                   
                    $( "#nombreAsesor" ).val(nombreAsesor);
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