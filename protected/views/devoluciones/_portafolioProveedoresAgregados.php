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
?>

<div class="col-sm-8 col-sm-offset-2">
    <table class="table table-email" id="tablePortafolioProveedoresAg">        
                              <tbody>
                               
                              <?php foreach ($portafolio as $item): ?> 
                                  
                                  <?php if ($item['Cantidad']>0) { ?>
                                  
                                <tr class="unread">
                                 
                                    <td style="width: 10%">
                                    
                                    <img data-producto-nuevo="1" id="<?php echo $item['CodigoVariante']; ?>" src="images/devolucion_press.png" />
                                    
                                  </td>
                                  <td>
                                    <div class="media">                                        
                                        <div class="media-body btnItemDevolucion" data-variante="<?php echo $item['CodigoVariante']?>">
                                            
                                            <p class="email-summary"><strong>Código Articulo:</strong> <span id="CodArt-<?php echo $item['CodigoVariante']?>"><?php echo $item['CodigoVariante']?></span> </p> 
                                            <p class="email-summary"><strong>Descripción:</strong> <span id="Descripcion-<?php echo $item['CodigoVariante']?>"><?php echo $item['NombreArticulo']?> <?php echo $item['CodigoCaracteristica1']?> <?php echo $item['CodigoCaracteristica2']?> (<?php echo $item['CodigoTipo']?>)  </span> </p> 
                                            <p class="email-summary"><strong>Unidad Medida:</strong><span id="UniMed-<?php echo $item['CodigoVariante']?>"> <?php echo $item['NombreUnidadMedida']?> </span></p> 
                                            <p class="email-summary"><strong>Cantidad:</strong> <span id="Valor-<?php echo $item['Cantidad']?>"> <?php echo $item['Cantidad']?> </span></p> 
                                             
                                            
                                        </div>
                                    </div>
                                  </td>
                                  
                                  <td style="width: 5% !important;" class="text-center">
                                      <img src="images/delete.png" style="width: 25px;" class="delete-item-devoluciones" data-variante="<?php echo $item['CodigoVariante']?>"/>
                                      <br/>
                                      <small>Eliminar</small>
                                  </td>
                                  <td style="width: 5% !important;" class="text-center">
                                      <img src="images/edit.png" style="width: 25px;" class="btnItemDevolucion" data-variante="<?php echo $item['CodigoVariante']?>"/>
                                      <br/>
                                      <small>Modificar</small>
                                  </td>
                                </tr>
                                    <?php } ?>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                        </div>


                    