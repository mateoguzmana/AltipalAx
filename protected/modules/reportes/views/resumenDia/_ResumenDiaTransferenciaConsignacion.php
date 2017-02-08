  
  

<div class="panel-heading">
    <br> 
    <div align="center">
    <h2>
       <b>
            Transferencia Consignación
        </b>
        <a href="javascript: redireccionar_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png"></a>
    </h2>
    </div>
     
    <?php
     
                foreach ($arraypuhs as $iteminfo) {
                    ?>
    
         <div class="table-responsive">

            <table class="table table-bordered">

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
                        Responsable  
                    </th>
                        <th  nowrap="nowrap" class="text-center">
                      Nombre Responsable  
                    </th>
                     <th nowrap="nowrap" class="text-center">
                       Sitio 
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Almacén
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Fecha Transferencia 
                    </th>
                    <th nowrap="nowrap" class="text-center">
                        Hora Transferencia
                    </th>
                   

                </tr>


                    <tr>   
                        <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Nombresitio']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreAlma']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['FechaTransferencia']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['HoraEnviado']; ?></td>
                       
                    </tr>
                    <tr>
                        <td colspan="10">
                             <div class="table-responsive">
                                 
                                 <table class="table table-bordered">
                                  
                                   <tr style="background-color: #C5D9F1; font-size: 12px;">
                                     <th class="text-center">Código Variante</th>
                                     <th class="text-center">Código Artículo</th>
                                     <th class="text-center">Nombre Artículo</th>
                                     <th class="text-center">Unidad Medida</th>
                                     <th class="text-center">Cantidad</th>
                                   </tr>
                                   <?php
                                   $detalleConsig = ReporteFzNoVentas::model()->getDetalleTrnasferenciaConsig($iteminfo['IdTransferencia'],$iteminfo['CodAgencia']);
                                   
                                   foreach ($detalleConsig as $itemDetalle){
                                   ?>
                                   <tr>
                                        
                                       <td class="text-center"><?php echo $itemDetalle['CodVariante']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['CodigoArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['NombreArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['NombreUnidadMedida']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['Cantidad']?></td>
                                         
                                   </tr>
                                   <?php } ?>
                                 </table>
                                 
                             </div>   
                              
                        </td>
                        
                    </tr>
                    
                   
            </table>

        </div>    

                    <?php
                }
              
   
    ?>



</div>

<?php $this->renderPartial('//mensajes/_alerta'); ?>




          
