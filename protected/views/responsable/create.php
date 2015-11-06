<?php
/* @var $this ResponsableController */
/* @var $model Responsable */

$this->breadcrumbs=array(
	'Responsables'=>array('index'),
	'Asignar',
);

$this->menu=array(
	array('label'=>'Listar Responsable', 'url'=>array('index')),
);
?>

<h1>Asignar Responsable</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'dps'=>$dps, 'status'=>$status, 'personas'=>$personas, 'acceso'=>$acceso)); ?>
