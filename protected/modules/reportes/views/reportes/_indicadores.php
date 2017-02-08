<div class="container-fluid">
<div class="row">   
     <div style="overflow-x: scroll; overflow-y: no-display; margin-top: 10px;">
                        <?php
                        $canales = $this->obtenerCanales();
                        foreach ($canales as $canal) :
                            $indicadoresVentas = Consultas::model()->getPresupuestoCanal($canal['NombreCanal']);
                           
                            foreach ($indicadoresVentas as $itemIndicadores):
                                
                                if($itemIndicadores['pesos'] != "" && $itemIndicadores['cuotapesos'] !=""):
                                    
                                    
                                   $Division  = $itemIndicadores['pesos'] / $itemIndicadores['cuotapesos'];
                                   $porcetaje = $Division * 100;
                                ?>
                               <div class="col-md-6">
                                   <table class="table table-bordered" style="width: 100%;">
                                        <th  class="text-center">$ Pesos</th>
                                        <th  class="text-center">$ Objetivo</th>
                                        <th  class="text-center" nowrap="nowrap">% Porcentaje</th>
                                        <th  class="text-center">Canal</th>
                                        <th></th>
                                        <tr>
                                            <td class="text-center"><?php echo number_format($itemIndicadores['pesos'], '2', ',', '.') ?></td>
                                            <td class="text-center"><?php echo number_format($itemIndicadores['cuotapesos'], '2', ',', '.') ?></td>
                                            <td class="text-center"><?php echo round($porcetaje); ?></td>
                                            <td class="text-center"><?php echo $itemIndicadores['NombreCanal'] ?></td>
                                            <?php if ($porcetaje > '99') { ?>
                                                <td>
                                                    <img src="images/bueno.png">
                                                </td>
                                            <?php } elseif ($porcetaje > '64' && $porcetaje < '95') { ?>
                                                <td>
                                                    <img src="images/regular.png">
                                                </td>                                   
                                            <?php } elseif ($porcetaje > '0' && $porcetaje < '64') { ?>
                                                <td>
                                                    <img src="images/malo.png">
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                        </tr>
                                    </table> 
                                   </div>
                                <?php endif; endforeach;
                        endforeach; ?>
         
                         </div>
                              
                    </div>
</div>