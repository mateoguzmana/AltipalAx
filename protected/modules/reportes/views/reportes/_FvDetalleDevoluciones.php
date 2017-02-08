   
<div class="panel-heading">
    <br> 
    <div align="center">
        <h2>
            <a  href="javascript:devoluciones();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Devoluciones
            </b>
            <a href="javascript:genrar_Devoluciones_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

    <?php
    foreach ($arraypuhs as $iteminfo) {

        $cantidevo = 0;
        $totaldevolucion = 0;
        ?>

        <form action="  index.php?r=reportes/Reportes/AjaxExportarExcelDevolucion" method=post name="formulario_devolucion_excel">


           <input type="hidden" name="sqlDevoluciones" value="<?php echo $sqlDevoluciones ?>">
            <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
            <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
            <input type="hidden" name="agencia" value="<?php echo $agencia ?>">

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
                                        <td class="text-center" colspan="6"><?php echo $iteminfo['Observacion']; ?></td>  
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
                                    $detalleFactura = ReporteFzNoVentas::model()->getDetalleDevolucion($iteminfo['IdDevolucion'], $iteminfo['CodAgencia']);


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
                                            <?php
                                            if ($itemDetalle['Autoriza'] == 1) {

                                                $Autoriza = 'Aprobado';
                                            } else if ($itemDetalle['Autoriza'] == 2) {

                                                $Autoriza = 'Rechazado';
                                            }
                                            ?>
                                            <td class="text-center"><?php echo $Autoriza ?></td>

                                        </tr>



                                        <?php
                                        $totaldevolucion = $totaldevolucion + $itemDetalle['ValorTotalProducto'];
                                        $cantidevo = $cantidevo + $itemDetalle['Cantidad'];
                                    }
                                    ?>

                                    <tr>
                                        <th style="background-color: #8DB4E2; font-size: 11px;" class="text-center" colspan="5"><b>TOTALES</b></th> 
                                        <td class="text-center"><?php echo $cantidevo ?></td>
                                        <td class="text-center" >$<?php echo number_format($totaldevolucion, '2', ',', '.') ?></td>  
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
            
                <input type="hidden" value="<?php echo $sqlDevoluciones ?>" id="sqlDevoluciones" name="sqlDevoluciones"/>
                <input type="hidden" value="<?php echo $fechaini ?>" id="fechaini" name="fechaini"/>
                <input type="hidden" value="<?php echo $fechafin ?>" id="fechafin" name="fechafin"/>
        </form>
</div>

<script>

    function genrar_Devoluciones_excel() {
        document.formulario_devolucion_excel.submit();
    }



</script>






