<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cargo-persona-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php
		echo $form->labelEx($model,'cargo_id');
		$list = Chtml::listData($cargos, 'id', 'descripcion');
		echo $form->dropDownList($model,'cargo_id', $list, array('prompt'=>'Selecciona una'));		
	?>
	</div>
	
	<div class="row">
	<?php
		echo $form->labelEx($model,'dependencia_id');
		$list = Chtml::listData($dps, 'id', 'descripcion');
		echo $form->dropDownList($model,'dependencia_id', $list, array('prompt'=>'Selecciona una'));		
	?>
	</div>

	<?php if (!$model->isNewRecord) : ?>
	<div class="row">
	<?php
		echo $form->labelEx($model,'status_id');
		$list = Chtml::listData($status, 'id', 'descripcion');
		echo $form->dropDownList($model,'status_id', $list, array('prompt'=>'Selecciona una'));		
	?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Guardar', array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
