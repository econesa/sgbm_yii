<?php
/* @var $this ResponsableController */
/* @var $model Responsable */

$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Responsables', 'url'=>array('index')),
	array('label'=>'Responsable Nuevo', 'url'=>array('create')),
	array('label'=>'Mostrar Responsable', 'url'=>array('view', 'id'=>$model->id)),
);

if ($model->dependencia->genero_id==1) :
	echo '<h1>Modificar Responsable del '.$model->dependencia->descripcion.'</h1>';
else :
	echo '<h1>Modificar Responsable de la '.$model->dependencia->descripcion.'</h1>';
endif;

echo $this->renderPartial('_form', array('model'=>$model, 'status'=>$status, 'personas'=>$personas, 'acceso'=>$acceso)); 
?>
