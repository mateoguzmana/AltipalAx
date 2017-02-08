

<div class="contentpanel">

            <div class="panel-heading">

            <div class="widget widget-blue">

                <div class="widget-content">
                      <br>
            <div align="center">
                <button class="btn btn-primary" onclick="GenerarTerminarRuta()" style="height: 50px; width: 200px;background-color: #24D29B; border: solid 2px #24D29B;"><li class="glyphicon  glyphicon-pencil"></li> Generar Terminar Ruta
                </button>
            </div>
            <div align="center" style="display:none;" id="cargandoterminarruta">
               <div id="img-cargar">Cargando....</div> 
            </div>
            <br>
            
           <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">
                <table class="table table-bordered" id="tblPedidos" style="width: 100%;">
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
                    foreach ($FvzonaRuta as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['CodZonaVentas']; ?></td>
                            <td><?php echo $item['NombreZonadeVentas']; ?></td>
                            <td><input type="checkbox" id="<?php echo $item['CodZonaVentas']; ?>" name="<?php echo $item['CodZonaVentas']; ?>" value="<?php echo $item['CodZonaVentas']; ?>" class="chckZonaRuta"></td> 
                        </tr>

                    <?php } ?>
                     </tbody>   

                </table>
            </div>

                </div>
                    
            </div>
            </div>
</div>
           
