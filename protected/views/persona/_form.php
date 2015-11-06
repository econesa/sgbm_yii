<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this PersonaController */
/* @var $pdata PersonaData */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persona-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($pdata); ?>

	<div class="row">
		<?php echo $form->labelEx($pdata,'cedula'); ?>
		<?php echo $form->textField($pdata,'cedula'); ?>
		<?php echo $form->error($pdata,'cedula'); ?>
	</div>

	<div class="row">
		<?php 
		echo $form->labelEx($pdata,'nombre'); 
		echo $form->textField($pdata,'nombre',array('size'=>60,'maxlength'=>128));
		echo $form->error($pdata,'nombre'); 
		?>
	</div>
	
	<div class="row">
		<?php
			echo $form->labelEx($pdata,'sexo_id');
			$list = Chtml::listData($genero, 'id', 'descripcion'); 
			echo $form->dropDownList($pdata,'sexo_id', $list, array('prompt'=>'Selecciona una'));
		?>
	</div>

	<div class="row">
	<?php
		echo $form->labelEx($pdata,'profesion_id');
		$list2 = Chtml::listData($profesiones, 'id', 'descripcion'); 
		echo $form->dropDownList($pdata,'profesion_id', $list2, array('prompt'=>'Selecciona una'));
	?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($pdata->isNewRecord ? 'Registrar' : 'Guardar', array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>