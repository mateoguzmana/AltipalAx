  

<div class="contentpanel">


    <div class="panel-body" style="min-height: 1000px;">

        <div class="panel-heading">
            <div align="center">
                <button class="btn btn-primary EnviarMensaje" style="height: 50px; width: 200px;"><li class="glyphicon  glyphicon-pencil"></li>Enviar Mensaje
                </button>
            </div>
            <div align="center" style="display:none;" id="cargandorecibos">
               <div id="img-cargar">Cargando....</div> 
            </div>
            <br>
            <br>
            <div class="table-responsive">
                <table class="table table-bordered" id="tblAsesores">
                    <thead>
                    <tr style="background-color: #8DB4E2;">
                        <th>
                           Asesores Comercial
                        </th>
                        <th>
                           Zona Ventas
                        </th>
                        <th>
                           Todos <input type="checkbox" id="todos" onclick="marcarCheck(this);"> 
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($Asesores as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['NombreEmpleado']; ?></td>
                            <td><?php echo $item['CodigoZonaVentas']; ?></td>
                            <td><input type="checkbox" id="<?php echo $item['CodigoZonaVentas']; ?>" value="<?php echo $item['CodigoZonaVentas']; ?>,<?php echo $item['Agencia']; ?>" class="chckAsesores"></td> 
                        </tr>

                    <?php } ?>

                    </tbody>    
                </table>
            </div>

        </div>

    </div>


</div>