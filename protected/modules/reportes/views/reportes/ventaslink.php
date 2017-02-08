   <div id="content">
	<div class="pageheader">
    <h2>
        <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=reportes/Reportes/Ventas">
            <img src="images/home.png" class="cursorpointer " style="width: 38px; margin-right: 15px; margin-left: 15px;"/>
        </a>

        Ventas<span></span>Ventas x Proveedor</h2>  
</div> 

<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 1000px;">

            <div class="panel-heading">
                
                <?php $this->renderPartial('_IconosMenu');?>
            </div>




            <div class="widget widget-blue">


                <div class="widget-content">
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
                                        $canal = ReporteVistaLink::model()->getCanales();

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
                                <div id="zonasventas" class="GenrarRepoteZonaVenta">
                                    <select id="selectchosezonaventas" name="ZonaVentas" class="form-control chosen-select" data-placeholder="Seleccione una zona venta">
                                        <option value=""></option>


                                    </select>
                                </div>
                            </div>   
                        </div>
                    </div>
                    
                    <div id="graf">

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
                                        <div id="containerventasproveedor" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                          <table class="table table-bordered" style="width: 1000px;">
                                                <tr>
                                                    <td></td>
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
                                                        
                                                       
                                                    if($contVentaProve < 12){
                                                        ?>
                                                        <td class="text-center"><?php echo $ItemTotales['NombreCuentaProveedor'] ?></td>
                                                        <?php
                                                        }
                                                       $contVentaProve++; 
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Pesos&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
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
                                                        if($contVentasProvee < 12){
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
                                                    <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span>&nbsp;Detalle Pesos

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
                                        <h3 class="panel-title">Detalle Cajas</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="containercajas" style="min-width: 310px; width: 1000px; height: 400px; margin: 0 auto"></div>
                                        <div class="table-responsive">
                                          <table class="table table-bordered" style="width: 1000px;">
                                                <tr>
                                                    <td></td>
                                                    <?php
                                                   // echo '<pre>'; print_r($cajas);
                                                    $arrayContenedorCajas = array();
                                                    $anteriorProvedorCaja = "";
                                                    $valorProve = 0;
                                                    $contcajas = 0;
                                                    arsort($cajas);
                                                    foreach ($cajas as $itemacaja){
                                                        
                                                        if($itemacaja['CodigoUnidadMedida'] != '001'){
                                                            
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemacaja['CodigoArticulo'],$itemacaja['CodigoUnidadMedida'],$itemacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrar = $itemacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                           
                                                            }
                                                            
                                                            //echo $cajasamostrar.' - '. $itemacaja['NombreCuentaProveedor'].'<br/>';
                                                            
                                                        if($itemacaja['NombreCuentaProveedor'] != $anteriorProvedorCaja)
                                                            
                                                            {
                                                             if($contcajas > 0)
                                                               {
                                                                  $provi = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);

                                                                   array_push($arrayContenedorCajas, $provi);
                                                                   $valorProve = 0;
                                                               }
                                                            }
                                                          $valorProve = $valorProve + $cajasamostrar;
                                                          $anteriorProvedorCaja = $itemacaja['NombreCuentaProveedor'];
                                                          $contcajas ++;
                                                        }
                                                        
                                                    }
                                                   
                                                   /*
                                                   echo '<pre>';
                                                    print_r($arrayContenedorCajas);
                                                    exit();*/
                                                 arsort($arrayContenedorCajas);
                                                 $contArray=0;   
                                                 foreach ($arrayContenedorCajas as $itemcajas){
                                                     if($contArray < 12){
                                                    ?>
                                                     <td class="text-center"><?php echo $itemcajas['NombreCuentaProveedor'] ?></td>
                                                 <?php 
                                                     }
                                                   $contArray++;  
                                                  } ?>   
                                                </tr>
                                                <tr>
                                                    <td class="text-center">Cajas&nbsp;&nbsp; <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span></td>
                                                <?php
                                                
                                                 $arrayContenedorCajas = array();
                                                 $anteriorProvedorCaja = "";
                                                 $valorProve = 0;
                                                 $contcajas = 0;
                                                    arsort($cajas);
                                                    /*echo '<pre>';
                                                    print_r($cajas);*/
                                                    foreach ($cajas as $itemacaja){
                                                        
                                                        if($itemacaja['CodigoUnidadMedida'] != '001'){
                                                            
                                                            $UnidadConversion = ReporteVistaLink::model()->getUnidadConversion($itemacaja['CodigoArticulo'],$itemacaja['CodigoUnidadMedida'],$itemacaja['Agencia']);
                                                            
                                                            foreach ($UnidadConversion as $itemConversion){
                                                            
                                                            $cajasamostrar = $itemacaja['Cantidad'] / $itemConversion['Factor'];
                                                            
                                                           
                                                            }
                                                            
                                                            //echo $cajasamostrar.' - '. $itemacaja['NombreCuentaProveedor'].'<br/>';
                                                            
                                                        if($itemacaja['NombreCuentaProveedor'] != $anteriorProvedorCaja)
                                                            
                                                            {
                                                             if($contcajas > 0)
                                                               {
                                                                  $provi = array("total_ventas_porveedor_caja"=>$valorProve,"NombreCuentaProveedor"=>$anteriorProvedorCaja,);

                                                                   array_push($arrayContenedorCajas, $provi);
                                                                   $valorProve = 0;
                                                               }
                                                            }
                                                          $valorProve = $valorProve + $cajasamostrar;
                                                          $anteriorProvedorCaja = $itemacaja['NombreCuentaProveedor'];
                                                          $contcajas ++;
                                                        }
                                                        
                                                    }
                                                
                                                
                                                 $contArray=0;   
                                                 arsort($arrayContenedorCajas);
                                                  
                                                 foreach ($arrayContenedorCajas as $itemcajas){
                                                     $numeroentero=intval($itemcajas['total_ventas_porveedor_caja']);
                                                     if($contArray < 12){
                                                  ?>
                                                    <td class="text-center"><?php echo $numeroentero ?></td>
                                                  <?php 
                                                     }
                                                   $contArray++;  
                                                 }
                                                  ?>  
                                                  
                                                </tr>
                                            </table>
                                            <table style="width: 151px ! important; height: 20px; margin: 0 auto;" class="table table-bordered">
                                                <td>
                                                    <span style="padding: 0px 8px; width: 5px; height: 5px; background-color: blue"></span>&nbsp;Cajas

                                                </td>
                                            </table> 

                                        </div>
                                    </div>
                                </div><!-- panel -->
                            </div><!-- col-sm-6 -->
                        </div>
                        </div>
                        
                      <!--AQUI SE EMPIESA LAS GRAFICAS DE CATEGORIAS GRUPOS Y MARCAS-->
                        
                        
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
                                <div id="categorias" class="GenrarReporteCategoriaVentasVistaLink onchangeGruposByMarcas">
                                    <select id="selectCategoria" name="Categoria" class="form-control chosen-select" data-placeholder="Seleccione una categoria">
                                        <option value=""></option>
                                        
                                    </select>

                                </div>
                            </div>
                        </div> 
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Grupos</label>
                                <div id="grupos">     
                                    <select id="selectGrupos" name="Grupo" class="form-control chosen-select" data-placeholder="Seleccione un grupo">
                                        <option value=""></option>
                                       
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="form-group">
                                <label>Marcas</label>
                                <div id="marcas" class="GenrarReporteMarcasVentasVistaLink">
                                    <select id="selectMarca" name="Marcas" class="form-control chosen-select" data-placeholder="Seleccione una marca">
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
                   
                   
              
                            
                            
                          </div>  
                      
                    
                    

                        </div>
                    </div>



                </div>
            </div>      

        </div>
</div>

    <script>
    $(document).ready(function(){
        
     $('#mensajeCategoria').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');   
     $('#mensajeGrupo').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');   
     $('#mensajeMarca').html('<center><b> Si quiere ver el indicador de cajas por favor dar click en el recuaro AZUL que se encuentra en la parte superior de este texto </b></center>');   
        ////////GRAFICA DE DETALLE PESO//////
     var FechaCat =  $('#datepickerVistaLink').val();
     var Fecha =  $('#datepicker').val();
        
         $('#containerventasproveedor').highcharts({
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
                    <?php if ($contVentasProvee < 12){ ?>
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
                    color: 'blue',
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
    if($ContVentasProvee < 12){
    ?>

    <?php echo $itemtotal['total_ventas_porveedor']; ?>,
    <?php $ContVentasProvee++; } endforeach; ?>
                    ]

            }, ]
    });
    
    
    
    
    /////////GRAFICA DE CAJAS ////////
    
    
     $('#containercajas').highcharts({
    chart: {
    type: 'column'
    },
            title: {
            text: 'Detalle Cajas'
            },
            subtitle: {
            text: 'Detalle Cajas ' + Fecha
            },
            xAxis: {
            categories: [
<?php  
$contArray=0; foreach($arrayContenedorCajas as $item): ?>
                    <?php if ($contArray < 12){ ?>
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
                    color: 'blue',
            }
            },
            series: [ {
            name: 'Cajas',
                    data: [

<?php 
$contArray=0;    
foreach ($arrayContenedorCajas as $itemtotal):
      $numeroentero=intval($itemtotal['total_ventas_porveedor_caja']);
    if($contArray < 12){
    ?>

    <?php echo $numeroentero; ?>,
    <?php $contArray++; } endforeach; ?>
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