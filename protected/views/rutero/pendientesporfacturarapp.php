<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"> 
                                <form>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Buscar Cliente: </label>
                                        <div class="col-sm-3">
                                            <input class="form-control" name="txtBuscarCliente"  id="txtBuscarCliente" placeholder="Buscar" type="text">
                                            <a id="btnBuscarCliente" class="btn btn-primary" data-zonaventas="<?php echo $zoaventas?>" >Buscar</a>
                                        </div>
                                        <div id="img-cargar-clientes"></div> 
                                    </div>
                                </form> 
                            </div>
                            <div class="panel-body panel-body-nopadding" id = "divContenpendientesporfacturar">
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
                            <!-- panel-body --> 
                        </div>
                        <!-- panel --> 
                    </div>
                    <!-- col-md-6 --> 
                </div>
            </div>
        </div>
    </div>
</div>
