
<div class="pageheader">
    <h2><i class="fa fa-truck"></i> Opciones <span></span></h2>      
</div>



<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                
                <div class="col-md-1">
                     <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                </div>
                
                <div class="col-md-11">
                    <h5> Cuenta:  <span class="text-primary"><?php echo $datosCliente['CuentaCliente']; ?></span></h5>
                     <h5> Nombre: <span class="text-primary"><?php echo $datosCliente['NombreCliente']; ?></span></h5>
                </div>
                
            </div>
           
           

        </div>
        <div class="panel-body" style="min-height: 450px;">


            <div class="widget widget-blue">



                <div class="widget-content">
                    
                    <div class="mb30"></div>
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                            
                            <?php 
                            $busquedaPreventa=0;  
                            $busquedaAutoventa=0;
                            foreach ($sitiosVentas as $itemBusqueda){
                                if($itemBusqueda['Preventa']=='Verdadero'){
                                   $busquedaPreventa=1; 
                                }
                                if($itemBusqueda['Autoventa']=='Verdadero'){
                                   $busquedaAutoventa=1; 
                                }
                            }
                             
                            ?>
                            
                             <?php if($busquedaPreventa==1){ ?>  
                             
                                <span class="btn-cargar-pedido">
                                <img src="images/pedido.png " style="width: 55px"/><br/>
                                <span class="text-primary">Pedido</span>
                                </span>
                                                        
                            <?php }else{?>                             
                                <span class="">
                                <img src="images/nopedidos.png " style="width: 55px"/><br/>
                                <span class="text-primary">Pedido</span>
                                </span>                             
                             
                            <?php }?> 
                            
                        </div>
                        
                        
                        
                         <div class="col-md-2">                            
                           
                            <?php if($busquedaAutoventa==1){ ?>  
                             
                                <span class="btn-cargar-factura cursorpointer">
                                <img src="images/factura.png " style="width: 55px"/><br/>
                                <span class="text-primary">Factura</span>
                                </span>
                                                        
                            <?php }else{?>                             
                                <span class="">
                                <img src="images/nopedidos.png " style="width: 55px"/><br/>
                                <span class="text-primary">Factura</span>
                                </span>                             
                             
                            <?php }?> 
                            
                        </div>
                        
                        </div>
                    
                    <div class="mb20"></div>
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                             <?php 
                            $busquedaPreventa=0;  
                            $busquedaAutoventa=0;
                            foreach ($sitiosVentas as $itemBusqueda){
                                if($itemBusqueda['Preventa']=='Verdadero'){
                                   $busquedaPreventa=1; 
                                }
                                if($itemBusqueda['Autoventa']=='Verdadero'){
                                   $busquedaAutoventa=1; 
                                }
                            }
                             
                            ?>
                            
                           <?php if($busquedaPreventa==1){ ?>
                               <span class="btn-consignacion cursorpointer"> 
                             <img src="images/transconsig.png " style="width: 55px"/><br/>
                             <span class="text-primary">Transferencia  Consignacion</span>
                             </span>
                               <?php }else{?> 
                            <span class="cursorpointer">
                               <img src="images/transconsig.png" style="width: 55px"/><br/>
                             <span class="text-primary">Transferencia Consignacion</span>
                             </span>
                             
                            <?php }?>   
                             
                        </div>
                        
                        
                        <div class="col-md-2">
                            
                            
                                              
                             
                            
                        </div>
                    </div>
                    
                    <div class="mb20"></div>
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                            <span id="btn-devoluciones" class="cursorpointer">
                             <img src="images/devolucion_press.png " style="width: 55px"/><br/>
                             <span class="text-primary">Devoluciones</span>
                             </span>
                            
                        </div>
                        
                        
                        <div class="col-md-2">
                            
                            
                             <img src="images/novisita.png " style="width: 55px"/><br/>
                             <span class="text-primary">No Venta</span>                             
                             
                            
                        </div>
                    </div>
                       <div class="mb20"></div>  
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                            <a href="index.php?r=Recibos/index&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>">
                             <img src="images/recaudo.png " style="width: 55px"/><br/>
                             <span class="text-primary">Recibos</span>
                             </a>
                            
                        </div>
                        
                        
                        <div class="col-md-2">
                            
                            <a href="index.php?r=NotasCredito/index&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>">
                             <img src="images/notas_credito.png " style="width: 55px"/><br/>
                             <span class="text-primary">Notas credito</span>                             
                             </a>
                            
                        </div>
                    </div>
                    <div class="mb20"></div>

                     <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                            
                             <img src="images/report.png " style="width: 55px"/><br/>
                             <span class="text-primary">Reportes</span>
                             
                            
                        </div>
                        
                        
                        <div class="col-md-2">
                            
                           
                             <img src="images/satelite.png " style="width: 55px"/><br/>
                             <span class="text-primary">Localizacion</span>                             
                            
                            
                        </div>
                    </div>
                    
                     <div class="mb20"></div>

                     <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                            
                             <img src="images/portfolio.png " style="width: 55px"/><br/>
                             <span class="text-primary">Portafolio</span>
                            
                            
                        </div>
                        
                        
                        <div class="col-md-2">
                            
                           
                             <img src="images/ruta.png " style="width: 55px"/><br/>
                             <span class="text-primary">Encuestas</span>                             
                           
                            
                        </div>
                    </div>
                    
                      <div class="mb30"></div>
                      
                    
                </div>
            </div>



        </div>
    </div>      



</div>



<!-- Modal -->
<div class="modal fade" id="mdl-datos-cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px;">
        <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Datos Cupo cliente</h4>
      </div>
      <div class="modal-body">
          
          <div class="people-item" >
              <div class="media">
               
                <div class="media-body">
                  <h4 class="person-name"><?php echo $datosCliente['NombreBusqueda']; ?></h4>
                  
                  <div class="row">
                      <div class="col-md-6">
                           <div class="text-muted"> <b>Cuenta Cliente: </b><?php echo $datosCliente['CuentaCliente']; ?></div>
                            <div class="text-muted"> <b>Razón Social: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Contacto: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Dirección: </b><?php echo $datosCliente['DireccionEntrega']; ?></div>                  
                            <div class="text-muted"> <b>Teléfono: </b><?php echo $datosCliente['Telefono']; ?></div>
                            <div class="text-muted"> <b>Teléfono Móvil: </b><?php echo $datosCliente['TelefonoMovil']; ?></div>
                             <div class="text-muted"> <b>Forma Pago: </b><?php echo $datosCliente['CodigoFormadePago']; ?></div>
                      </div>
                      
                       <div class="col-md-6">
                          
                            <div class="text-muted"> <b>Tipo Negocio: </b><?php echo $datosCliente['Nombre']; ?></div>
                            <div class="text-muted"> <b>Cupo Total: </b><?php echo $datosCliente['ValorCupo']; ?></div>
                            <div class="text-muted"> <b>Cupo Disponible: </b><?php echo $datosCliente['SaldoCupo']; ?></div>
                            <div class="text-muted"> <b>Cupo Temporal: </b><?php echo $datosCliente['ValorCupoTemporal']; ?></div>
                            
                            <div class="mb10"></div>
                            <button class="btn btn-primary" id="btn-asesores-comerciales">Asesores comerciales &nbsp;&nbsp; <span class="fa fa-user-md"></span> </button>
                            
                      </div>
                      
                  </div>
                
                </div>
                  
                  
                  
              </div>
            </div>
            
            <?php 
            $facturaSaldo=  Consultas::model()-> getSaldoFacturaCliente($datosCliente['CuentaCliente']);
            
          
            
            $facturaSaldo=$facturaSaldo['SaldoFactura'];
                        
            $facturaSaldoAsesor=  Consultas::model()-> getSaldoFacturaClienteAsesor($datosCliente['CuentaCliente'], $zonaVentas);
            //$facturaSaldoAsesor=$facturaSaldoAsesor['SaldoFactura'];
            
          
            $facturaCarteraVencida= Consultas::model()->getSaldoFacturaCarteraVencida($datosCliente['CuentaCliente']);
            $carteraVencida=$facturaCarteraVencida['SaldoFactura'];
            $cantidadVencida=$facturaCarteraVencida['Total'];
            
            ?>
          
          <div class="table-responsive">
          <table class="table table-bordered mb30">
            
            <tbody>
              <tr>
                <td>Cartera Total:</td>
                <td><?php echo '$'.number_format($facturaSaldo); ?></td>               
             
                <td>Cartera Vendedor:</td>
                <td><?php echo '$'.number_format($facturaSaldoAsesor); ?></td>               
              </tr>
              
                <tr>
                <td>Cartera Vencida:</td>
                <td><?php echo '$'.number_format($carteraVencida); ?></td>               
            
                <td>Facturas Vencidas Totales:</td>
                <td><?php echo $cantidadVencida; ?></td>               
              </tr>             
            
            </tbody>
          </table>
          </div>
          
          <div class="table-responsive" style="overflow-x: scroll; overflow-y: scroll; height: 170px;">
              
          <?php 
           $facturasCliente=  Consultas::model()->getFacturasCliente($datosCliente['CuentaCliente']);
          ?>
              
          <table class="table table-bordered mb30">
            <thead>
              <tr>
                <th></th>
                <th>Factura</th>
                <th>Valor Neto</th>
                <th>Saldo</th>
                <th>Fecha</th>                
                <th>Días a vencer</th>
                <th>Días mora</th>
                <th>Días PP1</th>
                <th>Días PP2</th>
                <th style="width: 45px;">Zona ventas</th>
                <th>Asesor Comercial</th>
                <th>Grupo ventas</th>
                <th>Teléfono Movil</th>
                
              </tr>
            </thead>
            <tbody>
                
             <?php              
             if($facturasCliente){
                 foreach ($facturasCliente as $itemFacturas){ 
               ?>
                
                <tr>
                    <td> <span class="glyphicon glyphicon-new-window" style="color: #028AF3" id="detalleSaldo-<?php echo $itemFacturas['NumeroFactura'] ?>" ></span><br> </td>  
                            <td><?php echo $itemFacturas['NumeroFactura'] ?></td>
                            <td><?php echo '$' . number_format($itemFacturas['ValorNetoFactura']) ?></td>
                            <td><?php echo '$' . number_format($itemFacturas['SaldoFactura']) ?></td>
                            <td><?php echo $itemFacturas['FechaFactura'] ?></td>
                            <?php                            
                            if($itemFacturas['FechaVencimientoFactura']<=  date('Y-m-d')){
                                $diasVencer='0';
                                $diasMora=Yii::app()->controller->diff_dte( date('Y-m-d'),$itemFacturas['FechaVencimientoFactura'] );
                            }else{
                                $diasVencer= Yii::app()->controller->diff_dte(date('Y-m-d'), $itemFacturas['FechaVencimientoFactura'] );                             
                                $diasMora='0';
                            }
                            ?>
                            
                            
                            <td> <?php echo $diasVencer;?></td>
                            <td><?php echo  $diasMora;?></td>
                            
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel1'] ); ?></td>
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel2'] ); ?></td>
                          
                            
                            <td><?php echo $itemFacturas['NombreZonadeVentas'].' - '.$itemFacturas['CodZonaVentas'] ?></td>
                            <td><?php echo $itemFacturas['NombreAsesorComercial'] ?></td>
                            <td><?php echo $itemFacturas['NombreGrupoVentas'] ?></td>
                            <td><?php echo $itemFacturas['AsesorTelefonoMovil'] ?></td>

                        </tr>
                
              <?php  
              }
             }else{
              ?>
                
             <?php   
             }
             ?>   
                
             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
          
        <?php 
        
        $valorFacturas=0;
        foreach ($facturasCliente as $item){
            if($item['Total']==NULL){
               $valorFacturas-=1; 
            }else{
               $valorFacturas+=$item['Total']; 
            }
            
        } 
        
     
        
         if($valorFacturas!=0){
            ?>
             
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="factutas-pendientes">Aceptar</button>
          
            <?php 
         }else{             
             ?>
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
           <a href="index.php?r=Pedido/CrearPedido&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>" class="btn btn-primary">Aceptar</a>
           
          <?php             
         }        
        ?>
       
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



<!-- Modal -->
<div class="modal fade" id="mdl-datos-cliente-autoventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px;">
        <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Datos Cupo cliente</h4>
      </div>
      <div class="modal-body">
          
          <div class="people-item" >
              <div class="media">
               
                <div class="media-body">
                  <h4 class="person-name"><?php echo $datosCliente['NombreBusqueda']; ?></h4>
                  
                  <div class="row">
                      <div class="col-md-6">
                           <div class="text-muted"> <b>Cuenta Cliente: </b><?php echo $datosCliente['CuentaCliente']; ?></div>
                            <div class="text-muted"> <b>Razón Social: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Contacto: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Dirección: </b><?php echo $datosCliente['DireccionEntrega']; ?></div>                  
                            <div class="text-muted"> <b>Teléfono: </b><?php echo $datosCliente['Telefono']; ?></div>
                            <div class="text-muted"> <b>Teléfono Móvil: </b><?php echo $datosCliente['TelefonoMovil']; ?></div>
                             <div class="text-muted"> <b>Forma Pago: </b><?php echo $datosCliente['CodigoFormadePago']; ?></div>
                      </div>
                      
                       <div class="col-md-6">
                          
                            <div class="text-muted"> <b>Tipo Negocio: </b><?php echo $datosCliente['Nombre']; ?></div>
                            <div class="text-muted"> <b>Cupo Total: </b><?php echo $datosCliente['ValorCupo']; ?></div>
                            <div class="text-muted"> <b>Cupo Disponible: </b><?php echo $datosCliente['SaldoCupo']; ?></div>
                            <div class="text-muted"> <b>Cupo Temporal: </b><?php echo $datosCliente['ValorCupoTemporal']; ?></div>
                            
                            <div class="mb10"></div>
                            <button class="btn btn-primary" id="btn-asesores-comerciales">Asesores comerciales &nbsp;&nbsp; <span class="fa fa-user-md"></span> </button>
                            
                      </div>
                      
                  </div>
                
                </div>
                  
                  
                  
              </div>
            </div>
            
            <?php 
            $facturaSaldo=  Consultas::model()-> getSaldoFacturaCliente($datosCliente['CuentaCliente']);
            
          
            
            $facturaSaldo=$facturaSaldo['SaldoFactura'];
                        
            $facturaSaldoAsesor=  Consultas::model()-> getSaldoFacturaClienteAsesor($datosCliente['CuentaCliente'], $zonaVentas);
            //$facturaSaldoAsesor=$facturaSaldoAsesor['SaldoFactura'];
            
          
            $facturaCarteraVencida= Consultas::model()->getSaldoFacturaCarteraVencida($datosCliente['CuentaCliente']);
            $carteraVencida=$facturaCarteraVencida['SaldoFactura'];
            $cantidadVencida=$facturaCarteraVencida['Total'];
            
            ?>
          
          <div class="table-responsive">
          <table class="table table-bordered mb30">
            
            <tbody>
              <tr>
                <td>Cartera Total:</td>
                <td><?php echo '$'.number_format($facturaSaldo); ?></td>               
             
                <td>Cartera Vendedor:</td>
                <td><?php echo '$'.number_format($facturaSaldoAsesor); ?></td>               
              </tr>
              
                <tr>
                <td>Cartera Vencida:</td>
                <td><?php echo '$'.number_format($carteraVencida); ?></td>               
            
                <td>Facturas Vencidas Totales:</td>
                <td><?php echo $cantidadVencida; ?></td>               
              </tr>             
            
            </tbody>
          </table>
          </div>
          
          <div class="table-responsive" style="overflow-x: scroll; overflow-y: scroll; height: 170px;">
              
          <?php 
           $facturasCliente=  Consultas::model()->getFacturasCliente($datosCliente['CuentaCliente']);
          ?>
              
          <table class="table table-bordered mb30">
            <thead>
              <tr>
                <th></th>
                <th>Factura</th>
                <th>Valor Neto</th>
                <th>Saldo</th>
                <th>Fecha</th>                
                <th>Días a vencer</th>
                <th>Días mora</th>
                <th>Días PP1</th>
                <th>Días PP2</th>
                <th style="width: 45px;">Zona ventas</th>
                <th>Asesor Comercial</th>
                <th>Grupo ventas</th>
                <th>Teléfono Movil</th>
                
              </tr>
            </thead>
            <tbody>
                
             <?php              
             if($facturasCliente){
                 foreach ($facturasCliente as $itemFacturas){ 
               ?>
                
                <tr>
                    <td> <span class="glyphicon glyphicon-new-window" style="color: #028AF3" id="detalleSaldo-<?php echo $itemFacturas['NumeroFactura'] ?>" ></span><br> </td>  
                            <td><?php echo $itemFacturas['NumeroFactura'] ?></td>
                            <td><?php echo '$' . number_format($itemFacturas['ValorNetoFactura']) ?></td>
                            <td><?php echo '$' . number_format($itemFacturas['SaldoFactura']) ?></td>
                            <td><?php echo $itemFacturas['FechaFactura'] ?></td>
                            <?php                            
                            if($itemFacturas['FechaVencimientoFactura']<=  date('Y-m-d')){
                                $diasVencer='0';
                                $diasMora=Yii::app()->controller->diff_dte( date('Y-m-d'),$itemFacturas['FechaVencimientoFactura'] );
                            }else{
                                $diasVencer= Yii::app()->controller->diff_dte(date('Y-m-d'), $itemFacturas['FechaVencimientoFactura'] );                             
                                $diasMora='0';
                            }
                            ?>
                            
                            
                            <td> <?php echo $diasVencer;?></td>
                            <td><?php echo  $diasMora;?></td>
                            
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel1'] ); ?></td>
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel2'] ); ?></td>
                          
                            
                            <td><?php echo $itemFacturas['NombreZonadeVentas'].' - '.$itemFacturas['CodZonaVentas'] ?></td>
                            <td><?php echo $itemFacturas['NombreAsesorComercial'] ?></td>
                            <td><?php echo $itemFacturas['NombreGrupoVentas'] ?></td>
                            <td><?php echo $itemFacturas['AsesorTelefonoMovil'] ?></td>

                        </tr>
                
              <?php  
              }
             }else{
              ?>
                
             <?php   
             }
             ?>   
                
             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
          
        <?php 
        
        $valorFacturas=0;
        foreach ($facturasCliente as $item){
            if($item['Total']==NULL){
               $valorFacturas-=1; 
            }else{
               $valorFacturas+=$item['Total']; 
            }
            
        } 
        
     
        
         if($valorFacturas!=0){
            ?>
             
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="factutas-pendientes">Aceptar</button>
          
            <?php 
         }else{             
             ?>
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
           <a href="index.php?r=Autoventa/CrearPedido&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>" class="btn btn-primary">Aceptar</a>
           
          <?php             
         }        
        ?>
       
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



<?php
if ($facturasCliente) {
    
    
    
    foreach ($facturasCliente as $itemFacturas) {
   
        $detalleFactura=  Consultas::model()->getFacturaDetalleCliente($itemFacturas['NumeroFactura']);     
        if(count($detalleFactura)>0){            
          ?>
            
                  <!-- Modal -->
<div class="modal fade" id="facturaCliente-<?php echo $itemFacturas['NumeroFactura']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Factura: <?php echo $itemFacturas['NumeroFactura'];?></h4>
      </div>
      <div class="modal-body">
        
          <div class="table-responsive">
          <table class="table table-striped mb30">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Código</th>
                <th>Concepto</th>
                <th>Valor</th>
              </tr>
            </thead>
            <tbody>
                
                <?php 
                if($detalleFactura){
                    foreach ($detalleFactura as $itemDetalle){                   
                 ?>
                    
                  <tr>                    
                    <td><?php echo $itemDetalle['NombreDocumento']; ?></td>
                    <td><?php echo $itemDetalle['NumeroDocumento']; ?></td>
                    <td><?php echo $itemDetalle['NombreConcepto']; ?></td>
                    <td><?php echo $itemDetalle['ValorDocumento']; ?></td>
                  </tr>
                
                <?php  
                  }  
                }                
                ?>
                
             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


         <?php   
        }else{
            ?>
            
            <!-- Modal -->
        <div class="modal fade" id="facturaCliente-<?php echo $itemFacturas['NumeroFactura']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
            <div class="modal-dialog modal-dialog-message">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="myModalLabel">Mensaje Facturas</h5>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-sm-2">  
                                <span class="glyphicon glyphicon-exclamation-sign" style="font-size: 40px; color: #F0AD4E;"></span>
                            </div>
                            <div class="col-sm-10">
                                <p class="text-modal-body">No existen transacciones relacionadas con la factura: <?php echo $itemFacturas['NumeroFactura'];?></p>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">         	
                        <button type="button" class="btn btn btn-small-template" data-dismiss="modal">Cerrar</button>  
                        
                    </div>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->  

        <?php    
        }
        ?>
        <?php
    }
}
?>


<!-- Modal -->
<div class="modal fade" id="asesoresComerciales" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Asesores Comerciales</h4>
      </div>
      <div class="modal-body">
       
          <?php            
           $asesoresRelacionados=  Consultas::model()->getAsesoresCliente($datosCliente['CuentaCliente']);          
          ?>
          
          <div class="table-responsive">
          <table class="table table-bordered mb30">
            <thead>
              <tr>
                <th>Zona ventas</th>
                <th>Nombre Asesor</th>               
              </tr>
            </thead>
            <tbody>             
              <?php 
                 foreach ($asesoresRelacionados as $itemAsesores){
                ?>    
                     <tr>
                        <td><?php echo $itemAsesores['NombreZonadeVentas'].' - '.$itemAsesores['CodZonaVentas'];?></td>
                        <td><?php echo $itemAsesores['Nombre'];?></td>                        
                      </tr> 
                <?php     
                  }
              ?>             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



<!-- Modal -->
<div class="modal fade" id="sitiosAlmacen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
       <form id="sitiosPreventa" action="" method="post">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sitios de Venta</h4>
      </div>
      <div class="modal-body">
                
            <div class="form-group">
                        <label class="col-sm-4 control-label">Sitio</label>
                        <div class="col-sm-8">                         
                            <select name="sitio" class="form-control" required id="select-sitio" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>"/>
                            <option value>Seleccione un sitio</option>
                                
                             <?php 
                               if($sitiosVentas){                                  
                                   
                                   foreach ($sitiosVentas as $itemSitio){   
                                       if($itemSitio['Preventa']=="Verdadero"){
                               ?>    
                            <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> -- <?php echo $itemSitio['NombreAlmacen'];?></option>
                              
                            <?php 
                                  }
                                }
                               }
                             ?>      
                          </select>
                          
                            <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Preventa" id="select-sitio-venta"/>   
                            
                        </div>
                      </div>                      
                      
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Continuar</button>-->
        <input type="submit" class="btn btn-primary "value="Continuar" />
      </div>        
    </div><!-- modal-content -->
    </form>
  </div><!-- modal-dialog -->
</div><!-- modal -->



<div class="modal fade" id="sitiosAlmacenAutoventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
       <form id="sitiosAutoventa" action="" method="post">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sitios de Venta Autoventa</h4>
      </div>
      <div class="modal-body">                
         
            <div class="form-group">
                        <label class="col-sm-4 control-label">Sitio</label>
                        <div class="col-sm-8">                         
                            <select name="sitio" class="form-control" required id="select-sitio-autoventa" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>"/>
                            <option value>Seleccione un sitio</option>
                                
                             <?php 
                                                      
                             
                               if($sitiosVentas){                                  
                                   
                                   foreach ($sitiosVentas as $itemSitio){   
                                       if($itemSitio['Autoventa']=="Verdadero"){
                               ?>    
                            <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> -- <?php echo $itemSitio['NombreAlmacen'];?></option>
                              
                            <?php 
                                  }
                                }
                               }
                             ?>      
                          </select>
                          
                            <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Autoventa" id="select-sitio-venta-autoventa"/>   
                            
                        </div>
                      </div>                      
                      
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Continuar</button>-->
        <input type="submit" class="btn btn-primary "value="Continuar" />
      </div>        
    </div><!-- modal-content -->
    </form>
  </div><!-- modal-dialog -->
</div><!-- modal -->




<div class="modal fade" id="sitiosAlmacenConsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
       <form id="basicFormConsignacion" action="" method="post">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sitios de Venta</h4>
      </div>
      <div class="modal-body">
                
            <div class="form-group">
                        <label class="col-sm-4 control-label">Sitio</label>
                        <div class="col-sm-8">                         
                            <select name="sitio" class="form-control" required id="select-sitioConsignacion" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>">
                            <option value="">Seleccione un sitio</option>
                                
                             <?php 
                               if($sitiosVentas){                                  
                                   
                                   foreach ($sitiosVentas as $itemSitio){   
                                       if($itemSitio['Preventa']=="Verdadero"){
                               ?>    
                            
                            <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> -- <?php echo $itemSitio['NombreAlmacen'];?></option>
                              
                            <?php 
                                  }
                                }
                               }
                             ?>      
                          </select>
                          
                            <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Preventa" id="select-sitio-venta"/>   
                            
                        </div>
                      </div>                      
                      
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Continuar</button>-->
        <input type="button" class="btn btn-primary "value="Continuar" id="consignaciones" data-clie="<?php echo  $datosCliente['CuentaCliente'] ?>" data-zona="<?php echo $zonaVentas ?>"/>
      </div>        
    </div><!-- modal-content -->
    </form>
  </div><!-- modal-dialog -->
</div><!-- modal -->






<style>
    
    .btn-cargar-pedido{
        cursor: pointer;
    }
    
</style>

<script>

$( document ).ready(function() {

<?php
if ($facturasCliente) {
    foreach ($facturasCliente as $itemFacturas) {
        ?>         
         $('#detalleSaldo-<?php echo $itemFacturas['NumeroFactura']?>').click(function(){
             $('#facturaCliente-<?php echo $itemFacturas['NumeroFactura']?>').modal('show');
         });
      <?php
    }
}
?>  
        
        
$('#btn-asesores-comerciales').click(function(){
    $('#asesoresComerciales').modal('show');
});        
        

$('#factutas-pendientes').click(function(){
     $('#alertaFacturasPendientes #mensaje-error').html('El cliente posee facturas');
    $('#alertaFacturasPendientes').modal('show');
});


});

</script>
    

   <div class="modal fade" id="alertaFacturasPendientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Facturas</h5>
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
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


   <div class="modal fade" id="alertaCarteraPendiente" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Recaudos</h5>
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
                <button type="button" class="btn btn-primary btn-small-template" id="btnRecibosCaja">OK</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->





<div class="modal fade" id="alertaFrmRecibosCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Recibos de caja</h5>
            </div>
            <div class="modal-body">
                <div class="row">                   
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Código Cliente</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" readonly="readonly" class="form-control" value="<?php echo $datosCliente['CuentaCliente'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Razón Social</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly"class="form-control" value="<?php echo $datosCliente['NombreBusqueda'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contacto</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['NombreCliente'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dirección</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['DireccionEntrega'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Teléfono</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['Telefono'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Forma de Pago</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['CodigoFormadePago'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo Negocio</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['Nombre'];?>">
                            </div>
                          </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                  <div class="form-group">
                            <label class="col-sm-3 col-sm-offset-2 control-label">Recaudar Factura:</label>
                            <div class="col-sm-2">
                              <div class="">
                                 <label>Si</label>
                                
                                 <a href="index.php?r=Recibos/index&cliente=<?php echo $datosCliente['CuentaCliente']; ?>&zonaVentas=<?php echo $zonaVentas;?>"> <input type="radio" name="radio" value="2" id="" ></a>
                              </div>
                            </div>
                            
                             <div class="col-sm-2">
                              <div class="">
                                
                               <label>No</label>
                                <input type="radio" name="radio" value="2" id="recaudarFacturaNo">
                                 
                              </div>
                            </div>
                            
                          </div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->




<div class="modal fade" id="alertaFrmRecibosCajaNo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">NO RECAUDO DE FACTURA</h5>
            </div>
            
            <form  action="" id="frmNoRecaudos" method="post">
            <div class="modal-body">
                <div class="row">                   
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-sm-6">
                                <input name="noRecaudos[Fecha]" id="FechaNoRecaudo" type="text" placeholder="" id="" required class="form-control" readonly="readonly" value="<?php echo date('Y-m-d');?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha Próxima Visita</label>
                            <div class="col-sm-6">
                              <input name="noRecaudos[FechaProximaVisita]" id="FechaProximaVisita" type="text" placeholder="" id="datepicker" required  class="form-control datepicker"  value="">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 required control-label">Motivo</label>
                            <div class="col-sm-6">
                             
                              <select class="form-control" name="noRecaudos[Motivo]">
                                  <?php foreach ($motivosgestiondecobros as $item):?>                                  
                                  <option value="<?php echo $item['CodMotivoGestion'];?>"> <?php echo $item['Nombre'];?></option>
                                  <?php endforeach;?>
                              </select>
                            </div>
                          </div>
                        
                          <div class="form-group">
                            <label class="col-sm-3  control-label">Observación</label>
                            <div class="col-sm-6">
                                <textarea required name="noRecaudos[Observaciones]" class="col-sm-12 txtAreaObservaciones" placeholder="Máximo 50 caracteres"></textarea>
                            </div>
                          </div>
                        
                       
                    </div>
                </div>

            </div>
                
           
            <div class="modal-footer">
                  <div class="form-group">
                            
                             <div class="col-sm-12">
                                 
                                <button class="btn btn-primary">Guardar</button>
                                <a class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                 
                             
                            </div>
                            
                          </div>
            </div>
          </form>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->







<?php 


$cantidad=0;
foreach ($recibosvsfacturas as $item){   
    if($item['SaldoFactura'] > $item['Total']){
        $cantidad++;
    }
}

 if($facturasCliente){
     
     $debeCartera=FALSE;
                 foreach ($facturasCliente as $itemFacturas){ 
                                          
                            if($itemFacturas['FechaVencimientoFactura']<=  date('Y-m-d')){
                                $debeCartera=TRUE;
                                $diasMora=Yii::app()->controller->diff_dte( date('Y-m-d'),$itemFacturas['FechaVencimientoFactura'] );
                            }
        }
  }
        
     
$totalNoRecaudos=  count($noRecaudos);          
 if($debeCartera && $totalNoRecaudos==0 && $cantidad>0){
    ?>
     
<script>

$( document ).ready(function() {   
   $('#alertaCarteraPendiente #mensaje-error').html('Recuerde que este cliente presenta cartera vencida, por favor hacer la gestion de cobro, de lo contrario no le permitita terminar ruta    '); 
   $('#alertaCarteraPendiente').modal('show');   
});
</script>


<?php 
 }       
        

?>
