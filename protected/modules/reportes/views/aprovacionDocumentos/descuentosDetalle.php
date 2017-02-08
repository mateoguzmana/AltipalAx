<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Descuentos Detalle <span></span></h2>      
</div>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row">
                        <div class="mb30"></div>
                        <div class="col-sm-12">
                            <?php
                            //print_r($pedidosGrupoVentas);
                            ?>
                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <input type="hidden" id="PedidoExistente" value="<?php echo $PedidoExistente ?>">
                                <table class="table table-hidaction table-hover table-bordered mb30">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">No.</th>
                                            <th>No. Pedido</th>
                                            <th style="width: 30%;">Vendedor</th>
                                            <th style="width: 30%;">Cliente</th>
                                            <th>Fecha Pedido</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 0;
                                        foreach ($pedidosGrupoVentas as $itemPedido): ?>
                                            <?php
                                            $tipoUsuario = Yii::app()->user->_tipoUsuario;
                                            $valida = TRUE;
                                            if ($tipoUsuario == '1' && $itemPedido['EstadoRevisadoAltipal'] == '1') {
                                                $valida = FALSE;
                                            } elseif ($tipoUsuario == '2' && $itemPedido['EstadoRevisadoProveedor'] == '1') {
                                                $valida = FALSE;
                                            }
                                            if ($valida) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cont + 1; ?></td>
                                                    <td><?php echo $itemPedido['IdPedido'] ?></td>
                                                    <td><?php echo $itemPedido['nombreAsesor']; ?>--<?php echo $itemPedido['CodZonaVentas'] ?></td>
                                                    <td><?php echo $itemPedido['NombreCliente']; ?>--<?php echo $itemPedido['CuentaCliente'] ?></td>
                                                    <td><?php echo $itemPedido['FechaPedido']; ?></td>
                                                    <td class="text-center">
                                                        <span 
                                                            class="cursorpointer btnDetallePedido"
                                                            data-agencia="<?php echo $itemPedido['Agencia'] ?>"
                                                            data-grupo-ventas="<?php echo $itemPedido['CodGrupoVenta'] ?>"
                                                            data-id-pedido="<?php echo $itemPedido['IdPedido'] ?>"
                                                            >
                                                            <img src="images/autoriza.png" style="width: 35px; padding: 5px;"/>
                                                            <br/>
                                                            <small>Autorizar</small>
                                                        </span> 
                                                        <div id="imgCargando1"></div>
                                                    </td>
                                                </tr>
        <?php
        $cont++;
    }
    ?>
                                        <?php endforeach; ?>                                       
                                        <?php
                                        if ($cont == 0):
                                            echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/Descuentos';</script>";
                                            ?>
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <div class="mb40"></div>
                                                    <h4 class="text-primary">No hay pedidos para aprobar</h4>
                                                    <div class="mb40"></div>
                                                </td>
                                            </tr>

                                        <?php endif; ?>
                                    </tbody>
                                    <input type="hidden" value="<?php echo $idPedido ?>" id="IdPedidoLink">
                                    <input type="hidden" value="<?php echo $CodAgencia ?>" id="CodAgenciaLink">
                                    <input type="hidden" value="<?php echo $GrupoVentas ?>" id="GrupoVentasLink">
                                    <input type="hidden" value="<?php echo $GestionoProducto ?>" id="ProductoGestionado">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script>
        $(document).ready(function () {
            $('#_alertaSucess').modal('show');
        });
    </script>
<?php endif; ?>
<div class="modal fade" id="_alertaSucess" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="msg">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="glyphicon glyphicon-ok" style="font-size: 40px; color: green;"></span>
                    </div>
                    <div class="col-sm-10">
                        <div class="info">
                            <?php echo Yii::app()->user->getFlash('success'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary retornarmenu" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<!-- Modal -->
<div class="modal fade" id="mdlDetallePedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 1342px;">
        <div class="modal-content">
            <div class="modal-header info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detalle del pedido</h4>
            </div>
            <div class="modal-body" style="height: 500px; overflow-y: scroll;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarPedido">Guardar Pedido</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<div class="modal fade" id="_alertaDescuento" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
<div class="modal fade" id="_alertaGuardando" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog" style="width: 300px; margin: 300px auto;">
        <div class="modal-content" style="border: 1px solid #CDCDCD;">            
            <div class="modal-body" style="padding: 25px;">
                <h5><img alt="" src="images/loaders/loader9.gif"> Guardando...</h5>
            </div>           
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->