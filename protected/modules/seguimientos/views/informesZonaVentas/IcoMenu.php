<div class="contentpanel">

    <div class="panel panel-default">        
        <div class="panel-body" style="min-height: 450px;">

            <div class="panel-heading">
                <div class="row">
                     <div class="col-md-2">
                            <img src="images/home.png" alt="Ir al menu" class="cursorpointer img-rounded" id="retornarSelect"  style="width: 75px; padding-left: 25px;"/> 
                            Menu<span></span>
                             
                    </div>

                    <div class="col-md-1">
                        <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                    </div>
                    <?php
                    $infromacion = InformeZonaVentas::model()->getinformationasesor($zonaventas);

                    foreach ($infromacion as $Iteminformacion) {

                        $Iteminformacion;
                    }
                    ?>
                     <div class="col-md-5">
                        <h5> Código Asesor:  <span class="text-primary"><?php echo $Iteminformacion['CodAsesor']; ?></span></h5>
                        <h5> Nombre Asesor: <span class="text-primary"><?php echo $Iteminformacion['Nombre']; ?></span></h5>
                    </div>
                    
                    
                    <div class="col-md-4">
                        <h5> Código Zona Ventas:  <span class="text-primary"><?php echo $zonaventas ?></span></h5>
                        <h5> Nombre Zona Ventas: <span class="text-primary"><?php echo $Iteminformacion['NombreZonadeVentas']; ?></span></h5>
                    </div>

                   

                </div>

            </div>


            <div class="widget widget-blue">


                <div class="widget-content">

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4" >
                            <div class="mb20"></div>
                            <div class="col-md-6 text-center sitiosalmacenAction">  
                                <a href="index.php?r=seguimientos/InformesZonaVentas/SitiosAlmacen&zonaventas=<?php echo $zonaventas ?>">
                                    <span class="sitiosalmacen cursorpointer">
                                        <img src="images/almacenes.png" style="width: 55px"/><br/>
                                        <span class="text-primary sitiosalmacen cursorpointer">Sitios y Almacenes</span>
                                    </span> 
                                </a> 
                            </div>
                            <div class="mb20"></div>
                            <div class="col-md-6 portafolioAction">  
                                <a href="index.php?r=seguimientos/InformesZonaVentas/Portafolio&zonaventas=<?php echo $zonaventas ?>">
                                    <span class="portafolio cursorpointer">
                                        <img src="images/portfolio.png " style="width: 55px"/><br/>
                                        <span class="text-primary portafolio cursorpointer">Portafolio</span>
                                    </span>                             
                                </a>
                            </div>
                            <div class="mb30"></div>
                            <div class="col-md-6 text-center saldospreventaAction">  
                                <span class="saldoinventaropreventa cursorpointer" data-zona="<?php echo $zonaventas ?>">
                                    <img src="images/pedido_preventa.png " style="width: 55px"/><br/>
                                    <span class="text-primary saldoinventaropreventa cursorpointer" data-zona="<?php echo $zonaventas ?>">Saldo Prevanta</span>
                                </span>                             
                            </div>
                            <div class="mb20"></div>
                            <div class="col-md-6">  
                                <span class="saldoinventaroautoventa cursorpointer saldosautoventaAction" data-zona-auto="<?php echo $zonaventas ?>">
                                    <img src="images/autoventa.png " style="width: 55px"/><br/>
                                    <span class="text-primary saldoinventaroautoventa cursorpointer" data-zona-auto="<?php echo $zonaventas ?>">Saldo Autoventa</span>
                                </span>                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>



        </div>
    </div>      



</div>


<?php $this->renderPartial('/mensajes/_alertPreventa'); ?>
<?php $this->renderPartial('/mensajes/_alertAutoventa'); ?>
<?php $this->renderPartial('/mensajes/_alertInfomatioSalirMenu');?>

