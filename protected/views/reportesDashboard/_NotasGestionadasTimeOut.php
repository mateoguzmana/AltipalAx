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
                                    <h3 class="panel-title">Notas Gestionadas Cartera</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="ContainerNotasGestionadasTimeOut" style="position:relative; min-width:200px; max-width:1000px; width: 100%;"></div>
                                   
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
                    </div>
                    
                </div>
            </div>
         </div>
            
      
   </div>  


<script>


  $('#ContainerNotasGestionadasTimeOut').highcharts({
    chart: {
    type: 'pie',
            options3d: {
            enabled: true,
                    alpha: 45,
                    beta: 0
            }
    },
            title: {
            text: 'Notas Credito Gestionadas Cartera'
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
            name: "Notas",
            colorByPoint: true,
            data: [{
                name: "Aprobadas",
                y: <?php echo $NotasGestinadas['Aprobadas']; ?>
            }, {
                name: "Rechzadas",
                y: <?php echo $NotasGestinadas['Rechazadas']; ?>
            }]
        }]
    });


</script>