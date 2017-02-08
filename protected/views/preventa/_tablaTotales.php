<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$session = new CHttpSession;
$session->open();
$datos = $session['pedidoForm'];

/*echo $saldoCupo;
      exit();  */


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


$cont=0;

/*echo '<pre>';
print_r($datos);
echo '</pre>';*/

foreach ($datos as $itemDatos) {
   
    $precioNeto+=($itemDatos['precio']+$itemDatos['impoconsumo'])*$itemDatos['cantidad'];    
    $valorProveedor+=$itemDatos['totalValorDescuentoProveedor'];
    $cantidad+=$itemDatos['cantidad'];
    $valorAltipal+=$itemDatos['totalValorDescuentoAltipal'];
    $valorEspecial+=$itemDatos['totalValorDescuentoEspecial'];
    $valorDescuentos+=$itemDatos['totalValorDescuentos'];
    $baseIva+=$itemDatos['totalValorbaseIva'];
    $iva+=$itemDatos['totalValorIva'];
    $impoconsumo+=$itemDatos['valorImpoconsumo'];
    $totalPedido+=$itemDatos['valorNeto'];    
    
    $cont++;
}
?>


<div class="form-group">
    <label class="col-sm-3 control-label">Precio Neto</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtPrecioNeto" value="<?php echo number_format($precioNeto, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Descuento Promocional</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtDescuentoProveedor" value="<?php echo number_format($valorProveedor, '2', ',', '.'); ?>">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Descuento Canal</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtDescuentoAltipal" value="<?php echo number_format($valorAltipal, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Descuento Especial</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtDescuentoEspecial" value="<?php echo number_format($valorEspecial, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Valor Total Descuentos</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtValorTotalDescuento" value="<?php echo number_format($valorDescuentos, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Impoconsumo</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtImpoconsumo" value="<?php echo number_format($impoconsumo, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Sub Total</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtBaseIva" value="<?php echo number_format($baseIva, '2', ',', '.'); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">IVA</label>
    <div class="col-sm-6">
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="txtIva" value="<?php echo number_format($iva, '2', ',', '.'); ?>">
    </div>
</div> 

<div class="form-group">
    <label class="col-sm-3 control-label">Total Pedido</label>
    <div class="col-sm-6">
         <input type="hidden" value="<?php echo $cont;?>" id="cantidad-enviar"/> 
        <input type="hidden" id="txtSaldoCupo" value="<?php echo $saldoCupo; ?>" name="saldoCupo" />  
        <input type="text" placeholder="" readonly="readonly" class="form-control" id="" value="<?php echo number_format($totalPedido, '2', ',', '.'); ?>">
        <input type="hidden" placeholder="" readonly="readonly" class="form-control" id="txtTotalPedido" value="<?php echo $totalPedido; ?>">
    </div>
</div>



