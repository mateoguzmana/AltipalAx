 <div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Devolución Detalle <span></span></h2>      
</div>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row">
                        <div class="mb30"></div>
                        <div class="col-sm-12">
                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table  table-hover table-bordered mb30" style='width: 100%'>
                                    <thead>
                                      <tr>
                                            <th style="width: 3%;">No.</th>                                            
                                            <th class="text-center">No. Devolución</th>
                                            <th class="text-center">Vendedor</th>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Fecha Devolución</th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>                                                                            
                                        <?php $cont=0; foreach ($informationDevoluciones as $itemDevolu): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $cont+1;?></td>
                                            <td class="text-center"><?php echo $itemDevolu['IdDevolucion']; ?></td>
                                            <td class="text-center"><?php echo $itemDevolu['NombreAsesor']; ?>--<?php echo $itemDevolu['CodZonaVentas']; ?></td>
                                            <td class="text-center"><?php echo $itemDevolu['NombreCliente']; ?>--<?php echo $itemDevolu['CuentaCliente']; ?> </td>
                                            <td class="text-center"><?php echo $itemDevolu['FechaDevolucion']; ?> </td>
                                            <td class="text-center">
                                             <span>
                                                  <img src="images/autoriza.png" style="width: 35px; padding: 5px;" class="cursorpointer btnDetalleDevoluciones"
                                                     data-id-devoluciones="<?php echo $itemDevolu['IdDevolucion'] ?>" data-agencia="<?php echo $agencia ?>"/>
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
<div class="modal fade" id="mdlDetalleDevolucion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 1220px;">
    <div class="modal-content">
      <div class="modal-header info">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Detalle de la Devolución</h4>
      </div>
        <div class="modal-body" style="height: 500px; overflow-y: scroll;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarDevolucion">Guardar Devolución</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<?php $this->renderPartial('//mensajes/_alerta'); ?>