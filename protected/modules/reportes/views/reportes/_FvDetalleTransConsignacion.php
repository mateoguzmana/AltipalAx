 
  

<div class="panel-heading">
    <br> 
    <div align="center">
    <h2>
       <a  href="javascript:transferenciaconsignacion();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a> 
        <b>
            Transferencia Consignación
        </b>
        <a href="javascript: redireccionar_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png"></a>
    </h2>
    </div>
     
    <?php
     
                foreach ($arraypuhs as $iteminfo) {
                    ?>
    
         <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

            <table class="table table-bordered" style="width: 100%;">

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
              
                </tr>


                    <tr>   
                        <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                    </tr>
                    
                   <tr style="background-color: #8DB4E2; font-size: 12px;">
                    
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
                    <th nowrap="nowrap" class="text-center">
                        Nro Transacción
                    </th>
                     <th nowrap="nowrap" class="text-center">
                        Estado
                    </th>
                    
                    </tr>
                    
                    <tr>
                       <td class="text-center"><?php echo $iteminfo['Nombresitio']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreAlma']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['FechaTransferencia']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['HoraEnviado']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>
                        <?php if($iteminfo['Estado'] == 2){
                            
                            $estado = 'Rechazada';
                        }else{
                            
                            $estado = 'Aprobada';
                        } ?>
                        <td class="text-center"><?php echo $estado; ?></td>  
                     </tr>
                        
                    
                    <tr>
                        <td colspan="10">
                            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">
                                 
                                 <table class="table table-bordered" style="width: 100%;">
                                  
                                   <tr style="background-color: #C5D9F1; font-size: 12px;">
                                     <th class="text-center">Código Artículo</th>
                                     <th class="text-center">Código Variante</th>
                                     <th class="text-center">Nombre Artículo</th>
                                     <th class="text-center">Unidad Medida</th>
                                     <th class="text-center">Cantidad</th>
                                   </tr>
                                   <?php
                                   $detalleConsig = ReporteFzNoVentas::model()->getDetalleTrnasferenciaConsig($iteminfo['IdTransferencia'],$iteminfo['CodAgencia']);
                                   
                                   foreach ($detalleConsig as $itemDetalle){
                                   ?>
                                   <tr>
                                       <td class="text-center"><?php echo $itemDetalle['CodigoArticulo']?></td>
                                       <td class="text-center"><?php echo $itemDetalle['CodVariante']?></td>
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




          
