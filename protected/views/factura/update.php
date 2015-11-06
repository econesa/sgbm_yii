<?php
/* @var $this FacturaController */
/* @var $model Factura */

$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	$model->numero => array('view','id'=>$model->id),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Listar Facturas', 'url'=>array('index')),
	array('label'=>'Registrar Factura', 'url'=>array('create')),
	array('label'=>'Mostrar Factura', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Modificar Factura #<?php echo $model->numero; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
