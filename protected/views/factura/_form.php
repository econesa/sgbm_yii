<?php
/* @var $this FacturaController */
/* @var $model Factura */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'factura-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'numero'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'proveedor'); ?>
		<?php echo $form->textField($model,'proveedor',array('size'=>60,'maxlength'=>120)); ?>
		<?php echo $form->error($model,'proveedor'); ?>
	</div>

	<div class="row">
		<?php 
		echo $form->labelEx($model,'fecha');
		$this->widget('application.extensions.timepicker.EJuiDateTimePicker',
				array(
					'model'=> $model,
					'attribute' => 'fecha',
					'language' => 'es',
					'value' => $model->fecha,
					'options' => array(//yy-mm-dd 
						'dateFormat' => 'yy-mm-dd',
						'timeFormat' => 'hh:mm',
						'constrainInput' => 'false',
						'changeYear' => 'true',
						'duration' => 'fast',
						'showAnim' => 'slide',
						'timeText' => 'Hora',
						'hourText' => 'Horas',
						'minuteText' => 'Min.',		
					),
				)
			);
			echo $form->error($model,'fecha');
			?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'button blue')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
