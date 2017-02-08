<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Sitios y Almacenes<span></span>
    </h2>      
</div>
 
<div class="contentpanel">

    <div class="panel panel-default">

        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">   
                <div class="widget-content">                    
                    <form class="form-inline" method="post" action="">  
                        <div class="mb30"></div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tblinformationsitioalamcen">
                                        <thead>
                                            <tr>
                                                <th>Codigo Zona Ventas</th>
                                                <th>Preventa</th>
                                                <th>Autoventa</th>
                                                <th>Consignación</th>
                                                <th>Venta directa</th>
                                                <th>Focalizados</th>
                                                <th>Sitio</th>
                                                <th>Almacen</th>
                                                <th>Agencia</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php 
                                           $zonas = InformeZonaVentas::model()->getsitiosAlmacen($zonaventas);
                                                 
                                                foreach ($zonas as $itemzona){
                                                
                                                ?>
                                            <tr>
                                                <td><?php echo $itemzona['CodZonaVentas'] ?></td>
                                                <td><?php echo $itemzona['Preventa'] ?></td>
                                                <td><?php echo $itemzona['Autoventa'] ?></td>
                                                <td><?php echo $itemzona['Consignacion'] ?></td>
                                                <td><?php echo $itemzona['VentaDirecta'] ?></td>
                                                <td><?php echo $itemzona['Focalizado'] ?></td>
                                                <td><?php echo $itemzona['NombreSitio'] ?></td>
                                                <td><?php echo $itemzona['NombreAlmacen'] ?></td>
                                                <td><?php echo $itemzona['NombreAgencia'] ?></td>
                                              
                                            </tr>
                                               <?php 
                                                }
                                                ?> 
                                            
                                            
                                            


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>   
</div>

<?php $this->renderPartial('/mensajes/_alertInformationSalirModulosSegumiento');?>