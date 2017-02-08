<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">            
                
            </div>
            

        </div>


        <div class="panel-body" style="min-height: 450px;">

            <div class="widget widget-blue">

                <div class="widget-content">

                    <form id="formNoventas" class="form-horizontal" method="post" action="" >

                        <div class="mb30"></div>

                        <div class="col-sm-8 col-sm-offset-2">

                            <div class="panel panel-primary panel-alt widget-newsletter">

                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Agencia:</label>
                                        <div class="col-sm-6">
                                            <select id="SelectAgencia" name="Agencia" class="form-control chosen-select  onchaZonaVentas" data-placeholder="Seleccione una agencia">
                                                <option value=""></option>
                                                <?php foreach ($Agencias as $tiem){ ?>
                                                <option value="<?php  echo $tiem['CodAgencia'] ?>"><?php echo $tiem['Nombre'] ?></option>
                                                
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                     <div id="ErroAgencia" class="col-md-offset-5"></div>
                                        
                                    <div class="form-group">    
                                        <label class="col-sm-4 control-label">Zona Ventas:</label>
                                        <div class="col-sm-6">
                                            <div id="zonaventas" class="cargarFecha">
                                            <select id="SelectZonaVentas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona ventas">
                                                <option value=""></option>
                                            </select>
                                            </div>  
                                        </div>
                                    </div>
                                     <div id="ErrozonaVentas" class="col-md-offset-5"></div>
                                    
                                     <div class="form-group">
                                        <label class="col-sm-4 control-label">Fecha Inicial:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control fechapaginaweb" id="fechaini"/>
                                        </div>
                                    </div>
                                     <div id="ErroFechaini" class="col-md-offset-5"></div>
                                     
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Fecha Final:</label>
                                        <div class="col-sm-6">
                                            <input type="text"  class="form-control fechapaginaweb" id="fechafin"/>
                                        </div>
                                    </div>
                                     <div id="ErroFechaFin" class="col-md-offset-5"></div>
                                     
                                     <div class="form-group">
                                        <label class="col-sm-4 control-label">Obervacion:</label>
                                        <div class="col-sm-8">
                                            <textarea id="observacion" rows="4" style="width: 320px;"></textarea>
                                        </div>
                                    </div>
                                      <div id="ErroObser" class="col-md-offset-5"></div>
                                    
                                    <div  class="row">
                                        <div class="col-sm-6 col-sm-offset-5">
                                            <input type="button" class="btn btn-primary" id="GuardarPermisos" value="Guardar"> 
                                        </div>
                                     </div>
                                   
                                </div>

                            </div>


                        </div>



                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

<?php $this->renderPartial('//mensajes/_alertaSuccesPermisosPaginaWeb');?> 
<?php $this->renderPartial('//mensajes/_alerta');?> 