<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */
/* @var $form CActiveForm */
?>

<div class="wide form">
<div class="searchbox">
<h4>B&uacute;squeda</h4>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<p>Indique el nro. ID:</p>
	<div class="row">
		<?php echo $form->label($model,'codigo'); ?>
		<?php echo $form->textField($model,'codigo',array('size'=>6,'maxlength'=>6)); ?>
	</div>

<p>o los filtros para realizar la búsqueda:</p>
	<div class="row">
	<?php
		echo $form->labelEx($model,'clasificacion_id');
		$list = Chtml::listData($vars['clases'], 'id', 'descripcion'); 
		echo $form->dropDownList($model,'clasificacion_id', $list, array('prompt'=>'CUALQUIERA'));
	?>
	</div>

	<div class="row">
	<?php
		echo $form->labelEx($model,'dependencia_id');
		$list = Chtml::listData($vars['dps'], 'id', 'descripcion'); 
		echo $form->dropDownList($model,'dependencia_id', $list, array('prompt'=>'CUALQUIERA'));
	?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'tipo_id');
			$list = Chtml::listData($vars['tipos'], 'id', 'descripcion'); 
			echo $form->dropDownList($model,'tipo_id', $list, array('prompt'=>'CUALQUIERA'));
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'factura_nro'); ?>
		<?php echo $form->textField($model,'factura_nro'); ?>
	</div>

	<div class="row">
		<?php
			echo $form->labelEx($model,'status_id');
			$list7 = Chtml::listData($vars['status'], 'id', 'descripcion'); 
			echo $form->dropDownList($model,'status_id', $list7, array('prompt'=>'CUALQUIERA'));
		?>
	</div>

	<div class="row">
	<?php
	/*
		echo $form->labelEx($model,'anho_id');
		$list8 = Chtml::listData($vars['anhos'], 'id', 'descripcion'); 
		echo $form->dropDownList($model,'anho_id', $list8, array('prompt'=>'CUALQUIERA'));
	*/
	?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar', array('class'=>'button blue')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>

</div><!-- search-form -->
