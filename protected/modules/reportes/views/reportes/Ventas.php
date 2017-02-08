<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span>Ventas</h2>      
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

                <h3 style="text-align: center">Reportes/Ventas</h3>
                    <br>
                            <br>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div>
                                    <select id="selectchosenagencia" name="Agencia" class="form-control chosen-select  onchagegrupos  GenrarRepoteAgencia" data-placeholder="Seleccione una agencia">
                                        <option value=""></option>
                                        <?php
                                   
                                        foreach ($AgenciasVentas as $itemaAgen) {
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
                                    <input style="height: 36px;" type="text"  class="form-control GenrarRepotFecha"  id="datepicker" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                        
                      <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Canal</label>
                                <div>
                                    <select id="selectchosencanal" name="Canal" class="form-control chosen-select  GenrarRepoteCanal" data-placeholder="Seleccione un canal">
                                         <option value=""></option>
                                        <?php
                                        $canal = ReporteVentas::model()->getCanales();

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
                                <div id="zonasventas" class="onchangereportzonaventas onchangeproveedores">
                                    <select id="selectchosezonaventas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta">
                                        <option value=""></option>


                                    </select>
                                </div>
                            </div>   
                        </div>
                        
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Proveedor</label>
                                <div id="proveedor" class="GenrarRepoteProveedor">
                                    <select id="selectchoseproveedor" name="proveedor" class="form-control chosen-select" data-placeholder="Seleccione un proveedor">
                                        <option value=""></option>


                                    </select>
                                </div>
                            </div>   
                        </div>


                    </div>
                    
                    
                    <div id="cargando" style="display: none">
                     <h3>Cargando... <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;"></h3></div>

                    <div id="graf">

                        <div class="row">
                            <div style="overflow: scroll">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Top 10 Clientes</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containerventas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1500px  ! important;">
                                                <tr>
                                                    <td></td>
                                                    <?php
                                                    arsort($compradores);
                                                    $contCompradores=0;
                                                    foreach ($compradores as $ItemTotales) {
                                                        
                                                        if($contCompradores < 10){
                                                        ?>
                                                        <td class="text-center"><?php echo $ItemTotales['NombreCliente'] ?></td>
                                                        <?php
                                                        }
                                                      $contCompradores++;  
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Precio&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                    <?php
                                                    arsort($compradores);
                                                    $contCompradores=0;
                                                    foreach ($compradores as $ItemTotales) {
                                                        
                                                       if($contCompradores < 10){
                                                        ?>
                                                    <td class="text-center">$ <?php echo number_format($ItemTotales['totalpedidos'],'2', ',', '.') ?></td>
                                                        <?php
                                                        }
                                                       $contCompradores++; 
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
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Top 10 Productos Vendidos</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containerventasproductos" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1000px  ! important;">
                                                <tr>
                                                    <td class="text-center">Productos Vendidos&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                                    <?php
                                                  arsort($productosvendidos);  
                                                 $cont = 0;
                                                 foreach ($productosvendidos as $ItemTotales) {
                                                        
                                                        if($cont < 10)
                                                        {
                                                        ?>
                                                        <td class="text-center"><?php echo $ItemTotales['NombreArticulo'] ?></td>
                                                        <?php
                                                        }
                                                        $cont++;
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Pesos&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                                    <?php
                                                    arsort($productosvendidos); 
                                                    $cont = 0;
                                                    foreach ($productosvendidos as $ItemTotales) {
                                                        if($cont < 10)
                                                        {
                                                        ?>
                                                    <td class="text-center">$ <?php echo number_format($ItemTotales['totalcantidapedido'],'2', ',', '.') ?></td>
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
                        </div>
                        <div class="row">
                            <div style="overflow: scroll">
                            <div class="col-sm-12">
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Top Ventas x Proveedor</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containerventasproveedor" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1000px;">
                                                <tr>
                                                     <td class="text-center">Ventas x Proveedor&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span></td>
                                                    <?php
                                                 
                                                   $arrayContenedor = array();
                                                   $anteriorProvedor = "";
                                                   $valor = 0;
                                                   $cont = 0;
                                                   arsort($ventasproveedor);
                                                   foreach($ventasproveedor as $row)
                                                   {
                                                       if($row['NombreCuentaProveedor'] != $anteriorProvedor)
                                                       {
                                                           if($cont > 0)
                                                           {
                                                               $provi = array(
                                                                   "total_ventas_porveedor"=>$valor,
                                                                   "NombreCuentaProveedor"=>$anteriorProvedor);
                                                               
                                                               array_push($arrayContenedor, $provi);
                                                               $valor = 0;
                                                           }
                                                       }
                                                       
                                                       $valor = $valor + $row['total_ventas_porveedor'];
                                                       $anteriorProvedor = $row['NombreCuentaProveedor'];
                                                       $cont ++;
                                                   } 
                                                   arsort($arrayContenedor);
                                                    
                                                    $contVentaProve=0;
                                                    foreach ($arrayContenedor as $ItemTotales) {
                                                        
                                                       
                                                    if($contVentaProve < 10){
                                                        ?>
                                                   
                                                        <td class="text-center"><?php echo $ItemTotales['NombreCuentaProveedor'] ?></td>
                                                        <?php
                                                        }
                                                       $contVentaProve++; 
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Pesos&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span></td>
                                                    <?php
                                                   $arrayContenedorPrecio = array();
                                                   $anteriorProvedorPrecio = "";
                                                   $valorProvePrecio = 0;
                                                   $cont = 0;
                                                    arsort($ventasproveedor);
                                                   foreach($ventasproveedor as $row)
                                                   {
                                                       if($row['NombreCuentaProveedor'] != $anteriorProvedorPrecio)
                                                       {
                                                           if($cont > 0)
                                                           {
                                                               $provi = array("total_ventas_porveedor"=>$valorProvePrecio,"NombreCuentaProveedor"=>$anteriorProvedorPrecio,);
                                                               
                                                               array_push($arrayContenedorPrecio, $provi);
                                                               $valorProvePrecio = 0;
                                                           }
                                                       }
                                                       
                                                       $valorProvePrecio = $valorProvePrecio + $row['total_ventas_porveedor'];
                                                       $anteriorProvedorPrecio = $row['NombreCuentaProveedor'];
                                                       $cont ++;
                                                   }
                                                    
                                                    arsort($arrayContenedorPrecio);
                                                    $contVentasProvee=0;
                                                    foreach ($arrayContenedorPrecio as $ItemTotales) {
                                                        if($contVentasProvee < 10){
                                                        ?>
                                                    <td class="text-center">$ <?php echo number_format($ItemTotales['total_ventas_porveedor'],'2', ',', '.') ?></td>
                                                        <?php
                                                        }
                                                        $contVentasProvee++;
                                                    }
                                                    ?>
                                                </tr>
                                            </table>
                                            <table style="width: 151px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                                                <td>
                                                    <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Ventas x Proveedor

                                                </td>
                                            </table>
                                           
                                        </div>
                                         <a href="index.php?r=reportes/Reportes/Vistalink">Ventas</a>
                                    </div>
                                </div><!-- panel -->
                            </div><!-- col-sm-6 -->

                            </div>
                        </div><!-- row -->

                    </div>

                </div>
            </div>



        </div>
    </div>      



</div>

<?php $this->renderPartial('//mensajes/_alertCargando');?> 


<script>

    $(document).ready(function(){

//    $(function() {
//    $("#datepicker").datepicker();
//    });
            $("#selectchosegrupventas").chosen();
            $("#selectchosezonaventas").chosen();
            $("#selectchoseproveedor").chosen();
            /////Grafica compradores////
             var Fecha = $('#datepicker').val();

            $('#containerventas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top 10 Clientes'
            },
            subtitle: {
            text: 'Clientes ' + Fecha
            },
            xAxis: {
            categories: [
<?php  arsort($compradores);  $contCompradores=0; foreach($compradores as $item): ?>
                    <?php if ($contCompradores < 10){ ?>
                '<?php echo $item['NombreCliente']; ?>',
                        <?php } ?>
<?php $contCompradores++; endforeach; ?>
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
                    color: 'blue',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php 
$cont = 0;
foreach ($compradores as $itemtotal): 
    if($cont < 10)
    {
    ?> 
    <?php echo $itemtotal['totalpedidos']; ?>,
<?php
$cont ++;
    }endforeach; ?>
                    ]

            }, ]
    });
    
            
            ////Grafica productos mas vendedios///
            
             $('#containerventasproductos').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top 10 Productos Vendidos'
            },
            subtitle: {
            text: 'Productos Vendidos ' + Fecha
            },
            xAxis: {
            categories: [
 <?php  arsort($productosvendidos);  $contProVendidos=0; foreach($productosvendidos as $item): ?>
                    <?php if ($contProVendidos < 10){ ?>
                '<?php echo $item['NombreArticulo']; ?>',
                    <?php } ?>
<?php $contProVendidos++; endforeach; ?> 
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
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php 
$contProVendidos=0;
foreach ($productosvendidos as $itemtotal):
    if($contProVendidos < 10)
    {
    ?>

    <?php echo $itemtotal['totalcantidapedido']; ?>,
    <?php $contProVendidos++; } endforeach; ?>
                    ]

            }, ]
    });
    
            //////Grafica ventas proveedor/////
   
    
     $('#containerventasproveedor').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top Ventas x Proveedor'
            },
            subtitle: {
            text: 'Ventas x Proveedor ' + Fecha
            },
            xAxis: {
            categories: [
<?php  
$arrayContenedorPrecio = array();
                                                   $anteriorProvedorPrecio = "";
                                                   $valorProvePrecio = 0;
                                                   $cont = 0;
                                                    arsort($ventasproveedor);
                                                   foreach($ventasproveedor as $row)
                                                   {
                                                       if($row['NombreCuentaProveedor'] != $anteriorProvedorPrecio)
                                                       {
                                                           if($cont > 0)
                                                           {
                                                               $provi = array("total_ventas_porveedor"=>$valorProvePrecio,"NombreCuentaProveedor"=>$anteriorProvedorPrecio,);
                                                               
                                                               array_push($arrayContenedorPrecio, $provi);
                                                               $valorProvePrecio = 0;
                                                           }
                                                       }
                                                       
                                                       $valorProvePrecio = $valorProvePrecio + $row['total_ventas_porveedor'];
                                                       $anteriorProvedorPrecio = $row['NombreCuentaProveedor'];
                                                       $cont ++;
                                                   }
                                                    
                                                    arsort($arrayContenedorPrecio);


$contVentasProvee=0; foreach($arrayContenedorPrecio as $item): ?>
                    <?php if ($contVentasProvee < 10){ ?>
                '<?php echo $item['NombreCuentaProveedor']; ?>',
                    <?php } ?>
<?php $contVentasProvee++; endforeach; ?> 
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
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php 
$arrayContenedorPrecio = array();
                                                   $anteriorProvedorPrecio = "";
                                                   $valorProvePrecio = 0;
                                                   $cont = 0;
                                                    arsort($ventasproveedor);
                                                   foreach($ventasproveedor as $row)
                                                   {
                                                       if($row['NombreCuentaProveedor'] != $anteriorProvedorPrecio)
                                                       {
                                                           if($cont > 0)
                                                           {
                                                               $provi = array("total_ventas_porveedor"=>$valorProvePrecio,"NombreCuentaProveedor"=>$anteriorProvedorPrecio,);
                                                               
                                                               array_push($arrayContenedorPrecio, $provi);
                                                               $valorProvePrecio = 0;
                                                           }
                                                       }
                                                       
                                                       $valorProvePrecio = $valorProvePrecio + $row['total_ventas_porveedor'];
                                                       $anteriorProvedorPrecio = $row['NombreCuentaProveedor'];
                                                       $cont ++;
                                                   }
                                                    
                                                    arsort($arrayContenedorPrecio);



$ContVentasProvee=0;
arsort($arrayContenedorPrecio);
foreach ($arrayContenedorPrecio as $itemtotal):
    if($ContVentasProvee < 10){
    ?>

    <?php echo $itemtotal['total_ventas_porveedor']; ?>,
    <?php $ContVentasProvee++; } endforeach; ?>
                    ]

            }, ]
    });
    
    
            })

</script>

<style>
    .col-md-6{
        margin-bottom: 20px;
    }
    .col-md-4{
        margin-bottom: 20px;
    }
</style>

