<style>
    .visibility{
        display: none;
    }
</style>

<?php
$Nit = Consultas::model()->getNitcuentacliente($datosCliente['CuentaCliente']);
$facturasCliente = Consultas::model()->getFacturasCliente($Nit[0]['Identificacion']);
//
$session = new CHttpSession;
$session->open();
$session['ConsignacionEfec'] = array();
$session['Cheque'] = array();
$session['ConsignacionCheque'] = array();
$session['Efectivo'] = array();
$Efectivo = $session['EfectivoDetalle'] = array();
$Cheques = $session['ChequeDetalle'] = array();
$ConsignacionEfectivo = $session['ConsignacionEfecDetalle'] = array();
$ChequesConsignacion = $session['ConsignacionChequeDetalle'] = array();
?>
<div class="pageheader">
    <h2>
        <img src="images/home.png" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;" data-zona="<?php echo $zonaVentas; ?>" data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"/> 
        Recibo <span></span>
    </h2>      
</div>

<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-1">
                    <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                </div>
                <div class="col-md-11">
                    <h5> Cuenta:  <span class="text-primary"><?php echo $datosCliente['CuentaCliente']; ?></span></h5>
                    <h5> Nombre: <span class="text-primary"><?php echo $datosCliente['NombreCliente']; ?></span></h5>
                </div>
            </div>
        </div>
        <div class="panel-body" style="min-height: 450px;">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="tabs">
                <li class="active"><a href="#detalleFacturas" data-toggle="tab"><img src="images/recaudoEncabezado.png"/><strong> Recibo</strong></a></li>
                <li class="popper"><a href="#fectivo" data-toggle="tab" ><img src="images/efectivo1.png"/> <strong>Efectivo</strong></a></li>
                <li class="popper"><a href="#efectivoConsignacion" data-toggle="tab" class="popper"><img src="images/consigEfectivo.png"/> <strong>Efectivo Consignación/Tarjeta</strong></a></li>
                <li class="popper"><a href="#cheque" data-toggle="tab" class="popper"><img src="images/formaCheque.png"/> <strong>Cheque</strong></a></li>
                <li class="popper"><a href="#chequeConsignacion" data-toggle="tab"><img src="images/formachequecondig.png"/> <strong>Cheque Consignación</strong></a></li>
            </ul>
            <!-- Tab panes -->
            <form method="post" action="" id="frmGuardarRecibo">
                <div class="tab-content mb30">
                    <div class="tab-pane active" id="detalleFacturas">
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Provisional</label>
                            <div class="col-sm-3">
                                <input type="text" placeholder="" id="txtProvisional" name="txtProvisional" class="form-control"/>
                                <input type="hidden" name="txtCuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>">
                                <input type="hidden" name="txtZonaVentas" value="<?php echo $zonaVentas; ?>" id="txtZonaVentas">
                                <input type="hidden" name="txtCodAsesor" value="<?php echo Yii::app()->user->_codAsesor; ?>" id="txtCodAsesor">
                                <input type="hidden" name="txtFacturaSeleccionada" id="txtFacturaSeleccionada" value="">
                                <input type="hidden" name="txtSaldoFacturaSeleccionada" id="txtSaldoFacturaSeleccionada" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Formas de pago</label>
                            <div class="col-sm-2">
                                <a class="btn btn-primary" id="btnOptionFormasPago">Opciones</a>
                                <!--<a href="javascript:modalformapagos()" class="btn btn-primary">Opciones</a>-->
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary" id="btnTotalFormasPago">Total Formas de Pago</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Facturas: <strong id="totalFacturas" ></strong></label>
                            <label class="col-sm-2 control-label">Total: <strong id="valorTxtFacturas"></strong></label>                  
                            <input type="hidden" id="valorFacturas" /> 
                            <?php
                            $valorTotalesValorFacturas = 0;
                            foreach ($facturasCliente as $ItemValorfac) {
                                if ($ItemValorfac['Total'] != 0 || $ItemValorfac['Total'] == NULL) {
                                    if ($ItemValorfac['Total'] != NULL) {
                                        $ItemValorfac['SaldoFactura'] = $ItemValorfac['Total'];
                                    }
                                    if ($ItemValorfac['SaldoFactura'] > 0) {
                                        $valorMaximo = 0;
                                        $fechaActual = date('Y-m-d');
                                        if ($ItemValorfac['SaldoFactura'] == $ItemValorfac['ValorNetoFactura']) {
                                            if ($ItemValorfac['FechaDtoProntoPagoNivel1'] >= $fechaActual) {
                                                $valorMaximo = $ItemValorfac['DtoProntoPagoNivel1'];
                                            } else if ($ItemValorfac['FechaDtoProntoPagoNivel2'] >= $fechaActual) {
                                                $valorMaximo = $ItemValorfac['DtoProntoPagoNivel2'];
                                            }
                                        }
                                        $valorTotalesValorFacturas = (floor($valorTotalesValorFacturas) + floor($ItemValorfac['SaldoFactura'])) - floor($valorMaximo);
                                    }
                                }
                            }
                            ?>
                            <label class="col-sm-2 control-label">Valor Total Facturas: <strong><?php echo number_format(floor($valorTotalesValorFacturas), '0', ',', '.') ?></strong></label>
                            <label class="col-sm-3 control-label">Total Registró Formas de Pago: <strong id="txtTotalFormasPago"></strong></label>
                            <label class="col-sm-3 control-label"> <strong id="txtTotalFormasPago2"></strong></label>
                            <label class="col-sm-3 control-label">Saldo Formas de Pago: <strong id="txtSaldoFormasPago"></strong></label>
                            <input type="number" class="txtSaldoFormasPago" style="visibility: hidden;">
                        </div>
                        <div class="">
                            <table class="table table-email">
                                <tbody>
                                    <?php
                                    if ($facturasCliente) {
                                        /* echo '<pre>';
                                          print_r($facturasCliente); */
                                        foreach ($facturasCliente as $itemFacturas) {
                                            if ($itemFacturas['Total'] != 0 || $itemFacturas['Total'] == NULL) {
                                                if ($itemFacturas['Total'] != NULL) {
                                                    $itemFacturas['SaldoFactura'] = $itemFacturas['Total'];
                                                }
                                                if ($itemFacturas['SaldoFactura'] > 0) {
                                                    $valorMaximo = 0;
                                                    $fechaActual = date('Y-m-d');
                                                    if ($itemFacturas['SaldoFactura'] == $itemFacturas['ValorNetoFactura']) {
                                                        if ($itemFacturas['FechaDtoProntoPagoNivel1'] >= $fechaActual) {
                                                            $valorMaximo = $itemFacturas['DtoProntoPagoNivel1'];
                                                        } else if ($itemFacturas['FechaDtoProntoPagoNivel2'] >= $fechaActual) {
                                                            $valorMaximo = $itemFacturas['DtoProntoPagoNivel2'];
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td class="itemFacturasRecaudos"  
                                                            data-factura="<?php echo $itemFacturas['NumeroFactura']; ?> "
                                                            data-zona-venta="<?php echo $itemFacturas['CodigoZonaVentas']; ?>"                                    
                                                            data-valor-neto="<?php echo number_format(floor($itemFacturas['SaldoFactura']) - floor($valorMaximo)); ?>"                                     
                                                            data-fecha-vencimiento="<?php echo $itemFacturas['FechaVencimientoFactura']; ?>"
                                                            data-dto-pp1="<?php echo $itemFacturas['DtoProntoPagoNivel1']; ?>"
                                                            data-fecha-pp1="<?php echo $itemFacturas['FechaDtoProntoPagoNivel1']; ?>"
                                                            data-dto-pp1="<?php echo $itemFacturas['DtoProntoPagoNivel2']; ?>"
                                                            data-fecha-pp2="<?php echo $itemFacturas['FechaDtoProntoPagoNivel2']; ?>" 
                                                            style="width: 8% !important;" >
                                                            <img src="images/monedafactura.png" style="width: 55px;" id="img-<?php echo $itemFacturas['NumeroFactura'] ?>"/>
                                                        </td>                                 
                                                        <td class="itemFacturasRecaudos"  
                                                            data-factura="<?php echo $itemFacturas['NumeroFactura']; ?> "
                                                            data-zona-venta="<?php echo $itemFacturas['CodigoZonaVentas']; ?>"                                    
                                                            data-valor-neto="<?php echo number_format(floor($itemFacturas['SaldoFactura']) - floor($valorMaximo)); ?>"                                   
                                                            data-fecha-vencimiento="<?php echo $itemFacturas['FechaVencimientoFactura']; ?>"
                                                            data-dto-pp1="<?php echo $itemFacturas['DtoProntoPagoNivel1']; ?>"
                                                            data-fecha-pp1="<?php echo $itemFacturas['FechaDtoProntoPagoNivel1']; ?>"
                                                            data-dto-pp1="<?php echo $itemFacturas['DtoProntoPagoNivel2']; ?>"
                                                            data-fecha-pp2="<?php echo $itemFacturas['FechaDtoProntoPagoNivel2']; ?>" 
                                                            style="padding: 15px;">
                                                            <div class="media">                                        
                                                                <div class="media-body">   
                                                                    <?php
                                                                    if ($itemFacturas['NombreZonadeVentas'] == "") {
                                                                        $NombreZona = 'Sin informacion de la zona';
                                                                    } else {
                                                                        $NombreZona = $itemFacturas['NombreZonadeVentas'];
                                                                    }
                                                                    ?>
                                                                    <h4 class="text-primary">                                                 
                                                                        <strong>Zona ventas:</strong> <?php echo $NombreZona . ' - ' . $itemFacturas['CodigoZonaVentas'] ?>
                                                                    </h4>    
                                                                    <table style="width: 480px;">
                                                                        <tr>
                                                                            <td><strong>Factura #:</strong> <?php echo $itemFacturas['NumeroFactura'] ?></td>
                                                                            <td><strong>Fecha Factura:</strong>  <?php echo $itemFacturas['FechaFactura'] ?> </td>                                                    
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                $ValorFacturadecimal = $itemFacturas['ValorNetoFactura'];
                                                                                $ValorFactura = explode(".", $ValorFacturadecimal);
                                                                                $SaldoFacturadecimal = $itemFacturas['SaldoFactura'];
                                                                                $SaldoFactura = explode(".", $SaldoFacturadecimal);
                                                                                $ValorMaximodecimal = $valorMaximo;
                                                                                $ValorMaximo = explode(".", $ValorMaximodecimal);
                                                                                ?>
                                                                                <strong>Valor Neto Factura:</strong> <?php echo '$' . number_format($ValorFactura[0]) ?>
                                                                                <input type="hidden" id="valorNetoFactura-<?php echo $itemFacturas['NumeroFactura'] ?>" value="<?php echo $itemFacturas['ValorNetoFactura']; ?>"/>
                                                                                <input value="<?php echo $ValorFactura[0] ?>" type="hidden" id="ValorTotalFactura">
                                                                            </td>
                                                                            <td>
                                                                                <strong>Saldo:</strong> <span id="saldoTxtFactura-<?php echo $itemFacturas['NumeroFactura'] ?>"><?php echo '$' . number_format($SaldoFactura[0] - $ValorMaximo[0]) ?> </span>
                                                                                <input type="hidden" id="saldoFactura-<?php echo $itemFacturas['NumeroFactura'] ?>" value="<?php echo $SaldoFactura[0] - $ValorMaximo[0]; ?>"/>
                                                                            </td>

                                                                        </tr>
                                                                        <tr>
                                                                           <!--<td><strong>Abono:</strong> <?php //echo '$' . number_format($itemFacturas['saldoAbonado'])            ?></td> -->  
                                                                            <td>
                                                                                <strong>Días vencimiento:</strong>  <?php echo $itemFacturas['DiasPago']; ?>  
                                                                            </td>
                                                                            <!--<td><strong>Días a vencer:</strong> <?php
                                                                            /* if($itemFacturas['FechaVencimientoFactura']<=  date('Y-m-d')){
                                                                              echo $diasVencer='Factura vencida';
                                                                              $diasMora=Yii::app()->controller->diff_dte( date('Y-m-d'),$itemFacturas['FechaVencimientoFactura'] );
                                                                              }else{
                                                                              echo $diasVencer= Yii::app()->controller->diff_dte(date('Y-m-d'), $itemFacturas['FechaVencimientoFactura'] ).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                              $diasMora='0';
                                                                              } */
                                                                            ?>  </td>-->
                                                                            <td><strong>Fecha Vencimiento:</strong> <?php echo $itemFacturas['FechaVencimientoFactura']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Dto PP1:</strong>$ <?php echo number_format($itemFacturas['DtoProntoPagoNivel1'], '0', ',', '.'); ?></td>
                                                                            <td><strong>Fecha Dto PP1:</strong> <?php echo $itemFacturas['FechaDtoProntoPagoNivel1']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Dto PP2:</strong>$ <?php echo number_format(floor($itemFacturas['DtoProntoPagoNivel2']), '0', ',', '.'); ?></td>
                                                                            <td><strong>Fecha Dto PP2:</strong> <?php echo $itemFacturas['FechaDtoProntoPagoNivel2']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <h4 class="text-primary">Abono: <strong class="abonoFactura" data-factura="<?php echo $itemFacturas['NumeroFactura'] ?>" id="abonoTxt-<?php echo $itemFacturas['NumeroFactura'] ?>">0</strong>
                                                                                </h4>
                                                                                <input type="hidden" class="abonos-item" data-factura="<?php echo $itemFacturas['NumeroFactura'] ?>" id="abono-<?php echo $itemFacturas['NumeroFactura'] ?>" />
                                                                            </td>
                                                                            <td>
                                                                                <h4 class="text-primary">Descuento PP: <strong class="" data-factura="<?php echo $itemFacturas['NumeroFactura'] ?>" id="descuentoPPTxt-<?php echo $itemFacturas['NumeroFactura'] ?>">0</strong>
                                                                                </h4>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td ><strong> Cuenta cliente:</strong><?php echo $itemFacturas['CuentaCliente']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><strong> Razon social:</strong> <?php echo $itemFacturas['NombreCliente']; ?></td>
                                                                        </tr>
                                                                    </table>
                                                                    <input type="hidden" id="txtValorProntoPagoAplicar-<?php echo $itemFacturas['NumeroFactura'] ?>" value="<?php echo $valorMaximo; ?>"/>
                                                                    <input type="hidden" id="txtFactura-<?php echo $itemFacturas['NumeroFactura'] ?>" name="txtFactura[]"/>
                                                                    <input type="hidden" id="txtZonaVentasFactura-<?php echo $itemFacturas['NumeroFactura'] ?>" name="txtZonaVentasFactura[]"/>
                                                                    <input type="hidden" id="txtMotivoSaldo-<?php echo $itemFacturas['NumeroFactura'] ?>" name="txtMotivoSaldo[]"/>
                                                                    <input type="hidden" id="txtSaldo-<?php echo $itemFacturas['NumeroFactura'] ?>" name="txtSaldo[]"/>
                                                                    <input type="hidden" id="txtDescuentoPPValor-<?php echo $itemFacturas['NumeroFactura'] ?>" name="txtDescuentoPPValor[]"/>
                                                                    <input type="hidden" id="txtDescuentoPPFactura-<?php echo $itemFacturas['NumeroFactura'] ?>" name="txtDescuentoPPFactura[]"/>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td id="eliminarAbono-<?php echo $itemFacturas['NumeroFactura'] ?>">
                                                          <!-- <img src="images/delete.png" style="width: 25px;" class="cursorpointer eliminarFactura" data-factura="<?php //echo $itemFacturas['NumeroFactura']            ?>"/> --->
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="fectivo">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right" >Factura</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="" class="form-control facturaRecibo" readonly="readonly" id="" name=""/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right" >Valor Efectivo</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="TotalEfectivo">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right" >Saldo Efectivo</label>
                                    <div class="col-sm-6">
                                        <input type="text" id="SaldoEfectivo" class="form-control" readonly="true">
                                        <input type="hidden" id="txtSalEfHid">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label text-right" >Valor</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="" value="<?php echo $Efectivo['ValorEfectivo'] ?>" class="form-control" id="txtFacturaEc" name="txtValorEfectivo" />
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <a class="btn btn-default" id="btnAgregarEfectivo">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                                </div>   
                                <div class="row" id="tblEfectivo"> </div>  
                            </div>
                        </div>
                    </div>   
                    <!--AQUI Consignacion Efectivo-->
                    <div class="tab-pane" id="efectivoConsignacion">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right" >Factura</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control facturaRecibo" readonly="readonly" id="FactCe" name=""/>
                                </div>
                            </div>      
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Número</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="numeroconsignacion">
                                        <?php foreach ($ConsignacionEfectivo as $itemNumConsig): ?>
                                            <option value="<?php echo $itemNumConsig['txtNumeroEc'] ?>"><?php echo $itemNumConsig['txtNumeroEc'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Banco</label>
                                <div class="col-sm-6">
                                    <select id="Bancos" class="form-control" disabled="true">
                                        <option value="<?php echo $ConsignacionEfectivo[0]['txtBancoEc'] ?>"><?php echo $ConsignacionEfectivo[0]['txtBancoEc'] ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cod Banco</label>
                                <div class="col-sm-3">
                                    <input type="text"  value="<?php echo $ConsignacionEfectivo[0]['txtCodBancoEc'] ?>" placeholder="" class="form-control" id="txtCodBancoEcNo" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Banco</label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $ConsignacionEfectivo[0]['txtBanco'] ?>" placeholder="" class="form-control" id="txtBancoNo" readonly="readonly"/>
                                </div>          
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cuenta</label>
                                <div class="col-sm-6">
                                    <select class="form-control"  id="txtCuentaNo" readonly="readonly">
                                        <option value="<?php echo $ConsignacionEfectivo[0]['txtCuenta'] ?>"><?php echo $ConsignacionEfectivo[0]['txtCuenta'] ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Fecha</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtFechaEcNo"  readonly="readonly" style="width: 85%" value="<?php echo $ConsignacionEfectivo[0]['txtFechaEc'] ?>"/>
                                    <!--<img class="ui-datepicker-trigger" src="images/calendar.png" alt="Seleccione una fecha" title="Seleccione una fecha">-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor Total Consignación</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtValorEcConsignacion"  value="<?php echo number_format($ConsignacionEfectivo[0]['txtValorTotalEcSaldo'], '2', ',', '.') ?>" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Saldo Consignación</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtValorEcSaldoConsignacion" value="<?php echo number_format($ConsignacionEfectivo[0]['txtValorEcSaldo'], '2', ',', '.') ?>" readonly="readonly"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control" id="txtValorEc"/>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarConEfec">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div>
                            <div class="mb30"></div>
                            <div class="row" id="tblConsignacionEfectivo"> </div>
                        </div>
                    </div>
                    <!--  aqui va Cheque  -->
                    <div class="tab-pane" id="cheque">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right" >Factura</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" class="form-control facturaRecibo" readonly="readonly" id="FactCh" name=""/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right" >Numero</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="numeros">
                                        <?php foreach ($Cheques as $itemNumCheque): ?>
                                            <option value="<?php echo $itemNumCheque['txtNumeroCheque'] ?>-<?php echo $itemNumCheque['txtBancoCheque'] ?>"><?php echo $itemNumCheque['txtNumeroCheque'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cod Banco</label>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="" class="form-control txtLenghtCodBanco" id="txtBancoChequeNo" value="<?php echo $Cheques[0]['txtBancoCheque'] ?>" readonly="readonly"/>
                                    <label id="MsgBancoNo"></label> 
                                </div>
                                <div class="col-sm-5">
                                    <label><?php echo $Cheques[0]['textoBancoCheque'] ?></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Cuenta</label>
                                <div class="col-sm-6">
                                    <input type="text"  id="txtCuentaChequeNo" class="form-control txtLenghtnumero" placeholder="Máximo 20 caracteres" value="<?php echo $Cheques[0]['txtCuentaCheque'] ?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Fecha</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" id="txtFechaChequeNo" class="form-control" readonly="readonly" style="width: 85%" value="<?php echo $Cheques[0]['txtFechaCheque'] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Girado a</label>
                                <div class="col-sm-6">                  
                                    <select class="form-control" id="txtGiradoNo" readonly="readonly">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Otro</label>
                                <div class="col-sm-6">                  
                                    <input readonly="readonly"  type="text" id="txtOtroNo"  class="form-control"  value="<?php echo $Cheques[0]['txtOtro'] ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor Cheque</label>
                                <div class="col-sm-6">
                                    <input type="text"  id="txtvalorch" class="form-control" value="<?php echo number_format($Cheques[0]['txtValorTotalChequeSaldo'], '2', ',', '.') ?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Saldo Cheque</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" id="txtSaldoCheque" class="form-control" value="<?php echo number_format($Cheques[0]['txtValorChequeSaldo'], '2', ',', '.') ?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label text-right">Valor</label>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="" id="txtValorCheque" class="form-control">
                                </div>
                            </div>     
                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarCheque">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div>    
                            <div class="row" id="tblcheque">
                            </div>   
                        </div>  
                    </div>
                    <!-- aqui va Cheque Consignacion  -->
                    <div class="tab-pane" id="chequeConsignacion">
                        <div class="col-sm-9">
                            <h5 class="text-primary">Datos Consignación</h5>
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right" >Factura</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" id="txtformaPago" name=""> 
                                            <input type="text" placeholder="" class="form-control facturaRecibo" readonly="readonly" id="FactChc" name=""/>
                                        </div>
                                    </div>   
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">

                                </div><!-- col-sm-6 -->
                            </div>
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">                    
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Número</label>
                                        <div class="col-sm-8">
                                            <select id="txtNumeroECcNo" class="form-control">
                                                <?php foreach ($ChequesConsignacion as $itemoption): ?>
                                                    <option value="<?php echo $itemoption['txtNumeroECc'] ?>"><?php echo $itemoption['txtNumeroECc'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Banco</label>
                                        <div class="col-sm-8">                    
                                            <select id="txtBancosNo" class="form-control" disabled="true">
                                                <option value="<?php echo $ChequesConsignacion[0]['txtBancoECc'] ?>"><?php echo $ChequesConsignacion[0]['txtBancoECc'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6"> 
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Cod Banco</label>
                                        <div class="col-sm-3">
                                            <input type="text" placeholder="" class="form-control txtLenghtCodBanco" id="txtCodBancoECcNo" readonly="readonly" value="<?php echo $ChequesConsignacion[0]['txtCodBancoECc'] ?>"/>
                                        </div>
                                    </div>  
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Banco</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="" class="form-control" id="txtNombreBancoECcNo" readonly="readonly" value="<?php echo $ChequesConsignacion[0]['txtNombreBancoECc'] ?>"/>
                                        </div>          
                                    </div> 
                                </div> 
                            </div>     
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Cuenta</label>
                                        <div class="col-sm-8">
                                            <select id="txtCuentasNo" class="form-control">
                                                <option value="<?php echo $ChequesConsignacion[0]['txtCuentaECc'] ?>"><?php echo $ChequesConsignacion[0]['txtCuentaECc'] ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Fecha</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lastname" id="txtFechaECcNo" class="form-control" readonly="readonly" style="width: 85%" value="<?php echo $ChequesConsignacion[0]['txtFechaECc'] ?>"/>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>
                            <hr/>
                            <h5 class="text-primary">Datos Cheque</h5>
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Número</label>
                                        <div class="col-sm-8">
                                            <select id="txtNumeroDCcNo" class="form-control">
                                                <?php
                                                foreach ($ChequesConsignacion as $Item) {
                                                    foreach ($Item['detalle'] as $ItemDetail) {
                                                        ?>
                                                        <option value="<?php echo $ItemDetail['txtNumeroDCc']; ?>"><?php echo $ItemDetail['txtNumeroDCc'] ?></option> 
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label text-right">Cod Banco</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="" class="form-control txtLenghtCodBanco" id="txtBancoDCcNo" readonly="readonly" value="<?php echo $ChequesConsignacion[0]['detalle'][0]['txtCodBancoDCc'] ?>"/>
                                        </div>          
                                    </div> 
                                    <label id="Msg"><?php echo $ChequesConsignacion[0]['detalle'][0]['MsgBancoCc'] ?></label>
                                </div> 
                            </div>
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Cuenta</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" id="txtCuentaDCcNo" readonly="readonly" class="form-control txtLenghtnumero" placeholder="Máximo 20 caracteres" value="<?php echo $ChequesConsignacion[0]['detalle'][0]['txtCuentaDCc'] ?>">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Fecha</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="lastname" id="txtFechaDCcNo" class="form-control" readonly="readonly" style="width: 85%" value="<?php echo $ChequesConsignacion[0]['detalle'][0]['txtFechaDCc'] ?>"/>
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>   
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Valor Total Cheque</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" id="txtValorDCcTotalCheque" readonly="readonly" class="form-control" value="<?php echo $ChequesConsignacion[0]['detalle'][0]['txtValorTotalDCcSaldo'] ?>">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Saldo Cheque</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" id="txtValorDCcSaldoCheque" readonly="readonly" class="form-control" value="<?php echo $ChequesConsignacion[0]['detalle'][0]['txtValorDCcSaldo'] ?>">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>     
                            <div class="row" style="margin: 5px;">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right">Valor</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="firstname" id="txtValorDCc" class="form-control">
                                        </div>
                                    </div>
                                </div><!-- col-sm-6 -->
                            </div>
                            <div class="form-group text-center">
                                <a class="btn btn-default" id="btnAgregarChequeConsignado">Agregar <img src="images/AgregarNew.png" style="width: 30px;"/></a>                          
                            </div>  
                            <div class="row" id="tblConsignacionCheque"> </div>
                        </div>
                    </div>
                    <div class="mb30"></div>
                    <div class="row">                
                        <div class="cols-sm-12 text-center">
                            <a class="btn btn-primary" id="btnGuardarRecibo">Guardar Recibo</a>
                        </div>                
                    </div> 
                </div>            
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="_alertaSinFacturas" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">El cliente no tiene facturas pendientes por recaudar</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <a href="index.php?r=Clientes/menuClientes&cliente=<?php echo $datosCliente['CuentaCliente']; ?>&zonaVentas=<?php echo $zonaVentas; ?>" class="btn btn-primary" >Aceptar</a>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_ModalEliminarCh" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="_ModalEliminarConsigEfectivo" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_ModalEliminarChequeConsignacion" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_ModalEliminarConsignacion" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_ModalEliminarEfec" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_alertaSaldoAFavor" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary okSaldoFavor" type="button">Aceptar</button>
                <button data-dismiss="modal" class="btn btn-primary" type="button">Cancelar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_totalformasdepago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 660px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Total Formas de Pagos</h4>
            </div>
            <div class="modal-body" id="infoFormasPago">
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="_alertConfirmationMenuRecibos" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id=""></h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <a href="index.php?r=Clientes/menuClientes&cliente=<?php echo $datosCliente['CuentaCliente']; ?>&zonaVentas=<?php echo $zonaVentas; ?>" class="btn btn-primary">SI</a> 
                <button data-dismiss="modal" class="btn btn-primary" type="button">NO</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<?php
$arrayAux = array();
foreach ($datos as $item) {
    $arrayItem = array(
        'value' => $item['CodMotivoSaldo'],
        'descripcion' => $item['Nombre'],
    );

    array_push($arrayAux, $arrayItem);
}
?>
<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_formaspagos'); ?>
<?php $this->renderPartial('//mensajes/_modalEfectivo'); ?>
<?php $this->renderPartial('//mensajes/_modalCheque'); ?>
<?php $this->renderPartial('//mensajes/_modalConsignacionEfectivo'); ?>
<?php $this->renderPartial('//mensajes/_modalChequeConsignacion'); ?>
<?php //$this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>
<?php $this->renderPartial('//mensajes/_alertaSaldoAFavor'); ?>
<?php $this->renderPartial('//mensajes/_alertInformacionRecibo'); ?>
<?php $this->renderPartial('//mensajes/_alertaInput'); ?>
<?php $this->renderPartial('//mensajes/_alertaSelect', array('datos' => $arrayAux)); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationMenu', array('zonaVentas' => $zonaVentas, 'cuentaCliente' => $datosCliente['CuentaCliente'])); ?>
<?php //$this->renderPartial('//mensajes/_alertConfirmationMenuRecibos', array('zonaVentas' => $zonaVentas, 'cuentaCliente' => $datosCliente['CuentaCliente'])); ?>
<?php
$totalFacturasCanceladas = 0;
foreach ($facturasCliente as $itemFacturas) {
    if ($itemFacturas['Total'] != 0 || $itemFacturas['Total'] == NULL) {
        $totalFacturasCanceladas++;
    }
}
?>
<?php if ($totalFacturasCanceladas == 0) { ?>
    <script>
        $(document).ready(function () {
            $('#_alertaSinFacturas').modal('show');
        });
    </script>   
<?php } else { ?>
    <script>
        $(document).ready(function () {
            $('#_alertInformacionRecibo .text-modal-body').html('Recuerde registrar las formas de pago en el botón de opciones.');
            $('#_alertInformacionRecibo').modal('show');
        });
    </script>

<?php } ?>
