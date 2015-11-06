<?php
/* @var $this CargoController */
/* @var $model Cargo */

$this->breadcrumbs=array(
	'Cargos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Cargos', 'url'=>array('index')),
	array('label'=>'Crear Cargo', 'url'=>array('create')),
	array('label'=>'Mostrar Cargo', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Cargo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>