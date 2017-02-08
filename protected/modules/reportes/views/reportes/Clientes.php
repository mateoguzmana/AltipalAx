<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
            Reportes<span></span>Clientes</h2>      
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
                    
                    <h3 style="text-align: center">Reportes/Clientes</h3>
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
                                    <input style="height: 36px;" type="text"  class="form-control GenrarRepoteFecha"  id="datepicker" value = "<?php echo date('Y-m-d') ?>"/>
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
                                        $canal = ReporteClientes::model()->getCanales();

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
                                <div id="zonasventas" class="onchangereportzonaventas">
                                    <select id="selectchosezonaventas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta">
                                        <option value=""></option>


                                    </select>
                                </div>
                            </div>   
                        </div>


                    </div>


                    <div id="graf">
                        <br>
                        <input  type="button" value="Exportar Excel" class="btn btn-primary">
                        <br><br>
                        <div class="row">
                            <div style="overflow: scroll"> 
                                <div class="col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <div class="panel-btns">
                                                <a href="#" class="minimize">&minus;</a>
                                            </div><!-- panel-btns -->
                                            <h3 class="panel-title">Top 10 Clientes Cartera Vencida</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="containerclientes" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 1500px  ! important;">
                                                    <tr>
                                                        <td></td>
                                                        <?php
                                                        arsort($clientescarteravenciada);
                                                        $contcarteravenciada = 0;
                                                        foreach ($clientescarteravenciada as $ItemTotales) {
                                                            if ($contcarteravenciada < 10) {
                                                                ?>
                                                                <td class="text-center"><?php echo $ItemTotales['NombreCliente'] ?></td>
                                                                <?php
                                                            }
                                                            $contcarteravenciada++;
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center"> Clientes Cartera Vencida&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                                        <?php
                                                        arsort($clientescarteravenciada);
                                                        $contcarteravenciada = 0;
                                                        foreach ($clientescarteravenciada as $ItemTotales) {
                                                            if ($contcarteravenciada < 10) {
                                                                ?>
                                                                <td class="text-center">$ <?php echo number_format($ItemTotales['total_deuda'], '2', ',', '.') ?></td>
                                                                <?php
                                                            }
                                                            $contcarteravenciada++;
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
                                            <h3 class="panel-title">No Ventas</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="containernoventas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 1000px  ! important;">
                                                    <tr>
                                                        <td class="text-center"><b>Motivos</b></td>
                                                        <?php
                                                        foreach ($noventas as $ItemTotales) {
                                                            ?>
                                                            <td class="text-center"><?php echo $ItemTotales['Nombre'] ?></td>
                                                            <?php
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center"><b>Clientes No Ventas</b></td>
                                                        <?php
                                                        foreach ($noventas as $ItemTotales) {
                                                            ?>
                                                            <td class="text-center"><?php echo $ItemTotales['total_clientes_noventas'] ?></td>
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
                                            <h3 class="panel-title">Notas Creditos</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="containernotascreditos" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="width: 1000px;">

                                                    <?php
                                                    foreach ($notascredito as $ItemTotales) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $ItemTotales['NombreConceptoNotaCredito'] ?></td>
                                                            <td class="text-center"><?php echo number_format($ItemTotales['total_notascredito'], '2', ',', '.') ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>

                                                </table>
                                                <table style="width: 151px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                                                    <td>
                                                        <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Notas Credito

                                                    </td>
                                                </table>

                                            </div>

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


<script>

    $(document).ready(function(){


    $('#containerclientes').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Top 10 Clientes Cartera Vencida'
            },
            subtitle: {
            text: 'Clientes'
            },
            xAxis: {
            categories: [

<?php
arsort($clientescarteravenciada);
$contcarteravenciada = 0;
foreach ($clientescarteravenciada as $item):
    if ($contcarteravenciada < 10) {
        ?>
                    '<?php echo $item['NombreCliente']; ?>',
    <?php
    } $contcarteravenciada++;
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
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php
arsort($clientescarteravenciada);
$contcarteravenciada = 0;
foreach ($clientescarteravenciada as $itemtotal):
    if ($contcarteravenciada < 10) {
        ?>

        <?php echo $itemtotal['total_deuda']; ?>,
    <?php
    } $contcarteravenciada++;
endforeach;
?>
                    ]

            }, ]
    });
            ////Grafica no ventas///


            $('#containernoventas').highcharts({
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
<?php foreach ($noventas as $itemtotal): ?>
                        ['<?php echo $itemtotal['Nombre'] ?>', <?php echo $itemtotal['total_clientes_noventas'] ?>],
<?php endforeach; ?>

                    ]
            }]
    });
            //////Grafica  notas credito /////

            $('#containernotascreditos').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Notas Credito'
            },
            subtitle: {
            text: 'notas credito'
            },
            xAxis: {
            categories: [
<?php foreach ($notascredito as $item): ?>
                '<?php echo $item['NombreConceptoNotaCredito']; ?>',
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
                    color: 'orange',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($notascredito as $itemtotal): ?>

    <?php echo $itemtotal['total_notascredito']; ?>,
<?php endforeach; ?>
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

