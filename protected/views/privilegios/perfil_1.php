<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<?php 
               if(!empty($idPerfil)){                  
                  
                   ?>
                    <script>
                     $( document ).ready(function() {
                       cargarPerfil(<?php echo $idPerfil;?>);
                       
                      });
                    
                    </script>
                   <?php
                   
               }
              ?>
<div class="widget widget-blue">
      <div class="widget-title">
              <div class="widget-controls">
 
</div>
        <h3><i class="icon-table"></i> Perfil</h3>
      </div>
      <div class="widget-content">
          
          <div class="row" style="margin-bottom: 20px;">
               <div class="col-sm-6">
            <div class="form-group">
                <label class="col-md-2 control-label">Perfiles</label>
                <div class="col-md-6">                  
                    
                  <select class="form-control" id="seleccionarPerfil">
                     <option>Selecionar perfil</option>
                     <?php foreach ($perfiles as $itemPerfiles){ ?> 
                     <option  <?php if(!empty($idPerfil)){if($idPerfil==$itemPerfiles['IdPerfil'])echo "selected";} ?>   value="<?php echo $itemPerfiles['IdPerfil'];?>" id="option-perfil-<?php echo $itemPerfiles['IdPerfil'];?>"><?php echo $itemPerfiles['Descripcion']; ?></option>
                     <?php } ?>
                   
                  </select>
                    <br/>
                    <div id="loading2"></div>
                </div>
                
                <div class="col-md-4">
                    <button class="btn btn-primary" id="agregarPrefil">Agregar perfil</button>                    
                </div>
                
              </div>
            </div>    
          </div>
          
          <div id="content-perfil">
              
          </div>
          
      </div>
    </div>




 <div class="modal fade" id="modalAgregarPerfil" tabindex="-1" role="dialog" aria-labelledby="modalFormStyle2Label" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="widget widget-blue">
                        <div class="widget-title">
                           <div class="widget-controls">                            
                               <button type="button" class="btn btn-default btn-round btn-xs" data-dismiss="modal"><i class="icon-remove" style="margin-right:0px;"></i></button>
                          </div> 
                          <h3><i class="icon-ok-sign"></i> Administrar Perfil</h3>
                        </div>
                        <div class="widget-content">
                          <div class="modal-body">

                              <form action="" role="form" method="post" class="form-horizontal">
                              <div class="form-group">
                                <label class="col-md-3 control-label">Perfil</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="perfil['nombrePerfil']" placeholder="Entre el nombre del perfil">
                                </div>
                              </div>
                                  
                              <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <input type="submit" class="btn btn-primary" value="Crear Perfil"/>                                  
                                </div>
                              </div>    
                             
                                  <div class="row">
                                     
                                      
                                      <div class="col-md-10 col-md-offset-1">
                                          
                                           <div id="mensaje-eliminar-perfil"></div>                                          
                                          
                                           <table class="table table-bordered">   
                                      <tr>
                                          <th>Perfil</th>
                                          <th></th>
                                      </tr>
                               <?php foreach ($perfiles as $itemPerfiles){ ?> 
                                      <tr id="tr-eliminar-<?php echo $itemPerfiles['IdPerfil'];?>">
                                          <th><?php echo $itemPerfiles['Descripcion'];?></th>
                                          <th><a class="btn btn-danger btn-xs eliminar-perfil" href="#" data-id="<?php echo $itemPerfiles['IdPerfil'];?>">Eliminar</a></th>
                                      </tr>                                  
                               <?php } ?>
                                 </table>                              
                                          
                                      </div>                                      
                                  </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>