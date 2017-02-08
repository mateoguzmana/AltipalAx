<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $session=new CHttpSession;
 $session->open();
 $datos=$session['pedidoForm'];

?>

         <table class="table table-bordered" id="tableDetail">
              <thead>
                 <tr>
                    <th>No.</th>
                    <th>Codigo Variante</th>
                    <th>Descripción</th>                    
                    <th>Saldo</th>                    
                    <th>Valor</th>
                    <th>Cantidad</th>
                    <th>Descuento Proveedor</th>
                    <th>Descuento Altipal</th>
                    <th>Descuento Especial</th>  
                     <th>Valor Neto</th>  
                    <th>Valor Total</th>  
                    <th></th>   
                 </tr>
              </thead>
              <tbody>
                <?php $cont=1; foreach ($datos as $item){ ?>
                 
                  <tr>
                    <th><?php echo $cont;?></th>
                    <th><?php echo $item['variante'];?></th>
                    <th><?php echo $item['nombreProducto'];?></th>                    
                    <th><?php echo $item['saldo'];?></th>                    
                    <th><?php echo number_format(($item['valorUnitario']+$item['impoconsumo']), '2', ',', '.');?></th>
                    <th><?php echo $item['cantidad'];?></th>
                    <th><?php echo $item['descuentoProveedor'];?></th>
                    <th><?php echo $item['descuentoAltipal'];?></th>
                    <th><?php echo $item['descuentoEspecial'];?></th>    
                     <th><?php echo number_format($item['valorNetoUnitario'], '2', ',', '.');?></th>  
                    <th><?php echo number_format ($item['valorNeto'], '2', ',', '.');?></th>                       
                    <th><img src="images/delete.png" style="width: 25px;" class="delete-item-pedido" data-variante="<?php echo $item['variante'];?>"/></th>   
                 </tr>
                
                <?php $cont++; } ?>
                 
              </tbody>
   </table>