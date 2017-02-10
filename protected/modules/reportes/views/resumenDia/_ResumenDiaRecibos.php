<div class="panel-heading">
    <br>  
    <div align="center">
        <h2>
            <a  href="javascript:formaspagos();" class="btn btn-primary GenrarFormasPago" style="float:left; margin-left: 20px;">Formas de pago</a>
            <b>
                Recibos
            </b>
            <a href="javascript:genrar_Recibos_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
           
        </h2>
       
    </div>

    <?php
    foreach ($arraypuhs as $iteminfo) {
        ?>

        <div class="table-responsive">

            <table class="table table-bordered">

                <tr>

                    <th class="text-center" style="background-color: #8DB4E2; font-size: 12px;">
                        Nro Provisional  
                    </th>
                    <td class="text-center">
                       <?php echo $iteminfo['Provisional']; ?>  
                    </td>
                    <th class="text-center" style="background-color: #8DB4E2; font-size: 12px;">
                        Fecha Recibo 
                    </th>
                    <td class="text-center">
                        <?php echo $iteminfo['Fecha']; ?>
                    </td>
                    <th class="text-center" style="background-color: #8DB4E2; font-size: 12px;">
                        Hora Recibo 
                    </th>
                    <td class="text-center">
                        <?php echo $iteminfo['Hora']; ?>
                    </td>

                </tr>

                <tr>
                    <td colspan="6">
                        <div class="table-responsive">

                            <table class="table table-bordered">


                                <tr style="background-color: #8DB4E2; font-size: 12px;">

                                    <th class="text-center">Código Zona Ventas</th>
                                    <th class="text-center">Nombre Zona Ventas</th>
                                    <th class="text-center">Cuenta Cliente</th>
                                    <th class="text-center">Nombre Cliente</th>
                                    <th class="text-center">Código Asesor</th>
                                     <th class="text-center">Nombre Asesor</th>
                                    <th class="text-center">Código Responsable</th>
                                    <th class="text-center">Nombre Responsable</th>
                                    <th class="text-center">Nro Transacción</th>



                                </tr>

                                <tr>   
                                    <td class="text-center"><?php echo $iteminfo['ZonaVenta']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>

                                    <td class="text-center"><?php echo $iteminfo['CodAsesor']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['Asesor']; ?></td>
                                    
                                    <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>
                                    
                                    


                                </tr>


                            </table> 

                        </div>    


                    </td>  
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tr style="background-color: #8DB4E2; font-size: 12px;">
                                    <th class="text-center">Número Factura</th>
                                    <th class="text-center">Valor Factura</th>
                                    <th class="text-center">Abono</th>
                                    <th class="text-center">Descuento Pronto Pago</th>
                                    <th class="text-center">Motivo Saldo</th>

                                </tr>
                                
                                <?php
                                
                                 $fac = ReporteFzNoVentas::model()->getDetalleRecibos($iteminfo['Id'],$iteminfo['CodAgencia']);
                               
                                 $totalabono=0;
                                  foreach ($fac as $iteminfoFac) {
                                      ?>
                            
                                    <tr>

                                        <td class="text-center"><?php echo $iteminfoFac['NumeroFactura'] ?></td>
                                        <td class="text-center"><?php echo number_format($iteminfoFac['ValorFactura'], '2', ',', '.') ?></td>
                                        <td class="text-center"><?php echo number_format($iteminfoFac['ValorAbono'], '2', ',', '.') ?></td>
                                        <td class="text-center"><?php echo number_format($iteminfoFac['DtoProntoPago'], '2', ',', '.') ?></td>
                                        <td class="text-center"><?php echo $iteminfoFac['NombreMotivo'] ?></td>
                                    </tr>
                                    
                                    
                                  <?php 
                                  
                                  $totalabono=$totalabono+$iteminfoFac['ValorAbono'];
                                  
                                  } ?>
                                    
                                 <tr>
                                       <th style="font-size: 12px;" class="text-center" colspan="2">Valor Recibo</th> 
                                       <td class="text-center">$ <?php echo number_format($totalabono, '2', ',', '.') ?></td> 
                                    </tr>
                                   
                                   <tr>
                                       <th colspan="5" style="background-color: #C5D9F1; font-size: 12px;" class="text-center" colspan="2">Formas De Pago</th> 
                                         
                                   </tr>
                                   <?php 
                                      $sumaefectivo = ReporteFzNoVentas::model()->getSumaEfectivo($iteminfoFac['Id'],$iteminfo['CodAgencia']);
                                      
                                      $auxi=0;
                                      foreach ($sumaefectivo as $itemefectivo){
                                          if($itemefectivo['Efectivo'] > 0){
                                          $auxi = $itemefectivo['Efectivo'];
                                          }
                                      }

                                   if($auxi!=0){
                                   ?>
                                   <tr>
                                      <td class="text-center">
                                          <img src="images/reporteefectivo.png" style="width: 40px; height: 40px;"  class="cursorpointer" onclick="Efectivo(<?php echo $iteminfoFac['Id']?>,'<?php echo $iteminfo['CodAgencia']?>')"   title="Efectivo">
                                      </td>
                                      <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Efectivo</b></td>
                                      <td class="text-center" colspan="3">$  <?php echo number_format($auxi,'2',',','.'); ?></td>
                                   </tr>
                                   <?php } ?>
                                   <?php 
                                      $sumaefectivoConsignacion = ReporteFzNoVentas::model()->getSumaEfectivoConsignacion($iteminfoFac['Id'],$iteminfo['CodAgencia']);
                                      
                                      $axu=0; 
                                      foreach ($sumaefectivoConsignacion as $itemefectivoconsig){
                                         if($itemefectivoconsig['efectivoconsignacion'] > 0){
                                          $axu = $itemefectivoconsig['efectivoconsignacion'];
                                           
                                         }
                                      }
                                      
                                   if($axu!=0){
                                   ?>
                                   <tr>     
                                      <td class="text-center">
                                          <img src="images/efectivoConsig.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="EfectivoConsig(<?php echo $iteminfoFac['Id'] ?>,'<?php echo $iteminfo['CodAgencia']?>')" title="Efectivo Consignación">
                                      </td>
                                       <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Efectivo Consignación</b></td>
                                        
                                       <td class="text-center" colspan="3">$ <?php echo number_format($axu,'2', ',', '.')?></td>
                                   </tr>
                                   <?php }?>
                                   <?php 
                                      $sumaecheque = ReporteFzNoVentas::model()->getSumaCheque($iteminfoFac['Id'], $iteminfo['CodAgencia']);
                                       
                                      $axu=0;
                                      foreach ($sumaecheque as $itemecheque){
                                          if($itemecheque['cheque'] > 0){
                                          $axu = $itemecheque['cheque'];
                                          }
                                      }
                                      
                                    if($axu!=0){
                                      ?>
                                    <tr>
                                      <td class="text-center">
                                          <img src="images/reportecheque.png" style="width: 40px; height: 40px;"  class="cursorpointer" onclick="Cheque(<?php echo $iteminfoFac['Id'] ?>,'<?php echo $iteminfo['CodAgencia']?>')" title="Cheque">
                                      </td>
                                       <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Cheque</b></td>
                                      <td class="text-center" colspan="3">$ <?php echo number_format($axu,'2', ',', '.')?></td>
                                   </tr>
                                   <?php } ?>
                                   <?php
                                        
                                      $sumachequeconsignacion="";
                                       $sumachequeconsignacion = ReporteFzNoVentas::model()->getSumaChequeConsignacion($iteminfoFac['Id'],$iteminfo['CodAgencia']);
                                       
                                       
                                       $auxi=0;   
                                       foreach ($sumachequeconsignacion as $itemConsig){
                                       if($itemConsig['chequeconsignacion'] > 0) { 
                                       $auxi = $itemConsig['chequeconsignacion'];
                                       }
                                           
                                       }
                                      
                                    if($auxi!=0){
                                    ?>
                                    <tr> 
                                      <td class="text-center">
                                          <img src="images/chequeConsig.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="ChequeConsig(<?php echo $iteminfoFac['Id'] ?>,'<?php echo $iteminfo['CodAgencia']?>')" title="Cheque Consignación">
                                      </td>
                                       <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Cheque Consignación</b></td>
                                      <td class="text-center" colspan="3">$ <?php echo number_format($auxi,'2', ',', '.')?></td>
                                   </tr>
                                  <?php } ?>
                                  <?php
                                        
                                      $sumaefectivoConsignacion = ReporteFzNoVentas::model()->getSumaEfectivoConsignacion($iteminfoFac['Id'],$iteminfo['CodAgencia'], '007');
                                      
                                      $axu=0; 
                                      foreach ($sumaefectivoConsignacion as $itemefectivoconsig){
                                         if($itemefectivoconsig['efectivoconsignacion'] > 0){
                                          $axu = $itemefectivoconsig['efectivoconsignacion'];
                                           
                                         }
                                      }
                                      //$axu = $iteminfo["ValorAbono"];
                                      
                                    if($axu!=0){
                                    ?>
                                    <tr> 
                                      <td class="text-center">
                                          <img src="imagenes/cardebito.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="EfectivoConsig(<?php echo $iteminfoFac['Id'] ?>,'<?php echo $iteminfo['CodAgencia']?>', '007')" title="Tarjeta débito">
                                      </td>
                                       <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Tarjeta débito</b></td>
                                      <td class="text-center" colspan="3">$ <?php echo number_format($axu,'2', ',', '.')?></td>
                                   </tr>
                                  <?php } ?>
                            </table>

                        </div>   

                    </td>

                </tr>


            </table>

        </div>    

        <?php
    }
    ?>



</div>



<div class="modal fade" id="_FvDetallesReciboEfectivo" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width:500px;">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Detalle Efectivo</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="tabladetallerecibosEfectivo" ></div>
                     </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Cerrar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="_FvDetallesRecibosEfectivConsig" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width:600px;">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Detalle Efectivo Consignación</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="tabladetallerecibosEfectivoConsig" ></div>
                     </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Cerrar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


 

<div class="modal fade" id="_FvDetallesRecibosCheque" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Detalle Cheque</h4>
            </div>
              <div id="tabladetallereciboscheque" ></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>


<div class="modal fade" id="_FvDetallesRecibosChequeConsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Detalle Cheque Consignación</h4>
            </div>
              <div id="tabladetallereciboschequeconsignacion" ></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>


<div class="modal fade" id="_formaPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 572px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Formas de Pago</h4>
            </div>
            <div class="modal-body">
                
                <div id="tablaformaspago"></div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
