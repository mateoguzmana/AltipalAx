 
<div class="panel-heading">
    <br> 
    <div align="center">
         <h2>
            <b>
                Clientes Nuevos
            </b>

            <a href="javascript:genrar_ClientesNuevos_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>
    
    

    <form action="  index.php?r=reportes/ResumenDia/ExportarExcelClientesNuevos" method=post name="formulario_clientesnuevos_excel">   
        
        
        <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
        <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
        <input type="hidden" name="sql" value="<?php echo $sql ?>">
        <input type="hidden" name="agencia" value="<?php echo $agencia ?>">

        <?php
        foreach ($arraypuhs as $iteminfo) {
            ?>

            <?php
            if ($iteminfo['CodTipoDocumento'] == 001) {
                ?>
                <div class="table-responsive">

                    <table class="table table-bordered">


                        <tr style="background-color: #8DB4E2; font-size: 12px;">

                            <th></th>
                            <th class="text-center" >
                                Tipo Identificación   
                            </th>
                            <th class="text-center">
                                Nro Identificación   
                            </th>
                            <th  class="text-center">
                                Id Cliente 
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Nombre y/o Razón Social 
                            </th>
                            <th class="text-center">
                                Establecimiento 
                            </th>

                            <th class="text-center">
                                Código CIIU 
                            </th>
                            <th class="text-center">
                                Teléfono 
                            </th>
                            <th class="text-center">
                                Teléfono Movil 
                            </th>

                            <th class="text-center">
                                Correo Electrónico 
                            </th>


                        </tr>


                        <tr>   
                            <td align="center" rowspan="3" >
                                <br><br><br><br>
                                <img src="images/clientesnit.png" style="width: 75px; height: 70px;">
                            </td>

                            <td class="text-center"><?php echo $iteminfo['Documento']; ?></td>
                            <td class="text-center"><?php echo $iteminfo['Identificacion']; ?></td>
                            <td class="text-center"><?php echo $iteminfo['Id']; ?></td>

                            <td class="text-center"><?php echo $iteminfo['RazonSocial']; ?></td>
                            <td class="text-center"><?php echo $iteminfo['Establecimiento']; ?></td>

                            <td class="text-center"><?php echo $iteminfo['CodigoCiuu']; ?></td>
                            <td class="text-center"><?php echo $iteminfo['Telefono']; ?></td>
                            <td class="text-center"><?php echo $iteminfo['TelefonoMovil']; ?></td>

                            <td class="text-center"><?php echo $iteminfo['Email']; ?></td>

                        </tr>  
                        <tr>
                            <td colspan="11">
                                <div class="table-responsive">

                                    <table class="table table-bordered">
                                        <tr style="background-color: #8DB4E2; font-size: 12px;">


                                            <th class="text-center" >
                                                Ciudad   
                                            </th>
                                            <th class="text-center">
                                                Localidad   
                                            </th>
                                            <th class="text-center">
                                                Barrio 
                                            </th>
                                            <th class="text-center">
                                                Otro Barrio 
                                            </th>
                                            <th class="text-center">
                                                Dirección 
                                            </th>

                                            <th class="text-center">
                                                Código Postal 
                                            </th>
                                            <th class="text-center">
                                                Latitud 
                                            </th>
                                            <th class="text-center">
                                                Longitud 
                                            </th>

                                        </tr>

                                        <tr>

                                            <td class="text-center"><?php echo $iteminfo['NombreCiudad']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['NombreLocalidad']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['NombreBarrio']; ?></td>

                                            <td class="text-center"><?php echo $iteminfo['OtroBarrio']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['Direccion']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['CodigoPostal']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['Latitud']; ?></td>

                                            <td class="text-center"><?php echo $iteminfo['Longitud']; ?></td>


                                        </tr>

                                    </table>
                                </div>     

                            </td>

                        </tr>

                        <tr>
                            <td colspan="11">

                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <tr style="background-color: #8DB4E2; font-size: 12px;">

                                            <th class="text-center" >
                                                Frecuencia   
                                            </th>
                                            <th class="text-center">
                                                Secuencia   
                                            </th>
                                            <th class="text-center">
                                                Código Zona Ventas 
                                            </th>
                                            <th class="text-center">
                                                Nombre Zona Ventas 
                                            </th>

                                        </tr>  

                                        <tr>

                                            <?php
                                            $frecuencia = "";


                                            switch (trim($iteminfo['frecuencia'])) {

                                                case 'S':
                                                    $frecuencia = 'Semanal';
                                                    break;
                                                case 'Q':
                                                    $frecuencia = 'Quincenal';
                                                    break;
                                                case 'M':
                                                    $frecuencia = 'Mensual';
                                                    break;
                                            }
                                            ?>


                                            <td class="text-center"><?php echo $frecuencia; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['Posicion']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                                            <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td> 

                                        </tr>


                                    </table>

                                </div>    


                            </td>

                        </tr>

                    </table> 

                </div>  


            <?php } else { ?>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <tr style="background-color: #8DB4E2; font-size: 12px;">

                            <th></th>

                            <th nowrap="nowrap" class="text-center" >
                                Tipo Identificación   
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Nro Identificación   
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Id Cliente 
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Primer Nombre 
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Segundo Nombre 
                            </th>

                            <th nowrap="nowrap" class="text-center">
                                Primer Apellido 
                            </th>
                            <th  nowrap="nowrap" class="text-center">
                                Segundo Apellido 
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Código CIIU 
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Teléfono 
                            </th>
                            <th nowrap="nowrap" class="text-center">
                                Teléfono Movil 
                            </th>

                            <th nowrap="nowrap" class="text-center">
                                Correo Electrónico 
                            </th>


                        </tr>
                        
                         <tr>  
                                
                                <td align="center" rowspan="3">
                                    <br><br><br><br>
                                    <img src="images/clientesnuevos.png" style="width: 75px; height: 70px;">
                                </td>

                                <td class="text-center"><?php echo $iteminfo['Documento']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['Identificacion']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['Id']; ?></td>

                                <td class="text-center"><?php echo $iteminfo['PrimerNombre']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['SegundoNombre']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['PrimerApellido']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['SegundoApellido']; ?></td>

                                <td class="text-center"><?php echo $iteminfo['CodigoCiuu']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['Telefono']; ?></td>
                                <td class="text-center"><?php echo $iteminfo['TelefonoMovil']; ?></td>

                                <td class="text-center"><?php echo $iteminfo['Email']; ?></td>

                          </tr>
                          <tr>
                                <td colspan="11">
                                    <div class="table-responsive">

                                        <table class="table table-bordered">
                                            <tr style="background-color: #8DB4E2; font-size: 12px;">

                                                <th class="text-center" >
                                                    Ciudad   
                                                </th>
                                                <th class="text-center">
                                                    Localidad   
                                                </th>
                                                <th class="text-center">
                                                    Barrio 
                                                </th>
                                                <th class="text-center">
                                                    Otro Barrio 
                                                </th>
                                                <th class="text-center">
                                                    Dirección 
                                                </th>

                                                <th class="text-center">
                                                    Código Postal 
                                                </th>
                                                <th class="text-center">
                                                    Latitud 
                                                </th>
                                                <th class="text-center">
                                                    Longitud 
                                                </th>

                                            </tr>

                                            <tr>

                                                <td class="text-center"><?php echo $iteminfo['NombreCiudad']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['NombreLocalidad']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['NombreBarrio']; ?></td>

                                                <td class="text-center"><?php echo $iteminfo['OtroBarrio']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['Direccion']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['CodigoPostal']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['Latitud']; ?></td>

                                                <td class="text-center"><?php echo $iteminfo['Longitud']; ?></td>


                                            </tr>

                                        </table>
                                    </div>     

                                </td>

                            </tr>
                            
                            <tr>
                                <td colspan="11">

                                    <div class="table-responsive">

                                        <table class="table table-bordered">

                                            <tr style="background-color: #8DB4E2; font-size: 12px;">

                                                <th class="text-center" >
                                                    Frecuencia   
                                                </th>
                                                <th class="text-center">
                                                    Secuencia   
                                                </th>
                                                <th class="text-center">
                                                    Código Zona Ventas 
                                                </th>
                                                <th class="text-center">
                                                    Nombre Zona Ventas 
                                                </th>

                                            </tr>  

                                            <tr>

        <?php
        $frecuencia = "";


        switch ($iteminfo['frecuencia']) {

            case 'S':
                $frecuencia = 'Semanal';
                break;
            case 'Q':
                $frecuencia = 'Quincenal';
                break;
            case 'M':
                $frecuencia = 'Mensual';
                break;
        }
        ?>


                                                <td class="text-center"><?php echo $frecuencia; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['Posicion']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                                                <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td> 

                                            </tr>


                                        </table>

                                    </div>    


                                </td>

                            </tr>


                    </table>

                </div>    




            <?php } ?>

        <?php } ?>


    </form>   


</div>

 <?php $this->renderPartial('//mensajes/_alerta'); ?>

<script>

    function genrar_ClientesNuevos_excel() {
        document.formulario_clientesnuevos_excel.submit();
    }



</script>


