
<?php $zonaVentas = Yii::app()->user->getState('_zonaVentas'); ?>


<div class="modal fade" id="alertaMensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color:orange ;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
<?php if (count($MensajesTransferencia) > 0): foreach ($MensajesTransferencia as $itemTrans): ?>

            $(document).ready(function () {
                $('#alertaMensaje #mensaje').html('<?php echo $itemTrans['Mensaje'] ?>');
                $('#alertaMensaje').modal('show');

            });


    <?php endforeach;
endif; ?>
</script>



<div class="pageheader">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <h2><i class="fa fa-truck"></i> Fuerza de Ventas<span></span></h2>
            </div> 
            <div class="text-right">
                <div class="col-md-9">
                    SOPORTE<img src="images/support.png" style="width: 30px" class="cursorpointer informacionactivity"/><br/>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 450px;">


            <div class="widget widget-blue">


                <div class="widget-content text-center">
                    <div class="container-fluid">
                        <div class="row">

                            <?php
                            /* if(Yii::app()->user->hasState('_Agencia' ))
                              echo $agencia = Yii::app()->user->getState('_Agencia'); */
                            ?>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"> 
                                <a href="index.php?r=Clientes/Rutas">
                                    <span class="">
                                        <img src="images/client.png" style="width: 55px"/><br/>
                                        <span class="text-primary">Clientes</span>
                                    </span> 
                                </a>  
                            </div>

                            <div class="col-md-3">  
                                <a href="index.php?r=reportes/ResumenDia/Menu">                
                                    <span class="">
                                        <img src="images/resumen_del_dia.png " style="width: 55px"/><br/>
                                        <span class="text-primary">Resumen Día</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="mb20"></div>
                        <div class="row">      
                            <div class="col-md-3"></div>
                            <div class="col-md-3">  
                                <span class="">
                                    <img src="images/message.png " style="width: 55px"/><br/>
                                    <span class="text-primary">Mensajes</span>
                                </span>                             
                            </div>
                            <!-- <div class="col-md-3">  
                                 <span class="">
                                     <img src="images/sincronizar.png " style="width: 55px"/><br/>
                                     <span class="text-primary">Transmición de Documentos</span>
                                 </span>                             
                             </div>-->

                            <div class="col-md-3">  
                                <a href="index.php?r=ConsignacionesVendedor/index&zonaVentas=<?php echo $zonaVentas; ?>">
                                    <span class="">
                                        <img src="images/check.png " style="width: 55px"/><br/>
                                        <span class="text-primary">Consignaciones Vendedor</span>
                                    </span>
                                </a>                             
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="mb20"></div>
                        <div class="row">                        
                            <div class="col-md-3"></div>
                            <div class="col-md-3">  
                                <a href="index.php?r=Rutero/Index">                 
                                    <span class="">
                                        <img src="images/report.png " style="width: 55px"/><br/>
                                        <span class="text-primary">Reportes</span>
                                    </span> 
                                </a>    
                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="mb20"></div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"> 
                                <?php
                                $TransferenciasHechas = Transferenciaautoventa::model()->getTransfereciasAutoventasSinAceptar($zonaVentas);
                                if (count($TransferenciasHechas) > 0) {
                                    ?>
                                    <a href="javascript:transferenciaspedientes()">              
                                        <span class="">
                                            <img src="images/terminar_ru.png " style="width: 55px"/><br/>
                                            <span class="text-primary">Terminar Ruta</span>
                                        </span> 
                                    </a>    

<?php } else { ?>
                                    <a href="javascript:terminarruta(<?php echo $zonaVentas ?>)">              
                                        <span class="">
                                            <img src="images/terminar_ru.png " style="width: 55px"/><br/>
                                            <span class="text-primary">Terminar Ruta</span>
                                        </span> 
                                    </a>    
                                    <div id="informationterminarruta"></div> 
<?php } ?> 
                            </div>

                            <div class="col-md-3">  
                                <?php
                                $zona = Consultas::model()->getZonaventasverdadero($zonaVentas);


                                if ($zona['Transferencia'] == 'verdadero') {
                                    ?> 

                                    <a href="index.php?r=TransferenciaAutoventa/index&zonaVentas=<?php echo $zonaVentas; ?>">
                                        <span class="">
                                            <img src="images/autoventa.png " style="width: 55px" /><br/>
                                            <span class="text-primary">Transferencia Autoventa</span>
                                        </span>
                                    </a>

                                    <?php
                                } else {
                                    ?>
                                    <a href="#">
                                        <span class="">
                                            <img src="images/autoventaCancel.png " style="width: 55px" onclick="alerta()" /><br/>
                                            <span class="text-primary" onclick="alerta()">Transferencia Autoventa</span>
                                        </span>
                                    </a>                                     


                                    <?php
                                }
                                ?>

                            </div>
                            <div class="col-md-3"></div>
                        </div>
                        <div class="mb20"></div>
                        <div class="row">                       
                            <div class="col-md-3"></div>
                            <div class="col-md-3">  

                                <?php
                                if ($diaRuta == "") {
                                    ?>
                                    <span class="">
                                        <a href="#">
                                            <span class="">
                                                <img src="images/cliennovista_block.png" style="width: 55px"/><br/>
                                                <span class="text-primary">Gestión no venta</span>
                                            </span>
                                        </a>
                                    </span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="">
                                        <a href="index.php?r=Gestionnoventas/index&zonaVentas=<?php echo $zonaVentas; ?>">
                                            <span class="">
                                                <img src="images/cliennovista.png" style="width: 55px"/><br/>
                                                <span class="text-primary">Gestión no venta</span>
                                            </span>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="col-md-3">
                                <?php
                                $TransferenciasHechas = Transferenciaautoventa::model()->getTransfereciasAutoventasSinAceptar($zonaVentas);
                                if (count($TransferenciasHechas) > 0) {
                                    ?>  
                                    <a href="index.php?r=RecibirTransferencia/index&zonaVentas=<?php echo $zonaVentas; ?>">
                                        <span class="">
                                            <img src="images/recibirTransferencia.png " style="width: 55px"/><br/>
                                            <span class="text-primary">Recibir Tranferencia</span>
                                        </span>
                                    </a> 
<?php } else { ?>
                                    <a href="#">
                                        <span class="">
                                            <img src="images/recibirTransferenciafalseBlock.png " style="width: 55px"/><br/>
                                            <span class="text-primary">Recibir Tranferencia</span>
                                        </span>
                                    </a> 
<?php } ?> 
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>     



    <div id="msg"></div>

</div>

<?php $this->renderPartial('//mensajes/_alerta'); ?>
<?php $this->renderPartial('//mensajes/_terminaruta'); ?>
<?php $this->renderPartial('//mensajes/_alertaValidacionRuta'); ?>
<?php $this->renderPartial('//mensajes/_alertSucessTerminacionRuta'); ?>
<?php $this->renderPartial('//mensajes/_alertainformacionActivity'); ?>

<style>
    col-md-3 a{
        text-decoration: none
    }

    span .text-primary{
        font-weight: 200;
        font-size: 1.1em;
    }

</style>