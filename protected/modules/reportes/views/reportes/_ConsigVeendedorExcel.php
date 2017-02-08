<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ConsignacionVendedor.xls");
?>
 
<div class="panel-heading">
    <br><br>
    <div align="center">
    <h2><b>Consignación Vendedor</b></h2>
    </div>
   
    <br>
  
    <?php
        foreach ($arraypuhs as $iteminfo) {
            ?>
            <div class="table-responsive">

                <table  border="1">

                    <tr style="background-color: #8DB4E2; font-size: 10px;">

                        <td align="center">
                            <b>Codigo Zona Ventas</b>   
                        </td>
                        <td align="center">
                            <b>Nombre Zona Ventas</b>   
                        </td>
                        <td align="center">
                            <b>Codigo Asesor</b>   
                        </td>
                        <td align="center">
                            <b>Nombre Asesor</b> 
                        </td>
                        <td align="center">
                            <b>Codigo Responsable</b> 
                        </td>
                        <td align="center">
                            <b>Nombre Responsable</b> 
                        </td>
                        <td align="center">
                            <b>Fecha consignacion</b> 
                        </td>
                        <td align="center">
                            <b>Hora Consignacion</b> 
                        </td>
                        <td align="center">
                            <b>Valor</b> 
                        </td>
                    </tr>

                    <tr>   
                        <td align="center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td align="center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td align="center"><?php echo $iteminfo['CodAsesor']; ?></td>
                        <td align="center"><?php echo $iteminfo['NombreAsesor']; ?></td>
                        <td align="center"><?php echo $iteminfo['Responsable']; ?></td>
                        <td align="center"><?php echo $iteminfo['NombreResponsable']; ?></td>
                        <td align="center"><?php echo $iteminfo['FechaConsignacion']; ?></td>
                        <td align="center"><?php echo $iteminfo['HoraConsignacion']; ?></td>
                        <td align="center"><?php echo $iteminfo['Valor']; ?></td>
                    </tr>
                      
                    <tr>
                        <td colspan="9">
                            <div class="table-responsive">

                                <table  border="1">

                                    <tr style="background-color: #8DB4E2; font-size: 10px;">
                                        <td align="center">
                                            <b>Num Consignación</b> 
                                        </td>

                                        <td align="center">
                                            <b>Código Banco</b> 
                                        </td>

                                        <td align="center">
                                            <b>Nombre Banco</b> 
                                        </td>

                                        <td align="center">
                                            <b>Cuenta</b> 
                                        </td>

                                        <td align="center">
                                            <b>Fecha Consignación vendedor</b> 
                                        </td>

                                        <td align="center">
                                            <b>Valor Efectivo</b> 
                                        </td>
 
                                        <td align="center">
                                            <b>Valor Cheque</b> 
                                        </td>

                                        <td align="center">
                                            <b>Oficina</b> 
                                        </td>

                                        <td align="center">
                                            <b>Ciudad</b> 
                                        </td>


                                    </tr>
                                  
                                        <tr>
                                            <td align="center"><?php echo $iteminfo['NroConsignacion']; ?></td>
                                            <td align="center"><?php echo $iteminfo['IdentificadorBanco']; ?></td>
                                            <td align="center"><?php echo $iteminfo['Banco']; ?></td>
                                            <td align="center"><?php echo $iteminfo['CuentaConsignacion']; ?></td>
                                            <td align="center"><?php echo $iteminfo['FechaConsignacionVendedor']; ?></td>
                                            <td align="center"><?php echo number_format($iteminfo['ValorConsignadoEfectivo'], '2', ',', '.'); ?></td>
                                            <td align="center"><?php echo number_format($iteminfo['ValorConsignadoCheque'], '2', ',', '.'); ?></td>
                                            <td align="center"><?php echo $iteminfo['Oficina']; ?></td>
                                            <td align="center"><?php echo $iteminfo['Ciudad']; ?></td>
                                        </tr>
                    
                                </table>
 
                            </div>   
                         <br><br><br> 

                        </td>

                    </tr>
 
                <?php } ?> 
 
            </table>
          </div>
       
</div>

 


