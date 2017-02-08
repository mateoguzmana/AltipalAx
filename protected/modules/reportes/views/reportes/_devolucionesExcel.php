<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Devoluciones.xls");
?>


<div class="panel-heading">
    <br><br> 
    <div align="center">
    <h2><b>Devoluciones</b></h2>
    </div>
    
    <br>
   
    <?php
    foreach ($arraypuhs as $iteminfo) {
        
        $cantidevo=0;
        $totaldevolucion=0;
        
        ?>

        <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

            <table class="table table-bordered" style="width: 100%;">

                <tr style="background-color: #8DB4E2; font-size: 12px;">

                    <th class="text-center">
                        Código Zona Ventas
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
                        Fecha Devolución 
                    </th>
                    <th class="text-center">
                        Hora Devolución 
                    </th>
                    <th class="text-center">
                        Nro Transacción
                     </th>
                </tr>


                <tr>   
                    <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>

                    <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['FechaDevolucion']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['Horafinal']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>
                    
                </tr>

                <tr>
                    <td colspan="8">
                        <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                            <table class="table table-bordered" style="width: 100%;">

                                <tr style="background-color: #8DB4E2; font-size: 12px;">

                                    <th class="text-center">
                                       Sitio  
                                    </th>
                                    <th class="text-center">
                                        Proveedor 
                                    </th>
                                    <th class="text-center">
                                        Motivo
                                    </th>


                                </tr>
                                
                                <tr>
                                    <td class="text-center"><?php echo $iteminfo['Nombre']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['NombreCuentaProveedor']; ?></td>
                                   <td class="text-center"><?php echo $iteminfo['NombreMotivoDevolucion']; ?></td> 
                               </tr>
                               
                                   <tr>
                                       <th style="background-color: #8DB4E2; font-size: 12px;" class="text-center" colspan="2">Observación</th> 
                                       <td class="text-center" colspan="6"><?php echo $iteminfo['Observacion'];?></td>  
                                   </tr>


                            </table> 
                        </div>

                    </td> 
                </tr>

                <tr>
                    <td colspan="11">
                       <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                            <table class="table table-bordered" style="width: 100%;">

                                <tr style="background-color: #C5D9F1; font-size: 12px;">

                                    <th class="text-center">Código Variante</th>
                                    <th class="text-center">Código Artículo</th>
                                    <th class="text-center">Descripción del Producto</th>
                                    <th class="text-center">Código Unidad Medida</th>
                                    <th class="text-center">Nombre Unidad Medida</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Sub Total</th>
                                    <th class="text-center">Estado</th>
                                 
                                </tr>
                                <?php
                                $detalleFactura = ReporteFzNoVentas::model()->getDetalleDevolucion($iteminfo['IdDevolucion'],$iteminfo['CodAgencia']);
                                 
                                
                                foreach ($detalleFactura as $itemDetalle) {
                                    ?>
                                    <tr>

                                        <td class="text-center"><?php echo $itemDetalle['CodigoVariante'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['CodigoArticulo'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['NombreArticulo'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['Cantidad']; ?></td>
                                        <td class="text-center"><?php echo number_format($itemDetalle['ValorTotalProducto'], '2', ',', '.') ?></td>
                                         <?php if($itemDetalle['Autoriza'] == 1){
                                            
                                            $Autoriza = 'Aprobado';
                                        }else if($itemDetalle['Autoriza'] == 2){
                                            
                                            $Autoriza = 'Rechazado';
                                        }
                                        ?>
                                        <td class="text-center"><?php echo $Autoriza ?></td>

                                    </tr>
                                    
                                    
                                    
                                <?php 
                                
                                $totaldevolucion=$totaldevolucion+$itemDetalle['ValorTotalProducto'];
                                $cantidevo=$cantidevo+$itemDetalle['Cantidad'];
                                
                                } ?>
                                    
                                     <tr>
                                       <th style="background-color: #8DB4E2; font-size: 11px;" class="text-center" colspan="5"><b>TOTALES</b></th> 
                                       <td class="text-center"><?php echo $cantidevo ?></td>
                                       <td class="text-center" >$<?php echo number_format($totaldevolucion,'2', ',', '.') ?></td>  
                                     </tr>
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