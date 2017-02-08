 
<div class="panel-heading">
    <br> 
    <div align="center">
    <h2>
        <b>
            No Ventas
        </b>
        <a href="javascript:genrar_Noventas_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
    </h2>
    </div>
     
<form action="  index.php?r=reportes/ResumenDia/ExportarExcelNoventas" method=post name="formulario_noventas_excel">     
    
        <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
        <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
        <input type="hidden" name="sql" value="<?php echo $sql ?>">
        <input type="hidden" name="agencia" value="<?php echo $agencia ?>">
    
        <div class="table-responsive">

            <table class="table table-bordered">

                <tr style="background-color: #8DB4E2; font-size: 12px;">

                    <th nowrap="nowrap" class="text-center" >
                       Codigo Zona Ventas
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
                       Codigo Responsable
                    </th>
                     <th nowrap="nowrap" class="text-center">
                       Nombre Responsable
                    </th>
                     <th nowrap="nowrap" class="text-center">
                        Fecha no Venta
                    </th>
                      <th nowrap="nowrap" class="text-center">
                       Hora no Venta
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

<?php $this->renderPartial('//mensajes/_alerta'); ?>

<script>
     
   function genrar_Noventas_excel(){
        document.formulario_noventas_excel.submit(); 
    }
    
   

</script>

