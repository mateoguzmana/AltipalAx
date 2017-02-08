<style>
    
    .top{
        font-size: 12px;
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
                <td>
                    <span class="top">Autoventa</span>
                </td>
            </tr>
            <tr>
                <td><span class="top">Nit: 800.186.960-6</span></td>
            </tr>
            <tr>
                <td><span class="top">CRA 69 b No 19A-47 --2948383</span></td>
            </tr>
            <tr>
                <td><span class="top">Bogotá - AA. 110931</span></td>
            </tr> 
            <tr>
                <td><span class="top">Servicio al cliente 018000510037</span></td>
            </tr> 
            <tr>
                <td><span class="top">SOMOS GRANDES CONTRIBUYENTES RESOLUCION.</span></td>
            </tr>
            <tr>
                <td><span class="top">RESOLUCION 11076 DEL 14 DICIEMBRE DE 2001 </span></td>
            </tr>
            <tr>
                <td><span class="top">SOMOS AUTORRETENEDORES SEGUN RESOLUCION 2102 DEL 7 DE MARZO DE 2001</span></td>
            </tr>
            <tr>
                <td><span class="top">IVA REGIMEN COMUN RADICACION No. 2945-002363</span></td>
            </tr>
             <tr>
                <td><span class="top">Agente Retenedor de IVA-ICA RESOLUCION DIAN 310000071679 DE 2013-07-15 NUMERACION AUTORIZADA DEL 000-455088 AL 000-1000000</span></td>
            </tr>
        </table>
        
        <div style="padding-bottom: 25px;"></div>
        
    </td>
     
  </tr> 
  
  <tr>
      <td colspan="2">
          
          <table style="width: 840px">
              <tr>
                  <td class="td" colspan="4"> <b>Factura Física: <span><?php echo $factura;?></span></b>  </td>                
              </tr>
              <tr>
                  <td class="top"> Zona Ventas: <span><?php echo $datosZonaVentas[0]['CodZonaVentas']; ?> - <?php echo $datosZonaVentas[0]['NombreZonadeVentas']; ?></span></td>
              </tr>
              <tr>
                 <td class="top">Cuenta Cliente: <span><?php echo $datosCliente[0]['CuentaCliente']; ?></span></td>  
              </tr>
              <tr>
                   <td class="top"> Asesor comercial: <span><?php echo $datosZonaVentas[0]['Nombre']; ?></span></td>
              </tr>
              <tr>
                   <td class="top"> Nit: <span><?php echo $datosCliente[0]['Identificacion']; ?></span></td> 
              </tr>
              <tr>
                  <td class="top"> Celular: <span><?php echo $datosZonaVentas[0]['TelefonoMovilEmpresarial']; ?></span></td>
              </tr>
              <tr>
                 <td class="top">Razón social: <span><?php echo $datosCliente[0]['NombreBusqueda']; ?></span></td> 
              </tr>
               <tr>
                  <td class="top">Dirección: <span><?php echo $datosCliente[0]['DireccionEntrega']; ?></span></td>
              </tr>
              
          </table>
          
      </td>
      
  </tr>
  <br>
   <tr>
      <td colspan="2">
          
          <table style="width: 840px">
              <tr>
                  Detalllado de la venta
              </tr>
              <?php 
               foreach ($datosPedidos as $itemPedidos):  
              ?>
               <tr>
                  <td class="top" nowrap="nowrap"> Producto: <span><br><?php echo $itemPedidos['NombreArticulo'];?></span></td>
                  <td class="top">Cantidad: <span><br><?php echo $itemPedidos['Cantidad'];?></span></td>
                  <td class="top">Valor unitario: <span><?php echo '$'. number_format($itemPedidos['ValorUnitario'], '2',',','.');?></span></td>
                  <td class="top">Valor total: <span><?php echo '$'. number_format( $itemPedidos['TotalPrecioNeto']);?></span></td>
              </tr>
              <?php endforeach; ?>
              
          </table>
       
      </td>
      
  </tr>
  <br>
  <tr>
      <td colspan="2">
          
          <table style="width: 840px">
             
              <tr>
                  <td class="top" style=""> Sub Total: <span><?php echo number_format($datosPedidos[0]['TotalSubtotalBaseIva'],'2',',','.');?></span></td>
              </tr>        
              <tr>
                  <td class="top">Iva: <span><?php echo number_format($datosPedidos[0]['TotalValorIva'],'2',',','.');?></span></td>
              </tr>
              <tr>
                 <td class="top">SubTotal Base Iva: <span><?php echo  number_format( $datosPedidos[0]['TotalSubtotalBaseIva'], '2',',','.');?></span></td>
              </tr>
              <tr>
                <td class="top">Descuento: <span><?php echo  number_format( $datosPedidos[0]['TotalValorDescuento'],'2',',','.');?></span></td>  
              </tr>
              <tr>    
                 <td class="top">SubTotal Ipoconsumo: <span><?php echo number_format( $datosPedidos[0]['TotalValorImpoconsumo'],'2',',','.');?></span></td>
              </tr>
              <tr>
                <td class="top">Total: <span><?php echo number_format( $datosPedidos[0]['ValorPedido']);?></span></td>  
              </tr>
              
               <tr>
                  <td class="top"> Tipo Pago: <span><?php echo $datosPedidos[0]['FormaPago'];?></span></td>
               </tr>
                
              
          </table>
          
      </td>
      
  </tr>
  
  
  <tr>
      <td colspan="2">          
          <table style="width: 860px">
              <tr>
                  <td  class="td" style="width: 50%"> 
                     Notas:
                         1.En caso de mora se causara el interes maximo permitido por la ley.
                         <br>
                         2.Favor girar cheque cruzado a nombre de ALTIPAL S.A.
                         <br>
                         3.Autorizo a ALTIPAL y/o ALPAAR S. en C.S a consultar,reportar y divulgar a cualquier entidad que maneje o administre base de datos,toda la informacion pertinente sobre mi comportamiento crediticio.
                     
                      
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
                      <h4>***COPIA FACTURA***</h4> 
                      
                  </td>                
              </tr>
              
          </table>          
      </td>      
  </tr>
  
</tbody>
</table>