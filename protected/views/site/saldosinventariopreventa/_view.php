<?php
/* @var $this SaldosinventariopreventaController */
/* @var $data Saldosinventariopreventa */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoSitio')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoSitio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NombreSitio')); ?>:</b>
	<?php echo CHtml::encode($data->NombreSitio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoAlmacen')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoAlmacen); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoVariante')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoVariante); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoArticulo')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoArticulo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoCaracteristica1')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoCaracteristica1); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoCaracteristica2')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoCaracteristica2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoTipo')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoTipo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Disponible')); ?>:</b>
	<?php echo CHtml::encode($data->Disponible); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('CodigoUnidadMedida')); ?>:</b>
	<?php echo CHtml::encode($data->CodigoUnidadMedida); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('NombreUnidadMedida')); ?>:</b>
	<?php echo CHtml::encode($data->NombreUnidadMedida); ?>
	<br />

	*/ ?>

</div>