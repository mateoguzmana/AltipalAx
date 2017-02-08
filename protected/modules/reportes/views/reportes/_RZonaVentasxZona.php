<div class="row">
    <div>
        <div class="col-sm-12">
            <div class="panel panel-primary" style="border: solid 1px #428bca">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">Efectividad</h3>
                </div>
                <div class="panel-body" style="overflow-x: scroll; overflow-y: no-display">
                    <div id="containerefectividadxAgencia" style="width: 100%; min-width: 500px; margin: 0 auto"></div>
                    <div>
                        <table class="table table-bordered" style="width: 100%; min-width: 500px">
                            <tr>

                                <td class="text-center"><b>Clientes</b></td>
                                <td class="text-center"><b>Frecuencia</b></td>
                                <td class="text-center"><b>Objetivo Visita</b></td>
                                <td class="text-center"><b>Visita Efectiva</b></td>
                                <td class="text-center"><b>Visitas NO Efectivas</b></td>
                            </tr>
                            <?php foreach ($reportexzona as $ItemEfectividadxZona) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $ItemEfectividadxZona['Total_ClientesXZona'] ?></td>
                                    <td class="text-center"><?php echo $ItemEfectividadxZona['CodFrecuencia'] ?></td>
                                    <td class="text-center"><?php echo $ItemEfectividadxZona['objetivovisita'] ?></td>
                                    <td class="text-center"><?php echo $ItemEfectividadxZona['Visitasxzona'] ?></td>
                                    <td class="text-center"><?php echo $ItemEfectividadxZona['NoVisitaxZona'] ?></td> 
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                </div>
            </div><!-- panel -->
        </div><!-- col-sm-6 -->
    </div>
</div>
<div class="row">
    <div>
        <div class="col-sm-12">
            <div class="panel panel-primary" style="border: solid 1px #428bca">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">No Ventas</h3>
                </div>
                <div class="panel-body" style="overflow-x: scroll; overflow-y: no-display">
                    <div id="containernoventasZonaVentasxZona" style="width: 100%; min-width: 500px; margin: 0 auto"></div>
                    <div>
                        <table class="table table-bordered" style="width: 100%; min-width: 500px">
                            <tr>
                                <td class="text-center"><b>Motivos</b></td>
                                <?php
                                foreach ($reportexzonaNoVentasMes as $Itemes) {
                                    ?>
                                    <td class="text-center"><?php echo $Itemes['Nombre'] ?></td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center"><b>Clientes No Ventas</b></td>
                                <?php
                                foreach ($reportexzonaNoVentasMes as $ItemTotales) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemTotales['total_clientes_noventas_mes'] ?></td>
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
<div id="gr">
<div class="row">
    <div class="col-md-3 text-center">
        <div class="form-group">
            <label>Tipo</label>
            <div>
                <select id="selectchosentipo" name="Tipo" class="form-control chosen-select  GenrarRepoteTipo" data-placeholder="Seleccione un tipo">
                    <option value=""></option>
                    <option value="Grupo">Grupo</option>
                    <option value="Marca">Marca</option>
                    <option value="Fabricante">Fabricante</option>
                </select>
            </div>
        </div>
    </div>
    <div id="cargando" style="display:none;" class="col-md-3">
        <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;">
        Cargando...
    </div>
</div>
<div class="row">
    <div>
        <div class="col-sm-12">
            <div class="panel panel-primary" style="border: solid 1px #428bca">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="#" class="minimize">&minus;</a>
                    </div><!-- panel-btns -->
                    <h3 class="panel-title">Profundidad</h3>
                </div>
                <div class="panel-body" style="overflow-x: scroll; overflow-y: no-display">
                    <div id="containerProfundidad" style="width: 100%; min-width: 500px; margin: 0 auto"></div>
                    <br>
                    <div>
                        <table class="table table-bordered" style="width: 100%; min-width: 500px;">
                            <tr>
                                <td></td>
                                <?php
                                $cont = 0;
                                foreach ($profundidad as $Itemfabri) {
                                      if ($cont < 12) {
                                    ?>
                                    <td class="text-center"><?php echo $Itemfabri['NombreDimension'] ?></td>
                                    <?php
                                    }
                                $cont++;
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Ejecutado&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #7CB5EC"></span></td>
                                <?php
                                $cont = 0;
                                foreach ($profundidad as $ItemEjecutado) {
                                    if ($cont < 12) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemEjecutado['Ejecutado'] ?></td>
                                    <?php
                                     }
                                $cont++;
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Objetivo&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #434348"></span></td>
                                <?php
                                 $cont = 0;
                                foreach ($profundidad as $ItemPresupuestado) {
                                    if ($cont < 12) {
                                    ?>
                                    <td class="text-center"><?php echo $ItemPresupuestado['Presupuestado']; ?></td>
                                    <?php
                                      }
                                $cont++;
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="text-center">Porcentaje&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #90ED7D"></span></td>
                                <?php
                                $cont = 0;
                                foreach ($profundidad as $ItemPorcentaje) {
                                     if ($cont < 12) {
                                    ?>
                                    <td class="text-center">% <?php echo number_format($ItemPorcentaje['PorcentajeCumplimiento'], '2'); ?></td>
                                    <?php
                                      }
                                $cont++;
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div><!-- panel -->
        </div><!-- col-sm-6 -->

    </div>
</div><!-- row -->
</div>

<script>

    $('#containerefectividadxAgencia').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Efectividad'
            },
            subtitle: {
            text: 'Efectividad'
            },
            xAxis: {
            categories: [
<?php foreach ($reportexzona as $itemZona): ?>
                '<?php echo $itemZona['CodFrecuencia']; ?>',
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
            }
            },
            series: [{
            name: 'Clientes',
                    data: [
<?php foreach ($reportexzona as $itemtotalEfeZona): ?>
    <?php echo $itemtotalEfeZona['Total_ClientesXZona']; ?>,
<?php endforeach; ?>,
                    ]

            }, {
            name: 'Visitas Efectivas',
                    data:
                    [
<?php foreach ($reportexzona as $itemtotalZonaVisitas): ?>
    <?php echo $itemtotalZonaVisitas['Visitasxzona']; ?>,
<?php endforeach; ?>,
                    ]

            }]
    });
    
    
    $('#containernoventasZonaVentasxZona').highcharts({
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


<?php foreach ($reportexzonaNoVentasMes as $itemmes): ?>
                        ['<?php echo $itemmes['Nombre'] ?>', <?php echo $ItemTotales['total_clientes_noventas_mes'] ?>],
<?php endforeach; ?>

                    ]
            }]
    });
    
  

 $('#containerProfundidad').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Profundidad'
            },
            subtitle: {
            text: 'Grupo'
            },
            xAxis: {
            categories: [
<?php foreach ($profundidad as $itemFabricante): ?>
                '<?php echo $itemFabricante['NombreDimension']; ?>',
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
            }
            },
            series: [{
            name: 'Ejecutado',
                    data: [
<?php $cont = 0;
foreach ($profundidad as $itemEje): if ($cont < 12): ?>
        <?php echo $itemEje['Ejecutado']; ?>,
    <?php endif;
    $cont++;
endforeach; ?>,
                    ]

            }, {
            name: 'Objetivo',
                    data:
                    [
<?php $cont = 0;
foreach ($profundidad as $itemObj): if ($cont < 12): ?>
        <?php echo $itemObj['Presupuestado']; ?>,
    <?php endif;
    $cont++;
endforeach; ?>,
                    ]

            }, {
            name: 'Porcentaje',
                    data:
                    [
<?php $cont = 0;
foreach ($profundidad as $itemPor): if ($cont < 12): $PorcentajeGlobalGrafica = $itemPor['Ejecutado'] / $itemPor['Presupuestado'] * 100 ?>
        <?php echo $PorcentajeGlobalGrafica; ?>,
    <?php endif;
    $cont++;
endforeach; ?>,
                    ]
            } ]
    });



</script>                       

