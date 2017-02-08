<?php 

if(!Yii::app()->user->isGuest) {                       
     $Nombre = Yii::app()->user->_nombres." ".Yii::app()->user->_apellidos;  
     $connection = Multiple::getConexionZonaVentas();
     $sql = "SELECT * FROM `jerarquiacomercial` WHERE `NombreEmpleado` = '$Nombre'";
     $command = $connection->createCommand($sql);
     $dataReader = $command->queryAll();
     $CodigoZonaVentas = $dataReader[0]["CodigoZonaVentas"];
     
     $connection2 = Multiple::getConexionZonaVentas();
     $sql2 = "SELECT * FROM `zonaventas` WHERE `CodZonaVentas` = '$CodigoZonaVentas'";
     $command2 = $connection2->createCommand($sql2);
     $dataReader2 = $command2->queryAll();
     $CodigoGrupoVentas = $dataReader2[0]["CodigoGrupoVentas"];
     
     $connection3 = Multiple::getConexionZonaVentas();
     $sql3 = "SELECT  PermitirModificarDescuentoLinea,PermitirModifiarDescuentoMultiLinea FROM `gruposventas` WHERE `CodigoGrupoVentas` = '$CodigoGrupoVentas'";
     $command3 = $connection3->createCommand($sql3);
     $dataReader3 = $command3->queryAll();
     $PermisoDescuentoLinea = $dataReader3[0]["PermitirModificarDescuentoLinea"];
     $PermisoDescuentoMultiLinea = $dataReader3[0]["PermitirModifiarDescuentoMultiLinea"];
     
     $connection4 = Multiple::getConexionZonaVentas();
     $sql4 = "SELECT  (`PorcentajeDescuentoMultilinea1`+`PorcentajeDescuentoMultilinea2`) AS PorcentajeDescuentoMultiLinea, Max(`FechaInicio`) FROM `acuerdoscomercialesdescuentomultilinea` WHERE `CodigoGrupoArticulosDescuentoMultilinea` = '$CodigoGrupoVentas' ";
     $command4 = $connection4->createCommand($sql4);
     $dataReader4 = $command4->queryAll();
     $PorDescuentoMultiLinea = $dataReader4[0]["PorcentajeDescuentoMultiLinea"];
     
     $connection5 = Multiple::getConexionZonaVentas();
     $sql5 = "SELECT MIN( PorcentajeDescuentoLinea1 + PorcentajeDescuentoLinea2 ) AS PorcentajeDescuentoLinea, MAX(`FechaInicio`) 
              FROM  `acuerdoscomercialesdescuentolinea` 
              WHERE  `CodigoClienteGrupoDescuentoLinea` = '$CodigoGrupoVentas'";
     $command5 = $connection5->createCommand($sql5);
     $dataReader5 = $command5->queryAll();
     $PorDescuentoLinea = $dataReader5[0]["PorcentajeDescuentoLinea"];
     
     
 } 
 
$cont=0;

$session=new CHttpSession;
$session->open();

if($session['portafolio']){
     $datosPortafolio=$session['portafolio'];
}else{
    $datosPortafolio=array();
 }
 
 
if( $session['pedidoForm']){
     $datosPedido=$session['pedidoForm'];
}else{
    $datosPedido=array();
}


foreach ($datosPortafolio as $itemPortafolio){
     
     /*echo '<pre>';
     //echo $txtZonaVentas;
     print_r($itemPortafolio);*/
        
     $itemPorCodigoVariante=$itemPortafolio['CodigoVariante'];
     $itemPorCodigoArticulo=$itemPortafolio['CodigoArticulo'];
     
     if($itemPorCodigoVariante==$txtCodigoVariante && $itemPorCodigoArticulo==$txtCodigoArticulo){
         
     $itemPorNombreArticulo=$itemPortafolio['NombreArticulo'];
     $itemPorCodigoTipo=$itemPortafolio['CodigoTipo'];
     $itemPorCodigoCaracteristica1=$itemPortafolio['CodigoCaracteristica1'];
     $itemPorCodigoCaracteristica2=$itemPortafolio['CodigoCaracteristica2'];     
     $itemPorPorcentajedeIVA=$itemPortafolio['PorcentajedeIVA'];
     $itemPorValorIMPOCONSUMO=$itemPortafolio['ValorIMPOCONSUMO'];    
     $itemPorCodigoGrupoVentas=$itemPortafolio['CodigoGrupoVentas'];    
     $itemPorCuentaProveedor=$itemPortafolio['CuentaProveedor'];
     $itemPorIdentificadorProductoNuevo=$itemPortafolio['IdentificadorProductoNuevo'];
     $itemPorCodigoGrupoDescuentoLinea=$itemPortafolio['CodigoGrupoDescuentoLinea'];
     $itemPorCodigoGrupoDescuentoMultiLinea=$itemPortafolio['CodigoGrupoDescuentoMultiLinea'];
     $itemPortxtCodigoGrupoArticulosDescuentoMultilinea=$itemPortafolio['CodigoGrupoArticulosDescuentoMultilinea'];
         
     $itemPortxtIdAcuerdoLinea=$itemPortafolio['txtIdAcuerdoLinea'];
     $itemPortxtIdAcuerdoMultilinea=$itemPortafolio['txtIdAcuerdoMultilinea'];
         
     $itemPorACPrecioVenta=$itemPortafolio['ACPrecioVenta'];
     $itemPorACIdAcuerdoComercial=$itemPortafolio['ACIdAcuerdoComercial'];
     $itemPorACCodigoUnidadMedida=$itemPortafolio['ACCodigoUnidadMedida'];
     $itemPorACNombreUnidadMedida=$itemPortafolio['ACNombreUnidadMedida'];
     
     
     //aqui se calcula el valor impuesto 
      $valorProducto =  $itemPorACPrecioVenta+$itemPorValorIMPOCONSUMO;
      $valorConImpuesto = $valorProducto * $itemPorPorcentajedeIVA / 100;
      $TotalValorConImpuesto = $valorProducto + $valorConImpuesto + $itemPorValorIMPOCONSUMO;
      
      $itemPorSAId = $itemPortafolio['SAId'];
      $itemPorSADisponible=$itemPortafolio['SADisponible'];
      $itemPorSANombreUnidadMedida=$itemPortafolio['SANombreUnidadMedida'];
      $itemPorSACodigoUnidadMedida=$itemPortafolio['SACodigoUnidadMedida'];     
      $itemPorSaldoDisponibleVentaAutoventa=$itemPortafolio['SaldoDisponibleVentaAutoventa'];
      
      //echo $itemPorSaldoDisponibleVentaAutoventa;
     
     break; 
     }       
 }
 
 //Consultamos si existe el proucto
 $pedidoCodigoVariante='';
 $pedidoCodigoArticulo='';
 $pedidoCantidad='';
 $pedidoDescuentoEspecial='';
 $pedidoDescuentoEspecialSelect='';
 $pedidoDescuentoEspecialAltipal='';
 
 foreach ($datosPedido as $itemPedido){
     
     $pedidoCodigoVariante=$itemPedido['variante'];
     $pedidoCodigoArticulo=$itemPedido['articulo'];
     
     if($txtCodigoVariante==$pedidoCodigoVariante && $pedidoCodigoArticulo==$txtCodigoArticulo){ 
         
         /*echo '<pre>';
         print_r($itemPedido);
         echo '</pre>';*/
         
         $pedidoCantidad=$itemPedido['cantidad'];           
         $pedidoDescuentoEspecial=$itemPedido['descuentoEspecial'];          
         $pedidoDescuentoEspecialSelect=$itemPedido['descuentoEspecialSelect'];         
         $pedidoDescuentoEspecialAltipal=$itemPedido['descuentoEspecialAltipal'];
         $pedidoDescuentoEspecialProveedor=$itemPedido['descuentoEspecialProveedor'];
         
         $pedidoDescuentoAltipal=$itemPedido['descuentoAltipal'];         
         $pedidoDescuentoProveedor=$itemPedido['descuentoProveedor'];
         
     }
 }
  
 ?>
                
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b> <?php echo $itemPorCodigoVariante;?> <?php echo $itemPorNombreArticulo;?> <?php echo $itemPorCodigoCaracteristica1;?> <?php echo $itemPorCodigoCaracteristica2;?> (<?php echo $itemPorCodigoTipo;?>)</b></h4>
            </div>
            <div class="modal-body" >
                <div>
                  <?php 
                 /* echo '<pre>';
                  echo $itemPorCodigoVariante. " ".$ubicacion;
                 
                  print_r($datosPortafolio);
                  
                  echo '<pre>'; */
                  ?>    
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Unidad de Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetUnidadMedida" value="<?php echo $itemPorACNombreUnidadMedida;?>"/> 

                        <input type="hidden" id="textCodigoVariante" />  
                        
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="txtCodigoArticulo"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textDetCodigoUnidadMedida"/>      
                    </div>
                </div>
                <?php if($kit == 1){ ?>
                <?php $saldo = $itemPorSaldoDisponibleVentaAutoventa;  
                      $lotesMenor = Consultas::model()->getLoteMenorVariante($saldo,$ubicacion);?>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Lote:</label>
                    <div class="col-sm-6">
                        <select name="lote" class="form-control" id="txtLote">
                          <?php foreach ($lotesMenor as $lotMen){ ?>
                            <option <?php if($txtLote==$lotMen['LoteArticulo']){ ?> selected="select" <?php }?> value="<?php echo $lotMen['LoteArticulo']; ?>"><?php echo $lotMen['LoteArticulo']; ?></option>
                          <?php } ?> 
                        </select> 
                    </div>
                </div>
                <?php }else{ ?>
                <?php $lotes = Consultas::model()->getLoteVariante($itemPorCodigoVariante,$ubicacion);?>
                <?php $lot = count($lotes);?>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Lote:</label>
                    <div class="col-sm-6">
                        <select name="lote" class="form-control" id="txtLote">
                           <?php if($lot > 1){?>
                            <option value="0">Seleccione un lote</option>
                            <?php } ?>
                          <?php foreach ($lotes as $lot){ ?>
                            <option <?php if($txtLote==$lot['LoteArticulo']){ ?> selected="select" <?php }?> value="<?php echo $lot['LoteArticulo']; ?>"><?php echo $lot['LoteArticulo']; ?></option>
                          <?php } ?> 
                        </select> 
                    </div>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Saldo:</label>
                    <div class="col-sm-4 saldo">
                        <?php if($txtSaldo > 0){ ?>
                        <input type="text" name="name" readonly="readonly" class="form-control textDetSaldo"  value="<?php  echo $txtSaldo  ?>"/>
                        <?php }else{ ?>
                        <input type="text" name="name" readonly="readonly" class="form-control textDetSaldo"  value="<?php if(count($lotes) > 1) echo '0';  else if($itemPorSaldoDisponibleVentaAutoventa!="") echo $itemPorSaldoDisponibleVentaAutoventa; else echo "0";?>"/>
                        <?php } ?>
                    </div>
                    <div class="col-sm-2">
                        <label id="lblUnidadMedidaSaldo"><?php if($itemPorSANombreUnidadMedida) echo $itemPorACNombreUnidadMedida; else echo $itemPorACNombreUnidadMedida;?></label>
                    </div>
                </div>
             
                <div class="form-group">
                    <label class="col-sm-5 control-label">Saldo Limite:</label>
                    <div class="col-sm-4">
                        <input type="number" name="txtSaldoLimite" id="" readonly="readonly" class="form-control txtSaldoLimite" value="<?php echo $saldoLimite['Saldo'] ?>"/>
                        
                        <input type="hidden" name="txtCodigoTipo" id="txtCodigoTipo" readonly="readonly" class="form-control"/>
                        
                        <input type="hidden" name="txtLimiteVentasACDL" id="txtLimiteVentasACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDLSinConversion" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="" id="txtIdAcuerdo" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="" id="txtIdSaldoInventario" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCodigoUnidadSaldoInventario" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCuentaProveedor" readonly="readonly" class="form-control"/>


                        <input type="hidden" name="txtCodigoUnidadMedidaACDL" id="txtCodigoUnidadMedidaACDL" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="txtPorcentajeDescuentoLinea1ACDL" id="txtPorcentajeDescuentoLinea1ACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtPorcentajeDescuentoLinea2ACDL" id="txtPorcentajeDescuentoLinea2ACDL" readonly="readonly" class="form-control"/>
                    </div>
                    <div class="col-sm-2">
                        <label id="lblUnidadMedidaSaldoLimite"><?php if($itemPorSPNombreUnidadMedida) echo $itemPorACNombreUnidadMedida; else echo $itemPorACNombreUnidadMedida;?></label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label">IVA:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetIva" class="form-control" value="<?php echo $itemPorPorcentajedeIVA;?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label">Impoconsumo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetImpoconsumo" class="form-control" value="<?php echo ''. number_format($itemPorValorIMPOCONSUMO);?>"/>
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-sm-5 control-label">Valor con Impuestos:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetValorImpuestos" class="form-control" value="<?php echo '$'.number_format($TotalValorConImpuesto,'2',',','.'); ?>"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label">Valor del Producto:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetValorProductoMostrar" class="form-control" value="<?php  echo '$'. number_format($itemPorACPrecioVenta+$itemPorValorIMPOCONSUMO);?>"/>
                        
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-5 control-label">Cantidad Pedida:</label>
                    <div class="col-sm-6">
                        <!--<input type="text" id="txtCantidadPedida" name="name" class="form-control"/>-->
                        <input type="text" name="name" placeholder="Cantidad Pedida" class="form-control txtCantidadPedida" value="<?php  if (!empty($pedidoCantidad)) echo  $pedidoCantidad;?>"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-5 control-label">Descuento Promocional (Dcto 1):</label>
                    <div class="col-sm-6">
                    <!--<input type="text" name="name" id="txtDescuentoProveedor"class="form-control" />-->
                    <input type="text" class="form-control txtDescuentoProveedor" style="display: none"  id="descLineaValidado" value="<?php
                            if (!empty($saldoLimite['Total'])) {

                                echo $saldoLimite['Total'];
                            } else {

                                if (!empty($pedidoDescuentoProveedor)) {
                                    echo $pedidoDescuentoProveedor;
                                } else {
                                    echo '0';
                                }
                            }?>"/>
                    
                    <?php if($PermisoDescuentoLinea == 'verdadero'){ ?>
                      
                    <input type="text" class="form-control txtDescuentoProveedor" onblur="ValidarPorLinea()" id="descLinea" value="<?php
                            if (!empty($saldoLimite['Total'])) {

                                echo $saldoLimite['Total'];
                            } else {

                                if (!empty($pedidoDescuentoProveedor)) {
                                    echo $pedidoDescuentoProveedor;
                                } else {
                                    echo '0';
                                }
                            }?>"/>
                    <?php } else{ ?> 
                        
                           <input type="text" class="form-control txtDescuentoProveedor" readonly="readonly" value="<?php
                            if (!empty($saldoLimite['Total'])) {

                                echo $saldoLimite['Total'];
                            } else {

                                if (!empty($pedidoDescuentoProveedor)) {
                                    echo $pedidoDescuentoProveedor;
                                } else {
                                    echo '0';
                                }
                            }?>"/>
                           <script>
                               $('.txtDescuentoProveedor').prop('disabled', true);
                           </script>
                    <?php } ?>
                           <script>
                                function ValidarPorLinea() {
                                    var PorDescuentoL = parseInt($('#descLinea').val());
                                    var PorDescuentoLVal = parseInt($('#descLineaValidado').val());
                                    if(PorDescuentoL <= PorDescuentoLVal){

                                    }
                                    else{
                                        alert('El valor Descuento Promocional (Dcto 1) debe ser menor o igual a: ' + PorDescuentoLVal);
                                        $('#descLinea').val(PorDescuentoLVal);
                                    }
                                }
                           </script>

                </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-5 control-label">Descuento Canal (Dcto 2):</label>
                    <div class="col-sm-6">
                    <input type="text" name="name" id="DescVal" class="form-control txtDescuentoAltipal" style="display: none" value="<?php if (!empty($pedidoDescuentoAltipal)) echo $pedidoDescuentoAltipal;
                           else echo '0'; ?>"/>
                    <?php if($PermisoDescuentoMultiLinea == 'verdadero'){ ?>
                         
                    <input type="text" name="name" id="Desc1" class="form-control txtDescuentoAltipal" onblur="ValidarPorMLinea()" value="<?php if (!empty($pedidoDescuentoAltipal)) echo $pedidoDescuentoAltipal;
                           else echo '0'; ?>"/>
                    <?php } else{ ?> 
                           
                           <input type="text" name="name" class="form-control txtDescuentoAltipal"  readonly="readonly" value="<?php if (!empty($pedidoDescuentoAltipal)) echo $pedidoDescuentoAltipal;
                           else echo '0'; ?>"/>
                           <script>
                               $('.txtDescuentoAltipal').prop('disabled', true);
                           </script>
                    <?php } ?>
                   <script>
                    function ValidarPorMLinea() {
                        var PorDescuentoML = parseInt($('#Desc1').val());
                       var PorDescuentoMLVal = parseInt($('#DescVal').val());
                    
                    
                    if(PorDescuentoML <= PorDescuentoMLVal){
                        
                    }
                    else{
                        alert('El valor Descuento Canal (Dcto 2) debe ser menor o igual a: ' + PorDescuentoMLVal);
                        $('#Desc1').val(PorDescuentoMLVal);
                    }
                    }
                   </script>
                </div>
                </div>

            </div>
            <div class="modal-footer">
                
                <!---Datos a enviar --->
                
              <input type="hidden" readonly="readonly" class="txtClienteDetalle" value="<?php echo $txtCliente?>"/> 
              <?php $CodArticuloCliente = Consultas::model()->getCodArtiDesLinaCliente($txtCliente,$txtZonaVentas); ?>
              <input type="hidden" readonly="readonly" class="txtZonaVenta" value="10091" />
             
              
              
              <input type="hidden" readonly="readonly" class="form-control textDetValorProducto" value="<?php echo $itemPorACPrecioVenta;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control textDetCodigoProducto" value="<?php echo $itemPorCodigoVariante;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control textDetNombreProducto" value="<?php echo $itemPorNombreArticulo;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control textDetIva" value="<?php echo $itemPorPorcentajedeIVA;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control textDetSaldo" value="<?php echo $itemPorSaldoDisponibleVenta;?>"/>               
              <input type="hidden" readonly="readonly" class="form-control textDetImpoconsumo" value="<?php echo $itemPorValorIMPOCONSUMO;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control textDetCodigoUnidadMedida" value="<?php echo $itemPorACCodigoUnidadMedida;?>"/>     
              
              <input type="hidden" readonly="readonly" class="form-control textDetNombreUnidadMedida" value="<?php echo $itemPorACNombreUnidadMedida;?>"/>  
                            
              <input type="hidden" readonly="readonly" class="form-control txtCodigoArticulo" value="<?php echo $txtCodigoArticulo;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control txtIdAcuerdo" value="<?php echo $itemPorACIdAcuerdoComercial;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control txtCodigoUnidadSaldoInventario" value="<?php echo $itemPorSACodigoUnidadMedida;?>"/>                 
              <input type="hidden" readonly="readonly" class="form-control txtCodigoTipo" value="<?php echo $itemPorCodigoTipo;?>"/>  
              <input type="hidden" readonly="readonly" class="form-control txtCuentaProveedor" value="<?php echo $itemPorCuentaProveedor;?>"/>
              
              <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoDescuentoLinea" value="<?php echo $itemPorCodigoGrupoDescuentoLinea;?>"/>              
              <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoDescuentoMultiLinea" value="<?php echo $itemPorCodigoGrupoDescuentoMultiLinea;?>"/>
              
              <input type="hidden" readonly="readonly" class="form-control txtIdSaldoAutoventa" value="<?php echo $itemPorSAId ?>">
              <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoArticulosDescuentoLinea" value="<?php echo $CodArticuloCliente[0]['CodigoGrupoDescuentoLinea'];?>"/>
              <input type="hidden" readonly="readonly" class="form-control txtCodigoGrupoArticulosDescuentoMultilinea" value="<?php echo $CodArticuloCliente[0]['CodigoGrupoDescuentoMultiLinea'];?>"/>
              
              
              <input type="hidden" readonly="readonly" class="form-control txtIdAcuerdoLinea"  value="<?php echo $itemPortxtIdAcuerdoLinea;?>"/>
              <input type="hidden" readonly="readonly" class="form-control txtIdAcuerdoMultilinea"  value="<?php echo $itemPortxtIdAcuerdoMultilinea;?>"/> 
              <input type="hidden" readonly="readonly" class="form-control txtubicacion" value="<?php echo $ubicacion ?>"/>
              
              
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btnAdicionarProducto" >Adicionar</button>
            </div>
        </div>
    </div>

 


