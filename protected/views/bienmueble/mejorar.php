<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */

$this->breadcrumbs=array(
	'Inventario de Bienes'=>array('index'),
	$model->codigo=>array('view','id'=>$model->id),
	'Otros Movimientos',
);

$this->menu=array(
	array('label'=>'Inventario de Bienes', 'url'=>array('index')),
	array('label'=>'Incorporar Bienmueble', 'url'=>array('create')),
	array('label'=>'Mostrar Bien', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<div class='form'>
<h1>Otros Movimiento del Bien #<?php echo $model->codigo; ?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bienmueble-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>

<?php if ($model->ult_mov->concepto_id<20) : ?>
	<div class="row">
		<?php 
		$list = Chtml::listData($conceptosD, 'id', 'descripcion'); 
		echo $form->labelEx($movimientoD,'concepto_id').'<b> por Desincorporaci&oacute;n</b> '; 
		echo $form->dropDownList($movimientoD,'concepto_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($movimientoD,'concepto_id'); 
		?>
	</div>
	<div class="row">
		<?php 
		$list = Chtml::listData($conceptosI, 'id', 'descripcion'); 
		echo $form->labelEx($movimientoI,'concepto_id').'<b> por Incorporaci&oacute;n</b> '; 
		//echo $form->dropDownList($movimientoI,'concepto_id', $list, array('prompt'=>'Selecciona una'));
		echo CHtml::dropDownList('BmMovimiento2[concepto_id]', 'concepto_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($movimientoI,'concepto_id'); 
		?>
	</div>
<?php else : ?>
	<div class="row">
		<?php 
		$list = Chtml::listData($conceptosI, 'id', 'descripcion'); 
		echo $form->labelEx($movimientoI,'concepto_id').'<b> por Incorporaci&oacute;n</b> '; 
		//echo $form->dropDownList($movimientoI,'concepto_id', $list, array('prompt'=>'Selecciona una'));
		echo CHtml::dropDownList('BmMovimiento2[concepto_id]', 'concepto_id', $list, array('prompt'=>'Selecciona una'));
		echo $form->error($movimientoI,'concepto_id'); 
		?>
	</div>
<?php endif ?>
<div class="row">
	<?php 
	echo $form->labelEx($model,'observaciones'); 
	echo $form->textArea($model,'observaciones',array('maxlength'=>200, 'cols'=>90, 'rows'=>5));
	echo $form->error($model,'observaciones'); 
	?>
</div>
<div class="row buttons">
	<?php echo CHtml::submitButton('Aceptar', array('class'=>'button green')); ?>
</div>
<?php $this->endWidget(); ?>
</div>