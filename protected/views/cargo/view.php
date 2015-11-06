<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Cargos', 'url'=>array('index')),
	array('label'=>'Crear Cargo', 'url'=>array('create')),
	array('label'=>'Modificar Cargo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Cargo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro que desea eliminar este registro?')),
);
?>

<h1>Mostrar Cargo #<?php echo $model->cod; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cod',
		'descripcion',
		'desc_f',
	),
)); ?>
