<?php
$session = new CHttpSession;
$session->open();
$codagencia = Yii::app()->user->_Agencia;
if ($session['ConsignacionEfecDetalle']) {
    $datosConsignacion = $session['ConsignacionEfecDetalle'];
} else {
    $datosConsignacion = array();
}
?>

<table class="table table-email">
    <tbody>

<?php foreach ($datosConsignacion as $item): 
    $formasPagoEfectivoConsig = Consultas::model()->getFormasPagoDescription($codagencia,$item['txtFormaPag']);
    ?>
            <tr>
                <td style="width: 8% !important;">
                    <img style="width: 30px;" src="images/verificarFotmasPago.png">
                </td>                                 
                <td style="padding: 15px; width: 70%;">
                    <div class="media">                                        
                        <div class="media-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Número: </strong> <?php echo $item['txtNumeroEc']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Cod Banco: </strong> <?php echo $item['txtCodBancoEc']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Banco: </strong> <?php echo $item['txtBancoEc']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Cuenta: </strong> <?php echo $item['txtCuenta']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Fecha: </strong> <?php echo $item['txtFechaEc']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Forma Pago: </strong> <?php echo $formasPagoEfectivoConsig['Descripcion']; ?>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Valor: </strong> <?php echo $item['txtValorTotalEcSaldo']; ?>
                                </div> 
       
                            </div>
 
                        </div>
                    </div>
                </td>
                <td>
                    <img src="images/cancelGeneral.png" style="width: 28px;" class="cursorpointer" data-txtNumeroEfectivoConsignacion="<?php echo $item['txtNumeroEc']; ?>" data-txtCodBancoEfectivoConsig="<?php echo $item['txtCodBancoEc']; ?>" id='eliminarConsigEfectivoDetalle'/>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>




