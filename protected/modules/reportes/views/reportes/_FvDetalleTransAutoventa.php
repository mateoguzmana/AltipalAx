 


<div class="panel-heading">
    <br>
    <div align="center">
        <h2>
            <a  href="javascript:transferenciaautoventa();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Transferencia Autoventa
            </b> 
            <a href="javascript: redireccionar_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png"></a>
        </h2>
    </div>

    <?php
    foreach ($arraypuhs as $iteminfo) {
        ?>

        <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">

            <table class="table table-bordered" style="width: 1500px;">

                <tr style="background-color: #8DB4E2; font-size: 12px;">

                    <th nowrap="nowrap" class="text-center">
                        Código Zona Ventas  
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Nombre Zona Ventas   
                    </th>
                    <th nowrap="nowrap" class="text-center">
                      Código Zona Ventas Transferida
                    </th>
                    <th nowrap="nowrap" class="text-center">
                       Nombre Zona Ventas Transferida
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Código Responsable
                    </th>
                    <th nowrap="nowrap" class="text-center">
                       Nombre Responsable
                    </th>
                    <th>
                        Nro Transacción
                    </th>
                </tr>


                <tr>   
                    <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['CodZonaVentasTransferencia']; ?></td>
                    <?php
                   
                    
                    $NombreZonaTransferir = ReporteFzNoVentas::model()->getConsultarNombreZonaTransferir($iteminfo['CodZonaVentasTransferencia'],$iteminfo['CodAgencia']);
                    
                    foreach ($NombreZonaTransferir as $itemZonaTransferida){
                        
                        $itemZonaTransferida['NombreZonaVentasTransferida'];
                        
                    }
                    
                    
                    ?>
                    <td class="text-center"><?php echo $itemZonaTransferida['NombreZonaVentasTransferida']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                    <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>
                    
                </tr>
                <tr>
                    <td colspan="6">

                       <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">

                            <table class="table table-bordered" style="width: 1500px;">

                                <tr style="background-color: #8DB4E2; font-size: 12px;">

                                    <th nowrap="nowrap" class="text-center">
                                        Nro Documento  
                                    </th>
                                    <th nowrap="nowrap" class="text-center">
                                        Ubicación Origen   
                                    </th>
                                    <th nowrap="nowrap" class="text-center">
                                        Ubicación Destino 
                                    </th>
                                    <th nowrap="nowrap" class="text-center">
                                        Fecha Transferencia 
                                    </th>
                                    <th nowrap="nowrap" class="text-center">
                                        Hora Transferencia 
                                    </th>
                                </tr>

                                <tr>   
                                    <td class="text-center"><?php echo $iteminfo['IdTransferenciaAutoventa']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['CodigoUbicacionOrigen']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['CodigoUbicacionDestino']; ?></td>
                                    
                                    <td class="text-center"><?php echo $iteminfo['FechaTransferenciaAutoventa']; ?></td>
                                    <td class="text-center"><?php echo $iteminfo['HoraEnviado']; ?></td>
                                    
                                </tr>


                            </table>

                        </div>

                    </td>

                </tr>
                <tr>
                    <td colspan="6">
                        <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">

                            <table class="table table-bordered" style="width: 1500px;">

                                <tr style="background-color: #C5D9F1; font-size: 12px;">

                                    <th nowrap="nowrap" class="text-center">Código Variante</th>
                                    <th nowrap="nowrap" class="text-center">Código Artículo</th>
                                    <th nowrap="nowrap" class="text-center">Nombre Artículo</th>
                                    <th nowrap="nowrap" class="text-center">Código Unidad Medida</th>
                                    <th nowrap="nowrap" class="text-center">Nombre Unidad Medida</th>
                                    <th nowrap="nowrap" class="text-center">Cantidad</th>
                                    <th nowrap="nowrap" class="text-center">Nro Lote</th>
                                </tr>
                                <?php
                                $detalleConsig = ReporteFzNoVentas::model()->getDetalleTrnasferenciaAutoventa($iteminfo['IdTransferenciaAutoventa'],$iteminfo['CodAgencia']);

                                foreach ($detalleConsig as $itemDetalle) {
                                    ?>
                                    <tr>

                                        <td class="text-center"><?php echo $itemDetalle['CodVariante'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['CodigoArticulo'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['NombreArticulo'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['Cantidad'] ?></td>
                                        <td class="text-center"><?php echo $itemDetalle['Lote'] ?></td>

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





