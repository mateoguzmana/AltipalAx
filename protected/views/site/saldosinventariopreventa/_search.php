<?php
/* @var $this SaldosinventariopreventaController */
/* @var $model Saldosinventariopreventa */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Id'); ?>
		<?php echo $form->textField($model,'Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoSitio'); ?>
		<?php echo $form->textField($model,'CodigoSitio',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NombreSitio'); ?>
		<?php echo $form->textField($model,'NombreSitio',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoAlmacen'); ?>
		<?php echo $form->textField($model,'CodigoAlmacen',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoVariante'); ?>
		<?php echo $form->textField($model,'CodigoVariante',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoArticulo'); ?>
		<?php echo $form->textField($model,'CodigoArticulo',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoCaracteristica1'); ?>
		<?php echo $form->textField($model,'CodigoCaracteristica1',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoCaracteristica2'); ?>
		<?php echo $form->textField($model,'CodigoCaracteristica2',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoTipo'); ?>
		<?php echo $form->textField($model,'CodigoTipo',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Disponible'); ?>
		<?php echo $form->textField($model,'Disponible',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodigoUnidadMedida'); ?>
		<?php echo $form->textField($model,'CodigoUnidadMedida',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'NombreUnidadMedida'); ?>
		<?php echo $form->textField($model,'NombreUnidadMedida',array('size'=>25,'maxlength'=>25)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->