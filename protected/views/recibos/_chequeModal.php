<?php

$session = new CHttpSession;
$session->open();
if ($session['ChequeDetalle']) {
    $datosDetalle = $session['ChequeDetalle'];
} else {
    $datosDetalle = array();
}

echo '<pre>';
print_r($datosDetalle);

?>

<table class="table table-email">
    
    <tbody>
            
        <?php foreach ($datosDetalle as $item): ?>
        <tr>
            <td style="width: 8% !important;">
                <img style="width: 55px;" src="images/cheque_recibo.png">
            </td>                                 
            <td style="padding: 15px; width: 70%;">
                <div class="media">                                        
                    <div class="media-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Número: </strong> <?php echo $item['txtNumeroCheque'];?>
                            </div>
                            <div class="col-sm-6">                                
                                <strong>Cod Banco: </strong> <?php echo $item['txtBancoCheque'];?>
                                <input type="hidden" value="<?php echo $item['txtBancoCheque'];?>"/>
                            </div>
                            <div class="col-sm-6">
                                <strong>Cuenta: </strong><?php echo $item['txtCuentaCheque'];?>
                                <input type="hidden" value="<?php echo $item['txtCuentaCheque'];?>"/>
                            </div> 
                             <div class="col-sm-6">
                               <strong>Fecha: </strong><?php echo $item['txtFechaCheque'];?>
                            </div> 
                             <div class="col-sm-6">
                               <strong>Girado a: </strong><?php echo $item['txtOtro'];?>
                            </div>
                             <div class="col-sm-6">
                               <strong>Valor: </strong> <?php echo $item['txtValorChequeSaldo'];?>
                            </div> 
                        </div>
                       
                        
                    </div>
                </div>
            </td>
            <td>
               <img src="images/delete.png" style="width: 35px;" class="cursorpointer eliminarCheque" data-numero="<?php echo $item['txtNumeroCheque'];?>" data-factura="<?php echo $item['facturaRecibo']; ?>"/>
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>
