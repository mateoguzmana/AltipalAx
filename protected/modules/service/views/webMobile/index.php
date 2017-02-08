<style>
    
    .top{
        font-size: 11px;
    }
    
    .td{
        font-size: 10px;
    }
    
</style>


<table style="width: 100%">
<tbody>
 
  <tr>
    <td class="active">
        
        <table>
            <tr>
                <td>
                    <b> <span class="top">Fecha: <?php echo date('Y-m-d H:i:s')?></span></b>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="top">ALTIPAL S.A</span>
                </td>
            </tr>
            <tr>
                <td><span class="top">Nit: 800.186.960-6</span></td>
            </tr>
            <tr>
                <td><span class="top">CRA 69 b NO 19A-47 --2948383</span></td>
            </tr>
            <tr>
                <td><span class="top">Bogotá - AA. 110931</span></td>
            </tr>         
        </table>
        
        <div style="padding-bottom: 25px;"></div>
        
    </td>
    <td style="text-align: right;">
        <img src="images/altipal_banner.png" style="width: 280px;"/>
    </td>    
  </tr> 
  
  <tr>
      <td colspan="2">
          
          <table style="width: 840px">
              <tr>
                  <td class="td" style="width: 50%"> Zona Ventas: <span><?php echo $datosZonaVentas[0]['CodZonaVentas']; ?> - <?php echo $datosZonaVentas[0]['NombreZonadeVentas']; ?></span></td>
                  <td class="td">Código Cliente: <span><?php echo $datosCliente[0]['CuentaCliente']; ?></span></td>
              </tr>
              
               <tr>
                  <td class="td" style="width: 50%"> Asesor comercial: <span><?php echo $datosZonaVentas[0]['Nombre']; ?></span></td>
                  <td class="td">Nombre Cliente: <span><?php echo $datosCliente[0]['NombreCliente']; ?></span></td>
              </tr>
              <tr>
                  <td class="td" style="width: 50%"> Celular: <span><?php echo $datosZonaVentas[0]['TelefonoMovilEmpresarial']; ?></span></td>
                  <td class="td">Razón social: <span><?php echo $datosCliente[0]['NombreBusqueda']; ?></span></td>
              </tr>
               <tr>
                  <td class="td" style="width: 50%"> </td>
                  <td class="td">Dirección: <span><?php echo $datosCliente[0]['DireccionEntrega']; ?></span></td>
              </tr>
              
          </table>
          
      </td>
      
  </tr>
  <?php 
    $zonaVentas = $datosZonaVentas[0]['CodZonaVentas'];
    $cuentaCliente = $datosCliente[0]['CuentaCliente'];
    ?>
   <tr>
      <td colspan="2">
          
          <table style="width: 840px">
              <tr>
                  <td class="td" style="width: 50%" colspan="4"> <b>Recibo Físico: <span><?php echo  $zonaVentas." ".$cuentaCliente. " ".$provisional;?></span></b>  </td>                
              </tr>
              <?php 
               $facturasRecibos =  WebMobile::model()->getFacturasProvicional($zonaVentas, $cuentaCliente, $provisional);
               $totalAbono=0;
               foreach ($facturasRecibos as $itemFacturas):  
                   $totalAbono+=$itemFacturas['ValorAbono'];
              ?>
               <tr>
                  <td class="td" style=""> Número Factura: <span><?php echo $itemFacturas['NumeroFactura'];?></span></td>
                  <td class="td">Fecha: <span><?php echo $itemFacturas['Fecha'];?></span></td>
                  <td class="td">Valor Cancelado: <span><?php echo '$'. number_format( $itemFacturas['ValorAbono']);?></span></td>
                  <td class="td">Descuento: <span><?php echo '$'. number_format( $itemFacturas['DtoProntoPago']);?></span></td>
                  <td class="td">Saldo: <span><?php echo '$'. number_format($itemFacturas['saldo']); ?></span></td>
              </tr>             
              <?php endforeach; ?>
              
          </table>
          
      </td>
      
  </tr>
  
  <tr>
      <td colspan="2">
          
          <table style="width: 860px">
              <tr>
                  <td class="td" style="width: 50%" colspan="5"> <b>Formas de Pago:</b>  </td>                
              </tr>
              
                <?php foreach ($facturasRecibos as $itemFacturas):  ?> 
                <?php 
                  $idReciboFactura=$itemFacturas['Id'];
                  
                  $valorFacturaEfectivo=WebMobile::model()->getValorFacturaEfectivo($idReciboFactura);
                  $valorFacturaEfectivoConsignacion=WebMobile::model()->getValorFacturaEfectivoConsignacion($idReciboFactura);
                  
                  $valorFacturaChequeConsignacion=WebMobile::model()->getValorFacturaChequeConsignacion($idReciboFactura);
                  $valorFacturaCheque=WebMobile::model()->getValorFacturaCheque($idReciboFactura);
                  //getValorFacturaCheque($id)
                ?>
               <tr>
                  <td class="td">Factura: <span><?php echo ($itemFacturas['NumeroFactura']); ?></span></td>
                  <td class="td">Efectivo: <span><?php echo '$'.number_format($valorFacturaEfectivo['Valor']);?></span></td>
                  <td class="td">Ef. Consignado: <span><?php echo '$'.number_format($valorFacturaEfectivoConsignacion['Valor']);?></span></td>
                  <td class="td">Ch. Cosnignado: <span><?php echo '$'.number_format( $valorFacturaChequeConsignacion['Valor']);?></span></td>
                  <td class="td">Cheque: <span><?php echo '$'. number_format($valorFacturaCheque['Valor']);?></span></td>
              </tr>             
              <?php endforeach; ?>
              
          </table>
          
      </td>
      
  </tr>
  
   <tr>
      <td colspan="2">          
          <table style="width: 860px">
              <tr>
                  <td style="width: 50%" colspan=""> 
                      <h5>Total Recibo: <?php echo $totalAbono;?></h5> 
                  </td>                
              </tr>
              
          </table>          
      </td>      
  </tr>
  
  <tr>
      <td colspan="2">          
          <table style="width: 860px">
              <tr>
                  <td style="width: 50%" style="text-align: center;"> 
                      <h4>***COPIA CLIENTE***</h4> 
                  </td>                
              </tr>
              
          </table>          
      </td>      
  </tr>
  
</tbody>
</table>