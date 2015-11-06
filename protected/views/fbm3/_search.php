<?php
/* @var $this Fbm3Controller */
/* @var $model Fbm3 */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php 
		echo $form->label($model,'id');
		echo $form->textField($model,'id'); 
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comprobante'); ?>
		<?php echo $form->textField($model,'comprobante',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dependencia_id'); ?>
		<?php echo $form->textField($model,'dependencia_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observador_id'); ?>
		<?php echo $form->textField($model,'observador_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'responsable_id'); ?>
		<?php echo $form->textField($model,'responsable_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cantidad'); ?>
		<?php echo $form->textField($model,'cantidad'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'valor_total'); ?>
		<?php echo $form->textField($model,'valor_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'observacones'); ?>
		<?php echo $form->textField($model,'observacones',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->