<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">

            <div class="panel-heading">
                
            </div>




            <div class="widget widget-blue">


                <div class="widget-content">
                    
                     <div class="row">
                        <div class="col-md-4 col-md-offset-2 text-center">
                            <div class="form-group">
                                <label>Fecha Inicial</label>
                                <div  aling="center">
                                    <input style="height: 36px;" type="text"  class="form-control fechareport" id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                                 </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control fechareport"  id='fechafin' value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                         
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 col-md-offset-4 text-center">
                            <div class="form-group">
                                <label>Agencia</label>
                                <div>
                                    <select id="selectchosenagencia" name="agencia" class="form-control chosen-select onchenAgenciaMensaje" data-placeholder="Seleccione una agencia">
                                         <option value=""></option>
                                          <?php foreach($agencia as $itemagencia){ ?>
                                          <option value="<?php echo  $itemagencia['CodAgencia'] ?>"><?php echo $itemagencia['Nombre'] ?></option>
                                          <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>  
                    </div>
                    
                    
                    <div class="row">
                   <div id="zonaaenviarmensaje"></div>
                   </div>
                  
                </div>
            </div>

        </div>
    </div>      



</div>

<?php $this->renderPartial('//mensajes/_alerta');?> 
 