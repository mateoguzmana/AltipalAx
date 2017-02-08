<div class="contentpanel">
    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">
            <div class="panel-heading">                
            </div>
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-3 col-md-offset-4 text-center">
                            <div class="form-group">
                                <label>Supervisores</label>
                                <div>
                                    <select id="selectchosensupervisores" name="Supervisores" class="form-control chosen-select onchenSupervisor" data-placeholder="Seleccione un supervisor">
                                         <option value=""></option>
                                         <?php
                                         $cedula = Yii::app()->user->_cedula;
                                         if($cedula == '11200'){
                                         ?>
                                         <option value="1">Todos</option>
                                          <?php
                                          foreach($supervisores as $itemSuper){
                                         ?>
                                          <option value="<?php echo  $itemSuper['NombreEmpleado'] ?>"><?php echo $itemSuper['NombreEmpleado'] ?></option>
                                          <?php } }else{ ?>
                                          <option value="<?php echo  $itemSuper['NombreEmpleado'] ?>"><?php echo $itemSuper['NombreEmpleado'] ?></option>
                                          <?php }  ?>
                                    </select>
                                </div>
                            </div>
                        </div>  
                    </div>
                     <div class="row">
                        <div class="col-md-3 col-md-offset-4 text-center">
                            <div class="form-group">
                                  <label>Mensaje</label>
                                  <textarea class="form-control" rows="5" maxlength="255" placeholder="Digite el mensaje" id="mensaje"></textarea>
                            </div>
                        </div> 
                    </div>                    
                    <div class="row">
                   <div id="vistaenviuarmensaje"></div>
                    </div>                   
                   <div class="row">
                   <div id="zonaaenviarmensaje"></div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>