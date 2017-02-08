<?
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE
?>

<?php if($Obligatoria == '1'){ ?>
<script>
$(document).ready(function() {
    
     $("#alertaEncuestas").modal('show');
    });

</script>
<?php } ?>


<?php  $Malla = Consultas::model()->getMallaActivacion($datosCliente['CuentaCliente']);
       $Pedido = Consultas::model()->getPedidoActual($datosCliente['CuentaCliente']);
      if(count($Malla) > 0 && $Pedido['pedidos'] == 0){   
         ?>
<script>
$(document).ready(function() {
    
     $("#alertaMallaActivacion").css("z-index", "25000");
     $("#alertaMallaActivacion").modal('show');
    });

</script>
      <?php  }?>

<?php 

 $session = new CHttpSession;
 $session->open();
 $clienteSeleccionado = $session['clienteSeleccionado'];
 $diaRuta = $clienteSeleccionado['diaRuta'];
 $encabezadoPedidoAlmacenado =  $session['EncabezadoPedidoAlamcenado'];
 /*echo '<pre>';
 print_r($session['EncabezadoPedidoAlamcenado']);*/
 
  
 $Nit = Consultas::model()->getNitcuentacliente($datosCliente['CuentaCliente']);

 $facturasClienteZona=  Consultas::model()->getFacturasClienteZona($Nit[0]['Identificacion']);
 
 $fechaFacturaMenor='9999-12-31';     
    foreach ($facturasClienteZona as $itemFacturas){   
        if($itemFacturas['FechaVencimientoFactura']<$fechaFacturaMenor){
               $fechaFacturaMenor=$itemFacturas['FechaVencimientoFactura'];
    }                     
  }

  
  ////AQUI VA EL ENCABEZADO DEL PEDIDO ALMACENADO PREVENTA//
  
  if(isset($session['EncabezadoPedidoAlamcenado'])){
      
      $encabezadoPedidoAlmacenado =  $session['EncabezadoPedidoAlamcenado'];
      
      /*echo '<pre>';
      print_r($encabezadoPedidoAlmacenado);*/
      
      $zonaVentas = $encabezadoPedidoAlmacenado['CodZonaVentas'];
      $codagencia = Yii::app()->user->_Agencia;
      $CodSitio = $encabezadoPedidoAlmacenado['CodigoSitio'];
      
      $sitiosVentas = Consultas::model()->getSitiosAlmacenados($zonaVentas, $codagencia, $CodSitio);
      
      
  }
  
  ////AQUI VA EL ENCABEZADO DEL PEDIDO ALAMCENADO AUTOVENTA/////
  
  if(isset($session['EncabezadoPedidoAlamcenadoAutoventa'])){
     
      echo '<pre>';
      print_r($session['EncabezadoPedidoAlamcenadoAutoventa']);
      
      $encabezadoPedidoAlmacenadoAutoventa =  $session['EncabezadoPedidoAlamcenadoAutoventa'];
      
      $zonaVentas = $encabezadoPedidoAlmacenadoAutoventa['CodZonaVentas'];
      $codagencia = Yii::app()->user->_Agencia;
      $CodSitio = $encabezadoPedidoAlmacenadoAutoventa['CodigoSitio'];
      
      $sitiosVentas = Consultas::model()->getSitiosAlmacenados($zonaVentas, $codagencia, $CodSitio);
  }
 

  
  
  
/*$diasGracia=$datosCliente['DiasGracia'];
$diasAdicionales=$datosCliente['DiasAdicionales'];
if($diasAdicionales!=""){
    $diasGracia=$diasGracia+$diasAdicionales;
}*/
 
/*$fecha = date_create($fechaFacturaMenor);
date_add($fecha, date_interval_create_from_date_string($diasGracia.'days'));
$diasGraciaFecha= date_format($fecha, 'Y-m-d');*/

?>

<?php // echo '<pre>'; print_r($sitiosVentas); 
echo $codagencia;
echo $CodSitio;
?>

<div class="pageheader">
    <h2>
        <img src="images/home.png" alt="Ir al menu" class="cursorpointer" class="cursorpointer" id="retornarMenu"  style="width: 38px; margin-right: 15px; margin-left: 15px;"/> 
        Opciones <span></span></h2>      
</div>
 

<div class="contentpanel">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">                
                <div class="col-md-1">
                     <img src="images/cliente.png" class="img-rounded" style="width: 75px; padding-left: 25px;"/>
                </div>
                
                <div class="col-md-11">
                    <input type="text" hidden="true" id="txtCuentaCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>">
                    <input type="text" hidden="true" id="txtIDUser" value="<?php echo $datosCliente['Identificacion']; ?>">
                    <input type="text" hidden="true" id="txtZonaventas" value="<?php echo $zonaVentas;?>">
                    <h5> Cuenta:  <span class="text-primary"><?php echo $datosCliente['CuentaCliente']; ?></span></h5>
                    <h5> Nombre: <span class="text-primary" id="txtNombreCliente"><?php echo $datosCliente['NombreCliente']; ?></span></h5>
                     
                    <input type="hidden" id="txtZonaVenta" value="<?php echo $zonaVentas;?>"/>
                    <input type="hidden" id="txtCliente" value="<?php echo $datosCliente['CuentaCliente']; ?>"/>
                    <input type="hidden" id="txtFechaActual" value="<?php echo date('Y-m-d'); ?>">
                    
                </div>
            </div>    
        </div>
        <div class="panel-body" style="min-height: 450px;">
 
            <div class="widget widget-blue">

                
                <div class="widget-content">
                    
                    <div class="mb30"></div>
                    <div class="row">
                       
                        <div class="col-md-2 col-md-offset-4">
                            
                            
                            <?php 
                            /*   echo '<pre>';
        print_r($sitio);
        exit();*/
                            
                            $busquedaPreventa=0;  
                            $busquedaAutoventa=0;
                            $busquedaConsignacion=0;
                            $busquedaVentaDirecta=0;
                               
                            foreach ($sitiosVentas as $itemBusqueda){
                                if($itemBusqueda['Preventa']=='verdadero'){
                                   $busquedaPreventa=1; 
                                }
                                if($itemBusqueda['Autoventa']=='verdadero'){
                                   $busquedaAutoventa=1; 
                                }
                                 if($itemBusqueda['Consignacion']=='verdadero' &&  $sitio[0]['CodigoAlmacen'] != $itemBusqueda['CodigoAlmacen'] ||  $sitio[0]['CodigoSitio'] != $itemBusqueda['CodigoSitio']  ){
                                   $busquedaConsignacion=1; 
                                }
                                if($itemBusqueda['VentaDirecta']=='verdadero' &&   $sitio[0]['CodigoAlmacen'] != $itemBusqueda['CodigoAlmacen'] ||  $sitio[0]['CodigoSitio'] != $itemBusqueda['CodigoSitio']){
                                   $busquedaVentaDirecta=1; 
                                }
                            }
                             
                            ?>
                            
                             <?php if($busquedaPreventa==1 || $busquedaConsignacion = 1 || $busquedaVentaDirecta = 1){ ?>  
                            
                            <?php 
                               if($sitiosVentas){  
                                   
                                   /*echo  '<pre>';
                                   print_r($sitiosVentas);
                                   exit();*/
                                   
                                   $codigoSitio='';
                                   $desPreventa='';
                                   $desAutoventa='';
                                   $desConsignacion='';
                                   $desVentaDirecta='';
                                   $desAlmacen='';
                                   $ubicacion='';
                                   $tipoVenta='';
                                   $nombreSitio='';
                                   
                                   $contSitios=0;
                                   foreach ($sitiosVentas as $itemSitio){                                        
                                     if($itemSitio['Preventa']=="Verdadero" || $itemSitio['Preventa']=="verdadero" || $itemSitio['Consignacion']=="verdadero" &&  
                                      $sitio[0]['CodigoAlmacen'] != $itemBusqueda['CodigoAlmacen'] || $sitio[0]['CodigoSitio'] != $itemBusqueda['CodigoSitio'] || $itemSitio['VentaDirecta']=="verdadero" &&  $sitio['CodigoAlmacen'] != $itemBusqueda['CodigoAlmacen'] || $sitio[0]['CodigoSitio'] != $itemBusqueda['CodigoSitio']){
                                         
                                         
                                         $codigoSitio=$itemSitio['CodigoSitio'];
                                         $desPreventa=$itemSitio['Preventa'];
                                         $desAutoventa=$itemSitio['Autoventa'];
                                         $consignacion=$itemSitio['Consignacion'];
                                         $desVentaDirecta=$itemSitio['VentaDirecta'];
                                         $ubicacion=$itemSitio['CodigoUbicacion'];
                                         $desAlmacen=$itemSitio['CodigoAlmacen'];
                                         $nombreSitio=$itemSitio['NombreSitio'].'--'.$itemSitio['NombreAlmacen'];
                                         $contSitios++;
                                          
                                     }
                                       
                                  }
                                
                               }
                             ?>                           
                             
                            <span id="btnCargarPedidoPreventa" 
                                  
                                  data-sitios="<?php echo $contSitios;?>" 
                                  data-codigo-sitio="<?php echo $codigoSitio;?>" 
                                  data-Preventa="<?php echo $desPreventa;?>"
                                  data-Autoventa="<?php echo $desAutoventa; ?>"
                                  data-consignacion="<?php echo $consignacion; ?>"
                                  data-venta-directa="<?php echo $desVentaDirecta; ?>"                                  
                                  data-ubicacion="<?php echo $ubicacion; ?>"
                                  data-almacen="<?php echo $desAlmacen; ?>"
                                  data-nombre-sitio="<?php echo $nombreSitio;?>"
                                  data-dossitios="<?php echo $sitiosVentas;?>"
                                  
                                  class="cursorpointer">
                                <img src="images/pedido_preventa.png " style="width: 55px"/><br/>
                                <span class="text-primary">Pedido</span>
                             </span>
                                                        
                            <?php }else{?>                             
                            <span class="cursorpointer" id="noPreventaActivo">
                                <img src="images/nopedidos.png " style="width: 55px"/><br/>
                                <span class="text-primary">Pedido</span>
                                </span>                             
                             
                            <?php }?> 
                            
                        </div>
                        
                        
                        
                         <div class="col-md-2">                            
                           
                            <?php if($busquedaAutoventa==1){ ?>  
                             
                             <?php 
                               if($sitiosVentas){ 
                                   $codigoSitio='';
                                   $desPreventa='';
                                   $desAutoventa='';
                                   $desConsignacion='';
                                   $desVentaDirecta='';
                                   $desAlmacen='';
                                   $ubicacion='';
                                   $tipoVenta='';
                                   $nombreSitio='';
                                   
                                   $contSitios=0;
                                   foreach ($sitiosVentas as $itemSitio){                                        
                                     if($itemSitio['Autoventa']=="verdadero"){
                                         $codigoSitio=$itemSitio['CodigoSitio'];
                                         $desPreventa=$itemSitio['Preventa'];
                                         $desAutoventa=$itemSitio['Autoventa'];
                                         $consignacion=$itemSitio['Consignacion'];
                                         $desVentaDirecta=$itemSitio['VentaDirecta'];
                                         $ubicacion=$itemSitio['CodigoUbicacion'];
                                         $desAlmacen=$itemSitio['CodigoAlmacen'];
                                         $nombreSitio=$itemSitio['NombreSitio'].'--'.$itemSitio['NombreAlmacen'];
                                         $contSitios++;
                                     }
                                  }
                               }
                             ?> 
                             
                             <span id="btnCargarPedidoAutoventa" 
                                   
                                  data-sitios="<?php echo $contSitios;?>" 
                                  data-codigo-sitio="<?php echo $codigoSitio;?>" 
                                  data-Preventa="<?php echo $desPreventa;?>"
                                  data-Autoventa="<?php echo $desAutoventa; ?>"
                                  data-consignacion="<?php echo $consignacion; ?>"
                                  data-venta-directa="<?php echo $desVentaDirecta; ?>"                                  
                                  data-ubicacion="<?php echo $ubicacion; ?>"
                                  data-almacen="<?php echo $desAlmacen; ?>"   
                                  data-nombre-sitio="<?php echo $nombreSitio;?>"
                                  
                                   class="cursorpointer">                                 
                                <img src="images/factura.png " style="width: 55px"/><br/>
                                <span class="text-primary">Factura</span>
                                </span>
                                                        
                            <?php }else{?>                             
                                <span class="cursorpointer" id="noAutoventaActivo">
                                <img src="images/nopedidos.png " style="width: 55px"/><br/>
                                <span class="text-primary">Factura</span>
                                </span>                           
                             
                            <?php }?> 
                            
                        </div>
                        
                        </div>
                    
                    <div class="mb20"></div>
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                             <?php 
                             $con=0;
                            foreach ($sitiosVentas as $itemBusqueda){
                                 if($itemBusqueda['Consignacion']=='verdadero'){
                                   $con=1; 
                                } 
                             }
                              
                            ?>
                            
                           <?php if($con==1){ ?>
                            
                            <?php 
                             if($sitiosVentas){
                                 
                                   $codigoSitio='';
                                   $desPreventa='';
                                   $desAutoventa='';
                                   $desConsignacion='';
                                   $desVentaDirecta='';
                                   $desAlmacen='';
                                   $ubicacion='';
                                   $tipoVenta='';
                                   $nombreSitio='';
                                   
                                   $contSitios=0;
                                   foreach ($sitiosVentas as $itemSitio){                                        
                                     if($itemSitio['Consignacion']=="Verdadero" || $itemSitio['Consignacion']=="verdadero" || $itemSitio['Preventa']=="verdadero"){
                                         $codigoSitio=$itemSitio['CodigoSitio'];
                                         $desPreventa=$itemSitio['Preventa'];
                                         $desAutoventa=$itemSitio['Autoventa'];
                                         $consignacion=$itemSitio['Consignacion'];
                                         $desVentaDirecta=$itemSitio['VentaDirecta'];
                                         $ubicacion=$itemSitio['CodigoUbicacion'];
                                         $desAlmacen=$itemSitio['CodigoAlmacen'];
                                         $nombreSitio=$itemSitio['NombreSitio'].'--'.$itemSitio['NombreAlmacen'];
                                         $contSitios++;
                                     }
                                  }
                               
                             }  
                                 
                            ?>
                              <span class="btn-consignacion cursorpointer"
                                  
                                   data-sitios="<?php echo $contSitios;?>" 
                                  data-codigo-sitio="<?php echo $codigoSitio;?>" 
                                  data-Preventa="<?php echo $desPreventa;?>"
                                  data-Autoventa="<?php echo $desAutoventa; ?>"
                                  data-consignacion="<?php echo $consignacion; ?>"
                                  data-venta-directa="<?php echo $desVentaDirecta; ?>"                                  
                                  data-ubicacion="<?php echo $ubicacion; ?>"
                                  data-almacen="<?php echo $desAlmacen; ?>"   
                                  data-nombre-sitio="<?php echo $nombreSitio;?>"
                                  data-clie="<?php echo $datosCliente['CuentaCliente'];  ?>"
                                  data-zona="<?php echo $zonaVentas ?>"
                                  
                                  
                                  > 
                              
                           
                             <img src="images/transconsig.png " style="width: 55px"/><br/>
                             <span class="text-primary">Transferencia Mercancia en Consignación</span>
                             </span>
                                 <?php }else{?> 
                            <span class="cursorpointer">
                                <img src="images/transconsig-block.png" style="width: 55px" class="msgtransconsig"/><br/>
                             <span class="text-primary msgtransconsig">Transferencia Mercancia en Consignación</span>
                             </span>
                             
                            <?php }?>   
                             
                        </div>
                        
                    </div>
                    
                    <div class="mb20"></div>
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            <?php if($tipoPago['AplicaContado']=="falso"): ?>
                            
                            <?php if($busquedaPreventa==1 || $busquedaAutoventa == 1): ?>  
                                <span id="btnDevoluciones" class="cursorpointer">
                                <img src="images/devolucion_press.png " style="width: 55px"/><br/>
                                <span class="text-primary">Devoluciones</span>
                                </span>
                             <?php endif;?>
                            
                             <?php if($busquedaPreventa==0 && $busquedaAutoventa == 0): ?>  
                                <span id="btnDevolucionesInactivas" data-zona="<?php echo $zonaVentas;?>" class="cursorpointer">
                                <img src="images/devolucion_press_block.png " style="width: 55px"/><br/>
                                <span class="text-primary">Devoluciones</span>
                                </span>
                             <?php endif;?>
                             
                            <?php endif; ?>
                            
                            <?php if($tipoPago['AplicaContado']=="verdadero"): ?>
                                <span id="btnDevolucionesInactivas" data-zona="<?php echo $zonaVentas;?>" class="cursorpointer">
                                <img src="images/devolucion_press_block.png " style="width: 55px"/><br/>
                                <span class="text-primary">Devoluciones</span>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        
                        <div class="col-md-2">
                            <?php 
                            
                           
                            
                            $novetas = Noventas::model()->getNoVentasEchas($zonaVentas,$datosCliente['CuentaCliente']);  
                            
                            
                            
                            foreach ($novetas as $item){                                
                                $item;
                            }
                            ?>
                            <?php if($item > 0)                                 
                               {
                                ?>
                               <a href="#">
                                   <img src="images/noventasblock.png " style="width: 55px" class="alerta"/><br/>
                               <span class="text-primary alerta">No Venta</span>                             
                              </a>  
                               <?php 
                                 }else{
                                ?>
                            <a href="index.php?r=Noventas/index&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>">
                             <img src="images/novisita.png " style="width: 55px"/><br/>
                             <span class="text-primary">No Venta</span>                             
                            </a> 
                                 <?php } ?>
                            
                        </div>
                    </div>
                       <div class="mb20"></div>  
                    <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                            <?php if($tipoPago['AplicaContado']=="falso"): ?>
                            <a href="index.php?r=Recibos/index&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>">
                             <img src="images/recaudo.png " style="width: 55px"/><br/>
                             <span class="text-primary">Recibos</span>
                             </a>
                            <?php endif; ?>
                            
                             <?php if($tipoPago['AplicaContado']=="verdadero"): ?>
                            <span class="cursorpointer" id="noRecibos" data-zona="<?php echo $zonaVentas;?>">
                                <img src="images/recaudono.png " style="width: 55px"/><br/>
                                <span class="text-primary">Recibos</span>
                            </span>
                             <?php endif; ?>
                            
                        </div>
                        
                        <?php 
                       
                        $agencia =  Yii::app()->user->_Agencia;
                        
                        $notas = Notascredito::model()->getConsultaAplicacontado($zonaVentas,$agencia);
                        
                        $zonaConAutoventaVerdadero = Notascredito::model()->getConsultaVerdadero($zonaVentas, $agencia);
                        
                        
                        $facturasdelcliente = Notascredito::model()->getFacturasDelClientes($datosCliente['CuentaCliente']);  
                        
                        
                        $facturas = Notascredito::model()->getFacturasCliente($datosCliente['CuentaCliente']);
                        $sw=0;
                        foreach ($facturas as $item){
                            
                            $detalleFacturas = Notascredito::model()->getDetalleFacCliente($item['NumeroFactura']);
                            if($detalleFacturas['facturasdetalle'] > 0){
                                
                              $sw=1;
                              break;
                            }
                        }
                        ?>
                        
                        <?php if($zonaConAutoventaVerdadero[0]['verdadero'] > 0){  ?>
                           <div class="col-md-2">
                            <a href="#">
                                <img src="images/notas_credito_block.png " style="width: 55px" class="msge"/><br/>
                             <span class="text-primary msge">Notas credito</span>                             
                             </a>
                         </div>
                         <?php }elseif($facturasdelcliente[0]['facturasdelcliente'] == 0){ ?>
                          <div class="col-md-2">
                             <a href="#">
                                 <img src="images/notas_credito.png " style="width: 55px" class="msgnotienefacturas"/><br/>
                             <span class="text-primary msgnotienefacturas">Notas credito</span>                             
                             </a>
                         </div>
                          <?php }elseif($sw == 0){ ?>
                         <div class="col-md-2">
                             <a href="#">
                                 <img src="images/notas_credito.png " style="width: 55px" class="msgnofacturas"/><br/>
                             <span class="text-primary msgnofacturas">Notas credito</span>                             
                             </a>
                         </div>
                        <?php 
                            }elseif($notas['AplicaContado'] == 'falso'){
                        ?>
                        <div class="col-md-2">
                              <a href="index.php?r=NotasCredito/index&cliente=<?php echo $cliente;?>&zonaVentas=<?php echo $zonaVentas;?>">
                             <img src="images/notas_credito.png " style="width: 55px"/><br/>
                             <span class="text-primary">Notas credito</span>                             
                             </a>
                            
                        </div>
                       <?php 
                          }
                        ?>
                         
                    </div>
                    <div class="mb20"></div>

                     <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                             <img src="images/report.png " style="width: 55px"/><br/>
                             <span class="text-primary">Reportes</span>
                        </div>
                        <!--<div class="col-md-2">
                             <img src="images/satelite.png " style="width: 55px"/><br/>
                             <span class="text-primary">Localizacion</span>
                        </div>
                    </div>-

                     <div class="mb20"></div>

                     <div class="row">-->
                        
                        <div class="col-md-2">
                             <img src="images/portfolio.png " style="width: 55px"/><br/>
                             <span class="text-primary">Portafolio</span>
                        </div>
                     </div>
                     <div class="mb20"></div>

                     <div class="row">
                        
                        <div class="col-md-2 col-md-offset-4">
                            
                         <a href="index.php?r=Clientes/Encuestas&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>"> 
                             <img src="images/ruta.png " style="width: 55px"/><br/>
                             <span class="text-primary">Encuestas</span>
                         </a>     
                           
                            
                        </div>
                    </div>
                    
                      <div class="mb30"></div>
                      
                    
                </div>
            </div>



        </div>
    </div>      



</div>



<!-- Modal -->
<div class="modal fade" id="mdl-datos-cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 850px;">
        <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Datos Cupo cliente</h4>
      </div>
      <div class="modal-body">
          
          <div class="people-item" >
              <div class="media">
               
                <div class="media-body">
                  <h4 class="person-name"><?php echo $datosCliente['NombreBusqueda']; ?></h4>
                  
                  <div class="row">
                      <div class="col-md-6">
                           <div class="text-muted"> <b>Cuenta Cliente: </b><?php echo $datosCliente['CuentaCliente']; ?></div>
                           <div class="text-muted"> <b>Nit/Cedula: </b><?php echo $datosCliente['Identificacion']; ?></div>
                            <div class="text-muted"> <b>Razón Social: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Contacto: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Dirección: </b><?php echo $datosCliente['DireccionEntrega']; ?></div>                  
                            <div class="text-muted"> <b>Teléfono: </b><?php echo $datosCliente['Telefono']; ?></div>
                            <div class="text-muted"> <b>Teléfono Móvil: </b><?php echo $datosCliente['TelefonoMovil']; ?></div>
                             <div class="text-muted"> <b>Forma Pago: </b><?php echo $datosCliente['DescripcionFormaPago']; ?></div>
                      </div>
                      
                       <div class="col-md-6">
                          
                            <div class="text-muted"> <b>Tipo Negocio: </b><?php echo $datosCliente['TipoNegocio']; ?></div>
                            <div class="text-muted"> <b>Cupo Zona Venta: </b><?php echo number_format($datosCliente['ValorCupo'], '2', ',', '.'); ?></div>
                            <div class="text-muted"> <b>Cupo Disponible: </b><?php echo number_format($datosCliente['SaldoCupo'], '2', ',', '.') ; ?></div>
                            <div class="text-muted"> <b>Cupo Temporal: </b><?php echo number_format($datosCliente['ValorCupoTemporal'], '2', ',', '.'); ?></div>
                            <?php $sumaValorNegativoFcsPrev = Consultas::model()->getSumaSaldoNegativoFactura($datosCliente['CuentaCliente']);?>
                            <div class="text-muted"> <b>Saldo a Favor: </b><?php echo number_format($sumaValorNegativoFcsPrev[0]['saldosumavalornegativo'], '2', ',', '.'); ?></div>
                            <!--<div class="text-muted"> <b>Dias Adicionales: </b><?php// echo $datosCliente['DiasAdicionales'] ?></div>-->
                            <div class="mb10"></div>
                            <button class="btn btn-primary" id="btn-asesores-comerciales">Zonas de Ventas Relacionadas &nbsp;&nbsp; <span class="fa fa-user-md"></span> </button>
                            
                      </div>                      
                  </div>                
                </div>
                  <div id="cargando" style="display:none;" class="col-md-offset-5">
                  <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;">
                 Cargando...
                </div>
                  
              </div>
            </div>
            
            <?php 
            $facturaSaldo=  Consultas::model()-> getSaldoFacturaCliente($datosCliente['CuentaCliente']);
            
            $facturaSaldo=$facturaSaldo['SaldoFactura'];
                        
             $facturaSaldoAsesor=  Consultas::model()-> getSaldoFacturaClienteAsesor($datosCliente['CuentaCliente'],$zonaVentas);
           
            //$facturaSaldoAsesor=$facturaSaldoAsesor['SaldoFactura'];
                     
            $facturaCarteraVencida= Consultas::model()->getSaldoFacturaCarteraVencida($Nit[0]['Identificacion']);
            
            $totalfacturavencida = Consultas::model()->getSaldoFacturaCarteraVencidaTotal($Nit[0]['Identificacion']);
            
            
            
            $carteraVencida=0;
            $cantidadVencida=0;
            foreach ($facturaCarteraVencida as $item){
                
                if($item['SaldoFactura'] !=""){
            
                $carteraVencida=$carteraVencida+$item['SaldoFactura'];
            
               }
            }
            
            foreach ($totalfacturavencida as $itemtotalfac){
                
              if($itemtotalfac['Total'] !=""){
                  
                  $cantidadVencida=$cantidadVencida+$itemtotalfac['Total'];
              }  
                
            }
            
            
            ?>
          
          <div style="width: 100%">
          <table class="table table-bordered mb30">
            
            <tbody>
              <tr>
                <td>Cartera Total:</td>
                <td> $<?php if($carteraVencida>0) echo number_format($carteraVencida);  else echo '0';?></td>                            
             
                <td>Cartera Vendedor:</td>
                <td> $<?php if($facturaSaldoAsesor>0) echo number_format($facturaSaldoAsesor); else echo '0'; ?></td>               
              </tr>
              
                <tr>
                <td>Cartera Vencida:</td>
                <td> $<?php if($facturaSaldo>0) echo ''.number_format($facturaSaldo); else echo '0'; ?></td> 
                
                <td>Facturas Vencidas Totales:</td>
                <td><?php echo $cantidadVencida; ?></td>               
              </tr>             
            
            </tbody>
          </table>
          </div>
          
          <div class="table-responsive" style="width: 100%;overflow-y: scroll; height: 200px;">
              
          <?php 
           $facturasCliente=  Consultas::model()->getFacturasCliente($Nit[0]['Identificacion']);
          ?>
              
          <table class="table table-bordered mb30">
            <thead>
              <tr>
                <th></th>
                <th>Factura</th>
                <th>Valor Neto</th>
                <th>Saldo</th>
                <th>Fecha</th>                
                <th>Días a vencer</th>
                <th>Días mora</th>
                <th>Días PP1</th>
                <th>Días PP2</th>
                <th style="width: 45px;">Zona ventas</th>
                <th>Asesor Comercial</th>
                <th>Grupo ventas</th>
                <th>Teléfono Movil</th>
                
              </tr>
            </thead>
            <tbody>
                
             <?php              
             if($facturasCliente){
                 foreach ($facturasCliente as $itemFacturas){ 
               ?>
                
                <tr>
                    <td> <span class="glyphicon glyphicon-new-window" style="color: #028AF3" id="detalleSaldo-<?php echo $itemFacturas['NumeroFactura'] ?>" ></span><br> </td>  
                            <td><?php echo $itemFacturas['NumeroFactura'] ?></td>
                            <td><?php echo '$' . number_format($itemFacturas['ValorNetoFactura']) ?></td>
                            <td> $<?php if($itemFacturas['Total']==NULL) echo number_format($itemFacturas['SaldoFactura']); else if($itemFacturas['Total']>0) echo number_format($itemFacturas['Total']); else echo '0'; ?></td>
                            <td nowrap="nowrap"><?php echo $itemFacturas['FechaFactura'] ?></td>
                            <?php                            
                            if($itemFacturas['FechaVencimientoFactura']<=  date('Y-m-d')){
                                $diasVencer='0';
                                $diasMora=Yii::app()->controller->diff_dte( date('Y-m-d'),$itemFacturas['FechaVencimientoFactura'] );
                            }else{
                                $diasVencer= Yii::app()->controller->diff_dte(date('Y-m-d'), $itemFacturas['FechaVencimientoFactura'] );                             
                                $diasMora='0';
                            }
                            ?>
                            
                            
                            <td> <?php echo $diasVencer;?></td>
                            <td><?php echo  $diasMora;?></td>
                            
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel1'] ); ?></td>
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel2'] ); ?></td>
                          
                            
                            <td nowrap="nowrap"><?php echo $itemFacturas['NombreZonadeVentas'].' - '.$itemFacturas['CodigoZonaVentas'] ?></td>
                            <td nowrap="nowrap"><?php echo $itemFacturas['NombreEmpleado'] ?></td>
                            <td><?php echo $itemFacturas['NombreGrupoVentas'] ?>(<?php echo $itemFacturas['CodigoGrupoVentas'] ?>)</td>
                            <td><?php echo $itemFacturas['CelularCorporativo'] ?></td>

                        </tr>
                
              <?php  
              }
             }else{
              ?>
                
             <?php   
             }
             ?>   
                
             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
          
        <?php 
        $fechaActual=  date('Y-m-d');
        $valorFacturas=0;
        
    if(!empty($facturasClienteZona)){    
        foreach ($facturasClienteZona as $item){
            
       $Dias = Consultas::model()->getDiasAdicionaGraciasCliente($item['CuentaCliente'],$item['CodZonaVentas']);   
         
       $diasGracia =  $Dias[0]['diasgracia'];
      
        $fecha = date_create($item['FechaVencimientoFactura']);
        date_add($fecha, date_interval_create_from_date_string($diasGracia.'days'));
        $diasGraciaFech = date_format($fecha, 'Y-m-d');
        $diasGraciaFecha = strtotime( '-1 day' , strtotime ( $diasGraciaFech ) ) ;
        $diasGraciaFecha = date ( 'Y-m-d' , $diasGraciaFecha );
         
         if($fechaActual>$diasGraciaFecha){
               $valorFacturas+=1; 
              
         }
            
        }
    }
         
         if($valorFacturas>0){            
            ?>
         <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary factutas-pendientes" >Aceptar</button>
         
            <?php 
         }else{  
             
            ?>
<!--           <button type="button" class="btn btn-default" id="btnModalClose" >Test</button>-->
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<!--           <a href="index.php?r=Preventa/CrearPedido&cliente=<?php //echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php //echo $zonaVentas;?>" class="btn btn-primary cargando">Aceptar</a>-->
           <button id="btnModalClose" type="button" class="btn btn-primary">Aceptar</button>
          <?php             
         }        
        ?>
       
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



<!-- Modal -->
<div class="modal fade" id="mdl-datos-cliente-autoventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 750px;">
        <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Datos Cupo cliente</h4>
      </div>
      <div class="modal-body">
          
          <div class="people-item" >
              <div class="media">
               
                <div class="media-body">
                  <h4 class="person-name"><?php echo $datosCliente['NombreBusqueda']; ?></h4>
                  
                  <div class="row">
                      <div class="col-md-6">
                           <div class="text-muted"> <b>Cuenta Cliente: </b><?php echo $datosCliente['CuentaCliente']; ?></div>
                           <div class="text-muted"> <b>Nit/Cedula: </b><?php echo $datosCliente['Identificacion']; ?></div>
                            <div class="text-muted"> <b>Razón Social: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Contacto: </b><?php echo $datosCliente['NombreCliente']; ?></div>
                            <div class="text-muted"> <b>Dirección: </b><?php echo $datosCliente['DireccionEntrega']; ?></div>                  
                            <div class="text-muted"> <b>Teléfono: </b><?php echo $datosCliente['Telefono']; ?></div>
                            <div class="text-muted"> <b>Teléfono Móvil: </b><?php echo $datosCliente['TelefonoMovil']; ?></div>
                            <div class="text-muted"> <b>Forma Pago: </b><?php echo $datosCliente['DescripcionFormaPago']; ?></div>
                       </div>
                      
                       <div class="col-md-6">
                          
                            <div class="text-muted"> <b>Tipo Negocio: </b><?php echo $datosCliente['TipoNegocio']; ?></div>
                            <div class="text-muted"> <b>Cupo Zona Venta: </b><?php echo number_format($datosCliente['ValorCupo']); ?></div>
                            <div class="text-muted"> <b>Cupo Disponible: </b><?php  echo number_format($datosCliente['SaldoCupo']); ?></div>
                            <div class="text-muted"> <b>Cupo Temporal: </b><?php echo number_format($datosCliente['ValorCupoTemporal']); ?></div>
                            <?php $sumaValorNegativoFcs = Consultas::model()->getSumaSaldoNegativoFactura($datosCliente['CuentaCliente']);?>
                            <div class="text-muted"> <b>Saldo a Favor: </b><?php echo number_format($sumaValorNegativoFcs[0]['saldosumavalornegativo']); ?></div>
                           <!-- <div class="text-muted"> <b>Dias Adicionales: </b><?php  //echo $datosCliente['DiasAdicionales']; ?></div>-->
                            <div class="mb10"></div>
                            <button class="btn btn-primary" id="btn-asesores-comerciales-autoventa">Zonas de Ventas Relacionadas &nbsp;&nbsp; <span class="fa fa-user-md"></span> </button>
                            
                      </div>
                      
                  </div>
                
                </div>
                <div id="cargandoAutoventa" style="display:none;" class="col-md-offset-5">
                  <img src="images/loaders/loader9.gif" style="height: 35px; width: 35px;">
                 Cargando...
                </div> 
                  
              </div>
            </div>
            
            <?php 
            $facturaSaldoAuto=  Consultas::model()-> getSaldoFacturaCliente($datosCliente['CuentaCliente']);
            
            $facturaSaldoAut=$facturaSaldoAuto['SaldoFactura'];
                        
             $facturaSaldoAsesorAuto=  Consultas::model()-> getSaldoFacturaClienteAsesor($datosCliente['CuentaCliente'],$zonaVentas);
           
            //$facturaSaldoAsesor=$facturaSaldoAsesor['SaldoFactura'];
                     
            $facturaCarteraVencidaAuto= Consultas::model()->getSaldoFacturaCarteraVencida($Nit[0]['Identificacion']);
            
            $totalfacturavencidaAuto = Consultas::model()->getSaldoFacturaCarteraVencidaTotal($Nit[0]['Identificacion']);
            
            /*echo '<pre>';
            print_r($facturaCarteraVencidaAuto);
            exit();*/
            
            $carteraVencidaAuto=0;
            $cantidadVencidaAuto=0;
           
            
          foreach ($facturaCarteraVencidaAuto as $item){
                
                if($item['SaldoFactura'] !=""){
            
                $carteraVencidaAuto=$carteraVencidaAuto+$item['SaldoFactura'];
            
               }
            }
            
            foreach ($totalfacturavencidaAuto as $itemtotalfacAuto){
                
              if($itemtotalfacAuto['Total'] !=""){
                  
                  $cantidadVencidaAuto=$cantidadVencidaAuto+$itemtotalfacAuto['Total'];
              }  
                
            }
            
            
            
            ?>
          
          <div style="width: 100%">
          <table class="table table-bordered mb30">
            
            <tbody>
              <tr>
                <td>Cartera Total:</td>
                <td> $<?php if($carteraVencidaAuto>0) echo number_format($carteraVencidaAuto);  else echo '0';?></td>                            
             
                <td>Cartera Vendedor:</td>
                <td> $<?php if($facturaSaldoAsesorAuto>0) echo number_format($facturaSaldoAsesorAuto); else echo '0'; ?></td>               
              </tr>
              
                <tr>
                <td>Cartera Vencida:</td>
                <td> $<?php if($facturaSaldoAut>0) echo ''.number_format($facturaSaldoAut); else echo '0'; ?></td> 
                
                <td>Facturas Vencidas Totales:</td>
                <td><?php echo $cantidadVencidaAuto; ?></td>               
              </tr>             
            
            </tbody>
          </table>
          </div>
          
           <div style="overflow-x: scroll; overflow-y: scroll; height: 170px; border: solid 1px #eee">
              
          <?php 
           $facturasCliente=  Consultas::model()->getFacturasCliente($Nit[0]['Identificacion']);
          ?>
              
          <table class="table table-bordered mb30">
            <thead>
              <tr>
                <th></th>
                <th>Factura</th>
                <th>Valor Neto</th>
                <th>Saldo</th>
                <th>Fecha</th>                
                <th>Días a vencer</th>
                <th>Días mora</th>
                <th>Días PP1</th>
                <th>Días PP2</th>
                <th style="width: 45px;">Zona ventas</th>
                <th>Asesor Comercial</th>
                <th>Grupo ventas</th>
                <th>Teléfono Movil</th>
                
              </tr>
            </thead>
            <tbody>
                
             <?php              
             if($facturasCliente){
                 foreach ($facturasCliente as $itemFacturas){ 
               ?>
                
                <tr>
                    <td> <span class="glyphicon glyphicon-new-window" style="color: #028AF3" id="detalleSaldoAuto-<?php echo $itemFacturas['NumeroFactura'] ?>" ></span><br> </td>  
                            <td><?php echo $itemFacturas['NumeroFactura'] ?></td>
                            <td><?php echo '$' . number_format($itemFacturas['ValorNetoFactura']) ?></td>
                            <td> $<?php if($itemFacturas['Total']==NULL) echo number_format($itemFacturas['SaldoFactura']); else if($itemFacturas['Total']>0) echo number_format($itemFacturas['Total']); else echo '0'; ?></td>
                            <td nowrap="nowrap"><?php echo $itemFacturas['FechaFactura'] ?></td>
                            <?php                            
                            if($itemFacturas['FechaVencimientoFactura']>  date('Y-m-d')){
                                $diasVencer='0';
                                $diasMora=Yii::app()->controller->diff_dte( date('Y-m-d'),$itemFacturas['FechaVencimientoFactura'] );
                            }else{
                                $diasVencer= Yii::app()->controller->diff_dte(date('Y-m-d'), $itemFacturas['FechaVencimientoFactura'] );                             
                                $diasMora='0';
                            }
                            ?>
                            
                            
                            <td> <?php echo $diasVencer;?></td>
                            <td><?php echo  $diasMora;?></td>
                            
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel1'] ); ?></td>
                            <td><?php echo Yii::app()->controller->diff_dte($itemFacturas['FechaFactura'], $itemFacturas['FechaDtoProntoPagoNivel2'] ); ?></td>
                          
                            
                            <td nowrap="nowrap"><?php echo $itemFacturas['NombreZonadeVentas'].' - '.$itemFacturas['CodigoZonaVentas'] ?></td>
                            <td nowrap="nowrap"><?php echo $itemFacturas['NombreEmpleado'] ?></td>
                            <td><?php echo $itemFacturas['NombreGrupoVentas'] ?>(<?php echo $itemFacturas['CodigoGrupoVentas'] ?>)</td>
                            <td><?php echo $itemFacturas['CelularCorporativo'] ?></td>

                        </tr>
                
              <?php  
              }
             }else{
              ?>
                
             <?php   
             }
             ?>   
                
             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
          
        <?php 
         $fechaActualAuto=  date('Y-m-d');
         $valorFacturasAuto=0;
         foreach ($facturasClienteZona as $item){
           
            
       $Dias = Consultas::model()->getDiasAdicionaGraciasCliente($item['CuentaCliente'],$item['CodZonaVentas']);   
         
       //$diasGraciaAuto =  $Dias[0]['diasgracia'];
       $diasGraciaAuto = 0;
       
 
        $fechaAuto = date_create($item['FechaVencimientoFactura']);
        date_add($fechaAuto, date_interval_create_from_date_string($diasGraciaAuto.'days'));
        $diasGraciaFechaAuto= date_format($fechaAuto, 'Y-m-d');
            
         
         if($fechaActualAuto>$diasGraciaFechaAuto){
               $valorFacturasAuto+=1; 
              
         }
            
        }
         
         if($valorFacturasAuto>0){            
            ?>
             
         <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary factutas-pendientes" >Aceptar</button>
         
            <?php 
         }else{  
             
            ?>
           <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
           <a href="index.php?r=Autoventa/CrearPedido&cliente=<?php echo $datosCliente['CuentaCliente'];?>&zonaVentas=<?php echo $zonaVentas;?>" class="btn btn-primary cargandoAutoventa">Aceptar</a>
          <?php             
         }        
        ?>
       
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->



<?php
if ($facturasCliente) { 
    
    foreach ($facturasCliente as $itemFacturas) {
   
        $detalleFactura=  Consultas::model()->getFacturaDetalleCliente($itemFacturas['NumeroFactura']);   
        $detelleFacaturaCurdateRecibo = Consultas::model()->getFacturaDetalleCurdateRecibos($itemFacturas['NumeroFactura']);
        $detelleFacaturaCurdateNotas = Consultas::model()->getFacturaDetalleCurdateNotas($itemFacturas['NumeroFactura']);
        if(count($detalleFactura)>0 || count($detelleFacaturaCurdateRecibo) > 0 || count($detelleFacaturaCurdateNotas) > 0){            
          ?>
            
<div class="modal fade" id="facturaCliente-<?php echo $itemFacturas['NumeroFactura']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Factura: <?php echo $itemFacturas['NumeroFactura'];?></h4>
      </div>
      <div class="modal-body">
               Transacciones en Proceso Altipal 
               -------------------------------------------------------------------------------
              <?php 
                if($detalleFactura){
                    foreach ($detalleFactura as $itemDetalle){                   
                 ?>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Nombre:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <label><?php echo $itemDetalle['NombreDocumento'] ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Código:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $itemDetalle['NumeroDocumento']; ?>
                     </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Concepto:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <label><?php echo $itemDetalle['NombreConcepto']; ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Valor:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $itemDetalle['ValorDocumento']; ?>
                    </div>
                </div>
                <div class="row">
                 ------------------------------------------------------------------------------
                </div>
                   <?php  
                  }  
                }                
                ?> 
               <div class="row"></div>
                Transacciones en Proceso Activity
                ------------------------------------------------------------------------------
               <?php 
                if($detelleFacaturaCurdateRecibo){
                    foreach ($detelleFacaturaCurdateRecibo as $itemRecibo){                   
                 ?>
               <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Nombre</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <label><?php echo 'Recibo de Caja' ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Código:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $itemRecibo['Id']; ?>
                     </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Concepto:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <label><?php if($itemRecibo['Nombre'] == NULL || $itemRecibo['Nombre'] == "") echo 'N/A'; else echo $itemRecibo['Nombre']; ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Valor:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $itemRecibo['ValorAbono']; ?>
                    </div>
                </div>
                <div class="row">
                 --------------------------------------------------------------------------------- 
                </div>
                   <?php  
                  }  
                }                
                ?> 
               
               
                 
                 
                 <?php 
                if($detelleFacaturaCurdateNotas){
                    foreach ($detelleFacaturaCurdateNotas as $itemNotas){                   
                 ?>
               <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Nombre</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <label><?php echo 'Nota Credito' ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Código:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $itemNotas['IdNotaCredito']; ?>
                     </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Concepto:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <label><?php echo $itemNotas['NombreConceptoNotaCredito']; ?></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">  
                        <label><font color="#0033CC"><b>Valor:</b></font></label>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $itemNotas['Valor']; ?>
                    </div>
                </div>
                 <div class="row">
                 ------------------------------------------------------------------------------------ 
                </div> 
                   <?php  
                  }  
                }                
                ?> 
               
               
             
               
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->


         <?php   
        }else{
            ?>
            
            <!-- Modal -->
        <div class="modal fade" id="facturaCliente-<?php echo $itemFacturas['NumeroFactura']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
            <div class="modal-dialog modal-dialog-message">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="myModalLabel">Mensaje Facturas</h5>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-sm-2">  
                                <span class="glyphicon glyphicon-exclamation-sign" style="font-size: 40px; color: #F0AD4E;"></span>
                            </div>
                            <div class="col-sm-10">
                                <p class="text-modal-body">No existen transacciones relacionadas con la factura: <?php echo $itemFacturas['NumeroFactura'];?></p>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">         	
                        <button type="button" class="btn btn btn-small-template" data-dismiss="modal">Cerrar</button>  
                        
                    </div>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->  

        <?php    
        }
        ?>
        <?php
    }
}
?>


<!-- Modal -->
<div class="modal fade" id="asesoresComerciales" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Zonas de Ventas Relacionadas</h4>
      </div>
      <div class="modal-body">
       
          <?php            
           $asesoresRelacionados=  Consultas::model()->getAsesoresCliente($datosCliente['CuentaCliente']);          
          ?>
          
          <div  style="width: 100%; overflow-x: scroll;">
              <table class="table table-bordered mb30" style="width: 700px;">
            <thead>
              <tr>
                <th>Zona ventas</th>
                <th>Nombre Asesor</th>
                <th>Celular</th>
              </tr>
            </thead>
            <tbody>             
              <?php 
                 foreach ($asesoresRelacionados as $itemAsesores){
                ?>    
                     <tr>
                        <td><?php echo $itemAsesores['NombreZonadeVentas'].' - '.$itemAsesores['CodZonaVentas'];?></td>
                        <td><?php echo $itemAsesores['Nombre'];?></td>
                        <td><?php echo $itemAsesores['CelularCorporativo'];?></td> 
                      </tr> 
                <?php     
                  }
              ?>             
            </tbody>
          </table>
          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>        
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- Modal -->
<div class="modal fade" id="sitiosAlmacen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
       <form id="sitiosPreventa" action="" method="post">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sitios de Venta</h4>
      </div>
      <div class="modal-body">
                
            <div class="form-group">
                        <label class="col-sm-4 control-label">Sitio</label>
                        <div class="col-sm-8">                         
                            <select name="sitio" class="form-control" id="select-sitio" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>"/>
                            <option value>Seleccione un sitio</option>
                            
                             <?php 
                               if($sitiosVentas){                                  
                                   
                                   foreach ($sitiosVentas as $itemSitio){   
                                       if($itemSitio['Preventa']=="verdadero" || $itemSitio['Consignacion'] == "verdadero" || $itemSitio['VentaDirecta'] == "verdadero"){
                               ?>    
                            <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> -- <?php echo $itemSitio['NombreAlmacen'];?></option>
                              
                            <?php 
                                  }
                                }
                               }
                             ?>      
                          </select>
                          
                            <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Preventa" id="select-sitio-venta"/>   
                            
                        </div>
                      </div>                      
                      
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Continuar</button>-->
        <input type="submit" class="btn btn-primary "value="Continuar" />
      </div>        
    </div><!-- modal-content -->
    </form>
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="sitiosAlmacenAutoventa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
       <form id="sitiosAutoventa" action="" method="post">
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sitios de Venta Autoventa</h4>
      </div>
      <div class="modal-body">                
         
            <div class="form-group">
                        <label class="col-sm-4 control-label">Sitio</label>
                        <div class="col-sm-8">                         
                            <select name="sitio" class="form-control" id="select-sitio-autoventa" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>"/>
                            <option value>Seleccione un sitio</option>
                                
                             <?php 
                                                      
                             
                               if($sitiosVentas){                                  
                                   
                                   foreach ($sitiosVentas as $itemSitio){   
                                       if($itemSitio['Autoventa']=="verdadero"){
                               ?>    
                            <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>" ><?php echo $itemSitio['NombreSitio'];?> -- <?php echo $itemSitio['NombreAlmacen'];?></option>
                              
                            <?php 
                                  }
                                }
                               }
                             ?>      
                          </select>
                          
                            <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Autoventa" id="select-sitio-venta-autoventa"/>   
                            
                        </div>
                      </div>                      
                      
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Continuar</button>-->
        <input type="submit" class="btn btn-primary "value="Continuar" />
      </div>        
    </div><!-- modal-content -->
    </form>
  </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="sitiosAlmacenConsignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      
      
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Sitios Consignación</h4>
      </div>
      <div class="modal-body">                
         
            <div class="form-group">
                        <label class="col-sm-4 control-label">Sitio</label>
                        <div class="col-sm-8">                         
                            <select name="sitio" class="form-control" required id="select-sitioConsignacion" data-zona-ventas="<?php echo $zonaVentas;?>" data-cliente="<?php echo $datosCliente['CuentaCliente'];?>"/>
                            <option value>Seleccione un sitio</option>
                                
                             <?php 
                                                      
                             
                               if($sitiosVentas){                                  
                                   
                                   foreach ($sitiosVentas as $itemSitio){   
                                       if($itemSitio['Consignacion']=="verdadero" || $itemSitio['Preventa']=="verdadero" ){
                               ?>    
                            <option value="<?php echo $itemSitio['CodigoSitio'];?>" data-Preventa="<?php echo $itemSitio['Preventa'];?>" data-Autoventa="<?php echo $itemSitio['Autoventa'];?>" data-Consignacion="<?php echo $itemSitio['Consignacion'];?>" data-VentaDirecta="<?php echo $itemSitio['VentaDirecta'];?>" data-ubicacion="<?php echo $itemSitio['CodigoUbicacion'];?>" data-almacen="<?php echo $itemSitio['CodigoAlmacen'];?>"><?php echo $itemSitio['NombreSitio'];?> -- <?php echo $itemSitio['NombreAlmacen'];?></option>
                              
                            <?php 
                                  }
                                }
                               }
                             ?>      
                          </select>
                          
                            <input type="hidden"  name="tipoVenta" class="tipoVenta" value="Autoventa" id="select-sitio-venta-autoventa"/>   
                            
                        </div>
                      </div>                      
                      
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <!--<button type="button" class="btn btn-primary">Continuar</button>-->
        <button type="button" class="btn btn-primary" id="consignaciones" data-clie="<?php echo $datosCliente['CuentaCliente']; ?>" data-zona="<?php echo $zonaVentas;?>">Continuar</button>
      </div>        
    </div><!-- modal-content -->
  
  </div><!-- modal-dialog -->
</div><!-- modal -->







<style>
    
    .btn-cargar-pedido{
        cursor: pointer;
    }
    
</style>

<script>

$( document ).ready(function() {

<?php
if ($facturasCliente) {
    foreach ($facturasCliente as $itemFacturas) {
        ?>         
         $('#detalleSaldo-<?php echo $itemFacturas['NumeroFactura']?>').click(function(){
             $('#facturaCliente-<?php echo $itemFacturas['NumeroFactura']?>').modal('show');
         });
      <?php
    }
}
?>  
        
<?php
if ($facturasCliente) {
    foreach ($facturasCliente as $itemFacturas) {
        ?>         
         $('#detalleSaldoAuto-<?php echo $itemFacturas['NumeroFactura']?>').click(function(){
             $('#facturaCliente-<?php echo $itemFacturas['NumeroFactura']?>').modal('show');
         });
      <?php
    }
}
?>          
        


});

</script>
    

 <div class="modal fade" id="alertaFacturasPendientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Facturas</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal">Aceptar</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="alertaCarteraPendiente" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Recaudos</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-primary btn-small-template" id="btnRecibosCaja">OK</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="alertaCarteraPendienteInfo" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-message">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="myModalLabel">Mensaje Recaudos</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">      			
                        <span class="fa fa-exclamation-triangle" style="font-size: 40px; color: #D9534F;"></span>
                    </div>
                    <div class="col-sm-10">
                        <p class="text-modal-body" id="mensaje-error"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer">                 
                <button type="button" class="btn btn-default btn-small-template" data-dismiss="modal" id="">Cerrar</button>        
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="alertaFrmRecibosCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Recibos de caja</h5>
            </div>
            <div class="modal-body">
                <div class="row">                   
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Código Cliente</label>
                            <div class="col-sm-6">
                                <input type="text" placeholder="" readonly="readonly" class="form-control" value="<?php echo $datosCliente['CuentaCliente'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Razón Social</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly"class="form-control" value="<?php echo $datosCliente['NombreBusqueda'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Contacto</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['NombreCliente'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dirección</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['DireccionEntrega'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Teléfono</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['Telefono'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Forma de Pago</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['DescripcionFormaPago'];?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo Negocio</label>
                            <div class="col-sm-6">
                              <input type="text" placeholder="Default Input" readonly="readonly" class="form-control" value="<?php echo $datosCliente['TipoNegocio'];?>">
                            </div>
                          </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                  <div class="form-group">
                            <label class="col-sm-3 col-sm-offset-2 control-label">Recaudar Factura:</label>
                            <div class="col-sm-2">
                              <div class="">
                                 <label>Si</label>
                                
                                 <input type="radio" name="radio" value="2" id="recaudarFacturaSi" data-cuentaCliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-zonaVenta="<?php echo $zonaVentas;?>" >
                                 
                              </div>
                            </div>
                            
                             <div class="col-sm-2">
                              <div class="">
                                
                               <label>No</label>
                                <input type="radio" name="radio" value="2" id="recaudarFacturaNo">
                                 
                              </div>
                            </div>
                            
                          </div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="alertaFrmRecibosCajaNo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">NO RECAUDOS</h5>
            </div>
            
            <form  action="" id="frmNoRecaudos" method="post">
            <div class="modal-body">
                <div class="row">   
                    <div class="col-sm-12">
                       <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha</label>
                            <div class="col-sm-6">
                                <input name="noRecaudos[Fecha]" id="FechaNoRecaudo" type="text" placeholder="" id="" required class="form-control" readonly="readonly" value="<?php echo date('Y-m-d');?>">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Fecha Próxima Visita</label>
                            <div class="col-sm-6">
                              <input name="noRecaudos[FechaProximaVisita]" id="FechaProximaVisita" type="text" placeholder="" id="datepicker" class="form-control datepicker"  value="">
                            </div>
                          </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 required control-label">Motivo</label>
                            <div class="col-sm-6">
                             
                                <select class="form-control" name="noRecaudos[Motivo]" id="sltMotivoDevolucion">
                                  <option value="">Seleccione un motivo de no recaudo</option>
                                  <?php foreach ($motivosgestiondecobros as $item):?>                                  
                                  <option value="<?php echo $item['CodMotivoGestion'];?>"> <?php echo $item['Nombre'];?></option>
                                  <?php endforeach;?>
                              </select>
                            </div>
                          </div>
                        
                          <div class="form-group">
                            <label class="col-sm-3  control-label">Observación</label>
                            <div class="col-sm-6">
                                <textarea name="noRecaudos[Observaciones]" id="txtObservacionNoRecaudo" class="col-sm-12 txtAreaObservaciones" placeholder="Máximo 50 caracteres"></textarea>
                            </div>
                          </div>
                        
                       
                    </div>
                </div>

            </div>
                
           
            <div class="modal-footer">
                  <div class="form-group">
                            
                             <div class="col-sm-12">
                                 
                                <button class="btn btn-primary">Guardar</button>
                                <a class="btn btn-default" id="btnCancelarNoRecaudo">Cancelar</a>
                                 
                             
                            </div>
                            
                          </div>
            </div>
          </form>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

 
<div class="modal fade" id="alertaMallaActivacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-primary"  id="myModalLabel">Malla Activación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered" id="tableDetail">
                        <th class="text-center">No</th>
                        <th class="text-center">Establecimiento</th>
                        <th class="text-center">Cuenta Cliente</th>
                        <th class="text-center">Nombre Cliente</th>
                        <tr>
                            <td class="text-center"><?php echo $contador ?></td>
                            <td class="text-center"><?php echo $datosCliente['NombreBusqueda']; ?></td>
                            <td class="text-center"><?php echo $datosCliente['CuentaCliente']; ?></td>
                            <td class="text-center"><?php echo $datosCliente['NombreCliente']; ?></td>
                        </tr>
                    </table>  
                </div>
                <br>
                <div class="row">
                    <table class="table table-bordered" id="tableDetail">
                        <tr>
                        <th  class="text-center">Días Hábiles</th>
                        <th  class="text-center">Días Transcurridos</th>
                        <th  class="text-center">Porcentaje Esperado a la Fecha %</th>
                        </tr>
                        <tr>
                            <td class="text-center"><?php echo $Malla[0]['DiasHabiles'] ?></td>
                            <td class="text-center"><?php echo $Malla[0]['DiasTranscurridos'] ?></td>
                            <?php $PorcentajeEsperado = $Malla[0]['DiasTranscurridos'] / $Malla[0]['DiasHabiles'] * 100?>
                            <td class="text-center"><?php echo number_format($PorcentajeEsperado,'2',',','.').'%' ?></td>
                        </tr>
                    </table>
                </div>
                <div class="row">
                    <table class="table table-bordered" id="tableDetail">
                     <tr class="text-primary"><th colspan="4"><h4 class="text-center">RESUMEN CLIENTE</h4></th></tr>
                    <tr>
                        <th  class="text-center">Atributo</th>
                        <th  class="text-center">Cuota</th>
                        <th  class="text-center">Ventas</th>
                        <th  class="text-center">Cumplimiento %</th>
                    </tr>
                      <?php 
                        foreach ($Malla as $itemMalla){
                         $PorcentajeEsperado = $itemMalla['DiasTranscurridos'] / $itemMalla['DiasHabiles'] * 100;
                      ?> 
                       <tr> 
                        <?php if($itemMalla['Cumplimiento'] < $PorcentajeEsperado){ ?> 
                        <td  class="text-center"  style="background-color: pink"><?php echo $itemMalla['Tipo']; ?></td>
                        <td  class="text-center"  style="background-color: pink">$ <?php echo number_format($itemMalla['Presupuestado'],'2',',','.'); ?></td>
                        <td  class="text-center"  style="background-color: pink">$ <?php echo number_format($itemMalla['Ejecutado'],'2',',','.'); ?></td>
                        <td  class="text-center" style="background-color: pink"><?php echo $itemMalla['Cumplimiento']; ?></td>
                        <?php }else{ ?>
                        <td  class="text-center"><?php echo $itemMalla['Tipo']; ?></td>
                        <td  class="text-center">$ <?php echo number_format($itemMalla['Presupuestado'],'2',',','.'); ?></td>
                        <td  class="text-center">$ <?php echo number_format($itemMalla['Ejecutado'],'2',',','.'); ?></td>
                        <td  class="text-center"><?php echo $itemMalla['Cumplimiento']; ?></td>
                        <?php } ?>
                       </tr> 
                      <?php } ?>  
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>






<div class="modal fade" id="alertaEncuestas" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog" style="width: 930px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary"  id="myModalLabel">Encuestas</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover" id="tblEncuestas">
                                        <thead>
                                            <tr>
                                                <th>Cedula: <span class="text-primary"><?php echo $datosCliente['Identificacion'];  ?></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Razon Social: <span class="text-primary"><?php echo $datosCliente['NombreBusqueda']; ?></th>
                                            </tr>
                                            <tr>
                                              <th>
                                                  <h5> Encuestas:</h5> 
                                              </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cont = 1;
                                            
                                            
                                            foreach ($Encuestas as $itemEncuesta) {
                                                ?>
                                                <tr class="odd gradeX seleccionarEncuesta cursorpointer" data-IdEncuesta="<?php echo $itemEncuesta['IdTitulo']; ?>" data-CuentaCliente="<?php echo $datosCliente['CuentaCliente']; ?>" data-zona="<?php echo $datosCliente['CodZonaVentas']; ?>" data-CodAsesor="<?php echo $codigoAsesor ?>">
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-1">
                                                                <div class="mb20"></div>
                                                            <img src="images/ruta.png" class="img-rounded" style="width: 75px;"/>
                                                            </div>
                                                            <div class="col-sm-11">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <h3 class="text-primary">
                                                                             <input type="hidden" value="<?php echo $cont ?>" class="Contador">
                                                                            <?php echo $cont++ . ' - ' . $itemEncuesta['Titulo']; ?>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>
                                                                              Fecha Inicio 
                                                                            </b>
                                                                            <?php echo $itemEncuesta['FechaInicio']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Fecha Fin: </b>
                                                                            <?php echo $itemEncuesta['FechaFin']; ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <span>
                                                                            <b>Descripcion: </b>
                                                                            <?php echo $itemEncuesta['Descripcion'];?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                         <?php if($itemEncuesta['Tipo'] == 1){
                                                                             
                                                                             $tipo = 'Obligatoria';
                                                                             
                                                                         }else{
                                                                             
                                                                             $tipo = 'No Obligatoria';
                                                                         }?>
                                                                        <span>
                                                                            <b>Tipo: </b>
                                                                              <?php echo $tipo ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
            <div class="modal-footer">
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div>


<?php $this->renderPartial('//mensajes/_alerta');?>
<?php $this->renderPartial('//mensajes/_alertaInputCorreo');?>
<?php $this->renderPartial('//mensajes/_alertaEnvioEmail');?>
<?php $this->renderPartial('//mensajes/_alertSucess');?> 
<?php $this->renderPartial('//mensajes/_alertSucessRecibos');?> 
<?php $this->renderPartial('//mensajes/_alertaRecibos');?> 

<?php $this->renderPartial('//mensajes/_alertConfirmationClientesRuta');?> 


<?php 


$cantidad=0;
foreach ($recibosvsfacturas as $item){   
    if($item['SaldoFactura'] > $item['Total']){
        $cantidad++;
    }
}


$totalNoRecaudos=  count($noRecaudos);

 
$zonaventas = Yii::app()->user->_zonaVentas;
$contadorzona=0;
foreach ($facturasCliente as $item){
    
    
    if(trim($zonaventas) == trim($item['CodigoZonaVentas']) &&  trim($Nit[0]['Identificacion']) == trim($item['Identificacion'])){
        
        $contadorzona++; 
         
    }
     
}

if($diasGraciaFecha !=""){
   
 if($totalNoRecaudos==0 && $tipoPago['AplicaContado']=="falso" && $fechaActual>$diasGraciaFecha && $contadorzona > 0){
   ?>  
 
<script>
$( document ).ready(function() {

<?php 
  $facturamasantigua = Consultas::model()->getFacturaMasAntigua($Nit[0]['Identificacion']);
    ?>
   $('#alertaCarteraPendiente #mensaje-error').html('Recuerde que este cliente presenta cartera vencida,por favor hacer el recaudo o gestión de cobro de la factura : <?php echo $facturamasantigua[0]['NumeroFactura']; ?>  (<?php echo $facturamasantigua[0]['FechaVencimientoFactura']; ?>) '); 
   $('#alertaCarteraPendiente').modal('show');   
  <?php 
 
  ?>
});

</script>
<?php
 }elseif($totalNoRecaudos=='0' && $tipoPago['AplicaContado']=="falso" && $contadorzona > '0'){ ?>
<script>

$( document ).ready(function() {
    
<?php 
  $facturamasantigua = Consultas::model()->getFacturaMasAntigua($Nit[0]['Identificacion']);
    ?>
   $('#alertaCarteraPendiente #mensaje-error').html('Recuerde que este cliente presenta cartera vencida,por favor hacer el recaudo o gestión de cobro de la factura: <?php echo $facturamasantigua[0]['NumeroFactura']; ?>  (<?php echo $facturamasantigua[0]['FechaVencimientoFactura']; ?>) '); 
   $('#alertaCarteraPendiente').modal('show');   
  <?php 
     
  ?>
});

</script>

<?php } }?>      

<?php if(Yii::app()->user->hasFlash('success')):?>
<script>    
    $(document).ready(function() {
    $('#_alertaSucess #msg').html('Mensaje');  
    $('#_alertaSucess #sucess').html('<?php echo Yii::app()->user->getFlash('success'); ?>');
    $('#_alertaSucess').modal('show');
     });
</script>   
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('msjRecibos')):?>
<?php
 $zonaVentas=Yii::app()->user->getFlash('infoZonaVentas');
 $cuentaCliente=Yii::app()->user->getFlash('infoCuentaCliente');
 $provisional=Yii::app()->user->getFlash('infoProvisional');
?>
<script>    
    $(document).ready(function() {
         
        
    $('#alertaCarteraPendiente').modal('hide'); 
    
    
    $('#_alertaRecibos .text-modal-body').html('Usted puede imprimir copia de los recibos de caja en el módulo de impresiones, que se encuentra en el menú del cliente');  
    $('#_alertaRecibos').modal('show');   
   
    $('#_alertaSucessRecibos #msg').html('Mensaje');  
    $('#_alertaSucessRecibos #sucess').html('<?php echo Yii::app()->user->getFlash('msjRecibos'); ?>');        
    $('#_alertaSucessRecibos').modal('show');
    
    $('#_alertaInputCorreo #inputAlertaInput').val('<?php echo Yii::app()->user->getFlash('infoEmailCliente'); ?>');
    $('#_alertaInputCorreo #btnConfirmarEnviarEmail').attr('data-zona-ventas','<?php echo $zonaVentas; ?>' );
    $('#_alertaInputCorreo #btnConfirmarEnviarEmail').attr('data-cuenta-cliente','<?php echo $cuentaCliente; ?>' );
    $('#_alertaInputCorreo #btnConfirmarEnviarEmail').attr('data-provisional','<?php echo $provisional; ?>' );   

    $('#_alertaSucessRecibos #btnImprimirPdf').attr('data-zona-ventas','<?php echo $zonaVentas; ?>' );
    $('#_alertaSucessRecibos #btnImprimirPdf').attr('data-cuenta-cliente','<?php echo $cuentaCliente; ?>' );
    $('#_alertaSucessRecibos #btnImprimirPdf').attr('data-provisional','<?php echo $provisional; ?>' );   
    
 
     });
</script>   
<?php endif; ?>


<script>
$('body').on('click','.seleccionarEncuesta',function (){
    
  var idEncuesta = $(this).attr('data-IdEncuesta');
  var cuentaCliente = $(this).attr('data-CuentaCliente');
  var zonaVentas = $(this).attr('data-zona');
  var codAsesor = $(this).attr('data-CodAsesor');
  
   $.ajax({
            data: {
                "idEncuesta": idEncuesta,
                "cuentaCliente":cuentaCliente,
                "zonaVentas":zonaVentas,
                "codAsesor":codAsesor
            },
            async: false,
            url: 'index.php?r=clientes/AjaxSetEncuesta',
            type: 'post',
            success: function(response) {
                 window.location.href = "index.php?r=Clientes/Encuestar&cliente=" + cuentaCliente + "&zonaVentas=" + zonaVentas;
            }
        });
   
   
});
 
</script>