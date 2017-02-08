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

                    <div class="col-md-1 text-center">
                        <a href="javascript:pedidos()">
                            <span class="cursorpointer">
                                <img src="images/pedido_preventa.png" style="width: 55px"/><br/>
                                <span class="text-primary  cursorpointer">Pedidos</span>
                            </span> 
                        </a> 
                    </div>

                    <div class="col-md-3 text-center">
                        <a href="javascript:devoluciones()">
                            <span class=" cursorpointer">
                                <img src="images/devolu.png" style="width: 55px"/><br/>
                                <span class="text-primary  cursorpointer">Devoluciones</span>
                            </span> 
                        </a> 
                    </div>

                    <div class="col-md-3 text-center">
                        <a href="javascript:Notascredito()">
                            <span class="cursorpointer">
                                <img src="images/notas_credito.png" style="width: 55px"/><br/>
                                <span class="text-primary  cursorpointer">Notas Credito</span>
                            </span> 
                        </a> 
                    </div>

                    <div class="col-md-3 text-center">
                        <a href="javascript:recibos()">
                            <span class="cursorpointer">
                                <img src="images/recaudo.png" style="width: 55px"/><br/>
                                <span class="text-primary  cursorpointer">Recibos</span>
                            </span> 
                        </a> 
                    </div>

                    <div class="col-md-2 text-center">
                        <a href="javascript:GenerarConsigVeendedorZona()">
                            <span class="cursorpointer">
                                <img src="images/check.png" style="width: 55px"/><br/>
                                <span class="text-primary  cursorpointer">Consignación Vendedor</span>
                            </span> 
                        </a> 
                    </div>


                </div>



            </div>


        </div>


    </div>

</div>

 <?php $this->renderPartial('//mensajes/_alertSalirReportesResumenDia'); ?>