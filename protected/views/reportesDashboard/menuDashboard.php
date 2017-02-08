<div class="pageheader">
    <h2>
        <a style="text-decoration: none;" class="salirReporestFuerzaVentas">
            <img src="images/home.png" class="cursorpointer" style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        </a>
        Reportes Dahsboard<span></span></h2>      
</div> 

<div class="contentpanel">

         

            <div class="panel-heading">


            <div class="widget widget-blue">


                <div class="widget-content">
                    
                    <div class="row">
                        <div class="text-center">
                        <label>Selecione un rango de fecha no mayor a un (1) mes:</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-2 text-center">
                            <div class="form-group">
                                <label>Fecha Inicial</label>
                                <div  aling="center">
                                    <input style="height: 36px;" type="text"  class="form-control" id="fechainiDahsboard" value = "<?php echo date('Y-m-d') ?>"/>
                                 </div>
                                
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label>Fecha Final</label>
                                <div>
                                    <input style="height: 36px;" type="text"  class="form-control"  id='fechafinDahsboard' value = "<?php echo date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                         
                    </div>
                    
                
                    <div class="row">
                        <div class="col-md-2 text-center">
                           <a href="javascript:notastramitadas()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Descuentos/Notas Tramitadas</span>
                                </span> 
                            </a> 
                        </div>
                        <div class="col-md-2 text-center">
                           <a href="javascript:notaspendientesporautrizar()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Notas Pendientes Por Autorizar</span>
                                </span> 
                            </a> 
                        </div>
                         <div class="col-md-2 text-center">
                           <a href="javascript:reportedevoluciones()">
                                <span class="cursorpointer">
                                    <img src="images/reportedevo.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Reporte Devoluciones</span>
                                </span> 
                            </a> 
                        </div>
                         <div class="col-md-2 text-center">
                           <a href="javascript:graficanotastramitadas()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Gráficas Notas</span>
                                </span> 
                            </a> 
                        </div>
                         <div class="col-md-2 text-center">
                           <a href="javascript:greficavalorgrupoventas()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Grupos Ventas Graficas</span>
                                </span> 
                            </a> 
                        </div>
                        
                        <div class="col-md-2 text-center">
                           <a href="javascript:descuentospendientes()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Descuentos Pendientes Por Autorizar</span>
                                </span> 
                            </a> 
                        </div>
                        

               </div>
                    
                    <div class="row">
                         <div class="col-md-2 text-center">
                           <a href="javascript:descuentosaprobadosporproveedor()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Descuentos aprobados Por Proveedor</span>
                                </span> 
                            </a> 
                        </div>
                        <div class="col-md-2 text-center">
                           <a href="javascript:descuentosaprobadosporcartera()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Notas Gestionadas por Cartera</span>
                                </span> 
                            </a> 
                        </div>
                        
                        <div class="col-md-2 text-center">
                           <a href="javascript:descuentostramitadosporcartera()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Descuentos Autorizados Por Fuera del Rango</span>
                                </span> 
                            </a> 
                        </div>
                        
                        <div class="col-md-2 text-center">
                           <a href="javascript:notascreditotimeaot()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Notas Asignadas Por TimeOut</span>
                                </span> 
                            </a> 
                        </div>
                        
                        <div class="col-md-2 text-center">
                           <a href="javascript:notasgestionadastimeaot()">
                                <span class="cursorpointer">
                                    <img src="images/nota_tramite.png" style="width: 55px"/><br/>
                                    <span class="text-primary  cursorpointer">Notas Gestionadas Por TimeOut</span>
                                </span> 
                            </a> 
                        </div>
                        
                     </div>
                  
                </div>
            </div>
         </div>
            
      
   </div>  
    

       


                                <div id="reportesDashboard"></div>
                                
<div class="modal fade" id="DetalleDevolcuiones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detalle Devoluciones</h4>
            </div>
            <div class="modal-body">

                 <div id="reportesDetalle"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>
                               
                                
                                
   <?php $this->renderPartial('//mensajes/_alerta'); ?>     
   <?php $this->renderPartial('//mensajes/_alertaCargando'); ?>                                