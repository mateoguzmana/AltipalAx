<style>
    td
    { font-size:10px}

</style>
<div class="contentpanel">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">

                <table  id="DatosRutero" class="table table-bordered">
                    <thead>
                        <tr >
                            <th class="text-center"># Visita</th>
                            <th class="text-center">Frecuencia</th>
                            <th class="text-center">R1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th class="text-center">R2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th class="text-center">R3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th class="text-center">R4 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>                                    
                            <th class="text-center">Cuenta Cliente</th>
                            <th class="text-center">Nombre Cliente</th>
                            <th class="text-center"><?php echo utf8_encode("Dirección"); ?></th>  
                            <th class="text-center"><?php echo utf8_encode("Teléfono"); ?></th>
                            <th class="text-center"><?php echo utf8_encode("Teléfono Móvil"); ?></th>      
                            <th class="text-center">Barrio</th>
                            <th class="text-center">Valor cupo</th>
                        </tr>     
                    </thead>

                <!--    <tfoot>
                   
                       <tr>
                           <th class="text-center"># Visita</th>
                           <th class="text-center">Frecuencia</th>
                           <th class="text-center">R1</th>
                           <th class="text-center">R2</th>
                           <th class="text-center">R3</th>
                           <th class="text-center">R4</th>                                    
                           <th class="text-center">Cuenta Cliente</th>
                           <th class="text-center">Nombre Cliente</th>
                           <th class="text-center">Direccion</th>  
                           <th class="text-center">Telefono</th>
                           <th class="text-center">Telefono Movil</th>      
                           <th class="text-center">Barrio</th>
                           <th class="text-center">Valor cupo</th>
                       </tr>     
                       
           
       </tfoot>
                    -->
                    <tbody>
                        <?php foreach ($FilaRutero as $row) { ?>
                            <tr>
                                <td><?php echo  $row['NumeroVisita']; ?></td>
                                <td><?php echo  $row['CodFrecuencia']; ?></td>
                                <td><?php echo  $row['R1']; ?></td>
                                <td><?php echo $row['R2']; ?></td>
                                <td><?php echo $row['R3']; ?></td>
                                <td><?php echo $row['R4']; ?></td>
                                <td><?php echo $row['CuentaCliente']; ?></td>
                                <td><?php echo $row['NombreCliente']; ?></td>
                                <td><?php echo  $row['DireccionEntrega']; ?></td>
                                <td><?php echo $row['Telefono']; ?></td>  
                                <td><?php echo $row['TelefonoMovil']; ?></td>
                                <td><?php echo  $row['NombreBarrio']; ?></td>    
                                <td><?php echo  $row['Valorcupo']; ?></td>    
                            
                            </tr>
                            <?php
                        }
                        ?>   

                    </tbody>
                </table> 
            </div>
        </div>
    </div> 
</div>