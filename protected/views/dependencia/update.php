<?php
/* @var $this DependenciaController */
/* @var $model Dependencia */

$this->breadcrumbs=array(
	'Dependencias'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Dependencias', 'url'=>array('index')),
	array('label'=>'Crear Dependencia', 'url'=>array('create')),
	//array('label'=>'View Dependencia', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Dependencia <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'generos'=>$generos,)); ?>