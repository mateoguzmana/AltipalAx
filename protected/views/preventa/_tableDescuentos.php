<table id="detalle" border="1">
    <thead style="background-color: #2E9AFE;">
        <tr>
            <th class="text-center" colspan="8"><?php echo $txtCodigoVariante ?></th>
        </tr>
        <tr>
            <th class="text-center" colspan="8"><?php echo $txtDescripcion ?></th>
        </tr>
        <tr>
            <th class="text-center" colspan="8"><?php echo $txtCodigoArticulo ?></th> 
        </tr>
    </thead>

    <tbody>
        <?php foreach ($descuentoLineaConsulta as $itemdescuentoLinea) { ?>
            <tr style="background-color: #BDBDBD;">
                <td colspan="8"><b>Descuento Linea</b></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Desde:</td>
                <td class="text-center" colspan="4"><?php echo $itemdescuentoLinea['CantidadDesde'] ?></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Hasta:</td>
                <td class="text-center" colspan="4"><?php echo $itemdescuentoLinea['CantidadHasta'] ?></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Porcentaje:</td>
                <td class="text-center" colspan="4"><?php echo ($itemdescuentoLinea['PorcentajeDescuentoLinea1'] + $itemdescuentoLinea['PorcentajeDescuentoLinea2']). '%' ?></td>
            </tr>
        <?php } ?>
        <?php foreach ($descuentoLineaConsultaSL as $itemdescuentoLineaSL) { ?>
            <tr style="background-color: #BDBDBD;">
                <td colspan="8"><b>Descuento Linea</b></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Saldo Limite:</td>
                <td class="text-center" colspan="4"><?php echo $itemdescuentoLineaSL['Saldo'] ?></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Porcentaje:</td>
                <td class="text-center" colspan="4"><?php echo ($itemdescuentoLineaSL['PorcentajeDescuentoLinea1'] + $itemdescuentoLineaSL['PorcentajeDescuentoLinea2']). '%'  ?></td>
            </tr>
        <?php } ?>
        <?php foreach ($descuentoMultiLineaConsulta as $itemdescuentoMultilinea) { ?>

            <tr style="background-color: #BDBDBD;">
                <td colspan="8"><b>Descuento Multilinea</b></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Desde:</td>
                <td class="text-center" colspan="4"><?php echo $itemdescuentoMultilinea['CantidadDesde'] ?></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Hasta:</td>
                <td class="text-center" colspan="4"><?php echo $itemdescuentoMultilinea['CantidadHasta'] ?></td>
            </tr>
            <tr>
                <td class="text-center" colspan="4">Porcentaje:</td>
                <td class="text-center" colspan="4"><?php echo ($itemdescuentoMultilinea['PorcentajeDescuentoMultilinea1'] +  $itemdescuentoLinea['PorcentajeDescuentoMultilinea2']). '%'  ?></td>
            </tr>

        <?php } ?>
    </tbody>
</table>