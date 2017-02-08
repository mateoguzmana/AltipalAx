<div class="table-responsive" style="font-size: 13px;">
    <table class="table mb30">

<?php foreach ($InformacionDetalladaTransConsignacion as $itemTransFerenciConsig): ?>  
            <thead style="background-color: #E4E7EA">
                <tr class="active">
                    <th colspan="3">
                        Transferencia No. <?php echo $itemTransFerenciConsig['IdTransferencia']; ?>
                        <input type="hidden" id="transferencia" value="<?php echo $itemTransFerenciConsig['IdTransferencia']; ?>">
                        <input type="hidden" id="Agencia" value="<?php echo $agencia ?>">
                        <input type="hidden" id="Gupo" value="<?php echo $itemTransFerenciConsig['CodigoGrupoVentas']; ?>">
                        <input type="hidden" id="zona" value="<?php echo $itemTransFerenciConsig['CodZonaVentas']; ?>">
                        <input type="hidden" id="asesor" value="<?php echo $itemTransFerenciConsig['CodAsesor']; ?>">
                        <input type="hidden" id="cliente" value="<?php echo $itemTransFerenciConsig['CuentaCliente']; ?>">
                    </th>                  
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 25%;"> Zona Ventas: <span><?php echo $itemTransFerenciConsig['CodZonaVentas']; ?></span></td>
                    <td>Vendedor:	<span><?php echo $itemTransFerenciConsig['NombreAsesor']; ?></span></td>
                    <td>Grupo Ventas:	<span><?php echo $itemTransFerenciConsig['NombreGrupoVentas']; ?></span></td>

                </tr>
                <tr>
                    <td>Código Cliente: <span><?php echo $itemTransFerenciConsig['CuentaCliente']; ?></span></td>
                    <td>Cliente:	<span><?php echo $itemTransFerenciConsig['NombreCliente']; ?></span></td>
                    <td>Tipo Negocio: <span><?php echo $itemTransFerenciConsig['TipoNegocio']; ?></span></td>

                </tr>
                <tr>
                    <td>Fecha Transferencia: <span><?php echo $itemTransFerenciConsig['FechaTransferencia']; ?></span></td>
                    <td> <div align="left"><b>Aprobar</b><input type="checkbox" class="Checkbox Primary chckAprovacion" value="1" id="aceptar"></div></td>
                    <td> <div align="left"><b>Rechazar</b><input type="checkbox" class="Checkbox Primary chckAprovacion" value="0" id="rechazar"></div></td>
                </tr>
                 
            </tbody>

    <?php break;
endforeach; ?> 
    </table>
</div><!-- table-responsive -->


<div class="table-responsive">
    <table class="table mb30">
        <thead>
            <tr class="active">
                <th colspan="13">Detallado Transferencia Consignación </th>               
            </tr>
            <tr>
                <th>No</th>
                <th class="text-center">Código Artículo</th>
                <th class="text-center">Nombre Artículo</th>
                <th class="text-center">Unidad Medida</th>
                <th class="text-center">Cantidad</th>
            </tr>

        </thead>
        <tbody>
            <?php $cont=1; foreach ($InformacionDetalladaTransConsignacion as $itemTransFerenciConsig): ?>  
            
                <tr>
                    <th><?php echo $cont;?></th>
                    <th class="text-center"><?php echo $itemTransFerenciConsig['CodVariante']; ?></th>
                    <th class="text-center"><?php echo $itemTransFerenciConsig['NombreArticulo']; ?></th>
                    <th class="text-center"><?php echo $itemTransFerenciConsig['UnidadMedida']; ?></th>
                    <th class="text-center"><?php echo $itemTransFerenciConsig['Cantidad']; ?></th>
                </tr>
              
            <?php $cont++; endforeach; ?>            
        </tbody>
    </table>
</div><!-- table-responsive -->  