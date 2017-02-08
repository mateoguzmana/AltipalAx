<?php
$session = new CHttpSession;
$session->open();
if ($session['ChequeDetalle']) {
    $datos = $session['ChequeDetalle'];
} else {
    $datos = array();
}


?>

<table class="table table-email">
    <tbody>
            
        <?php foreach ($datos as $item): ?>
        <tr>
            <td style="width: 8% !important;">
                <img style="width: 30px;" src="images/verificarFotmasPago.png">
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
                            </div>
                            <div class="col-sm-6">
                                <strong>Banco: </strong> <?php echo $item['textoBancoCheque'];?>
                            </div>
                            <div class="col-sm-6">
                                <strong>Cuenta: </strong> <?php echo $item['txtCuentaCheque'];?>
                            </div>
                            <div class="col-sm-6">
                                <strong>Fecha: </strong> <?php echo $item['txtFechaCheque'];?>
                            </div>
                            <div class="col-sm-6">
                               <strong>Valor: </strong> <?php echo $item['txtValorChequeSaldo'];?>
                            </div> 
                            <div class="col-sm-6">
                                <?php if($item['txtGirado'] == 1){
                                    
                                    $Girado= 'Altipal';
                                }else{
                                    
                                    $Girado= $item['txtOtro'];
                                }
                                ?>
                               <strong>Girado a: </strong> <?php echo $Girado ;?>
                            </div> 
                        </div>
                       
                        
                    </div>
                </div>
            </td>
            <td>
                <img src="images/cancelGeneral.png" style="width: 28px;" class="cursorpointer" data-txtNumeroCheque='<?php echo $item['txtNumeroCheque']; ?>' data-txtCodBancoCheque='<?php echo $item['txtBancoCheque']; ?>' id="eliminarCheque"/>
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>




