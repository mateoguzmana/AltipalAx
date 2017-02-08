   <div class="row">
       <div style="overflow: scroll">
                          <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Marcas</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="containerMarcas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                    <div id="mensajeMarca"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td>
                                               
                                                <?php
                                                
                                                  
                                                 $arrayMarcas=array();
                                                 
                                                 foreach ($CategoriaxMarca as $item){
                                                     array_push($arrayMarcas, $item['CodigoGrupoCategoria']);                                                     
                                                 }
                                                 
                                                 $arrayMarcasUni=  array_unique($arrayMarcas);
                                                 
                                                 $arrayTotalMarcas=array();
                                                 
                                                 foreach ($arrayMarcasUni as $marca){
                                                     
                                                     $valor=0;
                                                     $cajas=0;
                                                     foreach ($CategoriaxMarca as $item){
                                                         
                                                         if($marca==$item['CodigoGrupoCategoria']){
                                                            $valor+=$item['TotalPrecioNeto'];
                                                            $cajas+=$item['Cajas'];
                                                         }                                                        
                                                     }                                                     
                                                     array_push($arrayTotalMarcas, array('ValorTotalMarca'=>$valor,'Marca'=>$marca , 'TotalCajasMarca'=>$cajas));                                                   
                                                     
                                                     
                                                     
                                                 }
                                                  
                                                 arsort($arrayTotalMarcas);
                                                $conArrayMarcas=0;
                                                foreach ($arrayTotalMarcas as $itemMarcas){
                                                     if($conArrayMarcas < 10){
                                                ?>
                                                <td class="text-center"><?php echo $itemMarcas['Marca'] ?></td>
                                                     <?php 
                                                     }
                                                     $conArrayMarcas++;
                                               } ?>
                                                
                                            </tr>
                                            <tr>
                                                <td class="text-center">Pesos&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                <?php
                                                $conArrayMarcas=0;
                                                foreach ($arrayTotalMarcas as $itemMarcas){
                                                     if($conArrayMarcas < 10){
                                                ?>
                                                <td class="text-center">$ <?php echo number_format($itemMarcas['ValorTotalMarca'], '2',',','.'); ?></td>   
                                                   <?php 
                                                     }
                                                  $conArrayMarcas++;   
                                                }
                                                     ?>
                                            </tr>
                                            <tr>
                                               <td class="text-center">Cajas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                             <?php
                                             $conArrayMarcas=0;
                                                foreach ($arrayTotalMarcas as $itemMarcas){
                                                     if($conArrayMarcas < 10){
                                                     $CajasMarcas = intval($itemMarcas['TotalCajasMarca'])   ;
                                              ?>  
                                               <td class="text-center"><?php echo $CajasMarcas; ?></td>  
                                               <?php 
                                                     }
                                                 $conArrayMarcas++;    
                                                }     
                                               ?>
                                            </tr>

                                        </table>
                                        <table style="width: 50px; height: 20px; margin: 0 auto;" class="table table-bordered">
                                            <td>
                                                <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span>&nbsp;Pesos

                                            </td>
                                            <td>
                                                <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: #FF8D00"></span>&nbsp;Cajas

                                            </td>
                                        </table>
                                    </div>   
                                </div>
                            </div><!-- panel -->
                        </div><!-- col-sm-6 -->
       </div>
                      
                   </div>


 <script>
    $(document).ready(function(){
        
   $('#mensajeMarca').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');     
  ////GRAFICA DE MARCAS
   var FechaCat =  $('#datepickerVistaLink').val();
    
    $('#containerMarcas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'MARCAS'
            },
            subtitle: {
            text: 'MARCAS ' + FechaCat
            },
            xAxis: {
            categories: [
<?php
$conArrayMarcas=0;
foreach($arrayTotalMarcas as $item): ?>
            <?php if($conArrayMarcas < 10){  ?>        
                '<?php echo $item['Marca']; ?>',
            <?php } ?>           
<?php $conArrayMarcas++; endforeach; ?>
            
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Pesos y Cajas'
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
                    
            }
            },
            series: [{
            name: 'Pesos',
            color: 'blue',
            data: [
            <?php
            $conArrayMarca=0;
            foreach ($arrayTotalMarcas as $itemtotalMarcas):
                if($conArrayMarca < 10){
            ?>
            <?php echo $itemtotalMarcas['ValorTotalMarca']; ?>,
            <?php } $conArrayMarca++; endforeach; ?>
                
            ]

        }, {
            name: 'Cajas',
             color: 'orange',
            data: [
            <?php 
            $conArrayMarca=0;
            foreach ($arrayTotalMarcas as $itemtotalCajasMarcas):
                if($conArrayMarca < 10){
               $CajasMarcas = intval($itemMarcas['TotalCajasMarca'])
            ?>
            <?php echo $CajasMarcas; ?>,
                <?php } $conArrayMarca++; endforeach; ?>
                
            ]
            

        },]
    }); 
    
    
  
   
   
        
        
    });
    
    
    </script>                     
