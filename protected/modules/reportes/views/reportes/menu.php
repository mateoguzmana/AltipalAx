<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Menu">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>
        Reportes<span></span></h2>      
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
        <div class="panel-body">
  <?php
   $Contador = 1;
    $canales = Consultas::model()->getCanales();
    foreach ($canales as $canal) :
        $indicadoresVentas = Consultas::model()->getPresupuestoCanal($canal['NombreCanal']);
        if( count($canal['NombreCanal']) < 5){
                   $Responsive = "col-md-6";
        }
        else{
            $Responsive = "col-md-4";
        }
        foreach ($indicadoresVentas as $itemIndicadores):

            if($itemIndicadores['pesos'] != "" && $itemIndicadores['cuotapesos'] != ""):


                $Division  = $itemIndicadores['pesos'] / $itemIndicadores['cuotapesos'];
               $porcetaje = $Division * 100;

                $bajo = $itemIndicadores['cuotapesos']*0.64;
                $medio = $itemIndicadores['cuotapesos']*0.99;
                $alto = $itemIndicadores['cuotapesos']*1.10;
                ?>
                  

                    <div class="<?php echo $Responsive ?>">
                        <div id="containerGraficaIndex<?php echo $Contador ?>" style="width: 100%; border-radius: 10px;"></div>
                    </div>
<?php 
$color = "";
$Estado = "";

   if($porcetaje > '99') { 
       $color = "color: green";
       $Estado = "( Bien )";
    } elseif ($porcetaje > '64' && $porcetaje < '95') { 
       $color = "color: orange";
       $Estado = "( Regular )";
     } elseif ($porcetaje > '0' && $porcetaje < '64') { 
       $color = "color: red";
       $Estado = "( Mal )";
    }
?>    
            
<script>
    
    $(document).ready(function() {
    $('#containerGraficaIndex<?php echo $Contador ?>').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $itemIndicadores['NombreCanal'] ?>'
        },
        subtitle: {
            text: 'Porcentaje: <h1 style="<?php echo $color ?>; font-weight: 300"> <?php echo  round($porcetaje) ?>% </h1> <?php echo  $Estado ?>'
        },
         plotOptions: {
            column: {
                grouping: false,
                shadow: false,
                borderWidth: 0
            }
        },
        xAxis: {
            categories: [
                'Valores'
            ]
        },
        yAxis: [{
            min: 0,
            title: {
                text: 'Objetivo'
            },
            plotBands: [{ // Bajo
                from: 0,
                to: <?php echo $bajo ?>,
                color: 'rgba(255,0,0, .5)'
            },
                { // Medio
                    from: <?php echo  $bajo ?>,
                    to: <?php echo  $medio ?>,
                    color: 'rgba(240,173,78, 1)'
                },
                { // Alto
                    from: <?php echo  $medio ?>,
                    to: <?php echo  $alto ?>,
                    color: 'rgba(0,255,0, .3)'
                }],
            tooltip: {
                shared: true
            }
        }],
        series: [{
                    name: 'Pesos',
                    data:[<?php echo $itemIndicadores['pesos']; ?> ],
                    color: 'rgba(165,170,217,1)',
                    pointPadding: 0.3,
                    pointPlacement: -0.2
            },
            {
                    name: 'Objetivo',
                    data:[<?php echo (int)$itemIndicadores['cuotapesos'] ?>],
                    color: 'rgba(126,86,134,.9)',
                    pointPadding: 0.4,
                    pointPlacement: -0.2

            }
        ]
    });
    
    });
</script>

<?php endif; endforeach;
  $Contador = $Contador + 1;
    endforeach; ?> 
    
      </div>
    </div>
</div>

<style>
    .col-md-6{
        margin-bottom: 20px;
    }
    .col-md-4{
        margin-bottom: 20px;
    }
</style>



