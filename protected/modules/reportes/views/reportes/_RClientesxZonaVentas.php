 
<div class="row">
    <div style="overflow: scroll">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">Top 10 Clientes Cartera Vencida</h3>
                </div>
                <div class="panel-body">
                    <div id="containerclientesxzona" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 1500px  ! important;">
                            <tr>
                                <td></td>
                                <?php
                                foreach ($reportexClientesxCarteraVencidaXZona as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['NombreCliente'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center"> Clientes Cartera Vencida&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                <?php
                                foreach ($reportexClientesxCarteraVencidaXZona as $ItemTotales) {
                                    ?>
                                    <td class="text-center">$ <?php echo number_format($ItemTotales['total_deuda'], '2', ',', '.') ?></td>
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
                    <h3 class="panel-title">No Ventas</h3>
                </div>
                <div class="panel-body">
                    <div id="containernoventasxzona" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 1000px  ! important;">
                            <tr>
                                <td class="text-center"><b>Motivos</b></td>
                                <?php
                                foreach ($reportexClientesxNoventasxZona as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['Nombre'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center"><b>Clientes No Ventas</b></td>
                                <?php
                                foreach ($reportexClientesxNoventasxZona as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['total_clientes_noventas'] ?></td>
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
                    <h3 class="panel-title">Notas Creditos</h3>
                </div>
                <div class="panel-body">
                    <div id="containernotascreditosxzona" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 1000px;">
                            <tr>
                                <td></td>
                                <?php
                                foreach ($reportexClientesNotaCreditoxZona as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['NombreConceptoNotaCredito'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Notas Creditos&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span></td>
                                <?php
                                foreach ($reportexClientesNotaCreditoxZona as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo number_format($ItemTotales['total_notascredito'], '2', ',', '.') ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                        </table>
                        <table style="width: 151px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                            <td>
                                <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Notas Credito

                            </td>
                        </table>

                    </div>

                </div>
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

    </div>
</div><!-- row -->


<script>

    $(document).ready(function(){


    $('#containerclientesxzona').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top 10 Clientes Cartera Vencida'
            },
            subtitle: {
            text: 'Clientes'
            },
            xAxis: {
            categories: [
<?php foreach ($reportexClientesxCarteraVencidaXZona as $item): ?>
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
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reportexClientesxCarteraVencidaXZona as $itemtotal): ?>

    <?php echo $itemtotal['total_deuda']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
            ////Grafica no ventas///


            $('#containernoventasxzona').highcharts({
    chart: {
    type: 'pie',
            options3d: {
            enabled: true,
                    alpha: 45,
                    beta: 0
            }
    },
            title: {
            text: 'No Ventas'
            },
            tooltip: {
            pointFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
            },
            plotOptions: {
            pie: {
            allowPointSelect: true,
                    cursor: 'pointer',
                    depth: 35,
                    dataLabels: {
                    enabled: true,
                            format: '{point.name}'
                    }
            }
            },
            series: [{
            type: 'pie',
                    name: 'Clientes',
                    data: [
<?php foreach ($reportexClientesxNoventasxZona as $itemtotal): ?>
                        ['<?php echo $itemtotal['Nombre'] ?>', <?php echo $itemtotal['total_clientes_noventas'] ?>],
<?php endforeach; ?>

                    ]
            }]
    });
            //////Grafica  notas credito /////

            $('#containernotascreditosxzona').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Notas Credito'
            },
            subtitle: {
            text: 'notas credito'
            },
            xAxis: {
            categories: [
<?php foreach ($reportexClientesNotaCreditoxZona as $item): ?>
                '<?php echo $item['NombreConceptoNotaCredito']; ?>',
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

<?php foreach ($reportexClientesNotaCreditoxZona as $itemtotal): ?>

    <?php echo $itemtotal['total_notascredito']; ?>,
<?php endforeach; ?>
                    ]

            }, ]  });
    })

</script>                       