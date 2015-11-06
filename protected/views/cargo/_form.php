<?php
/* @var $this CargoController */
/* @var $model Cargo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cargo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_f'); ?>
		<?php echo $form->textField($model,'desc_f',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'desc_f'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar' ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->