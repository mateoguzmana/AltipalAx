  
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenuGestionNoventas"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        No Ventas <span></span></h2>      
</div>


<?php if(Yii::app()->user->hasFlash('succes')):?>
 
<?php $this->renderPartial('//mensajes/_alertaGestionSucessNoVenta',array('zonaVentas'=>$zonaVen['CodZonaVentas']));?>      

<?php endif; ?>

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-btns">            
                
            </div>
            

        </div>
        
        
        <input type="hidden" value="<?php echo $zonaVen['CodZonaVentas'] ?>" id="ZonaVentas">
        <input type="hidden" value="<?php echo $clien['CuentaCliente'] ?>" id="Cliente">

        <div class="panel-body" style="min-height: 450px;">

            <div class="widget widget-blue">

                <div class="widget-content">

                    <form id="formGestionNoventas" class="form-horizontal" method="post" action="" >

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


<div class="modal fade" id="alertaCarteraPendiente" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Recaudos</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary btn-small-template" id="btnRecibosCajaNoVentas">OK</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertaFrmRecibosCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Recibos de caja</h5>
            </div>
            <div class="modal-body">
                <div class="row">                   
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Código Cliente</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" readonly="readonly" class="form-control" value="<?php echo $datosCliente['CuentaCliente'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Razón Social</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly"class="form-control" value="<?php echo $datosCliente['NombreBusqueda'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contacto</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['NombreCliente'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dirección</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['DireccionEntrega'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Teléfono</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['Telefono'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Forma de Pago</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['DescripcionFormaPago'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo Negocio</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['TipoNegocio'];?>">
                            </div>
                          </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                  <div class="form-group">
                            <label class="col-sm-3 col-sm-offset-2 control-label">Recaudar Factura:</label>
                            <div class="col-sm-2">
                              <div class="">
                                 <label>Si</label>
                                
                                 <input type="radio" name="radio" value="2" id="recaudarFacturaSiNoVenta" data-cuentaCliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-zonaVenta="<?php echo $zonaVentas;?>" >
                                 
                              </div>
                            </div>
                            
                             <div class="col-sm-2">
                              <div class="">
                                
                               <label>No</label>
                                <input type="radio" name="radio" value="2" id="recaudarFacturaNoVenta">
                                 
                              </div>
                            </div>
                            
                          </div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertaFrmRecibosCajaNo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">NO RECAUDOS</h5>
            </div>
            
            <form  action="" id="frmNoRecaudos" method="post">
            <div class="modal-body">
                <div class="row">   
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-sm-6">
                                <input name="noRecaudos[Fecha]" id="FechaNoRecaudo" type="text" placeholder="" id="" required class="form-control" readonly="readonly" value="<?php echo date('Y-m-d');?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha Próxima Visita</label>
                            <div class="col-sm-6">
                              <input name="noRecaudos[FechaProximaVisita]" id="FechaProximaVisita" type="text" placeholder="" id="datepicker" class="form-control datepicker"  value="">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 required control-label">Motivo</label>
                            <div class="col-sm-6">
                             
                                <select class="form-control" name="noRecaudos[Motivo]" id="sltMotivoDevolucion">
                                  <option value="">Seleccione un motivo de no recaudo</option>
                                  <?php foreach ($motivosgestiondecobros as $item):?>                                  
                                  <option value="<?php echo $item['CodMotivoGestion'];?>"> <?php echo $item['Nombre'];?></option>
                                  <?php endforeach;?>
                              </select>
                            </div>
                          </div>
                        
                          <div class="form-group">
                            <label class="col-sm-3  control-label">Observación</label>
                            <div class="col-sm-6">
                                <textarea name="noRecaudos[Observaciones]" id="txtObservacionNoRecaudo" class="col-sm-12 txtAreaObservaciones" placeholder="Máximo 50 caracteres"></textarea>
                            </div>
                          </div>
                        
                       
                    </div>
                </div>

            </div>
                
           
            <div class="modal-footer">
                  <div class="form-group">
                            
                             <div class="col-sm-12">
                                 
                                <button class="btn btn-primary">Guardar</button>
                                <a class="btn btn-default" id="btnCancelarNoRecaudo">Cancelar</a>
                                 
                             
                            </div>
                            
                          </div>
            </div>
          </form>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<?php $this->renderPartial('//mensajes/_alertConfirmationMenuGestionClientesNoventas', array('zonaVentas'=>$zonaVen['CodZonaVentas']));?>
<?php $this->renderPartial('//mensajes/_alertConfirmation');?>
<?php $this->renderPartial('//mensajes/_alertSucess');?> 


<?php
$Nit = Consultas::model()->getNitcuentacliente($datosCliente['CuentaCliente']);

$facturasCliente=  Consultas::model()->getFacturasCliente($Nit[0]['Identificacion']);

$facturasClienteZona=  Consultas::model()->getFacturasClienteZona($Nit[0]['Identificacion']);

 foreach ($facturasClienteZona as $item){
     
    $fechaActual=  date('Y-m-d'); 
    $Dias = Consultas::model()->getDiasAdicionaGraciasCliente($item['CuentaCliente'],$item['CodZonaVentas']);
     
     $diasGracia =  $Dias[0]['diasgracia'];
       
    $fecha = date_create($item['FechaVencimientoFactura']);
    date_add($fecha, date_interval_create_from_date_string($diasGracia.'days'));
    $diasGraciaFecha= date_format($fecha, 'Y-m-d');
     
 }

$totalNoRecaudos=  count($noRecaudos);

$zonaventas = Yii::app()->user->_zonaVentas;
foreach ($facturasCliente as $item){
    
    
    if(trim($zonaventas) == trim($item['CodigoZonaVentas']) &&  trim($datosCliente['CuentaCliente']) == trim($item['CuentaCliente'])){
        
        $contadorzona++; 
         
    }
     
}
 

if($totalNoRecaudos==0 && $tipoPago['AplicaContado']=="falso" && $fechaActual>$diasGraciaFecha && $contadorzona > 0){
?>
 
<script>
$(document).ready(function() {
   <?php 
   $facturamasantigua = Consultas::model()->getFacturaMasAntigua($datosCliente['CuentaCliente']); 
   ?> 
   $('#alertaCarteraPendiente #mensaje-error').html('Recuerde que este cliente presenta cartera vencida, por favor hacer la gestión de cobro de la factura: <?php echo $facturamasantigua[0]['NumeroFactura']; ?>  (<?php echo $facturamasantigua[0]['FechaFactura']; ?>)'); 
   $('#alertaCarteraPendiente').modal('show');   

});

</script>
<?php } ?>


<?php if(Yii::app()->user->hasFlash('success')):?>
<script>    
    $(document).ready(function() {
    $('#_alertaSucess #msg').html('Mensaje');  
    $('#_alertaSucess #sucess').html('<?php echo Yii::app()->user->getFlash('success'); ?>');
    $('#_alertaSucess').modal('show');
     });
</script>   
<?php endif; ?>

