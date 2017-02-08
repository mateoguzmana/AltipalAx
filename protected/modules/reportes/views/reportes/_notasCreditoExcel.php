<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=NotasCredito.xls");
?>

<div class="panel-heading">
    <br><br> 
    <div align="center">
        <h2><b>Notas Credito</b></h2>
    </div>
    <br>
    <?php
    foreach ($arraypuhs as $iteminfo) {
        ?>
        <div class="table-responsive">
            <table border="1">
                <tr style="background-color: #8DB4E2;  font-size: 10px;">
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
                        <b>Fecha Nota Credito</b> 
                    </td>
                    <td align="center">
                        <b>Hora Nota Credito</b> 
                    </td>
                    <td align="center">
                        <b>Valor</b> 
                    </td>
                </tr>
                <tr>   
                    <td align="center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                    <td align="center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                    <td align="center"><?php echo $iteminfo['CodAsesor']; ?></td>
                    <td align="center"><?php echo $iteminfo['Nombre']; ?></td>
                    <td align="center"><?php echo $iteminfo['Responsable']; ?></td>
                    <td align="center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                    <td align="center"><?php echo $iteminfo['Fecha']; ?></td>
                    <td align="center"><?php echo $iteminfo['Hora']; ?></td>
                    <td align="center"><?php echo $iteminfo['Valor']; ?></td>
                </tr>
                <tr>
                    <td colspan="11">
                        <div class="table-responsive">
                            <table border="1" >
                                <tr style="background-color: #8DB4E2; font-size: 10px;">
                                    <td align="center">
                                        <b>Cuenta Cliente</b>   
                                    </td>
                                    <td align="center">
                                        <b>Nombre Cliente</b>   
                                    </td>
                                    <td align="center">
                                        <b>Factura</b> 
                                    </td>
                                    <td align="center">
                                        <b>Concepto</b> 
                                    </td>
                                    <td align="center">
                                        <b>Responsable Nota</b> 
                                    </td>
                                    <td align="center">
                                        <b>Nombre Responsable</b> 
                                    </td>
                                    <td align="center">
                                        <b>Fabricante</b> 
                                    </td>
                                    <td align="center" colspan="2">
                                        <b>Observacion</b> 
                                    </td>
                                </tr>
                                <tr>   
                                    <td align="center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                                    <td align="center"><?php echo $iteminfo['NombreCliente']; ?></td>
                                    <td align="center"><?php echo $iteminfo['Factura']; ?></td>
                                    <td align="center"><?php echo $iteminfo['NombreConceptoNotaCredito']; ?></td>
                                    <td align="center"><?php echo $iteminfo['ResponsableNota']; ?></td>
                                    <td align="center"><?php echo $iteminfo['Descripcion']; ?></td>
                                    <td align="center"><?php echo $iteminfo['Fabricante']; ?></td>
                                    <td align="center" colspan="2"><?php echo $iteminfo['Observacion']; ?></td>
                                </tr>
                            </table>
                        </div>  
                        <br><br><br> 
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>