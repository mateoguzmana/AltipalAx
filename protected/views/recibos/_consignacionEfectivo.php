<?php
$session = new CHttpSession;
$session->open();
$codagencia = Yii::app()->user->_Agencia;
if ($session['ConsignacionEfec']) {
    $datos = $session['ConsignacionEfec'];
} else {
    $datos = array();
}
?>

<table class="table table-email">
    <tbody>

        <?php foreach ($datos as $item): ?>
            <?php $NumeroFactura = explode('-', $item['txtNumeroEc']); 
            $formasPagoEfectivoConsig = Consultas::model()->getFormasPagoDescription($codagencia,$item['txtFormaPag']);
            ?>
            <tr>
                <td style="width: 8% !important;">
                    <img style="width: 30px;" src="images/comprobarFomasPago.png">
                </td>                                 
                <td style="padding: 15px; width: 70%;">
                    <div class="media">                                        
                        <div class="media-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Factura:</strong><?php echo $item['facturaRecibo']; ?>
                                </div> 
                                <div class="col-sm-6">
                                    <strong>Número:</strong> <?php echo $NumeroFactura[0]; ?>
                                </div>
                                <div class="col-sm-6">                                
                                    <strong>Banco:</strong> <?php echo $item['textoBancoEc']; ?>
                                    <input type="hidden" value="<?php echo $item['txtBancoEc']; ?>"/>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Cuenta:</strong><?php echo $item['textoCuenta']; ?>
                                    <input type="hidden" value="<?php echo $item['txtCuenta']; ?>"/>
                                </div> 
                                <div class="col-sm-6">
                                    <strong>Fecha:</strong><?php echo $item['txtFechaEc']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Forma Pago:</strong><?php echo $formasPagoEfectivoConsig['Descripcion']; ?>
                                </div> 
                                <div class="col-sm-6">
                                    <strong>Valor:</strong> <?php echo $item['txtValorEc']; ?>
                                </div> 

                            </div>


                        </div>
                    </div>
                </td>
                <td>
                    <img src="images/cancelGeneral.png" style="width: 28px;" class="cursorpointer eliminarItemConsEfec" data-numero="<?php echo $item['txtNumeroEc']; ?>" data-factura="<?php echo $item['facturaRecibo']; ?>"/>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>



