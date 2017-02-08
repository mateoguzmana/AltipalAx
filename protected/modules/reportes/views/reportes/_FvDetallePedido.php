  
<div class="panel-heading">
    <br> 
    <div align="center">
        <h2>
            <a  href="javascript:pedidos();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Pedidos
            </b>
            <a href="javascript:genrar_Pedido_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

        <?php
        foreach ($arraypuhs as $iteminfo) {

            $canti = 0;
            $valoriva = 0;
            $baseiva = 0;
            $totalprecioneto = 0;
            $valoripoconsumo = 0;
            $valorTotalUnitario = 0;
            ?>
    
    <form action="index.php?r=reportes/Reportes/AjaxExportarExcelPedidos" method=post name="formulario_pedido_excel">

            <input type="hidden" name="sqlPedido" value="<?php echo $sqlPedido ?>">
            <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
            <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
            <input type="hidden" name="agencia" value="<?php echo $agencia ?>">
            
            <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">


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
                            Fecha Pedido 
                        </th>
                        <th class="text-center">
                            Hora Pedido 
                        </th>
                        <th class="text-center">
                            Nro Pedido 
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
                        <td class="text-center"><?php echo $iteminfo['IdPedido']; ?></td>


                    </tr>

                    <tr>
                        <td colspan="8"
                            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                                <table class="table table-bordered" style="width: 100%;">

                                    <tr style="background-color: #8DB4E2; font-size: 12px;">

                                        <th class="text-center"> Sitio </th>
                                        <th class="text-center"> Almacén </th>
                                        <th class="text-center"> Fecha Entrega </th>
                                        <th class="text-center"> Forma Pago </th>
                                        <th class="text-center"> Plazo </th>
                                        <th class="text-center"> Tipo Venta </th>
                                        <th class="text-center"> Actividad Especial </th>
                                        <th class="text-center"> Grupo Precio </th>
                                        <th class="text-center"> Nro Transaccion </th>

                                    </tr>


                                    <tr>

                                        <td class="text-center"><?php echo $iteminfo['CodigoSitio']; ?>-<?php echo $iteminfo['NombreSitio']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['CodigoAlmacen']; ?>-<?php echo $iteminfo['NombreAlmacen']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['FechaEntrega']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['FormaPago']; ?></td>
                                        <?php
                                        $plazo = $iteminfo['Plazo'];
                                        $dias = ReporteFzNoVentas::model()->getDiasPlazo($plazo);
                                        ?>
                                        <td class="text-center"><?php echo $dias[0]['Dias']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['TipoVenta']; ?></td>
                                        <?php
                                        if ($iteminfo['ActividadEspecial'] == 1) {

                                            $ActividadEspecial = 'Si';
                                            ?>

                                            <?php
                                        } else {

                                            $ActividadEspecial = 'No'
                                            ?>

                                        <?php } ?>




                                        <td class="text-center"><?php echo $ActividadEspecial ?></td>
                                        <td class="text-center"><?php echo $iteminfo['NombreGrupodePrecio']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>

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

                                        <th class="text-center">Código Artículo</th>
                                        <th class="text-center">Código Variante</th>
                                        <th nowrap="nowrap" class="text-center">Nombre Artículo</th>
                                        <th nowrap="nowrap" class="text-center">Código Unidad Medida</th>
                                        <th nowrap="nowrap" class="text-center">Nombre Unidad Medida</th>

                                        <th class="text-center">Cantidad</th>

                                        <th nowrap="nowrap" class="text-center">Descuento Promocional (Dcto1)</th>
                                        <th nowrap="nowrap" class="text-center">Descuento Canal (Dcto2)</th>
                                        <th nowrap="nowrap" class="text-center">Descuento Especial (Dcto3)</th>
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
                                    $detallePedido = ReporteFzNoVentas::model()->getDetallePedido($iteminfo['IdPedido'], $iteminfo['CodAgencia']);

                                    foreach ($detallePedido as $itemDetalle) {
                                        ?>

                                        <?php
                                        $valorunitario = $itemDetalle['TotalPrecioNeto'] / $itemDetalle['Cantidad'];

                                        if ($itemDetalle['CodigoTipo'] == 'KD' || $itemDetalle['CodigoTipo'] == 'KV') {
                                            ?>
                                            <tr>

                                                <td class="text-center"><?php echo $itemDetalle['CodigoArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodVariante'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['NombreArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Cantidad'] ?></td>

                                                <td class="text-center"><?php echo $itemDetalle['DsctoLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoMultiLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoEspecial'] ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorUnitario'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Impoconsumo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Iva'] ?></td>


                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['BaseIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($valorunitario, '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['TotalPrecioNeto'], '2', ',', '.') ?></td>



                                                <td class="text-center">
                                                    <img src="images/kits.png" style="width: 55px; height: 70px;"  class="cursorpointer"  onclick="kits('<?php echo $itemDetalle['Id'] ?>', '<?php echo $iteminfo['CodAgencia'] ?>')" >
                                                </td>

                                            </tr> 
                                            <?php
                                        } else {
                                            ?>
                                            <tr>



                                                <td class="text-center"><?php echo $itemDetalle['CodigoArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodVariante'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['NombreArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Cantidad'] ?></td>

                                                <td class="text-center"><?php echo $itemDetalle['DsctoLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoMultiLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoEspecial'] ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorUnitario'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Impoconsumo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Iva'] ?></td>


                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['BaseIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($valorunitario, '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['TotalPrecioNeto'], '2', ',', '.') ?></td>

                                            </tr> 


                                        <?php } ?>


                                        <?php
                                        $valorTotalUnitario = $valorTotalUnitario + $valorunitario;
                                    }
                                    ?>

                                    <?php
                                    $valoripoconsumo = $valoripoconsumo + $iteminfo['TotalValorImpoconsumo'];
                                    $canti = $canti + $iteminfo['TotalPedido'];
                                    $valoriva = $valoriva + $iteminfo['TotalValorIva'];
                                    $baseiva = $baseiva + $iteminfo['TotalSubtotalBaseIva'];
                                    $totalpedido = $totalprecioneto + $iteminfo['ValorPedido'];
                                    ?>

                                    <tr>
                                        <th style="background-color: #8DB4E2; font-size: 12px;" class="text-center" colspan="5"><b>TOTALES</b></th> 
                                        <td class="text-center"><?php echo $canti ?></td>
                                        <td colspan="4"></td>
                                        <td class="text-center" >$<?php echo number_format($valoripoconsumo, '2', ',', '.') ?></td>  
                                        <td></td>
                                        <td class="text-center" >$<?php echo number_format($valoriva, '2', ',', '.') ?></td>
                                        <td class="text-center" >$<?php echo number_format($baseiva, '2', ',', '.') ?></td>
                                        <td class="text-center" >$<?php echo number_format($valorTotalUnitario, '2', ',', '.') ?></td>
                                        <td class="text-center" >$<?php echo number_format($totalpedido, '2', ',', '.') ?></td>

                                    </tr>

                                </table>

                            </div>   

                        </td>
                    </tr>
                <input type="hidden" value="<?php echo $sqlPedido ?>" id="sqlPedido" name="sqlPedido"/>
                <input type="hidden" value="<?php echo $fechaini ?>" id="fechaini" name="fechaini"/>
                <input type="hidden" value="<?php echo $fechafin ?>" id="fechafin" name="fechafin"/>

                </table>
            </div>    
            <?php
        }
        ?>
    </form>



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

<script>

    function genrar_Pedido_excel() {
        document.formulario_pedido_excel.submit();
    }



</script>





