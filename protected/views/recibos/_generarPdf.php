<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<style>
    
 @font-face {
    font-family: "recibos";
    //src: url('font/recibos_caja.ttf');
    src:url(http://pics.cssbakery.com/fonts/GraublauWeb.otf) format("opentype");
    font-weight:normal;
   font-style:normal;
}


.encabezadoRecibo{
    font-size: 11px;
    line-height: 10px;
   font-family: "Times New Roman", Times, serif;
}

.datos-asesor{
    font-size: 10px;
    margin-top: 10px;
    line-height: 8px;
     font-family: "recibos";
}

.datos-cliente{
    font-size: 10px;
    margin-top: 5px;
    line-height: 8px;
}
.detalle-facturas{
    font-size: 10px; 
     line-height: 8px;
     text-align: left;
     margin-top: 7px;
     width: 100%;
}

.border-top{
    text-align: left;
    padding: 5px;
}

.table-facturas{
 font-size: 10px;
 line-height: 8px;
 margin-top: 7px;
}
.pie-recibo{
    padding: 5px;
    text-align: center;
    font-size: 10px;
    line-height: 10px;
    margin-top: 20px;
}

</style>


<table class="encabezadoRecibo">
    <tr>
        <td><b>ALTIPAL S.A</b></td>
    </tr>
    <tr>
        <td><b>NIT: 800186960-6</b></td>
    </tr>
    <tr>
        <td><b>Tel: 294 8383</b></td>
    </tr>
</table>


<table class="datos-asesor">
    <tr>
        <td>Recibo de Caja: <?php echo $provisional;?></td>
    </tr>
    <tr>
        <td>Cód. Zona Ventas: <?php echo $datosZonaVentas['CodZonaVentas'];?></td>
    </tr>
    <tr>
        <td>Nombre Asesor: <?php echo $datosZonaVentas['Nombre']; ?></td>
    </tr>
</table>

<table class="datos-cliente">
    <tr>
        <td>Código cliente: <?php echo $datosCliente['CuentaCliente'];?></td>            
    </tr>
    
    <tr>
        <td>Cliente: <?php echo $datosCliente['NombreCliente'];?></td>            
    </tr>
    
    <tr>
        <td>Télefono: <?php echo $datosCliente['Telefono'];?></td>            
    </tr>
    
    <tr>
        <td>Dirección: <?php echo $datosCliente['DireccionEntrega'];?></td>            
    </tr>
</table>

<table class="detalle-facturas">
    <thead>
        <tr>
            <th class="border-top">Nro. Factura</th>
        <th class="border-top">Valor</th>
        <th class="border-top">Dto.</th>
    </tr>
    </thead>
    
    <tbody>
        <?php foreach ($facturasProvicional as $itemFacturas):?>
        <tr>
            <td><?php echo $itemFacturas['NumeroFactura']; ?></td>
            <td> $<?php echo number_format($itemFacturas['ValorAbono']);?></td>
            <td> $<?php echo number_format($itemFacturas['DtoProntoPago']); ?></td>
        </tr>        
        <?php endforeach;?>
    </tbody>
    
</table>

<table class="table-facturas">
    <thead>
    <tr>
        <th class="border-top">Forma Pago</th>        
    </tr>
    </thead>
    
    <tbody>
        <?php 
         $vf=0;
         $vfc=0;
         $vcc=0;
         $vc=0;
         
         $facturasRecibos= ModelRecibos::model()->getFacturasProvicional($zonaVentas, $cuentaCliente, $provisional);
         print_r($facturasRecibos);
        ?>
         <?php foreach ($facturasRecibos as $itemFacturas):  ?> 
                <?php 
                  $idReciboFactura=$itemFacturas['Id'];
                  
                  $valorFacturaEfectivo=ModelRecibos::model()->getValorFacturaEfectivo($idReciboFactura);
                  $valorFacturaEfectivoConsignacion=ModelRecibos::model()->getValorFacturaEfectivoConsignacion($idReciboFactura);
                  
                 $valorFacturaChequeConsignacion=ModelRecibos::model()->getValorFacturaChequeConsignacion($idReciboFactura);
                 $valorFacturaCheque=ModelRecibos::model()->getValorFacturaCheque($idReciboFactura);
                 
                  
                  $vf+=$valorFacturaEfectivo['Valor'];
                  $vfc+=$valorFacturaEfectivoConsignacion['Valor'];
                  $vcc+=$valorFacturaChequeConsignacion['Valor'];
                  $vc+=$valorFacturaCheque['Valor'];
          ?>
        
         <?php endforeach; ?>
        
        
        <?php 
         echo $vf;
        
        ?>
        
        <tr>
            <td style="padding: 5px 0px;">Efectivo/Cheque</td>
        </tr>
        <tr>
            <td>Efectivo: $<?php echo number_format($vf); ?></td>
        </tr>
        <tr>
            <td>Cheque: $<?php echo number_format($vc);?></td>
        </tr>
        
         <tr>
            <td style="padding: 5px 0px;">Consignación</td>
        </tr>
        <tr>
            <td>Efectivo: $<?php echo number_format($vfc); ?></td>
        </tr>
        <tr>
            <td>Cheque: $<?php echo number_format($vcc);?></td>
        </tr>
        
        
    </tbody>
</table>

<table class="pie-recibo">
    <tr>
        <td>
            <b>Nota: </b>Este recibo se considerá definitivo y valido cuando los cheques se hayan hecho efectivos.
            Todo cheque devuelto causará una sanción del 20% (Art 732 del CC) 
        </td>
    </tr>
</table>

