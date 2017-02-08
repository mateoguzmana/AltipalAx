<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Preventa<span></span>
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
                                    <table class="table table-hover" id="tblinformationsaldopreventa">
                                            <thead style="width: 60px;">
                                            <tr>
                                                <th>Nombre sitio</th>
                                                <th>Codigo Variante</th>
                                                <th>Codigo Articulo</th>
                                                <th>Codigo Caracteristica 1</th>
                                                <th>Codigo Caracteristica 2</th>
                                                <th>Codigo Tipo</th>
                                                <th>Disponible</th>
                                                <th>Codigo Unidad medida</th>
                                                <th>Nombre Unidad medida</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php 
                                            $saladopreventa = InformeZonaVentas::model()->getsaldoinvitariopreventa($sitio,$almacen);
                                                 
                                                foreach ($saladopreventa as $itemsaldopreventa){
                                                
                                                ?>
                                            <tr>
                                                <td><?php echo $itemsaldopreventa['NombreSitio'] ?></td>
                                                <td><?php echo $itemsaldopreventa['CodigoVariante'] ?></td>
                                                <td><?php echo $itemsaldopreventa['CodigoArticulo'] ?></td>
                                                <td><?php echo $itemsaldopreventa['CodigoCaracteristica1'] ?></td>
                                                <td><?php echo $itemsaldopreventa['CodigoCaracteristica2'] ?></td>
                                                <td><?php echo $itemsaldopreventa['CodigoTipo'] ?></td>
                                                <td><?php echo $itemsaldopreventa['Disponible'] ?></td>
                                                <td><?php echo $itemsaldopreventa['CodigoUnidadMedida'] ?></td>
                                                <td><?php echo $itemsaldopreventa['NombreUnidadMedida'] ?></td>
                                                
                                              
                                                
                                                
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