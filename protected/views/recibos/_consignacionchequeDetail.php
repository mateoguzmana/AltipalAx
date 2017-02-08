<?php
$session = new CHttpSession;
$session->open();
if ($session['ConsignacionChequeDetalle']) {
    $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
} else {
    $datosConsignacionChequeDta = array();
    
}

/*echo '<pre>';
print_r($datosConsignacionChequeDta);*/
?>
<table class="table table-email">
    <tbody>
           
        <?php foreach ($datosConsignacionChequeDta as $item): ?>
        <tr>
            <td style="width: 8% !important;">
                <img style="width: 30px;" src="images/verificarFotmasPago.png">
            </td>                                 
            <td style="padding: 15px; width: 70%;">
                <div class="media">                                        
                    <div class="media-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="text-primary">Consignación</h5>
                            </div>    
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Número:</strong> <?php echo $item['txtNumeroECc'];?>
                            </div>
                            <div class="col-sm-6">                                
                                <strong>Banco:</strong> <?php echo $item['txtBancoECc'];?>
                                <input type="hidden" value="<?php echo $item['txtBancoECc'];?>"/>
                            </div>
                            <div class="col-sm-6">
                                <strong>Cuenta:</strong><?php echo $item['txtCuentaECc'];?>
                                <input type="hidden" value="<?php echo $item['txtCuentaECc'];?>"/>
                            </div> 
                        </div>
                       
                    </div>
                </div>
            </td>
            <td>
                <img src="images/cancelGeneral.png" style="width: 25px;" class="cursorpointer" data-txtNumeroECc='<?php echo $item['txtNumeroECc']; ?>' data-txtCodBancoECc='<?php echo $item['txtCodBancoECc']; ?>' id='eliminarConsigCheque'/>
            </td>
          </tr>
        <tr>
            <td colspan="3">
                 <table class="table table-bordered ">
                    <tr>
                        <td colspan="6">
                            <h5 class="text-primary">Cheque</h5>
                        </td>                        
                    </tr>
                    <tr>
                        <th class="text-center">Número</th>
                        <th class="text-center">Banco</th>
                        <th class="text-center">Cuenta</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center"></th>
                    </tr>
                <?php foreach ($item['detalle'] as $subItem): ?>
                    <tr>
                        <th class="text-center"><?php echo $subItem['txtNumeroDCc'] ;?></th>
                        <th class="text-center"><?php echo $subItem['MsgBancoCc'];?></th>
                        <th class="text-center"><?php echo $subItem['txtCuentaDCc'];?></th>
                        <th class="text-center"><?php echo $subItem['txtValorTotalDCcSaldo'];?></th>
                        <th class="text-center">                            
                            <img src="images/cancelGeneral.png" style="width: 25px;" class="cursorpointer" data-txtNumeroDCCheque='<?php echo $subItem['txtNumeroDCc']; ?>' data-txtCodBancoDCCheque='<?php echo $subItem['txtCodBancoDCc']; ?>' data-txtNumeroECCheque='<?php echo $item['txtNumeroECc'] ?>' id='eliminarConsigChequeDetalle'/>
                        </th>
                    </tr>
                
                <?php endforeach; ?>                      
                </table>    
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>




