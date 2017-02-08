<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if (!Yii::app()->user->isGuest) {
    $Nombre = Yii::app()->user->_nombres . " " . Yii::app()->user->_apellidos;
    $connection = Multiple::getConexionZonaVentas();
    $sql = "SELECT * FROM `jerarquiacomercial` WHERE `NombreEmpleado` = '$Nombre'";
    $command = $connection->createCommand($sql);
    $dataReader = $command->queryAll();
    $CodigoZonaVentas = $dataReader[0]["CodigoZonaVentas"];

    $connection2 = Multiple::getConexionZonaVentas();
    $sql2 = "SELECT * FROM `zonaventas` WHERE `CodZonaVentas` = '$CodigoZonaVentas'";
    $command2 = $connection2->createCommand($sql2);
    $dataReader2 = $command2->queryAll();
    $CodigoGrupoVentas = $dataReader2[0]["CodigoGrupoVentas"];

    $connection3 = Multiple::getConexionZonaVentas();
    $sql3 = "SELECT  PermitirModificarDescuentoLinea,PermitirModifiarDescuentoMultiLinea FROM `gruposventas` WHERE `CodigoGrupoVentas` = '$CodigoGrupoVentas'";
    $command3 = $connection3->createCommand($sql3);
    $dataReader3 = $command3->queryAll();
    $PermisoDescuentoLinea = $dataReader3[0]["PermitirModificarDescuentoLinea"];
    $PermisoDescuentoMultiLinea = $dataReader3[0]["PermitirModifiarDescuentoMultiLinea"];

    $connection4 = Multiple::getConexionZonaVentas();
    $sql4 = "SELECT  (`PorcentajeDescuentoMultilinea1`+`PorcentajeDescuentoMultilinea2`) AS PorcentajeDescuentoMultiLinea, Max(`FechaInicio`) FROM `acuerdoscomercialesdescuentomultilinea` WHERE `CodigoGrupoArticulosDescuentoMultilinea` = '$CodigoGrupoVentas' ";
    $command4 = $connection4->createCommand($sql4);
    $dataReader4 = $command4->queryAll();
    $PorDescuentoMultiLinea = $dataReader4[0]["PorcentajeDescuentoMultiLinea"];

    $connection5 = Multiple::getConexionZonaVentas();
    $sql5 = "SELECT MIN( PorcentajeDescuentoLinea1 + PorcentajeDescuentoLinea2 ) AS PorcentajeDescuentoLinea, MAX(`FechaInicio`) 
              FROM  `acuerdoscomercialesdescuentolinea` 
              WHERE  `CodigoClienteGrupoDescuentoLinea` = '$CodigoGrupoVentas'";
    $command5 = $connection5->createCommand($sql5);
    $dataReader5 = $command5->queryAll();
    $PorDescuentoLinea = $dataReader5[0]["PorcentajeDescuentoLinea"];
}

$cont = 0;

$session = new CHttpSession;
$session->open();

$arrayDatoKit = array();

if ($session['listaMateriales']) {
    $datosKit = $session['listaMateriales'];
} else {
    $datosKit = array();
}

/* if ($session['componenteKitVirtual']) {
  $arrayDatoKit = $session['componenteKitVirtual'];
  } else {
  $arrayDatoKit = array();
  } */

if ($session['componenteKitDinamicoActivity']) {
    $arrayNuevo = $session['componenteKitDinamicoActivity'];
} else {
    $arrayNuevo = array();
}//Implementamos nueva estructura a la hora de traer los datos por ende se le asigno array nuevo 

$arrayDatosKitDinamico = "";

if ($txttipokit === 'dinamico') {

    $arrayDatosKitDinamico = $arrayNuevo;
} else if ($txttipokit === 'virtual') {


    foreach ($datosKit as $item) {


        if ($item['LMCodigoVarianteKit'] == $txtCodigoVariante) {

            $PrecioVariante = $item['LMDPrecioVentaBaseVariante'];
            $CantidadComponentes = $item['LMDCantidadComponente'];
            $CodigoVarianteComponente = $item['LMDCodigoVarianteComponente'];
            $PorcentajedeIVAComponente = $item['PorcentajedeIVAComponente'];
            $ValorIMPOCONSUMOComponente = $item['ValorIMPOCONSUMOComponente'];

            $aray = array(
                'PrecioVariante' => $PrecioVariante,
                'CantidadComponentes' => $CantidadComponentes,
                'CodigoVarianteComponente' => $CodigoVarianteComponente,
                'PorcentajedeIVAComponente' => $PorcentajedeIVAComponente,
                'ValorIMPOCONSUMOComponente' => $ValorIMPOCONSUMOComponente
            );

            array_push($arrayDatoKit, $aray);
        }
    }
}
/* echo '<pre>';
  print_r($arrayDatoKit);

  exit(); */
/* echo '<pre>';
  print_r($arrayDatoKit);
  exit(); */


if ($session['portafolio']) {
    $datosPortafolio = $session['portafolio'];
} else {
    $datosPortafolio = array();
}

//$session['pedidoForm']


if ($session['pedidoForm']) {
    $datosPedido = $session['pedidoForm'];
} else {
    $datosPedido = array();
}

foreach ($datosPortafolio as $itemPortafolio) {

    /* echo '<pre>';
      print_r($itemPortafolio); */

    $itemPorCodigoVariante = $itemPortafolio['CodigoVariante'];
    $itemPorCodigoArticulo = $itemPortafolio['CodigoArticulo'];

    if ($itemPorCodigoVariante == $txtCodigoVariante && $itemPorCodigoArticulo == $txtCodigoArticulo) {

        $itemPorNombreArticulo = $itemPortafolio['NombreArticulo'];
        $itemPorCodigoTipo = $itemPortafolio['CodigoTipo'];
        $itemPorCodigoCaracteristica1 = $itemPortafolio['CodigoCaracteristica1'];
        $itemPorCodigoCaracteristica2 = $itemPortafolio['CodigoCaracteristica2'];
        $itemPorPorcentajedeIVA = $itemPortafolio['PorcentajedeIVA'];
        $itemPorValorIMPOCONSUMO = $itemPortafolio['ValorIMPOCONSUMO'];
        $itemPorCodigoGrupoVentas = $itemPortafolio['CodigoGrupoVentas'];
        $itemPorCuentaProveedor = $itemPortafolio['CuentaProveedor'];
        $itemPorIdentificadorProductoNuevo = $itemPortafolio['IdentificadorProductoNuevo'];
        $itemPorCodigoGrupoDescuentoLinea = $itemPortafolio['CodigoGrupoDescuentoLinea'];
        $itemPorCodigoGrupoDescuentoMultiLinea = $itemPortafolio['CodigoGrupoDescuentoMultiLinea'];
        $itemPortxtCodigoGrupoArticulosDescuentoMultilinea = $itemPortafolio['CodigoGrupoArticulosDescuentoMultilinea'];


        $itemPortxtIdAcuerdoLinea = $itemPortafolio['txtIdAcuerdoLinea'];
        $itemPortxtIdAcuerdoMultilinea = $itemPortafolio['txtIdAcuerdoMultilinea'];


        $itemPorACPrecioVenta = $itemPortafolio['ACPrecioVenta'];
        $itemPorACIdAcuerdoComercial = $itemPortafolio['ACIdAcuerdoComercial'];
        $itemPorACCodigoUnidadMedida = $itemPortafolio['ACCodigoUnidadMedida'];
        $itemPorACNombreUnidadMedida = $itemPortafolio['ACNombreUnidadMedida'];


        if (!empty($arrayDatosKitDinamico)) {
            $ValorSinImpuestoKit = 0;
            $ValorTodoConImpuestosKit = 0;
            foreach ($arrayDatosKitDinamico as $itemDinamica) {

                $ValorComponetesKit = $itemDinamica->txtKitPrecioVentaBaseVariante * $itemDinamica->cantidad;
                $ValorSinImpuestoKit = $ValorSinImpuestoKit + $ValorComponetesKit;
                $ValorivaComponenteskit = $itemDinamica->txtKitPrecioVentaBaseVariante * $itemDinamica->txtkitiva / 100;
                $TotalTodoComponentesKit = $itemDinamica->txtKitPrecioVentaBaseVariante + $ValorivaComponenteskit + $itemDinamica->txtkitipoconsumo;
                $ValorConImpuestosKit = $TotalTodoComponentesKit * $itemDinamica->cantidad;
                $ValorTodoConImpuestosKit = $ValorTodoConImpuestosKit + $ValorConImpuestosKit;
            }
            $itemPorACPrecioVenta = $ValorSinImpuestoKit;
            $TotalValorConImpuesto = $ValorTodoConImpuestosKit;
        } else if (!empty($arrayDatoKit)) {

            $ValorSinImpuestoKit = 0;
            $ValorTodoConImpuestosKit = 0;
            foreach ($arrayDatoKit as $item) {

                $ValorComponetesKit = $item['PrecioVariante'] * $item['CantidadComponentes'];
                $ValorSinImpuestoKit = $ValorSinImpuestoKit + $ValorComponetesKit;
                $ValorivaComponenteskit = $item['PrecioVariante'] * $item['PorcentajedeIVAComponente'] / 100;
                $TotalTodoComponentesKit = $item['PrecioVariante'] + $ValorivaComponenteskit + $item['ValorIMPOCONSUMOComponente'];
                $ValorConImpuestosKit = $TotalTodoComponentesKit * $item['CantidadComponentes'];
                $ValorTodoConImpuestosKit = $ValorTodoConImpuestosKit + $ValorConImpuestosKit;
            }
            $itemPorACPrecioVenta = $ValorSinImpuestoKit;
            $TotalValorConImpuesto = $ValorTodoConImpuestosKit;
        } else {
            //aqui se calcula el valor impuesto 
            $valorIva = $itemPorACPrecioVenta * $itemPorPorcentajedeIVA / 100;
            $valorProducto = $itemPorACPrecioVenta + $valorIva;
            $TotalValorConImpuesto = $valorProducto + $itemPorValorIMPOCONSUMO;
        }

        if ($txtTipoVenta == "Consignacion") {
            $itemPorSPDisponible = $itemPortafolio['SADisponible'];
            $itemPorSPNombreUnidadMedida = $itemPortafolio['SANombreUnidadMedida'];
            $itemPorSPCodigoUnidadMedida = $itemPortafolio['SACodigoUnidadMedida'];
            $itemPorSaldoDisponibleVenta = $itemPortafolio['SaldoDisponibleVentaAutoventa'];
        } else {
            $itemPorSPDisponible = $itemPortafolio['SPDisponible'];
            $itemPorSPNombreUnidadMedida = $itemPortafolio['SPNombreUnidadMedida'];
            $itemPorSPCodigoUnidadMedida = $itemPortafolio['SPCodigoUnidadMedida'];
            $itemPorSaldoDisponibleVenta = $itemPortafolio['SaldoDisponibleVenta'];
        }



        break;
    }
    //if()
}


//Consultamos si existe el proucto
$pedidoCodigoVariante = '';
$pedidoCodigoArticulo = '';
$pedidoCantidad = '';
$pedidoDescuentoEspecial = '';
$pedidoDescuentoEspecialSelect = '';
$pedidoDescuentoEspecialAltipal = '';
$conta = 0;
foreach ($datosPedido as $itemPedido) {

    $pedidoCodigoVariante = $itemPedido['variante'];
    $pedidoCodigoArticulo = $itemPedido['articulo'];

    if ($txtCodigoVariante == $pedidoCodigoVariante && $pedidoCodigoArticulo == $txtCodigoArticulo) {

        /* echo '<pre>';
          print_r($itemPedido);
          echo '</pre>'; */
        if ($conta == 0) {
            $pedidoCantidad = $itemPedido['cantidad'];
            $txtValorConInpuesto = $itemPedido['valorUnitario'];
            $valorUnitario = $itemPedido['txtValorConInpuesto'];
        }

        $pedidoDescuentoEspecial = $itemPedido['descuentoEspecial'];
        $pedidoDescuentoEspecialSelect = $itemPedido['descuentoEspecialSelect'];
        $pedidoDescuentoEspecialAltipal = $itemPedido['descuentoEspecialAltipal'];
        $pedidoDescuentoEspecialProveedor = $itemPedido['descuentoEspecialProveedor'];

        $pedidoDescuentoAltipal = $itemPedido['descuentoAltipal'];
        $pedidoDescuentoProveedor = $itemPedido['descuentoProveedor'];
        $conta++;
    }
}
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><b> <?php echo $itemPorCodigoVariante; ?> <?php echo $itemPorNombreArticulo; ?> <?php echo $itemPorCodigoCaracteristica1; ?> <?php echo $itemPorCodigoCaracteristica2; ?> (<?php echo $itemPorCodigoTipo; ?>)</b></h4>
        </div>
        <div class="modal-body" >

            <div>
                <?php
                /* echo $valorIva.'<br>';
                  echo $valorProducto.'<br>';
                  echo $TotalValorConImpuesto.'<br>';
                  echo $itemPorValorIMPOCONSUMO */
                ?>    
            </div>


            <div class="form-group">
                <label class="col-sm-5 control-label">Unidad de Medida:</label>
                <div class="col-sm-6">
                    <input type="text" name="name" readonly="readonly" class="form-control" id="textDetUnidadMedida" value="<?php echo $itemPorACNombreUnidadMedida; ?>"/> 

                    <input type="hidden" id="textCodigoVariante" />  

                    <input type="hidden" name="" readonly="readonly" class="form-control" id="txtCodigoArticulo"/>
                    <input type="hidden" name="" readonly="readonly" class="form-control" id="textDetCodigoUnidadMedida"/>      
                </div>
            </div>
            <?php if ($txtTipoVenta != "Consignacion") { ?>
                <div class="form-group" style="visibility: hidden">

                </div>
            <?php } else { ?>
                <?php $lotes = Consultas::model()->getLoteVariante($itemPorCodigoVariante, $ubicacion) ?>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Lote:</label>
                    <div class="col-sm-6">
                        <select name="lote" class="form-control" id="txtLote">
                            <?php foreach ($lotes as $lot) { ?>
                                <option <?php if ($txtLote == $lot['LoteArticulo']) { ?> selected="select" <?php } ?> value="<?php echo $lot['LoteArticulo']; ?>"><?php echo $lot['LoteArticulo']; ?></option>
                            <?php } ?> 
                        </select> 
                    </div>
                </div>
            <?php } ?>


            <div class="form-group">
                <label class="col-sm-5 control-label">Saldo:</label>
                <div class="col-sm-4">
                    <?php if ($txtSaldo > 0) { ?>
                        <input type="text" name="name" readonly="readonly" class="form-control textDetSaldo" id="" value="<?php echo $txtSaldo ?>"/>
                    <?php } else { ?>
                        <input type="text" name="name" readonly="readonly" class="form-control textDetSaldo" id="" value="<?php
                        if ($itemPorSaldoDisponibleVenta != "")
                            echo $itemPorSaldoDisponibleVenta;
                        else
                            echo "0";
                        ?>"/>
                           <?php } ?>
                </div>
                <div class="col-sm-2">
                    <label id="lblUnidadMedidaSaldo"><?php
                        if ($itemPorSPNombreUnidadMedida)
                            echo $itemPorACNombreUnidadMedida;
                        else
                            echo $itemPorACNombreUnidadMedida;
                        ?></label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">Saldo Limite:</label>
                <div class="col-sm-4">
                    <input type="number" name="txtSaldoLimite" id="" readonly="readonly" class="form-control txtSaldoLimite" value="<?php
                    if ($saldoLimite['Saldo'] != "")
                        echo $saldoLimite['Saldo'];
                    else
                        echo "0";
                    ?>"/>

                    <input type="hidden" name="txtCodigoTipo" id="txtCodigoTipo" readonly="readonly" class="form-control"/>

                    <input type="hidden" name="txtLimiteVentasACDL" id="txtLimiteVentasACDL" readonly="readonly" class="form-control"/>
                    <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDL" readonly="readonly" class="form-control"/>
                    <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDLSinConversion" readonly="readonly" class="form-control"/>

                    <input type="hidden" name="" id="txtIdAcuerdo" readonly="readonly" class="form-control"/>                  
                    <input type="hidden" name="" id="txtIdSaldoInventario" readonly="readonly" class="form-control"/>
                    <input type="hidden" name="" id="txtCodigoUnidadSaldoInventario" readonly="readonly" class="form-control"/>
                    <input type="hidden" name="" id="txtCuentaProveedor" readonly="readonly" class="form-control"/>


                    <input type="hidden" name="txtCodigoUnidadMedidaACDL" id="txtCodigoUnidadMedidaACDL" readonly="readonly" class="form-control"/>                  
                    <input type="hidden" name="txtPorcentajeDescuentoLinea1ACDL" id="txtPorcentajeDescuentoLinea1ACDL" readonly="readonly" class="form-control"/>
                    <input type="hidden" name="txtPorcentajeDescuentoLinea2ACDL" id="txtPorcentajeDescuentoLinea2ACDL" readonly="readonly" class="form-control"/>
                </div>
                <div class="col-sm-2">
                    <label id="lblUnidadMedidaSaldoLimite"><?php
                        if ($itemPorSPNombreUnidadMedida)
                            echo $itemPorACNombreUnidadMedida;
                        else
                            echo $itemPorACNombreUnidadMedida;
                        ?></label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">IVA:</label>
                <div class="col-sm-6">
                    <input type="text" name="name" readonly="readonly" id="textDetIva" class="form-control" value="<?php echo $itemPorPorcentajedeIVA; ?>"/>
                </div>
            </div>

            <div class="form-group">

                <label class="col-sm-5 control-label">Valor Sin Impuestos:</label>
                <?php
                if (strtolower($permisosDescuentoEspecial['PermitirModificarPrecio']) == "falso" || !empty($arrayDatoKit)) {
                    $valorSinImpuestosValidado = $itemPorACPrecioVenta;
                    $blokTextValorSinImpuestos = 'readonly="readonly"';
                } else {
                    // $blokTexValorConImpuestos = 'readonly="readonly"';
                    $blokTextValorSinImpuestos = '';
                }
                
                if ($txtValorConInpuesto <= $itemPorACPrecioVenta) {
                    $valorSinImpuestosValidado = $itemPorACPrecioVenta;
                } else {
                    $valorSinImpuestosValidado = $txtValorConInpuesto;
                }
                ?>
                <div class="col-sm-6">
                    <input type="text" name="name" 
                           data-valorIva ='<?php echo $itemPorPorcentajedeIVA; ?>' 
                           data-valorIpoconsumo ='<?php echo $itemPorValorIMPOCONSUMO; ?>' 
                           data-valorSinImpuestos="<?php echo $itemPorACPrecioVenta; ?>"
                           id="textDetValorProductoMostrar" class="form-control" <?php echo $blokTextValorSinImpuestos ?> 
                           value="<?php echo '$' . number_format($valorSinImpuestosValidado, '2', ',', '.'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">Impoconsumo:</label>
                <div class="col-sm-6">
                    <input type="text" name="name" readonly="readonly" id="textDetImpoconsumo" class="form-control" value="<?php echo '' . number_format($itemPorValorIMPOCONSUMO, '2'); ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">Valor Con Impuestos:</label>
                <div class="col-sm-6">
                    <?php
                    if ($valorUnitario < $TotalValorConImpuesto) {
                        $totalValue = $TotalValorConImpuesto;
                    } else {
                        $totalValue = $valorUnitario;
                    }
                    ?>

                    <input type="text" name="name" data-valorConImpuestos ="<?php echo $totalValue; ?>" readonly="readonly" id="textDetValorImpuestos" class="form-control" value="<?php echo '$' . number_format($totalValue, '2', ',', '.'); ?>"/>
                </div>
            </div>
            <div class="form-group" id="contentTextDetValorProductoImpuestosMostrar">
                <label class="col-sm-5 control-label">Cantidad Pedida:</label>
                <div class="col-sm-6">
                    <!--<input type="text" id="txtCantidadPedida" name="name" class="form-control"/>-->
                    <input type="text" style="height: 30px;" name="name" placeholder="Cantidad Pedida"  data-valorConImpuestos ="<?php echo $totalValue; ?>" class="form-control txtCantidadPedida" value="<?php if (!empty($pedidoCantidad)) echo $pedidoCantidad; ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">Descuento Promocional (Dcto 1):</label>
                <div class="col-sm-6">
                    <!--<input type="text" name="name" id="txtDescuentoProveedor"class="form-control" />-->
                    <?php
                    if ($PermisoDescuentoLinea == 'verdadero') {

                        $blokTextLinea = "";
                    } else {

                        $blokTextLinea = 'readonly="readonly"';
                    }
                    ?>
                    <input type="text" <?php echo $blokTextLinea; ?> class="form-control txtDescuentoProveedor" data-valorConImpuestos ="<?php echo $totalValue; ?>"  id="descLineaValidado" value="<?php
                    if (!empty($saldoLimite['Total'])) {
                        echo $saldoLimite['Total'];
                    } else {
                        if (!empty($pedidoDescuentoProveedor)) {
                            echo $pedidoDescuentoProveedor;
                        } else {
                            echo '0';
                        }
                    }
                    ?>"/>

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">Descuento Canal (Dcto 2):</label>
                <div class="col-sm-6">
                    <?php
                    if ($PermisoDescuentoMultiLinea == 'verdadero') {

                        $blokTextMulti = "";
                    } else {
                        $blokTextMulti = 'readonly="readonly"';
                    }
                    ?>

                    <input type="text" <?php echo $blokTextMulti; ?>  class="form-control txtDescuentoAltipal" data-valorConImpuestos ="<?php echo $totalValue; ?>" id="descMultiLineaValidado" value="<?php
                    if (!empty($pedidoDescuentoAltipal)) {
                        echo $pedidoDescuentoAltipal;
                    } else {
                        echo '0';
                    }
                    ?>"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-5 control-label">Descuento Especial (Dcto 3):</label>
                <div class="col-sm-6">

                    <?php
                    $activoDescuento = TRUE;
                    if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "falso" && $permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "falso") {
                        $activoDescuento = FALSE;
                    }
                    ?>

                    <input id="txtDescuentoEspecialPreventa" type="text" name="name" min="0" max="100" <?php if (!$activoDescuento) echo 'readonly="readonly"'; ?> value="<?php
                    if (!empty($pedidoDescuentoEspecial))
                        echo $pedidoDescuentoEspecial;
                    else
                        echo "0";
                    ?>"  <?php
                           if ($itemPorCodigoTipo == "KV" || $itemPorCodigoTipo == "KD") {
                               echo 'readonly="readonly"';
                           }
                           ?> class="form-control txtDescuentoEspecial" <?php
                           if (!$permisosDescuentoEspecial) {
                               echo 'readonly="readonly"';
                           }
                           ?>/><br/>
                           <?php ?>
                           <?php if ($permisosDescuentoEspecial && $itemPorCodigoTipo != "KV" && $itemPorCodigoTipo != "KD"): ?>  

                        <select name="" class="form-control select-especial" id="sltResposableDescuento">
                            <option value="Ninguno">Responsable del Descuento</option>
                            <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "verdadero"): ?>
                                <option value="Proveedor" data-cantidad="1" <?php if ($pedidoDescuentoEspecialSelect == "Proveedor") echo 'selected=""'; ?>>Proveedor</option>
                            <?php endif; ?>

                            <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "verdadero"): ?>
                                <option value="Altipal" data-cantidad="1" <?php if ($pedidoDescuentoEspecialSelect == "Altipal") echo 'selected=""'; ?>>Altipal</option>
                            <?php endif; ?>  

                            <?php if ($permisosDescuentoEspecial['PermitirModificarDescuentoEspecialAltipal'] == "verdadero" && $permisosDescuentoEspecial['PermitirModificarDescuentoEspecialProveedor'] == "verdadero"): ?>
                                <option value="Compartidos" data-cantidad="2" <?php if ($pedidoDescuentoEspecialSelect == "Compartidos") echo 'selected=""'; ?> >Compartido</option>
                            <?php endif; ?>   

                        </select><br/>
                    <?php endif; ?> 

                    <div class="contDescuentoEspecial">

                        <?php
                        if (!empty($pedidoDescuentoEspecialSelect)) {

                            if ($pedidoDescuentoEspecialSelect == "Compartidos") {
                                echo "<label>Dcto Proveedor</label><input type='text' value='" . $pedidoDescuentoEspecialProveedor . "' placeholder='Dcto Proveedor'  min='0' max='100' class='form-control txtDescuentoEspecialProveedor'/><br/>";
                                echo "<label>Dcto Altipal</label><input type='text' value='" . $pedidoDescuentoEspecialAltipal . "' placeholder='Dcto Altipal' min='0' max='100' class='form-control txtDescuentoEspecialAltipal'/><br/>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">

            <!---Datos a enviar --->

            <input type="hidden" readonly="readonly" class="txtClienteDetalle" value="<?php echo $txtCliente ?>"/> 
            <?php $CodArticuloCliente = Consultas::model()->getCodArtiDesLinaCliente($txtCliente, $txtZonaVentas); ?>
            <input type="hidden" readonly="readonly" class="txtZonaVenta" value="10091" />


            <?php if (!empty($arrayDatoKit) || !empty($arrayDatosKitDinamico)) { ?>
                <input type="hidden" readonly="readonly" class="form-control textDetValorProducto" value="<?php echo $TotalValorConImpuesto; ?>"/>
            <?php } else { ?>
                <input type="hidden" readonly="readonly" class="form-control textDetValorProducto" value="<?php echo $itemPorACPrecioVenta; ?>"/> 
            <?php } ?>
            <input type="hidden" readonly="readonly" class="form-control textDetCodigoProducto" value="<?php echo $itemPorCodigoVariante; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control textDetNombreProducto" value="<?php echo $itemPorNombreArticulo; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control textDetIva" value="<?php echo $itemPorPorcentajedeIVA; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control textDetSaldo" value="<?php echo $itemPorSaldoDisponibleVenta; ?>"/>               
            <input type="hidden" readonly="readonly" class="form-control textDetImpoconsumo" value="<?php echo $itemPorValorIMPOCONSUMO; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control textDetCodigoUnidadMedida" value="<?php echo $itemPorACCodigoUnidadMedida; ?>"/>     

            <input type="hidden" readonly="readonly" class="form-control textDetNombreUnidadMedida" value="<?php echo $itemPorACNombreUnidadMedida; ?>"/>  

            <input type="hidden" readonly="readonly" class="form-control txtCodigoArticulo" value="<?php echo $txtCodigoArticulo; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control txtIdAcuerdo" value="<?php echo $itemPorACIdAcuerdoComercial; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control txtCodigoUnidadSaldoInventario" value="<?php echo $itemPorSPCodigoUnidadMedida; ?>"/>                 
            <input type="hidden" readonly="readonly" class="form-control txtCodigoTipo" value="<?php echo $itemPorCodigoTipo; ?>"/>  
            <input type="hidden" readonly="readonly" class="form-control txtCuentaProveedor" value="<?php echo $itemPorCuentaProveedor; ?>"/>

            <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoDescuentoLinea" value="<?php echo $itemPorCodigoGrupoDescuentoLinea; ?>"/>              
            <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoDescuentoMultiLinea" value="<?php echo $itemPorCodigoGrupoDescuentoMultiLinea; ?>"/>

            <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoArticulosDescuentoLinea" value="<?php echo $CodArticuloCliente[0]['CodigoGrupoDescuentoLinea']; ?>"/>
            <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoArticulosDescuentoMultilinea" value="<?php echo $CodArticuloCliente[0]['CodigoGrupoDescuentoMultiLinea']; ?>"/>


            <input type="hidden" readonly="readonly" class="form-control txtIdAcuerdoLinea"  value="<?php echo $itemPortxtIdAcuerdoLinea; ?>"/>
            <input type="hidden" readonly="readonly" class="form-control txtIdAcuerdoMultilinea"  value="<?php echo $itemPortxtIdAcuerdoMultilinea; ?>"/> 
            <input type="hidden" readonly="readonly" class="form-control txtubicacion" value="<?php echo $ubicacion ?>"/>


            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary btnAdicionarProducto" >Adicionar</button>
<!--            <script>
                $('body').on('click', '.btnAdicionarProducto', function() {
                    var PorDescuentoML = $('#Desc1').val();
                    var PorDescuentoL = $('#descLinea').val();
                    
                    if(PorDescuentoML <= <?php echo $PorDescuentoMultiLinea ?>){
                       
                    }
                    else {
                       alert('El valor de "Descuento Canal (Dcto 2)" debe ser menor o igual a  <?php echo $PorDescuentoMultiLinea ?>');
                    }
                    
                    if(PorDescuentoL <= <?php echo $PorDescuentoLinea ?>){
                       
                    }
                    else {
                       alert('El valor de "Descuento Promocional (Dcto 1):" debe ser menor o igual a  <?php echo $PorDescuentoLinea ?>');
                    }
                        
                });
            </script>-->
        </div>
    </div>
</div>

