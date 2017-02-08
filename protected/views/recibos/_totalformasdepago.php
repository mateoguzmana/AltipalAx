<table class="table-bordered col-sm-12" id="TotalFormasPago">
    <tr>
        <th class="text-center">Factura</th>
        <th class="text-center">Forma de pago</th>
        <th class="text-center">Valor Forma Pago</th>
    </tr>
    <?php
    $position = array();
    $newRow = array();
    $inverse = false;
    foreach ($datos as $key => $row) {

        $position[$key] = $row['-'];
        $newRow[$key] = $row;
        $inverse = true;
    }

    if ($inverse) {
        arsort($position);
    }

    $formasPagoFacturas = array();
    foreach ($position as $key => $pos) {
        $formasPagoFacturas[] = $newRow[$key];
    }

    foreach ($formasPagoFacturas as $item):
        ?>
        <tr>
            <td class="text-center"><?php echo $item['Factura'] ?></td>
            <td class="text-center"><?php echo $item['FormaPago'] ?></td>
            <td class="text-center"><?php echo number_format($item['Valor'], '0', '.', '.') ?></td>
        </tr>

    <?php endforeach; ?>
</table>
