<?php
$session = new CHttpSession;
$session->open();
if ($session['EfectivoDetalle']) {
    $datos = $session['EfectivoDetalle'];
} else {
    $datos = array();
}
?>
<table class="table table-email">
    <tbody>  
        <?php foreach ($datos as $key => $item):?> 
        <tr>
            <td style="width: 8% !important;">
                <img style="width: 30px;" src="images/verificarFotmasPago.png">
            </td>                                 
            <td style="padding: 15px; width: 70%;">
                <div class="media">                                        
                    <div class="media-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <strong>Valor Efectivo: </strong> <?php echo $item['ValorEfectivo'];?>
                            </div>                            
                        </div>                                               
                    </div>
                </div>
            </td>
            <td>
                <img src="images/cancelGeneral.png" style="width: 28px;" class="cursorpointer" data-txtValorEfectivo="<?php echo $item['ValorEfectivo'].'-'.$key ?>" id="eliminarEfectivoDetalle"/>
            </td>
        </tr>
        <?php  endforeach; ?>
    </tbody>
</table>




