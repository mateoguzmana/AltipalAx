<?php
$tltValorPedidos = 0;
$cantidadPedidos = 0;

$arrayAux = array();
foreach ($pedidosDescuentos as $item) {
    array_push($arrayAux, $item['CodGrupoVenta']);
}
$gruposVentas = array_unique($arrayAux);
$gruposFiltrados = array();
$gruposFiltrados = array_values($gruposVentas);
$gruposAgencia = array_values($agencias);

$idPerfil = Yii::app()->user->_idPerfil;


/*

foreach ($gruposFiltrados as $itemGrupo) {



    foreach ($pedidosDescuentos as $itemPedidos) {



        if (($itemGrupo == $itemPedidos['CodGrupoVenta'] ) && ($itemAgencia == $itemPedidos['Agencia']) && ($itemPedidos['Agencia'] !== '')) {
            if ($itemPedidos['QuienAutorizaDscto'] == 1 && $itemPedidos['EstadoRevisadoAltipal'] != 1) {
                if ($tipoUsuario == 1) {
                    $tltValorPedidos+=$itemPedidos['TotalPrecioNeto'];
                    array_push($arrayPedidos, $itemPedidos['IdPedido']);
                }
            } else if ($itemPedidos['QuienAutorizaDscto'] == 2 && $itemPedidos['EstadoRevisadoProveedor'] != 1) {


                if ($tipoUsuario == 2) {
                    $tltValorPedidos+=$itemPedidos['TotalPrecioNeto'];
                    array_push($arrayPedidos, $itemPedidos['IdPedido']);
                }
            } else if ($itemPedidos['QuienAutorizaDscto'] == 3) {



                if ($idPerfil == 29) {
                    if ($tipoUsuario == 1) {
                        if ($itemPedidos['EstadoRevisadoAltipal'] != 1 && $itemPedidos['EstadoRevisadoProveedor'] != 1) {
                            $tltValorPedidos+=$itemPedidos['TotalPrecioNeto'];
                            array_push($arrayPedidos, $itemPedidos['IdPedido']);
                        }
                    }
                }

                if ($itemPedidos['EstadoRevisadoAltipal'] != 1) {
                    if ($tipoUsuario == 1) {
                        $tltValorPedidos+=$itemPedidos['TotalPrecioNeto'];
                        array_push($arrayPedidos, $itemPedidos['IdPedido']);
                    }
                }

                if ($itemPedidos['EstadoRevisadoProveedor'] != 1) {
                    if ($tipoUsuario == 2) {
                        $tltValorPedidos+=$itemPedidos['TotalPrecioNeto'];
                        array_push($arrayPedidos, $itemPedidos['IdPedido']);
                    }
                }
            } else if ($itemPedidos['QuienAutorizaDscto'] == "") {


                $tltValorPedidos+=$itemPedidos['TotalPrecioNeto'];
                array_push($arrayPedidos, $itemPedidos['IdPedido']);
            }
        }

    }
    $arrayPedidos = array_unique($arrayPedidos);

      echo count($arrayPedidos);
      echo '<pre>';
      print_r($arrayPedidos);
      die();
}
*/
/*echo '-----------------------------------------------pedidos no autorizados';
$arrayPedidos = array_unique($arrayPedidos);
echo '<pre>';
print_r($arrayPedidos);
echo '</pre>';
die();
if (count($arrayPedidos) < 1) {
    $_SESSION["AprobarDes"] = 1;
    echo "<script language='javascript'>window.location.href='index.php?r=reportes/AprovacionDocumentos/MenuAprovaciones';</script>";
}
?>
*/?>


<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        Descuentos <span></span></h2>
</div>


<?php
$total = 0;
$dinero = 0;
?>
<div class="contentpanel">

    <div class="panel panel-default">


        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">


                    <div class="row">

                        <div class="mb30"></div>

                        <div class="col-sm-10 col-sm-offset-1">

                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table table-hover table-striped mb30" style="width: 100%">

                                    <tbody>

                                    <?php foreach ($gruposAgencia as $itemAgencia): ?>
                                    <?php foreach ($gruposFiltrados as $itemGrupo): ?>
                                    <?php
                                        $totalGrupoVentas = 0;
                                        $nombreGrupoVentas = '';
                                        $nombreAgecia = '';
                                        $ag = '';
                                        $tipoUsuario = Yii::app()->user->_tipoUsuario;
                                    ?>
                                    <?php foreach ($pedidosDescuentos as $itemPedidos): ?>

                                        <?php if (($itemGrupo == $itemPedidos['CodGrupoVenta'] ) && ($itemAgencia == $itemPedidos['Agencia'])) {

                                            /*
                                              echo $itemPedidos['QuienAutorizaDscto'].' quien <br/>';
                                              echo $itemPedidos['EstadoRevisadoProveedor'].' Proveedor <br/>';
                                              echo $itemPedidos['EstadoRevisadoAltipal'].' Altipal <br/> <br/>';
                                             */

                                            if ($itemPedidos['QuienAutorizaDscto'] == 1 && $itemPedidos['EstadoRevisadoAltipal'] != 1) {

                                                if ($tipoUsuario == 1) {
                                                    $totalGrupoVentas+=$itemPedidos['TotalPrecioNeto'];
                                                    $nombreGrupoVentas = $itemPedidos['NombreGrupoVentas'];
                                                    $nombreAgecia = $itemPedidos['nombreAgencia'];
                                                    $ag = $itemPedidos['Agencia'];
                                                }
                                            } else if ($itemPedidos['QuienAutorizaDscto'] == 2 && $itemPedidos['EstadoRevisadoProveedor'] != 1) {
                                                if ($tipoUsuario == 2) {
                                                    $totalGrupoVentas+=$itemPedidos['TotalPrecioNeto'];
                                                    $nombreGrupoVentas = $itemPedidos['NombreGrupoVentas'];
                                                    $nombreAgecia = $itemPedidos['nombreAgencia'];
                                                    $ag = $itemPedidos['Agencia'];
                                                }
                                            } else if ($itemPedidos['QuienAutorizaDscto'] == 3) {

                                                if ($idPerfil == 29) {
                                                    if ($itemPedidos['EstadoRevisadoAltipal'] == 1 && $itemPedidos['EstadoRevisadoProveedor'] == 0) {
                                                        if ($tipoUsuario == 1) {
                                                            $totalGrupoVentas+=$itemPedidos['TotalPrecioNeto'];
                                                            $nombreGrupoVentas = $itemPedidos['NombreGrupoVentas'];
                                                            $nombreAgecia = $itemPedidos['nombreAgencia'];
                                                            $ag = $itemPedidos['Agencia'];
                                                        }
                                                    }
                                                }

                                                if ($itemPedidos['EstadoRevisadoAltipal'] != 1) {
                                                    if ($tipoUsuario == 1) {
                                                        $totalGrupoVentas+=$itemPedidos['TotalPrecioNeto'];
                                                        $nombreGrupoVentas = $itemPedidos['NombreGrupoVentas'];
                                                        $nombreAgecia = $itemPedidos['nombreAgencia'];
                                                        $ag = $itemPedidos['Agencia'];
                                                    }
                                                }

                                                if ($itemPedidos['EstadoRevisadoProveedor'] != 1) {
                                                    if ($tipoUsuario == 2) {
                                                    
                                                        $totalGrupoVentas+=$itemPedidos['TotalPrecioNeto'];
                                                        $nombreGrupoVentas = $itemPedidos['NombreGrupoVentas'];
                                                        $nombreAgecia = $itemPedidos['nombreAgencia'];
                                                        $ag = $itemPedidos['Agencia'];
                                                    }
                                                }
                                            } else if ($itemPedidos['QuienAutorizaDscto'] == "") {
                                                if($itemPedidos['Agencia'] !== ''){
                                                    $totalGrupoVentas+=$itemPedidos['TotalPrecioNeto'];
                                                    $nombreGrupoVentas = $itemPedidos['NombreGrupoVentas'];
                                                    $nombreAgecia = $itemPedidos['nombreAgencia'];
                                                    $ag = $itemPedidos['Agencia'];
                                                    // echo $itemPedidos['IdPedido'] . '<br />';
                                                }
                                            }
                                        }
                                    endforeach;
                                    if($nombreAgecia !== ''):
                                        $cont_notapv = 0;
                                        $PedidosPorAgencia = AprovacionDocumentos::model()->getPedidosGrupoVentas($ag, $itemGrupo, $tipoUsuario, $proveedor); ?>
                                    <?php foreach ($PedidosPorAgencia as $itemPedido):
                                        $tipoUsuario = Yii::app()->user->_tipoUsuario;
                                        $valida = TRUE;
                                        if ($tipoUsuario == '1' && $itemPedido['EstadoRevisadoAltipal'] == '1') {
                                            $valida = FALSE;
                                        } elseif ($tipoUsuario == '2' && $itemPedido['EstadoRevisadoProveedor'] == '1') {
                                            $valida = FALSE;
                                        }
                                        if ($valida) {
                                            $cont_notapv++;
                                        }
                                    endforeach;
                                    if($cont_notapv != 0):
                                        $total += $cont_notapv;
                                        $dinero +=  $totalGrupoVentas; ?>
                                        <tr>
                                            <td class="text-right" style="width: 45%;">
                                                <img src="images/descuentos.png" style="width: 55px; margin: 0px 30px;" />
                                            </td>
                                            <td>
                                                <span class="text-primary"><b><?= $cont_notapv; ?></b>&nbsp;&nbsp;
                                                <b>$<?= number_format($totalGrupoVentas) ?></b>
                                                </span><br/>
                                                <span class="text-danger">Agencia: <?= $nombreAgecia; ?> </span><br/>
                                                <span class="text-danger">Grupo ventas: <?= $nombreGrupoVentas; ?> </span>
                                            </td>
                                            <td>
                                                <a href="index.php?r=reportes/AprovacionDocumentos/AjaxDetalleDescuentos&agencia=<?= $ag; ?>&grupoVentas=<?= $itemGrupo; ?>">
                                                    <span class="fa fa-edit text-danger text-left" style="font-size: 30px;"></span>
                                                </a>
                                            </td>

                                        </tr>
                                        <?php endif ?>
                                    <?php endif ?>
                                    <?php endforeach; ?>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">
                                            <span class="glyphicon glyphicon-import"></span>
                                            TOTAL DESCUENTOS (<?= $total; ?>)&nbsp;&nbsp;
                                            VALOR ($<?= number_format($dinero); ?>)

                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div><!-- table-responsive -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


