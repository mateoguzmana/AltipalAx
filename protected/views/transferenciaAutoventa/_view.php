<?php
$session = new CHttpSession;
$session->open();

$datosTA = $session['TrnasAutoForm'];
$datosPedido = $session ['TrnasAutoPedido'];

/*echo '<pre>';
print_r($datosPedido);*/

?>


<div class="row">                          
    <div class="table-responsive" id="tableDetail">
        <table class="table table-bordered" id="tableDetail">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Código Artículo</th>
                    <th>Descripción</th>                    
                    <th>Cantidad</th>
                    <th>Lote</th>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $cont = 1;
                $sum=0;
                foreach ($datosTA as $item) {
                 $Multi = $item['PrecioVenta'] * $item['Cantidad'];    
                 $totalTranferencia = $sum=$sum+$Multi; 
                    ?> 
                   <tr class="cursorpointer">
                     <td class="cont"><?php echo $cont ?></td>
                       
                        <td class="cont" data-variante="<?php echo $item['CodVariante']; ?>" data-lote="<?php echo $item['Lote']; ?>"><?php echo $item['CodVariante']; ?></td>
                        <td class="cont" data-variante="<?php echo $item['CodVariante']; ?>" data-lote="<?php echo $item['Lote']; ?>"><?php echo $item['NombreArticulo']; ?></td>
                        <td class="cont" data-variante="<?php echo $item['CodVariante']; ?>" data-lote="<?php echo $item['Lote']; ?>"><?php echo $item['Cantidad']; ?></td>
                        <td class="cont" data-variante="<?php echo $item['CodVariante']; ?>" data-lote="<?php echo $item['Lote']; ?>"><?php echo $item['Lote']; ?></td>
                        <td class="cont" data-variante="<?php echo $item['CodVariante']; ?>" data-lote="<?php echo $item['Lote']; ?>"><?php echo number_format($Multi,'2',',','.'); ?></td>
                        <td><img src="images/delete.png" style="width: 25px;" class="deleteItem" data-variante="<?php echo $item['CodVariante'] ?>" data-lote="<?php echo $item['Lote'] ?>"></td>
                        <td class="cont" data-variante="<?php echo $item['CodVariante']; ?>" data-lote="<?php echo $item['Lote']; ?>"><img src="images/edit.png" title="Editar" style="width: 27px;"></td>
                        <input type="hidden"  value="<?php echo $item['PrecioVenta']; ?>" /> 
                     </tr>
                    
                    <?php $cont++;
                }
                $TotalPedidos = $datosPedido['TotalPedidos'];
                $CupoLimiteAuto = $datosPedido['CupoLimiteAutoventa'];
                $CupoDisponible = $CupoLimiteAuto - $TotalPedidos;
                 ?>
                   <tr>
                        
                       <td colspan="7" class="text-right" >
            <input type="hidden" value="<?php echo  count($datosTA) ?>" id="cantidad"/>     
            <input type="hidden" name="totalTranferencia" value="<?php echo $totalTranferencia ?>" id="TotalTranferencia">
            <input type="hidden" value="<?php  echo $TotalPedidos ?>" id="TotalPedidos">
            <input type="hidden" value="<?php  echo $CupoLimiteAuto ?>" id="CupoLimiteAutoventa">
            <input  type="hidden" value="<?php echo $CupoDisponible  ?>" id="CupoDisponible">
            </td>
             </tr>  
            </tbody>

        </table>
       
    </div>
</div>



<div class="modal fade" id="editDialog" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="">Editar</h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">Cantidad:</label>
                    <div class="col-sm-6">
                        <input type="text" id="canti"  class="form-control" value="<?php echo $item['Cantidad']; ?>"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <input type="button" class="btn btn-primary" onclick="editar()" value="Aceptar"/>   
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<?php $this->renderPartial('//mensajes/_alertConfirmationDeleteTrnasAuto');?>