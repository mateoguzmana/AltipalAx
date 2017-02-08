<?php
/* @var $this MensajesController */
/* @var $model Mensajes */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'IdMensaje'); ?>
		<?php echo $form->textField($model,'IdMensaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IdDestinatario'); ?>
		<?php echo $form->textField($model,'IdDestinatario',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'IdRemitente'); ?>
		<?php echo $form->textField($model,'IdRemitente',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'FechaMensaje'); ?>
		<?php echo $form->textField($model,'FechaMensaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HoraMensaje'); ?>
		<?php echo $form->textField($model,'HoraMensaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Mensaje'); ?>
		<?php echo $form->textField($model,'Mensaje',array('size'=>60,'maxlength'=>600)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Estado'); ?>
		<?php echo $form->textField($model,'Estado',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'CodAsesor'); ?>
		<?php echo $form->textField($model,'CodAsesor',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->