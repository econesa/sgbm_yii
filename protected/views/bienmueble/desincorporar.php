<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */

$this->breadcrumbs = array(
	'Inventario de Bienes' => array('index'),
	$model->codigo=>array('view','id' => $model->id),
	'Desincoporar',
);

$this->menu = array(
	array('label'=>'Inventario de Bienes', 'url'=>array('index')),
	array('label'=>'Incorporar Bienmueble', 'url'=>array('create')),
	array('label'=>'Mostrar Bien', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Desincoporar Bien #<?php echo $model->codigo; ?></h1>

<div class="form">
	
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bienmueble-form',
	'enableClientValidation'=>true,
	'enableAjaxValidation'=>false,
)); ?>

<div class="row">
	<?php 
	$list = Chtml::listData($conceptos, 'id', 'descripcion'); 
	echo $form->labelEx($movimiento,'concepto_id'); 
	echo $form->dropDownList($movimiento,'concepto_id', $list, array('prompt'=>'Selecciona una'));
	echo $form->error($movimiento,'concepto_id');
	?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Aceptar', array('class'=>'button green')); ?>
</div>
<?php $this->endWidget(); ?>
</div>