<?php
$session = new CHttpSession;
$session->open();
$session['TrnasAutoForm'] = "";


if(isset($session['TotalTransferencia'])){
    
    $transferencia = $session['TotalTransferencia'];
    echo $session['TotalTransferencia'];
    print_r($session['TotalTransferencia']);
}

?>
<input type="hidden" value="<?php echo $transferencia['totalTranferencia'] ?>">
<style>
    #tableDetail{
        width: 100% important;
    }   
</style>

<div class="pageheader">
    <h2>
        <a style="text-decoration: none;"  onclick="salir()">
            <img src="images/home.png" class="cursorpointer" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        </a>
        Transferencia Autoventa<span></span></h2>      
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>

    <?php $this->renderPartial('//mensajes/_alertSucessTransferenciaAutoventa'); ?>    
    

<?php endif; ?>



<div class="contentpanel">

    <div class="panel panel-default">

        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">                         
                            </div>
                            <div class="panel-body panel-body-nopadding">

                                <div id="validationWizardTrnasFerencia" class="basic-wizard">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#vtab1" data-toggle="tab"><img style="width: 24px; padding-right: 2px;" src="images/pedido.png">ENCABEZADO</a></li>
                                        <li><a href="#vtab2" data-toggle="tab"><img style="width: 24px; padding-right: 2px;" src="images/detalle.png">DETALLE</a></li>

                                    </ul>

                                    <form class="form" id="formTranferenciaAutoventa" method="post" action="" >  
                                        <div class="tab-content">

                                            <div class="tab-pane" id="vtab1">

                                                <input type="hidden"  name="horatranfeautoventa"  value="<?php  echo date('H:i:s');?>">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Código zona venta</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="zona" name="zona" data-codigo="<?php echo $zonaVentas; ?>"  class="form-control" readonly="true" value="<?php echo $zonaVentas; ?>"/>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Nombre zona venta</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="nombrezona" name="nombrezona" style="height: 29px;" class="form-control" readonly ="true" value="<?php echo $informacion['NombreZonadeVentas']; ?>"/>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Código asesor</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="codasesor" name="codasesor"  class="form-control" readonly ="true" value="<?php echo $informacion['CodAsesor']; ?>"/>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Nombre asesor</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="nombreasesor" name="nombreasesor"  class="form-control" readonly ="true" value="<?php echo $informacion['Nombre']; ?>"/>

                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Fecha</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" name="fechaEntrega"  class="form-control"  id="fecha" value="<?php echo date('Y-m-d'); ?>"  readonly ="true"/>

                                                    </div>
                                                </div>

                                                <?php 
                                                
                                               $CodUbicacionRemitente = Consultas::model()->getCodUbicacionaRemitente($zonaVentas);
                                               
                                               foreach ($CodUbicacionRemitente as $iteRemitente){
                                               
                                                ?>  
                                                <input type="hidden" name="CodUbicacionRemitente" id="CodUbicacionRemitente" value="<?php echo $iteRemitente ?>"/>
                                               <?php } ?>
                                                
                                                <div class="form-group"> 
                                                    <label class="col-sm-4 control-label">Código zona a transferir </label>
                                                    <div class="col-sm-8">
                                                        <?php
                                                        $grupo = Consultas::model()->getGrupoventa($zonaVentas);
                                                        $alma = Consultas::model()->getAlmacen($zonaVentas);

                                                        foreach ($grupo as $itemgrupo) {


                                                            $grupoventa = $itemgrupo;
                                                        }

                                                        foreach ($alma as $itealamcen) {

                                                            $almacen = $itealamcen;
                                                        }

                                                        $zonasatransferir = Consultas::model()->getSelectTransaccion($grupoventa, $almacen, $zonaVentas);
                                                        ?>
                                                        <select name="codzonatransferencia" class="form-control" id="codzonatransferencia" required>
                                                            <option value="">Seleccione una zona a transferir</option>
                                                            
<?php
foreach ($zonasatransferir as $trasnferncia) {
    ?>
                                                                <option value="<?php echo $trasnferncia['CodZonaVentas']; ?>"><?php echo $trasnferncia['CodZonaVentas']; ?> -- <?php echo $trasnferncia['NombreZonadeVentas']; ?></option>
                                                                <?php
                                                            }
                                                            ?> 
                                                        </select>

                                                    </div>
                                                </div>

                                                <div id="codubicacion"></div>
                                                  

                                            </div>
                                            <div class="tab-pane" id="vtab2">

                                                <div class="row">
                                                    <div class="col-md-2 col-lg-offset-10">

                                                        <img src="images/add_productos.png" style="width: 40px;" class="cursorpointer" id="adicionar-portafolio" title="Adicionar Producto"/>
                                                        <br/>
                                                        <small>Adicionar</small>
                                                    </div>
                                                </div>

                                                <div class="mb20"></div>

                                                <div class="row" id="datos">                          
                                                    <div class="table-responsive" id="tableDetail">
                                                        <table class="table table-bordered" id="tableDetail">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Código Artículo</th>
                                                                    <th>Descripción</th>                    
                                                                    <th>Cantidad</th>
                                                                    <th>Lote</th>
                                                                    <th></th>
                                                                    <th></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            </div>


                                        </div>

                                        <ul class="pager wizard">
                                            <li class="previous"><a href="javascript:void(0)">Anterior</a></li>
                                            <li class="next"><a href="javascript:void(0)">Siguiente</a></li>
                                            <div id="bt">

                                            </div>
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



<div class="modal fade" id="portafolio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">PORTAFOLIO</h4>
            </div>
            <div class="modal-body mdlPortafolio">

                <table class="table table-bordered" id="tblPortafolio">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>


                            </th>                      
                        </tr>
                    </thead>
                    <tbody>
<?php
$cont=1;
foreach ($portafolioZonaVentas as $itemPortafolio) {
    //$modal = Consultas::model()->getAddAtoventas($itemPortafolio['CodigoVariante'], $informacion['CodAsesor'], $zonaVentas);
    $modal = Consultas::model()->getAddAtoventas($itemPortafolio['CodigoVariante']);
    if ($modal['PrecioVenta'] != "0") {
    ?>
                            <tr data-id-inventario="<?php echo $itemPortafolio['IdSaldoInventario']; ?>" data-nuevo="<?php
                            if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                                echo '1';
                            } else {
                                echo '0';
                            }
                            ?>" data-agregado="1"  <?php
                            

                           
                            ?> class="adicionar-producto-detalle-transaccion cursorpointer"  data-zona="<?php echo $zonaVentas; ?>" data-codigo-variante="<?php echo $itemPortafolio['CodigoVariante']; ?>" data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-articulo="<?php echo $itemPortafolio['CodigoArticulo']; ?>" data-grupo-ventas="<?php echo $itemPortafolio['CodigoGrupoVentas']; ?>" data-CodigoUnidadMedida-saldo="<?php echo $itemPortafolio['CodigoUnidadMedida']; ?>">
                                <td style="width: 15%;">

                                <?php
                                if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                                    ?>
                                        <img data-producto-nuevo="1" id="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pronuevo.png" />
                                        <?php
                                    } else {
                                        ?>
                                        <img data-producto-nuevo="0" id="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />
                                        <?php
                                    }
                                    ?>                        
                                </td>

                                <td >
                                   
    <?php
    echo $cont.') ';
    $cont++;
    echo $itemPortafolio['CodigoVariante'];
    ?>                         
                                                        
                                    <br/>

                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                </td>
                                <td style="width: 10%;">

                                    <a href="javascript:addPoducto('<?php echo $itemPortafolio['CodigoVariante'] ?>')" class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></a> 

                                </td>
                            </tr>
    <?php
     }
}
?>
                    </tbody>


                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
            </div>
        </div>
    </div>
</div>







<div class="modal fade" id="alertaTransferencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Tranferencia Autoventa</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="glyphicon glyphicon-ok-sign" style="font-size: 40px; color: green;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">Transferencia realizada correctamente!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal" onclick="ok()">Aceptar</button>        
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="articuloPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span id="textDetCodigoProducto" class="text-primary"></span><span id="textDetNombreProducto"></span></h4>
            </div>
            <div class="modal-body">


            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="alertaErrorLote" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: red;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error-lote"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="alertaErrorValidar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error-transaccion"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="alertaElimindado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p id="mensaje-error" class="text-modal-body">Artículo eliminado satisfactoriamente de la transferencia autoventa!</p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-small-template" id="btn-aceptar-ACDL-Transaccion" data-dismiss="modal">Aceptar</button>     

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="alertaCantidad" tabindex="3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">"La cantidad pedida no puede ser superior al lote seleccionado</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>



<?php $this->renderPartial('//mensajes/_alertConfirmationMenuTransAuto');?>
<?php $this->renderPartial('//mensajes/_alertaConfirmationTransferenciaAutoventa');?>
<?php $this->renderPartial('//mensajes/_alertConfirmationDeleteTrnasAuto');?>
<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>



<script>

    $(document).ready(function() {

        $("#txtAreaObservaciones").keypress(function() {
            var limit = 50;
            var text = $(this).val();
            var chars = text.length;
            if (chars > limit) {
                var new_text = text.substr(0, limit);
                $(this).val(new_text);
            }
        });
    });

</script>