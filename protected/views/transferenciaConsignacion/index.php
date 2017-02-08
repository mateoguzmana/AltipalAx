<?php
$session = new CHttpSession;
$session->open();

$codigositio = $session['codigositio'];
$tipoVenta = $session['tipoVenta'];
$nombreSitio = $session['nombreSitio'];
$nombreTipoVenta = $session['nombreTipoVenta'];

$CodigoCanal=$session['canalEmpleado'];
//$CodigoCanal=$session['CodigoCanal'];
$Responsable=$session['Responsable']; 
 

$session['pedidoForm'] = "";
?>

<style>
    #tableDetail{
        width: 100% important;
    }   
</style>

  
<div class="pageheader">
    <h2>        
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenuTransConsignacion"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Transferencia en Consignación <span></span></h2>      
</div>

<?php if (Yii::app()->user->hasFlash('succe')): ?>
    
    
    <?php $this->renderPartial('//mensajes/_alertaSucessTransConsignacion',array('zonaVentas'=>$zonaVentas, 'datosCliente'=>$datosCliente['CuentaCliente'])); ?>    

<?php endif; ?>

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-1">
                    <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                </div>
                <div class="col-md-3">
                    <h5> Cuenta:  <span class="text-primary"><?php echo $datosCliente['CuentaCliente']; ?></span></h5>
                    <h5> Nombre: <span class="text-primary"><?php echo $datosCliente['NombreCliente']; ?></span></h5>
                </div>

                <div class="col-md-4">
                    <h5> Código Zona Ventas:  <span class="text-primary"><?php echo $zonaVentas ?></span></h5>
                    <h5> Nombre Zona Ventas: <span class="text-primary"><?php echo $datoszona['NombreZonadeVentas']; ?></span></h5>
                </div>
                
                
                 <div class="col-md-3">
                     <h5> Sitio: <span class="text-primary"><?php echo $nombreSitio  //echo $sitiosVentas['NombreAlmacen']; ?></span></h5>
                   
                 </div>

            </div>

        </div>
        
        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">                         
                            </div>
                            <div class="panel-body panel-body-nopadding">

                                <div id="validationWizardTransferencia" class="basic-wizard">
                                    <ul class="nav nav-pills nav-justified">

                                        <li><a href="#vtab2" data-toggle="tab"><img style="width: 24px; padding-right: 2px;" src="images/detalle.png">DETALLE</a></li>
                                        <li><a href="#vtab3" data-toggle="tab"><img style="width: 24px; padding-right: 2px;" src="images/totales.png">TOTAL TRANSFERENCIA CONSIGNACIÓN</a></li>
                                    </ul>

                                    <form class="form" id="formtransferenciaconsignacion" method="post" action="" >  
                                        <div class="tab-content">

                                            <div class="tab-pane" id="vtab1">

                                                <input type="hidden" name="CodigoCanal" value="<?php echo $CodigoCanal  ?>"/>
                                                <input type="hidden" name="Responsable" value="<?php echo $Responsable ?>"/>
                                                <input type="hidden" name="zonaVentas" value="<?php echo $zonaVentas; ?>"/>                      
                                                <input type="hidden" name="cuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>"/>
                                                <input type="hidden"  name="horaPedido"  value="<?php  echo date('H:i:s');?>">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Sitio/Almacen</label>
                                                    <div class="col-sm-8">  
                                                        <input type="text" id="select-sitio" data-codigo="<?php echo $codigositio; ?>" required name="sitio" class="form-control" readonly="readonly" value="<?php echo $nombreSitio; ?>"/>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Fecha Entrega</label>
                                                    <div class="col-sm-8">  
                                                        <?php
                                                        $modifica = $condicionPago['AplicaContado'];
                                                        ?>
                                                        <input type="text" name="fechaEntrega" class="form-control"  value="<?php echo date('Y-m-d'); ?>" <?php
                                                        if ($modifica == 'Falso') {
                                                            echo 'id="datepicker"';
                                                        } else {
                                                            echo 'readonly';
                                                        }
                                                        ?>  />
                                                    </div>
                                                </div>

                                                <div class="form-group"> 

                                                    <?php
                                                    if ($modifica == "Falso" && $condicionPago['Dias'] > 0) {
                                                        $diasPlazo = $condicionPago['Dias'];
                                                        $diasMinimo = 0;
                                                    } else {
                                                        $diasPlazo = 0;
                                                        $diasMinimo = 0;
                                                    }
                                                    ?>  

                                                    <label class="col-sm-4 control-label">Forma de Pago</label>
                                                    <div class="col-sm-8">                          
                                                        <select name="formaPago" class="form-control" id="formaPago" required>
                                                            <option value>Seleccionar Forma de pago</option>
                                                            <option value="contado">Contado</option>
                                                            <?php if ($modifica == "Falso" && $condicionPago['Dias'] > 0) { ?>
                                                                <option value="credito" data-dias-pago="<?php echo $diasPlazo; ?>">Crédito</option>
<?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
<?php ?>    
                                                    <label class="col-sm-4 control-label">Plazo</label>
                                                    <div class="col-sm-8">                            
                                                        <input type="number" id="plazo" required name="plazo" class="form-control" role="spinbutton" aria-valuenow="<?php echo $diasPlazo; ?>" min="<?php echo $diasMinimo; ?>" max="<?php echo $diasPlazo; ?>" value="<?php echo $diasPlazo; ?>"/>

                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Tipo de Venta</label>
                                                    <div class="col-sm-8">  

                                                        <select id="select-tipo-venta-transaccion" name="tipoVenta" required="required" class="form-control"> 
                                                            <option value="">Selecione Tipo de Venta</option>
                                                            <?php if ($session['desPreventa'] == "Verdadero" || $session['desPreventa'] == "verdadero"): ?>                                
                                                                <option value="Preventa">Preventa</option> 
                                                                <?php if ($session['Consignacion'] == "Verdadero" || $session['Consignacion'] == "verdadero"): ?>                                
                                                                    <option value="Consignacion">Consignacion</option>                                
                                                                <?php endif; ?>
                                                                <?php if ($session['VentaDirecta'] == "Verdadero" || $session['VentaDirecta'] == "verdadero"): ?>                                
                                                                    <option value="VentaDirecta">VentaDirecta</option>                                
    <?php endif; ?>
<?php endif; ?>
                                                        </select>   
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Actividad Especial</label>
                                                    <div class="col-sm-8">

                                                        <select name="actividadEspecial" id="actividadEspecial" class="form-control" required >                               
                                                            <?php if ($modifica == 'Falso' && $condicionPago['Dias'] > 0) { ?> 
                                                                <option value="no">No</option>   
                                                                <option value="si">Si</option>                                                        
                                                            <?php } else { ?>                             
                                                                <option value="no">No</option>
<?php } ?>

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label" >Observaciones: </label>
                                                    <div class="col-sm-8">                         
                                                        <textarea name="Observaciones" class="col-sm-12" id="txtAreaObservaciones" placeholder="Máximo 50 caracteres"></textarea>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="tab-pane" id="vtab2">

                                                <div class="row">
                                                    <div class="col-md-2 col-lg-offset-10">                              
                                                        <img src="images/add_productos.png" style="width: 40px;" class="cursorpointer" id="adicionar-portafolio"/>
                                                        <br/>
                                                        <small>Adicionar</small>
                                                    </div>
                                                </div>

                                                <div class="mb20"></div>

                                                <div class="row">                          
                                                    <div class="table-responsive" id="tableDetail">
                                                        <table class="table table-bordered" id="tableDetail">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">No.</th>
                                                                    <th class="text-center">Código Artículo</th>
                                                                    <th class="text-center">Descripción</th>                    
                                                                    <th class="text-center">Unidad de medida</th>
                                                                    <th class="text-center">Cantidad</th>
                                                                    <th class="text-center">Valor</th>
                                                                    <th></th>   
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="vtab3">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2" id="totalesCalculados">

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Valor Bruto</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Valor Iva</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Valor Impoconsumo</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Total Transferencia</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Valor Transferencia</label>
                                                            <div class="col-sm-6">
                                                                <input type="hidden" id="txtSaldoCupo" value="<?php echo $condicionPago['SaldoCupo'] ?>"/>  
                                                                <input type="text" placeholder="" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="hidden" value="0" id="cantidad-enviar"/>
                                                            <!--<button class="btn btn-primary enviarPedido" class="enviarPedido" style=" position: absolute;   right: 22px; height: 35px; width: 80px;">Enviar</button>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <ul class="pager wizard">
                                            <li class="previous"><a href="javascript:void(0)">Anterior</a></li>
                                            <li>
                                                <div id="bt"></div>
                                            </li>
                                            <li class="next"><a href="javascript:void(0)" style="position: absolute;  right: 22px; height: 35px; width: 83px; z-index: 2;">Siguiente</a></li>

                                        </ul>

                                    </form>

                                </div><!-- #validationWizard -->

                            </div><!-- panel-body -->
                        </div><!-- panel -->
                    </div><!-- col-md-6 -->
                </div>
            </div>
        </div>
    </div>      

</div>



<div class="modal fade" id="portafolio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">PORTAFOLIO</h4>
            </div>
            <div class="modal-body mdlPortafolio">

                <table class="table table-bordered" id="tblPortafolio">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th></th>                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*echo '<pre>';
                        print_r($portafolioZonaVentas);
                        exit();*/
                        $position = array();  
                        $newRow = array();
                        $inverse = false;
                        foreach ($portafolioZonaVentas as $key => $row) {
                          
                               
                                $position[$key]  = $row['SPDisponible'];  
                                 $position[$key]  = $row['ACPrecioVenta'];  
                                 //$position[$key] = $row['SaldoDisponibleVentaAutoventa'];
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
                        
                        $cont=1;
                        $anterior = "";
                        foreach ($portafolioPre as $itemPortafolio) {
                           ?>
                        
                        <?php
                         if($itemPortafolio['ACPrecioVenta']== ""){
                         ?>     
                          <tr class="btnAdicionarSinPrecio cursorpointer warning">  
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
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>
                        
                        <?php }elseif($itemPortafolio['ACPrecioVenta']!="" && $itemPortafolio['SPDisponible']!=""){ ?>
                        <tr class="btnAdicionarProductoDetalleAct cursorpointer"
                            
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
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"
                              
                              data-zona-ventas="<?php echo $zonaVentas;?>"
                              data-cliente="<?php echo $datosCliente['CuentaCliente']; ?>"
                              data-nuevo="0"
                            
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
                                </td>
                                 
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            
                            
                        </tr>
                        <?php }elseif($itemPortafolio['SPDisponible']!="" && $itemPortafolio['CodigoTipo']=="KV" && $itemPortafolio['kitActivo']=="1"){ ?>
                        
                         <tr class="btnAdicionarKitVirtual cursorpointer"
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
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"
                                 
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
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>   
                        
                       <?php
                         }elseif($itemPortafolio['SPDisponible']!="" && $itemPortafolio['CodigoTipo']=="KD" && $itemPortafolio['kitActivo']=="1"){
                        ?>
                        
                             <tr class="btnAdicionarKitDinamico cursorpointer"
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
                              data-SaldoDisponibleVenta ="<?php echo $itemPortafolio['SaldoDisponibleVentaAutoventa'] ?>"
                             
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
                                </td>
                                <td style="width: 10%;" class="text-center">
                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>   
                            
                            
                        <?php
                        }
                        $cont++;
                       }
?>
                    </tbody>


                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>       
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="alertaArticuloSinAcuerdo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo no cuenta con un acuerdo comercial!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="alertaArticuloSinSaldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo no cuenta un saldo disponible!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="alertaArticuloRestriccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje Articulo Portafolio</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error">El articulo se encuentra con una restrcción por el proveedor</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="articuloPedido" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><b>Código Variante:</b>&nbsp;<span id="textDetCodigoProducto" class="text-primary"></span><br> <span id="textDetNombreProducto"></span></h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="col-sm-4 control-label">Unidad de Medida:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetUnidadMedida"/> 

                        <input type="hidden" id="textCodigoVariante" />                 
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="txtCodigoArticulo"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textDetCodigoUnidadMedida"/> 
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textCodigoCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textZonaVentas" value="<?php echo $zonaVentas; ?>"/>
                        <input type="hidden" name="" readonly="readonly" class="form-control" id="textGrupoVentas" value=""/>
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Saldo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" class="form-control" id="textDetSaldo"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="hidden" name="txtLimiteVentasACDL" id="txtLimiteVentasACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtSaldoACDL" id="txtSaldoACDLSinConversion" readonly="readonly" class="form-control"/>

                        <input type="hidden" name="" id="txtIdAcuerdo" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="" id="txtIdSaldoInventario" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="" id="txtCodigoUnidadSaldoInventario" readonly="readonly" class="form-control"/>


                        <input type="hidden" name="txtCodigoUnidadMedidaACDL" id="txtCodigoUnidadMedidaACDL" readonly="readonly" class="form-control"/>                  
                        <input type="hidden" name="txtPorcentajeDescuentoLinea1ACDL" id="txtPorcentajeDescuentoLinea1ACDL" readonly="readonly" class="form-control"/>
                        <input type="hidden" name="txtPorcentajeDescuentoLinea2ACDL" id="txtPorcentajeDescuentoLinea2ACDL" readonly="readonly" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">IVA:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetIva" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Impoconsumo:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetImpoconsumo" class="form-control"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Valor del Producto:</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" readonly="readonly" id="textDetValorProductoMostrar" class="form-control"/>
                        <input type="hidden" name="name" readonly="readonly" id="textDetValorProducto" class="form-control"/>
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad Pedida:</label>
                    <div class="col-sm-6">
                        <input type="number" id="txtCantidadPedidaTransaccion" name="name" class="form-control"/>
                    </div>
                </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-adicionar-producto-consignacion">Adicionar</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="alertaErrorValidar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje transferencia consignación</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="alertaErrorValidar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje transferencia consignación</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>        
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="alertaEliminarCorrectamente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: red;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body">Producto eliminado correctamente de la transferencia</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                 <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Cerrar</button>
               </div>
        </div>
    </div>
</div>


 <div class="modal fade" id="_alertaKitinamico" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Altipal</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->




<div class="modal fade" id="mdlKitVirtual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10050;">
    
    <div id="contMdlKitVirtual">
                
    </div>
    
</div>

<div class="modal fade" id="mdlKitDinamico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 10050;">
    
    <div id="contMdlKitDinamico">
                
    </div>
    
</div>

<?php $this->renderPartial('//mensajes/_alertConfirmationMenu', array('zonaVentas' => $zonaVentas, 'cuentaCliente' => $datosCliente['CuentaCliente'])); ?>
<?php $this->renderPartial('//mensajes/_alertConfirmationTransConsignacion')?>
<?php $this->renderPartial('//mensajes/_alerta');?> 
<?php $this->renderPartial('//mensajes/_alertaRecargarPagina'); ?>

<script>

    $(document).ready(function() {

        $("#txtAreaObservaciones").keypress(function() {
            var limit = 50;
            var text = $(this).val();
            var chars = text.length;
            if (chars > limit) {
                var new_text = text.substr(0, limit);
                $(this).val(new_text);
            }
        });
    });

</script>