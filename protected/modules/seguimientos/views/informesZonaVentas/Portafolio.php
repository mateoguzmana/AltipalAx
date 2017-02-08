<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Portafolio<span></span>
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
                                    <table class="table table-hover" id="tblinformationportafolio">
                                            <thead style="width: 60px;">
                                            <tr>
                                                <th>Codigo Grupo Ventas</th>
                                                <th>Codigo Variante</th>
                                                <th>Codigo Articulo</th>
                                                <th>Nombre Articulo</th>
                                                <th>Codigo Caracteristica 1</th>
                                                <th>Codigo Caracteristica 2</th>
                                                <th>Codigo Marca</th>
                                                <th>Codigo Tipo</th>
                                                <th>Codigo Categoria</th>
                                                 <th>Codigo Cuenta Proveedor</th>
                                                 <th>Porcentaje Iva</th>
                                                   <th>Valor impoconsumo</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <?php 
                                            $zonas = InformeZonaVentas::model()->getPortafolio($zonaventas);
                                                 
                                                foreach ($zonas as $itemzona){
                                                
                                                ?>
                                            <tr>
                                                <td><?php echo $itemzona['CodigoGrupoVentas'] ?></td>
                                                <td><?php echo $itemzona['CodigoVariante'] ?></td>
                                                <td><?php echo $itemzona['CodigoArticulo'] ?></td>
                                                <td><?php echo $itemzona['NombreArticulo'] ?></td>
                                                <td><?php echo $itemzona['CodigoCaracteristica1'] ?></td>
                                                <td><?php echo $itemzona['CodigoCaracteristica2'] ?></td>
                                                <td><?php echo $itemzona['CodigoMarca'] ?></td>
                                                <td><?php echo $itemzona['CodigoTipo'] ?></td>
                                                <td><?php echo $itemzona['CodigoGrupoCategoria'] ?></td>
                                                <td><?php echo $itemzona['CuentaProveedor'] ?></td>
                                                <td><?php echo $itemzona['PorcentajedeIVA'] ?></td>
                                                <td><?php echo $itemzona['ValorIMPOCONSUMO'] ?></td>
                                              
                                                
                                                
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