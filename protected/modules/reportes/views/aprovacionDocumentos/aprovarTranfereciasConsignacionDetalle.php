 

<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Transferencia Consignación Detalle <span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">



        <div class="panel-body" style="max-height: 550px; min-height: 100%">
            <div class="widget widget-blue">
                <div class="widget-content">

                    <div class="row"> 

                        <div class="mb30"></div>

                        <div class="col-sm-12">
                           
                            
                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table  table-hover table-bordered mb30" style="min-width: 900px ; max-width: 100% ">
                                    <thead>
                                      <tr>
                                            <th style="width: 3%;"><b>No.</b></th>                                            
                                            <th class="text-center"><b>No. Transferencia</b></th>
                                            <th class="text-center"><b>Vendedor</b></th>
                                            <th class="text-center"><b>Cliente</b></th>
                                            <th class="text-center"><b>Fecha Transferencia</b></th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                                                            
                                        <?php $cont=0; foreach ($Information as $itemTransferenciaConsig): ?>
                                        <tr>
                                            <td class="text-center"><?php echo $cont+1;?></td>
                                            <td class="text-center"><?php echo $itemTransferenciaConsig['IdTransferencia']; ?></td>
                                            <td class="text-center"><?php echo $itemTransferenciaConsig['NombreAsesor']; ?>--<?php echo $itemTransferenciaConsig['CodZonaVentas']; ?></td>
                                            <td class="text-center"><?php echo $itemTransferenciaConsig['NombreCliente']; ?>--<?php echo $itemTransferenciaConsig['CuentaCliente']; ?></td>
                                            <td class="text-center"><?php echo $itemTransferenciaConsig['FechaTransferencia']; ?> </td>
                                            <td class="text-center">
                                             <span>
                                                  <img src="images/autoriza.png" style="width: 35px; padding: 5px;" class="cursorpointer btnDetalleTransferenciaConsignacion"
                                                     data-id-transferencia="<?php echo $itemTransferenciaConsig['IdTransferencia'] ?>" data-agencia="<?php echo $agencia ?>"/>
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

<div class="modal fade" id="mdlDetalleTransferenciaConsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 1220px;">
    <div class="modal-content">
      <div class="modal-header info">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Detalle de la Transferencia Consignación</h4>
      </div>
        <div class="modal-body" style="height: 500px; overflow-y: scroll;">
          
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarTransferenciaConsignacion">Guardar Transferencia</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<?php $this->renderPartial('//mensajes/_alerta'); ?>

 


 