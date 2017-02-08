<?php 
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=notascredito.xls");
 
?>

<div class="contentpanel">

    <div class="panel panel-default">

eeeeeeeeeeeeeeeeeeeeee

        <div class="panel-body" style="min-height: 450px;">
            <div class="widget widget-blue">
                <div class="widget-content">
                    <div class="row"> 

                        <label><b>Agencia:</b>&nbsp; <?php echo $InformacionNotaCredito[0]['agencia']; ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><b>Grupo Venta:</b>&nbsp; <?php echo $InformacionNotaCredito[0]['NombreGrupoVentas']; ?></label>

                        <div class="col-sm-12">
                           
                            
                            <div style="overflow-y: scroll; min-height: 100%; max-height: 400px; border: solid 2px #eee">
                                <table class="table" border="1">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">No.</th>                                            
                                            <th class="text-center">Vendedor</th>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Concepto</th>
                                            <th class="text-center">No. Factura</th>
                                            <th class="text-center">Valor Factura</th>
                                            <th class="text-center">Valor Notas</th>
                                            <th class="text-center">% Notas</th>
                                            <th class="text-center">Responsable</th>
                                            <th class="text-center">Fecha Nota</th>
                                            <th class="text-center">Observaciones</th>    
                                                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                                                            
                                        <?php $cont=1; foreach ($InformacionNotaCredito as $ItemNotas): ?>
                                        <tr>
                                            <td><?php echo $cont ?></td>
                                            <td><?php echo $ItemNotas['Nombre']?></td>
                                            <td><?php echo $ItemNotas['NombreCliente']?></td>
                                            <td><?php echo $ItemNotas['NombreConceptoNotaCredito']?></td>
                                            <td><?php echo $ItemNotas['NumeroFactura']?><br/></td>
                                            
                                            
                                            <td nowrap="nowrap"><b><?php echo number_format($ItemNotas['ValorNetoFactura'],'2',',','.') ?></b></td>
                                            <td nowrap="nowrap"><b><?php echo number_format($ItemNotas['Valor'],'2',',','.') ?></b></td>
                                            <?php $porcetaje = $ItemNotas['Valor'] * 100 / $ItemNotas['ValorNetoFactura']  ?>
                                            <td nowrap="nowrap"><b><?php echo number_format($porcetaje,'2',',','.') ?> % </b></td>
                                             <?php 
                                            if($ItemNotas['NombreCuentaProveedor'] == ""){
                                                
                                                $responsable = 'Altipal';
                                            }else{
                                                
                                                $responsable = $ItemNotas['NombreCuentaProveedor'];
                                            }
                                              
                                            
                                            ?>
                                            <td nowrap="nowrap"><?php echo $responsable ?></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['Fecha'] ?></td>
                                            <td nowrap="nowrap"><?php echo $ItemNotas['Observacion'] ?></td>
                                        </tr>
                                        
                                        <?php $cont++; endforeach; ?>
                                       
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

