<?php
/* @var $this MensajesController */
/* @var $model Mensajes //


  Yii::app()->clientScript->registerScript('search', "
  $('.search-button').click(function(){
  $('.search-form').toggle();
  return false;
  });
  $('.search-form form').submit(function(){
  $('#mensajes-grid').yiiGridView('update', {
  data: $(this).serialize()
  });
  return false;
  });
  ");
  ?>

  <div class="contentpanel">
  <div class="panel-heading">
  <?php

  $this->widget('zii.widgets.grid.CGridView', array(
  'id'=>'mensajes-grid',
  'dataProvider'=>$model->search(),
  'filter'=>$model,
  'columns'=>array(
  /*'IdMensaje',//
  'IdDestinatario',
  'NombreZonadeVentas',
  'IdRemitente',
  'remitente',
  'FechaMensaje',
  'HoraMensaje',



  /*array(
  'name' => 'NombreZonadeVentas',
  ),//
  'Mensaje',
  array(
  'name'=>'Estado',
  'value'=>'$data->estado->EstadoM',
  ),

  /*
  'CodAsesor',//

  array(
  'class'=>'CButtonColumn',
  'template'=>'',
  ),
  ),
  )); ?>


  </div>
  </div>
 * // Si se va a descomentar lo anterior Hay que borrar ese cierre de php 
 */
?>

<div class="contentpanel">
    <div class="panel-body" style="min-height: 1000px;">
        <div class="panel-heading">
            <div align="center">
                <div class="row">
                    <div class="col-md-3 col-md-offset-2 text-center">
                        <div class="form-group">
                            <label>Fecha Inicial</label>
                            <div aling="center">
                                <input style="height: 36px;" type="text" class="form-control fechareport" id="fechaini" value = "<?php echo date('Y-m-d') ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="form-group">
                            <label>Fecha Final</label>
                            <div>
                                <input style="height: 36px;" type="text" class="form-control fechareport" id='fechafin' value = "<?php echo date('Y-m-d') ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="form-group">
                            <label></label>
                            <div>
                                <input type="button" class="btnbuscar btn btn-primary" style="height: 25px; width: 100px;" value="Buscar" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="table-responsive" id="tablaerrores">
                <table class="table table-bordered" id="tbllogerror">
                    <thead>
                        <tr style="background-color: #8DB4E2;">
                            <th>
                                Id Destinatario
                            </th>
                            <th>
                                Id Remitente
                            </th>
                            <th>
                                Fecha Mensaje
                            </th>
                            <th>
                                Hora Mensaje
                            </th>
                            <th>
                                Mensaje
                            </th>
                            <th>
                                Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($errores as $item) {
                            ?>
                            <tr>
                                <td><?php echo $item['IdDestinatario']; ?></td>
                                <td><?php echo $item['IdRemitente']; ?></td>
                                <td><?php echo $item['FechaMensaje']; ?></td>
                                <td><?php echo $item['HoraMensaje']; ?></td>
                                <td><?php echo $item['Mensaje']; ?></td>
                                <td><?php echo $item['Estado']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>