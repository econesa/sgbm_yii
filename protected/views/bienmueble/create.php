<?php
/* Desarrollado por Elisa Conesa <econesa@gmail.com> */
/* @var $this BienmuebleController */
/* @var $model Bienmueble */

$this->breadcrumbs=array(
	'Inventario de Bienes'=>array('index'),
	'Incorporar',
);
?>

<h1>Incorporar Bienmueble</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 
	'movimiento'=>$movimiento, 
	'conceptos'=>$conceptos, 
	'clases'=>$clases, 
	'dps'=>$dps, 
	'tipos'=>$tipos,
	'factura'=>$factura,
	'acceso' => $acceso
	)); 
?>
