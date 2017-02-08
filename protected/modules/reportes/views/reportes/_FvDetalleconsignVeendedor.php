 



<div class="panel-heading">
    <br><br>
    <div align="center">
        <h2>
            <a  href="javascript:consignacionvendedor();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Consignación Vendedor
            </b>
            <a href="javascript:genrar_ConsigVeendedor_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2> 
    </div>

    <br>
    <form action="  index.php?r=reportes/Reportes/ExportarExcelConsignacionVeendedor" method=post name="formulario_consigveendedor_excel">       

        <?php
        foreach ($arraypuhs as $iteminfo) {
           
            $valortotalconsignado=0;
            
            $valortotalconsignado =$iteminfo['ValorConsignadoEfectivo'] + $iteminfo['ValorConsignadoCheque'];
           
            ?>
            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                <table class="table table-bordered" style="width: 100%;">

                    <tr style="background-color: #8DB4E2; font-size: 12px;" >

                        <th nowrap="nowrap" class="text-center" >
                            Código Zona Ventas   
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Nombre Zona Ventas   
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Código Asesor   
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Nombre Asesor 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Código Responsable 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Nombre Responsable 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Fecha consignación 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Hora Consignación 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Valor 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Nro Transacción 
                        </th>
                        
                    </tr>

                    <tr>   
                        <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['CodAsesor']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreAsesor']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreResponsable']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['FechaConsignacion']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['HoraConsignacion']; ?></td>
                        <td nowrap="nowrap" class="text-center">$ <?php echo number_format($valortotalconsignado,'2', ',', '.') ?></td>
                        <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>
                    </tr>
                    <br>
                    
                    <tr>
                        <td colspan="9">
                            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                                <table class="table table-bordered" style="width: 100%;">

                                    <tr style="background-color: #8DB4E2; font-size: 12px;">
                                        <th nowrap="nowrap" class="text-center">
                                            Num Consignación 
                                        </th>

                                        <th nowrap="nowrap"  class="text-center">
                                            Código Banco 
                                        </th>

                                        <th nowrap="nowrap" class="text-center">
                                            Nombre Banco 
                                        </th>

                                        <th nowrap="nowrap" class="text-center">
                                            Cuenta 
                                        </th>

                                        <th nowrap="nowrap" class="text-center">
                                            Fecha Consignación vendedor 
                                        </th>

                                        <th class="text-center">
                                            Valor Efectivo 
                                        </th>
 
                                        <th nowrap="nowrap" class="text-center">
                                            Valor Cheque 
                                        </th>

                                        <th nowrap="nowrap" class="text-center">
                                            Oficina 
                                        </th>

                                        <th nowrap="nowrap" class="text-center">
                                            Ciudad 
                                        </th>


                                    </tr>
                                  
                                        <tr>
                                            <td class="text-center"><?php echo $iteminfo['NroConsignacion']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['IdentificadorBanco']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['Banco']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['CuentaConsignacion']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['FechaConsignacionVendedor']; ?></td>
                                            <td class="text-center"><?php echo number_format($iteminfo['ValorConsignadoEfectivo'], '2', ',', '.'); ?></td>
                                            <td class="text-center"><?php echo number_format($iteminfo['ValorConsignadoCheque'], '2', ',', '.'); ?></td>
                                            <td class="text-center"><?php echo $iteminfo['Oficina']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['Ciudad']; ?></td>
                                        </tr>


                                   

                                </table>

                            </div>   


                        </td>

                    </tr>

                <?php } ?> 



                <input type="hidden" value="<?php echo $sql ?>" id="sql" name="sql"/>
                <input type="hidden" value="<?php echo $fechaini ?>" id="fechaini" name="fechaini"/>
                <input type="hidden" value="<?php echo $fechafin ?>" id="fechafin" name="fechafin"/>


            </table>

        </div>
    </form>  

</div>


<script>

    function genrar_ConsigVeendedor_excel() {
        document.formulario_consigveendedor_excel.submit();
    }

</script>



