<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span>AcumuladoMes</h2>      
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

                    <h3 style="text-align: center">Reportes/Acumulado mes</h3>
                    <br>
                            <br>
                    <div class="row">   
                        <div class="col-sm-6">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Cobertura</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerCobertura" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <?php 
                                             $TotalCober = $TotalEjecutadoCobertura +  $ClientesCobertura;         
                                            $prcentaje = ($TotalCober / $TotalCobertura['PrsupuestoCobertura']) * 100;
                                            ?>
                                            <th></th>
                                            <th class="text-center">% <?php echo number_format($prcentaje,'2',',','.'); ?></th>
                                            <tr>
                                                <td class="text-center">Cobertura Total</td>
                                                <td class="text-center"><?php echo $TotalCober; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cobertura Presupuesto</td>
                                                <td class="text-center"><?php echo $TotalCobertura['PrsupuestoCobertura']; ?></td> 
                                            </tr>
                                        </table>
                                    </div>   
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                        <div class="col-sm-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Ventas vs Presupuestos</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerVentasPresupuesto" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <?php
                                            $TotalEjecutado = $TotalEjecutadoVolumen + $TotalValorAgenciaPedido;
                                            $porcentajeVentasPresupuesto = ($TotalEjecutado / $TotalVolumen['PrsupuestoVolumen']) * 100;
                                            //$TotalValorPesos = $TotalPedidosDiaMes +  $TotalValorAgenciaPedido;
                                            ?>
                                            <th></th>
                                            <th class="text-center">% <?php echo number_format($porcentajeVentasPresupuesto,'2',',','.') ?></th>
                                            <tr>
                                                <td class="text-center">Pesos Totales</td>
                                                <td class="text-center">$ <?php echo number_format($TotalEjecutado, '2', ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Presupuesto Pesos</td>
                                                <td class="text-center">$ <?php echo number_format($TotalVolumen['PrsupuestoVolumen'], '2', ',', '.'); ?></td> 
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
                                    <h3 class="panel-title">Efectividad</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerEfectividad" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <?php $porcentajeEfectividad = ($EfectividadTotal / $EfectividadPresupuesto) * 100;
                                            ?>
                                            <th></th>
                                            <th class="text-center">% <?php echo number_format($porcentajeEfectividad,'2') ?></th>
                                            <tr>
                                                <td class="text-center">Efectividad Total</td>
                                                <td class="text-center"> <?php echo number_format($EfectividadTotal, '2', ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Efectividad Propuesta</td>
                                                <td class="text-center"><?php echo number_format($EfectividadPresupuesto, '2', ',', '.'); ?></td> 
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
                                    <h3 class="panel-title">Pedidos de Ventas</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerPedidosVentas" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td> 
                                              <?php foreach ($GraficaDias as $itemGrafica): 
                                                  if($itemGrafica['PedidosMesActual'] != "" && $itemGrafica['TotalPedidoMensual'] != ""):
                                                  ?>  
                                                <th class="text-center"><?php echo $itemGrafica['Dia'];  ?></th>
                                              <?php endif; endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Valor</th>
                                               <?php foreach ($GraficaDias as $itemGrafica): 
                                                  if($itemGrafica['PedidosMesActual'] != "" && $itemGrafica['TotalPedidoMensual'] != ""):
                                                  ?>  
                                                <td class="text-center">$ <?php echo number_format($itemGrafica['TotalPedidoMensual'],'2',',','.');  ?></td>
                                              <?php endif; endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Pedidos</th>
                                               <?php foreach ($GraficaDias as $itemGrafica): 
                                                  if($itemGrafica['PedidosMesActual'] != "" && $itemGrafica['TotalPedidoMensual'] != ""):
                                                  ?>  
                                                <td class="text-center"><?php echo $itemGrafica['PedidosMesActual'];  ?></td>
                                              <?php endif; endforeach; ?>  
                                            </tr>
                                        </table>
                                    </div>   
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                    </div>
                    <select id="dia" class="form-control" style="width: 150px;">
                        <option value="0">Seleccione un Dia</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miercoles">Miercoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                    </select>
                    <br>
                    <div id="PedidosCanalDia">
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Pedidos x Canal</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerPedidosCanal" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td> 
                                              <?php foreach ($PedidosMesCanal as $itemCanal): 
                                                  ?>  
                                                <th class="text-center"><?php echo $itemCanal['NombreCanal'];  ?></th>
                                              <?php endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Valor</th>
                                               <?php foreach ($PedidosMesCanal as $itemCanal): 
                                                  ?>  
                                                <td class="text-center">$ <?php echo number_format($itemCanal['ValorPedidoCanal'],'2',',','.');  ?></td>
                                              <?php  endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Canal</th>
                                               <?php foreach ($PedidosMesCanal as $itemCanal): 
                                                  ?>  
                                                <td class="text-center"><?php echo $itemCanal['CodCanal'];  ?></td>
                                              <?php  endforeach; ?>  
                                            </tr>
                                        </table>
                                    </div>   
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                      </div> <!--row--> 
                    </div>
                </div>
            </div>



        </div>
    </div>      



</div>

   <?php $this->renderPartial('//mensajes/_alertaCargando'); ?>  

<script>

    $(document).ready(function() {

        $('#ContainerCobertura').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Cobertura'
            },
            subtitle: {
                text: 'Cobertura'
            },
            xAxis: {
                categories: [
                    'Cobertura'
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
                    name: 'Cobertura Total',
                    data: [
<?php echo $TotalCober ?>,
                    ]

                }, {
                    name: 'Cobertura Presupuesto',
                    data: [
<?php echo $TotalCobertura['PrsupuestoCobertura'] ?>,
                    ]

                }, ]
        });


        $('#ContainerVentasPresupuesto').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Ventas x Presupuesto'
            },
            subtitle: {
                text: 'Ventas x Presupuesto'
            },
            xAxis: {
                categories: [
                    'Ventas x Presupuesto'
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
                    name: 'Pesos Total',
                    color: '#f7a35c',
                    data: [
<?php echo $TotalEjecutado; ?>,
                    ]

                }, {
                    name: 'Presupuesto pesos',
                    color: '#90ed7d',
                    data: [
<?php echo $TotalVolumen['PrsupuestoVolumen']; ?>,
                    ]

                }, ]
        });
        
        
        
        $('#ContainerEfectividad').highcharts({
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
                    'Efectividad'
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
                    name: 'Efectividad Total',
                    color: '#3300FF',
                    data: [
<?php echo $EfectividadTotal; ?>,
                    ]

                }, {
                    name: 'Efectividad Propuesta',
                    color: '#FFA200',
                    data: [
<?php echo $EfectividadPresupuesto; ?>,
                    ]

                }, ]
        });
        
        
        $('#ContainerPedidosVentas').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Pedidos Ventas'
            },
            subtitle: {
                text: 'Pedidos Ventas'
            },
            xAxis: {
                categories: [
               <?php foreach ($GraficaDias as $item): if($item['TotalPedidoMensual'] != "" && $item['PedidosMesActual'] !=""):?>
                '<?php echo $item['Dia']; ?>',
               <?php endif; endforeach; ?>
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
                    color: '#3300FF',
                    data: [
<?php foreach ($GraficaDias as $itemtotal): if($itemtotal['TotalPedidoMensual'] != "" && $itemtotal['PedidosMesActual'] !=""):  ?>
   <?php echo $itemtotal['TotalPedidoMensual']; ?>,
<?php endif; endforeach; ?>
                    ]

                }, {
                    name: 'Pedidos',
                    color: '#FFA200',
                    data: [
<?php foreach ($GraficaDias as $itemPedidos): if($itemPedidos['TotalPedidoMensual'] != "" && $itemPedidos['PedidosMesActual'] !=""): ?>
   <?php echo $itemPedidos['PedidosMesActual']; ?>,
<?php endif; endforeach; ?>
                    ]

                }, ]
        });
        
        
        $('#ContainerPedidosCanal').highcharts({
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
               <?php foreach ($PedidosMesCanal as $item):?>
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
<?php foreach ($PedidosMesCanal as $itemtotal): ?>
   <?php echo $itemtotal['ValorPedidoCanal']; ?>,
<?php  endforeach; ?>
                    ]

                }, ]
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

