

<div class="contentpanel">


    <div class="panel-body" style="min-height: 1000px;">

        <div class="panel-heading">
            <div align="center">
                <button class="btn btn-primary" onclick="GenerarNotasCredito()" style="height: 50px; width: 200px;"><li class="glyphicon  glyphicon-pencil"></li> Generar Notas Crédito
                </button>
            </div>
            <div align="center" style="display:none;" id="cargandonotas">
               <div id="img-cargar">Cargando....</div> 
            </div>
            <br>
            <br>
            <div style="overflow-y: scroll; min-height: 100%; max-height: 500px; border: solid 2px #eee; padding: 10px;">
                <table class="table table-bordered" id="tblNotasCredito" style="width: 100%;">
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
                    foreach ($FvzonaNotas as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['CodZonaVentas']; ?></td>
                            <td><?php echo $item['NombreZonadeVentas']; ?></td>
                            <td><input type="checkbox" id="<?php echo $item['CodZonaVentas']; ?>" name="<?php echo $item['CodZonaVentas']; ?>" value="<?php echo $item['CodZonaVentas']; ?>" class="chckZonaNota"></td> 
                        </tr>

                    <?php } ?>
                        </tbody>


                </table>
            </div>

        </div>

    </div>


</div>