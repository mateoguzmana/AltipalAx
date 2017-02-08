<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Actividad Especial Detalle <span></span></h2>      
</div>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="container-fluid">
                        <div class="row"> 
                            <div class="mb30"></div>
                            <div class="col-sm-12">                            
                                <div style="border: 2px solid #eee; overflow-y: scroll; max-height: 470px; min-height: 100%; font-size: 11px">
                                    <table class="table table-hidaction table-hover table-bordered mb30" style="min-width: 700px">
                                        <thead>
                                            <tr>
                                                <th style="width: 3%;"><b>No.</b></th>                                            
                                                <th class="text-center"><b>No. Pedido</b></th>
                                                <th class="text-center"><b>Vendedor</b></th>
                                                <th class="text-center"><b>Cliente</b></th>
                                                <th class="text-center"><b>Fecha Pedido</b></th>
                                                <th></th>                                            
                                            </tr>
                                        </thead>
                                        <tbody>                                                                            
                                            <?php $cont = 0;
                                            foreach ($InformacionPedidoActiEspecial as $itemPedidoActiEspecial): ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $cont + 1; ?></td>
                                                    <td class="text-center"><?php echo $itemPedidoActiEspecial['IdPedido']; ?></td>
                                                    <td class="text-center"><?php echo $itemPedidoActiEspecial['NombreAsesor']; ?>--<?php echo $itemPedidoActiEspecial['CodZonaVentas']; ?></td>
                                                    <td class="text-center"><?php echo $itemPedidoActiEspecial['NombreCliente']; ?>--<?php echo $itemPedidoActiEspecial['CuentaCliente']; ?> </td>
                                                    <td class="text-center"><?php echo $itemPedidoActiEspecial['FechaPedido']; ?> </td>
                                                    <td class="text-center">
                                                        <span>
                                                            <img src="images/autoriza.png" style="width: 35px; padding: 5px;" class="cursorpointer btnDetallePedidoActividadEspecial"
                                                                 data-id-pedido="<?php echo $itemPedidoActiEspecial['IdPedido'] ?>" data-agencia="<?php echo $agencia ?>"/>
                                                            <br/>
                                                            <small>Autorizar</small>
                                                        </span>
                                                    </td>                                             
                                                </tr>
                                                <?php
                                                $cont++;
                                                ?>
<?php endforeach; ?>                                       
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdlDetallePedidoActividadEsepcial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 1220px;">
        <div class="modal-content">
            <div class="modal-header info">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detalle Pedidos Actividad Especial</h4>
            </div>
            <div class="modal-body" style="border: 2px solid #eee; overflow-x: scroll; height: 400px;">          
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarPedidosActividaEspecial">Guardar Pedido</button>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
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
                    <div class="modal-body"></div>                    
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary reload" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<?php $this->renderPartial('//mensajes/_alerta'); ?>