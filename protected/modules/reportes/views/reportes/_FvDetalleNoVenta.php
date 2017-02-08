
<div class="panel-heading">
    <br> 
    <div align="center">
        <h2>
            <a  href="javascript:noventas();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                No Ventas
            </b>
            <a href="javascript:genrar_Noventas_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

    <form action="  index.php?r=reportes/Reportes/ExportarExcelNoventas" method=post name="formulario_noventas_excel">


        <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
        <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
        <input type="hidden" name="sql" value="<?php echo $sql ?>">
        <input type="hidden" name="agencia" value="<?php echo $agencia ?>">

        <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

            <table class="table table-bordered" style="width: 100px;">

                <tr style="background-color: #8DB4E2; font-size: 12px;">

                    <th nowrap="nowrap" class="text-center" >
                        Código Zona Ventas
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Nombre Zona Ventas  
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Cuenta Cliente 
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Nombre Cliente
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Código Responsable
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Nombre Responsable
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Fecha No Venta
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Hora No Venta
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Motivo No Venta
                    </th>

                </tr>

                <?php
                foreach ($arraypuhs as $iteminfo) {
                    ?>


                    <tr>   
                        <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['FechaNoVenta']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['HoraNoVenta']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['motivonoventa']; ?></td>
                    </tr>   


                    <?php
                }
                ?>

                <input type="hidden" value="<?php echo $sql ?>" id="sql" name="sql"/>
                <input type="hidden" value="<?php echo $fechaini ?>" id="fechaini" name="fechaini"/>
                <input type="hidden" value="<?php echo $fechafin ?>" id="fechafin" name="fechafin"/>

            </table>

        </div> 
    </form>   

</div>

<script>

    function genrar_Noventas_excel() {
        document.formulario_noventas_excel.submit();
    }

</script>

