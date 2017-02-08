<div class="row">
    <div style="overflow: scroll">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Efectividad</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containerefectividadxfecha" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1500px  ! important;">
                                                <tr>
                                                     
                                                    <td class="text-center"><b>Clientes</b></td>
                                                    <td class="text-center"><b>Frecuencia</b></td>
                                                    <td class="text-center"><b>Objetivo Visita</b></td>
                                                    <td class="text-center"><b>Visita Efectiva</b></td>
                                                    <td class="text-center"><b>Visitas NO Efectivas</b></td>
                                                </tr>
                                                 <?php foreach ($reportexfecha as $ItemEfectividadxFecha ){ ?>
                                                <tr>
                                                    <td></td>
                                                    <td class="text-center"><?php echo $ItemEfectividadxFecha['CodFrecuencia'] ?></td>
                                                    <td></td>
                                                    <td class="text-center"><?php echo $ItemEfectividadxFecha['Total_Pedidosfecha'] ?></td>
                                                    <td class="text-center"><?php echo $ItemEfectividadxFecha['NovistaxFEcha'] ?></td> 
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
                                        <div id="containernoventasZonaVentasxFecha" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1000px  ! important;">
                                                <tr>
                                                    <td class="text-center"><b>Motivos</b></td>
                                                    <?php
                                                    foreach ($reportexzonaNoVentasFecha as $Itemes) {
                                                        ?>
                                                        <td class="text-center"><?php echo $Itemes['Nombre'] ?></td>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td class="text-center"><b>Clientes No Ventas</b></td>
                                                    <?php
                                                    foreach ($reportexzonaNoVentasFecha as $ItemTotales) {
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
                        <div class="row">
                            <div style="overflow: scroll">
                            <div class="col-sm-12">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Profundida</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containernotascreditos" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1000px;">
                                                <tr>
                                                   
                                                </tr>
                                                <tr>
                                                   
                                                </tr>
                                            </table>
                                            <table style="width: 151px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                                                <td>
                                                    <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Profundida

                                                </td>
                                            </table>

                                        </div>

                                    </div>
                                </div><!-- panel -->
                            </div><!-- col-sm-6 -->
                            </div>

                        </div><!-- row -->
                        
                        <script>
                        
   $('#containerefectividadxfecha').highcharts({
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
                   <?php foreach ($reportexfecha as $itemZonaFecha): ?>
                         '<?php echo $itemZonaFecha['CodFrecuencia']; ?>',
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
                    name: 'Visitas Efectivas',
                    data: [
                     <?php foreach ($reportexfecha as $itemtotalEfeZonaFecha): ?> 
                       <?php echo $itemtotalEfeZonaFecha['Total_Pedidosfecha']; ?>,
                     <?php endforeach; ?>,
                          
                    ]

                }]
        });
        
        
        
        
    
    
    $('#containernoventasZonaVentasxFecha').highcharts({
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
           ['<?php echo $itemmes['Nombre'] ?>',   <?php echo $itemmes['total_clientes_noventas_mes'] ?>],
                <?php endforeach; ?>
                           
              
            ]
        }]
    });
    
                        
                        
                        </script>                       

