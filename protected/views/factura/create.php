<?php
/* @var $this FacturaController */
/* @var $model Factura */

$this->breadcrumbs=array(
	'Facturas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Factura', 'url'=>array('index')),
	array('label'=>'Manage Factura', 'url'=>array('admin')),
);
?>

<h1>Create Factura</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>