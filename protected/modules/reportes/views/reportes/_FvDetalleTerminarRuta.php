<div class="contentpanel">
    <div class="panel-heading">
        <div class="widget widget-blue">
            <div class="widget-content">
    <div align="center">
                 <a  href="javascript:terminarruta();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>

    <h3>
           Terminacion Ruta
    </h3>
    </div>
     
        <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

            <table class="table table-bordered">

                <tr style="background-color: #8DB4E2; font-size: 12px;">

                    <th nowrap="nowrap" class="text-center">
                       Zona Ventas 
                    </th>
                    <th nowrap="nowrap" class="text-center">
                       Nombre Zona  
                    </th>
                     <th nowrap="nowrap" class="text-center">
                        Fecha Terminación
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Hora Terminación
                    </th>
                    <th nowrap="nowrap" class="text-center">
                       Código Asesor
                    </th>
                      <th nowrap="nowrap" class="text-center">
                       Nombre Asesor
                    </th>
                 
                </tr>

                <?php
                foreach ($arraypuhs as $iteminfo) {
                    ?>
                

                    <tr>   
                        <td class="text-center"><?php echo $iteminfo['IdRemitente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['FechaMensaje']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['HoraMensaje']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['CodAsesor']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Nombre']; ?></td>
                   </tr>   


                    <?php
                }
                ?>
                   
            </table>

        </div> 
       
       

            </div>
        </div>
    </div>
</div>

   
 

