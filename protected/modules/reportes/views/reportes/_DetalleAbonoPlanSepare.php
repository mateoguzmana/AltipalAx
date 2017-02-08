<?php require 'conexionPDO/ventasPV.php'; ?>
<div class="panel-heading" style="width:1em;margin-left:9em;">
  <div class="portlet box blue">
      <div class="portlet-title">
          <div class="caption"><i class="icon-reorder"></i></div>
          Detalle Abonos Plan Separe
      </div>
      <div class="portlet-body form">
          <div class="row-fluid">
              
          <div class="table-responsive">            
              <div class="portlet box green">
                  <div class="portlet-title">
                      <div class="caption"><i class="icon-reorder"></i></div>
                      Abonos Plan Separe
                  </div>
                  <div class="portlet-body form">
          <table class="table mb30">            
            <thead>
              <tr style="font-size:12px;">
                <th class="text-center">Forma Pago</th>
                <th class="text-center">Tipo Transacci&oacuten</th>
                <th class="text-center">Numero Transacci&oacuten</th>
                <th class="text-center">Valor Abono</th>
                <th class="text-center">Fecha</th>  
                <th class="text-center">Hora</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $statement = PlanSepareController::detalleAbonos($_POST['Id']);
                foreach ($statement as $item) {
	     ?>				
					
                    <tr>
                        <td class="text-center"><?php echo $item['FormaPago'];?></td>
                        <td class="text-center"><?php echo $item['TipoTransaccion'];?></td>
                        <td class="text-center"><?php echo $item['NumeroTransaccion'];?></td>
                        <td class="text-center"><?php echo $item['ValorAbono'];?></td>
                        <td class="text-center" nowrap="nowrap"><?php echo $item['Fecha'];?></td>
                        <td class="text-center"><?php echo $item['Hora'];?></td>
                                              
                   </tr>
                    <?php                
                }                          
                ?>
            </tbody>
          </table>
                  </div>
          </div><!-- table-responsive -->
      </div>
          </div>
      </div> 
  </div>
</div>