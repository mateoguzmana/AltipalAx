<div class="row">
                          <div class="col-sm-12">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Pedidos x Canal Dia</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerPedidosCanalDia" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td> 
                                              <?php foreach ($PedidosDiaCanal as $itemCanal): 
                                                  ?>  
                                                <th class="text-center"><?php echo $itemCanal['NombreCanal'];  ?></th>
                                              <?php endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Valor</th>
                                               <?php foreach ($PedidosDiaCanal as $itemCanal): 
                                                  ?>  
                                                <td class="text-center">$ <?php echo number_format($itemCanal['ValorPedidoCanal'],'2',',','.');  ?></td>
                                              <?php  endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Canal</th>
                                               <?php foreach ($PedidosDiaCanal as $itemCanal): 
                                                  ?>  
                                                <td class="text-center"><?php echo $itemCanal['CodCanal'];  ?></td>
                                              <?php  endforeach; ?>  
                                            </tr>
                                        </table>
                                    </div>   
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                    </div>
<script>
    
    
    $('#ContainerPedidosCanalDia').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pedidos Canal Dia'
            },
            subtitle: {
                text: 'Pedidos Canal Dia'
            },
            xAxis: {
                categories: [
               <?php foreach ($PedidosDiaCanal as $item):?>
                '<?php echo $item['NombreCanal']; ?>',
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
                    name: 'Valor Pedidos',
                    color: '#FFA200',
                    data: [
<?php foreach ($PedidosDiaCanal as $itemtotal): ?>
   <?php echo $itemtotal['ValorPedidoCanal']; ?>,
<?php  endforeach; ?>
                    ]

                }, ]
        });
    
    
    
</script>
