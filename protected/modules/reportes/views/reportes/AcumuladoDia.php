<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span>AcumuladoDia</h2>      
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
  
                    <h3 style="text-align: center">Reportes/Acumulado diario</h3>
                    <br>
                            <br>
                    
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div>
                                    <select id="selectchosenagencia" name="Agencia" class="form-control chosen-select  onchagegrupos  GenrarRepoteAgencia" data-placeholder="Seleccione una agencia">
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
                                <label>Fecha</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control GenrarRepot"  id="datepicker" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Grupo Ventas</label>
                                <div id="grupoventa" class="onchangezonaventas GenrarRepoteGrupVenta">
                                    <select id="selectchosegrupventas" name="GruposVentas" class="form-control chosen-select" data-placeholder="Seleccione un grupo ventas">
                                        <option value=""></option>
                                        
                                        
                                    </select>
                                </div>
                            </div>
                        </div>   

                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Zona Ventas</label>
                                <div id="zonasventas" class="onchangereportzonaventas">
                                    <select id="selectchosezonaventas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta">
                                        <option value=""></option>


                                    </select>
                                </div>
                            </div>   
                        </div>


                    </div>
                    
                    

                    <div id="graf">
                    
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
                                    <div id="container" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="text-center">Pedidos&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: skyblue"></span></td>
                                                <?php
                                                $num_totales=0;
                                                foreach ($totales as $ItemTotales) {
                                                    $num_totales=$num_totales+$ItemTotales['num_pedidos'];  
                                                }
                                                ?>
                                                <td class="text-center"><?php echo $num_totales ?></td>    
                                            </tr>
                                            <tr>
                                                <td class="text-center">Pesos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                                <?php
                                                $TotalvalorPedidos=0;
                                                foreach ($totales as $ItemTotales) {
                                                $TotalvalorPedidos=$TotalvalorPedidos+$ItemTotales['total_valor_pedidos'];    
                                                }
                                                ?>
                                               <td class="text-center">$ <?php echo number_format($TotalvalorPedidos, '2', ',', '.') ?></td>  
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
                                    <div id="containerRecaudos" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 462px  ! important;">
                                            <tr>
                                                <td class="text-center">Recaudos <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: skyblue"></span></td>
                                                <?php
                                                $num_recudos=0;
                                                foreach ($totalesrecaudos as $ItemTotales) {
                                                $num_recudos=$num_recudos+$ItemTotales['num_recudos'];    
                                                }
                                                ?>
                                                <td class="text-center"><?php echo $num_recudos ?></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Pesos&nbsp;&nbsp<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                                <?php
                                                $total_recaudos=0;
                                                foreach ($totalesrecaudos as $ItemTotales) {
                                                $total_recaudos=$total_recaudos+$ItemTotales['total_recaudos'];    
                                                }
                                                ?>
                                               <td class="text-center">$ <?php echo number_format($total_recaudos, '2', ',', '.') ?></td> 
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
                                    <div id="containerClientesNuevos" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 462px;">
                                            
                                             <?php 
                                                  foreach ($totalclientes as $ItemTotales) {
                                                  $num_cliente=0;
                                                  $num_cliente=$num_cliente+$ItemTotales['clientes'];    
                                               ?> 
                                            <tr>
                                                <td class="text-center"><?php echo $ItemTotales['NombreCanal'] ?>&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span> </td>
                                                <td class="text-center"><?php echo $num_cliente ?></td> 
                                            </tr>
                                                <?php
                                                  }
                                                ?>
                                                
                                          
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
                                   <div id="containerEfectividad" style="position:relative; min-width:200px; max-width:700px; width: 100%;"></div>
                                   <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td class="text-center">Prcentaje</td> 
                                              <?php foreach ($Efectividad as $itemCanal):
                                                  
                                                  $CoberturaCanal = ReporteAcumuladoDia::model()->getClientesDiaPresupuestado($itemCanal['NombreCanal']);  
                                                  
                                                  foreach ($CoberturaCanal as $itemCorbeCanal):
                                                      
                                                   $porcentajeEfecGlo  = $itemCanal['ClientesCanal'] / $itemCorbeCanal['ejecutadoEfc'] *  100;
                                                   ?>  
                                                <th class="text-center">% <?php echo number_format($porcentajeEfecGlo,'2');  ?></th>
                                              <?php endforeach; endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <td class="text-center">Nombre Canal</td> 
                                              <?php foreach ($Efectividad as $itemCanal):
                                                   ?>  
                                                <th class="text-center"><?php echo $itemCanal['NombreCanal'];  ?></th>
                                              <?php endforeach; ?>  
                                            </tr>
                                            <tr>
                                                <th class="text-center">Clientes</th>
                                               <?php foreach ($Efectividad as $itemCanal): 
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
                    
                    </div>
                    
                </div>
            </div>



        </div>
    </div>      



</div>




<script>

    $(document).ready(function(){

    $(function() {
    $("#datepicker").datepicker();
    });
    
       $("#selectchosegrupventas").chosen();
       $("#selectchosezonaventas").chosen();
            /////Grafica pedidos////

            $('#container').highcharts({
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
                    'Total Pedidos Altipal'
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

    <?php $TotalvalorPedidos=0;  foreach ($totales as $itemtotal): $TotalvalorPedidos=$TotalvalorPedidos+$itemtotal['total_valor_pedidos'];?><?php endforeach; ?>
    <?php echo $TotalvalorPedidos ?>,
                    ]

            }, ]
    });
            //////grafica recaudos

            $('#containerRecaudos').highcharts({
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
                'Total Recaudos Altiapal'
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

<?php $total_recaudos=0; foreach ($totalesrecaudos as $itemtotal): $total_recaudos=$total_recaudos+$itemtotal['total_recaudos']; ?><?php endforeach; ?>
            <?php echo $total_recaudos; ?>,
                    ]

            }]
    });
            /////grafica clientes nuevo

            $('#containerClientesNuevos').highcharts({
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
                'Total Clientes Altiapal'
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

<?php $num_cliente=0; foreach ($totalclientes as $itemtotal): $num_cliente=$num_cliente+$itemtotal['clientes']; ?>

    <?php echo $num_cliente; ?>,
<?php endforeach; ?>
                    ]
            }]
    });
    
    
    
            ///grafica de efectividad
            
            
            $('#containerEfectividad').highcharts({
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
               <?php foreach ($Efectividad as $item):?>
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
<?php foreach ($Efectividad as $itemtotal): ?>
   <?php echo $itemtotal['ClientesCanal']; ?>,
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