<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$session = new CHttpSession;
$session->open();
$datos = $session['pedidoForm'];


//echo '<pre>';
//print_r($datos);
//echo '</pre>';
?>

<table class="table table-bordered table-hover" id="tableDetail">
    <thead>
        <tr>
            <th>No.</th>
            <th>Código Variante</th>
            <th>Descripción</th>                    
            <th>Saldo</th>                    
            <th>Valor</th>
            <th>Cantidad</th>
            <th>Descuento Promocional</th>
            <th>Descuento Canal</th>
            <th>Descuento Especial</th>  
            <th>Valor Unitario Neto</th>  
            <th>Valor Total</th>  
            <th></th>
            <th></th> 
        </tr>
    </thead>
    <tbody>
<?php $cont = 1;
foreach ($datos as $item) { ?>

            <tr>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $cont; ?></th>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $item['variante']; ?></th>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $item['nombreProducto']; ?></th>                    
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $item['saldo']; ?></th>                    
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" >$<?php echo number_format(($item['valorUnitario'] + $item['impoconsumo']), '2', ',', '.'); ?></th>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $item['cantidad']; ?></th>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $item['descuentoProveedor']; ?></th>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" ><?php echo $item['descuentoAltipal']; ?></th>
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>"><?php echo $item['descuentoEspecial']; ?></th>    
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" >$<?php echo number_format($item['valorProducto'], '2', ',', '.'); ?></th>  
                <th class="actulizarPortafolio cursorpointer" data-variante="<?php echo $item['variante']; ?>" >$<?php echo number_format($item['valorNeto'], '2', ',', '.'); ?></th>                       
                <th class="text-center cursorpointer">
                    <img src="images/delete.png" style="width: 25px;" class="delete-item-pedido" data-variante="<?php echo $item['variante']; ?>"/>
                    <br/>
                    <small>Eliminar</small>
                </th> 
                <th class="<?php
                            if ($item['codigoTipo'] == "KD"){
                                echo "btnAdicionarKitDinamico";
                            }else if ($item['codigoTipo'] == "KV") {
                                echo "btnAdicionarKitVirtual";
                            } else {
                                echo "btnAdicionarProductoDetalleAct";
                            }
                            ?>   cursorpointer text-center" 

                    data-CodigoVariante="<?php echo $item['variante']; ?>" 
                    data-CodigoArticulo ="<?php echo $item['articulo'] ?>"
                    data-ACCodigoUnidadMedida="<?php echo $item['codigoUnidadMedida']; ?>"                                                
                    data-ACNombreUnidadMedida="<?php echo $item['nombreUnidadMedida']; ?>"
                    data-codigotipo="<?php echo $item['codigoTipo']; ?>"
                    data-lote="<?php echo $item['txtlote']; ?>"
                    data-saldo="<?php echo $item['saldo']; ?>"


                    style="width: 5% !important;">

                    <img src="images/edit.png" style="width: 25px;"/>
                    <br/>
                    <small>Modificar</small>
                </th>
            </tr>

    <?php $cont++;
} ?>

    </tbody>
</table>