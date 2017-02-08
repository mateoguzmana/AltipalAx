<style type="text/css">
.pint{
  cursor: pointer;
}
.table-responsive{
  max-width: 1050px;
  overflow: auto;
}
.modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}
</style>
<div class="panel">
<div class="panel-heading">
    <br> 
    <div align="center">
        <h2>
           <b>
                Pedidos
            </b>
            <a href="javascript:genrar_Pedidos_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

</div>
<div class="panel-body">   
    <?php
      
      $count = 0;

      foreach ($arraypuhs as $iteminfo) {
            
      $count++;

      $cantiZona=0;
      $valoriva=0;
      $baseiva=0;
      $totalprecioneto=0;
      $valoripoconsumo=0;
      $valortotalunitario=0;
                      
    ?>

    <div class="table-responsive">

            <table class="table table-bordered">

                <tr style="background-color: #8DB4E2; font-size: 12px;">

                    <th class="text-center">
                        Cód. Zona Ventas   
                    </th>
                    <th class="text-center">
                        Nombre Zona Ventas   
                    </th>
                     <th class="text-center">
                        Cuenta Cliente 
                    </th>
                     <th class="text-center">
                        Nombre Cliente 
                    </th>
                    <th class="text-center">
                        Código Responsable 
                    </th>
                    <th class="text-center">
                        Nombre Responsable 
                    </th>
                    <th class="text-center">
                        Fecha Pedido 
                    </th>
                     <th class="text-center">
                        Hora Pedido 
                    </th>
                    
                 </tr>
                  <tr>   
                      <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['FechaPedido']; ?></td>
                      <td class="text-center"><?php echo $iteminfo['HoraEnviado']; ?></td>
                  </tr>
                      <tr>
                          <td colspan="8">
                               <div class="table-responsive">
                                 <table class="table table-bordered">
                                   <tr style="background-color: #8DB4E2; font-size: 12px;">
                                     <th class="text-center"> Nro. Pedido </th>
                                     <th class="text-center"> Sitio </th>
                                     <th class="text-center"> Almacén </th>
                                     <th class="text-center"> Fecha Entrega </th>
                                     <th class="text-center"> Forma Pago </th>
                                     <th class="text-center"> Plazo </th>
                                     <th class="text-center"> Tipo Venta </th>
                                     <th class="text-center"> Actividad Especial </th>
                                     <th class="text-center"> Grupo Precio </th>
                                   </tr>
                                   <tr>
                                       <td class="text-center"><?php echo $iteminfo['NombreSitio'];?></td>
                                       <td class="text-center"><?php echo $iteminfo['NombreAlmacen'];?></td>
                                       <td class="text-center"><?php echo $iteminfo['FechaEntrega'];?></td>
                                       <td class="text-center"><?php echo $iteminfo['FormaPago'];?></td>
                                       <?php $plazo = $iteminfo['Plazo'];
                                        $dias = ReporteFzNoVentas::model()->getDiasPlazoZonaVentas($plazo,$iteminfo['CodAgencia']);
                                        ?>
                                       <td class="text-center"><?php echo $dias['Dias'];;?></td>
                                       <td class="text-center"><?php echo $iteminfo['TipoVenta'];?></td>
                                        <?php if($iteminfo['ActividadEspecial'] == 1){
                                           
                                           $ActividadEspecial='Si';
                                        ?>
                                       
                                      <?php }else{
                                          
                                            $ActividadEspecial='No'
                                          
                                          ?>
                                        
                                      <?php  } ?>
                                       <td class="text-center"><?php echo $ActividadEspecial ?></td>
                                       <td class="text-center"><?php echo $iteminfo['NombreGrupodePrecio'];?></td>  
                                       <td class="text-center"><?php echo $iteminfo['IdPedido']; ?></td>
                                   </tr>   
                                   <tr>
                                       <th style="background-color: #8DB4E2; font-size: 12px;" class="text-center" colspan="2">Observación</th> 
                                       <td class="text-center" colspan="6"><?php echo $iteminfo['Observacion'];?></td>  
                                   </tr>
                                    <tr>
                                      <td data-toggle="modal" data-target="#ModalDetail<?=$count?>" class="text-center text-info pint" colspan="11"><i class="fa fa-eye fa-5x"></i><br>Ver detalle</td>
                                    </tr>
                                 </table>
                                 
                             </div>
                              
                          </td>
                      </tr>                   
            </table>

        </div>  
<!-- Modal -->
<div class="modal fade" id="ModalDetail<?=$count?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <br><!--<h4 class="modal-title" id="myModalLabel"></h4>-->
      </div>
      <div class="modal-body">
        <div class="table-responsive" style="max-width:1300px;overflow:auto;">
                                 <table class="table table-bordered">
                                  
                                     <tr style="background-color: #C5D9F1; font-size: 12px;">
                                      
                                     <th class="text-center">Código Variante</th>
                                     <th class="text-center">Código Artículo</th>
                                     <th nowrap="nowrap" class="text-center">Nombre Artículo</th>
                                     <th nowrap="nowrap" class="text-center">Código Unidad Medida</th>
                                     <th nowrap="nowrap" class="text-center">Nombre Unidad Medida</th>
                                     <th class="text-center">Cantidad</th>
                                    
                                     <th nowrap="nowrap" class="text-center">Descuento Promocional</th>
                                     <th nowrap="nowrap" class="text-center">Descuento Canal</th>
                                     <th nowrap="nowrap" class="text-center">Descuento Especial</th>
                                     <th nowrap="nowrap" class="text-center">Valor Unitario</th>
                                     <th class="text-center">Impoconsumo</th>
                                     <th nowrap="nowrap" class="text-center">% Iva</th>
                                     
                                      <th class="text-center">Valor Iva</th>
                                      <th class="text-center">Base Iva</th>
                                      <th nowrap="nowrap" class="text-center">Valor Unitario Neto</th>
                                      <th class="text-center">SUBTOTAL</th>
                                      <th nowrap="nowrap" class="text-center">Detalle kit</th>
                                       
                                       
                                     
                                   </tr>
                                   <?php
                                  
                                   
                                   $detallePedido = ReporteFzNoVentas::model()->getDetallePedido($iteminfo['IdPedido'],$iteminfo['CodAgencia']);
                                   
                                   foreach ($detallePedido as $itemDetalle){
                                   ?>
                                   
                                       <?php
                                       
                                      $valorunitario = $itemDetalle['TotalPrecioNeto'] / $itemDetalle['Cantidad'];  
                                     
                                      if($itemDetalle['CodigoTipo'] == 'KD')
                                      {
                                      ?>
                                   <tr>
                                       
                                       <td class="text-center"><?php echo $itemDetalle['CodVariante']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['CodigoArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['NombreArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Cantidad']?></td>
                                       
                                       <td class="text-center"><?php echo $itemDetalle['DsctoMultiLinea']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['DsctoLinea']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['DsctoEspecial']?></td>
                                       <td class="text-center"><?php echo number_format($itemDetalle['ValorUnitario'],'2', ',', '.')?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Impoconsumo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Iva']?></td>
                                       
                                        
                                      <td class="text-center"><?php echo number_format($itemDetalle['ValorIva'],'2', ',', '.')?></td>
                                      <td class="text-center"><?php echo number_format($itemDetalle['BaseIva'],'2', ',', '.')?></td>
                                      <td class="text-center"><?php echo number_format($valorunitario, '2',',','.') ?></td>
                                      <td class="text-center"><?php echo number_format($itemDetalle['TotalPrecioNeto'],'2', ',', '.')?></td>
                                          
                                   
                                      
                                      <td class="text-center">
                                          <img src="images/kits.png" style="width: 55px; height: 70px;"  class="cursorpointer"  id="<?php echo $itemDetalle['Id'] ?>" onclick="kitsZona(this.id)" >
                                      </td>
                                      
                                      </tr> 
                                      <?php 
                                      }  else {
                                      ?>
                                       <tr>
                                       
                                       <td class="text-center"><?php echo $itemDetalle['CodVariante']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['CodigoArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['NombreArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Cantidad']?></td>
                                       
                                       <td class="text-center"><?php echo $itemDetalle['DsctoMultiLinea']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['DsctoLinea']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['DsctoEspecial']?></td>
                                       <td class="text-center"><?php echo number_format($itemDetalle['ValorUnitario'],'2', ',', '.')?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Impoconsumo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Iva']?></td>
                                       
                                        
                                      <td class="text-center"><?php echo number_format($itemDetalle['ValorIva'],'2', ',', '.')?></td>
                                      <td class="text-center"><?php echo number_format($itemDetalle['BaseIva'],'2', ',', '.')?></td>
                                      <td class="text-center"><?php echo number_format($valorunitario, '2',',','.') ?></td>
                                      <td class="text-center"><?php echo number_format($itemDetalle['TotalPrecioNeto'],'2', ',', '.')?></td>
                                          
                                       </tr> 
                                      
                                      
                                     <?php  } ?>
                                  
                                  
                                   <?php 
                                  
                                    $valortotalunitario=$valortotalunitario+$valorunitario;
                                   } ?>
                                   
                                   <?php
                                   
                                    $valoripoconsumo=$valoripoconsumo+$iteminfo['TotalValorImpoconsumo'];
                                    $cantiZona=$cantiZona+$iteminfo['TotalPedido'];
                                    $valoriva=$valoriva+$iteminfo['TotalValorIva'];
                                    $baseiva=$baseiva+$iteminfo['TotalSubtotalBaseIva'];
                                    $totalpedido=$totalprecioneto+$iteminfo['ValorPedido'];
                                     
                                    
                                   
                                   ?>
                                    
                                   <tr>
                                       <th style="background-color: #8DB4E2; font-size: 12px;" class="text-center" colspan="4"><b>TOTALES</b></th> 
                                       <td class="text-center"><?php echo $canti ?></td>
                                       <td colspan="4"></td>
                                       <td></td>
                                       <td class="text-center" >$<?php echo number_format($valoripoconsumo,'2', ',', '.') ?></td>  
                                       <td class="text-center" >$<?php echo number_format($valoriva,'2', ',', '.') ?></td>
                                       <td class="text-center" >$<?php echo number_format($baseiva,'2', ',', '.') ?></td>
                                       <td class="text-center" >$<?php echo number_format($valortotalunitario,'2', ',', '.') ?></td>
                                       <td class="text-center" >$<?php echo number_format($totalpedido,'2', ',', '.') ?></td>
                                         
                                   </tr>
                                   
                                 </table>
                                 
                             </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>  




                    <?php
                }
              
    
    ?>
</div>
</div>

<div class="modal fade" id="_FvDetalleKitsPedidos" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Detalle del Kit</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="tabladetalle" ></div>
                     </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Cerrar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->






          
