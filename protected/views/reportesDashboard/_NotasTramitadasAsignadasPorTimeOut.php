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
                                                <?php foreach ($NotasDirectorComercialTimeOut as $itemDirector):?>
                                                <td class="text-center"><?php echo $itemDirector['QuienAutoriza'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Notas Asignadas</td>
                                                 <?php foreach ($NotasDirectorComercialTimeOut as $itemDirector):?>
                                                <td class="text-center"><?php echo $itemDirector['notasAsignadas'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cantidad TimeOut</td>
                                                 <?php foreach ($NotasDirectorComercialTimeOut as $itemDirector):?>
                                                <td class="text-center"><?php echo $itemDirector['NotasAutorizadasPorTimeOut'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Valor TimeOut</td>
                                                 <?php foreach ($NotasDirectorComercialTimeOut as $itemDirector):?>
                                                <td class="text-center">$ <?php echo number_format($itemDirector['valorNotas'],'2',',','.') ?></td>
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
                                    <div id="ContainerGerente" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                   <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">
                                        <table class="table table-bordered" style="width: 1500px;">
                                            <tr>
                                                <td class="text-center">Gerente</td>
                                                <?php foreach ($NotasGerentesTimeOut as $itemGerente):?>
                                                <td class="text-center"><?php echo $itemGerente['QuienAutoriza'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Notas Asignadas</td>
                                                 <?php foreach ($NotasGerentesTimeOut as $itemGerente):?>
                                                <td class="text-center"><?php echo $itemGerente['notasAsignadas'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cantidad TimeOut</td>
                                                 <?php foreach ($NotasGerentesTimeOut as $itemGerente):?>
                                                <td class="text-center"><?php echo $itemGerente['NotasAutorizadasPorTimeOut'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Valor TimeOut</td>
                                                 <?php foreach ($NotasGerentesTimeOut as $itemGerente):?>
                                                <td class="text-center">$ <?php echo number_format($itemGerente['valorNotas'],'2',',','.') ?></td>
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
                                        <table class="table table-bordered" style="width: 1500px;">
                                            <tr>
                                                <td class="text-center">Cartera</td>
                                                <?php foreach ($NotasCarteraTimeOut as $itemCartera):?>
                                                <td class="text-center"><?php echo $itemCartera['QuienAutoriza'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Notas Asignadas</td>
                                                 <?php foreach ($NotasCarteraTimeOut as $itemCartera):?>
                                                <td class="text-center"><?php echo $itemCartera['notasAsignadas'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cantidad TimeOut</td>
                                                 <?php foreach ($NotasCarteraTimeOut as $itemCartera):?>
                                                <td class="text-center"><?php echo $itemCartera['NotasAutorizadasPorTimeOut'] ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Valor TimeOut</td>
                                                 <?php foreach ($NotasCarteraTimeOut as $itemCartera):?>
                                                <td class="text-center">$ <?php echo number_format($itemCartera['valorNotas'],'2',',','.') ?></td>
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
                text: 'Notas Asignadas Director / Notas TimeOut Director'
            },
            subtitle: {
                text: 'Notas Asignadas Director / Notas TimeOut Asignadas'
            },
            xAxis: {
                categories: [
               <?php foreach ($NotasDirectorComercialTimeOut as $item):?>
                '<?php echo $item['QuienAutoriza']; ?>',
               <?php  endforeach; ?>
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
<?php foreach ($NotasDirectorComercialTimeOut as $itemtotal): ?>
   <?php echo $itemtotal['notasAsignadas']; ?>,
<?php  endforeach; ?>
                    ]

                }, {
                    name: 'Notas TimeOut',
                    color: '#FFA200',
                    data: [
<?php foreach ($NotasDirectorComercialTimeOut as $itemPedidos):?>
   <?php echo $itemPedidos['NotasAutorizadasPorTimeOut']; ?>,
<?php  endforeach; ?>
                    ]

                }, ]
        });
        
        
         $('#ContainerGerente').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Notas Asignadas Gerente / Notas TimeOut Gerente'
            },
            subtitle: {
                text: 'Notas Asignadas Gerente/ Notas TimeOut Gerente'
            },
            xAxis: {
                categories: [
               <?php foreach ($NotasGerentesTimeOut as $item):?>
                '<?php echo $item['QuienAutoriza']; ?>',
               <?php  endforeach; ?>
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
<?php foreach ($NotasGerentesTimeOut as $itemtotal): ?>
   <?php echo $itemtotal['notasAsignadas']; ?>,
<?php  endforeach; ?>
                    ]

                }, {
                    name: 'Notas TimeOut',
                    color: '#FFA200',
                    data: [
<?php foreach ($NotasGerentesTimeOut as $itemPedidos):?>
   <?php echo $itemPedidos['NotasAutorizadasPorTimeOut']; ?>,
<?php  endforeach; ?>
                    ]

                }, ]
        });
        
        
         $('#ContainerCartera').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Notas Asignadas Cartera / Notas TimeOut Cartera '
            },
            subtitle: {
                text: 'Notas Asignadas Cartera / Notas TimeOut Cartera'
            },
            xAxis: {
                categories: [
               <?php foreach ($NotasCarteraTimeOut as $item):?>
                '<?php echo $item['QuienAutoriza']; ?>',
               <?php  endforeach; ?>
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
<?php foreach ($NotasCarteraTimeOut as $itemtotal): ?>
   <?php echo $itemtotal['notasAsignadas']; ?>,
<?php  endforeach; ?>
                    ]

                }, {
                    name: 'Notas TimeOut',
                    color: '#FFA200',
                    data: [
<?php foreach ($NotasCarteraTimeOut as $itemPedidos):?>
   <?php echo $itemPedidos['NotasAutorizadasPorTimeOut']; ?>,
<?php  endforeach; ?>
                    ]

                }, ]
        });
        
        
        
   
  


</script>
    