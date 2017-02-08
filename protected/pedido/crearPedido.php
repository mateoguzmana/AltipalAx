<?php
$session = new CHttpSession;
$session->open();

$codigositio = $session['codigositio'];
$tipoVenta = $session['tipoVenta'];
$nombreSitio = $session['nombreSitio'];
$nombreTipoVenta = $session['nombreTipoVenta'];
$session['pedidoForm'] = "";
?>

<style>
    #tableDetail{
        width: 100% important;
    }   
</style>

<div class="pageheader">
    <h2><i class="fa fa-truck"></i> Crear Pedido <span></span></h2>      
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
                                        <li><a href="#vtab1" data-toggle="tab">ENCABEZADO</a></li>
                                        <li><a href="#vtab2" data-toggle="tab">DETALLE</a></li>
                                        <li><a href="#vtab3" data-toggle="tab">TOTAL PEDIDO</a></li>
                                    </ul>

                                    <form class="form" id="formPedidos" method="post" action="" >  
                                        <div class="tab-content">

                                            <div class="tab-pane" id="vtab1">


                                                <input type="hidden" name="zonaVentas" value="<?php echo $zonaVentas; ?>"/>                      
                                                <input type="hidden" name="cuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>"/>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Sitio/Almacen</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="select-sitio" data-codigo="<?php echo $codigositio; ?>" required name="sitio" class="form-control" readonly="readonly" value="<?php echo $nombreSitio; ?>"/>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Fecha Entrega</label>
                                                    <div class="col-sm-8">  
                                                        <?php
                                                        $modifica = $condicionPago['AplicaContado'];
                                                        ?>
                                                        <input type="text" name="fechaEntrega" class="form-control"  value="<?php echo date('Y-m-d'); ?>" <?php if ($modifica == 'Falso') {
                                                            echo 'id="datepicker"';
                                                        } else {
                                                            echo 'readonly';
                                                        } ?>  />
                                                    </div>
                                                </div>

                                                <div class="form-group"> 

                                                    <?php
                                                    if ($modifica == "Falso" && $condicionPago['Dias'] > 0) {
                                                        $diasPlazo = $condicionPago['Dias'];
                                                        $diasMinimo = 0;
                                                    } else {
                                                        $diasPlazo = 0;
                                                        $diasMinimo = 0;
                                                    }
                                                    ?>  

                                                    <label class="col-sm-4 control-label">Forma de Pago</label>
                                                    <div class="col-sm-8">                          
                                                        <select name="formaPago" class="form-control" id="formaPago" required>
                                                            <option value>Seleccionar Forma de pago</option>
                                                            <option value="contado">Contado</option>
                                                            <?php if ($modifica == "Falso" && $condicionPago['Dias'] > 0) { ?>
                                                                <option value="credito" data-dias-pago="<?php echo $diasPlazo; ?>">Crédito</option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <?php ?>    
                                                    <label class="col-sm-4 control-label">Plazo</label>
                                                    <div class="col-sm-8">                            
                                                        <input type="number" id="plazo" required name="plazo" class="form-control" role="spinbutton" aria-valuenow="<?php echo $diasPlazo; ?>" min="<?php echo $diasMinimo; ?>" max="<?php echo $diasPlazo; ?>" value="<?php echo $diasPlazo; ?>"/>

                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Tipo de Venta</label>
                                                    <div class="col-sm-8">  

                                                        <select id="select-tipo-venta" name="tipoVenta" required="required" class="form-control"> 
                                                            <option value="">Selecione Tipo de Venta</option>
                                                            <?php if ($session['desPreventa'] == "Verdadero"): ?>                                
                                                                <option value="Preventa">Preventa</option> 
                                                                <?php if ($session['Consignacion'] == "Verdadero"): ?>                                
                                                                    <option value="Consignacion">Consignacion</option>                                
                                                                <?php endif; ?>
                                                                <?php if ($session['VentaDirecta'] == "Verdadero"): ?>                                
                                                                    <option value="VentaDirecta">VentaDirecta</option>                                
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </select>   
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Actividad Especial</label>
                                                    <div class="col-sm-8">

                                                        <select name="actividadEspecial" id="actividadEspecial" class="form-control" required >                               
                                                            <?php if ($modifica == 'Falso' && $condicionPago['Dias'] > 0) { ?> 
                                                                <option value="no">No</option>   
                                                                <option value="si">Si</option>                                                        
                                                            <?php } else { ?>                             
                                                                <option value="no">No</option>
                                                            <?php } ?>

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label" >Observaciones: </label>
                                                    <div class="col-sm-8">                         
                                                        <textarea name="Observaciones" class="col-sm-12" id="txtAreaObservaciones" placeholder="Máximo 50 caracteres"></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane" id="vtab2">

                                                <div class="row">
                                                    <div class="col-md-2 col-lg-offset-10">                              
                                                        <img src="images/add_productos.png" style="width: 40px;" class="cursorpointer" id="adicionar-portafolio"/>                                                         
                                                    </div>
                                                </div>

                                                <div class="mb20"></div>

                                                <div class="row">                          
                                                    <div class="table-responsive" id="tableDetail">
                                                        <table class="table table-bordered" id="tableDetail">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Codigo Variante</th>
                                                                    <th>Descripción</th>                    
                                                                    <th>Saldo</th>                    
                                                                    <th>Valor</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Descuento Proveedor</th>
                                                                    <th>Descuento Altipal</th>
                                                                    <th>Descuento Especial</th>    
                                                                    <th>Valor</th>    
                                                                    <th>Neto</th>  
                                                                    <th></th>   
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="vtab3">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2" id="totalesCalculados">

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Precio Neto</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Descuento Proveedor</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Descuento Altipal</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Valor Total Descuentos</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Base IVA</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">IVA</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">IMPOCONSUMO</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Total Pedido</label>
                                                            <div class="col-sm-6">
                                                                <input type="hidden" id="txtSaldoCupo" value="<?php echo $condicionPago['SaldoCupo'] ?>"/>  
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="hidden" value="0" id="cantidad-enviar"/>
                                                            <button class="btn btn-primary enviarPedido" class="enviarPedido">Enviar Pedido</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <ul class="pager wizard">
                                        <li class="previous"><a href="javascript:void(0)">Anterior</a></li>
                                        <li class="next"><a href="javascript:void(0)">Siguiente</a></li>
                                    </ul>

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
            <div class="modal-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th></th>                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($portafolioZonaVentas as $itemPortafolio) {
                            ?>
                            <tr data-id-inventario="<?php echo $itemPortafolio['IdSaldoInventario']; ?>" data-nuevo="<?php if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                            echo '1';
                        } else {
                            echo '0';
                        } ?>" data-agregado="1"  <?php if ($itemPortafolio['SaldoInventario'] == 0 || $itemPortafolio['AcuerdoComercial'] == 0) {
                                    echo 'style="background-color:#EAECEE; border-bottom: 2px solid #fff;"';
                                } ?> class="adicionar-producto-detalle cursorpointer"  data-zona="<?php echo $zonaVentas; ?>" data-codigo-variante="<?php echo $itemPortafolio['CodigoVariante']; ?>" data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-articulo="<?php echo $itemPortafolio['CodigoArticulo']; ?>" data-grupo-ventas="<?php echo $itemPortafolio['CodigoGrupoVentas']; ?>" data-CodigoUnidadMedida-saldo="<?php echo $itemPortafolio['CodigoUnidadMedida']; ?>">
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
                                    echo $itemPortafolio['CodigoArticulo'];
                                    ?>                         
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];
                                    ?>                         
                                    <br/>
    <?php
    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
    ?>
                                </td>
                                <td style="width: 10%;">

                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                </td>
                            </tr>
    <?php
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




<div class="modal fade" id="alertaArticuloSinAcuerdo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo no cuenta con un acuerdo comercial!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="alertaArticuloSinSaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo no cuenta un saldo disponible!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="alertaArticuloRestriccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo se encuentra con una restrcción por el proveedor</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
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
                <h4 class="modal-title" id="myModalLabel"><span id="textDetCodigoProducto" class="text-primary"></span>: <span id="textDetNombreProducto"></span></h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Unidad de Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetUnidadMedida"/> 

                        <input type="hidden" id="textCodigoVariante" />                 
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="txtCodigoArticulo"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textDetCodigoUnidadMedida"/>      
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetSaldo"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo Limite:</label>
                    <div class="col-sm-6">
                        <input type="number" name="txtSaldoLimite" id="txtSaldoLimite" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="txtLimiteVentasACDL" id="txtLimiteVentasACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDLSinConversion" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="" id="txtIdAcuerdo" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="" id="txtIdSaldoInventario" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCodigoUnidadSaldoInventario" readonly="readonly" class="form-control"/>


                        <input type="hidden" name="txtCodigoUnidadMedidaACDL" id="txtCodigoUnidadMedidaACDL" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="txtPorcentajeDescuentoLinea1ACDL" id="txtPorcentajeDescuentoLinea1ACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtPorcentajeDescuentoLinea2ACDL" id="txtPorcentajeDescuentoLinea2ACDL" readonly="readonly" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">IVA:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetIva" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Impoconsumo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetImpoconsumo" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Valor del Producto:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetValorProductoMostrar" class="form-control"/>
                        <input type="hidden" name="name" readonly="readonly" id="textDetValorProducto" class="form-control"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad Pedida:</label>
                    <div class="col-sm-6">
                        <input type="number" id="txtCantidadPedida" name="name" class="form-control"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">Descuento Proveedor:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="txtDescuentoProveedor" class="form-control" readonly="readonly"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Descuento Altipal:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="txtDescuentoAltipal" class="form-control" readonly="readonly"/>
                    </div>
                </div>

                <div class="form-group">

                    <label class="col-sm-4 control-label">Descuento Especial:</label>
                    <div class="col-sm-6">
                        <input type="number" name="name" id="txtDescuentoEspecial" min="0" max="100" class="form-control" <?php if (!$permisosDescuentoEspecial) {
                        echo 'readonly="readonly"';
                    } ?>/><br/>

                            <?php if ($permisosDescuentoEspecial): ?>  

                            <select name="" class="form-control" id="select-especial">
                                <option value="Ninguno">Ninguno</option>
                                <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "Verdadero"): ?>
                                    <option value="Proveedor" data-cantidad="1" >Proveedor</option>
                                <?php endif; ?>

                                <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "Verdadero"): ?>
                                    <option value="Altipal" data-cantidad="1">Altipal</option>
                            <?php endif; ?>  

    <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "Verdadero" && $permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "Verdadero"): ?>
                                    <option value="Compartidos" data-cantidad="2">Compartidos</option>
    <?php endif; ?>   

                            </select><br/>
<?php endif; ?> 

                        <div id="div-descuento-especial">

                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-adicionar-producto">Adicionar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="alertaErrorValidar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Adicionar Pedido</h5>
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
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="alertaACDLCantidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Acuerdo Comercial Descuento Linea</h5>
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
                <button type="button" class="btn btn-primary btn-small-template" id="btn-aceptar-ACDL">Aceptar</button>     
                <button type="button" class="btn btn-default btn-small-template" id="btn-cancelar-ACDL">Cancelar</button>        
            </div>
        </div>
    </div>
</div>


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