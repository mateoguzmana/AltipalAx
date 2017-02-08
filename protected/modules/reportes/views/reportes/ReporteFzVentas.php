<div class="pageheader">
    <h2>
        <a style="text-decoration: none;" class="salirReporestFuerzaVentas">
            <img src="images/home.png" class="cursorpointer" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        </a>
        Reportes<span></span>Fuerza Ventas</h2>      
</div> 


 <div class="contentpanel" style="margin-bottom: -8px;">

            <div class="panel-heading">

            <div class="widget widget-blue">

                <div class="widget-content">
                  <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group text-center">
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
                         
                         <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label>Agencias</label>
                                <div>
                                    <select id="agencia" name="Agencia" class="form-control chosen-select" data-placeholder="Seleccione una agencia">
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
                   </div>

                    <div class="row">
                        <div class="col-md-2 text-center">
                           <a href="javascript:pedidos()">
                                <span class="cursorpointer">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Pedidos</span>
                                </span> 
                            </a> 
                        </div>

                        <div class="col-md-2 text-center">
                           <a href="javascript:facturas()">
                                <span class="cursorpointer">
                                    <i class="fa fa-barcode fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Factura</span>
                                </span> 
                           </a> 
                        </div>

                        <div class="col-md-2 text-center">
                            <a href="javascript:devoluciones()">
                                <span class=" cursorpointer">
                                    <i class="fa fa-reply fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Devoluciones</span>
                                </span> 
                            </a> 
                        </div>


                        <div class="col-md-2 text-center">
                            <a href="javascript:transferenciaconsignacion()">
                                <span class=" cursorpointer">
                                    <i class="fa fa-refresh fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Transferencia Consignación</span>
                                </span> 
                            </a> 
                        </div>

                        <div class="col-md-2 text-center">
                            <a href="javascript:noventas()">
                                <span class="cursorpointer">
                                    <i class="fa fa-minus-circle fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">No Ventas</span>
                                </span> 
                            </a> 
                        </div>


                        <div class="col-md-2 text-center">
                            <a href="javascript:recibos()">
                                <span class="cursorpointer">
                                    <i class="fa fa-th-large fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Recibos de Caja</span>
                                </span> 
                            </a> 
                        </div>
            </div>
                    
                    <div class="row">
                        
                          <div class="col-md-2 text-center">
                            <a href="javascript:Notascredito()">
                                <span class="cursorpointer">
                                    <i class="fa fa-credit-card fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Notas Credito</span>
                                </span> 
                            </a> 
                        </div>
                        
                        <div class="col-md-2 text-center">
                           <a href="#">
                                <span class="cursorpointer">
                                    <i class="fa fa-clipboard fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Encuestas</span>
                                </span> 
                            </a> 
                        </div>
                        
                        
                       <div class="col-md-2 text-center">
                           <a href="javascript:consignacionvendedor()">
                                <span class="cursorpointer">
                                    <i class="fa fa-money fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Consignación Vendedor</span>
                                </span> 
                            </a> 
                        </div>
                        
                       <div class="col-md-2 text-center">
                           <a href="javascript:clientesnuevos()">
                                <span class="cursorpointer">
                                    <i class="fa fa-male fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Clientes Nuevos</span>
                                </span> 
                            </a> 
                        </div>
                        
                       <div class="col-md-2 text-center">
                           <a href="javascript:transferenciaautoventa()">
                                <span class="cursorpointer">
                                    <i class="fa fa-exchange fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Transferencia Autoventa</span>
                                </span> 
                            </a> 
                        </div>
                        
                        
                       <div class="col-md-2 text-center">
                           <a href="javascript:terminarruta()">
                                <span class="cursorpointer">
                                    <i class="fa fa-clock-o fa-5x"></i>
                                    <br/>
                                    <span class="text-primary  cursorpointer">Terminar Ruta</span>
                                </span> 
                            </a> 
                        </div>
                        
                        
                        
                    </div>
                      <br>
                  </div>
                </div>
            </div>
         </div>
            
      
   </div>  
<style>
    .col-md-2 a{
        text-decoration: none;
         color: #24D29B
    }
    
     .col-md-2 a:hover{
        color: rgba(29, 156, 115, 1);
    }
    
    a span .text-primary{
        font-size: 0.85em;
        text-decoration: none;
        font-weight: 100;
        color: black;
        letter-spacing: 1px;
    }
    .col-md-2{
        margin-top: 18px;
    }
</style>

       


                                <div id="reportes"></div> 
                                
                                 
          <?php $this->renderPartial('//mensajes/_alerta'); ?>  
          <?php $this->renderPartial('//mensajes/_alertSalirReportesFuerzaVentas'); ?>                          
                                

<script>

  
</script>



