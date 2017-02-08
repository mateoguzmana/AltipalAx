<?php
$session = new CHttpSession;
$session->open();
if ($session['ConsignacionCheque']) {
    $datos = $session['ConsignacionCheque'];
} else {
    $datos = array();
}

/*echo '<pre>';
print_r($datos);*/

?>


<table class="table table-email">
    <tbody>
            
        <?php foreach ($datos as $item): ?>
        <tr>
            <td style="width: 8% !important;">
                <img style="width: 30px;" src="images/comprobarFomasPago.png">
            </td>                                 
            <td style="padding: 15px; width: 70%;">
                <div class="media">                                        
                    <div class="media-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 class="text-primary">Datos Consignación</h5>
                            </div>    
                        </div>
                        <?php $NumeroConsignacion = explode('-', $item['txtNumeroECc']); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Factura:</strong> <?php echo $item['facturaRecibo'];?>
                            </div>
                            <div class="col-sm-6">
                                <strong>Número:</strong> <?php echo $NumeroConsignacion[0];?>
                            </div>
                            <div class="col-sm-6">                                
                                <strong>Banco:</strong> <?php echo $item['textoBancoECc'];?>
                                <input type="hidden" value="<?php echo $item['txtBancoECc'];?>"/>
                            </div>
                            <div class="col-sm-6">
                                <strong>Cuenta:</strong><?php echo $item['textoCuentaECc'];?>
                                <input type="hidden" value="<?php echo $item['txtCuentaECc'];?>"/>
                            </div> 
                             <div class="col-sm-6">
                               <strong>Fecha:</strong><?php echo $item['txtFechaECc'];?>
                            </div> 
                            
                        </div>
                       
                    </div>
                </div>
            </td>
            <td>
                <img src="images/cancelGeneral.png" style="width: 25px;" class="cursorpointer eliminarItemConsCheque" data-numero="<?php echo $item['txtNumeroECc'];?>" data-factura="<?php echo $item['facturaRecibo'];?>" data-val="<?php echo $item['detalle'][0]['txtValorDCc'] ?>" data-num="<?php echo $item['detalle'][0]['txtNumeroDCc'];?>"/>
                <?php foreach ($item['detalle'] as $itemDeta): ?>
                <input type="hidden" class="chequeAliminar" data-val="<?php echo $itemDeta['txtValorDCc'] ?>" data-num="<?php echo $itemDeta['txtNumeroDCc'];?>">
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                 <table class="table table-bordered ">
                    <tr>
                        <td colspan="6">
                            <h5 class="text-primary">Datos Cheque</h5>
                        </td>                        
                    </tr>
                    <tr>
                        <th class="text-center">Número</th>
                        <th class="text-center">Cod Banco</th>
                        <th class="text-center">Banco</th>
                        <th class="text-center">Cuenta</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center"></th>
                    </tr>
                <?php foreach ($item['detalle'] as $subItem): ?>
                    <?php $NumeroChe = explode('-', $subItem['txtNumeroDCc']); ?>
                     <tr>
                        <th class="text-center"><?php echo $NumeroChe[0] ;?></th>
                        <th class="text-center"><?php echo $subItem['txtBancoDCc'];?></th>
                        <th class="text-center"><?php echo $subItem['textoBancoDCc'];?></th>
                        <th class="text-center"><?php echo $subItem['textoCuentaDCc'];?></th>
                        <th class="text-center"><?php echo $subItem['txtFechaDCc'];?></th>
                        <th class="text-center"><?php echo $subItem['txtValorDCc'];?></th>
                        <th class="text-center">                            
                            <!--<img src="images/cancelGeneral.png" style="width: 25px;" class="cursorpointer eliminarSubItemConsCheque" data-numero="<?php //echo $item['txtNumeroECc'];?>" data-subnumero="<?php //echo $subItem['txtNumeroDCc'];?>" data-valorDcc="<?php //echo $subItem['txtValorDCc'];?>"  data-factura="<?php //echo $item['facturaRecibo'];?>"/>-->
                        </th>
                    </tr>
                
                <?php endforeach; ?>                      
                </table>    
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>



