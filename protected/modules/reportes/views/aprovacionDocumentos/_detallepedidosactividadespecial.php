 <div class="table-responsive" style="font-size: 13px;">
    <table class="table mb30">

<?php foreach ($detallePedidoActiEspecial as $itemPedidoActiEspecial): ?>  
            <thead style="background-color: #E4E7EA">
                <tr class="active">
                    <th colspan="3">
                        Pedido No. <?php echo $itemPedidoActiEspecial['IdPedido']; ?>
                        <input type="hidden" id="pedido" value="<?php echo $itemPedidoActiEspecial['IdPedido']; ?>">
                        <input type="hidden" id="Agencia" value="<?php echo $agencia ?>">
                        <input type="hidden" id="Gupo" value="<?php echo $itemPedidoActiEspecial['CodigoGrupoVentas']; ?>">
                        <input type="hidden" id="zona" value="<?php echo $itemPedidoActiEspecial['CodZonaVentas']; ?>">
                        <input type="hidden" id="asesor" value="<?php echo $itemPedidoActiEspecial['CodAsesor']; ?>">
                        <input type="hidden" id="cliente" value="<?php echo $itemPedidoActiEspecial['CuentaCliente']; ?>">
                    </th>                  
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 25%;"><b> Zona Ventas:</b> <span><?php echo $itemPedidoActiEspecial['CodZonaVentas']; ?></span></td>
                    <td><b>Vendedor:</b>	<span><?php echo $itemPedidoActiEspecial['NombreAsesor']; ?></span></td>
                    <td><b>Grupo Ventas:</b>	<span><?php echo $itemPedidoActiEspecial['NombreGrupoVentas']; ?></span></td>

                </tr>
                <tr>
                    <td><b>Código Cliente:</b> <span><?php echo $itemPedidoActiEspecial['CuentaCliente']; ?></span></td>
                    <td><b>Cliente:</b>	<span><?php echo $itemPedidoActiEspecial['NombreCliente']; ?></span></td>
                    <td><b>Tipo Negocio:</b> <span><?php echo $itemPedidoActiEspecial['TipoNegocio']; ?></span></td>

                </tr>
                <tr>
                    <td><b>Fecha Pedido:</b> <span><?php echo $itemPedidoActiEspecial['FechaPedido']; ?></span></td>
                    <td><b>Observación:</b> <span><?php echo $itemPedidoActiEspecial['Observacion']; ?></span></td>
                </tr>
                 
            </tbody>

    <?php break;
endforeach; ?> 
    </table>
</div><!-- table-responsive -->


 <div class="table-responsive" style="font-size: 13px;">
    <table class="table mb30">

<?php foreach ($detallePedidoActiEspecial as $itemPedidoActiEspecial): ?>  
            <thead style="background-color: #E4E7EA">
                 
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" style="width: 25%;"> Valor Pedido: <b><span style="background-color: #D9EDF7"><?php echo number_format($itemPedidoActiEspecial['ValorPedido'],'2', ',', '.') ?></span></b></td>
                    <?php 
                    $Agencia = $itemPedidoActiEspecial['CodAgencia'];
                    $CodDias = $itemPedidoActiEspecial['Plazo'];
                    $DiasPlazo = AprovacionDocumentos::model()->DiasPlazo($Agencia,$CodDias);
                    
                    ?>
                    <td class="text-center">Días Plazo:	<b><span style="background-color: #D9EDF7"><?php echo $DiasPlazo[0]['Descripcion']; ?></span></b></td>
                    <td class="text-center">Días de Gracias: <b><span style="background-color: #D9EDF7"><?php echo $itemPedidoActiEspecial['DiasGracia']; ?></span></b></td>
                    <?php 
                    $Agencia = $itemPedidoActiEspecial['CodAgencia'];
                    $Dias = AprovacionDocumentos::model()->DiasProntoPago($Agencia);
                    ?>
                    <td class="text-center">Modificar Días Plazo:	
                        <select id="diasplazo">
                         <option value="0">Seleccione días plazo</option>
                        <?php  foreach ($Dias as $itemDias){ ?>
                             <option value="<?php echo $itemDias['CodigoCondicionPago']; ?>"><?php echo $itemDias['Descripcion']; ?></option>        
                        <?php } ?>
                         </select>
                    </td>
                </tr>
                <tr align="center">
                    <td> <div><b>Aprobar:</b> <input type="checkbox" class="chckAprovacion" value="1" id="aceptar"></div></td>
                    <td> <div><b>Rechazar:</b> <input type="checkbox" class="chckAprovacion" value="0" id="rechazar"></div></td>
                </tr>
            </tbody>

    <?php break;
endforeach; ?> 
    </table>
</div><!-- table-responsive -->

 