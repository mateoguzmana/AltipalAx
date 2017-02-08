<?php
$session = new CHttpSession;
$session->open();
if ($session['Efectivo']) {
    $datos = $session['Efectivo'];
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
                            <div class="col-sm-6">
                                <strong>Factura:</strong> <?php echo $item['facturaRecibo'];?>
                            </div>
                            <div class="col-sm-6">
                                <strong>Valor:</strong> <?php echo $item['valorEfectivo'];?>
                            </div>                           
                            
                        </div>
                       
                        
                    </div>
                </div>
            </td>
            <td>
                <img src="images/cancelGeneral.png" style="width: 28px;" class="cursorpointer eliminarEfectivoItem" data-factura="<?php echo $item['facturaRecibo'];?>" data-valor="<?php echo $item['valorEfectivo']  ?>" data-valortotal="<?php echo $item['totalEfectivo']; ?>" id="deleteItemFactEfectivo"/>
            </td>
        </tr>
        <?php endforeach;?>

    </tbody>
</table>


