

<div class="row">
    <div style="overflow: scroll">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">Top 10 Clientes</h3>
                </div>
                <div class="panel-body">
                    <div id="containerventasxGrupoventas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 1500px  ! important;">
                            <tr>
                                <td></td>
                                <?php
                                foreach ($reportexgrupoventacomprador as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['NombreCliente'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Pesos&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                <?php
                                foreach ($reportexgrupoventacomprador as $ItemTotales) {
                                    ?>
                                    <td class="text-center">$ <?php echo number_format($ItemTotales['totalpedidos'], '2', ',', '.') ?></td>
                                    <?php
                                }
                                ?>
                            </tr>

                        </table>

                    </div>
                </div>
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div>
</div>
<div class="row">
    <div style="overflow: scroll">
        <div class="col-sm-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">Top 10 Productos Vendidos</h3>
                </div>
                <div class="panel-body">
                    <div id="containerventasproductosventidosxGrupoventas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 1000px  ! important;">
                            <tr>
                                 <td class="text-center">Productos Vendidos&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                <?php
                                foreach ($reportexgrupoventaproductovendidos as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['NombreArticulo'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Pesos&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                <?php
                                foreach ($reportexgrupoventaproductovendidos as $ItemTotales) {
                                    ?>
                                    <td class="text-center">$ <?php echo number_format($ItemTotales['totalcantidapedido'], '2', ',', '.') ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </table>

                    </div>
                </div>
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div>
</div>
<div class="row">
    <div style="overflow: scroll">
        <div class="col-sm-12">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">Top Ventas x Proveedor</h3>
                </div>
                <div class="panel-body">
                    <div id="containerproveedorxventasxGrupoventas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 1000px;">
                            <tr>
                                <td class="text-center">Ventas x Proveedor&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span></td>
                                <?php
                                foreach ($reportexgrupoventaventasXproveedor as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['NombreCuentaProveedor'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Pesos&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span></td>
                                <?php
                                foreach ($reportexgrupoventaventasXproveedor as $ItemTotales) {
                                    ?>
                                    <td class="text-center">$ <?php echo number_format($ItemTotales['total_ventas_porveedor'], '2', ',', '.') ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </table>
                        <table style="width: 151px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                            <td>
                                <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Ventas x Proveedor

                            </td>
                        </table>

                    </div>
                    <a href="index.php?r=reportes/Reportes/Vistalink">Ventas</a>
                </div>
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div>

</div><!-- row -->
<script>

    $(document).ready(function(){

//    $(function() {
//    $("#datepicker").datepicker();
//    });
    $("#selectchosegrupventas").chosen();
            $("#selectchosezonaventas").chosen();
            /////Grafica compradores////
     var Fecha = $('#datepicker').val();         

            $('#containerventasxGrupoventas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top 10 Clientes'
            },
            subtitle: {
            text: 'Clientes ' + Fecha
            },
            xAxis: {
            categories: [
<?php foreach ($reportexgrupoventacomprador as $item): ?>
                '<?php echo $item['NombreCliente']; ?>',
<?php endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Valor'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0,
                    color: 'blue',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reportexgrupoventacomprador as $itemtotal): ?>

    <?php echo $itemtotal['totalpedidos']; ?>,
<?php endforeach; ?>
                    ]

        }, ]
    });
            ////Grafica productos mas vendedios///

            $('#containerventasproductosventidosxGrupoventas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top 10 Productos Vendidos'
            },
            subtitle: {
            text: 'Productos Vendidos ' + Fecha
            },
            xAxis: {
            categories: [
<?php foreach ($reportexgrupoventaproductovendidos as $item): ?>
                '<?php echo $item['NombreArticulo']; ?>',
<?php endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Valor'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0,
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reportexgrupoventaproductovendidos as $itemtotal): ?>

    <?php echo $itemtotal['totalcantidapedido']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
            //////Grafica ventas proveedor/////


          

            $('#containerproveedorxventasxGrupoventas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top Ventas x Proveedor'
            },
            subtitle: {
            text: 'Ventas x Proveedor ' + Fecha
            },
            xAxis: {
            categories: [
<?php foreach ($reportexgrupoventaventasXproveedor as $item): ?>
                '<?php echo $item['NombreCuentaProveedor']; ?>',
<?php endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Valor'
                    }
            },
            tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            column: {
            pointPadding: 0.2,
                    borderWidth: 0,
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reportexgrupoventaventasXproveedor as $itemtotal): ?>

    <?php echo $itemtotal['total_ventas_porveedor']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
    })

</script>