<div class="row">
    <div class="col-md-3 text-center">
        <div class="form-group">
            <label>Tipo</label>
            <div>
                <form method="post">
                <select id="selectchosentipo" name="Tipo" class="form-control chosen-select  GenrarRepoteTipo" data-placeholder="Seleccione un tipo">
                    <option value=""></option>
                    <option value="Grupo">Grupo</option>
                    <option value="Marca">Marca</option>
                    <option value="Fabricante">Fabricante</option>
                </select>
                </form>
                <?php
                $tipo2 = $tipo;
                 ?>
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
                    <div id="containerProfundidadGM" style="width: 100%; min-width: 500px; margin: 0 auto"></div>
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

<script>

$('#containerProfundidadGM').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Profundidad'
            },
            subtitle: {
            text:  '<?php echo $tipo2; ?>'
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
     
     