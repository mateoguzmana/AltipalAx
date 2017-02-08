  
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenuNoventas"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        No Ventas <span></span></h2>      
</div>

<?php if(Yii::app()->user->hasFlash('succes')):?>
 
<?php $this->renderPartial('//mensajes/_alertaSucessNoVenta',array('zonaVentas'=>$zonaVen['CodZonaVentas'], 'cuentaCliente'=>$clien['CuentaCliente']));?>      

<?php endif; ?>

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
                                    <input type="hidden"  name="horanoventa"  value="<?php  echo date('H:i:s');?>">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Código Zona de Ventas:</label>
                                        <div class="col-sm-8">
                                            <input type="text"   class="form-control" readonly="true" value="<?php echo $zonaVen['CodZonaVentas']; ?>" id="codzona" name="codzona"/>
                                        </div>
                                    </div>
                                        
                                    <div class="form-group">    
                                        <label class="col-sm-4 control-label">Nombre Zona Ventas:</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" readonly="true" value="<?php echo $zonaVen['NombreZonadeVentas']; ?>" id="nombrezona" name="nombrezona" style="height: 27px;"/>
                                        </div>
                                    </div>
                                    
                                     <div class="form-group">
                                        <label class="col-sm-4 control-label">Código Asesor:</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" readonly="true" value="<?php echo $asesor['CodAsesor']; ?>" id="codasesor" name="codasesor"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nombre Asesor:</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" style="height: 27px;" readonly="true" value="<?php echo $asesor['Nombre']; ?>" id="nombreasesro" name="nombreasesro"/>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Cuenta Cliente:</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" readonly="true" value="<?php echo $clien['CuentaCliente']; ?>" id="cuenta" name="cuenta"/>
                                        </div>
                                    </div>    
                                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nombre Cliente:</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" readonly="true" value="<?php echo $clien['NombreCliente']; ?>" id="nombrecliente" name="nombrecliente"/>
                                        </div>

                                    </div>
                                    
                                     <div class="form-group">
                                        <label class="col-sm-4 control-label">Establecimiento:</label>
                                        <div class="col-sm-8">
                                            <input type="text"  class="form-control" readonly="true" value="<?php echo $clien['NombreBusqueda']; ?>"/>
                                        </div>

                                    </div>
                                    
                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Motivo no venta:</label>
                                        <div class="col-sm-8">
                                            <?php
                                            $models = Motivosnoventa::model()->findAll();
                                            $list = CHtml::listData($models, 'CodMotivoNoVenta', 'Nombre');

                                            echo CHtml::dropDownList('txtmotivonoventa', '', $list, array(
                                                'prompt' => 'Seleccione un motivo no venta',
                                                'class' => 'form-control',
                                                'name'=>'txtmotivonoventa',
                                                'id' => 'txtmotivonoventa',
                                                'onchange' => 'oe()',
                                                'ajax' => array(
                                                    'type' => 'POST',
                                                    'data' => array('Interfaz' => 'js:this.value'),
                                            )));
                                            ?>
                                        </div>
                                        <div class="col-sm-offset-6">
                                            <div id="ErrorNoventa"></div>
                                        </div>

                                    </div>
                                    
                                    
                                    
                                    <div  class="row">
                                        <div class="col-sm-6 col-sm-offset-5">
                                                      <button class="btn btn-primary">Guardar</button>  
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

<?php $this->renderPartial('//mensajes/_alertConfirmationMenu', array('zonaVentas'=>$zonaVen['CodZonaVentas'], 'cuentaCliente'=>$clien['CuentaCliente']));?>
 
<?php $this->renderPartial('//mensajes/_alertConfirmation');?>
<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>
 