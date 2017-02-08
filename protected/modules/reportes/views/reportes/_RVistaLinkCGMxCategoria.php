

                       <div class="row">
                           <div style="overflow: scroll">
                         <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Categoria</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="containerCategoria" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                    <div id="mensajeCategoria"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td>
                                             <?php 
                                                $arrayCategoria = array();
                                                $categoriaGrupoAnterior = "";
                                                $valorCategoria = 0;
                                                $contadorCategoria = 0;
                                                
                                                $total = 0;
                                                $cont = 0;
                                                arsort($CategoriaxCategoria);
                                                for($i=0;$i<count($CategoriaxCategoria);$i++){
                                                    if($CategoriaxCategoria[$i]['CodigoGrupoCategoria']==$CategoriaxCategoria[$i+1]['CodigoGrupoCategoria']){
                                                        if($total==0){
                                                            $total=$CategoriaxCategoria[$i]['TotalPrecioNeto'];
                                                        }
                                                        $total +=$CategoriaxCategoria[$i+1]['TotalPrecioNeto'];
                                                        $nombre = $CategoriaxCategoria[$i]['CodigoGrupoCategoria'];
                                                        $arrayCategoria[$cont] = array('ValorTotalCategoria'=>$total,'GrupoCategoria'=>$nombre);
                                                    }else{
                                                        $cont++;
                                                        $total = 0;
                                                    }
                                                }
                                              
                                                arsort($arrayCategoria);
                                                $ConCate=0;
                                                foreach ($arrayCategoria as $itemCa){
                                                    if($ConCate < 10){
                                                ?>    
                                                <td class="text-center"><?php echo $itemCa['GrupoCategoria'] ?></td>
                                                <?php
                                                    }
                                                $ConCate++;    
                                                } ?>
                                            </tr>
                                            <tr>
                                                
                                                <td class="text-center" nowrap="nowrap">Pesos&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                <?php 
                                                $arrayCategoria = array();
                                                $categoriaGrupoAnterior = "";
                                                $valorCategoria = 0;
                                                $contadorCategoria = 0;
                                                
                                                $total = 0;
                                                $cont = 0;
                                                arsort($CategoriaxCategoria);
                                                for($i=0;$i<count($CategoriaxCategoria);$i++){
                                                    if($CategoriaxCategoria[$i]['CodigoGrupoCategoria']==$CategoriaxCategoria[$i+1]['CodigoGrupoCategoria']){
                                                        if($total==0){
                                                            $total=$CategoriaxCategoria[$i]['TotalPrecioNeto'];
                                                        }
                                                        $total +=$CategoriaxCategoria[$i+1]['TotalPrecioNeto'];
                                                        $nombre = $CategoriaxCategoria[$i]['CodigoGrupoCategoria'];
                                                        $arrayCategoria[$cont] = array('ValorTotalCategoria'=>$total,'GrupoCategoria'=>$nombre);
                                                    }else{
                                                        $cont++;
                                                        $total = 0;
                                                    }
                                                }
                                             
                                                arsort($arrayCategoria);
                                                $ConCate=0;
                                                foreach ($arrayCategoria as $itemCa){
                                                    if($ConCate < 10){
                                                ?>
                                                <td class="text-center" nowrap="nowrap">$ <?php echo number_format($itemCa['ValorTotalCategoria'], '2',',','.') ?></td>
                                                    <?php 
                                                       }
                                                  $ConCate++;          
                                                } ?>
                                            </tr>
                                            <tr>
                                               <td class="text-center" nowrap="nowrap">Cajas&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                               <?php 
                                               $arrayCategoriaCajas = array();
                                               $categoriaAnteriorCaja = "";
                                               $totalCategoriaCaja = 0;
                                               $contCategoriaCaja = 0;
                                                    arsort($CategoriaxCategoria);
                                                    foreach ($CategoriaxCategoria as $itemaCategoriacaja){
                                                        
                                                        if($itemaCategoriacaja['CodigoUnidadMedida'] != '001'){
                                                            
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemaCategoriacaja['CodigoArticulo'],$itemaCategoriacaja['CodigoUnidadMedida'],$itemaCategoriacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrarcategoria = $itemaCategoriacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                           
                                                            }
                                                            
                                                            
                                                            
                                                        if($itemaCategoriacaja['CodigoGrupoCategoria'] != $categoriaAnteriorCaja)
                                                            
                                                            {
                                                             if($contCategoriaCaja > 0)
                                                               {
                                                                  $provicionalcajacategoria = array("TotalCajasCategoria"=>$totalCategoriaCaja,"GrupoCategoria"=>$categoriaAnteriorCaja,);

                                                                   array_push($arrayCategoriaCajas, $provicionalcajacategoria);
                                                                   $valorProve = 0;
                                                               }
                                                            }
                                                          $totalCategoriaCaja = $totalCategoriaCaja + $cajasamostrarcategoria;
                                                          $categoriaAnteriorCaja = $itemaCategoriacaja['CodigoGrupoCategoria'];
                                                          $contCategoriaCaja ++;
                                                        }
                                                        
                                                    }
                                                    arsort($arrayCategoriaCajas);
                                                    
                                                    foreach ($arrayCategoria as $key=>$item){
                                                        
                                                        foreach ($arrayCategoriaCajas as $keySubItem=>$subItem){
                                                            
                                                            if($item['GrupoCategoria']==$subItem['GrupoCategoria']){
                                                                 $arrayCategoria[$key]['Cajas']=$subItem['TotalCajasCategoria'];
                                                            }                                                            
                                                        }
                                                        
                                                    }
                                               
                                                $contArrayCate=0; 
                                                foreach ($arrayCategoria as $item){
                                                    $cajas=intval($item['Cajas']);
                                                    if($contArrayCate < 10){
                                               ?> 
                                               <td class="text-center"> <?php echo $cajas; ?></td>
                                                <?php 
                                                    }
                                                 $contArrayCate++;   
                                                }?>
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
                      
                    <div class="row">
                          <div style="overflow: scroll">
                      <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-btns">
                                        <a href="#" class="minimize">&minus;</a>
                                    </div><!-- panel-btns -->
                                    <h3 class="panel-title">Grupos</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="containerGrupos" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                    <div id="mensajeGrupo"></div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td>
                                                <?php
                                                    foreach ($arrayCategoria as $key=>$item){
                                                        
                                                        $Grupos = ReporteVistaLink::model()->getGrupos($item['GrupoCategoria']);
                                                        foreach ($Grupos as $keySubItem=>$subItem){
                                                            if($item['GrupoCategoria']==$subItem['Nombre']){
                                                                 $arrayCategoria[$key]['Agrupo']=$subItem['IdPrincipal'];
                                                                 ksort($arrayCategoria[$key]);
                                                            }                                                            
                                                        }
                                                        
                                                     }
                                                    
                                                     $arrayGrupo = array();
                                                     foreach ($arrayCategoria as $itemGrupo){
                                                         
                                                         if($itemGrupo['Agrupo'] == $itemGrupo['Agrupo']){
                                                             
                                                             $ValorTotalGrupo+=$itemGrupo['ValorTotalCategoria'];
                                                             $cajas+=$itemGrupo['Cajas'];
                                                             
                                                         }
                                                         
                                                       array_push($arrayGrupo, array('ValorTotalGrupo'=>$ValorTotalGrupo,'Grupo'=>$itemGrupo['Agrupo'] , 'TotalCajasGrupo'=>$cajas));                                                     
                                                     } 
                                               
                                                $conArrayGrupo=0;
                                                foreach ($arrayGrupo as $itemGrupo){
                                                    if($conArrayGrupo < 10){
                                                ?>    
                                                <td class="text-center"><?php echo $itemGrupo['Grupo'] ?></td>
                                                <?php
                                                    }
                                                $conArrayGrupo++;    
                                                 } 
                                                ?>
                                                
                                            </tr>    
                                            
                                            <tr>
                                                <td class="text-center">Pesos&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                
                                                <?php
                                                $conArrayGrupo=0;
                                                 foreach ($arrayGrupo as $itemGrupo){
                                                     if($conArrayGrupo < 10){
                                                ?>    
                                                <td class="text-center" nowrap="nowrap">$ <?php echo number_format($itemGrupo['ValorTotalGrupo'], '2',',','.'); ?></td>
                                                <?php
                                                  }
                                                $conArrayGrupo++;
                                                 } 
                                                ?> 
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cajas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                               
                                               <?php 
                                               $conArrayGrupo=0;
                                                foreach ($arrayGrupo as $itemGrupo){
                                                     $cajas=intval($itemGrupo['TotalCajasGrupo']);
                                                     if($conArrayGrupo < 10){
                                                ?>    
                                                <td class="text-center"><?php echo $cajas ?></td>
                                                <?php
                                                  }
                                                $conArrayGrupo++;
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
                                                
                                                foreach ($arrayCategoria as $key=>$item){
                                                        
                                                        $Marcas= ReporteVistaLink::model()->getMarcas($item['GrupoCategoria']);
                                                        foreach ($Marcas as $keySubItem=>$subItem){
                                                            
                                                                 $arrayCategoria[$key]['Marca']=$subItem['CodigoMarca'];
                                                                 ksort($arrayCategoria[$key]);
                                                        }
                                                        
                                                     }
                                                
                                                  
                                                 $arrayMarcas=array();
                                                 
                                                 foreach ($arrayCategoria as $item){
                                                     array_push($arrayMarcas, $item['Marca']);                                                     
                                                 }
                                                 
                                                 $arrayMarcasUni=  array_unique($arrayMarcas);
                                                 
                                                 $arrayTotalMarcas=array();
                                                 
                                                 foreach ($arrayMarcasUni as $marca){
                                                     
                                                     $valor=0;
                                                     $cajas=0;
                                                     foreach ($arrayCategoria as $item){
                                                         
                                                         if($marca==$item['Marca']){
                                                            $valor+=$item['ValorTotalCategoria'];
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
        
    $('#mensajeCategoria').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');   
    $('#mensajeGrupo').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');   
    $('#mensajeMarca').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');        
   /////////GRAFICA CATEGORIA////////
   var FechaCat =  $('#datepickerVistaLink').val();
   
     $('#containerCategoria').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Categorias'
            },
            subtitle: {
            text: 'Categoria ' + FechaCat
            },
            xAxis: {
            categories: [
<?php  
$contArrayCategoria=0; foreach($arrayCategoria as $item): ?>
                    <?php if ($contArrayCategoria < 10){ ?>
                '<?php echo $item['GrupoCategoria']; ?>',
                   <?php } ?>
                 
<?php $contArrayCategoria++; endforeach; ?>
            
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
            $contArrayCategoria=0;    
            foreach ($arrayCategoria as $itemtotalCategoria):
                if($contArrayCategoria < 10){
            ?>

            <?php echo $itemtotalCategoria['ValorTotalCategoria']; ?>,
            <?php $contArrayCategoria++; } endforeach; ?>
                
            ]

        }, {
            name: 'Cajas',
             color: 'orange',
            data: [
            <?php 
            $contArrayCategoria=0;    
            foreach ($arrayCategoria as $itemtotalCategoria):
                $caja=intval($itemtotalCategoria['Cajas']); 
                 if($contArrayCategoria < 10){
            ?>

            <?php echo $caja; ?>,
            <?php $contArrayCategoria++; } endforeach; ?>
                
            ]
            

        },]
    }); 
    
    
   ///////GRAFICA GRUPO ////
   
     $('#containerGrupos').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'GRUPOS'
            },
            subtitle: {
            text: 'GRUPO ' + FechaCat
            },
            xAxis: {
            categories: [
<?php
$conArrayGrupo=0;
foreach($arrayGrupo as $item): ?>
            <?php if($conArrayGrupo < 10){  ?>        
                '<?php echo $item['Grupo']; ?>',
            <?php } ?>           
<?php $conArrayGrupo++; endforeach; ?>
            
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
            $conArrayGrupo=0;
            foreach ($arrayGrupo as $itemtotalGrupo):
                if($conArrayGrupo < 10){
            ?>
            <?php echo $itemtotalGrupo['ValorTotalGrupo']; ?>,
            <?php } $conArrayGrupo++; endforeach; ?>
                
            ]

        }, {
            name: 'Cajas',
             color: 'orange',
            data: [
            <?php 
            $conArrayGrupo=0;
            foreach ($arrayGrupo as $itemtotalCajasGrupo):
                if($conArrayGrupo < 10){
            ?>
            <?php echo $itemtotalCajasGrupo['TotalCajasGrupo']; ?>,
                <?php } $conArrayGrupo++; endforeach; ?>
                
            ]
            

        },]
    }); 
   
   
   ////GRAFICA DE MARCAS
    
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
