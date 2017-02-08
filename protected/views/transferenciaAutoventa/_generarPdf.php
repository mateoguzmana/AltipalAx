<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>


<table style="width: 100%">
    
    <tr>
        <td style="vertical-align: top;">
            <h4>FUERZA DE VENTAS ALTIPAL</h4>
            </br>
           
            <table style="width: 300px;">
                
                <tr>
                    <td>
                         Transferencia
                    </td>
                    <td style="vertical-align: top;">
                        <img src="images/transconsig.png" style="width: 45px;">
                    </td>
                </tr>
            </table>
            
        </td>
    </tr>
    
    <td>
         <img src="images/altipal_banner.png" style="width: 260px;"/>
    </td>
    
    
</table>

<hr/>

<div style="border: 1px solid #DDD">
    
    <table style="font-size: 11px;">
        <?php $cont=1; foreach ($transferenciaAutoventa as $itemTransferencia): ?>
        <tr>
            <td style="vertical-align: top; padding:2px 10px;">Número: <span><?php echo $itemTransferencia['IdTransferenciaAutoventa']; ?></span> </td>  
            <td style="vertical-align: top; padding:2px 10px;">Fecha: <span><?php echo $itemTransferencia['FechaTransferenciaAutoventa'];?></span></td>
        </tr>
        <tr>
            <td style="vertical-align: top; padding:2px 10px;">Zona ventas: <span><?php echo $itemTransferencia['CodZonaVentas'];?> -- <?php echo $itemTransferencia['NombreZonaVentas'];?></span></td>
            <td style="vertical-align: top; padding:2px 10px;">Transferencia Zona: <span><?php echo $itemTransferencia['CodZonaVentasTransferencia'];?> -- <?php echo $itemTransferencia['NombreZonaVentasTransferir'];?></span></td>
            
        </tr>
        <?php break; endforeach; ?>
    </table>  
    

<table style="margin: 15px; border: 1px solid #999; width: 100%; font-size: 11px;" cellspacing="0" cellpadding="0">  
    <tr>
        <th style="text-align: center; border: 1px solid #999;">No.</th>
        <th style="text-align: center; border: 1px solid #999;">Código Artículo</th>
        <th style="text-align: center; border: 1px solid #999;">Unidad Medida</th>
        <th style="text-align: center; border: 1px solid #999;">Cantidad</th>
        <th style="text-align: center; border: 1px solid #999;">No. Lote</th>
    </tr>
    <?php $cont=1; foreach ($transferenciaAutoventa as $itemTransferencia): ?>
    <tr> 
        <td style="text-align: center; border: 1px solid #999;">
            <b><?php echo $cont;?></b>
        </td>
        <td style="text-align: center; border: 1px solid #999; "><?php echo $itemTransferencia['CodVariante'];?></td>
        <td style="text-align: center; border: 1px solid #999;"><?php echo $itemTransferencia['NombreUnidadMedida'];?></td>
        <td style="text-align: center; border: 1px solid #999;"><?php echo $itemTransferencia['Cantidad'];?></td>
        <td style="text-align: center; border: 1px solid #999;"><?php echo $itemTransferencia['Lote'];?></td>
    </tr>
    
    <?php $cont++; endforeach; ?>    
</table>
    
</div>