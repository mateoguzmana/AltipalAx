<?php
$session = new CHttpSession;
$session->open();

$codigositio = $session['codigositio'];
$tipoVenta = $session['tipoVenta'];
$nombreSitio = $session['nombreSitio'];
$nombreTipoVenta = $session['nombreTipoVenta'];
$session['pedidoForm'] = "";



$sitios = count($sitiosVentas);
?>

<style>
    #tableDetail{
        width: 100% important;
    }   
    
    .scrolls-y {    
    overflow-y: scroll;
    height: 420px;   
}
</style>

<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Devoluciones <span></span></h2>      
</div>

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-1">
                    <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                </div>
                <div class="col-md-11">
                    <h5> Cuenta:  <span class="text-primary"><?php echo $datosCliente['CuentaCliente']; ?></span></h5>
                    <h5> Nombre: <span class="text-primary"><?php echo $datosCliente['NombreCliente']; ?></span></h5>
                </div>
            </div>
        </div>
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">                         
                            </div>
                            <div class="panel-body panel-body-nopadding">

                                <div id="validationWizard" class="basic-wizard">
                                    <ul class="nav nav-pills nav-justified">
                                        <li>
                                            <a href="#vtab1" data-toggle="tab">
                                                 <img src="images/pedido.png" style="width: 24px; padding-right: 2px;"/>
                                                ENCABEZADO
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#vtab2" data-toggle="tab">
                                                <img src="images/detalle.png" style="width: 24px; padding-right: 2px;"/>
                                                PORTAFOLIO
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#vtab3" data-toggle="tab">
                                                 <img src="images/totales.png" style="width: 24px; padding-right: 2px;"/>
                                                DETALLE
                                            </a>
                                        </li>
                                    </ul>

                                    <form class="form" id="formDevoluciones" method="post" action="">  
                                        <div class="tab-content">

                                            <div class="tab-pane" id="vtab1">


                                                <input type="hidden" name="zonaVentas" value="<?php echo $zonaVentas; ?>"/>                      
                                                <input type="hidden" name="cuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>"/>
                                                <input type="hidden" name="horaInicio" value="<?php echo date('H:i:s'); ?>"/>

                                                <?php
                                                /* echo '<pre>';
                                                  print_r($datosCliente);
                                                  echo '</pre>'; */
                                                ?>
                                                <div class="row">

                                                    <div class="col-sm-8 col-sm-offset-2">

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Zona Ventas</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="txtZonaVentas" required="" placeholder="" value="<?php echo $zonaVentas; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Nombre Zona Ventas</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="txtNombreZonaVentas" required="" placeholder="" value="<?php echo $sitiosVentas[0]['NombreZonadeVentas']; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Cuenta Cliente</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="txtCuentaCliente" required="" placeholder="" value="<?php echo $datosCliente['CuentaCliente']; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Nombre Cliente</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="txtNombreCliente" required="" placeholder="" value="<?php echo $datosCliente['NombreCliente']; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>  
                                                         <div class="form-group">
                                                            <label class="col-sm-3 control-label">Establecimiento</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="txtEstablecimiento" required="" placeholder="" value="<?php echo $datosCliente['NombreBusqueda']; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                         <div class="form-group">
                                                            <label class="col-sm-3 control-label">Teléfono Fijo</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" value="<?php echo $datosCliente['Telefono']; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        
                                                         <div class="form-group">
                                                            <label class="col-sm-3 control-label">Teléfono Movil</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" value="<?php echo $datosCliente['TelefonoMovil']; ?>" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label">Sitio</label>
                                                                <div class="col-sm-6">                         
                                                                   <select name="sitio" class="form-control" required id="select-sitio-devolucion" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>">
                                                                   <?php   
                                                                       if($sitios > 1){ 
                                                                   ?>
                                                                   <option value="">Seleccione un sitio</option>
                                                                   <?php  foreach ($sitiosVentas as $itemSitio){ ?>
                                                                    <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> </option>
                                                                            
                                                                     <?php } }else{ ?> 
                                                                    
                                                                     <?php 
                                                                       if($sitiosVentas){                                  

                                                                           foreach ($sitiosVentas as $itemSitio){   

                                                                       ?>    
                                                                    <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> </option>
                                                                    <?php                                 
                                                                        }
                                                                       }
                                                                     }  
                                                                     ?>      
                                                                  </select>

                                                                    <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Preventa" id="select-sitio-venta"/>   

                                                                </div>
                                                            </div> 
                                                       

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Proveedor</label>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">  


                                                                    <?php
                                                                    foreach ($motivosproveedor as $item) {
                                                                        $subArray[$item['CuentaProveedor']] = $item['NombreCuentaProveedor'];
                                                                    }

                                                                    echo CHtml::dropDownList('proveedor', '', $subArray, array(
                                                                        'prompt' => 'Seleccione un proveedor',
                                                                        'onChange'=>'  

                                                                             $.ajax({            
                                                                                url: "index.php?r=Devoluciones/AjaxLimpiarPorafolioProveedor",
                                                                                type: "post",
                                                                                success: function(response) { 
                                                                                    $("#contentPortafolioProveedores").html(response); 
                    
                                                                                        inicializarDevoluciones();

                                                                                        $("#tablePortafolioProveedores").on( "page",   function () { 
                                                                                            inicializarDevoluciones();                    
                                                                                        } ).dataTable({                     
                                                                                            "bSort": false,                        
                                                                                        });
                                                                                    }
                                                                             });
                                                                        ',
                                                                        'class' => 'form-control',
                                                                        'name' => 'txtProveedor',
                                                                        'required' => 'required',
                                                                        'id' => 'txtProveedores',
                                                                        'ajax' => array(
                                                                            'type' => 'POST',
                                                                            'url' => Yii::app()->createUrl('Devoluciones/AjaxMotivosDevolucion'), //or $this->createUrl('loadcities') if '$this' extends CController
                                                                            'update' => '#txtMotivo', //or 'success' => 'function(data){...handle the data in the way you want...}',
                                                                            'data' => array('CuentaProveedor' => 'js:this.value'),
                                                                    )));
                                                                    ?> 

                                                                </div>
                                                            </div>
                                                        </div>   

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Motivo</label>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">                                                              
                                                                    <?php
                                                                    echo CHtml::dropDownList('txtMotivo', '', array(), array('prompt' => 'Seleccione un Motivo',
                                                                        'class' => 'form-control',                                                                        
                                                                        'name' => 'txtMotivo',
                                                                        'required' => 'required',
                                                                        'data-zona' => $zonaVentas,
                                                                        'data-cliente' => $datosCliente['CuentaCliente']
                                                                    ));
                                                                    ?>  
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Observación</label>
                                                            <div class="col-sm-6">
                                                                <textarea type="text" name="txtObservacion" placeholder="Maximo 50 caracteres"  class="form-control txtAreaObservaciones"></textarea>
                                                            </div>
                                                        </div>


                                                    </div>    
                                                </div>


                                            </div>

                                            <div class="tab-pane" id="vtab2">

                                                <div class="row">

                                                    <div id="contentPortafolioProveedores" class="scrolls-y">
                                                        
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="tab-pane" id="vtab3">

                                                <div class="row">
                                                     <div id="contentProductosAgregados"></div>
                                                </div>
                                                
                                                <div class="mb30"></div>
                                                
                                                                                                
                                            </div>
                                        </div>

                                       

                                    <div class="mb20"></div>                                    

                                    <ul class="pager wizard">
                                        <li class="previous"><a href="javascript:void(0)">Anterior</a></li>
                                        <li>                                           
                                            <!-- <input type="submit" style=" position: absolute; right: 22px; height: 30px; width: 80px; z-index: 1" id="" value="Enviar" class="btn btn-primary"/>-->
                                             <button type="button" style=" position: absolute; right: 22px; height: 30px; width: 80px; z-index: 1" id="btnConfirmarEnviar"  class="btn btn-primary" >Enviar</button>
                                        </li>
                                        <li class="next"><a href="javascript:void(0)" style="position: relative; z-index: 2;">Siguiente</a></li>
                                       
                                    </ul>
                                    </form>
                                </div><!-- #validationWizard -->

                            </div><!-- panel-body -->
                        </div><!-- panel -->
                    </div><!-- col-md-6 -->
                </div>
            </div>
        </div>
    </div>      

</div>


<!-- Modal -->
<div class="modal fade" id="mdlDevoluciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin: 130px auto;  width: 550px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">DEVOLUCIÓN</h4>
            </div>
            <div class="modal-body">
                
<!--                <div class="form-group">
                    <label class="col-sm-3 control-label">Código Artículo</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtCodigoA" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>-->
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">Código Artículo</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtCodigoArticulo" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Descripción</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtDescripcion" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Unidad Medida</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtUnidadMedida" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Valor</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtValor" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">% Iva</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtPorcentajeIva" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">Valor Iva</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtValorIva" placeholder="" class="form-control" readonly="readonly">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-3 control-label">Cantidad</label>
                    <div class="col-sm-9">
                        <input type="text" id="txtCantidad" placeholder="" class="form-control">
                    </div>
                </div>

                <div id="cargando" style="display:none;" class="col-md-offset-5">
                  <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;">
                 Cargando...
                </div>

            </div>
            <div class="modal-footer">       
                <button type="button" class="btn btn-primary" id="adicionarProductoDevolucion">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="_alertConfirmationEliminar" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">¿Realmente desea eliminar este producto de la devolución?</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" id="btnEliminarItem" class="btn btn-primary" type="button">Si</button>   
                <button data-dismiss="modal" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_alertConfirmationCambiarSitio" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">¿Recuerde que si cambia de motivo se eliminaran los productos agregados en la devolución, Desea Cambiar de Sitio.?</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" id="btnCambiarSitioSi" class="btn btn-primary" type="button">Si</button>   
                <button type="button" id="btnCambiarSitioNo" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_alertConfirmationCambiarProveedor" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">¿Recuerde que si cambia de motivo se eliminaran los productos agregados en la devolución, Desea Cambiar de Sitio.?</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" id="btnCambiarProveedorSi" class="btn btn-primary" type="button">Si</button>   
                <button type="button" id="btnCambiarProveedorNo" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="_alertEnviarDevolucion" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                  <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">¿Esta seguro de terminar la devolución?</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" id="btnEnviarDevolucionSi" class="btn btn-primary" type="button">Si</button>   
                <button data-dismiss="modal" type="button" class="btn btn-primary" type="button">No</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->




<?php if(Yii::app()->user->hasFlash('success')):?>
<script>    
    $(document).ready(function() {
    $('#_alertaSucess #msg').html('Mensaje Devolución');  
    $('#_alertaSucess #sucess').html('<?php echo Yii::app()->user->getFlash('success'); ?>');
    $('#_alertaSucess').modal('show');
     });
</script>   
<?php endif; ?>

<?php $this->renderPartial('//mensajes/_alertSucess');?> 
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationMenu', array('zonaVentas'=>$zonaVentas, 'cuentaCliente'=>$datosCliente['CuentaCliente']));?>