<div class="pageheader">
    <h2>
        <a style="text-decoration: none;" class="salirReporestResumenDia">
            <img src="images/home.png" class="cursorpointer" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        </a>
        Reportes Resumen Dia<span></span></h2>      
</div>
<input type="hidden" value="<?php echo $zonaVentas ?>" id="ZonaVentas">
<div class="contentpanel">
    <div class="panel-heading">
        <div class="widget widget-blue">

            <div class="widget-content">

                <div class="row">
                    <div class="col-md-4 col-md-offset-2 text-center">
                        <div class="form-group">
                            <label>Fecha Inicial</label>
                            <div  aling="center">
                                <input style="height: 36px;" type="text"  class="form-control fechareport" id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="form-group">
                            <label>Fecha Final</label>
                            <div>
                                <input style="height: 36px;" type="text"  class="form-control fechareport"  id='fechafin' value = "<?php echo date('Y-m-d') ?>"/>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="row">

                    <div class="col-md-2 text-center">
                        <a href="javascript:GenerarPedidosZona()">
                            <span class="cursorpointer">
                                <i class="fa fa-shopping-cart fa-5x"></i><br/>
                                <span class="text-primary  cursorpointer">Pedidos</span>
                            </span> 
                        </a> 
                    </div>
                    
                       <div class="col-md-2 text-center">
                           <a href="javascript:GenerarFacturasZona()">
                                <span class="cursorpointer">
                                    <i class="fa fa-barcode fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">Factura</span>
                                </span> 
                           </a> 
                        </div>

                    <div class="col-md-2 text-center">
                        <a href="javascript:GenerarDevolucionesZona()">
                            <span class=" cursorpointer">
                                <i class="fa fa-reply fa-5x"></i><br/>
                                <span class="text-primary  cursorpointer">Devoluciones</span>
                            </span> 
                        </a> 
                    </div>
                    
                    
                     <div class="col-md-2 text-center">
                            <a href="javascript:GenerarTransferenciaconsignacionZona()">
                                <span class=" cursorpointer">
                                    <i class="fa fa-refresh fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">Transferencia Consignación</span>
                                </span> 
                            </a> 
                        </div>
                    
                     <div class="col-md-2 text-center">
                            <a href="javascript:GenerarNoventasZona()">
                                <span class="cursorpointer">
                                    <i class="fa fa-minus-circle fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">No Ventas</span>
                                </span> 
                            </a> 
                     </div>


                    

                    <div class="col-md-2 text-center">
                        <a href="javascript:GenerarRecibosZona()">
                            <span class="cursorpointer">
                                <i class="fa fa-th-large fa-5x"></i><br/>
                                <span class="text-primary  cursorpointer">Recibos</span>
                            </span> 
                        </a> 
                    </div>

                   
                </div>
                
                <div class="row">
                    
                    <div class="col-md-2 text-center">
                        <a href="javascript:GenerarNotascreditoZona()">
                            <span class="cursorpointer">
                                <i class="fa fa-credit-card fa-5x"></i><br/>
                                <span class="text-primary  cursorpointer">Notas Credito</span>
                            </span> 
                        </a> 
                    </div>
                    
                    <div class="col-md-2 text-center">
                           <a href="#">
                                <span class="cursorpointer">
                                    <i class="fa fa-clipboard fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">Encuestas</span>
                                </span> 
                            </a> 
                    </div>
                    
                    
                    
                   <div class="col-md-2 text-center">
                        <a href="javascript:GenerarConsigVeendedorZona()">
                            <span class="cursorpointer">
                                <i class="fa fa-money fa-5x"></i><br/>
                                <span class="text-primary  cursorpointer">Consignación Vendedor</span>
                            </span> 
                        </a> 
                    </div>
                    
                    
                     <div class="col-md-2 text-center">
                           <a href="javascript:GenerarClientesnuevos()">
                                <span class="cursorpointer">
                                    <i class="fa fa-male fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">Clientes Nuevos</span>
                                </span> 
                            </a> 
                     </div>
                    
                     <div class="col-md-2 text-center">
                           <a href="javascript:GenerarTransferenciaAutoventa()">
                                <span class="cursorpointer">
                                    <i class="fa fa-exchange fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">Transferencia Autoventa</span>
                                </span> 
                            </a> 
                        </div>
                        
                        
                       <div class="col-md-2 text-center">
                           <a href="#">
                                <span class="cursorpointer">
                                    <i class="fa fa-clock-o fa-5x"></i><br/>
                                    <span class="text-primary  cursorpointer">Terminar Ruta</span>
                                </span> 
                            </a> 
                        </div>
                        
                    
                    
                </div>



            </div>


        </div>


    </div>

</div>
    
   <div align="center" style="display:none;" id="cargando">
       <div id="img-cargar"></div> 
   </div>
   <div id="reporteszona"></div>

 <?php $this->renderPartial('//mensajes/_alertSalirReportesResumenDia'); ?>
 <?php $this->renderPartial('//mensajes/_alerta'); ?>