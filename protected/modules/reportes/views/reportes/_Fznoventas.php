

<div class="contentpanel">


    <div class="panel-body" style="min-height: 1000px;">

        <div class="panel-heading">
            <div align="center">
                <button class="btn btn-primary" onclick="GenerarNoVentas()" style="height: 50px; width: 200px;"><li class="glyphicon  glyphicon-pencil"></li> Generar No Ventas
                </button>
            </div>
            <div align="center" style="display:none;" id="cargandonoventas">
               <div id="img-cargar">Cargando....</div> 
            </div>
            <br>
            <br>
            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">
                <table class="table table-bordered" id="tblNoVentas" style="width: 100%;">
                    <thead> 
                    <tr style="background-color: #8DB4E2;">
                       <th>
                            Código Zona Ventas 
                        </th>
                        <th>
                            Nombre Zona Ventas 
                        </th>
                        <th>
                           Todos <input type="checkbox" id="todos" onclick="marcarCheck(this);"> 
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($Fvzona as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['CodZonaVentas']; ?></td>
                            <td><?php echo $item['NombreZonadeVentas']; ?></td>
                            <td><input type="checkbox" value="<?php echo $item['CodZonaVentas']; ?>" id="<?php echo $item['CodZonaVentas']; ?>" name="<?php echo $item['CodZonaVentas']; ?>" class="chckZona"></td> 
                        </tr>

                    <?php } ?>
                     </tbody>
                </table>
            </div>

        </div>

    </div>


</div>