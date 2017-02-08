
<table class="table table-bordered" id="tblPortafolio">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th></th>                      
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($portafolioZonaVentas as $itemPortafolio) {
                            
                          /*  echo '<pre>';
                            print_r($portafolioZonaVentas);*/
                            
                            ?>
                            <tr data-id-inventario="<?php echo $itemPortafolio['IdSaldoInventario']; ?>" data-nuevo="<?php if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                           /* echo '<pre>';
                            print_r($portafolioZonaVentas);
                                echo '1';*/
                        } else {
                            echo '0';
                        } ?>" data-agregado="1"  <?php if (($itemPortafolio['SaldoInventario'] == "" || $itemPortafolio['SaldoInventario'] == 0 || $itemPortafolio['AcuerdoComercial'] == 0)) {
                                    echo 'style="background-color:#EAECEE; border-bottom: 2px solid #fff;"';
                                    echo 'data-block="1"';
                                } ?> class="btnAdicionarProductoDetalle cursorpointer"  data-unidad-medida="<?php echo $itemPortafolio['UnidadMedidaProducto']; ?>" data-zona="<?php echo $zonaVentas; ?>" data-codigo-variante="<?php echo $itemPortafolio['CodigoVariante']; ?>" data-cliente="<?php echo $cuentaCliente; ?>" data-articulo="<?php echo $itemPortafolio['CodigoArticulo']; ?>" data-grupo-ventas="<?php echo $itemPortafolio['CodigoGrupoVentas']; ?>" data-CodigoUnidadMedida-saldo="<?php echo $itemPortafolio['CodigoUnidadMedida']; ?>">
                                <td style="width: 15%;" class="text-center">

                                    <?php
                                    if ($itemPortafolio['IdentificadorProductoNuevo'] == 1) {
                                        ?>
                                        <img data-producto-nuevo="1" id="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pronuevo.png" />
                                        <br/>
                                        <small>Nuevo</small>
                                        <?php
                                    } else {
                                        if ($itemPortafolio['SaldoInventario'] == 0 || $itemPortafolio['AcuerdoComercial'] == 0){
                                         ?>
                                        <img data-producto-nuevo="0" id="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro_inactive.png" />
                                        <br/>
                                        <small>Restringido</small>
                                        <?php
                                        }else{
                                        ?>                                        
                                        <img data-producto-nuevo="0" id="imagen-producto-<?php echo $itemPortafolio['CodigoVariante']; ?>" src="images/pro.png" />
                                         <br/>
                                        <small>Producto</small>
                                        <?php
                                        }
                                    }
                                    ?>                        
                                </td>

                                <td >
                                    <b>Código Artículo:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoArticulo'].' -- ';
                                    echo $itemPortafolio['CodigoTipoKit'];
                                    ?>                         
                                    <br/>
                                     <b>Código Variante:</b>
                                    <?php
                                    echo $itemPortafolio['CodigoVariante'];
                                    ?>                         
                                    <br/>
                                    <?php
                                    echo $itemPortafolio['NombreArticulo'] . ' ' . $itemPortafolio['CodigoCaracteristica1'] . ' ' . $itemPortafolio['CodigoCaracteristica2'] . ' (' . $itemPortafolio['CodigoTipo'] . ')';
                                    ?>
                                    <br/>
                                    
                                    <!--
                                    <span>Acuerdo<?php //echo $itemPortafolio['AcuerdoComercial']; ?></span>
                                    <span>Saldo:<?php //echo $itemPortafolio['SaldoInventario']; ?></span>
                                    -->
                                    
                                </td>
                                <td style="width: 10%;" class="text-center">

                                    <span class="glyphicon glyphicon-plus" style="color: #1CAF9A; font-size: 20px"></span>
                                    <br/>
                                    <small>Adicionar</small>                                    
                                </td>
                            </tr>
                                <?php
                                }
                            ?>
                    </tbody>


                </table>
