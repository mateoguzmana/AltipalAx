<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span>ZonaVentas</h2>      
</div> 

<div class="contentpanel" style="margin-bottom: -27px;">
    <div class="panel panel-default">        
        <div class="panel-body">
            <div class="panel-heading">
                <?php $this->renderPartial('_IconosMenu'); ?>
                <br>
            </div>
        </div>
    </div>  
</div>


  
<div class="contentpanel">
    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">

            <div class="widget widget-blue">
                <div class="widget-content">

                    <h3 style="text-align: center">Reportes/Zona ventas</h3>
                        <br>
                            <br>
                    <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div class="cargaselectagenciaAction" id="selectAgen">
                                    <select id="selectchosenagencia" name="Agencia" class="form-control chosen-select  onchagegrupos" data-placeholder="Seleccione una agencia">
                                        <option value=""></option>
                                        <?php
                                        foreach ($Agencias as $itemaAgen) {
                                            ?> 
                                            <option value="<?php echo $itemaAgen['CodAgencia'] ?>"><?php echo $itemaAgen['Nombre'] ?></option>

                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>    
                        
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Canal</label>
                                <div class="cargarcanalAction">
                                    <select id="selectchosencanal" name="Canal" class="form-control chosen-select  GenrarRepoteCanal" data-placeholder="Seleccione un canal">
                                        <option value=""></option>
                                        <?php
                                        $canal = ReporteZonaVentas::model()->getCanales();

                                        foreach ($canal as $itemaCanla) {
                                            ?> 
                                            <option value="<?php echo $itemaCanla['CodigoCanal'] ?>"><?php echo $itemaCanla['NombreCanal'] ?></option>

                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>    

                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Grupo Ventas</label>
                                <div id="grupoventa" class="onchangezonaventas GenrarRepoteGrupVenta  	cargargrupoventasAction">
                                    <select id="selectchosegrupventas" name="GruposVentas" class="form-control chosen-select" data-placeholder="Seleccione un grupo ventas">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>   

                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Zona Ventas</label>
                                <div id="zonasventas" class="onchangereportzonaventas cargarzonaventasAction">
                                    <select id="selectchosezonaventas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>   
                        </div>


                    </div>
                    </div>
                    <div id="graf">

                        <div class="row">
                                <div class="col-sm-12">
                                    <div class="panel panel-primary" style="border: solid 1px #428bca">
                                        <div class="panel-heading">
                                            <div class="panel-btns">
                                                <a href="#" class="minimize">&minus;</a>
                                            </div><!-- panel-btns -->
                                            <h3 class="panel-title">Efectividad</h3>
                                        </div>
                                        <div class="panel-body" style="overflow-x: scroll; overflow-y: no-display">
                                            <div id="containerefectividad" style="width: 100%; min-width: 500px; margin: 0 auto"></div>
                                            <div class="">
                                                <table class="table table-bordered" style="width: 100%; min-width: 500px;">
                                                    <tr>
                                                        <td class="text-center"><b>Clientes</b></td>
                                                        <td class="text-center"><b>Frecuencia</b></td>
                                                        <td class="text-center"><b>Objetivo Visita</b></td>
                                                        <td class="text-center"><b>Visita Efectiva</b></td>
                                                        <td class="text-center"><b>Visitas NO Efectivas</b></td>
                                                    </tr>
                                                    <?php foreach ($Frecuencias as $ItemFrecuencias) { ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $ItemFrecuencias['Total_ClientesVisita'] ?></td>
                                                            <td class="text-center"><?php echo $ItemFrecuencias['CodFrecuencia'] ?></td>
                                                            <td></td>
                                                            <td class="text-center"><?php echo $ItemFrecuencias['numVisitasEfectiva'] ?></td>
                                                            <td class="text-center"><?php echo $ItemFrecuencias['numNovisita'] ?></td>
                                                        </tr>

                                                    <?php } ?>

                                                </table>

                                            </div>
                                        </div>
                                    </div><!-- panel -->
                                </div><!-- col-sm-6 -->
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
                                            <div id="containernoventasZonaVentas" style="width: 100%; min-width: 500px; margin: 0 auto"></div>
                                            <div>
                                                <table class="table table-bordered" style="width: 100%; min-width: 500px;">
                                                    <?php
                                                    $count = count($Agencias);

                                                    if ($count > 1) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><b>Motivos</b></td>
                                                            <?php
                                                            for ($i = 0; $i < count($Noventames); $i++) {
                                                                for ($j = $i + 1; $j < count($Noventames); $j++) {
                                                                    if ($Noventames[$i]['Nombre'] == $Noventames[$j]['Nombre']) {
                                                                        ?>

                                                                        <td class="text-center"><?php echo $Noventames[$i]['Nombre'] ?></td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>     
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center"><b>Clientes No Ventas</b></td>
                                                            <?php
                                                            for ($i = 0; $i < count($Noventames); $i++) {
                                                                for ($j = $i + 1; $j < count($Noventames); $j++) {
                                                                    if ($Noventames[$i]['Nombre'] == $Noventames[$j]['Nombre']) {
                                                                        $Noventames[$i]['total_clientes_noventas_mes'] = $Noventames[$i]['total_clientes_noventas_mes'] + $Noventames[$j]['total_clientes_noventas_mes'];
                                                                        ?>

                                                                        <td class="text-center"><?php echo $Noventames[$i]['total_clientes_noventas_mes'] ?></td>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </tr>
                                                    <?php } else { ?>

                                                        <tr>
                                                            <td class="text-center"><b>Motivos</b></td>
                                                            <?php
                                                            foreach ($Noventames as $Itemes) {
                                                                ?>
                                                                <td class="text-center"><?php echo $Itemes['Nombre'] ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center"><b>Clientes No Ventas</b></td>
                                                            <?php
                                                            foreach ($Noventames as $ItemTotales) {
                                                                ?>
                                                                <td class="text-center"><?php echo $ItemTotales['total_clientes_noventas_mes'] ?></td>
                                                                <?php
                                                            }
                                                            ?>
                                                        </tr>

                                                    <?php } ?>   
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
                                    <div class="cargaselectagenciaAction" id="selectAgen">
                                        <select disabled="true" id="selectchosentipo" name="tipo" class="form-control chosen-select cargarRGMGlobal" data-placeholder="Seleccione un tipo">
                                            <option value=""></option>
                                            <option value="Grupo">Grupo</option>
                                            <option value="Marca">Marca</option>

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
                                <div class="col-sm-12">
                                    <div class="panel panel-primary" style="border: solid 1px #428bca">
                                        <div class="panel-heading">
                                            <div class="panel-btns">
                                                <a href="#" class="minimize">&minus;</a>
                                            </div><!-- panel-btns -->
                                            <h3 class="panel-title">Profundidad</h3>
                                        </div>
                                        <div class="panel-body" style="overflow-x: scroll; overflow-y: no-display">
                                            <div id="containerprofundidadglobal" style="width: 100%; min-width: 500px; margin: 0 auto"></div>

                                                <table class="table table-bordered" style="width: 100%; min-width: 500px;">
                                                    <tr>
                                                        <td class="text-center">Proveedor</td>
                                                        <?php
                                                        $cont = 0;
                                                        foreach ($ProfundidadGlobal as $ItemProfundidad) {
                                                            if ($cont < 12) {
                                                                ?>
                                                                <td class="text-center"><?php echo $ItemProfundidad['NombreDimension'] ?></td>
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
                                                        foreach ($ProfundidadGlobal as $ItemProfundidad) {
                                                            if ($cont < 12) {
                                                                ?>
                                                                <td class="text-center"><?php echo number_format($ItemProfundidad['ejecutadoglobal'], '2', ',', '.') ?></td>
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
                                                        foreach ($ProfundidadGlobal as $ItemProfundidad) {
                                                            if ($cont < 12) {
                                                                ?>
                                                                <td class="text-center"><?php echo number_format($ItemProfundidad['presupuestadoglobal'], '2', ',', '.') ?></td>
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
                                                        foreach ($ProfundidadGlobal as $ItemPorcentaje) {
                                                            if ($cont < 12) {
                                                                $PorcentajeGlobal = $ItemPorcentaje['ejecutadoglobal'] / $ItemPorcentaje['presupuestadoglobal'] * 100
                                                                ?>
                                                                <td class="text-center">% <?php echo number_format($PorcentajeGlobal, '2'); ?></td>
                                                                <?php
                                                            }
                                                            $cont++;
                                                        }
                                                        ?>
                                                    </tr>
                                                </table>

                                        </div>
                                    </div><!-- panel -->
                                </div><!-- col-sm-6 -->
                        </div><!-- row -->
                        
                    </div>    

                    </div>

                </div>
            </div>



        </div>
    </div>      



</div>

<?php $this->renderPartial('//mensajes/_alerta');?> 


<script>

    $(document).ready(function() {


    $('#containerefectividad').highcharts({
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
<?php foreach ($Frecuencias as $ItemFrecuencias): ?>
                '<?php echo $ItemFrecuencias['CodFrecuencia']; ?>',
<?php endforeach; ?>


<?php foreach ($VisitasEfectivas as $itemVisitasEFEc): ?>
                '<?php echo $itemVisitasEFEc['CodFrecuencia']; ?>',
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
<?php foreach ($Frecuencias as $ItemFrecuencias): ?>
    <?php echo $ItemFrecuencias['Total_ClientesVisita']; ?>,
<?php endforeach; ?>,
                    ]

            }, {
            name: 'Visitas Efectivas',
                    data:
                    [
<?php foreach ($Frecuencias as $ItemFrecuencias): ?>
    <?php
    if ($ItemFrecuencias['numVisitasEfectiva'] == NULL) {

        $ItemFrecuencias['numVisitasEfectiva'] = 0
        ?>

    <?php } else { ?>

        <?php echo $ItemFrecuencias['numVisitasEfectiva']; ?>,
    <?php } ?>

<?php endforeach; ?>,
                    ]

            }]
    });
            $('#containernoventasZonaVentas').highcharts({
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
<?php
$congraf = count($Agencias);

if ($congraf > 1) {
    ?>
    <?php
    for ($i = 0; $i < count($Noventames); $i++) {
        for ($j = $i + 1; $j < count($Noventames); $j++) {
            if ($Noventames[$i]['Nombre'] == $Noventames[$j]['Nombre']) {
                ?>
                                    ['<?php echo $Noventames[$i]['Nombre'] ?>', <?php echo $Noventames[$i]['total_clientes_noventas_mes'] ?>],
                <?php
            }
        }
    }
    ?>
<?php } else { ?>

    <?php foreach ($Noventames as $itemmes): ?>
                            ['<?php echo $itemmes['Nombre'] ?>', <?php echo $itemmes['total_clientes_noventas_mes'] ?>],
    <?php endforeach; ?>

<?php } ?>
                    ]
            }]
    });
            $('#containerprofundidadglobal').highcharts({
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
<?php foreach ($ProfundidadGlobal as $itemFabricante): ?>
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
foreach ($ProfundidadGlobal as $itemEje): if ($cont < 12): ?>
        <?php echo $itemEje['ejecutadoglobal']; ?>,
    <?php endif;
    $cont++;
endforeach; ?>,
                    ]

            }, {
            name: 'Objetivo',
                    data:
                    [
<?php $cont = 0;
foreach ($ProfundidadGlobal as $itemObj): if ($cont < 12): ?>
        <?php echo $itemObj['presupuestadoglobal']; ?>,
    <?php endif;
    $cont++;
endforeach; ?>,
                    ]

            }, {
            name: 'Porcentaje',
                    data:
                    [
<?php $cont = 0;
foreach ($ProfundidadGlobal as $itemPor): if ($cont < 12): $PorcentajeGlobalGrafica = $itemPor['ejecutadoglobal'] / $itemPor['presupuestadoglobal'] * 100 ?>
        <?php echo $PorcentajeGlobalGrafica; ?>,
    <?php endif;
    $cont++;
endforeach; ?>,
                    ]

            } ]
    });
    });

</script>

<style>
    .col-md-6{
        margin-bottom: 20px;
    }
    .col-md-4{
        margin-bottom: 20px;
    }
</style>






