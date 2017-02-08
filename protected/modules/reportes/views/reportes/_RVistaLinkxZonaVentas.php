  <div class="row">
      <div style="overflow: scroll">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Detalle Pesos</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containervistalinkventasvendedorxzona" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1500px  ! important;">
                                                <tr>
                                                    <td></td>
                                                    <?php
                                                    foreach ($reporteventasprovedorxZonaVentas as $ItemTotales) {
                                                        ?>
                                                        <td class="text-center"><?php echo $ItemTotales['NombreCuentaProveedor'] ?></td>
                                                        <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Detalle Pesos&nbsp;<span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                    <?php
                                                    foreach ($reporteventasprovedorxZonaVentas as $ItemTotales) {
                                                        ?>
                                                    <td class="text-center">$ <?php echo number_format($ItemTotales['total_ventas_porveedor'],'2', ',', '.') ?></td>
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
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <div class="panel-btns">
                                            <a href="#" class="minimize">&minus;</a>
                                        </div><!-- panel-btns -->
                                        <h3 class="panel-title">Detalle Cajas</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containercajasxazona" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 1000px  ! important;">
                                                <tr>
                                                    <td></td>
                                                    <?php
                                                   $arrayContenedorCajasZonaVentas= array();
                                                   $anteriorProvedorCaja = "";
                                                   $valorProve = 0;
                                                   $contcajas = 0;
                                                   arsort($reportecajaxZonaVentas);
                                                   
                                                    foreach ($reportecajaxZonaVentas as $itemacaja){
                                                         //$contcajas ++;
                                                        if($itemacaja['CodigoUnidadMedida'] != '001'){
                                                           
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemacaja['CodigoArticulo'],$itemacaja['CodigoUnidadMedida'],$itemacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrar = $itemacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                          
                                                            }
                                                            
                                                              
                                                           if($itemacaja['NombreCuentaProveedor'] != $anteriorProvedorCaja)
                                                             
                                                            {
                                                             if($contcajas > 0)
                                                                 
                                                               {
                                                                  $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                                    
                                                                   array_push($arrayContenedorCajasZonaVentas, $provisional);
                                                                   $valorProve = 0;
                                                                  
                                                               }
                                                            }
                                                          $valorProve = $valorProve + $cajasamostrar;
                                                          $anteriorProvedorCaja = $itemacaja['NombreCuentaProveedor'];
                                                          $contcajas ++;
                                                        }
                                                      }
                                                   
                                                    //el entra a esta linea de codigo si es solo un proveedor  
                                                    $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                    array_push($arrayContenedorCajasZonaVentas, $provisional); 
                                                      
                                                    arsort($arrayContenedorCajasZonaVentas);
                                                    $contArray=0;
                                                    
                                                    foreach ($arrayContenedorCajasZonaVentas as $ItemTotales) {
                                                          if($contArray < 12){
                                                        ?>
                                                        <td class="text-center"><?php echo $ItemTotales['NombreCuentaProveedor'] ?></td>
                                                        <?php
                                                          }
                                                     $contArray++;     
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <?php
                                                   $arrayContenedorCajasZonaVentas= array();
                                                   $anteriorProvedorCaja = "";
                                                   $valorProve = 0;
                                                   $contcajas = 0;
                                                   arsort($reportecajaxZonaVentas);
                                                   
                                                    foreach ($reportecajaxZonaVentas as $itemacaja){
                                                         //$contcajas ++;
                                                        if($itemacaja['CodigoUnidadMedida'] != '001'){
                                                           
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemacaja['CodigoArticulo'],$itemacaja['CodigoUnidadMedida'],$itemacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrar = $itemacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                          
                                                            }
                                                            
                                                              
                                                           if($itemacaja['NombreCuentaProveedor'] != $anteriorProvedorCaja)
                                                             
                                                            {
                                                             if($contcajas > 0)
                                                                 
                                                               {
                                                                  $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                                    
                                                                   array_push($arrayContenedorCajasZonaVentas, $provisional);
                                                                   $valorProve = 0;
                                                                  
                                                               }
                                                            }
                                                          $valorProve = $valorProve + $cajasamostrar;
                                                          $anteriorProvedorCaja = $itemacaja['NombreCuentaProveedor'];
                                                          $contcajas ++;
                                                        }
                                                      }
                                                    
                                                      //el entra a esta linea de codigo si es solo un proveedor  
                                                    $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                    array_push($arrayContenedorCajasZonaVentas, $provisional); 
                                                      
                                                      
                                                    arsort($arrayContenedorCajasZonaVentas);
                                                    $contArray=0;
                                                    foreach ($arrayContenedorCajasZonaVentas as $ItemTotales) {
                                                         $totalcajaszonaventas = intval($ItemTotales['total_ventas_porveedor_caja']);
                                                        if($contArray < 12){
                                                        ?>
                                                    <td class="text-center"><?php echo $totalcajaszonaventas; ?></td>
                                                        <?php
                                                       }
                                                     $contArray++;  
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

     <!--AQUI SE EMPIESA LAS GRAFICAS DE CATEGORIAS GRUPOS Y MARCAS-->
                        
                        <!--$('elemento').on('evento', 'elemento hijo', callback);-->
                        
                   <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div>
                                    <select id="selectAgencia" name="Agencia" class="form-control chosen-select GenerarReporteCGMxAgencia" data-placeholder="Seleccione una agencia">
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
                                    <input style="height: 36px;" type="text"  class="form-control GenerarReporteCGMxFecha"  id="datepickerVistaLink" value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                       <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Poveedores</label>
                                <div>
                                    <select id="selectProveedor" name="Proveedor" class="form-control chosen-select GenerarReporteCGMxProveedor" data-placeholder="Seleccione un proveedor">
                                        <option value=""></option>
                                        <?php
                                   
                                        foreach ($proveedores as $itemaProvee) {
                                            ?> 
                                            <option value="<?php echo $itemaProvee['CodigoCuentaProveedor'] ?>"><?php echo $itemaProvee['NombreCuentaProveedor'] ?> <?php echo $itemaProvee['CodigoCuentaProveedor'] ?></option>

                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                       <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Categoria</label>
                                <?php 
                                 $arrayCargarCategoria = array();
                                 $categoriaCargarAnterior = "";
                                 $contadorCargaCategoria = 0;
                                 sort($cargarcategoria);
                                   foreach ($cargarcategoria as $itemacategoria){
                                                    
                                                    if($itemacategoria['CodigoGrupoCategoria'] !=  $categoriaCargarAnterior)
                                                        {
                                                        
                                                        if($contadorCargaCategoria > 0)
                                                            {
                                                            
                                                            $provisionalCargacategoria = array("Categoria"=>$categoriaCargarAnterior);
                                                            array_push($arrayCargarCategoria, $provisionalCargacategoria);
                                                            
                                                            } 
                                                        }
                                                        $categoriaCargarAnterior = $itemacategoria['CodigoGrupoCategoria'];
                                                        $contadorCargaCategoria ++;
                                                    
                                                }
                                ?>
                                <div>
                                    <select id="selectCategoria" name="Categoria" class="form-control chosen-select GenrarReporteCategoriaVentasVistaLink onchangeGruposByMarcas" data-placeholder="Seleccione un proveedor">
                                        <option value=""></option>
                                        <?php
                                        foreach ($arrayCargarCategoria as $itemaCategoria) {
                                            ?> 
                                            <option value="<?php echo $itemaCategoria['Categoria'] ?>"><?php echo $itemaCategoria['Categoria'] ?></option>

                                        <?php }  ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Grupos</label>
                                <div>
                                    <select id="selectGrupos" name="Grupo" class="form-control chosen-select" data-placeholder="Seleccione un grupo">
                                        <option value=""></option>
                                       
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Marcas</label>
                                <div>
                                    <select id="selectMarca" name="Marcas" class="form-control chosen-select GenrarReporteMarcasVentasVistaLink" data-placeholder="Seleccione una marca">
                                        <option value=""></option>
                                       
                                    </select>

                                </div>
                            </div>
                        </div>    
                       
                    </div>
                        
                        <div id="grafCGM">
                        
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
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td>
                                             <?php 
                                                $arrayCategoria = array();
                                                $categoriaGrupoAnterior = "";
                                                $valorCategoria = 0;
                                                $contadorCategoria = 0;
                                                
                                                arsort($categoria);
                                                foreach ($categoria as $itemacategoria){
                                                    
                                                    if($itemacategoria['CodigoGrupoCategoria'] !=  $categoriaGrupoAnterior)
                                                        {
                                                        
                                                        if($contadorCategoria > 0)
                                                            {
                                                            
                                                            $provisionalGripoCategoria = array("ValorTotalCategoria"=>$valorCategoria,"GrupoCategoria"=>$categoriaGrupoAnterior);
                                                            array_push($arrayCategoria, $provisionalGripoCategoria);
                                                            $valorCategoria=0;
                                                            
                                                            } 
                                                        }
                                                        $valorCategoria = $valorCategoria + $itemacategoria['TotalPrecioNeto'];
                                                        $categoriaGrupoAnterior = $itemacategoria['CodigoGrupoCategoria'];
                                                        $contadorCategoria ++;
                                                    
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
                                                
                                                arsort($categoria);
                                                foreach ($categoria as $itemacategoria){
                                                    
                                                    if($itemacategoria['CodigoGrupoCategoria'] !=  $categoriaGrupoAnterior)
                                                        {
                                                        
                                                        if($contadorCategoria > 0)
                                                            {
                                                            
                                                            $provisionalGripoCategoria = array("ValorTotalCategoria"=>$valorCategoria,"GrupoCategoria"=>$categoriaGrupoAnterior);
                                                            array_push($arrayCategoria, $provisionalGripoCategoria);
                                                            $valorCategoria=0;
                                                            
                                                            } 
                                                        }
                                                        $valorCategoria = $valorCategoria + $itemacategoria['TotalPrecioNeto'];
                                                        $categoriaGrupoAnterior = $itemacategoria['CodigoGrupoCategoria'];
                                                        $contadorCategoria ++;
                                                    
                                                }
                                             
                                                arsort($arrayCategoria);
                                                
                                               // echo '<pre>';
                                                //print_r($arrayCategoria);
                                                
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
                                                    arsort($categoria);
                                                    foreach ($categoria as $itemaCategoriacaja){
                                                        
                                                        if($itemaCategoriacaja['CodigoUnidadMedida'] != '001'){
                                                            
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemaCategoriacaja['CodigoArticulo'],$itemaCategoriacaja['CodigoUnidadMedida'],$itemaCategoriacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrarcategoria = $itemaCategoriacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                           
                                                            }
                                                            
                                                            //echo $cajasamostrar.' - '. $itemacaja['NombreCuentaProveedor'].'<br/>';
                                                            
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
                                                     
                                                     
                                                   $Gp =  array(); 
                                                   $Gp = $arrayCategoria;
                                                    sort($Gp);
                                                   
                                                   /*echo '<pre>';
                                                   print_r($Gp);*/
                                                     
                                                  $arrayGrupo= array();
                                                  $grupoAnterior = "";
                                                  $totalValorGrupo = 0;
                                                  $totalcajas =0;
                                                  $contGrupo = 0; 
                                                  
                                                  foreach ($Gp as $itemacategoriaGrupo){
                                                      
                                                      /*echo '<pre>';
                                                      print_r($itemacategoriaGrupo);*/
                                                    
                                                    if($itemacategoriaGrupo['Agrupo'] !=  $grupoAnterior)
                                                        {
                                                        
                                                        if($contGrupo > 0)
                                                            {
                                                            
                                                            $provisionalGrupo = array("ValorTotalGrupo"=>$totalValorGrupo,"Grupo"=>$grupoAnterior,"TotalCajasGrupo"=>$totalcajas);
                                                            array_push($arrayGrupo, $provisionalGrupo);
                                                            $totalValorGrupo=0;
                                                            $totalcajas=0;
                                                            
                                                            } 
                                                        }
                                                        $totalValorGrupo = $totalValorGrupo + $itemacategoriaGrupo['ValorTotalCategoria'];
                                                        $CajaGrupo =  intval($itemacategoriaGrupo['Cajas']);
                                                        $totalcajas = $totalcajas + $CajaGrupo;
                                                        $grupoAnterior = $itemacategoriaGrupo['Agrupo'];
                                                        $contGrupo ++;
                                                       
                                                } 
                                                arsort($arrayGrupo);
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
                                                     if($conArrayGrupo < 10){
                                                ?>    
                                                <td class="text-center"><?php echo $itemGrupo['TotalCajasGrupo'] ?></td>
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
                                    <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td></td>
                                                <?php
                                                /*echo '<pre>';
                                                 print_r($arrayCategoria);*/
                                               $arrayMarcas = array();
                                               $anteriorMarca = "";
                                               $contmarca=0;
                                               foreach ($arrayCategoria as $key=>$item){
                                                        
                                                        $Marcas= ReporteVistaLink::model()->getMarcas($item['GrupoCategoria']);
                                                        sort($Marcas);
                                                        /*echo '<pre>';
                                                        print_r($Marcas);*/
                                                        
                                                        foreach ($Marcas as $itemMarca){
                                                            
                                                           if($itemMarca['CodigoMarca'] != $anteriorMarca)
                                                             {
                                                                
                                                                if($contmarca > 0)
                                                                {
                                                                    
                                                                    $provisionamarcas = array("Marca"=>$anteriorMarca);
                                                                    array_push($arrayMarcas, $provisionamarcas);
                                                                    
                                                                }
                                                                
                                                                $anteriorMarca = $itemMarca['CodigoMarca'];
                                                                $contmarca++;
                                                            }
                                                            
                                                            
                                                            
                                                        }
                                                        /*echo '<pre>';
                                                                print_r($arrayMarcas);*/
                                                        
                                                        
                                                        
                                                        foreach ($Grupos as $keySubItem=>$subItem){
                                                            
                                                            if($item['GrupoCategoria']==$subItem['Nombre']){
                                                                 $arrayCategoria[$key]['Agrupo']=$subItem['IdPrincipal'];
                                                                 ksort($arrayCategoria[$key]);
                                                           }                                                            
                                                      }
                                                        
                                                }  
                                                
                                                
                                                ?>
                                                
                                            </tr>
                                            <tr>
                                                <td class="text-center">Pesos&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                
                                                
                                                <td class="text-center">200000</td>    
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cajas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: orange"></span></td>
                                               
                                               <td class="text-center">100000</td>  
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
                            
                            
                    </div>        
                        
                        
 <script>

    $(document).ready(function(){
        
        var FechaCat =  $('#datepickerVistaLink').val();
        var Fecha =  $('#datepicker').val();

      $('#containervistalinkventasvendedorxzona').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Detalle Pesos'
            },
            subtitle: {
            text: 'Detalle Pesos ' + Fecha
            },
            xAxis: {
            categories: [
<?php foreach ($reporteventasprovedorxZonaVentas as $item): ?>
                '<?php echo $item['NombreCuentaProveedor']; ?>',
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
                    color: 'blue',
            }
            },
            series: [ {
            name: 'Pesos',
                    data: [

<?php foreach ($reporteventasprovedorxZonaVentas as $itemtotal): ?>

    <?php echo $itemtotal['total_ventas_porveedor']; ?>,
<?php endforeach; ?>
                    ]

            }, ]
    });
    
            ////Grafica cajas///
            
      $('#containercajasxazona').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Detalle Caja'
            },
            subtitle: {
            text: 'Caja ' + Fecha
            },
            xAxis: {
            categories: [
<?php 
$arrayContenedorCajasZonaVentas= array();
                                                   $anteriorProvedorCaja = "";
                                                   $valorProve = 0;
                                                   $contcajas = 0;
                                                   arsort($reportecajaxZonaVentas);
                                                   
                                                    foreach ($reportecajaxZonaVentas as $itemacaja){
                                                         //$contcajas ++;
                                                        if($itemacaja['CodigoUnidadMedida'] != '001'){
                                                           
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemacaja['CodigoArticulo'],$itemacaja['CodigoUnidadMedida'],$itemacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrar = $itemacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                          
                                                            }
                                                            
                                                              
                                                           if($itemacaja['NombreCuentaProveedor'] != $anteriorProvedorCaja)
                                                             
                                                            {
                                                             if($contcajas > 0)
                                                                 
                                                               {
                                                                  $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                                    
                                                                   array_push($arrayContenedorCajasZonaVentas, $provisional);
                                                                   $valorProve = 0;
                                                                  
                                                               }
                                                            }
                                                          $valorProve = $valorProve + $cajasamostrar;
                                                          $anteriorProvedorCaja = $itemacaja['NombreCuentaProveedor'];
                                                          $contcajas ++;
                                                        }
                                                      }
                                                    //el entra a esta linea de codigo si es solo un proveedor  
                                                    $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                    array_push($arrayContenedorCajasZonaVentas, $provisional);   
                                                      
                                                    arsort($arrayContenedorCajasZonaVentas);
                                                    $contArray=0;

foreach ($arrayContenedorCajasZonaVentas as $item): ?>
                    <?php if($contArray < 12){ ?>
                '<?php echo $item['NombreCuentaProveedor']; ?>',
                    <?php } ?>
<?php $contArray++; endforeach; ?>
            ]
            },
            yAxis: {
            min: 0,
                    title: {
                    text: 'Cajas'
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
$arrayContenedorCajasZonaVentas= array();
                                                   $anteriorProvedorCaja = "";
                                                   $valorProve = 0;
                                                   $contcajas = 0;
                                                   arsort($reportecajaxZonaVentas);
                                                   
                                                    foreach ($reportecajaxZonaVentas as $itemacaja){
                                                         //$contcajas ++;
                                                        if($itemacaja['CodigoUnidadMedida'] != '001'){
                                                           
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemacaja['CodigoArticulo'],$itemacaja['CodigoUnidadMedida'],$itemacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrar = $itemacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                          
                                                            }
                                                            
                                                              
                                                           if($itemacaja['NombreCuentaProveedor'] != $anteriorProvedorCaja)
                                                             
                                                            {
                                                             if($contcajas > 0)
                                                                 
                                                               {
                                                                  $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                                    
                                                                   array_push($arrayContenedorCajasZonaVentas, $provisional);
                                                                   $valorProve = 0;
                                                                  
                                                               }
                                                            }
                                                          $valorProve = $valorProve + $cajasamostrar;
                                                          $anteriorProvedorCaja = $itemacaja['NombreCuentaProveedor'];
                                                          $contcajas ++;
                                                        }
                                                      }
                                                    //el entra a esta linea de codigo si es solo un proveedor  
                                                    $provisional = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);
                                                    array_push($arrayContenedorCajasZonaVentas, $provisional);   
                                                      
                                                    arsort($arrayContenedorCajasZonaVentas);
                                                    $contArray=0;

foreach ($arrayContenedorCajasZonaVentas as $itemtotal):
     $totalcajaszonaventas = intval($itemtotal['total_ventas_porveedor_caja']);
    ?>
                        <?php if($contArray < 12){ ?>
    <?php echo $totalcajaszonaventas; ?>,
                        <?php } ?>
<?php $contArray++; endforeach; ?>
                    ]

            }, ]
    });
    
    
          /////////GRAFICA CATEGORIA////////
   
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
            
            
       
    
    
    }); 

</script>                       

