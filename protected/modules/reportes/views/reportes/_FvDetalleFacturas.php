   
<div class="panel-heading">
    <br>  
    <div align="center">
        <h2>
            <a  href="javascript:facturas();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Facturas
            </b>
            <a href="javascript:genrar_Facturas_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>



    <?php
    foreach ($arraypuhs as $iteminfo) {

        $canti = 0;
        $valoriva = 0;
        $baseiva = 0;
        $totalprecioneto = 0;
        $valoripoconsumo = 0;
        ?>

        <form action="index.php?r=reportes/Reportes/AjaxExportarExcelfactura" method=post name="formulario_factura_excel">

            <input type="hidden" name="sqlFactura" value="<?php echo $sqlFactura ?>">
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
                            Fecha Factura 
                        </th>
                        <th class="text-center">
                            Hora Factura 
                        </th>
                        <th class="text-center">
                            Nro Pedido 
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
                        <td class="text-center"><?php echo $iteminfo['FechaPedido']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['HoraEnviado']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['IdPedido']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>


                    </tr>

                    <tr>
                        <td colspan="8"
                            <div class="table-responsive">

                                <table class="table table-bordered">

                                    <tr style="background-color: #8DB4E2; font-size: 12px;">

                                        <th class="text-center"> Sitio </th>
                                        <th class="text-center"> Almacén </th>
                                        <th class="text-center"> Fecha Entrega </th>
                                        <th class="text-center"> Forma Pago </th>
                                        <th class="text-center"> Plazo </th>
                                        <th class="text-center"> Tipo Venta </th>
                                        <th class="text-center"> Actividad Especial </th>
                                        <th class="text-center"> Grupo Precio </th>
                                        <th class="text-center">Número Factura </th>

                                    </tr>


                                    <tr>

                                        <td class="text-center"><?php echo $iteminfo['NombreSitio']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['NombreAlmacen']; ?></td>
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


                                        <td class="text-center"><?php echo $ActividadEspecial; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['NombreGrupodePrecio']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['NroFactura']; ?></td>

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

                                    <tr style="background-color: #C5D9F1; font-size: 10px;">

                                        <th class="text-center">Código Variante</th>
                                        <th class="text-center">Código Artículo</th>
                                        <th nowrap="nowrap"  class="text-center">Nombre Artículo</th>
                                        <th nowrap="nowrap"  class="text-center">Código Unidad Medida</th>
                                        <th nowrap="nowrap" class="text-center">Cantidad facturada</th>

                                        <th nowrap="nowrap" class="text-center">Nro lote</th>

                                        <th nowrap="nowrap"  class="text-center">Descuento Promocional</th>
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
                                    $detallePedido = ReporteFzNoVentas::model()->getDetalleFactura($iteminfo['IdPedido'], $iteminfo['CodAgencia']);

                                    foreach ($detallePedido as $itemDetalle) {
                                        ?>

                                        <?php
                                        if ($itemDetalle['CodigoTipo'] == 'KD') {
                                            ?>
                                            <tr>

                                                <td class="text-center"><?php echo $itemDetalle['CodVariante'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodigoArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['NombreArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Cantidad'] ?></td>
                                                <td class="text-center"> </td>

                                                <td class="text-center"><?php echo $itemDetalle['DsctoMultiLinea'] ?></td>
                                                <!                                     <td class="text-center"><?php echo $itemDetalle['DsctoLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoEspecial'] ?></td> 
                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorUnitario'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Impoconsumo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Iva'] ?></td>

                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['BaseIva'], '2', ',', '.') ?></td>
                                                <td class="text-center">pp</td>  
                                                <td class="text-center"><?php echo number_format($itemDetalle['TotalPrecioNeto'], '2', ',', '.') ?></td>


                                                <td class="text-center">
                                                    <img src="images/kits.png" style="width: 55px; height: 70px;"  class="cursorpointer"  onclick="kitsFacturas('<?php echo $itemDetalle['Id'] ?>', '<?php echo $iteminfo['CodAgencia'] ?>')" >
                                                </td>

                                            </tr> 
            <?php
        } else {
            ?>
                                            <tr>

                                                <td class="text-center"><?php echo $itemDetalle['CodVariante'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodigoArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['NombreArticulo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['CodigoUnidadMedida'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Cantidad'] ?></td>
                                                <td class="text-center"> </td>

                                                <td class="text-center"><?php echo $itemDetalle['DsctoMultiLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoLinea'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['DsctoEspecial'] ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorUnitario'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Impoconsumo'] ?></td>
                                                <td class="text-center"><?php echo $itemDetalle['Iva'] ?></td>


                                                <td class="text-center"><?php echo number_format($itemDetalle['ValorIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['BaseIva'], '2', ',', '.') ?></td>
                                                <td class="text-center"></td>
                                                <td class="text-center"><?php echo number_format($itemDetalle['TotalPrecioNeto'], '2', ',', '.') ?></td>

                                            </tr> 

        <?php } ?>
                                        <?php }
                                    ?>

                                    <?php
                                    $valoripoconsumo = $valoripoconsumo + $iteminfo['TotalValorImpoconsumo'];
                                    $canti = $canti + $iteminfo['TotalPedido'];
                                    $valoriva = $valoriva + $iteminfo['TotalValorIva'];
                                    $baseiva = $baseiva + $iteminfo['TotalSubtotalBaseIva'];
                                    $totalpedido = $totalprecioneto + $iteminfo['ValorPedido'];
                                    ?>

                                    <tr>
                                        <th style="background-color: #8DB4E2; font-size: 12px;" class="text-center" colspan="4"><b>TOTALES</b></th> 
                                        <td class="text-center"><?php echo $canti ?></td>
                                        <td colspan="5"></td>
                                        <td class="text-center" >$<?php echo number_format($valoripoconsumo, '2', ',', '.') ?></td>  
                                        <td></td>
                                        <td class="text-center" >$<?php echo number_format($valoriva, '2', ',', '.') ?></td>
                                        <td class="text-center" >$<?php echo number_format($baseiva, '2', ',', '.') ?></td>
                                        <td class="text-center"></td>
                                        <td class="text-center" >$<?php echo number_format($totalpedido, '2', ',', '.') ?></td>

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
            
                <input type="hidden" value="<?php echo $sqlFactura ?>" id="sqlFactura" name="sqlFactura"/>
                <input type="hidden" value="<?php echo $fechaini ?>" id="fechaini" name="fechaini"/>
                <input type="hidden" value="<?php echo $fechafin ?>" id="fechafin" name="fechafin"/>
        </form>  

</div>

<div class="modal fade" id="_FvDetalleKitsFacturas" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content" style="width: 500px;">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Detalle del Kit Autoventa</h5>
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

    function genrar_Facturas_excel() {
        document.formulario_factura_excel.submit();
    }



</script>



