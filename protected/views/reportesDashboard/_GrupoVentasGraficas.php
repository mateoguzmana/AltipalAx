
<div class="contentpanel">



    <div class="panel-heading">


        <div class="widget widget-blue">


            <div class="widget-content">

                <div class="row">
                    <div style="overflow: scroll">
                    <div class="col-sm-12">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <div class="panel-btns">
                                    <a href="#" class="minimize">&minus;</a>
                                </div><!-- panel-btns -->
                                <h3 class="panel-title">Valor de Notas Aprobadas Grupos Ventas</h3>
                            </div>
                            <div class="panel-body">
                                <div id="ContainerNotasAprobadas" style="position:relative; min-width:200px;  width: 5500px; height: 1000px;"></div>
                            </div>
                        </div><!-- panel -->
                    </div><!-- col-sm-6 -->
                    </div>
                </div>
                <input type="button" value="Ver Detalle" class="btn btn-success verTabla">
            </div>
        </div>
    </div>


</div>


<div class="modal fade" id="Information" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detalle</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered" id="informacion">
                        <thead>
                        <th class="text-center">Código</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Valor</th>
                        </thead>
                        <tbody>
                            <?php foreach ($NotasAprobasGrupoVentas as $item): 
                                
                                 if($itemtotal['ValorNotasGrupo'] !="" || $item['NombreGrupos'] !=""):
                                ?> 
                                <tr>
                                    <td class="text-center"><?php echo $item['CodigoGrupos']; ?></td>
                                    <td class="text-center"><?php echo $item['NombreGrupos']; ?></td>
                                    <td class="text-center"><?php echo number_format($item['ValorNotasGrupo'], '2', ',', '.'); ?></td>
                                </tr>
                            <?php endif; endforeach; ?> 
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>


<script>

  
    $('#ContainerNotasAprobadas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Valor Notas Aprobadas Grupo Ventas'
            },
            subtitle: {
            text: 'Valor Notas Aprobadas Grupo Ventas'
            },
            xAxis: {
            categories: [
<?php foreach ($NotasAprobasGrupoVentas as $item): if($itemtotal['ValorNotasGrupo'] !="" || $item['NombreGrupos'] !=""):?>
                '<?php echo $item['CodigoGrupos']; ?>',
<?php endif; endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Valor',
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
<?php foreach ($NotasAprobasGrupoVentas as $itemtotal): if($itemtotal['ValorNotasGrupo'] !="" || $item['NombreGrupos'] !=""): ?>
    <?php echo $itemtotal['ValorNotasGrupo']; ?>,
<?php endif; endforeach; ?>
                    ]

            }]
    });
    
  

</script>    