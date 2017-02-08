<div id="divTablaPendiestesporfacturar">
    <?php foreach ($PedientesPorFacturar as $item): ?>
        <div class="row">
            <div class="col-md-1"> <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/> </div>
            <div class="col-md-3">
                <h5> Fecha: <span class="text-primary"><?php echo date('Y-m-d'); ?></span></h5>
                <h5> Cuenta Cliente: <span class="text-primary"><?php echo $item['AccountNum']; ?></span></h5>
            </div>
            <div class="col-md-4">
                <h5> Nombre Cliente: <span class="text-primary"><?php echo $item['CustName']; ?></span></h5>
                <h5> Motivo: <span class="text-primary"><?php echo $item['ReasonPendingInovice']; ?></span></h5>
            </div>
            <br>
            <div style="overflow:scroll">
                <table class="table table-bordered" id="tableDetail">
                    <?php if ($item['ReasonPendingInovice'] == 'Facturas vencidas' || $item['ReasonPendingInovice'] == 'Vencidas x cheque') { ?>
                        <th>Número Factura</th>
                    <?php } else { ?>
                        <th></th>
                    <?php } ?>
                    <th class="text-center">Código Artículo</th>
                    <th class="text-center">Nombre Artículo</th>
                    <th class="text-center">Unidad Medida</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Código Kit</th>
                    <th class="text-center">Cantidad Pedida</th>
                    <th class="text-center">Cantidad Pendiente</th>
                    <tr>
                        <?php if ($item['ReasonPendingInovice'] == 'Facturas vencidas' || $item['ReasonPendingInovice'] == 'Vencidas x cheque') { ?>
                            <td><?php echo $item['Invoice']; ?></td>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>
                        <td class="text-center"><?php echo $item['VariantCode']; ?></td>
                        <td class="text-center"><?php echo $item['VariantName']; ?></td>
                        <td class="text-center"><?php echo $item['UniTid']; ?></td>
                        <td class="text-center"><?php echo $item['Type']; ?></td>
                        <td class="text-center"><?php echo $item['CodKit']; ?></td>
                        <td class="text-center"><?php echo $item['OrderedQty']; ?></td>
                        <td class="text-center"><?php echo $item['OutstandingQty']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>
