<?php
/* @author Elisa Conesa <econesa@gmail.com> */
/* @var $this BienmuebleController */
/* @var $model Bienmueble */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bienmueble-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos se&ntilde;alados con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord) : ?>
	<div class="row">
		<?php echo $form->labelEx($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('size'=>10,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'codigo'); ?>
	</div>
	
	<div class="row">
		<?php 
		$list = Chtml::listData($conceptos, 'id', 'descripcion'); 
		echo $form->labelEx($movimiento,'concepto_id'); 
		echo $form->dropDownList($movimiento,'concepto_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($movimiento,'concepto_id'); 
		?>
	</div>	

	<?php if ($acceso < 4) : ?>
	<div class="row">
		<?php 
		$list = Chtml::listData($dps, 'id', 'descripcion'); 
		echo $form->labelEx($movimiento,'dependencia_id'); 
		echo $form->dropDownList($movimiento,'dependencia_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($movimiento,'dependencia_id'); 
		?>
	</div>
	<?php endif; ?>	
	
	<?php endif; ?>	
	
	<div class="row">
		<?php 
		$list = Chtml::listData($clases, 'id', 'descripcion'); 
		echo $form->labelEx($model,'clasificacion_id'); 
		echo $form->dropDownList($model,'clasificacion_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($model,'clasificacion_id'); 
		?>
	</div>
	
	<div class="row">
		<?php 
		$list = Chtml::listData($tipos, 'id', 'descripcion'); 
		echo $form->labelEx($model,'tipo_id'); 
		echo $form->dropDownList($model,'tipo_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($model,'tipo_id'); 
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textArea($model,'descripcion',array('maxlength'=>500, 'cols'=>90, 'rows'=>5)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valor_unitario'); ?>
		<?php echo $form->textField($model,'valor_unitario'); ?>
		<?php echo $form->error($model,'valor_unitario'); ?>
	</div>

	<?php if ($model->isNewRecord) : ?>
	<fieldset>
	<legend>Factura</legend>
	<div class="row">
		<?php echo $form->labelEx($factura,'numero'); ?>
		<?php echo $form->textField($factura,'numero'); ?>
		<?php echo $form->error($factura,'numero'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($factura,'proveedor'); ?>
		<?php echo $form->textField($factura,'proveedor'); ?>
		<?php echo $form->error($factura,'proveedor'); ?>
	</div>
	</fieldset>

	<div class="row">
		<?php 
		echo $form->labelEx($model,'f_incorporacion');
		$this->widget('application.extensions.timepicker.EJuiDateTimePicker',
				array(
					'model'=> $model,
					'attribute' => 'f_incorporacion',
					'language' => 'es',
					'value' => $model->f_incorporacion,
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
			echo $form->error($model,'f_incorporacion');
		?>
	</div>
	<?php endif; ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'observaciones'); ?>
		<?php echo $form->textArea($model,'observaciones',array('maxlength'=>200, 'cols'=>90, 'rows'=>5)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Incorporar' : 'Guardar', array('class'=>'button green')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
