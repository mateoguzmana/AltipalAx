

<div class="contentpanel">


    <div class="panel-body" style="min-height: 1000px;">

        <div class="panel-heading">
            <div align="center">
                <button class="btn btn-primary" onclick="GenerarFacturas()" style="height: 50px; width: 200px;"><li class="glyphicon  glyphicon-pencil"></li> Generar Facturas
                </button>
            </div>
            <div align="center" style="display:none;" id="cargandofacturas">
               <div id="img-cargar">Cargando....</div> 
            </div>
            <br>
            <br>
            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">
                <table class="table table-bordered" id="tblFactura" style="width: 100%;">
                     <thead> 
                    <tr style="background-color: #8DB4E2;">
                        <th>
                            <b>Código Zona Ventas</b>   
                        </th>
                        <th>
                            <b>Nombre Zona Ventas</b>   
                        </th>
                        <th>
                           Todos <input type="checkbox" id="todos" onclick="marcarCheck(this);"> 
                        </th>

                    </tr>
                    </thead> 
                    <tbody>
                    <?php
                    foreach ($FvzonaFacturas as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['CodZonaVentas']; ?></td>
                            <td><?php echo $item['NombreZonadeVentas']; ?></td>
                            <td><input type="checkbox" id="<?php echo $item['CodZonaVentas']; ?>" name="<?php echo $item['CodZonaVentas']; ?>" value="<?php echo $item['CodZonaVentas']; ?>" class="chckZonaFactura"></td> 
                        </tr>

                    <?php } ?>
                      </tbody>  


                </table>
            </div>

        </div>

    </div>


</div>