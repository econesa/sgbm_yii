<?php
/* @var $this DependenciaController */
/* @var $model Dependencia */

$this->breadcrumbs=array(
	'Dependencias'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Dependencias', 'url'=>array('index')),
);
?>

<h1>Crear Dependencia</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'generos'=>$generos)); ?>