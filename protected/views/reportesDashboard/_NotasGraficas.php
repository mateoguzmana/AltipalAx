<div class="contentpanel">
    <div class="panel-heading">


        <div class="widget widget-blue">


            <div class="widget-content">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a href="#" class="minimize">&minus;</a>
                                </div><!-- panel-btns -->
                                <h3 class="panel-title">Director</h3>
                            </div>
                            <div class="panel-body">
                                <div id="ContainerDirector" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">
                                    <table class="table table-bordered" style="width: 1500px;">
                                        <tr>
                                            <td class="text-center">Director</td>
                                            <?php foreach ($NotasDirectorComercial as $itemDirector): ?>
                                                <td class="text-center"><?php echo $itemDirector['QuienAutoriza'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Notas Tramitadas</td>
                                            <?php foreach ($NotasDirectorComercial as $itemDirector): ?>
                                                <td class="text-center"><?php echo $itemDirector['notas'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Notas Asignadas</td>
                                            <?php foreach ($NotasDirectorComercial as $itemDirector): ?>
                                                <td class="text-center"><?php echo $itemDirector['notasAsignadas'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </table>
                                </div>   
                            </div>
                        </div><!-- panel -->
                    </div><!-- col-sm-6 -->
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a href="#" class="minimize">&minus;</a>
                                </div><!-- panel-btns -->
                                <h3 class="panel-title">Gerente</h3>
                            </div>
                            <div class="panel-body">
                                <div id="ContainerGerentes" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">
                                    <table class="table table-bordered" style="width: 100%px;">
                                        <tr>
                                            <td class="text-center">Gerente</td>
                                            <?php foreach ($NotasGerentes as $itemGerente): ?>
                                                <td class="text-center"><?php echo $itemGerente['QuienAutoriza'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Notas Tramitadas</td>
                                            <?php foreach ($NotasGerentes as $itemGerente): ?>
                                                <td class="text-center"><?php echo $itemGerente['notas'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Notas Asignadas</td>
                                            <?php foreach ($NotasGerentes as $itemGerente): ?>
                                                <td class="text-center"><?php echo $itemGerente['notasAsignadas'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </table>
                                </div>   
                            </div>
                        </div><!-- panel -->
                    </div><!-- col-sm-6 -->
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a href="#" class="minimize">&minus;</a>
                                </div><!-- panel-btns -->
                                <h3 class="panel-title">Cartera</h3>
                            </div>
                            <div class="panel-body">
                                <div id="ContainerCartera" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <td class="text-center">Cartera</td>
                                            <?php foreach ($NotasCartera as $itemCartera): ?>
                                                <td class="text-center"><?php echo $itemCartera['QuienAutoriza'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Notas Tramitadas</td>
                                            <?php foreach ($NotasCartera as $itemCartera): ?>
                                                <td class="text-center"><?php echo $itemCartera['notas'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td class="text-center">Notas Asignadas</td>
                                            <?php foreach ($NotasCartera as $itemCartera): ?>
                                                <td class="text-center"><?php echo $itemCartera['notasAsignadas'] ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </table>
                                </div>   
                            </div>
                        </div><!-- panel -->
                    </div><!-- col-sm-6 -->
                </div>

            </div>
        </div>
    </div>


</div>  

<script>
    $('#ContainerDirector').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Notas Asignadas / Notas Tramitadas'
            },
            subtitle: {
            text: 'Notas Asignadas / Notas Tramitadas'
            },
            xAxis: {
            categories: [
<?php foreach ($NotasDirectorComercial as $item): ?>
                '<?php echo $item['QuienAutoriza']; ?>',
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
                    //color: '#FF8D00',
            }
            },
            series: [{
            name: 'Notas Asignadas',
                    color: '#3300FF',
                    data: [
<?php foreach ($NotasDirectorComercial as $itemtotal): ?>
    <?php echo $itemtotal['notas']; ?>,
<?php endforeach; ?>
                    ]

            }, {
            name: 'Notas Tramitadas',
                    color: '#FFA200',
                    data: [
<?php foreach ($NotasDirectorComercial as $itemPedidos): ?>
    <?php echo $itemPedidos['notasAsignadas']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
    
 $('#ContainerGerentes').highcharts({
      chart: {
    type: 'column'
    },
            title: {
            text: 'Notas Tramitadas / Notas Asignadas'
            },
            subtitle: {
            text: 'Notas Tramitadas / Notas Asignadas'
            },
            xAxis: {
            categories: [
<?php foreach ($NotasGerentes as $item): ?>
                '<?php echo $item['QuienAutoriza']; ?>',
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
                    //color: '#FF8D00',
            }
            },
            series: [{
            name: 'Notas Tramitadas',
                    color: '#3300FF',
                    data: [
<?php foreach ($NotasGerentes as $itemtotal): ?>
    <?php echo $itemtotal['notas']; ?>,
<?php endforeach; ?>
                    ]

            }, {
            name: 'Notas Asignadas',
                    color: '#FFA200',
                    data: [
<?php foreach ($NotasGerentes as $itemPedidos): ?>
    <?php echo $itemPedidos['notasAsignadas']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
    
$('#ContainerCartera').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Notas Tramitadas / Notas Asignadas'
            },
            subtitle: {
            text: 'Notas Tramitadas / Notas Asignadas'
            },
            xAxis: {
            categories: [
<?php foreach ($NotasCartera as $item): ?>
                '<?php echo $item['QuienAutoriza']; ?>',
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
                    //color: '#FF8D00',
            }
            },
            series: [{
            name: 'Notas Tramitadas',
                    color: '#3300FF',
                    data: [
<?php foreach ($NotasCartera as $itemtotal): ?>
    <?php echo $itemtotal['notas']; ?>,
<?php endforeach; ?>
                    ]

            }, {
            name: 'Notas Asignadas',
                    color: '#FFA200',
                    data: [
<?php foreach ($NotasCartera as $itemPedidos): ?>
    <?php echo $itemPedidos['notasAsignadas']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
</script>
