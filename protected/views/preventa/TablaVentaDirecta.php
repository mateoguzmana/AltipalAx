<?php

$session = new CHttpSession;
$session->open();
?>
<table class="table table-bordered" id="tblPortafolioVentaDirecta">
                    <thead>
                        <tr>
                            <th class="col-sm-2"></th>
                            <th class="col-sm-8">Producto</th>
                            <th class="col-sm-2"></th>                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $session = new CHttpSession;
                        $session->open();
                        
                        $position = array();  
                        $newRow = array();
                        $inverse = false;
                        $portafolioPreventa = $session['portafolio'];
                        foreach ($portafolioPreventa as $key => $row) {
                          
                                $position[$key]  = $row['SPDisponible'];  
                                $position[$key] = $row['SaldoDisponibleVenta'];
                                $newRow[$key] = $row;
                                $inverse = true;
                        }  
                        
                        if ($inverse) {  
                            arsort($position);  
                        }  
                        
                        $portafolioPre = array();  
                        foreach ($position as $key => $pos) {       
                            $portafolioPre[] = $newRow[$key];  
                        }  
                        
                        //echo 'vacioa'.$session['proveedor'];
                        
                        /*echo '<pre>';
                        print_r($portafolioPre);
                        exit();*/
                        
                        $cont=1;
                        foreach ($portafolioPre as $itemPortafolio) {
                            
                        if($itemPortafolio['CuentaProveedor'] ==  $cuentaproveedor){    
                            
                         $kitvalidacion=false;  
                          if($itemPortafolio['ACIdAcuerdoComercial'] !=""){ 
                              
                              if($itemPortafolio['CodigoTipo'] == KV || $itemPortafolio['CodigoTipo'] == KD || $itemPortafolio['CodigoTipo'] == KP){
                                  
                                  $IdListaMateriales = Consultas::model()->getListaMateriales($itemPortafolio['CodigoArticulo']);
                                  $ConsultaComponenOB = Consultas::model()->getComponentesOB($IdListaMateriales[0]['CodigoListaMateriales']);
                                  
                                  if($ConsultaComponenOB['componentes'] == 1){
                                      
                                      $ListaMaDatilComp = Consultas::model()->getListaMaterialesDetalle($IdListaMateriales[0]['CodigoListaMateriales']);
                                      if($ListaMaDatilComp[0]['CodigoTipo'] == 'OB'){
                                      $kitvalidacion = true;
                                      }
                                  }
                                
                                  
                              }
                         
                         if($kitvalidacion == false){
                            
                          if($itemPortafolio['ACPrecioVenta']==""){
                         ?>     
                          <tr class="btnAdicionarSinPrecio cursorpointer active cuentaproveedor"  
                              data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "
                           >
                              
                            <td style="width: 15%;" class="text-center icon-table1">                                                                 
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/restringido.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/> 
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta']));?>
                                    <br/>
                                     <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) /100;
                                            echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion) );
                                        }
                                        else
                                        {
                                             echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']),'2',',','.');
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>
                        <?php                           
                          } else if($itemPortafolio['CodigoTipo']=="KV" && $itemPortafolio['kitActivo']=="1" ){
                         ?>     
                           
                          <tr class="btnAdicionarKitVirtual cursorpointer cuentaproveedor"
                              
                              data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "
                              data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                              data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                              data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                              data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                              data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                              data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                              data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                              data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                              data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                              data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                              data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                              data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                              data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                              data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                              data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"
                                 
                              data-zona-ventas="<?php echo $zonaVentas;?>"
                              data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"
                               
                              >  
                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/> 
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                   <b>Valor Sin Impuestos:</b><?php  $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],0);
                                            echo number_format( floor( $resultado));?>
                                    <br/>
                                    <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],1);
                                            echo number_format( floor( $resultado));
                                        }
                                        else
                                        {
                                              $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],1);
                                             echo number_format( floor($resultado));
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>   
                             <?php                           
                          } else if($itemPortafolio['CodigoTipo']=="KV" && $itemPortafolio['kitActivo']=="0" ){
                         ?>     
                           
                          <tr class="btnAdicionarProductoDetalleAct cursorpointer warning  cuentaproveedor"
                              
                              data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "
                              data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                              data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                              data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                              data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                              data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                              data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                              data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                              data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                              data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                              data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                              data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                              data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                              data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                              data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                              data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"
                                 
                              data-zona-ventas="<?php echo $zonaVentas;?>"
                              data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"
                               
                              >  
                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/sinsaldo.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/> 
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php  $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],0);
                                            echo number_format( floor( $resultado));?>
                                    <br/>
                                    <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],1);
                                            echo number_format( floor( $resultado));
                                        }
                                        else
                                        {
                                              $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],1);
                                             echo number_format( floor($resultado));
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>   
                            
                         <?php
                         } else if($itemPortafolio['CodigoTipo']=="KD" && $itemPortafolio['kitActivo']=="1"){
                         ?>
                         
                             <tr class="btnAdicionarKitDinamico cursorpointer  cuentaproveedor"
                               
                              data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "   
                              data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                              data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                              data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                              data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                              data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                              data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                              data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                              data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                              data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                              data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                              data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                              data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                              data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                              data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                              data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"
                             
                              data-zona-ventas="<?php echo $zonaVentas;?>"
                              data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"
                              
                                 >  
                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/>
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php  $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],0);
                                            echo $resultado;?>
                                    <br/>
                                   <b>Valor Sin Impuestos:</b><?php  $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],0);
                                            echo number_format( floor( $resultado));?>
                                    <br/>
                                    <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],1);
                                            echo number_format( floor( $resultado));
                                        }
                                        else
                                        {
                                              $resultado = PreventaController::actionValorConInpuestoKid($itemPortafolio['CodigoVariante'],$itemPortafolio['PorcentajedeIVA'],$itemPortafolio['CodigoGrupoVentas'],1);
                                             echo number_format( floor($resultado));
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>   
                         <?php   
                          } else if($itemPortafolio['SaldoDisponibleVenta']=="" ){
                        ?>      
                          <tr class="btnAdicionarProductoDetalleAct cursorpointer warning  cuentaproveedor"
                              
                              data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "
                              data-icon="<?php echo '1'; ?>"
                              data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                              data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                              data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                              data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                              data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                              data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                              data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                              data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                              data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                              data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                              data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                              data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                              data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                              data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                              data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"
                             
                              data-zona-ventas="<?php echo $zonaVentas;?>"
                              data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"                              
                              >  
                            <td style="width: 15%;" class="text-center icon-table1">                                                                  
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/sinsaldo.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/>
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta']));?>
                                    <br/>
                                     <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) /100;
                                            echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion) );
                                        }
                                        else
                                        {
                                             echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>
                            
                        <?php    
                          }else if(  ($itemPortafolio['ACPrecioVenta']=="" || (int)$itemPortafolio['ACPrecioVenta']==0) && $itemPortafolio['SaldoDisponibleVenta']==""){
                        ?>  
                         
                           <tr class="btnAdicionarSinPrecio cursorpointer active  cuentaproveedor"
                                data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "
                               >  
                            <td style="width: 15%;" class="text-center icon-table1">
                                                                  
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/restringido.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/>
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta']));?>
                                    <br/>
                                     <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) /100;
                                            echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion) );
                                        }
                                        else
                                        {
                                             echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>
                            
                        <?php    
                          }else if($itemPortafolio['ACPrecioVenta']!="" && $itemPortafolio['SaldoDisponibleVenta']!=""){
                         ?>     
                          
                          <tr class="btnAdicionarProductoDetalleAct cursorpointer  cuentaproveedor"
                              
                              data-cuentaproveedor="<?php echo $itemPortafolio['CuentaProveedor']; ?> "
                              data-CodigoVariante="<?php echo $itemPortafolio['CodigoVariante'] ?>"                               
                              data-CodigoArticulo ="<?php echo $itemPortafolio['CodigoArticulo'] ?>"
                              data-NombreArticulo ="<?php echo $itemPortafolio['NombreArticulo'] ?>"
                              data-CodigoTipo ="<?php echo $itemPortafolio['CodigoTipo'] ?>"
                              data-CodigoCaracteristica1 ="<?php echo $itemPortafolio['CodigoCaracteristica1'] ?>"
                              data-CodigoCaracteristica2 ="<?php echo $itemPortafolio['CodigoCaracteristica2'] ?>"
                              data-CodigoGrupoVentas ="<?php echo $itemPortafolio['CodigoGrupoVentas'] ?>"
                              data-IdentificadorProductoNuevo ="<?php echo $itemPortafolio['IdentificadorProductoNuevo'] ?>"
                              data-ACPrecioVenta ="<?php echo $itemPortafolio['ACPrecioVenta'] ?>"
                              data-ACIdAcuerdoComercial ="<?php echo $itemPortafolio['ACIdAcuerdoComercial'] ?>"
                              data-ACCodigoUnidadMedida ="<?php echo $itemPortafolio['ACCodigoUnidadMedida'] ?>"
                              data-ACNombreUnidadMedida ="<?php echo $itemPortafolio['ACNombreUnidadMedida'] ?>"
                              data-SPDisponible ="<?php echo $itemPortafolio['SPDisponible'] ?>"                              
                              data-SPNombreUnidadMedida ="<?php echo $itemPortafolio['SPNombreUnidadMedida'] ?>"
                              data-SPCodigoUnidadMedida ="<?php echo $itemPortafolio['SPCodigoUnidadMedida'] ?>"
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVenta'] ?>"
                              
                              data-zona-ventas="<?php echo $zonaVentas;?>"
                              data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"
                               
                              > 
                              
                            <td style="width: 15%;" class="text-center datos-item">                                                                  
                                    <img class="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />                       
                            </td>

                                <td >
                                    <b><?php echo $cont;?>) Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];                                   
                                    ?>                     
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/>
                                     <?php
                                     echo $itemPortafolio['CodigoArticulo'] 
                                     ?>
                                    <br/>
                                    <b>Valor Sin Impuestos:</b><?php echo number_format(floor($itemPortafolio['ACPrecioVenta']));?>
                                    <br/>
                                     <b>Valor Con Impuestos:</b><?php if ($itemPortafolio['PorcentajedeIVA'] !="" ) 
                                        {
                                            $varIVAConvercion = floor($itemPortafolio['ACPrecioVenta']) * floor($itemPortafolio['PorcentajedeIVA']) /100;
                                            echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']) + floor($varIVAConvercion) );
                                        }
                                        else
                                        {
                                             echo number_format(floor($itemPortafolio['ACPrecioVenta']) + floor($itemPortafolio['ValorIMPOCONSUMO']));
                                        };?><br/>
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>
                            
                         <?php   
                          }  
                        ?>    
                            
                                <?php
                                $cont++;
                         }
                        }
                        } 
                                }
                            ?>
                    </tbody>
                </table>