
<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="minimize">&minus;</a>
                </div><!-- panel-btns -->
                <h3 class="panel-title">Pedido de venta</h3>
            </div>
            <div class="panel-body">
                <div id="containerAgenciaPedido" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-center">Canal</td>
                            <?php
                            foreach ($reportexagenciapedido as $ItemTotales) {
                                ?>
                                <td class="text-center"><?php echo $ItemTotales['NombreCanal'] ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="text-center">Pedidos&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: skyblue"></span></td>
                            <?php
                            foreach ($reportexagenciapedido as $ItemTotales) {
                                ?>
                                <td class="text-center"><?php echo $ItemTotales['num_pedidos'] ?></td>
                                <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="text-center">Pesos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                            <?php
                            foreach ($reportexagenciapedido as $ItemTotales) {
                                ?>
                                <td class="text-center">$ <?php echo number_format($ItemTotales['total_valor_pedidos'], '1', ',', '.') ?></td>
                                <?php
                            }
                            ?>
                        </tr>

                    </table>
                    <table style="width: 50px; height: 20px; margin: 0 auto;" class="table table-bordered">
                        <td>
                            <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: skyblue"></span>&nbsp;Pedidos

                        </td>
                        <td>
                            <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Pesos

                        </td>
                    </table>
                </div>   
            </div>
        </div><!-- panel -->
    </div><!-- col-sm-6 -->

    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="minimize">&minus;</a>
                </div><!-- panel-btns -->
                <h3 class="panel-title">Recaudos</h3>
            </div>
            <div class="panel-body">
                <div id="containerRecaudosxAgencia" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width: 462px  ! important;">
                        <tr>
                            <td class="text-center">Canal</td>
                            <?php
                            foreach ($reportexagenciarecaudos as $ItemTotales) {
                            ?>
                            <td class="text-center"><?php echo $ItemTotales['NombreCanal'] ?></td>
                            <?php
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="text-center">Recaudos <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: skyblue"></span></td>
                            <?php
                             foreach ($reportexagenciarecaudos as $ItemTotales) {
                            ?>
                            <td class="text-center"><?php echo $ItemTotales['num_recudos'] ?></td>
                            <?php
                             }
                            ?>
                        </tr>
                        <tr>
                            <td class="text-center">Pesos&nbsp;&nbsp<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                            <?php
                             foreach ($reportexagenciarecaudos as $ItemTotales) {
                            ?>
                            <td class="text-center">$ <?php echo number_format($ItemTotales['total_recaudos'], '1', ',', '.') ?> </td>
                            <?php
                             }
                            ?>
                        </tr>

                    </table>
                    <table style="width: 50px; height: 20px; margin: 0 auto;" class="table table-bordered">
                        <td>
                            <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: skyblue"></span>&nbsp;Recaudos

                        </td>
                        <td>
                            <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Pesos

                        </td>
                    </table>
                </div>
            </div>
        </div><!-- panel -->
    </div><!-- col-sm-6 -->

</div>
<div class="row">     
    <div class="col-sm-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="minimize">&minus;</a>
                </div><!-- panel-btns -->
                <h3 class="panel-title">Clientes Nuevos</h3>
            </div>
            <div class="panel-body">
                <div id="containerClientesNuevosxAgencia" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" style="width: 462px;">
                        <tr>
                            <td></td>
                            <?php
                              foreach ($reportexagenciaclientesnuevo as $ItemTotales) {
                             ?>
                            <td class="text-center"><?php echo $ItemTotales['CodigoCanal'] ?></td>
                            <?php
                              }
                            ?>
                        </tr>
                        <tr>
                            <td class="text-center">Clientes nuevos&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span></td>
                            <?php
                            foreach ($reportexagenciaclientesnuevo as $ItemTotales) {
                            ?>
                            <td class="text-center"><?php echo $ItemTotales['clientes'] ?></td>
                            <?php
                            }
                            ?>
                        </tr>
                    </table>
                    <table style="width: 130px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                        <td>
                            <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Clientes nuevos

                        </td>
                    </table>
                </div>
            </div>
        </div><!-- panel -->
    </div><!-- col-sm-6 -->

    <div class="col-sm-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="minimize">&minus;</a>
                </div><!-- panel-btns -->
                <h3 class="panel-title">Efectividad</h3>
            </div>
            <div class="panel-body">
                 <div id="containerEfectividadAgencia" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                   <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="text-center">Prcentaje</td> 
                                              <?php foreach ($reportexagenciaefectividad as $itemCanal):
                                                  
                                                  $CoberturaCanal = ReporteAcumuladoDia::model()->getClientesDiaPresupuestadoAgencia($itemCanal['NombreCanal'],$Agencia);  
                                                  
                                                  foreach ($CoberturaCanal as $itemCorbeCanal):
                                                      
                                                   $porcentajeEfecGlo  = $itemCanal['ClientesCanal'] / $itemCorbeCanal['ejecutadoEfc'] *  100;
                                                   ?>  
                                                <th class="text-center">% <?php echo number_format($porcentajeEfecGlo,'2');  ?></th>
                                              <?php endforeach; endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <td class="text-center">Nombre Canal</td> 
                                              <?php foreach ($reportexagenciaefectividad as $itemCanal):
                                                   ?>  
                                                <th class="text-center"><?php echo $itemCanal['NombreCanal'];  ?></th>
                                              <?php endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Clientes</th>
                                               <?php foreach ($reportexagenciaefectividad as $itemCanal): 
                                                  ?>  
                                                <td class="text-center"><?php echo $itemCanal['ClientesCanal'];  ?></td>
                                              <?php  endforeach; ?>  
                                            </tr>
                                        </table>
                                    </div>
            </div>
        </div><!-- panel -->
    </div><!-- col-sm-6 -->

</div><!-- row -->





<script>

    $(document).ready(function(){
        
    /*Highcharts.setOptions({
    lang: {
        //numericSymbols: null //otherwise by default ['k', 'M', 'G', 'T', 'P', 'E']
        numericSymbols: [' Mil', ' Millon', 'G', 'T', 'P', 'E']
    }
    });*/    

    $(function() {
    $("#datepicker").datepicker();
    });
            $("#selectchosegrupventas").chosen();
            $("#selectchosezonaventas").chosen();
            /////Grafica pedidos////

            $('#containerAgenciaPedido').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Acumulado Dia'
            },
            subtitle: {
            text: 'Pedido de venta'
            },
            xAxis: {
            categories: [
<?php foreach ($reportexagenciapedido as $item): ?>
                '<?php echo $item['NombreCanal']; ?>',
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
                    color: '#FF8D00',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reportexagenciapedido as $itemtotal): ?>

    <?php echo $itemtotal['total_valor_pedidos']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
          

    });
    
    //graficas de recaudos x fecha
    
     $('#containerRecaudosxAgencia').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Acumulado Dia'
            },
            subtitle: {
            text: 'Recaudos'
            },
            xAxis: {
            categories: [
<?php foreach ($reportexagenciarecaudos as $item): ?>
                '<?php echo $item['NombreCanal']; ?>',
<?php endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Valor'
                    },
                    
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
                    color: '#FF8D00',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reportexagenciarecaudos as $itemtotal): ?>

    <?php echo $itemtotal['total_recaudos']; ?>,
<?php endforeach; ?>
                    ]

            }]
    });


    //grafica de cientes nuevos x zona
    
      $('#containerClientesNuevosxAgencia').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Acumulado Dia'
            },
            subtitle: {
            text: 'Clientes Nuevo'
            },
            xAxis: {
            categories: [
<?php foreach ($reportexagenciaclientesnuevo as $item): ?>
                '<?php echo $item['CodigoCanal']; ?>',
<?php endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Rango'
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
                    color: '#FF8D00',
            }
            },
            series: [ {
            name: 'Clientes nuevos',
                    data: [

<?php foreach ($reportexagenciaclientesnuevo as $itemtotal): ?>

    <?php echo $itemtotal['clientes']; ?>,
<?php endforeach; ?>
                    ]
            }]
    });
    
    
    
      $('#containerEfectividadAgencia').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pedidos Canal'
            },
            subtitle: {
                text: 'Pedidos Canal'
            },
            xAxis: {
                categories: [
               <?php foreach ($reportexagenciaefectividad as $item):?>
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
                    name: 'Clientes',
                    color: '#FFA200',
                    data: [
<?php foreach ($reportexagenciaefectividad as $itemtotal): ?>
   <?php echo $itemtotal['ClientesCanal']; ?>,
<?php  endforeach; ?>
                    ]

                }, ]
        });

</script>

