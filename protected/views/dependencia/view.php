<?php
/* @var $this DependenciaController */
/* @var $model Dependencia */

$this->breadcrumbs=array(
	'Dependencias'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Dependencia', 'url'=>array('index')),
	array('label'=>'Create Dependencia', 'url'=>array('create')),
	array('label'=>'Update Dependencia', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Dependencia', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Dependencia', 'url'=>array('admin')),
);
?>

<h1>View Dependencia #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cod',
		'sede_id',
		'u_adm_id',
		'descripcion',
		'desc_corta',
		'genero_id',
	),
)); ?>
