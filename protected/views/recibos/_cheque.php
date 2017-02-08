<?php
$session = new CHttpSession;
$session->open();
if ($session['Cheque']) {
    $datos = $session['Cheque'];
} else {
    $datos = array();
}

?>

<table class="table table-email">
    <tbody>
            
        <?php foreach ($datos as $item): ?>
        <?php $numeroCh = explode('-', $item['txtNumeroCheque']);?>
        <tr>
            <td style="width: 8% !important;">
                <img style="width: 30px;" src="images/comprobarFomasPago.png">
            </td>                                 
            <td style="padding: 15px; width: 70%;">
                <div class="media">                                        
                    <div class="media-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Factura:</strong> <?php echo $item['facturaRecibo'];?>
                            </div>
                            <div class="col-sm-6">
                                <strong>Número: </strong> <?php echo $numeroCh[0] ?>
                            </div>
                            <div class="col-sm-6">                                
                                <strong>Cod Banco: </strong> <?php echo $item['txtBancoCheque'];?>
                                <input type="hidden" value="<?php echo $item['txtBancoCheque'];?>"/>
                            </div>
                            <div class="col-sm-6">                                
                                <strong>Banco: </strong> <?php echo $item['textoBancoCheque'];?>
                           </div>
                            <div class="col-sm-6">
                                <strong>Cuenta: </strong><?php echo $item['txtCuentaCheque'];?>
                                <input type="hidden" value="<?php echo $item['txtCuentaCheque'];?>"/>
                            </div> 
                             <div class="col-sm-6">
                               <strong>Fecha: </strong><?php echo $item['txtFechaCheque'];?>
                            </div> 
                             <div class="col-sm-6">
                                 <?php if($item['txtGirado'] == 1){
                                     
                                     $Girado = 'Altipal'; 
                                     
                                 }else if($item['txtGirado'] == 2){
                                     
                                     $Girado = $item['txtOtro'];
                                     
                                 } ?>
                               <strong>Girado a: </strong><?php echo $Girado;?>
                            </div>
                             <div class="col-sm-6">
                               <strong>Valor: </strong> <?php echo $item['txtValorCheque'];?>
                            </div> 
                        </div>
                       
                        
                    </div>
                </div>
            </td>
            <td>
               <img src="images/cancelGeneral.png" style="width: 28px;" class="cursorpointer eliminarCheque" data-numero="<?php echo $item['txtNumeroCheque'];?>" data-factura="<?php echo $item['facturaRecibo']; ?>"/>
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>



