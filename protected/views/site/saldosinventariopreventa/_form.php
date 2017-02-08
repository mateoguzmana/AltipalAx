<?php
/* @var $this SaldosinventariopreventaController */
/* @var $model Saldosinventariopreventa */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'saldosinventariopreventa-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoSitio'); ?>
		<?php echo $form->textField($model,'CodigoSitio',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'CodigoSitio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NombreSitio'); ?>
		<?php echo $form->textField($model,'NombreSitio',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'NombreSitio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoAlmacen'); ?>
		<?php echo $form->textField($model,'CodigoAlmacen',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'CodigoAlmacen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoVariante'); ?>
		<?php echo $form->textField($model,'CodigoVariante',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'CodigoVariante'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoArticulo'); ?>
		<?php echo $form->textField($model,'CodigoArticulo',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'CodigoArticulo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoCaracteristica1'); ?>
		<?php echo $form->textField($model,'CodigoCaracteristica1',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'CodigoCaracteristica1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoCaracteristica2'); ?>
		<?php echo $form->textField($model,'CodigoCaracteristica2',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'CodigoCaracteristica2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoTipo'); ?>
		<?php echo $form->textField($model,'CodigoTipo',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'CodigoTipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Disponible'); ?>
		<?php echo $form->textField($model,'Disponible',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'Disponible'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'CodigoUnidadMedida'); ?>
		<?php echo $form->textField($model,'CodigoUnidadMedida',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'CodigoUnidadMedida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'NombreUnidadMedida'); ?>
		<?php echo $form->textField($model,'NombreUnidadMedida',array('size'=>25,'maxlength'=>25)); ?>
		<?php echo $form->error($model,'NombreUnidadMedida'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->