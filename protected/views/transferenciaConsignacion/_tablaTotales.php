<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$session = new CHttpSession;
$session->open();
$datos = $session['pedidoForm'];

 

$precioNeto = 0;
$valorProveedor = 0;
$cantidad=0;
$valorAltipal = 0;
$valorEspecial = 0;
$valorDescuentos = 0;
$baseIva = 0;
$iva = 0;
$impoconsumo = 0;
$totalPedido = 0;
$preciobruto = 0;
$totaliva = 0;


$cont=0;
foreach ($datos as $itemDatos) {
    $precioNeto+=$itemDatos['valorSinImpoconsumo'];
    $valorProveedor+=$itemDatos['valorDescuentoProveedor'];
    $cantidad+=$itemDatos['cantidad'];
    $preciobruto+=$itemDatos['toatalvalorBruto'];
    $baseIva+=$itemDatos['precioNeto'];
    $iva+=$itemDatos['precioIva'];
    $impoconsumo+=$itemDatos['valorImpoconsumo'];
    $totalPedido+=$itemDatos['valorNeto'];
    $totaliva+=$itemDatos['totalValorIva'];
    
    
    $cont++;
}
?>


<div class="form-group">
    <label class="col-sm-3 control-label">Valor Bruto</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtPrecioNeto" value="<?php echo '$ '. number_format($preciobruto, '2', ',', '.'); ?>">
    </div>
</div>
  

<div class="form-group">
    <label class="col-sm-3 control-label">Valor Iva</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtIva" value="<?php echo  number_format($totaliva, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label"> Valor Impoconsumo</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtImpoconsumo" value="<?php echo '$ '. number_format($impoconsumo, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Total Cantidad</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtcantidad" value="<?php echo $cantidad ?>">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Valor Transferencia</label>
    <div class="col-sm-6">
        <input type="hidden" id="txtSaldoCupo" value="<?php echo $saldoCupo; ?>" name="saldoCupo" />  
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="" value="<?php echo '$ '. number_format($totalPedido, '2', ',', '.'); ?>">
        <input type="hidden" placeholder="" readonly="readonly" class="form-control" id="txtTotalPedido" value="<?php echo $totalPedido; ?>">
    </div>
</div>

<div class="form-group">
    <input type="hidden" value="<?php echo $cont; ?>" id="cantidad-enviar"/>
   
   
    
</div>

