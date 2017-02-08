<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$totalDescuentos = 0;
foreach ($pedidosGrupoVentasDetalle as $itemPedido) {

    $totalDescuentos+=($itemPedido['ValorDsctoEspecial']);
}
/* echo '<pre>';
  print_r($pedidosGrupoVentasDetalle); */
?>
<?php //$this->renderPartial('//mensajes/_alertaCargando');  ?> 
<div class="table-responsive" style="font-size: 13px;">
    <table class="table mb30">
        <?php foreach ($pedidosGrupoVentasDetalle as $itemPedido): ?>  
            <thead style="background-color: #E4E7EA">
            <input type="hidden" id="actividadespecial" value="<?php echo $itemPedido['ActividadEspecial']; ?>">    
            <tr class="active">
                <th colspan="3">
                    Pedido No. <?php echo $itemPedido['IdPedido']; ?> 
                </th>                  
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 25%;"> Zona Ventas: <span><?php echo $itemPedido['CodZonaVentas']; ?></span></td>
                    <td>Vendedor:	<span><?php echo $itemPedido['nombreAsesor']; ?></span></td>
                    <td>Grupo Ventas:	<span><?php echo $itemPedido['NombreGrupoVentas']; ?></span></td>
                </tr>
                <tr>
                    <td>Código Cliente: <span><?php echo $itemPedido['CuentaCliente']; ?></span></td>
                    <td>Cliente:	<span><?php echo $itemPedido['NombreCliente']; ?></span></td>
                    <td>Tipo Negocio: <span><?php echo $itemPedido['TipoNegocio']; ?></span></td>
                </tr>
                <tr>
                    <td>Fecha Pedido: <span><?php echo $itemPedido['FechaPedido']; ?></span></td>
                    <td colspan="2">Observaciones: <?php echo $itemPedido['Observacion']; ?></td>  
                </tr>
                <tr>
                    <td><b>Valor total del Pedido: $<?php echo number_format($itemPedido['ValorPedido']); ?></b></td>
                    <td><b>Valor Pedido sin Impuestos: $<?php echo number_format($itemPedido['TotalSubtotalBaseIva']); ?></b></td>
                    <td><b>Descuento Total Pedido: $<?php echo number_format($totalDescuentos); ?></b></td>
                </tr>
            </tbody>
            <?php break;
        endforeach;
        ?> 
    </table>
</div><!-- table-responsive -->
<div class="table-responsive">
    <table class="table mb30" id="tableItems">
        <thead>
            <tr class="active">
                <th colspan="14">Detalle Pedido</th>               
            </tr>
            <tr>
                <th>No</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Codigo Unidad</th>
                <th>Nombre Unidad</th>
                <th>Valor</th>
                <th>Fabricante</th>
                <th>Descuento Especial Proveedor</th>
                <th>Descuento Especial Altipal</th>
                <th>Descuento Total Especial</th>
                <th>Valor Descuento Especial</th>
                <?php if ($itemPedido['CuentaProveedor'] != "") { ?>
                    <th>Dinámica</th>
                <?php } else { ?>
                <?php } ?>
                <th class="text-center">Motivo Rechazo</th>
                <th style="padding-top: 14px; padding-left: 15px;">
                    Autorizar Todos<br/>
        <div class="ckbox ckbox-primary">
            <input type="checkbox" id="checkboxAll" value="1">
            <label for="checkboxAll"></label>
        </div>                
        </th>                  
        </tr>
        </thead>
        <tbody>
            <?php $cont = 1;
            foreach ($pedidosGrupoVentasDetalle as $itemPedido): ?>  
                <?php
                $tipoUsuario = Yii::app()->user->_tipoUsuario;
                $valida = TRUE;
                if ($tipoUsuario == '1' && $itemPedido['EstadoRevisadoAltipal'] == '1') {
                    $valida = FALSE;
                } elseif ($tipoUsuario == '2' && $itemPedido['EstadoRevisadoProveedor'] == '1') {
                    $valida = FALSE;
                }
                if ($valida) {
                    ?>
                    <tr data-idDescripPedidoth="<?php echo $itemPedido['IdDescripcionPedido']; ?>"  data-valorDescuentoth="<?php echo $itemPedido['ValorDsctoEspecial']; ?>">
                        <th><?php echo $cont; ?></th>
                        <th><?php echo $itemPedido['CodVariante']; ?></th>
                        <th><?php echo $itemPedido['NombreArticulo']; ?></th>
                        <th><?php echo $itemPedido['Cantidad']; ?></th>
                        <th><?php echo $itemPedido['CodigoUnidadMedida']; ?></th>
                        <th><?php echo $itemPedido['NombreUnidadMedida']; ?></th>
                        <th>$<?php echo number_format($itemPedido['TotalPrecioNeto']); ?></th>
                        <th><?php echo $itemPedido['NombreCuentaProveedor']; ?></th>
                        <th><?php echo $itemPedido['DsctoEspecialProveedor']; ?></th>
                        <th><?php echo $itemPedido['DsctoEspecialAltipal']; ?></th>
                        <th><?php echo $itemPedido['DsctoEspecial']; ?></th>
                        <th>$<?php echo number_format($itemPedido['ValorDsctoEspecial']); ?></th>
                        <?php if ($itemPedido['CuentaProveedor'] != "") { ?>
                            <?php $Dinamicas = AprovacionDocumentos::model()->getDinamicas($itemPedido['Agencia'], $itemPedido['CuentaProveedor']); ?>
                            <th style="width: 53%;">
                                <select id="Dinamicas<?php echo $itemPedido['IdDescripcionPedido']; ?>" onchange="CargarDinamica('<?php echo $itemPedido['IdDescripcionPedido']; ?>', '<?php echo $itemPedido['Agencia'] ?>', <?php echo $itemPedido['ValorDsctoEspecial']; ?>)" data-idDescripPedido="<?php echo $itemPedido['IdDescripcionPedido']; ?>" class="form-control input-sm mb15 LimpiarMotivos">
                                    <option value="0">Seleccione una dinámica</option>
                                    <?php foreach ($Dinamicas as $itemDinamicas): ?>
                                        <option value="<?php echo $itemDinamicas['Codigo'] ?>"><?php echo $itemDinamicas['Codigo'] . '-' . $itemDinamicas['Descripcion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label id="ValorDina<?php echo $itemPedido['IdDescripcionPedido']; ?>"></label>  
                                <label id="SaldoDina<?php echo $itemPedido['IdDescripcionPedido']; ?>"></label>
                                <input type="hidden" id="ValorDinamica<?php echo $itemPedido['IdDescripcionPedido']; ?>">
                                <input type="hidden" id="SaldoDinamica<?php echo $itemPedido['IdDescripcionPedido']; ?>">
                                <input type="hidden" id="CodDinamica<?php echo $itemPedido['IdDescripcionPedido']; ?>">
                            </th>
                        <?php }else { ?>
                        <?php } ?>  
                        <th style="width: 70%;">
                            <select class="form-control input-sm mb15 sltItem sltItemDinamica" id="motivoIdDesPedido_<?php echo $itemPedido['IdDescripcionPedido']; ?>" data-variante="<?php echo $itemPedido['CodVariante']; ?>" data-idDescripcionPedido="<?php echo $itemPedido['IdDescripcionPedido']; ?>">
                                <option value="">Seleccione un motivo</option>
                                <option value="1">Dscto no Autorizado</option>
                                <option value="2">Cantidad Diferente a la Pactada</option>
                            </select>
                        </th>
                        <th style="padding-top: 14px; padding-left: 15px;">
                <div class="ckbox ckbox-primary">
                    <input 
                        type="checkbox" 
                        class="itemCheck" 
                        id="checkbox_<?php echo $itemPedido['CodVariante']; ?>"
                        data-id-pedido="<?php echo $itemPedido['IdPedido']; ?>"
                        data-id-des-pedido="<?php echo $itemPedido['IdDescripcionPedido']; ?>"
                        data-desc-altipal="<?php echo $itemPedido['DsctoEspecialAltipal']; ?>"
                        data-desc-proveedor="<?php echo $itemPedido['DsctoEspecialProveedor']; ?>"
                        data-variante="<?php echo $itemPedido['CodVariante']; ?>"
                        data-valorDescuento="<?php echo $itemPedido['ValorDsctoEspecial']; ?>"
                        data-cedula-usuario="<?php echo Yii::app()->user->_cedula; ?>"
                        data-nombre-usuario="<?php echo Yii::app()->user->_nombres . " " . Yii::app()->user->_apellidos; ?>"
                        data-agencia="<?php echo $itemPedido['Agencia']; ?>"                                
                        data-nombre="<?php echo $itemPedido['NombreArticulo']; ?>"
                        >
                    <label for="checkbox_<?php echo $itemPedido['CodVariante']; ?>"></label>
                </div>
                </th>                  
                </tr>
                <?php
            }
            ?>
            <?php $cont++;
        endforeach; ?>            
        </tbody>
    </table>
</div><!-- table-responsive -->