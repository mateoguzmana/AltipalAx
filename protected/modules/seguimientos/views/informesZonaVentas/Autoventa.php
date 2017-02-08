<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Autoventa<span></span>
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
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <!--<div style="height:1050px;  overflow-x:scroll ; overflow-y: scroll; padding-bottom:10px;">-->      
                                    <table class="table table-hover" id="tblinformationsaldoautoventa">
                                            <thead style="width: 60px;">
                                            <tr>
                                                <th>Nombre sitio</th>
                                                <th>Codigo Variante</th>
                                                <th>Codigo Articulo</th>
                                                <th>Codigo Caracteristica 1</th>
                                                <th>Codigo Caracteristica 2</th>
                                                <th>Codigo Tipo</th>
                                                <th>Lote Articulo</th>
                                                <th>Disponible</th>
                                                <th>Codigo Unidad medida</th>
                                                <th>Nombre Unidad medida</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php 
                                            $saladoautoventa = InformeZonaVentas::model()->getsaldoinvitarioautoventa($sitio,$almacen);
                                                 
                                                foreach ($saladoautoventa as $itemsaldoautoventa){
                                                
                                                ?>
                                            <tr>
                                                <td><?php echo $itemsaldoautoventa['NombreSitio'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['CodigoVariante'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['CodigoArticulo'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['Caracteristica1'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['Caracteristica2'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['CodigoTipo'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['LoteArticulo'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['Disponible'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['CodigoUnidadMedida'] ?></td>
                                                <td><?php echo $itemsaldoautoventa['NombreUnidadMedida'] ?></td>
                                                
                                              
                                                
                                                
                                            </tr>
                                               <?php 
                                                }
                                                ?> 
                                            
                                            
                                            


                                        </tbody>
                                    </table>
                                        <!--</div>-->
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