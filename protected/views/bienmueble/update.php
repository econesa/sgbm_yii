<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com>*/
/* @var $this BienmuebleController */
/* @var $model Bienmueble */

$this->breadcrumbs=array(
	'Inventario de Bienes'=>array('index'),
	$model->codigo=>array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Inventario de Bienes', 'url'=>array('index')),
	array('label'=>'Incorporar Bienmueble', 'url'=>array('create')),
	array('label'=>'Mostrar Bien', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Bien #<?php echo $model->codigo; ?></h1>

<?php 
	echo $this->renderPartial('_form', array(
		'model'=>$model, 
		'clases'=>$clases,
		'tipos'=>$tipos,
		'factura'=>$factura,
		)
	); 
?>