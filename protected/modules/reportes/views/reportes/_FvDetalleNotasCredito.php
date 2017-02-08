 


<div class="panel-heading">
    <br> 
    <div align="center">
        <h2>
            <a  href="javascript:Notascredito();"><img style="width: 40px; height: 40px; float:left; margin-left: 20px;"  src="images/atras.png" title="Atra"></a>
            <b>
                Notas Credito
            </b>
            <a href="javascript:genrar_NotasCredito_excel();"><img style="width: 40px; height: 40px;" src="images/excel.png" title="Exporta"></a>
        </h2>
    </div>

    <form action="  index.php?r=reportes/Reportes/ExportarExcelNotasCredito" method=post name="formulario_notascredito_excel">    
        
        <input type="hidden" name="fechaini" value="<?php echo $fechaini ?>">
        <input type="hidden" name="fechafin" value="<?php echo $fechafin ?>">
        <input type="hidden" name="sql" value="<?php echo $sql ?>">
        <input type="hidden" name="agencia" value="<?php echo $agencia ?>">

        <?php
        foreach ($arraypuhs as $iteminfo) {
            ?>

            <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                <table class="table table-bordered" style="width: 100%;">

                    <tr style="background-color: #8DB4E2;  font-size: 12px;">

                        <th nowrap="nowrap" class="text-center">
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
                            Fecha Nota Crédito 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Hora Nota Crédito 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Valor 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Nro Transacción 
                        </th>
                        <th nowrap="nowrap" class="text-center">
                            Foto 
                        </th>
                         
                    </tr>


                    <tr>   
                        <td class="text-center"><?php echo $iteminfo['CodZonaVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['NombreZonadeVentas']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['CodAsesor']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Nombre']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Responsable']; ?></td>

                        
                        <td class="text-center"><?php echo $iteminfo['NombreEmpleado']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Fecha']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Hora']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['Valor']; ?></td>
                        <td class="text-center"><?php echo $iteminfo['ArchivoXml']; ?></td>
                        <td class="text-center">
                            <img src="images/fotos.png" style="width: 56px; height: 44px;"  class="cursorpointer"  onclick="Fotos('<?php echo $iteminfo['IdNotaCredito'] ?>','<?php  echo $iteminfo['CodAgencia'] ?>')" title="fotos">
                            <input type="hidden" value="<?php echo $iteminfo['Valor']; ?>">
                        </td>
                        
                        
                    </tr>   

                    <tr>
                        <td colspan="11">

                           <div style="width: 100%; overflow-x: scroll; border: solid #eee 2px;padding: 10px; border-radius: 5px;">

                                <table class="table table-bordered" style="width: 100%;">

                                    <tr style="background-color: #8DB4E2; font-size: 12px;">

                                        <th nowrap="nowrap" class="text-center">
                                            Cuenta Cliente   
                                        </th>
                                        <th nowrap="nowrap" class="text-center">
                                            Nombre Cliente   
                                        </th>
                                        <th nowrap="nowrap" class="text-center">
                                            Factura 
                                        </th>
                                        <th nowrap="nowrap" class="text-center">
                                            Concepto 
                                        </th>
                                        <th nowrap="nowrap" class="text-center">
                                            Responsable Nota 
                                        </th>
                                       
                                        <th nowrap="nowrap" class="text-center">
                                            Fabricante 
                                        </th>
                                        <th nowrap="nowrap" class="text-center" colspan="2">
                                            Observación 
                                        </th>
                                       

                                    </tr>

                                    <tr>   
                                        <td class="text-center"><?php echo $iteminfo['CuentaCliente']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['NombreCliente']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['Factura']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['NombreConceptoNotaCredito']; ?></td>
                                    
                                        <td class="text-center"><?php echo $iteminfo['Descripcion']; ?></td>
                                        <td class="text-center"><?php echo $iteminfo['Fabricante']; ?></td>
                                        <td class="text-center" colspan="2"><?php echo $iteminfo['Observacion']; ?></td>
                                        
                                    </tr>   



                                </table>

                            </div>    

                        </td>

                    </tr>



                <input type="hidden" value="<?php echo $sql ?>" id="sql" name="sql"/>
                <input type="hidden" value="<?php echo $fechaini ?>" id="fechaini" name="fechaini"/>
                <input type="hidden" value="<?php echo $fechafin ?>" id="fechafin" name="fechafin"/>

            </table>

        </div> 
                    <?php
                }
                ?>  
    </form>     

</div>


<div class="modal fade" id="_FvNotasCredito" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="msg">Mensaje</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: orange;"></span>
                    </div>
                    <div class="col-sm-10">
                        <div id="msgnotascredito" ></div>
                     </div>
                </div>
            </div>
            <div class="modal-footer">                 
                <button data-dismiss="modal" class="btn btn-primary" type="button">Aceptar</button>    
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="_FvDetalleFotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Fotos</h4>
            </div>
              <div id="tabladetallefoto" ></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>



<script>

    function genrar_NotasCredito_excel() {
        document.formulario_notascredito_excel.submit();
    }



</script>





