<div class="panel-heading">
    <br>  
    <div align="center">
        <h2>
            <a  href="javascript:recibos();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Recibos de caja
            </b>
            <a href="javascript:genrar_Recibos_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

    <form action="  index.php?r=reportes/Reportes/AjaxExportarExcelRecibos" method=post name="formulario_recibos_excel">

        <input type="hidden" name="sqlRecibos" value="<?php echo $sqlRecibos ?>">
        <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
        <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
        <input type="hidden" name="agencia" value="<?php echo $agencia ?>">

        <?php
        foreach ($arraypuhs as $iteminfo) {
            ?>

            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                <table class="table table-bordered" style="width: 100%;">

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
                            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                                <table class="table table-bordered" style="width: 100%;">


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
                            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                                <table class="table table-bordered" style="width: 100%;">

                                    <tr style="background-color: #8DB4E2; font-size: 12px;">
                                        <th class="text-center">Número Factura</th>
                                        <th class="text-center">Valor Factura</th>
                                        <th class="text-center">Abono</th>
                                        <th class="text-center">Descuento Pronto Pago</th>
                                        <th class="text-center">Motivo Saldo</th>

                                    </tr>

                                    <?php
                                    $fac = ReporteFzNoVentas::model()->getDetalleRecibos($iteminfo['Id'], $iteminfo['CodAgencia']);

                                    $totalabono = 0;
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
                                        $totalabono = $totalabono + $iteminfoFac['ValorAbono'];
                                    }
                                    ?>

                                    <tr>
                                        <th style="font-size: 12px;" class="text-center" colspan="2">Valor Recibo</th> 
                                        <td class="text-center">$ <?php echo number_format($totalabono, '2', ',', '.') ?></td> 
                                    </tr>

                                    <tr>
                                        <th colspan="5" style="background-color: #C5D9F1; font-size: 12px;" class="text-center" colspan="2">Formas De Pago</th> 

                                    </tr>

                                    <?php
                                    $sumaefectivo = ReporteFzNoVentas::model()->getSumaEfectivo($iteminfoFac['Id'], $iteminfo['CodAgencia']);

                                    $auxiEfectivo = 0;
                                    foreach ($sumaefectivo as $itemefectivo) {
                                        if ($itemefectivo['Efectivo'] > 0) {
                                            $auxiEfectivo = $itemefectivo['Efectivo'];
                                        }
                                    }
                                    if ($auxiEfectivo > 0) {
                                        ?>
                                        <tr>

                                            <td class="text-center">
                                                <img src="images/reporteefectivo.png" style="width: 40px; height: 40px;"  class="cursorpointer" onclick="Efectivo(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>')"   title="Efectivo">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Efectivo</b></td>



                                            <td class="text-center" colspan="3">$  <?php echo number_format($auxiEfectivo, '2', ',', '.'); ?></td>

                                        </tr>
                                    <?php }
                                    
                                    $tipoConsignacion = '004';
                                    $sumaefectivoConsignacion = ReporteFzNoVentas::model()->getSumaEfectivoConsignacion($iteminfoFac['Id'], $iteminfo['CodAgencia'], $tipoConsignacion);

                                    $axufectivoconsig = 0;
                                    foreach ($sumaefectivoConsignacion as $itemefectivoconsig) {
                                        if ($itemefectivoconsig['efectivoconsignacion'] > 0) {
                                            $axufectivoconsig = $itemefectivoconsig['efectivoconsignacion'];
                                        }
                                    }

                                    if ($axufectivoconsig > 0) {
                                        ?>
                                        <tr>

                                            <td class="text-center">
                                                <img src="images/efectivoConsig.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="EfectivoConsig(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>', '<?php echo $tipoConsignacion ?>')" title="Efectivo Consignación">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Efectivo Consignación</b></td>

                                            <td class="text-center" colspan="3">$ <?php echo number_format($axufectivoconsig, '2', ',', '.') ?></td>
                                        </tr>
                                    <?php }
                                    
                                    $sumaecheque = ReporteFzNoVentas::model()->getSumaCheque($iteminfoFac['Id'], $iteminfo['CodAgencia']);

                                    $axusumaecheque = 0;
                                    foreach ($sumaecheque as $itemecheque) {
                                        if ($itemecheque['cheque'] > 0) {
                                            $axusumaecheque = $itemecheque['cheque'];
                                        }
                                    }

                                    if ($axusumaecheque > 0) {
                                        ?>

                                        <tr>
                                            <td class="text-center">
                                                <img src="images/reportecheque.png" style="width: 40px; height: 40px;"  class="cursorpointer" onclick="Cheque(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>')" title="Cheque">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Cheque</b></td>


                                            <td class="text-center" colspan="3">$ <?php echo number_format($axusumaecheque, '2', ',', '.') ?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php
                                    $sumachequeconsignacion = "";
                                    $sumachequeconsignacion = ReporteFzNoVentas::model()->getSumaChequeConsignacion($iteminfoFac['Id'], $iteminfo['CodAgencia']);

                                    $auxiConsig = 0;
                                    foreach ($sumachequeconsignacion as $itemConsig) {
                                        if ($itemConsig['chequeconsignacion'] > 0) {
                                            $auxiConsig = $itemConsig['chequeconsignacion'];
                                        }
                                    }
                                    if ($auxiConsig > 0) {
                                        ?>
                                        <tr>

                                            <td class="text-center">
                                                <img src="images/chequeConsig.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="ChequeConsig(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>')" title="Cheque Consignación">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Cheque Consignación</b></td>

                                            <td class="text-center" colspan="3">$ <?php echo number_format($auxiConsig, '2', ',', '.') ?></td>
                                        </tr>
                                    <?php } 
                                    
                                    $sumaTargetaDebito = "";
                                    $tipoConsignacion = '007';
                                    $sumaTargetaDebito = ReporteFzNoVentas::model()->getSumaEfectivoConsignacion($iteminfoFac['Id'], $iteminfo['CodAgencia'], $tipoConsignacion);

                                    $auxiTargetaDebito = 0;
                                    foreach ($sumaTargetaDebito as $itemTargetaDebito) {
                                        if ($itemTargetaDebito['efectivoconsignacion'] > 0) {
                                            $auxiTargetaDebito = $itemTargetaDebito['efectivoconsignacion'];
                                        }
                                    }
                                    if ($auxiTargetaDebito > 0) {
                                        ?>

                                        <tr>
                                            <td class="text-center">
                                                <img src="imagenes/cardebito.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="EfectivoConsig(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>', '<?php echo $tipoConsignacion ?>')" title="Targeta Devito">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Targeta Debito</b></td>

                                            <td class="text-center" colspan="3">$ <?php echo number_format($auxiTargetaDebito, '2', ',', '.') ?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php
                                    $sumaTargetaCredito = "";
                                    $tipoConsignacion = '006';
                                    $sumaTargetaCredito = ReporteFzNoVentas::model()->getSumaEfectivoConsignacion($iteminfoFac['Id'], $iteminfo['CodAgencia'], $tipoConsignacion);


                                    $auxiTargetaCredito = 0;
                                    foreach ($sumaTargetaCredito as $itemTargetaCredito) {
                                        if ($itemTargetaCredito['efectivoconsignacion'] > 0) {
                                            $auxiTargetaCredito = $itemTargetaCredito['efectivoconsignacion'];
                                        }
                                    }
                                    if ($auxiTargetaCredito > 0) {
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <img src="imagenes/cardcredito.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="EfectivoConsig(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>', '<?php echo $tipoConsignacion ?>')" title="Targeta de Credito">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Targeta de Credito</b></td>

                                            <td class="text-center" colspan="3">$ <?php echo number_format($auxiTargetaCredito, '2', ',', '.') ?></td>
                                        </tr>
                                    <?php } 
                                    $sumaTrasnferencia = "";
                                    $tipoConsignacion = '008';
                                    $sumaTrasnferencia = ReporteFzNoVentas::model()->getSumaEfectivoConsignacion($iteminfoFac['Id'], $iteminfo['CodAgencia'], $tipoConsignacion);


                                    $auxiTransferencia = 0;
                                    foreach ($sumaTrasnferencia as $itemTransferencia) {
                                        if ($itemTransferencia['efectivoconsignacion'] > 0) {
                                            $auxiTransferencia = $itemTransferencia['efectivoconsignacion'];
                                        }
                                    }
                                    if ($auxiTransferencia > 0) {
                                        ?>

                                        <tr>

                                            <td class="text-center">
                                                <img src="imagenes/tranfer.png" style="width: 40px; height: 40px;"  class="cursorpointer"  onclick="EfectivoConsig(<?php echo $iteminfoFac['Id'] ?>, '<?php echo $iteminfo['CodAgencia'] ?>', '<?php echo $tipoConsignacion ?>')" title="Transferencia">
                                            </td>
                                            <td class="text-center" style="background-color: #C5D9F1; font-size: 12px;"><b>Transferencia</b></td>

                                            <td class="text-center" colspan="3">$ <?php echo number_format($auxiTransferencia, '2', ',', '.') ?></td>
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
    </form>

    <input type="hidden" name="sqlRecibos" value="<?php echo $sqlRecibos ?>">
    <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
    <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
    <input type="hidden" name="agencia" value="<?php echo $agencia ?>">

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

<script>

    function genrar_Recibos_excel() {
        document.formulario_recibos_excel.submit();
    }

</script>
