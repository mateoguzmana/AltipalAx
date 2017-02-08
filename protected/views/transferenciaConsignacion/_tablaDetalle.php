<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$session = new CHttpSession;
$session->open();
$datos = $session['pedidoForm'];

/*echo '<pre>';
print_r($datos);
echo '</pre>';*/

?>
<div class="row">   
    <div class="table-responsive" id="tableDetail">
        <table class="table table-bordered" id="tableDetail">
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Código Artículo</th>
                    <th class="text-center">Descripción</th>                    
                    <th class="text-center">Unidad de medida</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Valor</th>
                    <th class="text-center"></th>   
                </tr>
            </thead>
            <tbody>
<?php $cont = 1;
foreach ($datos as $item) { ?>

                    <tr class="cursorpointer">
                        <th class="text-center"><?php echo $cont; ?></th>
                        <th class="text-center"><?php echo $item['variante']; ?></th>
                        <th class="text-center"><?php echo $item['nombreProducto']; ?></th>                    
                        <th class="text-center"><?php echo $item['unidadMedida'] ?></th>
                        <th class="text-center"><?php echo $item['cantidad']; ?></th>
                        <th class="text-center"><?php echo number_format(($item['valorUnitario'] + $item['impoconsumo']), '2', ',', '.'); ?></th>

                        <th class="text-center"><img src="images/delete.png" style="width: 25px;" class="delete-item-pedido"  data-variante="<?php echo $item['variante']; ?>"/></th>   
                        <th class="text-center">
                            <img src="images/edit.png" title="Editar" style="width: 27px;" title="Editar"  class="adicionar-producto-detalle-transaccion-actualizar" data-codigo-variante="<?php echo $item['variante'];?>"
                            data-cliente="<?php echo $item['codigoCliente']; ?>"
                            data-articulo="<?php echo $item['articulo']; ?>"
                            data-grupo-ventas="<?php echo $item['grupoVentas']; ?>"
                            data-zona="<?php echo $item['zonaVentas']; ?>"
                            data-id-inventario="<?php echo $item['saldo'] ?>"   >
                        </th>
                        
                    </tr>

    <?php $cont++;
} ?>

            </tbody>
        </table>
    </div>

</div>