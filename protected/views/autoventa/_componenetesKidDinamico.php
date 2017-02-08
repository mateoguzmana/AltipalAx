<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
*/
$cont=0;

$session=new CHttpSession;
$session->open();

if( $session['listaMateriales']){
     $datosKit=$session['listaMateriales'];
}else{
    $datosKit=array();
 }
 
 
 
if($session['componenteKitDinamico']){
    $kitAdd=$session['componenteKitDinamico'];
}else{
    $kitAdd=array();
} 
 ?>
                
<div class="modal-dialog" style="margin: 120px auto; width: 580px;">
        <div class="modal-content" style="border: 3px solid #EEEEEE;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><img src="images/kit.png"> 
            
            <?php echo $txtCodigoVariante;?> 
            <?php echo $txtNombreArticulo;?> 
            <?php echo $txtCodigoCaracteristica1;?> 
            <?php echo $txtCodigoCaracteristica2;?>
            
            (<?php echo $txtCodigoTipo;?>)
            
            <span id="tltComponentesArticulo"></span></h4>
      </div>
      <div class="modal-body">
        
          
          <table class="table table-hover table-bordered">
              <thead>
                  <tr>
                      
                      <th class="text-center">Descripción</th>
                      <th class="text-center">Tipo</th>
                      <th class="text-center">Cantidad</th>
                      <th class="text-center">Inventario</th>
                  </tr>     
              </thead>
              <tbody>
                  <?php 
                  
                  /*echo '<pre>';
                   print_r($datosKit);
                   echo '</pre>';*/
                  
                  foreach ($datosKit as $itemListaMateriales){
                      
                      
            
                $LMCodigoArticuloKit=$itemListaMateriales['LMCodigoArticuloKit'];
                $LMDCodigoArticuloComponente=$itemListaMateriales['LMDCodigoArticuloComponente'];            
                $LMDCodigoCaracteristica1=$itemListaMateriales['LMDCodigoCaracteristica1'];
                $LMDCodigoTipo=$itemListaMateriales['CA'];
                $LMDCantidadComponente=$itemListaMateriales['LMDCantidadComponente'];
                $LMSPDisponible=$itemListaMateriales['SADisponible'];
                        
             if($LMCodigoArticuloKit==$txtCodigoArticulo){                             
                   
                 $itemKitAddCantidad="";
                 
                 foreach ($kitAdd as $itemKitAdd){    
                     
                     /*echo '<pre>';
                     print_r($itemKitAdd);
                     echo '</pre>';*/
                     
                     $itemKitAddCodigoArticuloKit=$itemKitAdd['txtCodigoArticuloKit'];
                     $itemKitAddtxtCodigoArticulo=$itemKitAdd['txtCodigoArticulo'];    
                     
                     //print_r($itemKitAdd);
                     
                    //echo $LMCodigoArticuloKit.'=='.$itemKitAddCodigoArticuloKit .'&&'. $itemKitAddtxtCodigoArticulo.'=='.$LMDCodigoArticuloComponente.'<br/>';
                     
                     if($LMCodigoArticuloKit==$itemKitAddCodigoArticuloKit && $itemKitAddtxtCodigoArticulo==$LMDCodigoArticuloComponente){ 
                         
                        //echo $LMCodigoArticuloKit.'=='.$itemKitAddCodigoArticuloKit.'<br/>'; 
                        //echo $itemKitAddtxtCodigoArticulo.'<br/>'; 
                        
                          $itemKitAddCantidad=$itemKitAdd['txtKitCantidad'];
                          break;                         
                     }
                 }
                 
                 $LMCantidadFijos=$itemListaMateriales['LMCantidadFijos'];
                 $LMCantidadOpcionales=$itemListaMateriales['LMCantidadOpcionales'];
                   
                 $LMDFijo=$itemListaMateriales['LMDFijo'];
                 $LMDOpcional=$itemListaMateriales['LMDOpcional'];
                 
                 $obligatorio=false;
                 if( ($LMDFijo=="1" && $LMDOpcional=="0") || ($LMDFijo=="0" && $LMDOpcional=="1")){
                      $obligatorio=true;
                 }
                 
                 $regulares=false;
                 
                if($LMDFijo=="0" && $LMDOpcional=="1"){
                     $regulares=true;
                }
                 
              ?>      
                  <tr  <?php  if($obligatorio){ ?> class="info itemKitDinamico" <?php }else{?> class="itemKitDinamico" <?php } ?> 
                             
                        data-kit-CodigoArticuloKit="<?php  echo $itemListaMateriales['LMCodigoArticuloKit'] ?>"                           
                        data-kit-CodigoListaMateriales ="<?php echo $itemListaMateriales['LMCodigoListaMateriales']; ?>"
                        data-kit-CodigoArticuloComponente ="<?php echo $itemListaMateriales['LMDCodigoArticuloComponente']; ?>"
                        data-kit-Nombre ="<?php echo $itemListaMateriales['LMDCodigoCaracteristica1']; ?>"
                        data-kit-CodigoUnidadMedida ="<?php echo $itemListaMateriales['LMDCodigoUnidadMedida']; ?>"
                        data-kit-CodigoTipo ="<?php echo $itemListaMateriales['LMDCodigoTipo']; ?>"
                        data-kit-Fijo ="<?php echo $itemListaMateriales['LMDFijo']; ?>"
                        data-kit-Opcional ="<?php echo $itemListaMateriales['LMDOpcional']; ?>"
                        data-kit-TotalPrecioVentaBaseVariante="<?php echo $itemListaMateriales['LMDPrecioVentaBaseVariante']; ?>"   
                        
                    >
                    <td class="text-center">
                        
                        <?php echo $LMDCodigoCaracteristica1;?>
                    </td>

                    <td class="text-center">
                        <?php echo $LMDCodigoTipo;?>
                    </td>

                    <td class="text-center">                        
                        <input type="text"  
                               id="txtInputKit-<?php echo $itemListaMateriales['LMDCodigoArticuloComponente']; ?>-<?php echo $LMCantidadFijos;?>-<?php echo $LMCantidadOpcionales;?>"
                               value="<?php if(!empty($itemKitAddCantidad)) echo $itemKitAddCantidad; ?>" 
                               placeholder="<?php  if($obligatorio){ echo $LMDCantidadComponente;}?>"
                               style="width: 55px !important;" 
                               class="text-center txtCantidadItem"
                               data-obligatorio="<?php  if($obligatorio){ echo "1";}else{ echo "0";} ?>"
                               data-can-minima="<?php  if($obligatorio){ echo $LMDCantidadComponente;}else{ echo "0";} ?>"
                               data-caracteristica="<?php echo $LMDCodigoCaracteristica1;?>"
                               
                               data-cantidad-max-regulares="<?php echo $LMCantidadFijos;?>"
                               data-cantidad-max-obsequio="<?php echo $LMCantidadOpcionales;?>"
                               
                               data-regulares="<?php if(!$regulares){ echo "1"; }?>"
                               data-obsequios="<?php if($regulares){ echo "1"; }?>"
                                
                               
                         >
                        
                    </td>
                    <td>
                        <?php echo $itemListaMateriales['SADisponible'];?>
                    </td>
                </tr>   
               <?php    
                 
             }
           
            
        }
        
                    ?>
                <tr>
                    <td colspan="4">
                        
                        <i>Los componentes que poseen un color diferente es obligatorio incluirlos en el kit</i><br/><br/>                        
                        Cantidad de Productos del kit<br/>
                        Regulares: <b><?php echo $LMCantidadFijos;?></b><br/>
                        Obsequios: <b><?php echo $LMCantidadOpcionales;?></b>
                        
                    </td>
                   
                   
                </tr>
                
              </tbody>             
          </table>    
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary btnAdicionarProductoDetalleAct"
                
                 data-CodigoVariante="<?php echo $txtCodigoVariante; ?>"                               
                 data-CodigoArticulo ="<?php echo $txtCodigoArticulo;?>"
                 data-cliente="<?php echo $txtCliente;?>"
                 data-kit="true"                
                 data-tipo-kit="dinamico"
                 
                >Ok</button>
          
          <div class="imgDivKit">
              
          </div>
          
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->

