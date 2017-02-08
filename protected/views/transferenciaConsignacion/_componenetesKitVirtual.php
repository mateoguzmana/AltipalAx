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
 /*echo '<pre>';
 print_r($datosKit);*/
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
                      <th>Código</th>
                      <th>Descripción</th>
                      <th>Tipo</th>
                      <th>Cantidad</th>
                  </tr>     
              </thead>
              <tbody>
                  <?php 
                  
                  foreach ($datosKit as $itemListaMateriales){
                      
                     /*echo '<pre>';
                      print_r($datosKit);*/
                      
            
            $LMCodigoArticuloKit=$itemListaMateriales['LMCodigoArticuloKit'];
            $LMDCodigoArticuloComponente=$itemListaMateriales['LMDCodigoArticuloComponente'];
            $LMDCodigoVarianteComponente=$itemListaMateriales['LMDCodigoVarianteComponente'];
            
            $LMDCodigoCaracteristica1=$itemListaMateriales['LMDCodigoCaracteristica1'];
            $LMDCodigoTipo=$itemListaMateriales['LMDCodigoTipo'];
            $LMDCantidadComponente=$itemListaMateriales['LMDCantidadComponente'];
            
            $LMSPDisponible=$itemListaMateriales['SPDisponible'];
                        
             if($LMCodigoArticuloKit==$txtCodigoArticulo){                             
                    // echo $LMCodigoArticuloKit. $LMDCodigoArticuloComponente.'</br>'; 
                     
                     
              ?>      
                  <tr 
                      class="itemKitVirtual"
                      
                      data-kit-CodigoArticuloKit="<?php  echo $itemListaMateriales['LMCodigoArticuloKit'] ?>" 
                      data-kit-CodigoListaMateriales ="<?php echo $itemListaMateriales['LMCodigoListaMateriales']; ?>"
                      data-kit-CodigoArticuloComponente ="<?php echo $itemListaMateriales['LMDCodigoArticuloComponente']; ?>"
                 data-kit-Nombre ="<?php echo $itemListaMateriales['LMDCodigoCaracteristica1']; ?>"
                 data-kit-CodigoUnidadMedida ="<?php echo $itemListaMateriales['LMDCodigoUnidadMedida']; ?>"
                 data-kit-CodigoTipo ="<?php echo $itemListaMateriales['LMDCodigoTipo']; ?>"
                 data-kit-Fijo ="<?php echo $itemListaMateriales['LMCantidadFijos']; ?>"
                 data-kit-Opcional ="<?php echo $itemListaMateriales['LMCantidadOpcionales']; ?>"
                 data-kit-cantidad="<?php echo $LMDCantidadComponente; ?>"
                 data-kit-TotalPrecioVentaBaseVariante="<?php echo $itemListaMateriales['LMDTotalPrecioVentaBaseVariante']; ?>" 
                 data-kit-CodigoVarianteComponente="<?php echo $itemListaMateriales['LMDCodigoVarianteComponente']; ?>"
                      >
                    <td>
                        
                        
                        <?php echo $LMDCodigoVarianteComponente;?>
                    </td>

                    <td>
                        <?php echo $LMDCodigoCaracteristica1;?>
                    </td>

                    <td>
                        <?php echo $LMDCodigoTipo;?>
                    </td>

                    <td>
                        <?php echo $LMDCantidadComponente;?>
                    </td>
                </tr>      
              
               <?php      
             }
            
 }
 ?>
              </tbody>             
          </table>    
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-primary btnAdicionarProductoDetalleAct"
                 data-CodigoVariante="<?php echo $txtCodigoVariante; ?>"                               
                 data-CodigoArticulo ="<?php echo $txtCodigoArticulo;?>"
                 data-cliente="<?php echo $txtCliente;?>"
                 data-kit="true"
                 data-CodigoVariante="<?php echo $txtCodigoVariante; ?>"                               
                 data-CodigoArticulo ="<?php echo $txtCodigoArticulo;?>"
                 data-cliente="<?php echo $txtCliente;?>"
                 data-kit="true"  
                 data-tipo-kit="virtual"
                >Ok</button>
      </div>
    </div><!-- modal-content -->
  </div><!-- modal-dialog -->

