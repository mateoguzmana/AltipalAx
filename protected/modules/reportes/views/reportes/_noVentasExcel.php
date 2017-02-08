<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=NoVentas.xls");
?>


<div class="panel-heading">
    <br><br> 
    <div align="center">
    <h2><b>No Ventas</b></h2>
    </div>
    
    <br>
    <div class="table-responsive">

            <table border="1">

                <tr style="background-color: #8DB4E2; font-size: 10px;">

                    <td align="center" >
                        <b>Codigo Zona Ventas</b>   
                    </td>
                    <td align="center">
                        <b>Nombre Zona Ventas</b>   
                    </td>
                    <td align="center">
                        <b>Cuenta Cliente</b> 
                    </td>
                     <td align="center">
                        <b>Nombre Cliente</b> 
                    </td>
                    <td align="center">
                        <b>Codigo Responsable</b> 
                    </td>
                     <td align="center">
                        <b>Nombre Responsable</b> 
                    </td>
                     <td align="center">
                        <b>Fecha no Venta</b> 
                    </td>
                      <td align="center">
                        <b>Hora no Venta</b> 
                    </td>
                    <td align="center">
                        <b>Motivo de la no venta</b> 
                    </td>
                </tr>

                <?php
                foreach ($arraypuhs as $iteminfo) {
                    ?>
                

                    <tr>   
                        <td align="center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td align="center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td align="center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                        <td align="center"><?php echo $iteminfo['NombreCliente']; ?></td>
                        <td align="center"><?php echo $iteminfo['Responsable']; ?></td>
                        <td align="center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                        <td align="center"><?php echo $iteminfo['FechaNoVenta']; ?></td>
                        <td align="center"><?php echo $iteminfo['HoraNoVenta']; ?></td>
                        <td align="center"><?php echo $iteminfo['motivonoventa']; ?></td>
                    </tr>   


                    <?php
                }
                ?>
                    
    
            </table>

        </div> 
           
    
</div>