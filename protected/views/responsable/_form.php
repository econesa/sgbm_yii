<?php
/* @var $this ResponsableController */
/* @var $model Responsable */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'responsable-form',
	'enableClientValidation'=>false,
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord && $acceso) : ?>
	<div class="row">
		<?php
		echo $form->labelEx($model,'dependencia_id');
		$list = Chtml::listData($dps, 'id', 'descripcion'); 
		echo $form->dropDownList($model,'dependencia_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>
	<?php endif; ?>

	<div class="row">
		<?php
		echo $form->labelEx($model,'persona_id');
		$list = Chtml::listData($personas, 'id', 'descripcion'); 
		echo $form->dropDownList($model,'persona_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>

	
	<div class="row">
		<?php
		echo $form->labelEx($model,'status_id');
		$list = Chtml::listData($status, 'id', 'descripcion'); 
		echo $form->dropDownList($model,'status_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Asignar' : 'Guardar', array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
