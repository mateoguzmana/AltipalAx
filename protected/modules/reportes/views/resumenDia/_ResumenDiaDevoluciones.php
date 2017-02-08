    
<div class="panel-heading">
    <br> 
    <div align="center">
        <h2>
           <b>
                Devoluciones
            </b>
            <a href="javascript:genrar_Devoluciones_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

    <?php
    foreach ($arraypuhs as $iteminfo) {
        
        $cantidevo=0;
        ?>

        <div class="table-responsive">

            <table class="table table-bordered">

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
                </tr>

                <tr>
                    <td colspan="8">
                        <div class="table-responsive">

                            <table class="table table-bordered">

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
                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <tr style="background-color: #C5D9F1; font-size: 12px;">

                                    <th class="text-center">Código Variante</th>
                                    <th class="text-center">Código Artículo</th>
                                    <th class="text-center">Descripción del Producto</th>
                                    <th class="text-center">Código Unidad Medida</th>
                                    <th class="text-center">Nombre Unidad Medida</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Sub Total</th>
                                 
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


                                    </tr>
                                    
                                    
                                    
                                <?php 
                                
                                $totaldevolucion=$totaldevolucion+$itemDetalle['ValorTotalProducto'];
                                
                                } ?>
                                    
                                    <?php
                                     $cantidevo=$cantidevo+$iteminfo['TotalDevolucion'];
                                     
                                     
                                    
                                    ?>
                                    
                                    
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

 <?php $this->renderPartial('//mensajes/_alerta'); ?>






