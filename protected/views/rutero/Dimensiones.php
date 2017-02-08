<div class="contentpanel">

    <div class="panel panel-default">

        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">                         
                            </div>
                            <div class="panel-body panel-body-nopadding">
                                <?php foreach ($PresupuestoZona as $item): ?>     
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                                        </div>

                                        <div class="col-md-4">
                                            <h5> Nombre Zona Venta: <span class="text-primary"><?php echo $item['NombreZonadeVentas']; ?></span></h5>
                                            <h5> Dias Habiles: <span class="text-primary"><?php echo $item['DiasHabiles']; ?></span></h5>
                                        </div>

                                        <div class="col-md-4">
                                            <h5> Nombre Asesor:  <span class="text-primary"><?php echo $item['Nombre']; ?></span></h5>
                                            <h5> Dias Transcurridos: <span class="text-primary"><?php echo $item['DiasTranscurridos']; ?></span></h5>
                                            <?php $PorcentajeEsperado = $item['DiasTranscurridos'] / $item['DiasHabiles'] * 100 ?>
                                            <h5> Porcetaje Esperado: <span class="text-primary">%<?php echo $PorcentajeEsperado; ?></span></h5>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div><!-- panel-body -->
                        </div><!-- panel -->
                    </div><!-- col-md-6 -->

                    <div class="col-sm-12">
                        <div style="overflow: scroll">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Dimensiones</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerDimensiones" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                    <input type="button" value="Ver Tabla Dimensiones" class="btn btn-success verTablaDimension">
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                    </div>
                    <div class="col-sm-12">
                        <div style="overflow: scroll">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Profundidad</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerProfundida" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                    <input type="button" value="Ver Tabla Profundidad" class="btn btn-success verTablaProfundidad">
                                </div>
                            </div><!-- panel -->
                        </div>
                    </div><!-- col-sm-6 -->
                    <div class="col-sm-12">
                        <div style="overflow: scroll">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Proveedor</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerProveedor" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                    <input type="button" value="Ver Tabla Proveedor" class="btn btn-success verTablaProveedor">
                                </div>
                            </div><!-- panel -->
                        </div>
                    </div><!-- col-sm-6 -->
                </div>
            </div>
        </div>
    </div>


</div>

<?php
$Dimensiones = Consultas::model()->getDimenciones($item['Id']);
$Profundidad = Consultas::model()->getProfundidad($item['Id']);
$Proveedor = Consultas::model()->getProveedoresPresupuesto($item['Id']);
?>


<!--MODALES-->
<div class="modal fade" id="tablaDimensiones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Dimensiones</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered" id="tableDetail">
                        <th></th>
                        <th  class="text-center">Cartera</th>
                        <th class="text-center">Volumen</th>
                        <th class="text-center">Cobertura</th>
                        <th class="text-center">Efectividad</th>
                        <tr>
                            <td class="text-center">Presupuestado</td>
                            <?php foreach ($Dimensiones as $itemPesupuestado): ?>
                                <td class="text-center"><?php echo $itemPesupuestado['Presupuestado']; ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="text-center">Ejecutado</td>
                            <?php foreach ($Dimensiones as $itemEjecutado): ?>
                                <td class="text-center"><?php echo $itemEjecutado['Ejecutado']; ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <td class="text-center">% Cumplimiento</td>
                            <?php foreach ($Dimensiones as $itemPorcentajeCumplimiento): ?>
                                <td class="text-center"><?php echo $itemPorcentajeCumplimiento['PorcentajeCumplimiento']; ?></td>
                            <?php endforeach; ?>
                        </tr>
                    </table>
                </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>



<div class="modal fade" id="tablaProfundidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Profundidad</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered" id="tableDetailProfundidad">
                    <thead>
                        <th class="text-center">Dimension</th>
                        <th class="text-center">Objetivo</th>
                        <th class="text-center">Ejecutado</th>
                        <th class="text-center">% Cumplimiento</th>
                        <th class="text-center">Indicador</th>
                    </thead>
                    <tbody>
                        <?php foreach ($Profundidad as $itemaProfundidad): ?>
                            <tr>
                                <td class="text-center"><?php echo $itemaProfundidad['NombreDimension']; ?></td>
                                <td class="text-center"><?php echo $itemaProfundidad['Presupuestado']; ?></td>
                                <td class="text-center"><?php echo $itemaProfundidad['Ejecutado']; ?></td>
                                <td class="text-center"><?php echo $itemaProfundidad['PorcentajeCumplimiento']; ?></td>
                                <td class="text-center"><?php echo $itemaProfundidad['Indicador']; ?></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>        
                    </table>
                </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>



<div class="modal fade" id="tablaProveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Proveedores</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered" id="tablaProveedores">
                        <th class="text-center">Cod Proveedor</th>
                        <th class="text-center">Proveedor</th>
                        <th class="text-center">Cuota Pesos</th>
                        <th class="text-center">Pesos</th>
                        <th class="text-center">% Cumplimiento</th>
                        <?php foreach ($Proveedor as $itemaProveedor): ?>
                            <tr>
                                <td class="text-center"><?php echo $itemaProveedor['CodigoFabricante']; ?></td>
                                <td class="text-center"><?php echo $itemaProveedor['NombreFabricante']; ?></td>
                                <td class="text-center">$ <?php echo number_format($itemaProveedor['CuotaPesos'], '2', ',', '.'); ?></td>
                                <td class="text-center">$ <?php echo number_format($itemaProveedor['Pesos'], '2', ',', '.'); ?></td>
                                <td class="text-center"><?php echo $itemaProveedor['Cumplimiento']; ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </table>
                </div>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>



<script>
    $(document).ready(function(){
       
    //$('#tableDetailProfundidad').dataTable();


    $('#ContainerDimensiones').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Dimensiones'
            },
            subtitle: {
            text: 'Dimensiones'
            },
            xAxis: {
            categories: [
<?php foreach ($Dimensiones as $item): ?>
                '<?php echo $item['NombreDimension']; ?>',
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
                    //color: 'orange',
            }
            },
            series: [ {
            name: 'Presupuestado',
                    data: [

<?php foreach ($Dimensiones as $itemtotal): ?>
    <?php echo $itemtotal['Presupuestado']; ?>,
<?php endforeach; ?>
                    ]

            }, {
            name: 'Ejecutado',
                    data: [
<?php foreach ($Dimensiones as $itemtotal): ?>
    <?php echo $itemtotal['Ejecutado']; ?>,
<?php endforeach; ?>

                    ]

            }, {
            name: '% Cumplimiento',
                    data: [
<?php foreach ($Dimensiones as $itemtotal): ?>
    <?php echo $itemtotal['PorcentajeCumplimiento']; ?>,
<?php endforeach; ?>

                    ]

            }, ]
    });
            $('#ContainerProfundida').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Profundidad'
            },
            subtitle: {
            text: 'Profundidad'
            },
            xAxis: {
            categories: [
<?php
$contProfundidad = 0;
foreach ($Profundidad as $item): if ($contProfundidad < 12) {
        ?>
                    '<?php echo $item['NombreDimension']; ?>',
        <?php
    } $contProfundidad++;
endforeach;
?>
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
                    //color: 'orange',
            }
            },
            series: [ {
            name: 'Presupuestado',
                    data: [

<?php
$contProfundidad = 0;
foreach ($Profundidad as $itemtotal): if ($contProfundidad < 12) {
        ?>
        <?php echo $itemtotal['Presupuestado']; ?>,
        <?php
    } $contProfundidad++;
endforeach;
?>
                    ]

            }, {
            name: 'Ejecutado',
                    data: [
<?php
$contProfundidad = 0;
foreach ($Profundidad as $itemtotal): if ($contProfundidad < 12) {
        ?>
        <?php echo $itemtotal['Ejecutado']; ?>,
        <?php
    } $contProfundidad++;
endforeach;
?>

                    ]

            }, {
            name: '% Cumplimiento',
                    data: [
<?php
$contProfundidad = 0;
foreach ($Profundidad as $itemtotal): if ($contProfundidad < 12) {
        ?>
        <?php echo $itemtotal['PorcentajeCumplimiento']; ?>,
        <?php
    } $contProfundidad++;
endforeach;
?>

                    ]

            }, ]
    });
            $('#ContainerProveedor').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Proveedor'
            },
            subtitle: {
            text: 'Proveedor'
            },
            xAxis: {
            categories: [
<?php foreach ($Proveedor as $item): ?>
                '<?php echo $item['NombreFabricante']; ?>',
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
                    //color: 'orange',
            }
            },
            series: [ {
            name: 'Cuota Pesos',
                    data: [

<?php foreach ($Proveedor as $itemtotal): ?>
    <?php echo $itemtotal['CuotaPesos']; ?>,
<?php endforeach; ?>
                    ]

            }, {
            name: 'Pesos',
                    data: [
<?php foreach ($Proveedor as $itemtotal): ?>
    <?php echo $itemtotal['Pesos']; ?>,
<?php endforeach; ?>

                    ]

            }, ]
    });
    });


</script>