<?php
/* @var $this DependenciaController */
/* @var $model Dependencia */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dependencia-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cod'); ?>
		<?php echo $form->textField($model,'cod',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'cod'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'u_adm_id'); ?>
		<?php echo $form->textField($model,'u_adm_id'); ?>
		<?php echo $form->error($model,'u_adm_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc_corta'); ?>
		<?php echo $form->textField($model,'desc_corta',array('size'=>55,'maxlength'=>55)); ?>
		<?php echo $form->error($model,'desc_corta'); ?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'genero_id');
			$list = Chtml::listData($generos, 'id', 'descripcion'); 
			echo $form->dropDownList($model,'genero_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->