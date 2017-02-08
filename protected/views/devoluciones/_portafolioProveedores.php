 <?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$session = new CHttpSession;
$session->open();
if ($session['portafolioProveedores']) {
    $portafolioProveedores = $session['portafolioProveedores'];
} else {
    $portafolioProveedores = array();
}
$portafolio=$portafolioProveedores;

/*echo '<pre>';
print_r($portafolio);*/


$cont=1;

?>

<div class="col-sm-8 col-sm-offset-2">
    <table class="table table-email" id="tablePortafolioProveedores">
        <thead>
            <tr>
                <td></td>
                 <td></td>
            </tr>
        </thead>
                              <tbody>
                               
                              <?php foreach ($portafolio as $item): ?>  
                                  
                                 
                                <tr class="unread btnItemDevolucion" data-variante="<?php echo $item['CodigoVariante']?>">
                                 
                                    <td style="width: 10%">
                                    <?php 
                                      if($item['Cantidad']==0){                                   
                                    ?>
                                    <img data-producto-nuevo="1" id="<?php echo $item['CodigoVariante']; ?>" src="images/pro.png" />
                                    <br/>
                                    <small>Producto</small>
                                    <?php }else{
                                        ?>
                                    <img data-producto-nuevo="1" id="imagen-producto-<?php echo $item['CodigoVariante']; ?>" src="images/aceptar.png" />
                                    <?php
                                        } 
                                    ?>
                                    
                                  </td>
                                  <td>
                                    <div class="media">                                        
                                        <div class="media-body">                                            
                                            <?php 
                                            
                                            $nombreProducto=$item['NombreArticulo'];
                                            if($item['CodigoCaracteristica1']!="N/A"){                                                
                                                $nombreProducto.=" ". $item['CodigoCaracteristica1'];                                                
                                            }
                                            
                                            if($item['CodigoCaracteristica2']!="N/A"){
                                                $nombreProducto.=" ".$item['CodigoCaracteristica2'];                                                
                                            }
                                            $nombreProducto.=" (".$item['CodigoTipo'].")";
                                            
                                            ?>
                                            <p class="email-summary"><strong><?php echo $cont;?>) Código Articulo:</strong> <span id="CodArt-<?php echo $item['CodigoVariante']?>"><?php echo $item['CodigoVariante']?> </span> </p> 
                                            <!--<p class="email-summary"><strong>Código Artículo:</strong> <span id="CodA-<?php echo $item['CodigoVariante']?>"><?php echo $item['CodigoArticulo']?></span> </p>--> 
                                             <p class="email-summary"><strong>Descripción:</strong> <span id="Descripcion-<?php echo $item['CodigoVariante']?>"> <?php echo $nombreProducto;?> </span> </p> 
                                             <p class="email-summary"><strong>Unidad Medida:</strong><span id="UniMed-<?php echo $item['CodigoVariante']?>"> <?php echo $item['NombreUnidadMedida']?> </span></p> 
                                             <p class="email-summary"><strong>Valor:</strong> <span id="Valor-<?php echo $item['CodigoVariante']?>"><?php echo number_format($item['PrecioVentaAcuerdo'],'2',',','')?> </span></p> 
                                             <p class="email-summary"><strong>% Iva:</strong> <span id="Iva-<?php echo $item['CodigoVariante']?>"><?php echo $item['PorcentajedeIVA']?> </span</p>                                              
                                             <input type="hidden" value="<?php echo $item['ValorIva']?>" id="ValorIva-<?php echo $item['CodigoVariante']?>" />
                                             <input type="hidden" id="Cantidad-<?php echo $item['CodigoVariante']?>" value="<?php echo $item['Cantidad']?>"/> 
                                        </div>
                                    </div>
                                  </td>
                                </tr>
                              
                                <?php  $cont++; endforeach; ?>
                              </tbody>
                            </table>
                        </div>
            