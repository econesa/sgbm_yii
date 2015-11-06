<?php
/* @var $this UsuarioController */
/* @var $model Usuario */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php
			echo $form->labelEx($model,'rol_id');
			$list = Chtml::listData($roles, 'id', 'descripcion'); 
			echo $form->dropDownList($model,'rol_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($model,'dependencia_id');
			$list = Chtml::listData($dps, 'id', 'descripcion'); 
			echo $form->dropDownList($model,'dependencia_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'salt'); ?>
		<?php echo $form->textField($model,'salt',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'salt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->